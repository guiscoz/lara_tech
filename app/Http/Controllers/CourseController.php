<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\Campus;
use App\Models\User;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['campus', 'teacher'])->where('active', true)->paginate(10);
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar cursos') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $teachers = User::role('Professor')->get();
        $campuses = Campus::where('active', true)->get();
        return view('courses.create', compact('teachers', 'campuses'));
    }

    public function store(CourseRequest $request)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar eventos') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

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
        if(!Auth::user()->hasPermissionTo('Gerenciar eventos') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $course = Course::findOrFail($id);
        $teachers = User::role('Professor')->get();
        $campuses = Campus::where('active', true)->get();

        return view('courses.edit', compact('course', 'teachers', 'campuses'));
    }

    public function update(CourseRequest $request, string $id)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar eventos') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

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
        if(!Auth::user()->hasPermissionTo('Gerenciar eventos') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $course = Course::findOrFail($id);
        $course->update(['active' => false]);

        return redirect()->route('course.index')->with('success', 'Curso apagado com sucesso!');
    }
}
