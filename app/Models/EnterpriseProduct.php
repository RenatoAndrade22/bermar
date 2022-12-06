<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnterpriseProduct extends Model
{
    use HasFactory;
   
    protected $filable = [
        'status',
        'stock',
    ];
    
    protected $with = [
        'products'
    ];

    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
