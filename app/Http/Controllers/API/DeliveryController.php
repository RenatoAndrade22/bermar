<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\TokenDelivery;

use Illuminate\Http\Request;

class DeliveryController extends Controller
{

    private $client;
    private $token;

    public function __construct(){
        $this->client = new \GuzzleHttp\Client();
        $this->token = TokenDelivery::first();
        if($this->token)
            $this->token = $this->token->token;
    }

    public function getCity($zipcode){

        try{
            $response = $this->client->request('GET', 'https://01wapi.rte.com.br/api/v1/busca-por-cep?zipCode='.$zipcode, [
                'headers' => [
                  'Accept' => 'application/json',
                  'Authorization' => 'Bearer '.$this->token,
                ],
            ]);
            return $response->getBody();
        }
        catch(\GuzzleHttp\Exception\RequestException $e)
        {
            $response = $e->getResponse();
            if($response->getStatusCode() == 401){
                $this->getToken();
                return $this->getCity($zipcode);
            }
        }
    }

    public function getToken(){
        $response = $this->client->request('POST', 'https://01wapi.rte.com.br/token', [
            'form_params' => [
                'auth_type' => 'DEV',
                'grant_type' => 'password',
                'username' => 'BERMARIND',
                'password' => 'CKA8936F'
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        $resp = json_decode($response->getBody());

        $token = TokenDelivery::firstOrNew();
        $token->token = $resp->access_token;
        $token->saveOrFail();

        $this->token = $resp->access_token;

    }
}
