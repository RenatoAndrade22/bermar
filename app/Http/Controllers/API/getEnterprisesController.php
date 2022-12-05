<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enterprise;

class getEnterprisesController extends Controller
{
    public function getRepresentatives()
    {
        $enterprises = Enterprise::query()->where('enterprise_type_id', 3)->get();
        return $enterprises;
    }
}
