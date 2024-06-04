@extends('layouts.main')

@section('title', 'LaraTech - Escola técnica de tecnologia')

@section('content')
    <div class="container">
        @auth
        <div class="card mt-3">
                <div class="card-body">
                    <p class="card-text">Autenticado</p>
                </div>
            </div>
        @endauth
        @guest
            <div class="card mt-3">
                <div class="card-body">
                    <p class="card-text">Hello world</p>
                </div>
            </div>
        @endguest
    </div>
@endsection
