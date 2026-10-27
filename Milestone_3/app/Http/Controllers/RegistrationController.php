<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    public function store(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'team_name' => ['required', 'string', 'max:255'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
        ]);

        DB::transaction(function () use ($event, $validated) {
            $event = Event::query()
                ->whereKey($event->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($event->event_date->isBefore(today())) {
                throw ValidationException::withMessages([
                    'team_name' => 'Registration for this event has closed.',
                ]);
            }

            if ($event->registrations()->count() >= $event->max_teams) {
                throw ValidationException::withMessages([
                    'team_name' => 'This event is fully booked.',
                ]);
            }

            Registration::create([
                'event_id' => $event->id,
                ...$validated,
            ]);
        });

        return redirect()
            ->route('registrations.create', $event)
            ->with('success', 'Your team has been registered successfully!');
    }
}
