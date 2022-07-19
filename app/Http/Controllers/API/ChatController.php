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
}
