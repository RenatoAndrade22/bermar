<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function store(Request $request){
        $address = new Address();
        $address->fill($request->all());
        $address->saveOrFail();
        return $address;
    }
}
