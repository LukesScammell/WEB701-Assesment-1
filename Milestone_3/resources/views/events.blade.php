
@extends('layouts.app')

@section('title', 'Events | Pixel Pals')

@section('content')

<div class="events-page">

    <section class="content-panel events-introduction">
        <h1>Pixel Pals Events</h1>

        <p>
            Explore upcoming gaming tournaments, esports
            competitions, and community events organised
            by Pixel Pals.
        </p>
    </section>

    <section class="content-panel upcoming-events">

        <h2>Upcoming Events</h2>

        <div class="events-list">

            @forelse ($events as $event)

                <article class="event-card">

                    <h3>{{ $event->name }}</h3>

                    <p>{{ $event->description }}</p>

                    <p>
                        <strong>Game:</strong>
                        {{ $event->game }}
                    </p>

                    <p>
                        <strong>Date:</strong>
                        {{ $event->event_date->format('d M Y') }}
                    </p>

                    <p>
                        <strong>Time:</strong>
                        {{ substr($event->event_time, 0, 5) }}
                    </p>

                    <p>
                        <strong>Location:</strong>
                        {{ $event->location }}
                    </p>

                    <p>
                        <strong>Maximum Teams:</strong>
                        {{ $event->max_teams }}
                    </p>

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
