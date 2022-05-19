<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function store(Request $request, $id){
        $path = public_path('uploads');
      
        if (!file_exists($path)) {
          mkdir($path, 0777, true);
        }
      
        $file = $request->file('image');

        $name = uniqid() . '_&&_' . trim($file->getClientOriginalName());
      
        $file->move($path, $name);
        
        $product = new ProductImage();
        $product->name = $name;
        $product->product_id = $id;
        $product->saveOrFail();

        return $product;
    }

    public function delete(Request $request, $id = null){

      if($id){
        $image = ProductImage::query()->where('id', $id)->delete();
      }else{
        $image_name = $request->get('image');
        $product_id = $request->get('product');
  
        $images = ProductImage::query()
                    ->where('product_id', $product_id)
                    ->where('name', 'like', '%_&&_'.$image_name.'%')
                    ->first()
                    ->delete();
      }

    }
}
