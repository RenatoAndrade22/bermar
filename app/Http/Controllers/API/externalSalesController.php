<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\externalSaleRequest;
use App\Services\ExternalSales\GetExternalSalesService;
use App\Models\externalSales;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class externalSalesController extends Controller
{
    public function index(Request $request, GetExternalSalesService $service)
    {
        return $service->process(Auth::user()->id, $request->all());
    }

  

    public function store(externalSaleRequest $request)
    {
        $dataSale = $request->all();

        // validando o valor da venda
        $value = $dataSale['value'];

        $value = str_replace(',', '.', $value);

        $value = number_format((float)$value, 2, '.', '');
         
        // upload arquivo
        $file = $request->file('file')->getRealPath();
        $upload = UploadCloudController::upload($file);

        // salvar a venda
        $sale = new externalSales();    
        $sale->date_sale      = Carbon::createFromFormat('d/m/Y', $dataSale['date_sale'])->format('Y-m-d');
        $sale->product_id     = $dataSale['product_id'];
        $sale->value          = $value;
        $sale->nfe_number     = $dataSale['nfe_number'];
        $sale->nfe_url        = $upload['secure_url'];
        $sale->nfe_public_id  = $upload['public_id'];
        $sale->product_serial = $dataSale['product_serial'];
        $sale->user_id        = Auth::user()->id;
        $sale->enterprise_id  = Auth::user()->enterprise_id;
        $sale->saveOrFail();

        return DB::select(
            '
                SELECT 
                    pro.name as product_name,
                    es.id,
                    es.date_sale,
                    es.value,
                    es.nfe_number,
                    es.nfe_url,
                    es.product_serial
                FROM external_sales es
                    inner join products pro
                    on pro.id = es.product_id
                WHERE es.id = :id
    
            ', ['id' => $sale->id]);
    }
}
