<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssistanceSiteController extends Controller
{
    public function index(){
        return view('site.assistance');
    }
}
