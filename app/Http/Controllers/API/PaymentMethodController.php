<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index(){
        return PaymentMethod::all();
    }

    public function store(Request $request){
        $method = new PaymentMethod();
        $method->fill($request->all());
        $method->saveOrFail();
        return $method;
    }

    public function update(Request $request, $id){
        $method = PaymentMethod::find($id);
        $method->fill($request->all());
        $method->saveOrFail();
        return $method;
    }

    public function destroy($id)
    {
        $method = PaymentMethod::find($id);
        $method->delete();

        return $method;
    }
}
