@extends('layouts.main')

@section('title', 'Lista de eventos')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Lista de eventos</div>

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
                                <th scope="col">Data</th>
                                <th scope="col">Horário</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($events as $event)
                                <tr>
                                    <td>{{ $event->name }}</td>
                                    <td>{{ $event->campus->name }}</td>
                                    <td>{{ date('d/m/Y', strtotime($event->event_date)) }}</td>
                                    <td>{{ date('H:i', strtotime($event->event_time)) }}</td>
                                    <td>
                                        <a href="{{ route('event.show', $event->id) }}" class="btn btn-primary btn-sm">Detalhes</a>
                                        @can('Gerenciar eventos')
                                            <a href="{{ route('event.edit', $event->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                            <form action="{{ route('event.destroy', $event->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">Nenhum evento encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center">
                        {{ $events->links() }}
                    </div>

                    
                    <div class="d-flex justify-content-end mt-4">
                        @can('Gerenciar eventos')
                            <a class="btn btn-primary mx-2" href="{{ route('event.create') }}">Cadastrar evento</a>
                        @endcan
                        <a class="btn btn-danger" href="{{ route('home') }}">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
