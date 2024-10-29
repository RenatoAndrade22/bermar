<?php

namespace App\Services\ExternalSales;

use App\Services\ExternalSales\Validation\GetExternalSalesValidation;
use App\Models\externalSales;

class GetExternalSalesService 
{

    protected $validation;
    protected $model;

    public function __construct(GetExternalSalesValidation $validation, externalSales $model)
    {
        $this->validation = $validation;
        $this->model = $model;
    }

    public function process($user_id, $request)
    {

        $queryWhere = $this->validation->validDateInRequestForWhere($request);

        return $this->model->getExternalSalesById($user_id, $queryWhere);

    }

}