<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Enterprise extends Model
{
    use HasFactory;

    protected $table = 'enterprises';

    protected $with = [
        'address'
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

}
