<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\Address;
use App\Models\PriceTable;
use App\Models\Price;
use App\Models\Enterprise;
use App\Models\IntegrationProduct;
use App\Models\PaymentMethod;
use App\Models\PaymentTerm;
use App\Models\TableSeller;
use App\Models\ClientSeller;
use App\Models\Carrier;
use App\Models\EnterpriseRule;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ExternalApiController extends Controller
{

    public $products = '';
    public $receipt_form = '';
    public $payment_term = '';
    public $table_price = '';

    public $client = '';

    public $carrier = '';
    public $type_transport= '';

    public $carrier_redispatch = '';
    public $type_transport_redispatch= '';
    public $obs = '';
    public $delivery_date = '';

    public function allPaymentMethod()
    {
        $data = $this->getDataAPI('formarecebimento?bascod='.env('EXTERNAL_API_BASCOD').'&empresa='.env('EXTERNAL_API_EMPRESA').'&filial='.env('EXTERNAL_API_FILIAL').'&vendedor='.env('EXTERNAL_API_ID_BERMAR'));

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
        $data = $this->getDataAPI('condicaopagamento?bascod='.env('EXTERNAL_API_BASCOD').'&empresa='.env('EXTERNAL_API_EMPRESA').'&filial='.env('EXTERNAL_API_FILIAL').'&vendedor='.env('EXTERNAL_API_ID_BERMAR'));

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
                    ->select('users.code_integration', 'users.id')
                    ->join('users', 'users.enterprise_id', '=', 'enterprises.id')
                    ->join('enterprises_rules', 'enterprises_rules.enterprise_id', '=', 'enterprises.id')
                    ->whereIn('enterprises_rules.enterprise_type_id', [1, 3])
                    ->where('users.code_integration', '!=', null)
                    ->get();

        ClientSeller::query()->delete();
        
        foreach($sellers as $seller){

            $data = $this->getDataAPI('cliente?bascod='.env('EXTERNAL_API_BASCOD').'&empresa='.env('EXTERNAL_API_EMPRESA').'&filial='.env('EXTERNAL_API_FILIAL').'&vendedor='.$seller['code_integration']);

            foreach($data['cliente'] as $client){

                if(isset($client['documento']['numero']) && $client['documento']['numero']){
                    $cnpj = str_replace(array('.', '-', '/'), '', $client['documento']['numero']);

                    if($cnpj != '33068813840'){ // cnpj bermar
                       
                        $enterprise = Enterprise::query()
                                        ->where('code_integration', $client['id'])
                                        ->firstOrNew();

                        $enterprise->name = $client['nome'];
                        $enterprise->enterprise_type_id = 2;
                        $enterprise->cnpj = $cnpj;
                        $enterprise->status = 1;
                        $enterprise->code_integration = $client['id'];
                        $enterprise->save();

                        if($client['tipoCliente2']['id'] == 8){ // deve ser gravado como assitencia e cliente.

                            $enterprise_rule = EnterpriseRule::query()
                                                ->where('enterprise_id', $enterprise->id)
                                                ->where('enterprise_type_id', 4)
                                                ->firstOrNew();

                            $enterprise_rule->enterprise_id = $enterprise->id;
                            $enterprise_rule->enterprise_type_id = 4;
                            $enterprise_rule->save();
                            
                        }

                        $enterprise_rule_re = EnterpriseRule::query()
                                                ->where('enterprise_id', $enterprise->id)
                                                ->where('enterprise_type_id', 2)
                                                ->firstOrNew();

                        $enterprise_rule_re->enterprise_id = $enterprise->id;
                        $enterprise_rule_re->enterprise_type_id = 2;
                        $enterprise_rule_re->save();

                        $address = Address::query()->where('enterprise_id', $enterprise->id)->firstOrNew();

                        $rua = '';
                        $numero = '';

                        if(isset($client['endereco']['endereco'])){
                            $endereco = explode(',', $client['endereco']['endereco']);
                        
                            $rua = isset($endereco[0]) ? $endereco[0] : '';
                            $numero = isset($endereco[1]) ? $endereco[1] : '';    
                        }
                      
                        $address->enterprise_id = $enterprise->id;
                        $address->number = $numero;
                        $address->street = $rua;
                        $address->district = isset($client['endereco']['bairro']) ? $client['endereco']['bairro'] : '';
                        $address->zipcode = isset($client['endereco']['cep']) ? $client['endereco']['cep'] : '';
                        $address->city = isset($client['endereco']['municipio']['nome']) ? $client['endereco']['municipio']['nome'] : '';
                        $address->state = isset($client['endereco']['municipio']['estado']['uf']) ? $client['endereco']['municipio']['estado']['uf'] : '';

                        $address->save();

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
                    ->where('users.code_integration', '!=', null)
                    ->join('users', 'users.enterprise_id', '=', 'enterprises.id')
                    ->join('enterprises_rules', 'enterprises_rules.enterprise_id', '=', 'enterprises.id')
                    ->whereIn('enterprises_rules.enterprise_type_id', [1, 3])
                    ->select('users.code_integration', 'users.id')
                    ->get();

        TableSeller::query()->delete();

        // buscar todos os vendedores que tem o codigo de integração.
        foreach ($sellers as $seller) {
            
            // usar o codigo de integração para buscar a tabela de venda de cada codigo integração.
            $data = $this->getDataAPI('tabelavenda?bascod='.env('EXTERNAL_API_BASCOD').'&empresa='.env('EXTERNAL_API_EMPRESA').'&filial='.env('EXTERNAL_API_FILIAL').'&vendedor='.$seller['code_integration']);

            if(isset($data['tabela_venda'])){
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
            

        }



        return true;

    }


    public function allCarriers()
    {
        $data = $this->getDataAPI('transportador?bascod='.env('EXTERNAL_API_BASCOD'));

        foreach($data['transportador'] as $carrierApi){
            
            if($carrierApi['nome'] && $carrierApi['id']){
                $carrier = Carrier::query()->where('name', $carrierApi['nome'])->where('code_integration', $carrierApi['id'])->firstOrNew();
                $carrier->name = $carrierApi['nome'];
                $carrier->code_integration = $carrierApi['id'];
                $carrier->save();
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

            $data = $this->getDataAPI('produto?bascod='.env('EXTERNAL_API_BASCOD').'&empresa='.env('EXTERNAL_API_EMPRESA').'&filial='.env('EXTERNAL_API_FILIAL').'&vendedor='.$seller['code_integration']);

            foreach($data['produto'] as $product){

                    $product_controller = new ProductController();
                    $product_internal = $product_controller->saveImportedProduct($product);

                    if($product['grupo']['id'] == 2){ // verifica se o produto deve ser cadastrado na tabela de preço com o valor de atacado.
                        $table_price = PriceTable::query()->where('code_integration', $product['grupo']['id'].'-ATACADO')->firstOrNew();
                        $table_price->name = $product['grupo']['nome'].' - ATACADO';
                        $table_price->code_integration = $product['grupo']['id'].'-ATACADO';
                        $table_price->save(); 
                        
                        $table_seller = TableSeller::query()
                                            ->where('user_id', $seller->id)
                                            ->where('price_table_id', $table_price->id)
                                            ->firstOrNew();
                        
                        $table_seller->user_id = $seller->id;
                        $table_seller->price_table_id = $table_price->id;
                        $table_seller->save();
                        
                        // salva o preço
                        $price = Price::query()
                            ->where('product_id', $product_internal->id)
                            ->where('price_table_id', $table_price->id)
                            ->firstOrNew();

                        $price->price          =  $product['precoAtacado'];
                        $price->price_table_id =  $table_price->id;
                        $price->product_id     =  $product_internal->id;
                        $price->save();

                    }
                
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

        $headers = [
            'Authorization: ' . env('EXTERNAL_API_TOKEN'),
            'Content-Type: application/json',
        ];
    
        $url = env('EXTERNAL_API_URL').'/pedido?bascod='.env('EXTERNAL_API_BASCOD').'&empresa='.env('EXTERNAL_API_EMPRESA').'&filial='.env('EXTERNAL_API_FILIAL').'&vendedor='.Auth::user()->code_integration;

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

    public function setProduct($product_id, $discount_percentage, $qnt, $total_discount)
    {

        if($this->products)
            $this->products = $this->products.' , ';
        

        $this->products = $this->products.'
            {
                "numero_item_pedido_compra": "",
                "numero_pedido_compra": "",
                "observacao": "",
                "percentual_desconto": '.$discount_percentage.',
                "produto": {
                    "id": '.$product_id.'
                },
                "quantidade": '.$qnt.',
                "tabela_venda": {
                },
                "tipo": "0",
                "valor_unitario": '.$total_discount / $qnt.'
            }
        ';
    }

    public function setTablePrice($table_price)
    {
        $this->table_price = $table_price;
    }

    public function setReceiptForm($receipt_form)
    {
        $this->receipt_form = $receipt_form;
    }

    public function setPaymentTerm($payment_term)
    {
        $this->payment_term = $payment_term;
    }

    public function setCarrier($carrier)
    {
        $this->carrier = $carrier;
    }

    public function setCarrierRedispatch($carrier, $type_transport)
    {
        if($carrier && $type_transport){
            $this->carrier_redispatch = '"id": '.$carrier.'';
            $this->type_transport_redispatch = $type_transport;
        }
    }

    public function setClient($client)
    {
        $this->client = $client;
    }

    public function setObs($obs)
    {
        $this->obs = $obs;
    }

    public function setTypeTransport($type_transport)
    {
        $this->type_transport = $type_transport;
    }

    public function setDeliveryDate($delivery_date)
    {
        $date = DateTime::createFromFormat('d/m/Y', $delivery_date);
        if($date){
            $this->delivery_date = '"data_previsao_entrega": "'.$date->format('Y-m-d').'",';
        }
    }
    
    public function payload()
    {
        //"valor_desconto": 23.56,
        //"tipo_frete_transportador": "'.$this->type_transport.'",

        $payload = '
        {
            "integracao": {
                "bascod": "'.env('EXTERNAL_API_BASCOD').'"
            },
            "empresa_filial": {
                "empresa": {
                    "id": "'.env('EXTERNAL_API_EMPRESA').'"
                },
                "filial": {
                    "id": "'.env('EXTERNAL_API_FILIAL').'"
                }
            },
            "cliente": {
                "id": '.$this->client.'
            },
            "vendedor": {
                "id": '.Auth::user()->code_integration.'
            },
            "data": "'.date("Y-m-d").'",
            "data_base_faturamento": "'.date("Y-m-d").'",
            "data_base_vencimentos": "'.date("Y-m-d").'",
            '.$this->delivery_date.'
            "natureza": "V",
            "condicao_pagamento": {
                "id": '.$this->payment_term.'
            },
            "forma_recebimento": {
                "id": '.$this->receipt_form.'
            },
            "tabela_venda": {
                "id": '.$this->table_price.'
            },
            "tipo_frete_transportador": "'.$this->type_transport.'",
            "transportador": {
                "id": '.$this->carrier.'
            },
            "tipo_frete_transportador_redespacho": "'.$this->type_transport_redispatch.'",
            "transportador_redespacho": {
                '.$this->carrier_redispatch.'
            },
            "observacao": "'.$this->obs.'",
            "itens": [
                '.$this->products.'
            ]
        }
        ';
        
        return $payload;

    }


}
