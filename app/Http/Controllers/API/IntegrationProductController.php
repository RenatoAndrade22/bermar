<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IntegrationProduct;

class IntegrationProductController extends Controller
{
    public function index()
    {
        return IntegrationProduct::all();
    }

    public function store(Request $request)
    {
        $integration = new IntegrationProduct();
        $integration->code_integration = $request->get('code_integration');
        $integration->save();
        return true;
    }

    public function destroy($id)
    {
        $integration = IntegrationProduct::find($id);
        $integration->delete();

        return $integration;
    }
}
