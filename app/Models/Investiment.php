<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Investiment extends Model
{
    use HasFactory;

    protected $fillable = [
        'cv',
        'action_id',
        'price',
        'amount',
        'type',
        'rate',
        'value',
        'due_date',
    ];

    public function action() :BelongsTo
    {
        return $this->belongsTo(Action::class);
    }
}
