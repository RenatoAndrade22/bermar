<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Warranty;
use App\Models\ChatMessage;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class WarrantyController extends Controller
{
    public function index(){

        $warranties = [];
            
        if(isset(Auth::user()->enterprise->enterprise_type_id))
        {
            if(Auth::user()->enterprise->enterprise_type_id == 1){
                $warranties = Warranty::query()
                    ->with('chat')->get();
            }
            if(Auth::user()->enterprise->enterprise_type_id == 4){
                $warranties = Warranty::query()
                ->whereHas('chat', function ($query) {
                    return $query->where('enterprise_id', '=', Auth::user()->enterprise_id);
                })->with('chat')
                ->get();
            }
        }else{
            $warranties = Warranty::query()
                ->whereHas('chat', function ($query) {
                    return $query->where('user_id', '=', Auth::user()->id);
                })->with('chat')
                ->get();
                
        }
        return $warranties;
    }

    public function store(Request $request){

        $warranty = new Warranty();
        $warranty->status = true;
        $warranty->product_id = $request->get('product');
        $warranty->saveOrFail();

        $chat = new Chat();
        $chat->status = true;
        $chat->warranty_id = $warranty->id;
        $chat->enterprise_id = $request->get('assistance');
        $chat->user_id = $request->get('user');
        $chat->saveOrFail();

        return $chat;
    }

    public function update(Request $request, $id){
        $warranty = Warranty::find($id);
        $warranty->fill($request->all());
        $warranty->saveOrFail();
        return $warranty;
    }
}
