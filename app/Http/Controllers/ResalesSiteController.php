<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResalesSiteController extends Controller
{
    public function index(){
        return view('site.resales');
    }
}
