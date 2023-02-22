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
        'payment_method_id',
        'shipping_type',
        'shipping_company',
        'phone',
        'observation',
    ];

    protected $with = [
        'user',
        'enterprise',
        'saleOrderItems',
        'invoices',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function enterprise(): BelongsTo
    {
        return $this->belongsTo(enterprise::class);
    }

    public function saleOrderItems(): HasMany
    {
        return $this->hasMany(SaleOrderItems::class);
    }

    public function invoices(): hasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function boletos(): hasMany
    {
        return $this->hasMany(Boleto::class);
    }

}
