<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\CategoryController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductSiteController extends Controller
{

    public function index($slug){

        $categories = new CategoryController();

        $category = Category::query()->with('products')->where('slug', $slug)->first();

        $products = Product::query()
            ->whereNotNull('category_id')
            ->where('category_id', $category->id)
            ->where('site_appear', 1)
            ->get();
 
        return view('site.category', ['category_name' => $category->name,'products' => $products, 'categories' => $categories->categoriesSite()]);
    }

    public function show($slug){

        $categories = new CategoryController();

        $product = Product::query()->with('links')->where('slug', $slug)->first();


        $product->productImages = collect($product->productImages)->map(function($p){

            if($p['url']){
                $url = explode('upload', $p['url']);
                $p['url'] = $url[0].'upload/w_500'.$url[1];
            }
            
            return $p;
        });


        $products_related = Product::query()->where('category_id', $product->category_id)->get();

        $products_related = collect($products_related)->map(function($p){

            if(isset($p['productImages'][0]['url']) && $p['productImages'][0]['url']){
                $url = explode('upload', $p['productImages'][0]['url']);
                $p['productImages'][0]['url'] = $url[0].'upload/w_200'.$url[1];
            }
            
            return $p;
        });


        $links = collect($product['links'])->map(function($link){
            $state = isset($link['enterprise']['address'][0]['state']) ? $link['enterprise']['address'][0]['state'] : null;
            $link['region'] = $this->region($state);
            return $link;
        })->groupBy('region')->toArray();
        
        // dd($links);

        return view('site.product', ['links' => $links, 'product' => $product, 'categories' => $categories->index(), 'products_related' => $products_related ]);

    }

    public function region($state){

        $regions = 
        [
            [
                'state' => 'AC',
                'region' => 'Norte',
            ],
            [
                'state' => 'AP',
                'region' => 'Norte',
            ],
            [
                'state' => 'AM',
                'region' => 'Norte',
            ],
            [
                'state' => 'PA',
                'region' => 'Norte',
            ],
            [
                'state' => 'RO',
                'region' => 'Norte',
            ],
            [
                'state' => 'RR',
                'region' => 'Norte',
            ],
            [
                'state' => 'TO',
                'region' => 'Norte',
            ],
            [
                'state' => 'AL',
                'region' => 'Nordeste',
            ],
            [
                'state' => 'BA',
                'region' => 'Nordeste',
            ],
            [
                'state' => 'CE',
                'region' => 'Nordeste',
            ],
            [
                'state' => 'MA',
                'region' => 'Nordeste',
            ],
            [
                'state' => 'PB',
                'region' => 'Nordeste',
            ],
            [
                'state' => 'PE',
                'region' => 'Nordeste',
            ],
            [
                'state' => 'PI',
                'region' => 'Nordeste',
            ],
            [
                'state' => 'RN',
                'region' => 'Nordeste',
            ],
            [
                'state' => 'SE',
                'region' => 'Nordeste',
            ],
            [
                'state' => 'DF',
                'region' => 'Centro-Oeste',
            ],
            [
                'state' => 'GO',
                'region' => 'Centro-Oeste',
            ],
            [
                'state' => 'MT',
                'region' => 'Centro-Oeste',
            ],
            [
                'state' => 'MS',
                'region' => 'Centro-Oeste',
            ],
            [
                'state' => 'ES',
                'region' => 'Sudeste',
            ],
            [
                'state' => 'MG',
                'region' => 'Sudeste',
            ],
            [
                'state' => 'RJ',
                'region' => 'Sudeste',
            ],
            [
                'state' => 'SP',
                'region' => 'Sudeste',
            ],
            [
                'state' => 'PR',
                'region' => 'Sul',
            ],
            [
                'state' => 'SC',
                'region' => 'Sul',
            ],
            [
                'state' => 'RS',
                'region' => 'Sul',
            ]
        ];
        $region = collect($regions)->where('state', $state)->first();
        return isset($region['region']) ? $region['region'] : null;
    }
}






