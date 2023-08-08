<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\PriceTable;
use App\Models\Price;
use Illuminate\Support\Facades\Auth;

class PriceTableController extends Controller
{
    public function index()
    {
        return PriceTable::query()
                ->join('table_seller', 'table_seller.price_table_id', '=', 'price_tables.id')
                ->where('table_seller.user_id', Auth::user()->id)
                ->select('price_tables.id', 'price_tables.name')
                ->get();
    }

    public function store(Request $request)
    {
        $table = PriceTable::query()->where('name', $request->name)->firstOrNew();
        $table->name = $request->name;
        $table->saveOrFail();

        $this->storeProducts($table->id, $request->products);

        return $table;
    }

    public function storeProducts($table_id, $products)
    {
        foreach($products as $product){

            $product['price'] = str_replace(".","", $product['price']);
            $product['price'] = str_replace(",",".", $product['price']);

            $price = Price::query()->where('price_table_id', $table_id)->where('product_id', $product['id'])->firstOrNew();
            $price->price_table_id = $table_id;
            $price->product_id     = $product['id'];
            $price->price          = $product['price'];
            $price->saveOrFail();
        }
    }

    public function update()
    {

    }

    public function destroy($id)
    {
        $products = Price::query()->where('price_table_id', $id)->delete();

        $table = PriceTable::find($id);
        $table->delete();

        return $table;
    }
}
