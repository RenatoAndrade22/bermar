<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class externalSaleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date_sale' => 'required',
            'product_id' => 'required|integer|exists:products,id',
            'value' => 'required',
            'nfe_number' => 'required|string',
            'product_serial' => 'required|string',
        ];
    }
}
