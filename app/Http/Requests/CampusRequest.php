<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CampusRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:150',
            'address' => 'required|string|max:150',
            'address_number' => 'required|string|max:10',
            'district' => 'required|string|max:150',
            'zip_code' => 'required|string|max:8',
            'city_id' => 'required|exists:cities,id',
            'state_id' => 'required|exists:states,id',
            'coordinator_id' => 'required|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'O campo título é obrigatório.',
            'title.max' => 'O campo título não pode ter mais de 150 caracteres.',
            'address.required' => 'O campo endereço é obrigatório.',
            'address.max' => 'O campo endereço não pode ter mais de 150 caracteres.',
            'address_number.required' => 'O campo número é obrigatório.',
            'address_number.max' => 'O campo número não pode ter mais de 10 caracteres.',
            'district.required' => 'O campo bairro é obrigatório.',
            'district.max' => 'O campo bairro não pode ter mais de 150 caracteres.',
            'zip_code.required' => 'O campo CEP é obrigatório.',
            'zip_code.max' => 'O campo CEP não pode ter mais de 8 caracteres.',
            'city_id.required' => 'Selecione uma cidade válida.',
            'city_id.exists' => 'A cidade selecionada não é válida.',
            'state_id.required' => 'Selecione um estado válido.',
            'state_id.exists' => 'O estado selecionado não é válido.',
            'coordinator_id.required' => 'Selecione um coordenador válido.',
            'coordinator_id.exists' => 'O coordenador selecionado não é válido.',
        ];
    }
}
