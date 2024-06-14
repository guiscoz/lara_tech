<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RolePermissionRequest;

class PermissionController extends Controller
{
    public function index()
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar permissões') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $permissions = Permission::paginate(10);

        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar permissões') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        return view('permissions.create');
    }

    public function store(RolePermissionRequest $request)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar permissões') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $permission = new Permission();
        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('permission.index');
    }

    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar permissões') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $permission = Permission::where('id', $id)->first();

        return view('permissions.edit', ['permission' => $permission, 'id' => $permission->id]);
    }

    public function update(RolePermissionRequest $request, $id)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar permissões') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $permission = Permission::where('id', $id)->first();
        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('permission.index');
    }

    public function destroy($id)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar permissões') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $permission = Permission::where('id', $id);
        $permission->delete();

        return redirect()->route('permission.index')->with('success', 'Permissão apagada com sucesso!');
    }
}
