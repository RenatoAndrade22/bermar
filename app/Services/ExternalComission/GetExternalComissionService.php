<?php

namespace App\Services\ExternalComission;

use App\Models\ExternalCommission;
use Carbon\Carbon;

class GetExternalComissionService 
{
    public function process()
    {
        $comissions = new ExternalCommission();

        $data = $comissions->getAllComissions();

        return $this->formatReturn($data);
    }

    public function formatReturn($data)
    {
        $dataReturn = [];

        foreach ($data as $item) {

            if (!isset($dataReturn[$item->id])) {
                $dataReturn[$item->id] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'start_date' => Carbon::createFromFormat('Y-m-d', $item->start_date)->format('d/m/Y'),
                    'end_date' => Carbon::createFromFormat('Y-m-d', $item->end_date)->format('d/m/Y'),
                    'products' => []
                ];
            }

            $dataReturn[$item->id]['products'][] = [
                'product_id' => $item->product_id,
                'name' => $item->product_name,
                'double' => $item->double,
                'comission' => $item->comission,
            ];

        }

        return array_values($dataReturn);
    }
}