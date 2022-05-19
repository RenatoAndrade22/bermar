<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordUser extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users',
            'cpf' => 'required|unique:users',
            'password' => 'required',
            'confirme_pass' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'cpf.required' => 'O campo cpf é obrigatório.',
            'password.required' => 'O campo senha é obrigatório.',
            'confirme_pass.required' => 'O campo repetir senha é obrigatório.',
            'phone.required' => 'O campo telefone é obrigatório.',

            'email.unique' => 'Email já cadastrado.',
            'phone.unique' => 'Telefone já cadastrado.',
            'cpf.unique' => 'CPF já cadastrado.',
        ];
    }
}
