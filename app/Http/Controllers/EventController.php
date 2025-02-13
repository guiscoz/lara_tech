<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\Campus;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['campus'])->where('active', true)->paginate(10);
        return view('events.index', compact('events'));
    }

    public function create()
    {
        $campuses = Campus::where('active', true)->get();
        return view('events.create', compact('campuses'));
    }

    public function store(EventRequest $request)
    {
        $newEvent = [
            'name' => $request->name,
            'campus_id' => $request->campus_id,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'creator_id' => Auth::id(),
        ];
    
        Event::create($newEvent);

        return redirect()->route('event.index')->with('success', 'Campus criado com sucesso!');
    }

    public function show(string $id)
    {
        $event = Event::with('campus', 'creator')->findOrFail($id);
        return view('events.show', compact('event'));
    }

    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        $campuses = Campus::where('active', true)->get();
        return view('events.edit', compact('event', 'campuses'));
    }

    public function update(EventRequest $request, string $id)
    {
        $event = Event::findOrFail($id);

        $newData = [
            'name' => $request->name,
            'campus_id' => $request->campus_id,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'creator_id' => Auth::id(),
        ];

        $event->update($newData);
        return redirect()->route('event.index')->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        $event->update(['active' => false]);

        return redirect()->route('event.index')->with('success', 'Evento apagado com sucesso!');
    }
}
