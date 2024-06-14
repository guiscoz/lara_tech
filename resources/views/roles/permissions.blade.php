@extends('layouts.main')

@section('title', 'Perfis do usuário')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Permissões de {{ $role->name }}</div>

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

                    <form action="/role/{{ $role->id }}/permissions/sync" method="post" class="mt-4" autocomplete="off">
                        @csrf
                        @method('PUT')

                        @foreach($permissions as $permission)
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="{{ $permission->id }}" name="{{ $permission->id }}" {{ ($permission->can == '1' ? 'checked' : '') }}>
                                <label class="custom-control-label" for="{{ $permission->id }}">{{ $permission->name }}</label>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary mx-3">Sincronizar perfil</button>
                            <a class="btn btn-danger" href="{{ route('role.index') }}">Cancelar</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
