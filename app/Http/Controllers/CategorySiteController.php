<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Catalog;
use Illuminate\Http\Request;

class CategorySiteController extends Controller
{
    public function index(){

        $categories = Category::all();

        $catalog = Catalog::first();

        $url_catalog = "";

        if(isset($catalog->url)){
            $url_catalog = $catalog->url;
        }

        return view('site.index', ['categories' => $categories, 'catalog' => $url_catalog]);
    }

    public function pageCategory(){

        $categories = Category::query()->where('category_id', null)->orderBy('name')->with('categories')->get();

        $products = Product::query()->where('status', 1)->where('site_appear', 1)->get();

        $products = collect($products)->map(function($p){

            if(isset($p['productImages'][0]['url']) && $p['productImages'][0]['url']){
                $url = explode('upload', $p['productImages'][0]['url']);
                $p['productImages'][0]['url'] = $url[0].'upload/w_200'.$url[1];
            }
            
            return $p;
        });

        return view('site.category', ['categories' => $categories, 'products' => $products]);
    }

    public function searchProducts($slug)
    {
        $categories = Category::query()->orderBy('name')->get();
        $products = Product::query()
            ->where('status', 1)
            ->where('name', 'LIKE', '%'.$slug.'%')
            ->get();

        $products = collect($products)->map(function($p){

            if(isset($p['productImages'][0]['url']) && $p['productImages'][0]['url']){
                $url = explode('upload', $p['productImages'][0]['url']);
                $p['productImages'][0]['url'] = $url[0].'upload/w_200'.$url[1];
            }
                
            return $p;
        });

        return view('site.category', ['categories' => $categories, 'products' => $products]);
    }
}
