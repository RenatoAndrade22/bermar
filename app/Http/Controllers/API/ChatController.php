<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;

class ChatController extends Controller
{
    public function show($id)
    {
        return Chat::query()->with(['messages', 'warranty'])->where('id', $id)->get();
    }

    public function update(Request $request, $id){
        $chat = Chat::find($id);
        $chat->fill($request->all());
        $chat->saveOrFail();
        return $chat;
    }
}
