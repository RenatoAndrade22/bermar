<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RecordUser;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function store(RecordUser $request)
    {
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($request->password);
        $user->saveOrFail();

        return $user;
    }

    public function update(Request $request, $id){
        $user = User::find($id);
        $user->fill($request->all());
        $user->saveOrFail();
        return $user;
    }
}












