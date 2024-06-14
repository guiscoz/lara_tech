@extends('layouts.main')

@section('title', 'Detalhes do evento')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $event->name }}</div>

                <div class="card-body">
                    <p><strong>Campus:</strong> {{ $event->campus->title }}</p>
                    <p><strong>Criador:</strong> {{ $event->creator->name }}</p>
                    <p><strong>Data:</strong> {{ $event->event_date }}</p>
                    <p><strong>Horário:</strong> {{ $event->event_time }}</p>
                </div>

                <div class="d-flex justify-content-center mb-3">
                    <a class="btn btn-danger" href="{{ route('event.index') }}">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
