<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:150',
            'campus_id' => 'required|exists:campuses,id',
            'event_date' => 'required|date',
            'event_time' => 'required|regex:/^\d{2}:\d{2}(:\d{2})?$/',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome do evento é obrigatório.',
            'campus_id.required' => 'O campus é obrigatório.',
            'campus_id.exists' => 'O campus selecionado é inválido.',
            'event_date.required' => 'A data do evento é obrigatória.',
            'event_date.date' => 'A data do evento deve ser uma data válida.',
            'event_time.required' => 'O horário do evento é obrigatório.',
            'event_time.date_format' => 'O horário do evento deve estar no formato HH:MM.',
        ];
    }
}
