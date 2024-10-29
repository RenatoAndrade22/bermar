<?php

namespace App\Services\ExternalComission;

use App\Models\ExternalCommission;
use App\Models\ExternalCommissionItem;

class DeleteExternalComissionService 
{

    public function process($id_comission) :void
    {
        $this->deleteComissionItems($id_comission);
        $this->deleteComission($id_comission);
    }

    public function deleteComissionItems($id_comission) :void
    {
        ExternalCommissionItem::where('external_commission_id', $id_comission)->delete();
    }

    public function deleteComission($id_comission) :void
    {
        ExternalCommissionItem::where('id', $id_comission)->delete();
    }

}