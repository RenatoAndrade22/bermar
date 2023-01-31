<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\CategoryController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductSiteController extends Controller
{

    public function index($slug){

        $categories = new CategoryController();

        $category = Category::query()->with('products')->where('slug', $slug)->first();

        $products = Product::query()->where('category_id', $category->id)->get();
 
        return view('site.category', ['category_name' => $category->name,'products' => $products, 'categories' => $categories->index()]);
    }

    public function show($slug){


        $categories = new CategoryController();

        $product = Product::query()->where('slug', $slug)->first();

        $products_related = Product::query()->with('links')->where('category_id', $product->category_id)->get();

        return view('site.product', ['product' => $product, 'categories' => $categories->index(), 'products_related' => $products_related ]);

    }
}
