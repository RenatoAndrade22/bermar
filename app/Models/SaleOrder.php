<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'status_payment',
        'status_delivery',
    ];

    protected $with = [
        'user',
        'enterprise',
        'saleOrderItems'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function enterprise(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function saleOrderItems(): HasMany
    {
        return $this->hasMany(saleOrderItems::class);
    }

}
