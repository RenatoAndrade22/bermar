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

    public function report($where) {
        return DB::select('
            SELECT 
                us.id AS sellet_id,
                us.name AS sellet_name,
                esale.date_sale,
                entRev.name AS enterprise_resale_name,
                entRepre.name AS enterprise_repre_name,
                prod.name AS product_name,
                esale.product_serial,
                esale.nfe_number,
                ecoItem.comission,
                ecoItem.double,
                ecom.id
            FROM users us
                JOIN external_sales esale
                    ON esale.user_id = us.id
                JOIN enterprises entRev
                    ON entRev.id = us.enterprise_id
                JOIN enterprises entRepre
                    ON entRepre.id = entRev.enterprise_id
                JOIN products prod
                    ON prod.id = esale.product_id
                JOIN external_commissions ecom
                    ON esale.date_sale BETWEEN ecom.start_date AND ecom.end_date
            JOIN external_commission_items ecoItem
                ON ecoItem.external_commission_id = ecom.id AND ecoItem.product_id = prod.id
            WHERE
            us.seller = 1 
            '.implode($where['where']).'
        ', $where['values']);
    }
}
