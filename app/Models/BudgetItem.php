<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetItem extends Model
{
    use HasFactory;

    protected $table = 'budget_items';

    protected $fillable = [
        'budget_id',
        'warranty_product_id',
        'price',
    ];

    protected $with = [
        'warrantyProduct'
    ];

    public function budget() :BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

    public function warrantyProduct() :BelongsTo
    {
        return $this->belongsTo(WarrantyProduct::class);
    }
}
