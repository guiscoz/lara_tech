<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RolePermissionRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        $name = ['required'];

        return [
            'name' => $name,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Você precisa inserir um nome para este item',
        ];
    }
}
