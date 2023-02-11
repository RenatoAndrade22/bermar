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

        return view('site.index', ['categories' => $categories, 'catalog' => $catalog->url]);
    }

    public function pageCategory(){

        $categories = Category::query()->orderBy('name')->get();
        $products = Product::query()->where('status', 1)->get();

        return view('site.category', ['categories' => $categories, 'products' => $products]);
    }

    public function searchProducts($slug)
    {
        $categories = Category::query()->orderBy('name')->get();
        $products = Product::query()
            ->where('status', 1)
            ->where('name', 'LIKE', '%'.$slug.'%')
            ->get();

        return view('site.category', ['categories' => $categories, 'products' => $products]);
    }
}
