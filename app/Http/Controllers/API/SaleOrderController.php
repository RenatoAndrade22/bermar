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
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class SaleOrderController extends Controller
{
    public function store(Request $request)
    {

        $table_price = PriceTable::query()->with('prices')->where('id', $request->get('table_price_id'))->first();

        $deliveryDate = null;
/*
        $data_sale = array();
        $data_sale['cliente_id'] = $request->get('enterprise_id');
        $data_sale['vendedor_id'] = Auth::user()->id;
*/
        if($request->has('delivery_date') && $request->get('delivery_date')){
            $date = Carbon::createFromFormat('d/m/Y', $request->get('delivery_date'));
            $deliveryDate = $date->toDateString();
        }

        $sale = new SaleOrder();
        $sale->fill($request->all());
        $sale->delivery_date = $deliveryDate;
        $sale->user_id = $request->get('user_id');
        $sale->status = $request->get('status');
        $sale->status_payment = 1;
        $sale->status_delivery = 1;
        $sale->enterprise_id = $request->get('enterprise_id');
        $sale->saveOrFail();

        foreach ($request->get('products') as $p) {

            $price = Price::query()
                        ->where('product_id', $p['product_id'])
                        ->where('price_table_id', $table_price->id)
                        ->first();

            $item = new SaleOrderItems();
            $item->sale_order_id = $sale->id;
            $item->product_id = $p['product_id'];
            $item->quantity = $p['quantity'];

            $item->discount_percentage = $p['discount'];
            $item->total = $p['total_discount'];

            $item->price = $price->price;
            $item->saveOrFail();
        }

        //ExternalApiController::saveSaleAPI();
        //$externalController = new ExternalApiController();
        //$externalController->saveSaleAPI();

        return $sale;
    
    }


    public function index()
    {
        $saleOrders = SaleOrder::query()
            ->where('user_id', Auth::user()->id)->get();
        return $saleOrders;
    }

    public function myShopping(){

        $saleOrders = SaleOrder::query()
            ->with('boletos')
            ->where('enterprise_id', Auth::user()->enterprise_id)
            ->join('enterprises as e1', 'sale_orders.enterprise_id', '=', 'e1.id')
            ->join('enterprises as e2', 'e1.enterprise_id', '=', 'e2.id')
            ->orderByDesc('id')->get(['sale_orders.*', 'e1.name as enterprise_name', 'e2.name as creator_name']);
        return $saleOrders;
    }

    public function allSales()
    {
        $saleOrders = SaleOrder::query()->with(['boletos', 'paymentMethod'])
        ->join('enterprises as e1', 'sale_orders.enterprise_id', '=', 'e1.id')
        ->join('enterprises as e2', 'e1.enterprise_id', '=', 'e2.id')
        ->orderByDesc('id')->get(['sale_orders.*', 'e1.name as enterprise_name', 'e2.name as creator_name']);
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
