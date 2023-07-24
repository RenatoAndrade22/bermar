<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\Mapping;
use App\Models\PriceTable;
use App\Models\Price;
use Illuminate\Http\Request;

class ExternalApiController extends Controller
{
    public function allTablePrice()
    {
        $data = $this->getDataAPI('tabelavenda');

        foreach($data['tabela_venda'] as $table){

            $mapping = Mapping::
                           where('external_id', $table['id'])
                           ->where('model', 'table_price')
                           ->first();

            // se não existir mapping, cadastra a nova tabela na base.
            if($mapping){
                $table_price = PriceTable::find($mapping['internal_id']);
            }else{
                $table_price = new PriceTable();
                $table_price->name = $table['descricao'];
                $table_price->save();

                $mapping = new Mapping();
                $mapping->internal_id = $table_price->id;
                $mapping->external_id = $table['id'];
                $mapping->model = 'table_price';
                $mapping->save();

            }
            
            
            // looping com os produtos
            foreach($table['tabelaVendaProdutos'] as $product){
                // verifica se o produto exise pra pegar o id dele, se o produto não existir, não cadastramos o valor
                $product_mapping =  Mapping::
                                    where('external_id', $product['produto']['id'])
                                    ->where('model', 'product')
                                    ->first();

                if(!$product_mapping)
                    continue;
                
                // varifica se já existe um preço para esse produto com essa tabela, caso exista atualiza, caso não exista cadastra.
                $price = Price::where('price_table_id', $table_price->id)
                                ->where('product_id', $product_mapping['internal_id'])
                                ->firstOrNew();
                
                $price->price          =  $product['preco'];
                $price->price_table_id =  $table_price->id;
                $price->product_id     =  $product_mapping['internal_id'];
                $price->save();
                
            }


        }

        return $data;
    }

    public function allProducts()
    {
        $data = $this->getDataAPI('produto');

        foreach($data['produto'] as $product){
            
            // VERIFICA SE ESSE REGISTRO JÁ EXISTE NA TABELA MAPPING
            // CASO EXISTA, ELE JÁ FOI IMPORTADO, PULAMOS ELE.
            $mapping = Mapping::
                           where('external_id', $product['id'])
                           ->where('model', 'product')
                           ->first();

            if($mapping) // se existir já foi importado.
                continue;
            
            // CASO NÃO EXISTA, TEMOS QUE VERIFICAR SE ELE JÁ FOI CADASTRADO MANUALMENTE NO ADMIN,
            // PODEMOS USAR O PARAMETRO "codigoIntegracao" PARA ACHAR O PRODUTO
            $product_internal = Product::where('integration_code', $product['id'])->first();

            if(!$product_internal) // se não existir cadastramos.
            {
                $product_controller = new ProductController();
                $product_internal = $product_controller->saveImportedProduct($product);
            }

            // APÓS, CADASTRAMOS OS IDS REFERENTES NA TABELA MAPPING
            $mapping = new Mapping();
            $mapping->internal_id = $product_internal->id;
            $mapping->external_id = $product['id'];
            $mapping->model = 'product';
            $mapping->save();

        }

        return $data;
    }

    public function getDataAPI($url)
    {
        $response = Http::withHeaders([
            'Authorization' => env('EXTERNAL_API_TOKEN')
        ])->get(env('EXTERNAL_API_URL').'/'.$url.'?bascod='.env('EXTERNAL_API_BASCOD').'&empresa=0101&filial=1&vendedor=11');
        
        return $response->json();
    }


}
