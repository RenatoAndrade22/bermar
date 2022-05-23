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
        'category_id'
    ];
    
    protected $with = [
        'productImages'
    ];

    public function productImages() : HasMany
    {
        return $this->hasMany(ProductImage::class);
    }
  
}
