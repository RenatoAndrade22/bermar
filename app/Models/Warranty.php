<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use \Illuminate\Database\Eloquent\Relations\HasOne;

class Warranty extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'enterprise_id',
    ];

    protected $with = [
        'product'
    ];
    
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function enterprise(): BelongsTo
    {
        return $this->belongsTo(Enterprise::class);
    }

    public function chat(): HasOne
    {
        return $this->hasOne(Chat::class);
    }
 
}
