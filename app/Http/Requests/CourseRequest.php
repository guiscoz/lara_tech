<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:150',
            'teacher_id' => 'required|exists:users,id',
            'campus_id' => 'required|exists:campuses,id',
            'semesters' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome não pode ter mais de 150 caracteres.',
            'teacher_id.required' => 'O campo professor é obrigatório.',
            'teacher_id.exists' => 'O professor selecionado é inválido.',
            'campus_id.required' => 'O campo campus é obrigatório.',
            'campus_id.exists' => 'O campus selecionado é inválido.',
            'semesters.required' => 'O campo semestres é obrigatório.',
            'semesters.integer' => 'O campo semestres deve ser um número inteiro.',
            'semesters.min' => 'O número mínimo de semestres é 1.',
        ];
    }
}
