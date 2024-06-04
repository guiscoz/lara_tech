<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'min:3', 'max:30', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo "Nome" é obrigatório.',
            'name.min' => 'O campo "Nome" deve ter pelo menos :min caracteres.',
            'name.max' => 'O campo "Nome" não pode ter mais de :max caracteres.',
            'name.unique' => 'Este nome de usuário já está em uso.',
            'email.required' => 'O campo "E-mail" é obrigatório.',
            'email.email' => 'Por favor, insira um endereço de e-mail válido.',
            'email.max' => 'O campo "E-mail" não pode ter mais de :max caracteres.',
            'email.unique' => 'Este e-mail já está em uso.',
            'password.required' => 'O campo "Senha" é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos :min caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
            'password.regex' => 'A senha deve conter pelo menos uma letra maiúscula, uma letra minúscula e um número.',
        ];
    }
}
