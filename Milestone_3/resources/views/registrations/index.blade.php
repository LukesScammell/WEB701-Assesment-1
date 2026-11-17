@extends('layouts.app')

@section('title', 'My Teams | Pixel Pals')

@section('content')

<div class="events-page my-teams-page">

    <section class="events-section">

        <h1>My Teams</h1>

        <p class="my-teams-intro">
            View and manage your registered Pixel Pals tournament teams.
        </p>

        @if (session('success'))
            <div class="registration-success" role="status">
                {{ session('success') }}
            </div>
        @endif

        <div class="my-teams-summary">
            <strong>Registered Teams:</strong> {{ $registrations->count() }}
            <a href="{{ url('/events') }}" class="event-signup-button">
                Browse Events
            </a>
        </div>

        <div class="events-grid">

            @forelse ($registrations as $registration)

                @php
                    $event = $registration->event;

                    $eventStart = Carbon\Carbon::parse($event->event_date)
                        ->setTimeFromTimeString($event->event_time);

                    $canEdit = $eventStart->isFuture();
                @endphp

                <article class="event-card my-team-card">

                    <h2>{{ $registration->team_name }}</h2>

                    <p><strong>Event:</strong> {{ $event->name }}</p>
                    <p><strong>Game:</strong> {{ $event->game }}</p>
                    <p><strong>Date:</strong> {{ $eventStart->format('d M Y') }}</p>
                    <p><strong>Time:</strong> {{ $eventStart->format('H:i') }}</p>
                    <p><strong>Contact:</strong> {{ $registration->contact_name }}</p>
                    <p><strong>Email:</strong> {{ $registration->contact_email }}</p>

                    <div class="my-team-players">
                        <h3>Registered Players</h3>

                        <ul>
                            @forelse ($registration->players as $player)
                                <li>{{ $player->username }}</li>
                            @empty
                                <li>No player usernames recorded.</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="event-actions">

                        @if ($canEdit)
                            <a href="{{ route('registrations.edit', $registration) }}"
                               class="event-signup-button">
                                Edit Team
                            </a>
                        @else
                            <span class="event-full-label">
                                Editing Closed
                            </span>
                        @endif

                    </div>

                </article>

            @empty

                <div class="my-teams-empty">
                    <h2>No Teams Registered</h2>
                    <p>
                        You haven't registered any teams yet.
                        Browse upcoming events to get started.
                    </p>
                    <a href="{{ url('/events') }}" class="event-signup-button">
                        Browse Events
                    </a>
                </div>

            @endforelse

        </div>

    </section>

</div>

@endsection
