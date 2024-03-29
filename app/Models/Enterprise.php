<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enterprise extends Model
{
    use HasFactory;

    protected $table = 'enterprises';

    protected $with = [
        'address',
        'enterpriseRules'
    ];

    protected $fillable = [
        'name',
        'enterprise_type_id',
        'email',
        'cnpj',
        'phone',
        'cell',
        'status',
    ];

    public function address(): HasMany
    {
        return $this->hasMany(Address::class, 'enterprise_id');
    }

    public function representative_states(): HasMany
    {
        return $this->hasMany(RepresentativeState::class, 'enterprise_id');
    }

    public function enterpriseType(): BelongsTo
    {
        return $this->belongsTo(EnterpriseType::class);
    }

    public function enterpriseRules(): HasMany
    {
        return $this->hasMany(EnterpriseRule::class);
    }

}
