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
    public function index(){
        return Enterprise::query()->with('address')->get();
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
