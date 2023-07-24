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
        'datasheet',
        'price',
        'status',
        'category_id',
        'slug',
        'width',
        'weight',
        'length',
        'height',
        'video',
        'power',
        'voltage',
        'packing_width',
        'packing_weight',
        'packing_length',
        'packing_height',
        'manual',
        'site_appear'
    ];

    protected $with = [
        'productImages'
    ];

    public function productImages() : HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function links() : HasMany
    {
        return $this->hasMany(Link::class);
    }

}
