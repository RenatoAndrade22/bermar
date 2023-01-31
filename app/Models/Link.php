<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'enterprise_id',
        'link'
    ];

    protected $with = [
        'enterprise'
    ];

    public function enterprise() :BelongsTo
    {
        return $this->belongsTo(Enterprise::class);
    }
}
