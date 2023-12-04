<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function store(Request $request, $id){

        $file = $request->file('image');

        $name = uniqid() . '_&&_' . trim($file->getClientOriginalName());
        
        $image_name = $request->file('image')->getRealPath();
       
        $upload = UploadCloudController::upload($image_name);

        $product = new ProductImage();
        $product->name = $name;
        $product->product_id = $id;
        $product->public_id = $upload['public_id'];
        $product->url = $upload['secure_url'];
        $product->saveOrFail();

        return $product;
    }

    public function destroy(Request $request, $id = null){

      if($id){
        $image = ProductImage::query()->where('id', $id)->delete();
      }else{
        $image_name = $request->get('image');
        $product_id = $request->get('product');

        $image = ProductImage::query()
                    ->where('product_id', $product_id)
                    ->where('name', 'like', '%_&&_'.$image_name.'%')
                    ->first()
                    ->delete();
      }

      return $image;

    }
}
