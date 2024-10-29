<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Enterprise;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyRepreController extends Controller
{
    public function index(){
        
        $enterprises = DB::select('
            SELECT 
                ent.id,
                ent.name,
                ent.cnpj,
                ent.phone
            FROM 
                enterprises ent
            WHERE 
                ent.enterprise_type_id = 2
            AND
                ent.enterprise_id = '.Auth::user()->enterprise_id.'
        ');
                            
        return $enterprises;
    }
}
