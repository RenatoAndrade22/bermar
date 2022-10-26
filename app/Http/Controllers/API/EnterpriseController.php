<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnterpriseRequest;
use App\Models\Enterprise;

class EnterpriseController extends Controller
{
    public function index(){
        return Enterprise::all();
    }

    public function getEnterpriseType($type){
        return Enterprise::query()->where('enterprise_type_id', $type)->get();
    }

    public function store(EnterpriseRequest $request){
        $enterprise = new Enterprise();
        $enterprise->fill($request->all());
        $enterprise->saveOrFail();
        return $enterprise;
    }

    public function update(Request $request, $id){
        $enterprise = Enterprise::find($id);
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
                'address' => $enterprise->address->street.', '.$enterprise->address->number.', '.$enterprise->address->district.', '.$enterprise->address->city.'/'.$enterprise->address->state
            ];
        });
    }
}
