<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\UnauthorizedException;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar permissões') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $users = User::where('id', '!=', 1)->paginate(10);
        return view('users.index', compact('users'));
    }

    public function roles($user)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar permissões') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $user = User::where('id', $user)->first();

        $roles = Role::all();

        foreach($roles as $role) {
            if ($user->hasRole($role->name)) {
                $role->can = true;
            } else {
                $role->can = false;
            }
        }

        return view('users.roles', compact('user', 'roles'));
    }

    public function rolesSync(Request $request, $id)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar permissões') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $rolesRequest = $request->except(['_token', '_method']);

        foreach($rolesRequest as $key => $value) {
            $roles[] = Role::where('id', $key)->first();
        }

        $user = User::where('id', $id)->first();
        if(!empty($roles)){
            $user->syncRoles($roles);
        } else {
            $user->syncRoles(null);
        }

        return redirect()->route('user.roles', ['id' => $user->id]);
    }

    public function destroy($id)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar permissões') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $user = User::where('id', $id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'Usuário apagado com sucesso!');
    }
}
