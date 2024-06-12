@extends('layouts.main')

@section('title', 'Perfis do usuário')
    
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Perfis de {{ $user->name }}</div>

                <div class="card-body">
                    @if($errors)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger mt-4" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif

                    <form action="/user/{{ $user->id }}/roles/sync" method="post" class="mt-4" autocomplete="off">
                        @csrf
                        @method('PUT')

                        @foreach($roles as $key => $role)
                            @if($key > 0)
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="{{ $role->id }}" name="{{ $role->id }}" {{ ($role->can == '1' ? 'checked' : '') }}>
                                    <label class="custom-control-label" for="{{ $role->id }}">{{ $role->name }}</label>
                                </div>
                            @endif
                        @endforeach

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary mx-3">Sincronizar usuário</button>
                            <a class="btn btn-danger" href="{{ route('users') }}">Cancelar</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection