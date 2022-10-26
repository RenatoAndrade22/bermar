<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PriceTable extends Model
{
    use HasFactory;

    protected $table = 'price_tables';

    protected $fillable = [
        'name'
    ];

    public function prices() : HasMany
    {
        return $this->hasMany(Price::class);
    }

}
