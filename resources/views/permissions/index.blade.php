@extends('layouts.main')

@section('title', 'Gerenciando permissões')

@section('content')
<div class="container">
    <h1>Gerenciando permissões</h1>

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
    
    <table class="table table-striped table-bordered mt-4 mx-5">
        <thead>
            <th>Permissão</th>
            <th>Ações</th>
        </thead>
        <tbody>
            @foreach($permissions as $permission)
            <tr>
                <td>{{$permission->name}}</td>
                <td class="d-flex">
                <a class="btn btn-sm btn-outline-success mx-3" href="{{ route('permission.edit', $permission->id) }}">Editar</a>
                <form action="{{ route('permission.destroy', $permission->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <input class="btn btn-sm btn-outline-danger" type="submit" value="Remover">
                </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $permissions->links() }}

    <div class="d-flex justify-content-end mt-4">
        <a class="btn btn-primary" href="{{ route('permission.create') }}">Cadastrar permissão</a>
    </div>
</div>

@endsection
