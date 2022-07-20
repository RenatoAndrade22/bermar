<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use App\Events\PusherEvent;

class ChatMessageController extends Controller
{
    public function store(Request $request)
    {
        $chatMessage = new ChatMessage();
        $chatMessage->message = $request->get('message');
        $chatMessage->chat_id = $request->get('chat_id');
        $chatMessage->user_id = Auth::user()->id;
        $chatMessage->saveOrFail();
        
        event(new PusherEvent($chatMessage));

        return $chatMessage;
    }
}
