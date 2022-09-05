<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WarrantyProduct;

class WarrantyProductController extends Controller
{

    public function index()
    {
        return WarrantyProduct::all();
    }

    public function store(Request $request){
        $product = new WarrantyProduct();
        $product->fill($request->all());
        $product->saveOrFail();
        return $product;
    }

    public function update(Request $request, $id){
        $product = WarrantyProduct::find($id);
        $product->fill($request->all());
        $product->saveOrFail();
        return $product;
    }

}
