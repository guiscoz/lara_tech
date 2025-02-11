<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Campus;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->get('filter', 'all');

        $query = Course::with(['campus', 'teacher'])->where('active', true);

        $enrolledCourses = $user ? $user->enrolled()->pluck('course_id')->toArray() : [];

        if ($filter == 'enrolled' && $user) {
            $query->whereIn('id', $enrolledCourses);
        } elseif ($filter == 'not_enrolled' && $user) {
            $query->whereNotIn('id', $enrolledCourses);
        }

        $courses = $query->paginate(10);

        return view('courses.index', compact('courses', 'enrolledCourses'));
    }

    public function create()
    {
        $teachers = User::role('Professor')->get();
        $campuses = Campus::where('active', true)->get();
        return view('courses.create', compact('teachers', 'campuses'));
    }

    public function store(CourseRequest $request)
    {
        $newCourse = [
            'name' => $request->name,
            'campus_id' => $request->campus_id,
            'teacher_id' => $request->teacher_id,
            'semesters' => $request->semesters,
        ];
    
        Course::create($newCourse);

        return redirect()->route('course.index')->with('success', 'Curso criado com sucesso!');
    }

    public function show(string $id)
    {
        $course = Course::with('teacher', 'campus')->findOrFail($id);
        return view('courses.show', compact('course'));
    }

    public function edit(string $id)
    {
        $course = Course::findOrFail($id);
        $teachers = User::role('Professor')->get();
        $campuses = Campus::where('active', true)->get();

        return view('courses.edit', compact('course', 'teachers', 'campuses'));
    }

    public function update(CourseRequest $request, string $id)
    {
        $course = Course::findOrFail($id);

        $newData = [
            'name' => $request->name,
            'campus_id' => $request->campus_id,
            'teacher_id' => $request->teacher_id,
            'semesters' => $request->semesters,
        ];

        $course->update($newData);
    
        return redirect()->route('course.index')->with('success', 'Curso atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $course->update(['active' => false]);

        return redirect()->route('course.index')->with('success', 'Curso apagado com sucesso!');
    }

    public function enroll(string $id)
    {
        $user = Auth::user();
        $course = Course::findOrFail($id);

        // Associar o usuário ao curso
        $user->enrolled()->attach($course);

        // Atribuir o perfil de aluno se ainda não tiver
        if (!$user->hasRole('Aluno') && !$user->hasRole('Super Admin')) {
            $user->assignRole('Aluno');
        }

        return redirect()->route('course.index')->with('success', 'Inscrição no curso realizada com sucesso!');
    }
}
