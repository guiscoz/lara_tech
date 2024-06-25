@extends('layouts.main')

@section('title', 'Detalhes do Curso')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $course->name }}</div>

                <div class="card-body">
                    <p><strong>Campus:</strong> {{ $course->campus->name }}</p>
                    <p><strong>Professor:</strong> {{ $course->teacher->name }}</p>
                    <p><strong>Semestres:</strong> {{ $course->semesters }}</p>

                    <h4>Alunos Matriculados:</h4>
                    @if($course->students->isEmpty())
                        <p>Nenhum aluno matriculado.</p>
                    @else
                        <ul>
                            @foreach($course->students as $student)
                                <li>{{ $student->name }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="d-flex justify-content-end mt-4">
                        <a class="btn btn-primary mx-2" href="{{ route('course.index') }}">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
