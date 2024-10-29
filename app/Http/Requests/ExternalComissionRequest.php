<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExternalComissionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'start_date' => 'required|date_format:d/m/Y',
            'end_date' => 'required|date_format:d/m/Y|after_or_equal:start_date',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|integer',
            'products.*.comission' => ['required', 'regex:/^\d{1,3}(\.\d{3})*,\d{2}$/'],
            'products.*.double' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome não pode ter mais de 255 caracteres.',
            'start_date.required' => 'O campo data de início é obrigatório.',
            'start_date.date_format' => 'O campo data de início deve estar no formato dd/mm/yyyy.',
            'end_date.required' => 'O campo data de término é obrigatório.',
            'end_date.date_format' => 'O campo data de término deve estar no formato dd/mm/yyyy.',
            'end_date.after_or_equal' => 'A data de término deve ser igual ou posterior à data de início.',
            'products.required' => 'É necessário enviar pelo menos um produto.',
            'products.array' => 'O campo produtos deve ser um array.',
            'products.min' => 'É necessário enviar pelo menos um produto.',
            'products.*.product_id.required' => 'O campo ID do produto é obrigatório.',
            'products.*.product_id.integer' => 'O campo ID do produto deve ser um número inteiro.',
            'products.*.comission.required' => 'O campo comissão é obrigatório.',
            'products.*.comission.regex' => 'O campo comissão deve estar no formato 0,00.',
            'products.*.double.required' => 'O campo double é obrigatório.',
            'products.*.double.boolean' => 'O campo double deve ser verdadeiro ou falso.',
        ];
    }
}
