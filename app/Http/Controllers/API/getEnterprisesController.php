<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enterprise;

class getEnterprisesController extends Controller
{
    public function getRepresentatives($type, $uf)
    {
        $type_id = 0;

        if($type == 'revendas'){
            $type_id = 2;
        }

        if($type == 'representantes'){
            $type_id = 3;
        }

        if($type == 'assistencias'){
            $type_id = 4;
        }

        $enterprises = Enterprise::query()->with(['address'])->where('enterprise_type_id', $type_id)->get();

        $enterprises = collect($enterprises)->filter(function ($item) use ($uf){

            if(count($item['address']) == 0){
                return false;
            }

            if($item['address'][0]['state'] != $uf){
                return false;
            }

            return true;
        });

        return $enterprises;
    }
}
