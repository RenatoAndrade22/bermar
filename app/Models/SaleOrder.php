<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

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
        'delivery_date',

        'carrier_id',
        'phone_redispatch',
        'shipping_type_redispatch',
        'carrier_id_redispatch',
        'payment_term_id',
        'value_NF',
        'volume'
    ];

    protected $with = [
        'user',
        'enterprise',
        'saleOrderItems',
        'invoices',
        'carrier',
        'paymentTerm'
    ];

    protected $appends = ['CreatedAtBr', 'deliveryDateBr', 'valueFull', 'value'];

    public function getValueFullAttribute(){
        $items = $this->saleOrderItems->sum('total');
        return $items;
    }

    public function getValueAttribute(){
        $items = $this->saleOrderItems->sum((function ($item) {
            return $item->quantity * $item->price; 
        }));
        return $items;
    }

    public function getCreatedAtBrAttribute()
    {
        return $this->created_at->format('d/m/Y H:i:s'); // Formata a data no formato brasileiro
    }

    public function getDeliveryDateBrAttribute()
    {
        if($this->delivery_date){
            return Carbon::parse($this->delivery_date)->format('d/m/Y');
        }
    }

    public function carrier(): BelongsTo
    {
        return $this->belongsTo(Carrier::class);
    }

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

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function paymentTerm(): BelongsTo
    {
        return $this->belongsTo(PaymentTerm::class);
    }

}
