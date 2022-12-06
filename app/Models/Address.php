<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'addresses';

    protected $fillable = [
        'number',
        'street',
        'district',
        'zipcode',
        'city',
        'state',
        'complement',
        'enterprise_id',
        'city_id',
        'region',
    ];

}
