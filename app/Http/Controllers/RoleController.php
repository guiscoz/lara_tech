<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RolePermissionRequest;

class RoleController extends Controller
{
    public function index()
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar permissões') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $roles = Role::paginate(10);

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar permissões') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        return view('roles.create');
    }

    public function store(RolePermissionRequest $request)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar permissões') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $role = new Role();
        $role->name = $request->name;
        $role->save();

        return redirect()->route('role.index');
    }

    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar permissões') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $role = Role::where('id', $id)->first();

        return view('roles.edit', ['role' => $role, 'id' => $role->id]);
    }

    public function update(RolePermissionRequest $request, $id)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar permissões') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $role = Role::where('id', $id)->first();
        $role->name = $request->name;
        $role->save();

        return redirect()->route('role.index');
    }

    public function destroy($id)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar permissões') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $role = Role::where('id', $id);
        $role->delete();

        return redirect()->route('role.index')->with('success', 'Perfil apagado com sucesso!');
    }

    public function permissions($role)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar permissões') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $role = Role::where('id', $role)->first();

        $permissions = Permission::all();

        foreach($permissions as $permission) {
            if ($role->hasPermissionTo($permission->name)) {
                $permission->can = true;
            } else {
                $permission->can = false;
            }
        }

        return view('roles.permissions', compact('role', 'permissions'));
    }

    public function permissionsSync(Request $request, $role)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar permissões') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $permissionsRequest = $request->except(['_token', '_method']);

        foreach($permissionsRequest as $key => $value) {
            $permissions[] = Permission::where('id', $key)->first();
        }

        $role = Role::where('id', $role)->first();
        if(!empty($permissions)){
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions(null);
        }

        return redirect()->route('role.permissions', ['role' => $role->id]);
    }
}
