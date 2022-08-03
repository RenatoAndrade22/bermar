<?php

namespace App\Http\Controllers\API;

use App\Events\PusherEvent;
use App\Models\ChatMessage;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChatMessageController extends Controller
{
    public function store(Request $request)
    {
        if($request->has('user_id') && $request->get('user_id') == 0)
        {
            $id = 0;        
        }else{
            $id = Auth::user()->id;
        }

        $chatMessage = new ChatMessage();
        $chatMessage->message = $request->get('message');
        $chatMessage->chat_id = $request->get('chat_id');
        $chatMessage->user_id = $id;
        $chatMessage->saveOrFail();
        
        event(new PusherEvent($chatMessage));

        return $chatMessage;
    }

    public function uploadFile(Request $request, $chat_id){

        $path = public_path('chat-images');
      
        if (!file_exists($path)) {
          mkdir($path, 0777, true);
        }
      
        $file = $request->file('file');

        $name = uniqid() . '_&&_' . trim($file->getClientOriginalName());
      
        $file->move($path, $name);

        $chatMessage = new ChatMessage();
        $chatMessage->file = $name;
        $chatMessage->chat_id = $chat_id;
        $chatMessage->user_id = Auth::user()->id;
        $chatMessage->saveOrFail();

        event(new PusherEvent($chatMessage));

        return $chatMessage;

    }
}
