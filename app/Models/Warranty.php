<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Warranty extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'enterprise_id',
    ];

    protected $with = [
        'saleOrder'
    ];
    
    public function saleOrder(): BelongsTo
    {
        return $this->belongsTo(saleOrder::class);
    }

    public function enterprise(): BelongsTo
    {
        return $this->belongsTo(Enterprise::class);
    }
    
}
