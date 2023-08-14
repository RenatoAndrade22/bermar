<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PaymentTerm;

use Illuminate\Http\Request;

class PaymentTermsController extends Controller
{
    public function index() 
    {
        return PaymentTerm::select('name', 'code_integration')->get();
    }
}
