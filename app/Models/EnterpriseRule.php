<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnterpriseRule extends Model
{
    use HasFactory;

    protected $table = 'enterprises_rules';

    protected $fillable = [
        'enterprise_id',
        'enterprise_type_id',
    ];

}
