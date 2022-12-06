<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnterpriseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:enterprises',
            'phone' => 'required|unique:enterprises',
            'cnpj' => 'required|unique:enterprises',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo Razão social é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'cnpj.required' => 'O campo CNPJ é obrigatório.',
            'phone.required' => 'O campo telefone é obrigatório.',

            'email.unique' => 'Email já cadastrado.',
            'phone.unique' => 'Telefone já cadastrado.',
            'cnpj.unique' => 'CNPJ já cadastrado.',
        ];
    }
}
