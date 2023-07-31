<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Price;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function allPricesByTable($id)
    {
        $prices = Price::query()->where('price_table_id', $id)->get();

        $prices = collect($prices)->map(function($p){
            return [
                'name_product' => $p['name_product'],
                'product_id' => $p['product_id'],
                'price' => $p['price']
            ];
        });

        return $prices;
    }
}
