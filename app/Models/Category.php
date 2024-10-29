<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id'
    ];


    public function products() :HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function categories() :belongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

}
