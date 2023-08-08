<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnterpriseRequest;
use App\Models\Enterprise;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class EnterpriseController extends Controller
{

    public function getByNameCnpj($name_cnpj)
    {
        $name_cnpj = str_replace(array('.', '-', '/'), '', $name_cnpj);

        $enterprises = Enterprise::query()
                        ->selectRaw("CONCAT(name, ' / ', cnpj) as name, enterprises.id")
                        ->join('client_seller', 'client_seller.enterprise_id', '=', 'enterprises.id')
                        ->where('client_seller.user_id', Auth::user()->id)
                        ->where('enterprise_type_id', 2)
                        ->where('name', 'LIKE', '%'.$name_cnpj.'%')
                        ->orWhere('cnpj', 'LIKE', '%'.$name_cnpj.'%')
                        ->get();

        return $enterprises;

    }

    public function getByNameCnpjMoreInfo($name_cnpj)
    {
        $name_cnpj = str_replace(array('.', '-', '/'), '', $name_cnpj);

        $enterprises = Enterprise::query()
                        ->with('enterpriseType')
                        ->where('name', 'LIKE', '%'.$name_cnpj.'%')
                        ->orWhere('cnpj', 'LIKE', '%'.$name_cnpj.'%')
                        ->get();

        return $enterprises;
    }

    public function index(){
        return Enterprise::query()->with('address', 'enterpriseType')->orderBy('id','desc')->take(30)->get();
    }

    public function getEnterpriseType($type){
        return Enterprise::query()->where('enterprise_type_id', $type)->get();
    }

    public function store(EnterpriseRequest $request){
        $enterprise = new Enterprise();
        $enterprise->enterprise_id = $request->has('enterprise_representative') ? $request->get('enterprise_representative') : Auth::user()->enterprise_id;
        $enterprise->fill($request->all());

        $enterprise->cnpj =  preg_replace("/[^0-9]/", "", $request->get('cnpj'));
        $enterprise->phone = preg_replace("/[^0-9]/", "", $request->get('phone'));

        $enterprise->saveOrFail();

        if($request->has('address'))
        {
            $address = new Address();
            $address->number = $request->get('address')['number'];
            $address->street = $request->get('address')['street'];
            $address->district = $request->get('address')['district'];
            $address->zipcode = $request->get('address')['zipcode'];
            $address->city = $request->get('address')['city'];
            $address->state = $request->get('address')['state'];
            $address->complement = $request->get('address')['complement'];
            $address->region = $request->get('address')['region'];
            $address->enterprise_id = $enterprise->id;
            $address->saveOrFail();
        }

        return $enterprise;
    }

    public function update(Request $request, $id){
        $enterprise = Enterprise::find($id);
        $enterprise->enterprise_id = $request->get('enterprise_representative');
        $enterprise->fill($request->all());
        $enterprise->saveOrFail();
        return $enterprise;
    }

    public function enterpriseAssistance(){
        $enterprises = Enterprise::query()->where('enterprise_type_id', 4)->get();
        return collect($enterprises)->map(function($enterprise){   
            return [
                'id' => $enterprise->id,
                'name' => $enterprise->name,
                'address' => $enterprise->address[0]->street.', '.$enterprise->address[0]->number.', '.$enterprise->address[0]->district.', '.$enterprise->address[0]->city.'/'.$enterprise->address[0]->state
            ];
        });
    }
}
