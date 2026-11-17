<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    // Display all events for administrators
    public function index(): View
    {
        $events = Event::withCount('registrations')
            ->orderBy('event_date', 'asc')
            ->orderBy('event_time', 'asc')
            ->get();

        return view('admin.events.index', [
            'events' => $events
        ]);
    }

    // Display the create event form
    public function create(): View
    {
        return view('admin.events.create');
    }

    // Save a new event to the database
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'event_date' => ['required', 'date', 'after_or_equal:today'],
            'event_time' => ['required', 'date_format:H:i'],
            'location' => ['required', 'string', 'max:255'],
            'game' => ['required', 'string', 'max:255'],
            'max_teams' => ['required', 'integer', 'min:1'],
            'team_size' => ['required', 'integer', 'min:1', 'max:100']
        ]);
        
        Event::create($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    // Display the edit event form
    public function edit(Event $event): View
    {
        return view('admin.events.edit', [
            'event' => $event
        ]);
    }

    // Update an existing event
    public function update(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'event_date' => ['required', 'date'],
            'event_time' => ['required', 'date_format:H:i'],
            'location' => ['required', 'string', 'max:255'],
            'game' => ['required', 'string', 'max:255'],
            'max_teams' => [
                'required',
                'integer',
                'min:1',
                'gte:' . $event->registrations()->count()
            ],
            'team_size' => [
                Rule::requiredIf(! $event->registrations()->exists()),
                'integer',
                'min:1',
                'max:100',
            ],
        ]);

        // Prevent changing team size if teams are already registered
        if ($event->registrations()->exists()) {
            unset($validated['team_size']);
        }

        $event->update($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }
    // Delete an event if no teams are registered
    public function destroy(Event $event): RedirectResponse
    {
        // Prevent deleting events with existing registrations
        if ($event->registrations()->exists()) {
            return redirect()
                ->route('admin.events.index')
                ->with('error', 'This event cannot be deleted because teams are registered.');
        }
        

        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }
}
