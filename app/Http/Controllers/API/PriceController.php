<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Price;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function allPricesByTable(Request $request)
    {
        $prices = Price::query()
            ->whereIn('price_table_id', $request->all())
            ->get();

        $prices = collect($prices)->map(function($p){
            return [
                'name_product' => $p['name_product'],
                'product_id' => $p['product_id'],
                'price' => $p['price']
            ];
        });

        return $prices;
    }

    public function validateTables(Request $request)
    {
        $prices = Price::query()
                    ->whereIn('price_table_id', $request->all())
                    ->select('product_id') // Selecionar os campos relevantes para a verificação de duplicatas
                    ->groupBy('product_id') // Agrupar pelo valor
                    ->havingRaw('COUNT(*) > 1') // Ter mais de uma ocorrência significa duplicata
                    ->get();
                
        return $prices;

    }
}
