<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\User;
use App\Models\State;
use App\Http\Requests\CampusRequest;

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
        $coordinators = User::role('Coordenador')->get();
        $states = State::all();

        return view('campuses.create', compact('coordinators', 'states'));
    }

    public function store(CampusRequest $request)
    {
        $newCampus = [
            'name' => $request->name,
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
        $campus = Campus::findOrFail($id);
        $coordinators = User::role('Coordenador')->get();
        $states = State::all();
        $cities = $campus->state->cities;

        return view('campuses.edit', compact('campus', 'coordinators', 'states', 'cities'));
    }

    public function update(CampusRequest $request, string $id)
    {    
        $campus = Campus::findOrFail($id);

        $newData = [
            'name' => $request->name,
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
        $campus = Campus::findOrFail($id);
        $campus->update(['active' => false]);

        return redirect()->route('campus.index')->with('success', 'Campus apagado com sucesso!');
    }
}
