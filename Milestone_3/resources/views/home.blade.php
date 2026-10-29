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
            <img
                src="{{ asset('images/pixel-pals-esports.png') }}"
                alt="Esports players competing at a gaming event"
                class="charity-image"
            >
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

        <div class="events-container">
            <p class="placeholder-text">
                Upcoming events will appear here.
            </p>
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

        <div class="fundraising-container">
            <h3>Our Fundraising Progress</h3>

            <p class="placeholder-text">
                Fundraising information will appear here.
            </p>
        </div>

    </section>

</div>

@endsection
