<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategorySiteController extends Controller
{
    public function index(){
        $categories = Category::all();

        return view('site.index', ['categories' => $categories]);
    }

    public function pageCategory(){

        $categories = Category::all();
        $products = Product::query()->where('status', 1)->get();

        return view('site.category', ['categories' => $categories, 'products' => $products]);
    }
}
