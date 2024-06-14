@extends('layouts.main')

@section('title', 'Detalhes do campus')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $campus->title }}</div>

                <div class="card-body">
                    <p><strong>Endereço:</strong> {{ $campus->address }}, {{ $campus->address_number }}</p>
                    <p><strong>Bairro:</strong> {{ $campus->district }}</p>
                    <p><strong>CEP:</strong> {{ $campus->zip_code }}</p>
                    <p><strong>Estado:</strong> {{ $campus->state->name }}</p>
                    <p><strong>Cidade:</strong> {{ $campus->city->name }}</p>
                    <p><strong>Coordenador:</strong> {{ $campus->coordinator->name }}</p>
                    
                    <!-- Aqui você pode adicionar mais detalhes conforme necessário -->
                </div>

                <div class="d-flex justify-content-center mb-3">
                    <a class="btn btn-danger" href="{{ route('campus.index') }}">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
