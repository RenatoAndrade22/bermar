<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\EnterpriseProduct;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Product[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Product
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $video = $request->get('video');

        if(strpos($video,"watch?v=")){
            $video = explode("watch?v=",$video);
            $video = 'https://www.youtube.com/embed/'.$video[1];
        }

        $product = new Product();
        $product->fill($request->all());
        $product->slug = $this->sanitizeString($request->get('name'));
        $product->video = $video;
        $product->saveOrFail();
        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $video = $request->get('video');

        if(strpos($video,"watch?v=")){
            $video = explode("watch?v=",$video);
            $video = 'https://www.youtube.com/embed/'.$video[1];
        }

        $product = Product::find($id);
        $product->fill($request->all());
        if($request->get('name')){
            $product->slug = $this->sanitizeString($request->get('name'));
        }
        $product->video = $video;
        $product->saveOrFail();
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return bool
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        $images = ProductImage::query()->where('product_id', $id)->delete();

        $product->delete();
        return true;
    }

    public function getProductsBermar(){
        return Product::all();
    }

    public function sanitizeString($str) {
        $str = preg_replace('/[??????????]/ui', 'a', $str);
        $str = preg_replace('/[????????]/ui', 'e', $str);
        $str = preg_replace('/[????????]/ui', 'i', $str);
        $str = preg_replace('/[??????????]/ui', 'o', $str);
        $str = preg_replace('/[????????]/ui', 'u', $str);
        $str = preg_replace('/[??]/ui', 'c', $str);
        $str = preg_replace('/[^a-z0-9]/i', '_', $str);
        $str = preg_replace('/_+/', '_', $str);
        return strtolower($str);
    }

}
