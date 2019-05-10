<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStorageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome_informal' => 'required|min:3|max:40|regex:/^[a-zA-ZÀ-ù\s]+$/',
            'name' => 'required|min:3|regex:/^[a-zA-ZÀ-ù\s]+$/',
            'nif' => 'nullable|min:9|max:9',
            'telefone' => 'nullable|min:9|max:20',
            'data_nascimento' => 'required|date|before:today|date_format:Y-m-d',
            'direcao' => 'required|in: 0,1',
            'sexo' => 'required|in: F, M',
            'data_nascimento' => 'required|date_format:Y-m-d|before:18 years ago',
            'email' => 'required|email|unique: users, email',
            'tipo_socio' => 'required|in:P,NP,A',
            'password' => 'required|min:8|confirmed',
            'ativo' => 'required|in: 0,1',
            'quota_paga' => 'required|in: 0,1',
            'aluno' => ['nullable', 'in: 0,1', new ValidateInstrutorAluno($this->instrutor)],
            'instrutor' => ['nullable', 'in: 0,1', new ValidateInstrutorAluno($this->aluno)],
            'foto_url' => 'nullable|image|mimes: jpeg, png, jpg, gif|max: 2048',
            'file_licenca' => 'nullable|mimes: pdf| max:2048',
            'file_certificado' => 'nullable|mimes: pdf| max:2048',
            'num_licenca' => 'nullable|max:30',
            'num_certificado' => 'nullable|max:30',
            'tipo_licenca' => 'nullable|exists:tipos_licencas, code|max: 20',
            'classe_certificado' => 'nullable|exists:classes_certificados, code|max: 20',
            'licenca_confirmada' => 'nullable|in: 0,1',
            'certificado_confirmado' => 'nullable|in: 0,1',
            'validade_certificado' => 'nullable|date|after:today|date_format: Y-m-d',
            'validade_licenca' => 'nullable|date|after:today|date_format: Y-m-d',
        ];
    }

    public function messages(){
        return [
            // Ver ficha6 ;) ;)
            'name.regex' => 'Fullname should only contain letters and spaces',
        ];
    }
}
