<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Boleto;

class BoletoController extends Controller
{
    public function store(Request $request, $id){

        $name = $request->file('file')->getRealPath();
        $upload = UploadCloudController::upload($name);

        $boleto = new Boleto();
        $boleto->url = $upload['secure_url'];
        $boleto->public_id = $upload['public_id'];
        $boleto->sale_order_id = $id;
        $boleto->saveOrFail();

        return $boleto;
    }

    public function destroy($id)
    {
        $boleto = Boleto::find($id);
        $boleto->delete();
        return true;
    }
}
