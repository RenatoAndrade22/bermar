<?php

namespace App\Services\ExternalSales\Validation;

use DateTime;
use InvalidArgumentException;

class GetExternalSalesValidation 
{
    public function validDateInRequestForWhere($request)
    {
        $where = '';

        if (!empty($request['start_date']) && !empty($request['end_date'])) {
            
            if (!$this->isValidDate($request['start_date']) || !$this->isValidDate($request['end_date'])) {
                throw new InvalidArgumentException('Datas inválidas fornecidas.');
            }

            $where = 'AND es.date_sale BETWEEN "'.$request['start_date'].'" AND "'.$request['end_date'].'"';
        }

        return $where;
    }

    public function isValidDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}