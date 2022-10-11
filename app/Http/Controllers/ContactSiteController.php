<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactSiteController extends Controller
{
    public function index(){
        return view('site.contact');
    }
}
