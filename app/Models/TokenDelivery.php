<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenDelivery extends Model
{
    use HasFactory;
    protected $table = 'token_delivery';
    protected $fillable = [
        'token'
    ];
}
