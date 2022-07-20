<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enterprise extends Model
{
    use HasFactory;

    protected $table = 'enterprises';

    protected $with = [
        'address',
        'enterpriseType'
    ];

    protected $fillable = [
        'name',
        'enterprise_type_id',
        'email',
        'cnpj',
        'phone',
        'status',
    ];

    public function address(): HasOne
    {
        return $this->hasOne(address::class);
    }

    public function enterpriseType(): BelongsTo
    {
        return $this->belongsTo(EnterpriseType::class);
    }

}
