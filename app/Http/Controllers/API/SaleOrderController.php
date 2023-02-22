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
        $table_price = PriceTable::query()->with('prices')->where('name', $enterprise->address[0]['state'])->first();

        $sale = new SaleOrder();
        $sale->fill($request->all());
        $sale->user_id = $request->get('user_id');
        $sale->status = $request->get('status');
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

            $item->discount_percentage = $p['discount'];
            $item->total = $p['total_discount'];

            $item->price = $price->price;
            $item->saveOrFail();
        }

        return $sale;
        
    }

    public function index()
    {
        $enterprises = Enterprise::select('id')->where('enterprise_id', Auth::user()->enterprise_id)->get();

        $enterprises = collect($enterprises)->map(function ($e) {
            return $e['id'];
        });

        $saleOrders = SaleOrder::query()
            ->whereIn('enterprise_id', $enterprises)->get();
        return $saleOrders;
    }

    public function myShopping(){

        $saleOrders = SaleOrder::query()
            ->with('boletos')
            ->where('enterprise_id', Auth::user()->enterprise_id)->orderByDesc('id')->get();
        return $saleOrders;
    }

    public function allSales()
    {
        $saleOrders = SaleOrder::query()->with('boletos')->orderByDesc('id')->get();
        return $saleOrders;
    }

    public function getSaleOrderByUser()
    {
        return SaleOrder::with(['user', 'saleOrderItems'])
            ->where('enterprise_id', Auth::user()->enterprise_id)->get();
    }

    public function getTotalSales()
    {
        $currentMonth = date('m');

        $saleOrders = SaleOrder::query()
            ->whereRaw('MONTH(created_at) = ?',[$currentMonth])
            ->where('user_id', Auth::user()->id)->get();

        $financial_total = $this->getPriceSale($saleOrders);

        return [
            'total_sales' => count($saleOrders),
            'financial_total' => $financial_total
        ];
    }

    public function getPriceSale($saleOrders){

        $price = 0;

        foreach($saleOrders as $sale){
            // dd($sale['saleOrderItems']);
            foreach($sale['saleOrderItems'] as $items){
                $price = $items['price'] * $items['quantity'];
            }
        }
        return $price;
    }

    public function update(Request $request, $id)
    {
        $sale = SaleOrder::find($id);
        $sale->fill($request->all());
        $sale->saveOrFail();
        return $sale;
    }

}
