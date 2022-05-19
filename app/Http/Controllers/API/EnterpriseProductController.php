<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\EnterpriseProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnterpriseProductController extends Controller
{

    public function index(){
        $products = EnterpriseProduct::query()
            ->where('enterprise_id', Auth::user()->enterprise_id)
            ->get();

        $products = collect($products)->map(function($item){
            $item['products']['status'] = $item['status'];
            $item['products']['stock'] = $item['stock'];
            return $item['products'];
        });

        return $products;
    }

    public function store(Request $request){

        $ent_product = EnterpriseProduct::query()
            ->where('enterprise_id', Auth::user()->enterprise_id)
            ->where('product_id', $request->get('product_id'))
            ->firstOrNew();
        
        $ent_product->enterprise_id = Auth::user()->enterprise_id;
        $ent_product->product_id = $request->get('product_id');

        $ent_product->stock =  $ent_product->stock + (int)$request->get('stock');
        $ent_product->saveOrFail();
        return $ent_product;
    }

    public function update(Request $request, $id)
    {
        $product = EnterpriseProduct::query()
            ->where('enterprise_id', Auth::user()->enterprise_id)
            ->where('product_id', $request->get('product_id'))
            ->first();

        $product->status = $request->get('status');
        $product->saveOrFail();
        return $product;
    }

}
