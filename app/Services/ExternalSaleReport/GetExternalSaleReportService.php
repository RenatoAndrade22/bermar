<?php

namespace App\Services\ExternalSaleReport;

use App\Models\externalSales;

class GetExternalSaleReportService 
{
    protected $model;

    public function __construct(externalSales $model)
    {
        $this->model = $model;
    }

    public function process($dataRequest)
    {
        $where = $this->generateWhere($dataRequest);

        $data = $this->model->report($where);

        $data = $this->formatData($data);

        return $data;
    }

    public function generateWhere($dataRequest)
    {

        $where = [
            'where' => [],
            'values' => []
        ];

        if (isset($dataRequest['start_date']) && $dataRequest['start_date'] && isset($dataRequest['end_date']) && $dataRequest['end_date']) {
            $where['where'][] = ' AND esale.date_sale BETWEEN ? AND ? ';
            $where['values'][] = $dataRequest['start_date'];
            $where['values'][] = $dataRequest['end_date'];
        }

        if (isset($dataRequest['name']) && $dataRequest['name']) {
            $where['where'][] = ' AND us.name LIKE CONCAT("%", ?, "%") ';
            $where['values'][] = $dataRequest['name'];
        }
        
        return $where;
    }

    public function formatData($data)
    {
        $dataFormat = [];

        foreach ($data as $item) {

            if (!isset($dataFormat[$item->sellet_id])) {
                $dataFormat[$item->sellet_id] = [
                    'sellet_id' => $item->sellet_id,
                    'sellet_name' => $item->sellet_name,
                    'enterprise_resale_name' => $item->enterprise_resale_name,
                    'enterprise_repre_name' => $item->enterprise_repre_name,
                    'comissions' => [],
                    'total_comissions' => 0,
                ];
            }
            
            $dataFormat[$item->sellet_id]['total_comissions'] += $item->double ? ($item->comission * 2) : $item->comission;

            $dataFormat[$item->sellet_id]['comissions'][] = [
                'date_sale' => $item->date_sale,
                'product_name' => $item->product_name,
                'product_serial' => $item->product_serial,
                'nfe_number' => $item->nfe_number,
                'comission_real' => $item->double ? ($item->comission * 2) : $item->comission,
                'comission' => $item->comission,
                'double' => $item->double,
            ];

        }

        return array_values($dataFormat);
    }
}