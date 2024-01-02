<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enterprise;


class getEnterprisesController extends Controller
{
    public function getRepresentatives($type, $uf, $text = null)
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

        
        if(!$text){
            $enterprises = Enterprise::query()
                ->join('addresses', 'enterprises.id', '=', 'addresses.enterprise_id')
                ->join('enterprises_rules', 'enterprises.id', '=', 'enterprises_rules.enterprise_id')
                ->where('enterprises_rules.enterprise_type_id', $type_id)
                ->where('addresses.state', '=', $uf)
                ->orderBy('city')
                ->paginate(9);
        } else{

            $enterprises = Enterprise::query()
                ->join('addresses', 'enterprises.id', '=', 'addresses.enterprise_id')
                ->join('enterprises_rules', 'enterprises.id', '=', 'enterprises_rules.enterprise_id')
                ->where('enterprises_rules.enterprise_type_id', $type_id)
                ->where('addresses.state', '=', $uf)
                ->where(function ($query) use ($text) {
                    $query->where('enterprises.name', 'LIKE', '%' . $text . '%')
                        ->orWhere('addresses.city', 'LIKE', '%' . $text . '%');
                })
                ->orderBy('city')
                ->paginate(9);
        }
            
        return $enterprises;
    }
}
