@extends('layouts.app')

@section('title', 'Home | Pixel Pals')

@section('content')

    <div class="home-page">
        {{-- Pixel Pals charity introduction --}}
        <section class="hero-section">
            <div class="hero-content">
                <h1>Welcome to Pixel Pals</h1>
                <p>
                    Bringing young people together through gaming,
                    esports tournaments, and community events.
                </p>
                <p>
                    Pixel Pals is a non-profit organisation that
                    creates opportunities for young people to
                    socialise, compete, and support important causes.
                </p>
            </div>

            <div class="hero-image">
                <img src="{{ asset('images/pixel-pals-esports.png') }}" alt="Esports players competing at a gaming event"
                    class="charity-image">
            </div>
        </section>

        {{-- About the charity --}}
        <section class="content-panel about-section">

            <h2>About Pixel Pals</h2>

            <p>
                Pixel Pals organises gaming and esports events
                to bring young people together while raising
                money for charitable causes.
            </p>

            <p>
                Our fundraising supports youth wellbeing,
                access to technology, and community initiatives.
            </p>

        </section>

        {{-- Upcoming esports events --}}
        <section class="content-panel events-section">

            <h2>Upcoming Events</h2>

            <p>
                Discover upcoming esports tournaments and
                community gaming events organised by Pixel Pals.
            </p>

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

                                <a href="{{ route('registrations.create', $event) }}" class="event-signup-button">
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
            <div class="event-actions">
                <a href="{{ url('/events') }}" class="event-signup-button">
                    View All Events
                </a>
            </div>
        </section>

        {{-- Fundraising information --}}
        <section class="content-panel fundraising-section">

            <h2>Supporting Our Community</h2>

            <p>
                Donations and fundraising events help Pixel Pals
                provide opportunities for young people and
                support important community causes.
            </p>

            <div class="community-actions">
                <a href="{{ route('about') }}" class="event-signup-button">
                    Learn More About Us
                </a>
            </div>
        </section>

    </div>

@endsection
