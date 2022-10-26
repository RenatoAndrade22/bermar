<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SaleOrder;
use App\Models\Product;
use App\Models\SaleOrderItems;
use App\Models\Enterprise;
use App\Models\PriceTable;
use App\Models\Price;
use Illuminate\Support\Facades\Auth;

class SaleOrderController extends Controller
{
    public function store(Request $request)
    {

        // encontra a tabela de preços pelo Estado do cliente.
        $enterprise = Enterprise::query()->where('id', $request->get('enterprise_id'))->first();
        $table_price = PriceTable::query()->with('prices')->where('name', $enterprise->address['state'])->first();

        $sale = new SaleOrder();
        $sale->fill($request->all());
        $sale->user_id = $request->get('user_id');
        $sale->status = 1;
        $sale->status_payment = 1;
        $sale->status_delivery = 1;
        $sale->enterprise_id = $request->get('enterprise_id');
        $sale->saveOrFail();

        foreach ($request->get('products') as $p) {

            $price = Price::query()
                        ->where('product_id', $p['id'])
                        ->where('price_table_id', $table_price->id)
                        ->first();

            $item = new SaleOrderItems();
            $item->sale_order_id = $sale->id;
            $item->product_id = $p['id'];
            $item->quantity = $p['quantity'];
            $item->price = $price->price;
            $item->saveOrFail();
        }

        return $sale;
        
    }

    public function index()
    {
        $saleOrders = SaleOrder::with(['enterprise', 'user', 'saleOrderItems'])
            ->where('user_id', Auth::user()->id)->get();
        return $saleOrders;
    }

    public function getSaleOrderByUser()
    {
        return SaleOrder::with(['user', 'saleOrderItems'])
            ->where('enterprise_id', Auth::user()->enterprise_id)->get();
    }

}
