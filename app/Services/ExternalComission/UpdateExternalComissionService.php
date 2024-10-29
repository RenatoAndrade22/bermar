<?php

namespace App\Services\ExternalComission;

use App\Exceptions\ApiErrorException;
use App\Models\ExternalCommission;
use App\Models\ExternalCommissionItem;
use App\Services\ExternalComission\Validation\StoreExternalComissionValidation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateExternalComissionService 
{

    protected $validation;

    public function __construct(StoreExternalComissionValidation $validation)
    {
        $this->validation = $validation;
    }

    public function process($data, $id) :void
    {
        $this->validation->checkUpdateNameUnique($data['name'], $id);

        try {

            $this->UpdateComission($data, $id);

            $this->UpdatedItemsComission($data, $id);

        } catch (\Exception $e) {
            throw new ApiErrorException('Erro ao atualizar comissão.', 500);
        }
        
    }

    public function UpdateComission($data, $id) :void
    {
        $comission = ExternalCommission::find($id);
        $comission->name = $data['name'];
        $comission->start_date = Carbon::createFromFormat('d/m/Y', $data['start_date'])->format('Y-m-d');
        $comission->end_date = Carbon::createFromFormat('d/m/Y', $data['end_date'])->format('Y-m-d');
        $comission->save();
    }

    public function UpdatedItemsComission($data, $id) :void
    {
        $items_delete = [];

        foreach ($data['products'] as $item) {

            $comission = ExternalCommissionItem::query()
                            ->where('product_id', $item['product_id'])
                            ->where('external_commission_id', $id)
                            ->firstOrNew();

            $comission->external_commission_id = $id;
            $comission->product_id = $item['product_id'];
            $comission->comission  = $this->formatToDecimal($item['comission']);
            $comission->double     = filter_var($item['double'], FILTER_VALIDATE_BOOLEAN);
            $comission->save();

            $items_delete[] = $comission->id;
        }

        $this->deleteItems($items_delete, $id);

    }

    public function deleteItems($items_delete, $comission_id) :void
    {
        ExternalCommissionItem::where('external_commission_id', $comission_id)
                      ->whereNotIn('id', $items_delete)
                      ->delete();
    }

    public function formatToDecimal($value) 
    {
        $formattedValue = str_replace(['.', ','], ['', '.'], $value);
        return number_format((float)$formattedValue, 2, '.', '');
    }
}