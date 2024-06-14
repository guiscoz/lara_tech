@extends('layouts.main')

@section('title', 'LaraTech - Escola técnica de tecnologia')

@section('content')
    <div class="container">
        <div class="card mt-3">
            @auth
                <div class="card-body">
                    <p class="card-text">Autenticado</p>
                </div>
            @endauth
            @guest
                <div class="card-body">
                    <p class="card-text">Hello world</p>
                </div>
            @endguest
            <div class="card-body">
                <a class="btn btn-primary" href="{{ route('campus.index') }}">Visualizar campus</a>
            </div>
        </div>
    </div>
@endsection
