<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\Product;
class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_endpoint_list_all_products_bermar()
    {
        Product::factory(3)->create();

        $response = $this->get('/api/products-bermar');

        // verifica se o status retornado é 200
        $response->assertStatus(200);

        // valida o json retornado.
        $response->assertJson(function(AssertableJson $json){

            // valida que o json retornado tem um array 'data'.
            $json->hasAll(['data']);

            // verifica se o aray 0 do data, tem name e description
            $json->hasAll(['data.0.name', 'data.0.description']);

            // verifica o tipo de dados é cada parametro
            $json->whereAllType([
                'data.0.name' => 'string',
                'data.0.description' => 'string'
            ]);


            // valida se o array data dentro do json tem 3 arrays.
            $json->count('data', 3);
        });
        
        
    }
}
