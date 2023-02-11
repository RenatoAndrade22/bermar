<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Budget extends Model
{
    use HasFactory;

    protected $table = 'budgets';

    protected $with = [
        'budgetItems'
    ];

    public function budgetItems(): HasMany
    {
        return $this->hasMany(BudgetItem::class);
    }
}
