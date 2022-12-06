<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategorySiteController extends Controller
{
    public function index(){
        $categories = Category::all();

        return view('site.index', ['categories' => $categories]);
    }
}
