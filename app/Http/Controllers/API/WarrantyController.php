<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Warranty;
use Illuminate\Support\Facades\Auth;

class WarrantyController extends Controller
{
    public function index(){

        $warranties = Warranty::whereHas('saleOrder', function ($query) {
                return $query->where('enterprise_id', '=', Auth::user()->enterprise_id);
            })->with('saleOrder')->get();

        return $warranties;

    }
}
