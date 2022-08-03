<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarrantyProduct extends Model
{
    use HasFactory;

    protected $table = 'warranty_products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'status'
    ];

}
