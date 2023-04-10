<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enterprise;

class ExportController extends Controller
{
    public function index(){
        $enterprises = Enterprise::query()
              ->where('enterprises.enterprise_type_id', '=', 5)
              ->get();

        return view('site.export', ['enterprises'=> $enterprises]);
    }
}
