<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carrier;

class CarrierController extends Controller
{
    public function index()
    {
        return Carrier::query()->select('name', 'code_integration')->orderBy('name')->get();
    }
}
