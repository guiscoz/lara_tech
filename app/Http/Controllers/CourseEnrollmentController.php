<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CourseEnrollmentController extends Controller
{
    public function enroll(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $user = Auth::user();
        $course = Course::findOrFail($request->course_id);

        // Associar o usuário ao curso
        $user->courses()->attach($course);

        // Atribuir o perfil de aluno se ainda não tiver
        if (!$user->hasRole('Aluno')) {
            $user->assignRole('Aluno');
        }

        return redirect()->route('courses.index')->with('success', 'Inscrição no curso realizada com sucesso!');
    }
}
