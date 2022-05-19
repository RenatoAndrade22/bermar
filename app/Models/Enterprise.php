<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    use HasFactory;
    protected $table = 'enterprises';

    protected $fillable = [
        'name',
        'enterprise_type_id',
        'email',
        'cnpj',
        'phone',
    ];

}
