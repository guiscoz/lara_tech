@extends('layouts.main')

@section('title', 'Gerenciando perfis')

@section('content')
<div class="container">
    <h1>Gerenciando perfis</h1>
    <table class="table table-striped table-bordered mt-4 mx-5">
        <thead>
            <th>ID</th>
            <th>Perfil</th>
            <th>Ações</th>
        </thead>
        <tbody>
            @foreach($roles as $key => $role)
            <tr>
                @if($key > 0)
                <td>{{$role->id-1}} </td>
                <td>{{$role->name}} </td>
                <td class="d-flex">
                    <a class="btn btn-sm btn-outline-success mx-2" href="{{ route('role.edit', $role->id) }}">Editar</a>
                    <a class="btn btn-sm btn-outline-info mx-2" href="{{ route('role.permissions', $role->id) }}">Permissões</a>
                    <form action="{{ route('role.destroy', $role->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <input class="btn btn-sm btn-outline-danger mx-2" type="submit" value="Remover">
                    </form>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-end mt-4">
        <a class="btn btn-primary" href="{{ route('role.create') }}">Cadastrar perfil</a>
    </div>
</div>
@endsection
