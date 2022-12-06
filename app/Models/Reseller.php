<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reseller extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cnpj',
        'email',
        'phone',
    ];

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
