<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Price extends Model
{
    use HasFactory;

    protected $table = 'prices';

    protected $appends = ['name_product'];

    protected $fillable = [
        'price_table_id',
        'product_id',
        'price'
    ];

    public function getNameProductAttribute()
    {
        return $this->product->name;
    }

    public function product() : BelongsTo 
    {
        return $this->belongsTo(Product::class);
    }

}
