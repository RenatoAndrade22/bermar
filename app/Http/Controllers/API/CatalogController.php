<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog;

class CatalogController extends Controller
{
    public function index(){
        return Catalog::query()->first();
    }

    public function updateCatalog(Request $request, $id){

        $name = $request->file('file')->getRealPath();
        $upload = UploadCloudController::upload($name);

        $catalog = Catalog::firstOrNew();

        $catalog->public_id = $upload['public_id'];
        $catalog->url = $upload['secure_url'];
        $catalog->saveOrFail();

        return $catalog;
    }
}
