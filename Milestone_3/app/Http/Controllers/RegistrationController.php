<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    // Display all teams registered by the logged-in user
    public function index(Request $request): View
    {
        $registrations = Registration::with(['event', 'players'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return view('registrations.index', compact('registrations'));
    }

    // Store a new team registration
    public function store(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'team_name' => ['required', 'string', 'max:255'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'players' => ['required', 'array'],
            'players.*' => ['required', 'string', 'max:100', 'distinct'],
        ]);

        DB::transaction(function () use ($event, $validated, $request) {
            $event = Event::query()
                ->whereKey($event->id)
                ->lockForUpdate()
                ->firstOrFail();

            $eventStart = Carbon::parse($event->event_date)
                 ->setTimeFromTimeString($event->event_time);

            if ($eventStart->isPast()) {
                throw ValidationException::withMessages([
                    'team_name' => 'Registration for this event has closed.',
                ]);
            }

            if ($event->registrations()->count() >= $event->max_teams) {
                throw ValidationException::withMessages([
                    'team_name' => 'This event is fully booked.',
                ]);
            }

            if (count($validated['players']) !== (int) $event->team_size) {
                throw ValidationException::withMessages([
                    'players' => 'This event requires exactly ' . $event->team_size . ' players.',
                ]);
            }

            $registration = Registration::create([
                'event_id' => $event->id,
                'user_id' => $request->user()->id,
                'team_name' => $validated['team_name'],
                'contact_name' => $validated['contact_name'],
                'contact_email' => $validated['contact_email'],
            ]);

            foreach ($validated['players'] as $username) {
                $registration->players()->create([
                    'username' => $username,
                ]);
            }
        });

        return redirect()
            ->route('registrations.index')
            ->with('success', 'Your team has been registered successfully!');
    }

    // Display the edit form for an existing team
    public function edit(Request $request, Registration $registration): View
    {
        abort_unless($registration->user_id === $request->user()->id, 403);

        $registration->load(['event', 'players']);

        $eventStart = Carbon::parse($registration->event->event_date)
            ->setTimeFromTimeString($registration->event->event_time);

        if ($eventStart->isPast()) {
            abort(403, 'This event has already started. Team editing is closed.');
        }

        return view('registrations.edit', compact('registration'));
    }

    // Save updated team details and player usernames
    public function update(Request $request, Registration $registration): RedirectResponse
    {
        abort_unless($registration->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'team_name' => ['required', 'string', 'max:255'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'players' => ['required', 'array'],
            'players.*' => ['required', 'string', 'max:100', 'distinct'],
        ]);

        DB::transaction(function () use ($registration, $validated, $request) {
            $event = Event::query()
                ->whereKey($registration->event_id)
                ->lockForUpdate()
                ->firstOrFail();

            $eventStart = Carbon::parse(
                $event->getRawOriginal('event_date') . ' ' . $event->event_time
            );

            if ($eventStart->isPast()) {
                throw ValidationException::withMessages([
                    'team_name' => 'This event has started. Team editing is closed.',
                ]);
            }

            if (count($validated['players']) !== (int) $event->team_size) {
                throw ValidationException::withMessages([
                    'players' => 'This event requires exactly ' . $event->team_size . ' players.',
                ]);
            }

            $registration->update([
                'team_name' => $validated['team_name'],
                'contact_name' => $validated['contact_name'],
                'contact_email' => $validated['contact_email'],
            ]);

            $registration->players()->delete();

            foreach ($validated['players'] as $username) {
                $registration->players()->create([
                    'username' => $username,
                ]);
            }
        });

        return redirect()
            ->route('registrations.index')
            ->with('success', 'Your team information has been updated successfully!');
    }
}
