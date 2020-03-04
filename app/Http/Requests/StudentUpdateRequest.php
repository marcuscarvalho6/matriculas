<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:students,email,'.$request->segment(3),
            'date_of_birth' => 'required|date_format:d/m/Y',
            'gender' => 'required|in:M,F'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'É necessário informar o nome do aluno',
            'email.required' => 'É necessário informar o email do aluno',
            'email.email' => 'Um email válido deve ser informado',
            'email.unique' => 'Já existe um aluno com esse email',
            'date_of_birth.required' => 'Informe a data de nascimento do aluno',
            'date_of_birth.date_format' => 'Informe a data de nascimento do aluno no formato DD/MM/AAAA',
            'gender.required' => 'É necessário informar o sexo do aluno',
            'gender.in' => 'Informe M ou F para sexo do aluno'
        ];
    }
}
