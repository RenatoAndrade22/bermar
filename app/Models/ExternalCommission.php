<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class ExternalCommission extends Model
{
    use HasFactory;

    protected $table = 'external_commissions';

    public function externalCommissionItems() :HasMany
    {
        return $this->hasMany(ExternalCommissionItem::class);
    }

    public function getAllComissions()
    {
        return DB::select('
            SELECT 
                ex.id,
                ex.name,
                ex.start_date,
                ex.end_date,
                eci.comission,
                eci.double,
                pro.name AS product_name,
                pro.id AS product_id
            FROM external_commissions ex
                JOIN external_commission_items eci
                    ON eci.external_commission_id = ex.id
                JOIN products pro
                    ON pro.id = eci.product_id
            ORDER BY ex.id DESC
        ');
    }
}
