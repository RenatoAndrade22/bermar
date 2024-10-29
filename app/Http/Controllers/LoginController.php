<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Nette\Schema\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))){
            return response()->json(['user' => $this->userAndPages(), 'token' => Auth::user()->createToken('JWT')->plainTextToken], 200);
        }else{
            return response()->json('error login', 500);
        }
    }

    public function logout()
    {
        Auth::logout();
    }

    public function userAndPages()
    {
        $results = DB::select('
            SELECT 
            us.name AS user_name,
            us.seller,
            pg.name AS page_name,
            ent.enterprise_type_id as enterprise_type
            FROM users us
            JOIN enterprises ent
                ON ent.id = us.enterprise_id
            JOIN enterprises_rules er
                ON er.enterprise_id = us.enterprise_id
            JOIN pages_rules pr
                ON pr.enterprise_type_id = er.enterprise_type_id
            JOIN pages pg
                ON pg.id = pr.page_id
            WHERE us.id = :user_id', ['user_id' => Auth::user()->id]
        );

        $user = [
            'name' => null,
            'seller' => null,
            'pages' => []
        ];

        foreach ($results as $item) {
            $user['name'] = $item->user_name;
            $user['enterprise_type'][] = $item->enterprise_type;
            $user['seller'] = $item->seller;
            $user['pages'][] = $item->page_name;
        }

        return $user;
    }

    public function athenticated()
    {
        return response()->json(['user' => $this->userAndPages()], 200);
    }
    
}












