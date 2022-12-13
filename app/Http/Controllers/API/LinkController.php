<?php

namespace App\Http\Controllers\API;
use App\Models\Link;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;

class LinkController extends Controller
{

    public function index()
    {
        $products = Product::query()
            ->where('status', 1)
            ->get();

        $products = collect($products)->map(function($item){
            $link = Link::query()
                ->where('product_id', $item['id'])
                ->where('enterprise_id', Auth::user()->enterprise_id)
                ->first();

            $item['link'] = isset($link->link) ? $link->link : null;

            return $item;
        });
        

        return $products;
    }

    public function store(Request $request)
    {
        foreach($request->all() as $item){
            $link = Link::query()
                ->where('product_id', $item['id'])
                ->where('enterprise_id', Auth::user()->enterprise_id)
                ->firstOrNew();
            $link->product_id = $item['id'];
            $link->enterprise_id = Auth::user()->enterprise_id;
            $link->link = $item['link'];
            $link->save();
        }

        return true;

    }
    
}
