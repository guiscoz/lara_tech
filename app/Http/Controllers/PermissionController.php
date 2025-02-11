<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use App\Http\Requests\RolePermissionRequest;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::paginate(10);

        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(RolePermissionRequest $request)
    {
        $permission = new Permission();
        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('permission.index');
    }

    public function edit($id)
    {
        $permission = Permission::where('id', $id)->first();

        return view('permissions.edit', ['permission' => $permission, 'id' => $permission->id]);
    }

    public function update(RolePermissionRequest $request, $id)
    {
        $permission = Permission::where('id', $id)->first();
        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('permission.index');
    }

    public function destroy($id)
    {
        $permission = Permission::where('id', $id);
        $permission->delete();

        return redirect()->route('permission.index')->with('success', 'Permissão apagada com sucesso!');
    }
}
