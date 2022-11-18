<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function store(Request $request, $id){

        $path = public_path('products-images');

        if (!file_exists($path)) {
          mkdir($path, 0777, true);
        }

        $file = $request->file('image');

        $name = 'teste.png';

        $file->move($path, $name);

        $product = new ProductImage();
        $product->name = $name;
        $product->product_id = $id;
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
