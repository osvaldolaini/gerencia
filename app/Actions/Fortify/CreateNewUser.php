<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // Remover todos os caracteres não numéricos do CPF/CNPJ
        $input['cpf_cnpj'] = preg_replace('/\D/', '', $input['cpf_cnpj']);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'document_type' => ['required', 'in:cpf,cnpj'],
            'cpf_cnpj' => ['required', 'unique:users', $input['document_type']],
        ];

        // Definir mensagens personalizadas
        $messages = [
            'cpf_cnpj.unique' => $input['document_type'] === 'cpf' ? __('validation.cpf_unique', ['attribute' => 'CPF']) : __('validation.cnpj_unique', ['attribute' => 'CNPJ']),
            'cpf_cnpj.' . $input['document_type'] => $input['document_type'] === 'cpf' ? __('validation.cpf', ['attribute' => 'CPF']) : __('validation.cnpj', ['attribute' => 'CNPJ']),
        ];

        // Validar e retornar erro, se houver
        Validator::make($input, $rules, $messages)->validate();

        // Criar o novo usuário
        return User::create([
            'active'    => 1,
            'dark'      => 0,
            'panel'     => 'user',
            'groups'    => ['user'],
            'accesses'  => [null],
            'activities'  => [null],
            'name'      => $input['name'],
            'email'     => $input['email'],
            'password'  => Hash::make($input['password']),
            'cpf_cnpj'  => $input['cpf_cnpj'], // CPF/CNPJ sem caracteres não numéricos
        ]);
    }
}
