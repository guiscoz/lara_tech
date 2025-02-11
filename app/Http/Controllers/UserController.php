<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('id', '!=', 1)->paginate(10);
        return view('users.index', compact('users'));
    }

    public function roles($user)
    {
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
        $user = User::where('id', $id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'Usuário apagado com sucesso!');
    }
}
