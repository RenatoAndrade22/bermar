<?php

namespace App\Http\Controllers;

use App\Jobs\PDF2Text;
use App\Models\Action;
use App\Models\Investiment;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;

class investmentController extends Controller
{
    protected $final_c = false;

    public function index()
    {
        $investments = Action::query()->with('investments')->get();

        $investments = collect($investments)->map(function ($i){
            $buy = collect($i['investments'])->where('cv', 'C')->sum('amount');
            $sale = collect($i['investments'])->where('cv', 'V')->sum('amount');
            return [
                'id' => $i['id'],
                'quantidade' => $buy - $sale,
                'ações' => $i['name'],
            ];
        });

        return $investments;
    }

    public function pdfToList(Request $request)
    {
        $file = $request->file;

        $request->validate([
            'file' => 'required|mimes:pdf',
        ]);

        $fileName = $file->getClientOriginalName();

        $pdfParser = new Parser();
        $pdf = $pdfParser->parseFile($file->path());
        $content = $pdf->getText();
        $clear = str_replace("\t", '', $content);
        $result = explode("\n", $clear);


        $result_filter = collect($result)->filter(function ($item, $index){
            $i = true;

            if($index < 9){
                return false;
            }

            if ($item == 'NOTA DE NEGOCIAÇÃO'){
                $this->final_c = true;
            }

            if ($this->final_c){
                return false;
            }

            return $i;
        })->chunk(6);

        $result_correct = $result_filter->map(function ($item, $index) use ($result_filter){
            $keys = ['cv', 'mercadoria', 'vencimento', 'preco', 'tipo', 'valor'];
            $combine = collect($keys)->combine($item);

            return[
                'index' => $index,
                'cv' => substr($combine['cv'], 0, 1),
                'mercadoria' => substr($combine['cv'], 1),
                'vencimento' => $combine['mercadoria'],
                'quantidade' => substr($combine['vencimento'], 0, 1),
                'preco' => substr($combine['vencimento'], 1),
                'tipo' => $combine['preco'],
                'valor' => $combine['tipo'],
                'dc' => substr($combine['valor'], 0, 1),
                'taxa' => substr($combine['valor'], 1),
            ];

        });

        return $result_correct;

    }

    public function store(Request $request)
    {
        $actions = Action::all();

        foreach ($request->all() as $invest){

            $action= collect($actions)
                ->where('name', str_replace(' ', '', $invest['mercadoria']))
                ->first();

            if (!$action){
                $action = new Action();
                $action->name = str_replace(' ', '', $invest['mercadoria']);
                $action->save();

                $actions = collect($actions)->push($action);
            }

            $investiments = new Investiment();
            $investiments->action_id = $action->id;
            $investiments->cv = $invest['cv'];
            $investiments->due_date = $invest['vencimento'];
            $investiments->amount = (int)$invest['quantidade'];
            $investiments->price = $invest['preco'];
            $investiments->type = $invest['tipo'];
            $investiments->value = (Float)$invest['valor'];
            $investiments->rate = (Float)$invest['taxa'];
            $investiments->save();
        }

        return true;
    }

    public function show($id)
    {
        $investments = Action::query()->with('investments')->where('id', $id)->first();

            $buy = collect($investments->investments)->where('cv', 'C')->sum('amount');
            $sale = collect($investments->investments)->where('cv', 'V')->sum('amount');

            return [
                'id' => $investments->id,
                'name' => $investments->name,
                'amount' => $buy - $sale,
                'buy' => $buy,
                'sale' => $sale,
            ];
    }
}
