<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\Mapping;
use App\Models\PriceTable;
use App\Models\Price;
use App\Models\Enterprise;
use App\Models\PaymentMethod;
use App\Models\PaymentTerm;
use App\Models\TableSeller;
use App\Models\ClientSeller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ExternalApiController extends Controller
{

    public $products = '';
    public $receipt_form = '';

    public function allPaymentMethod()
    {
        $data = $this->getDataAPI('formarecebimento?bascod='.env('EXTERNAL_API_BASCOD').'&empresa=0101&filial=1&vendedor=11');

        foreach($data['forma_recebimento'] as $method)
        {
            $table_price = PaymentMethod::where('code_integration', $method['id'])->firstOrNew();
            $table_price->name = $method['descricao'];
            $table_price->code_integration = $method['id'];
            $table_price->save();
        }

        return true;
    }

    public function allPaymentTerms()
    {
        $data = $this->getDataAPI('condicaopagamento?bascod='.env('EXTERNAL_API_BASCOD').'&empresa=0101&filial=1&vendedor=11');

        foreach($data['condicao_pagamento'] as $term)
        {
            $table_price = PaymentTerm::where('code_integration', $term['id'])->firstOrNew();
            $table_price->name = $term['descricao'];
            $table_price->code_integration = $term['id'];
            $table_price->save();
        }

        return true;
    }

    public function allClients() {

        $sellers = Enterprise::query()
                    ->whereIn('enterprise_type_id', [1, 3])
                    ->where('users.code_integration', '!=', null)
                    ->join('users', 'users.enterprise_id', '=', 'enterprises.id')
                    ->select('users.code_integration', 'users.id')
                    ->get();

        ClientSeller::query()->delete();
        
        foreach($sellers as $seller){

            $data = $this->getDataAPI('cliente?bascod='.env('EXTERNAL_API_BASCOD').'&empresa=0101&filial=1&vendedor='.$seller['code_integration']);

            foreach($data['cliente'] as $client){
                if(isset($client['documento']['numero']) && $client['documento']['numero']){
                    $cnpj = str_replace(array('.', '-', '/'), '', $client['documento']['numero']);

                    if($cnpj != '33068813840'){ // cnpj bermar

                        $enterprise = Enterprise::query()->where('code_integration', $client['id'])->orWhere('cnpj', $cnpj)->firstOrNew();
                        $enterprise->name = $client['nome'];
                        $enterprise->enterprise_type_id = 2;
                        $enterprise->cnpj = $cnpj;
                        $enterprise->status = 1;
                        $enterprise->code_integration = $client['id'];
                        $enterprise->save();

                        $client_seller = ClientSeller::query()
                                            ->where('user_id', $seller->id)
                                            ->where('enterprise_id', $enterprise->id)
                                            ->firstOrNew();
                                            
                        $client_seller->user_id = $seller->id;
                        $client_seller->enterprise_id = $enterprise->id;
                        $client_seller->save();

                    }
                    
                }   
            }

        }
        
        return true;
    }

    public function allTablePrice()
    {

        $sellers = Enterprise::query()
                    ->whereIn('enterprise_type_id', [1, 3])
                    ->where('users.code_integration', '!=', null)
                    ->join('users', 'users.enterprise_id', '=', 'enterprises.id')
                    ->select('users.code_integration', 'users.id')
                    ->get();

        TableSeller::query()->delete();

        // buscar todos os vendedores que tem o codigo de integração.
        foreach ($sellers as $seller) {
            
            // usar o codigo de integração para buscar a tabela de venda de cada codigo integração.
            $data = $this->getDataAPI('tabelavenda?bascod='.env('EXTERNAL_API_BASCOD').'&empresa=0101&filial=1&vendedor='.$seller['code_integration']);

            foreach($data['tabela_venda'] as $table){
            
                $table_price = PriceTable::query()->where('code_integration', $table['id'])->firstOrNew();
                $table_price->name = $table['descricao'];
                $table_price->code_integration = $table['id'];
                $table_price->save(); 
                
                $table_seller = TableSeller::query()
                                    ->where('user_id', $seller->id)
                                    ->where('price_table_id', $table_price->id)
                                    ->firstOrNew();
                
                $table_seller->user_id = $seller->id;
                $table_seller->price_table_id = $table_price->id;
                $table_seller->save();

                foreach($table['tabelaVendaProdutos'] as $product_external){
                    
                    $product = Product::query()->where('integration_code', $product_external['produto']['id'])->first();

                    if(!$product){
                        continue;
                    }
                    
                    // salva o preço
                    $price = Price::query()
                        ->where('product_id', $product->id)
                        ->where('price_table_id', $table_price->id)
                        ->firstOrNew();

                    $price->price          =  $product_external['preco'];
                    $price->price_table_id =  $table_price->id;
                    $price->product_id     =  $product->id;
                    $price->save();

                }
            }

        }



        return true;

    }

    public function allProducts()
    {

        $sellers = Enterprise::query()
                    ->whereIn('enterprise_type_id', [1, 3])
                    ->where('users.code_integration', '!=', null)
                    ->join('users', 'users.enterprise_id', '=', 'enterprises.id')
                    ->select('users.code_integration', 'users.id')
                    ->get();

        foreach($sellers as $seller){

            $data = $this->getDataAPI('produto?bascod='.env('EXTERNAL_API_BASCOD').'&empresa=0101&filial=1&vendedor='.$seller['code_integration']);

            foreach($data['produto'] as $product){

                $product_controller = new ProductController();
                $product_controller->saveImportedProduct($product);

            }

        }
        
        return true;
        
    }

    public function getDataAPI($url)
    {
        $response = Http::withHeaders([
            'Authorization' => env('EXTERNAL_API_TOKEN')
        ])->get(env('EXTERNAL_API_URL').'/'.$url);
        
        return $response->json();
    }

    public function saveSaleAPI()
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
    
        $url = env('EXTERNAL_API_URL').'/pedido?bascod='.env('EXTERNAL_API_BASCOD').'&empresa=0101&filial=1&vendedor='.Auth::user()->code_integration;

        $payload = $this->payload();

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

        // Decodifica a resposta JSON e retorna o resultado
        return json_decode($response, true);
    }

    public function setProduct($product_id, $discount_percentage, $qnt, $unit_value)
    {

        if($this->products)
            $this->products = $this->products.' , ';
        

        $this->products = $this->products.'
            {
                "numero_item_pedido_compra": "32",
                "numero_pedido_compra": "PD1234",
                "observacao": "Observção do item 01",
                "percentual_desconto": '.$discount_percentage.',
                "produto": {
                    "id": '.$product_id.'
                },
                "quantidade": '.$qnt.',
                "tabela_venda": {
                },
                "tipo": "0",
                "valor_unitario": '.$unit_value.'
            }
        ';
    }

    public function setReceiptForm($receipt_form)
    {
        $this->receipt_form = $receipt_form;
    }

    public function payload()
    {
        
        $payload = '
        {
            "integracao": {
                "bascod": "bermar_homologacao"
            },
            "empresa_filial": {
                "empresa": {
                    "id": "0101"
                },
                "filial": {
                    "id": 1
                }
            },
            "cliente": {
                "id": 1
            },
            "vendedor": {
                "id": 11
            },
            "data": "2023-05-05",
            "data_base_faturamento": "2023-05-05",
            "data_base_vencimentos": "2023-05-05",
            "data_previsao_entrega": "2023-05-05",
            "natureza": "V",
            "percentual_desconto_cascata_1": 6.0,
            "percentual_desconto_cascata_2": 0.0,
            "percentual_desconto_cascata_3": 0.0,
            "percentual_desconto_cascata_4": 0.0,
            "percentual_desconto_cascata_5": 0.0,
            "percentual_desconto_cascata_6": 0.0,
            "percentual_desconto_mostruario": 7.0,
            "percentual_despesa_supervisor": 8.0,
            "valor_desconto": 23.56,
            "condicao_pagamento": {
                "id": 9
            },
            "forma_recebimento": {
                "id": '.$this->receipt_form.'
            },
            "tabela_venda": {
        
            },
            "quantidade_volumes": 123.65,
            "tipo_frete_transportador": "C",
            "transportador": {
                "id": 1
            },
            "tipo_frete_transportador_redespacho": "F",
            "transportador_redespacho": {
                
            },
            "observacao": "observações do pedido",
            "itens": [
                '.$this->products.'
            ]
        }
        ';
        
        return $payload;

    }


}
