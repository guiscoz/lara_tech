@extends('layouts.main')

@section('title', 'Criar perfil')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Novo perfil</div>

                <div class="card-body">
                    @if($errors)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger mt-4" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif

                    <form action="{{ route('role.store') }}" method="post" class="mt-4" autocomplete="off">
                        @csrf
                        <div class="form-group row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Nome de perfil: </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="name"
                                    placeholder="Insira o nome de perfil" name="name"
                                    value="{{ old('name') }}"
                                >
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary mx-3">Cadastrar perfil</button>
                            <a class="btn btn-danger" href="{{ route('role.index') }}">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
