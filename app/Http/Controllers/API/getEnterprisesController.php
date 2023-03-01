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

        return Enterprise::query()
              ->join('addresses', 'enterprises.id', '=', 'addresses.enterprise_id')
              ->where('enterprises.enterprise_type_id', '=', $type_id)
              ->where('addresses.state', '=', $uf)
              ->get();
    }
}
