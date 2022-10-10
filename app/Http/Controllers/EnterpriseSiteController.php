<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\CategoryController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class EnterpriseSiteController extends Controller
{
    public function index(){
        return view('site.enterprise');
    }
}
