@extends('layouts.main')

@section('title', 'Lista de cursos')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Lista de cursos</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger mt-4" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Campus</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($courses as $course)
                                <tr>
                                    <td>{{ $course->name }}</td>
                                    <td>{{ $course->campus->name }}</td>
                                    <td>
                                        <a href="{{ route('course.show', $course->id) }}" class="btn btn-primary btn-sm">Detalhes</a>
                                        @can('Gerenciar cursos')
                                            <a href="{{ route('course.edit', $course->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                            <form action="{{ route('course.destroy', $course->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">Nenhum curso encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center">
                        {{ $courses->links() }}
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        @can('Gerenciar cursos')
                            <a class="btn btn-primary mx-2" href="{{ route('course.create') }}">Cadastrar curso</a>
                        @endcan
                        <a class="btn btn-danger" href="{{ route('home') }}">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
