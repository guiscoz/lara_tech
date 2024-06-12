<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Auth;

class CampusController extends Controller
{
    public function index()
    {
        $campuses = Campus::paginate(10);

        return view('campuses.index', compact('campuses'));
    }

    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar estabelecimentos') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }
    }

    public function store(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar estabelecimentos') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }
    }

    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar estabelecimentos') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }
    }

    public function update(Request $request, string $id)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar estabelecimentos') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }
    }

    public function destroy(string $id)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar estabelecimentos') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        Campus::findOrFail($id)->delete();
        return redirect()->route('campuses');
    }
}
