<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function store(Request $request, $id){
        $path = public_path('invoices');
      
        if (!file_exists($path)) {
          mkdir($path, 0777, true);
        }
      
        $file = $request->file('file');

        $name = uniqid() . '_&&_' . trim($file->getClientOriginalName());
      
        $file->move($path, $name);
        
        $product = new Invoice();
        $product->name = $name;
        $product->sale_order_id = $id;
        $product->saveOrFail();

        return $product;
    }
}
