<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Warranty;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;

class WarrantyController extends Controller
{
    public function index(){

        $warranties = [];
            
        if(isset(Auth::user()->enterprise->enterprise_type_id))
        {
            if(Auth::user()->enterprise->enterprise_type_id == 1){
                $warranties = Warranty::query()
                    ->with('saleOrder')->get();
            }
    
            if(Auth::user()->enterprise->enterprise_type_id == 4){
                $warranties = Warranty::query()
                    ->where('enterprise_id', '=', Auth::user()->enterprise_id)
                    ->with('saleOrder')->get();
            }
            
        }else{
            
            $warranties = Warranty::query()
                ->whereHas('saleOrder', function ($query) {
                    return $query->where('user_id', '=', Auth::user()->id);
                })->with('saleOrder')
                ->get();
            
        }
        
        return $warranties;

    }

    public function update(Request $request, $id){
        $warranty = Warranty::find($id);
        $warranty->fill($request->all());
        $warranty->saveOrFail();
    }
}
