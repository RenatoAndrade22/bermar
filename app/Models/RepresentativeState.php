<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepresentativeState extends Model
{
    use HasFactory;

    protected $table = 'representative_states';

    protected $fillable = [
        'enterprise_id',
        'state'
    ];

}
