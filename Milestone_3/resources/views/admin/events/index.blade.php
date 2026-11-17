@extends('layouts.app')

@section('title', 'Manage Events | Pixel Pals')

@section('content')

<div class="events-page">

    <section class="events-section">

        <h1>Manage Events</h1>
        @if (session('success'))
            <div class="alert-success" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert-error" role="alert">
                {{ session('error') }}
            </div>
        @endif

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
                        <strong>Registered Teams:</strong>
                        {{ $event->registrations_count }}
                        / {{ $event->max_teams }}
                    </p>

                    <div class="event-actions">
                        <a href="{{ route('admin.events.edit', $event) }}" class="event-signup-button">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.events.destroy', $event) }}"
                            onsubmit="return confirm('Are you sure you want to delete this event?');">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="event-signup-button">
                                Delete
                            </button>
                        </form>

                    </div>

                </article>

            @empty

                <p class="placeholder-text">
                    No events have been created yet.
                </p>

            @endforelse

        </div>

    </section>

</div>

@endsection
