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
            'num_socio' => 'required|unique:users,num_socio',
            'nome_informal' => 'required|min:3|max:40|regex:/^[a-zA-ZÀ-ù\s]+$/',
            'name' => 'required|min:3|regex:/^[a-zA-ZÀ-ù\s]+$/',
            'nif' => 'nullable|min:9|max:9',
            'telefone' => 'nullable|min:9|max:20',
            'direcao' => 'required|in:0,1',
            'sexo' => 'required|in:F,M',
            'endereco' => 'nullable|',
            'data_nascimento' => 'required|date_format:Y-m-d|before:18 years ago',
            'email' => 'required|email|unique:users,email|regex:/^\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b/',
            'tipo_socio' => 'required|in:P,NP,A',
            'password' => 'required|min:8|confirmed',
            'ativo' => 'required|in:0,1',
            'quota_paga' => 'required|in: 0,1',
            'aluno' => 'nullable', 'in: 0,1',
            'instrutor' => 'nullable', 'in: 0,1',
            'foto_url' => 'nullable|image|mimes: jpeg, png, jpg, gif|max: 2048',
            'file_licenca' => 'nullable|mimes:pdf|max:2048',
            'file_certificado' => 'nullable|mimes:pdf|max:2048',
            'num_licenca' => 'nullable|max:30|unique:users,num_licenca',
            'num_certificado' => 'nullable|max:30|unique:users,num_certificado',
            'tipo_licenca' => 'nullable|exists:tipos_licencas,code|max: 20',
            'classe_certificado' => 'nullable|exists:classes_certificados,code|max: 20',
            'licenca_confirmada' => 'nullable|in:0,1',
            'certificado_confirmado' => 'nullable|in:0,1',
            'validade_certificado' => 'nullable|date|after:today|date_format: Y-m-d',
            'validade_licenca' => 'nullable|date|after:today|date_format: Y-m-d',
        ];
    }

    public function messages(){
        return [
            'num_socio.unique' => 'O nome de sócio já se encontra em uso',
            'num_socio.required' => 'O nome de sócio é requerido',
            'name.regex' => 'O nome só pode conter letras e espaços',
            'name.required' => 'O nome é requerido',
            'nome_informal.regex' => 'O nome só pode conter letras e espaços',
            'nome_informal.required' => 'O nome é requerido',
            'nome_informal.max' => 'O nome pode ter no máximo 40 caracteres',
            'nif.min' => 'O NIF é invalido',
            'nif.max' => 'O NIF é invalido',
            'telefone.min' => 'O telefone é inválido',
            'sexo.required' => 'O sexo é requerido',
            'data_nascimento.required' => 'A data de nascimento é requerida',
            'data_nascimento.before' => 'A data de nascimento é inválida',
            'email.required' => 'O email é requerido',
            'email.unique' => 'O email inserido já se encontra registado',
            'email.regex' => 'O email inserido não é válido',
            'tipo_socio.required' => 'O tipo de sócio é requerido',
            'password.required' => 'A palavra-passe é requerida',
            'password.min' => 'A palavra-passe tem que ter no mínimo 8 caracteres',
            'password.confirmed' => 'A palavra-passe é a confirmação têm que ser iguais',
            'ativo.required' => 'O estado do utilizador é requerido',
            'quota_paga.required' => 'O estado da quota é requerido',
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
