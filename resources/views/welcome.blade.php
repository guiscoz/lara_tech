@extends('layouts.main')

@section('title', 'LaraTech - Escola técnica de tecnologia')

@section('content')
    <div class="container">
        <div class="card mt-3">
            <div class="card-header">
                Sobre a LaraTech
            </div>

            <div class="card-body">
                <h5 class="card-title">Quem Somos</h5>
                <p class="card-text">A LaraTech é uma escola técnica de tecnologia comprometida em proporcionar educação de qualidade e preparar os estudantes para o mercado de trabalho. Laratech tem escolas espalhadas pelo Brasil inteiro.</p>
                <a href="{{ route('campus.index') }}" class="btn btn-primary">Ver nossos campus</a>
            </div>

            <div class="card-body">
                <h5 class="card-title">Participe dos nossos eventos</h5>
                <p class="card-text">Confira os próximos eventos e atividades da LaraTech. Não perca a chance de expandir seus conhecimentos e networking!</p>
                <a href="{{ route('event.index') }}" class="btn btn-primary">Ver agenda de eventos</a>
            </div>

            <div class="card-body">
                <h5 class="card-title">Interessado em estudar na LaraTech?</h5>
                <p class="card-text">Descubra nossos cursos e comece sua jornada educacional hoje mesmo.</p>
                <a href="{{ route('course.index') }}" class="btn btn-primary">Conheça nossos cursos</a>
            </div>
        </div>
    </div>
@endsection
