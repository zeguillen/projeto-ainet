<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'nome_informal' => 'nullable|min:3|max:40|regex:/^[a-zA-ZÀ-ù\s]+$/',
            'name' => 'nullable|min:3|regex:/^[a-zA-ZÀ-ù\s]+$/',
            'nif' => 'nullable|min:9|max:9',
            'telefone' => 'nullable|min:9|max:20',
            'data_nascimento' => 'nullable|date|before:today',
            'direcao' => 'sometimes|required|in:0,1',
            'sexo' => 'sometimes|required|in:F,M',
            'data_nascimento' => 'nullable|date_format:Y-m-d|before:18 years ago',
            'email' => 'nullable|email|unique:users,email,'.$this->socio->email.',email',
            'tipo_socio' => 'sometimes|required|in:P,NP,A',
            'ativo' => 'somtimes|required|in:0,1',
            'quota_paga' => 'sometimes|required|in: 0,1',
            'aluno' => ['nullable', 'in: 0,1'],
            'instrutor' => ['nullable', 'in: 0,1'],
            'foto_url' => 'nullable|image|mimes: jpeg, png, jpg, gif|max: 2048',
            'file_licenca' => 'nullable|mimes:pdf|max:2048',
            'file_certificado' => 'nullable|mimes:pdf|max:2048',
            'num_socio' => 'sometimes|required|unique:users,num_socio,'.$this->socio->num_socio.'|integer|min:0',
            'num_licenca' => 'nullable|max:30|unique:users,num_licenca,'.$this->socio->num_licenca.',num_licenca',
            'num_certificado' => 'nullable|max:30|unique:users,num_certificado,'.$this->socio->num_certificado.',num_certificado',
            'tipo_licenca' => 'nullable|exists:tipos_licencas,code|max: 20',
            'classe_certificado' => 'nullable|exists:classes_certificados,code|max: 20',
            'licenca_confirmada' => 'nullable|in:0,1',
            'certificado_confirmado' => 'nullable|in:0,1',
            'validade_certificado' => 'sometimes|nullable|date|after:today',
            'validade_licenca' => 'sometimes|nullable|date|after:today',
        ];
    }

    public function messages(){
        return [
            'name.regex' => 'O nome só pode conter letras e espaços',
            'nome_informal.regex' => 'O nome só pode conter letras e espaços',
            'nome_informal.max' => 'O nome pode ter no máximo 40 caracteres',
            'nif.min' => 'O NIF é invalido',
            'nif.max' => 'O NIF é invalido',
            'telefone.min' => 'O telefone é inválido',
            'data_nascimento.before' => 'A data de nascimento é inválida',
            'email.unique' => 'O email inserido já se encontra registado',
            'email.regex' => 'O email inserido não é válido',
            'foto_url.mimes' => 'O formato da foto não é válido. Formatos válidos:  jpeg, png, jpg, gif',
            'foto_url.max' => 'O tamanho máximo da foto é 2mb',
            'foto_url.image' => 'A foto tem que ser uma imagem',
            'file_licenca.mimes' => 'O ficheiro da licença tem que ser um PDF',
            'file_licenca.max' => 'O tamanho do ficheiro da licença só pode ser de 2mb',
            'file_certificado.mimes' => 'O ficheiro do certificado tem que ser um PDF',
            'file_certificado.max' => 'O tamanho do ficheiro do certificado só pode ser de 2mb',
            'num_licenca.max' => 'O numero da licença pode conter no máximo 30 caracteres',
            'num_licenca.unique' => 'O numero da licença já existe',
            'num_certificado.max' => 'O numero da licença pode conter no máximo 30 caracteres',
            'num_certificado.unique' => 'O numero do certificado já existe',
            'tipo_licenca.max' => 'O tipo de licença só pode conter 20 caracteres',
            'classe_certificado.max' => 'A classe do certficiado só pode conter 20 caracteres',
            'validade_certificado.after' => 'A validade do certificado é inválida',
            'validade_licenca.after' => 'A validade da licença é inválida'
        ];
    }
}
