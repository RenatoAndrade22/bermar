<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SaleOrder;
use App\Models\Product;
use App\Models\SaleOrderItems;
use App\Models\Enterprise;
use App\Models\PaymentMethod;
use App\Models\PaymentTerm;
use App\Models\PriceTable;
use App\Models\Price;
use App\Models\Carrier;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth; 

class SaleOrderController extends Controller
{
    
    public function approveSale(Request $request, $id)
    {
        if($request->get('status') == 1)
        {

            $sale_items = DB::select("
                SELECT 
                    p.integration_code AS product_id,
                    sale_items.discount_percentage,
                    sale_items.quantity,
                    price_table.code_integration AS table_id,
                    sale_items.total / sale_items.quantity AS price_unitary
                FROM sale_order_items sale_items
                    JOIN products p
                        ON p.id = sale_items.product_id
                    LEFT JOIN price_tables price_table
                        ON price_table.id = sale_items.price_table_id
                WHERE 
                    sale_items.sale_order_id =".$id.""
            );

            $sale = DB::select(
                "
                SELECT 
                    method.code_integration AS method_id,
                    ent.code_integration AS client_id,
                    sale.shipping_type,
                    term.code_integration AS term_id,
                    carrier.code_integration AS carrier_id,
                    carrier_dis.code_integration AS carrier_dis_id,
                    sale.shipping_type_redispatch,
                    sale.observation,
                    sale.delivery_date
                FROM sale_orders sale
                    JOIN payment_methods method
                        ON method.id = sale.payment_method_id
                    JOIN enterprises ent
                        ON ent.id = sale.enterprise_id
                    LEFT JOIN payment_terms term
                        ON term.id = sale.payment_term_id
                    LEFT JOIN carriers carrier
                        ON carrier.id = sale.carrier_id
                    LEFT JOIN carriers carrier_dis
                        ON carrier.id = sale.carrier_id_redispatch      
                WHERE
                    sale.id = ".$id."
                "
            );

            $externalApiController = new ExternalApiController();

            foreach ($sale_items as $item) {
                $externalApiController->setProduct($item->product_id, $item->discount_percentage, $item->quantity, $item->price_unitary);
            }
            
            $externalApiController->setClient($sale[0]->client_id);
            $externalApiController->setTypeTransport($sale[0]->shipping_type);
            $externalApiController->setReceiptForm($sale[0]->method_id);
            $externalApiController->setCarrier($sale[0]->carrier_id);
            $externalApiController->setCarrierRedispatch($sale[0]->carrier_dis_id, $sale[0]->shipping_type_redispatch);
            $externalApiController->setPaymentTerm($sale[0]->term_id);

            $externalApiController->setTablePrice($sale_items[0]->table_id);
            $externalApiController->setObs($sale[0]->observation);
            $externalApiController->setDeliveryDate($sale[0]->delivery_date);

            $external = $externalApiController->saveSaleAPI();
            
            if(isset($external['pedido_de_venda']['id_pedido_venda'])){
                $sale_order = SaleOrder::find($id);
                $sale_order->code_integration = $external['pedido_de_venda']['id_pedido_venda'];
                $sale_order->status = 1;
                $sale_order->saveOrFail();

                return true;
            }

            return 'error';

        }

        
    }

    public function saleAllInfo($id)
    {
        
        
        $saleOrder = DB::select("
            SELECT 
            ep.name AS company_name,
            ep.id AS company,
            sale.phone,
            sale.shipping_type AS frete,
            sale.payment_method_id AS payment_method,
            sale.observation,
            sale.delivery_date,
            sale.payment_term_id AS payment_term,
            cr.code_integration AS carrier,
            cr_d.code_integration AS carrier_redispatch,
            sale.phone_redispatch,
            sale.shipping_type_redispatch AS frete_redispatch,
            sale.value_NF AS value_nf,
            sale.volume

            FROM sale_orders sale
                JOIN enterprises ep
                    ON ep.id = sale.enterprise_id	
                LEFT JOIN carriers cr
                	  ON cr.id = sale.carrier_id
                LEFT JOIN carriers cr_d
                	  ON cr_d.id = sale.carrier_id_redispatch
            WHERE sale.id = ".$id."
        ");

        

        $products = DB::select(
            "
                SELECT 
                item.discount_percentage AS discount,
                p.name as name_product,
                item.price,
                item.product_id,
                item.quantity,
                item.total AS total_discount,
                item.price_table_id,
                pt.name AS name_table,
                (item.total / (1 - (item.discount_percentage / 100))) as total
                FROM sale_order_items item
                    JOIN products p
                        ON p.id = item.product_id
                    JOIN price_tables pt
                        ON pt.id = item.price_table_id
                WHERE item.sale_order_id = ".$id."
            "
        );

        $tables = [];

        foreach($products as $p){
            $tables[] = [
                'name' => $p->name_table,
                'id' => $p->price_table_id
            ];
        }

        if(isset($saleOrder[0])){

            return [
                'company_name' => $saleOrder[0]->company_name,
                'company' => $saleOrder[0]->company,
                'phone' => $saleOrder[0]->phone,
                'frete' => $saleOrder[0]->frete,
                'payment_method' => $saleOrder[0]->payment_method,

                'tables' => array_unique($tables, SORT_REGULAR),
                'products' => $products,

                'observation' => $saleOrder[0]->observation,
                'delivery_date' => $saleOrder[0]->delivery_date,
                'payment_term' => $saleOrder[0]->payment_term,
                'carrier' => $saleOrder[0]->carrier,
                'carrier_redispatch' => $saleOrder[0]->carrier_redispatch,
                'phone_redispatch' => $saleOrder[0]->phone_redispatch,
                'frete_redispatch' => $saleOrder[0]->frete_redispatch,
                'value_nf' => $saleOrder[0]->value_nf,
                'volume' => $saleOrder[0]->volume,
            ];
        }

        return [];
        
    }

    public function store(Request $request)
    {

        $deliveryDate = null;

        if($request->has('delivery_date') && $request->get('delivery_date')){
            $date = Carbon::createFromFormat('d/m/Y', $request->get('delivery_date'));
            $deliveryDate = $date->toDateString();
        }
        
        $sale = SaleOrder::query()->where('id', $request->get('sale_edit_id'))->firstOrNew();
        $sale->fill($request->all());
        $sale->delivery_date = $deliveryDate;
        $sale->user_id = Auth::user()->id;
        $sale->status = $request->get('status');
        $sale->status_payment = 1;
        $sale->status_delivery = 1;
        $sale->enterprise_id = $request->get('enterprise_id');

        if($request->get('value_NF')){
            $value_NF = str_replace(',', '.', $request->get('value_NF'));
            $sale->value_NF = $value_NF;
        }

        if($request->get('volume')){
            $volume = str_replace(',', '.', $request->get('volume'));
            $sale->volume = $volume;
        }

        if($request->get('carrier')){
            $carrier = Carrier::query()->where('code_integration', $request->get('carrier'))->first();
            $sale->carrier_id = $carrier->id;
        }

        if($request->get('carrier_redispatch')){
            $carrier_redispatch = Carrier::query()->where('code_integration', $request->get('carrier_redispatch'))->first();
            $sale->carrier_id_redispatch = $carrier_redispatch->id;
        }
        
        $sale->phone_redispatch = $request->get('phone_redispatch');
        $sale->shipping_type_redispatch = $request->get('shipping_type_redispatch');

        $PaymentTerm = PaymentTerm::query()->where('id', $request->get('payment_term'))->first();
        $sale->payment_term_id = $PaymentTerm->id;

        $sale->saveOrFail();

        SaleOrderItems::where('sale_order_id', $request->get('sale_edit_id'))->delete();

        foreach ($request->get('products') as $p) {

            $price = Price::query()
                        ->where('product_id', $p['product_id'])
                        ->where('price_table_id', $p['price_table_id'])
                        ->first();

            //$externalApiController->setProduct($price->product_id, $p['discount'], $p['quantity'], $p['total_discount']);
                   
            $item = new SaleOrderItems();
            $item->sale_order_id = $sale->id;
            $item->product_id = $p['product_id'];
            $item->quantity = $p['quantity'];
            $item->price_table_id = $p['price_table_id'];

            $item->discount_percentage = $p['discount'];
            $item->total = $p['total_discount'];

            $item->price = $price->price;
            $item->saveOrFail();
        }

        /*

        $payment_method = PaymentMethod::find($request->get('payment_method_id'));
        
        $enterprise = Enterprise::find($request->get('enterprise_id'));

        $externalApiController->setClient($enterprise->code_integration);
        $externalApiController->setTypeTransport($request->get('shipping_type'));
        $externalApiController->setReceiptForm($payment_method->code_integration);
        $externalApiController->setCarrier($request->get('carrier'));
        $externalApiController->setCarrierRedispatch($request->get('carrier_redispatch'), $request->get('shipping_type_redispatch'));
        $externalApiController->setPaymentTerm($request->get('payment_term'));
        $externalApiController->setTablePrice($table_price->code_integration);
        $externalApiController->setObs($request->get('observation'));
        $externalApiController->setDeliveryDate($request->get('delivery_date'));

       // $table_price

        $external = $externalApiController->saveSaleAPI();

        $sale->code_integration = $external['pedido_de_venda']['id_pedido_venda'];

        */

        $sale->saveOrFail();

        return true;
    
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
        ->orderByDesc('id')
        ->get();
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
