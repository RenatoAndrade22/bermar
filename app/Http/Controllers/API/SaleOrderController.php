<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SaleOrder;
use App\Models\Product;
use App\Models\SaleOrderItems;

class SaleOrderController extends Controller
{
    public function store(Request $request)
    {
        $sale = new SaleOrder();
        $sale->fill($request->all());
        $sale->user_id = $request->get('user_id');
        $sale->status = 1;
        $sale->status_payment = 1;
        $sale->status_delivery = 1;
        $sale->enterprise_id = $request->get('enterprise_id');
        $sale->saveOrFail();

        foreach ($request->get('products') as $p) {
            $product = Product::find($p['id']);

            $item = new SaleOrderItems();
            $item->sale_order_id = $sale->id;
            $item->product_id = $p['id'];
            $item->quantity = $p['qnt'];
            $item->price = $product->price;
            $item->saveOrFail();
        }
        return $sale;
    }
}
