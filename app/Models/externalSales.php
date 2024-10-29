<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class externalSales extends Model
{
    use HasFactory;
    protected $table = 'external_sales';

    public function product() :BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getExternalSalesById($user_id, $where) {
        return DB::select(
            'SELECT 
                    pro.name as product_name,
                    es.id,
                    es.date_sale,
                    es.value,
                    es.nfe_number,
                    es.nfe_url,
                    es.product_serial,
                    es.approved
                FROM external_sales es
                    inner join products pro
                    on pro.id = es.product_id
                WHERE es.user_id = :user_id 
                '.$where.'
                ORDER BY es.id DESC
            ', ['user_id' => $user_id]);
    }
}
