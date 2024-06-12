@extends('layouts.main')

@section('title', 'Gerenciando usuários')

@section('content')
<div class="container">
    @if($errors)
        @foreach($errors->all() as $error)
            <div class="alert alert-danger mt-4" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <table class="table table-striped table-bordered mt-4 mx-5">
        <thead>
            <th>ID</th>
            <th>Usuário</th>
            <th>Email</th>
            <th>Data de cadastro</th>
            <th>Ações</th>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{$user->id}} </td>
                <td>{{$user->name}} </td>
                <td>{{$user->email}} </td>
                <td>{{$user->created_at != null ? date_format($user->created_at, "s:i:H - d/m/Y") : 'Criado no Seeder' }} </td>
                <td class="d-flex">
                    <a class="btn btn-sm btn-outline-success mx-2" href="/user/{{$user->id}}/roles">Perfis</a>
                    <form action="/user/delete/{{$user->id}}" method="post">
                        @csrf
                        @method('delete')
                        <input class="btn btn-sm btn-outline-danger mx-2" type="submit" value="Remover">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{$users->links()}}

</div>
@endsection