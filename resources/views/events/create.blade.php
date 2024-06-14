@extends('layouts.main')

@section('title', 'Criar evento')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Novo evento</div>

                <div class="card-body">
                    @if($errors)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger mt-4" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif

                    <form action="{{ route('event.store') }}" method="post" class="mt-4" autocomplete="off">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name">Nome do Evento:</label>
                                <input type="text" class="form-control" name="name" id="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="campus_id">Campus:</label>
                                <select class="form-control" name="campus_id" id="campus_id" required>
                                    <option value="">Selecione um campus</option>
                                    @foreach($campuses as $campus)
                                        <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="event_date">Data:</label>
                                <input type="date" class="form-control" name="event_date" id="event_date" required>
                            </div>

                            <div class="col-md-6">
                                <label for="event_time">Horário:</label>
                                <input type="time" class="form-control" name="event_time" id="event_time" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary mx-3">Cadastrar evento</button>
                            <a class="btn btn-danger" href="{{ route('event.index') }}">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
