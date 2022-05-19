<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'price',
        'status',
    ];
    
    protected $with = [
        'image'
    ];

    public function image() : HasMany
    {
        return $this->hasMany(ProductImage::class);
    }
  
}
