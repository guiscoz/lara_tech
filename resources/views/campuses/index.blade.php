@extends('layouts.main')

@section('title', 'Lista de Campus')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Lista de Campus</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Título</th>
                                <th scope="col">Cidade</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Coordenador</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($campuses as $campus)
                                <tr>
                                    <td>{{ $campus->title }}</td>
                                    <td>{{ $campus->city->name }}</td>
                                    <td>{{ $campus->state->abbr }}</td>
                                    <td>{{ $campus->coordinator->name }}</td>
                                    <td>
                                        <a href="{{ route('campus.show', $campus->id) }}" class="btn btn-primary btn-sm">Detalhes</a>
                                        @can('Gerenciar estabelecimentos')
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
