<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{

public function index()
{
    $userRole = Auth::user()->role;

    $events = Event::all()->map(function ($event) {
        $start = Carbon::parse($event->start);
        $end = Carbon::parse($event->end);

        $isAllDay = $start->format('H:i:s') === '00:00:00' && $end->format('H:i:s') === '00:00:00';

        return [
            'id'     => $event->id,
            'title'  => $event->title,
            'start'  => $event->start,
            'end'    => $event->end,
            'color'  => $event->color,
            'allDay' => $isAllDay,
        ];
    });

    return view('events.index', compact('events', 'userRole')); // 👈 pass userRole to the Blade
}


    public function fetchEvents()
    {
        $userRole = Auth::user()->role;
        $events = Event::all()->map(function ($event) {
            return [
                'id'     => $event->id,
                'title'  => $event->title,
                'description' => $event->description,
                'start'  => $event->start,
                'end'    => $event->end,
                'color'  => $event->color,
            ];
        });

        return response()->json($events);
    }

    public function store(Request $request)
    {
        // You can debug like this to see submitted data:
        // dd($request->all());

        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'start' => $request->start_date,
            'end' => $request->end_date,
            'color' => $request->color,
        ]);

        return redirect()->route('events.index')->with('success', 'Event added successfully!');
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'color' => 'nullable|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $event->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'color' => $validated['color'],
            'start' => $validated['start_date'],
            'end' => $validated['end_date'],
        ]);

    return redirect()->route('events.index')->with('success', 'Event added successfully!');

    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['success' => true]);
    }
}
