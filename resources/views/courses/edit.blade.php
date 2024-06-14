@extends('layouts.main')

@section('title', 'Editar curso')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar curso</div>

                <div class="card-body">
                    @if($errors)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger mt-4" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif

                    <form action="{{ route('course.update', $course->id) }}" method="post" class="mt-4" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <label for="name" class="form-label">Nome:</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ $course->name }}" required>
                            </div>

                            <div class="col-md-3">
                                <label for="semesters" class="form-label">Número de semestres:</label>
                                <input type="number" class="form-control" name="semesters" id="semesters" value="{{ $course->semesters }}" required>
                            </div>                            
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="teacher_id" class="form-label">Professor:</label>
                                <select class="form-select" name="teacher_id" id="teacher_id" required>
                                    <option value="">Selecione um professor</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ $course->teacher_id == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="campus_id" class="form-label">Campus:</label>
                                <select class="form-select" name="campus_id" id="campus_id" required>
                                    <option value="">Selecione um campus</option>
                                    @foreach($campuses as $campus)
                                        <option value="{{ $campus->id }}" {{ $course->campus_id == $campus->id ? 'selected' : '' }}>
                                            {{ $campus->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary mx-3">Atualizar curso</button>
                            <a class="btn btn-danger" href="{{ route('course.index') }}">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
