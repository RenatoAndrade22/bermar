<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use function Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{
    public function store(Request $request, $id){

        $path = public_path('invoices');

        if (!file_exists($path)) {
          mkdir($path, 0777, true);
        }

        $name = $request->file('file')->getRealPath();
        $upload = UploadCloudController::upload($name);

        $invoice = Invoice::query()->where('sale_order_id', $id)->firstOrNew();
        $invoice->name = $upload['secure_url'];
        $invoice->sale_order_id = $id;
        $invoice->saveOrFail();

        return $invoice;
    }

    public function downloadInvoice($id)
    {
        return Invoice::query()->where('sale_order_id', $id)->first();
    }
}
