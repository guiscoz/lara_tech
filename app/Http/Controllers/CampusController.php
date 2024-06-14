<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Requests\CampusRequest;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Auth;

class CampusController extends Controller
{
    public function index()
    {
        $campuses = Campus::with(['city', 'state', 'coordinator'])
            ->where('active', true)
            ->paginate(10);

        return view('campuses.index', compact('campuses'));
    }

    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar estabelecimentos') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $coordinators = User::role('Coordenador')->get();
        $states = State::all();

        return view('campuses.create', compact('coordinators', 'states'));
    }

    public function store(CampusRequest $request)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar estabelecimentos') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $newCampus = [
            'title' => $request->title,
            'address' => $request->address,
            'address_number' => $request->address_number,
            'district' => $request->district,
            'zip_code' => $request->zip_code,
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            'coordinator_id' => $request->coordinator_id,
        ];
    
        Campus::create($newCampus);

        return redirect()->route('campus.index')->with('success', 'Campus criado com sucesso!');
    }

    public function show(string $id)
    {
        $campus = Campus::with('state', 'city', 'coordinator')->findOrFail($id);
        return view('campuses.show', compact('campus'));
    }


    public function edit(string $id)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar estabelecimentos') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $campus = Campus::findOrFail($id);
        $coordinators = User::role('Coordenador')->get();
        $states = State::all();
        $cities = $campus->state->cities;

        return view('campuses.edit', compact('campus', 'coordinators', 'states', 'cities'));
    }

    public function update(CampusRequest $request, string $id)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar estabelecimentos') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }
    
        $campus = Campus::findOrFail($id);

        $newData = [
            'title' => $request->title,
            'address' => $request->address,
            'address_number' => $request->address_number,
            'district' => $request->district,
            'zip_code' => $request->zip_code,
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            'coordinator_id' => $request->coordinator_id,
        ];

        $campus->update($newData);
    
        return redirect()->route('campus.index')->with('success', 'Campus atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        if(!Auth::user()->hasPermissionTo('Gerenciar estabelecimentos') && !Auth::user()->hasRole('Super Admin')){
            throw new UnauthorizedException('403', 'Você não tem permissão');
        }

        $campus = Campus::findOrFail($id);
        $campus->update(['active' => false]);

        return redirect()->route('campus.index')->with('success', 'Campus desativado com sucesso!');
    }
}
