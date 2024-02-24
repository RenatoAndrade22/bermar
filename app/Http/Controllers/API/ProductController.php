<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\EnterpriseProduct;
use App\Models\Product;
use App\Models\Certificate;
use App\Models\ProductImage;
use App\Models\Price;
use DOMDocument;
use GuzzleHttp\Client;
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

        if($video && !strpos($video,"embed")){
            $video = $this->UrlEmbed($video);
        }

        $product = new Product();
        $product->fill($request->all());
        $product->slug = $this->sanitizeString($request->get('name'));
        $product->video = $video;
        $product->saveOrFail();
        return $product;
    }

    public function saveImportedProduct($product_external)
    {
        $product = Product::query()->where('integration_code', $product_external['id'])->firstOrNew();
        $product->name = $product_external['nome'];
        $product->status = 2;
        $product->slug = $this->sanitizeString($product_external['nome']);
        $product->description = $product_external['nome'];
        $product->price = $product_external['preco'];
        $product->integration_code = $product_external['id'];
        $product->site_appear = false;
        $product->save();

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
        $product = Product::find($id);

        $product->productImages = collect($product->productImages)->map(function($p){

            if($p['url']){
                $url = explode('upload', $p['url']);
                $p['url'] = $url[0].'upload/w_200'.$url[1];
            }
            
            return $p;
        });

        return $product;
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

        if($video && !strpos($video,"embed")){
            $video = $this->UrlEmbed($video);
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

    public function UrlEmbed($url){

        $client = new Client();
            
        $response = $client->get('https://www.youtube.com/oembed?url='.$url.'&format=json');

        $body = $response->getBody();

        $embed = null;

        if($body){
            $body = json_decode($body, true);

            $dom = new DOMDocument();
    
            if(isset($body['html']) && $body['html']){

                @$dom->loadHTML($body['html']);
    
                $iframes = $dom->getElementsByTagName('iframe');
        
                if ($iframes->length > 0) {
                    $embed = $iframes->item(0)->getAttribute('src');
                } 
            }
           
        }
       

        return $embed;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return bool
     */
    public function destroy($id)
    {
        $images = ProductImage::query()->where('product_id', $id)->delete();
        $images = Price::query()->where('product_id', $id)->delete();
        $product = Product::query()->where('id', $id)->delete();

        return true;
    }

    public function getProductsBermar(){
        return Product::query()->orderBy('id', 'desc')->get();
    }

    public function sanitizeString($str) {
        $str = preg_replace('/[áàãâä]/ui', 'a', $str);
        $str = preg_replace('/[éèêë]/ui', 'e', $str);
        $str = preg_replace('/[íìîï]/ui', 'i', $str);
        $str = preg_replace('/[óòõôö]/ui', 'o', $str);
        $str = preg_replace('/[úùûü]/ui', 'u', $str);
        $str = preg_replace('/[ç]/ui', 'c', $str);
        $str = preg_replace('/[^a-z0-9]/i', '_', $str);
        $str = preg_replace('/_+/', '_', $str);
        return strtolower($str);
    }

    public function uploadManual(Request $request, $id){

        $name = $request->file('file')->getRealPath();
        $upload = UploadCloudController::upload($name);

        $product = Product::find($id);
        $product->manual = $upload['secure_url'];
        $product->saveOrFail();

        return $product;
    }

    public function uploadCertificate(Request $request, $id){

        $name = $request->file('file')->getRealPath();
        $upload = UploadCloudController::upload($name);

        $certificate = new Certificate();
        $certificate->url = $upload['secure_url'];
        $certificate->public_id = $upload['public_id'];
        $certificate->product_id = $id;
        $certificate->saveOrFail();

        return $certificate;
    }

}
