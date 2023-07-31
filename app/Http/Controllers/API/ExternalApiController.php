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
                $table_price = PriceTable::find($mapping->internal_id);
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
                $price = Price::where('price_table_id', $table_price['id'])
                                ->where('product_id', $product_mapping->internal_id)
                                ->firstOrNew();
                
                $price->price          =  $product['preco'];
                $price->price_table_id =  $table_price['id'];
                $price->product_id     =  $product_mapping->internal_id;
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

    public function recordSaleAPI($payload)
    {
        /*
        $response = Http::withHeaders([
            'Authorization' => env('EXTERNAL_API_TOKEN'),
            'Content-Type' => 'application/json', 
        ])->post(env('EXTERNAL_API_URL').'/pedido?bascod='.env('EXTERNAL_API_BASCOD').'&empresa=0101&filial=1&vendedor=11', $data);
        dd($response->json());
        return $response->json();
        */

        $headers = [
            'Authorization: ' . env('EXTERNAL_API_TOKEN'),
            'Content-Type: application/json',
        ];
    
        $url = env('EXTERNAL_API_URL').'/pedido?bascod='.env('EXTERNAL_API_BASCOD').'&empresa=0101&filial=1&vendedor=11';

        // Inicializa a sessão cURL
        $ch = curl_init();
    
        // Define a URL de destino
        curl_setopt($ch, CURLOPT_URL, $url);
    
        // Configura o método POST
        curl_setopt($ch, CURLOPT_POST, true);
    
        // Define os dados do payload no corpo da requisição
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    
        // Define os headers da requisição
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        // Habilita o retorno da resposta em vez de exibi-la diretamente
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);
    
        // Verifica se ocorreu algum erro durante a requisição
        if (curl_errno($ch)) {
            // Aqui você pode tratar o erro conforme sua necessidade
            echo 'Erro cURL: ' . curl_error($ch);
        }
    
        // Fecha a sessão cURL
        curl_close($ch);
    
        dd($response);

        // Decodifica a resposta JSON e retorna o resultado
        return json_decode($response, true);
    }

    public function saveSaleAPI()
    {
        
        $data = array(
            "integracao" => array(
                "bascod" => env('EXTERNAL_API_BASCOD')
            ),
            "empresa_filial" => array(
                "empresa" => array(
                    "id" => "0101"
                ),
                "filial" => array(
                    "id" => 1
                )
            ),
            "cliente" => array(
                "id" => 1
            ),
            "vendedor" => array(
                "id" => 11
            ),
            "data" => "2023-05-05",
            "data_base_faturamento" => "2023-05-05",
            "data_base_vencimentos" => "2023-05-05",
            "data_previsao_entrega" => "2023-05-05",
            "natureza" => "V",
            "percentual_desconto_cascata_1" => 6.0,
            "percentual_desconto_cascata_2" => 0.0,
            "percentual_desconto_cascata_3" => 0.0,
            "percentual_desconto_cascata_4" => 0.0,
            "percentual_desconto_cascata_5" => 0.0,
            "percentual_desconto_cascata_6" => 0.0,
            "percentual_desconto_mostruario" => 7.0,
            "percentual_despesa_supervisor" => 8.0,
            "valor_desconto" => 23.56,
            "condicao_pagamento" => array(
                "id" => 9
            ),
            "forma_recebimento" => array(
                "id" => 1
            ),
            "tabela_venda" => array(),
            "quantidade_volumes" => 123.65,
            "tipo_frete_transportador" => "C",
            "transportador" => array(
                "id" => 1
            ),
            "tipo_frete_transportador_redespacho" => "F",
            "transportador_redespacho" => array(),
            "observacao" => "observações do pedido",
            "itens" => array(
                array(
                    "numero_item_pedido_compra" => "32",
                    "numero_pedido_compra" => "PD1234",
                    "observacao" => "Observção do item 01",
                    "percentual_desconto" => 1.0,
                    "produto" => array(
                        "id" => 2
                    ),
                    "quantidade" => 1.23,
                    "tabela_venda" => array(),
                    "tipo" => "0",
                    "valor_unitario" => 5.6
                ),
                array(
                    "numero_item_pedido_compra" => "32",
                    "numero_pedido_compra" => "PD1234",
                    "observacao" => "Observção do item 11",
                    "percentual_desconto" => 1.0,
                    "produto" => array(
                        "id" => 3
                    ),
                    "quantidade" => 1.23,
                    "tabela_venda" => array(),
                    "tipo" => "0",
                    "valor_unitario" => 5.6
                ),
                array(
                    "numero_item_pedido_compra" => "32",
                    "numero_pedido_compra" => "PD1234",
                    "observacao" => "Observção do item 21",
                    "percentual_desconto" => 1.0,
                    "produto" => array(
                        "id" => 5
                    ),
                    "quantidade" => 1.23,
                    "tabela_venda" => array(),
                    "tipo" => "0",
                    "valor_unitario" => 5.6
                ),
                array(
                    "numero_item_pedido_compra" => "32",
                    "numero_pedido_compra" => "PD1234",
                    "observacao" => "Observção do item 31",
                    "percentual_desconto" => 1.0,
                    "produto" => array(
                        "id" => 6
                    ),
                    "quantidade" => 1.23,
                    "tabela_venda" => array(),
                    "tipo" => "0",
                    "valor_unitario" => 5.6
                ),
                array(
                    "numero_item_pedido_compra" => "32",
                    "numero_pedido_compra" => "PD1234",
                    "observacao" => "Observção do item 41",
                    "percentual_desconto" => 1.0,
                    "produto" => array(
                        "id" => 7
                    ),
                    "quantidade" => 1.23,
                    "tabela_venda" => array(),
                    "tipo" => "0",
                    "valor_unitario" => 5.6
                )
            )
        );
        
        $this->recordSaleAPI(json_encode($data));

    }


}
