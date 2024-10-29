<?php

namespace App\Services\ExternalComission\Validation;

use App\Exceptions\ApiErrorException;
use App\Models\ExternalCommission;

class StoreExternalComissionValidation 
{

    public function chackUniqueName($name)
    {
        $comission = ExternalCommission::query()->where('name', $name)->get();

        if (count($comission) > 0) {
            throw new ApiErrorException('O nome informado já está em uso. Por favor, escolha um nome diferente.', 500);
        }
    }

    public function checkUpdateNameUnique($name, $id)
    {
        $comission = ExternalCommission::query()->where('name', $name)->where('id', '!=', $id)->get();

        if (count($comission) > 0) {
            throw new ApiErrorException('O nome informado já está em uso. Por favor, escolha um nome diferente.', 500);
        }
    }
}