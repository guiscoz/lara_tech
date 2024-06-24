@extends('layouts.main')

@section('title', 'Lista de campus')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Lista de campus</div>

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
                                <th scope="col">Cidade</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Coordenador</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($campuses as $campus)
                                <tr>
                                    <td>{{ $campus->name }}</td>
                                    <td>{{ $campus->city->name }}</td>
                                    <td>{{ $campus->state->abbr }}</td>
                                    <td>{{ $campus->coordinator->name }}</td>
                                    <td>
                                        <a href="{{ route('campus.show', $campus->id) }}" class="btn btn-primary btn-sm">Detalhes</a>
                                        @can('Gerenciar campus')
                                            <a href="{{ route('campus.edit', $campus->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                            <form action="{{ route('campus.destroy', $campus->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">Nenhum campus encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center">
                        {{ $campuses->links() }}
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        @can('Gerenciar campus')
                            <a class="btn btn-primary mx-2" href="{{ route('campus.create') }}">Cadastrar campus</a>
                        @endcan
                        <a class="btn btn-danger" href="{{ route('home') }}">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
