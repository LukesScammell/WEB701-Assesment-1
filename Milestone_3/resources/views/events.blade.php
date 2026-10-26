
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
                        {{ substr($event->event_time, 0, 5) }}
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
                        <strong>Teams:</strong>
                        Capacity: {{ $event->max_teams }}
                    </p>

                    <div class="event-actions">
                        <span class="event-action-placeholder">
                            Sign Up
                        </span>
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
