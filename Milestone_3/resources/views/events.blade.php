@extends('layouts.app')

@section('title', 'Events | Pixel Pals')

@section('content')

<div class="events-page">
    <section class="events-section">
        <h1>Events</h1>
        <div class="events-grid">
            @forelse ($events as $event)
                <article class="event-card">
                    <h2>{{ $event->name }}</h2>
                    <p>
                        <strong>Date:</strong>
                        {{ $event->event_date->format('l, d M Y') }}
                    </p>
                    <p>
                        <strong>Time:</strong>
                        {{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}
                    </p>
                    <p>
                        <strong>Venue:</strong>
                        {{ $event->location }}
                    </p>
                    <p>
                        <strong>Game:</strong>
                        {{ $event->game }}
                    </p>
                    <p>
                        <strong>Teams Registered:</strong>
                        {{ $event->registrations_count }} out of {{ $event->max_teams }}
                    </p>
                    <p>
                        <strong>Players Per Team:</strong>
                        {{ $event->team_size }}
                    </p>

                    <div class="event-actions">
                        @if ($event->registrations_count < $event->max_teams)
                            <a href="{{ route('registrations.create', $event) }}"
                               class="event-signup-button">
                                Sign Up
                            </a>
                        @else
                            <span class="event-full-label">
                                Event Full
                            </span>
                        @endif
                    </div>
                </article>
            @empty
                <p class="placeholder-text">
                    There are currently no upcoming events.
                </p>
            @endforelse
        </div>
    </section>
</div>

@endsection
