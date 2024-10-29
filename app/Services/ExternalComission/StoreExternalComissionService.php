<?php

namespace App\Services\ExternalComission;

use App\Exceptions\ApiErrorException;
use App\Models\ExternalCommission;
use App\Models\ExternalCommissionItem;
use App\Services\ExternalComission\Validation\StoreExternalComissionValidation;
use Carbon\Carbon;
use ExternalCommissionItems;
use Illuminate\Support\Facades\Log;

class StoreExternalComissionService 
{

    protected $validation;
    protected $comission_id;

    public function __construct(StoreExternalComissionValidation $validation)
    {
        $this->validation = $validation;
    }

    public function process($data) :void
    {
        $this->validation->chackUniqueName($data['name']);

        try {

            $this->recordComission($data);

            $this->recordItemsComission($data);

        } catch (\Throwable $th) {
            throw new ApiErrorException('Erro ao cadastrar comissões', 500);
        }
        
    }

    public function recordComission($data) :void
    {
        $comission = new ExternalCommission();
        $comission->name = $data['name'];
        $comission->start_date = Carbon::createFromFormat('d/m/Y', $data['start_date'])->format('Y-m-d');
        $comission->end_date = Carbon::createFromFormat('d/m/Y', $data['end_date'])->format('Y-m-d');
        $comission->save();

        $this->comission_id = $comission->id;
    }

    public function recordItemsComission($data) :void
    {
        foreach ($data['products'] as $item) {
            $comission = new ExternalCommissionItem();
            $comission->external_commission_id = $this->comission_id;
            $comission->product_id = $item['product_id'];
            $comission->comission  = $this->formatToDecimal($item['comission']);
            $comission->double     = filter_var($item['double'], FILTER_VALIDATE_BOOLEAN);
            $comission->save();
        }
    }

    function formatToDecimal($value) {
        $formattedValue = str_replace(['.', ','], ['', '.'], $value);
        return number_format((float)$formattedValue, 2, '.', '');
    }
}