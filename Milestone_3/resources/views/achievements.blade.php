@extends('layouts.app')

@section('title', 'Achievements - Pixel Pals')

@section('content')

<section class="achievements-page">

    <h1>Our Achievements</h1>

    <p class="achievements-intro">
        At Pixel Pals, we are working towards making esports
        more accessible and creating opportunities for young
        people to connect through gaming.
    </p>

    <div class="achievements-grid">

        <section class="content-panel">
            <h2>Community Gaming Events</h2>

            <p>
                We organise gaming events and tournaments that
                encourage teamwork, friendly competition and
                community participation.
            </p>
        </section>

        <section class="content-panel">
            <h2>Supporting Young Gamers</h2>

            <p>
                Our goal is to help young people access gaming
                opportunities, including those who may not have
                suitable equipment or technology.
            </p>
        </section>

        <section class="content-panel">
            <h2>Building Connections</h2>

            <p>
                Pixel Pals encourages positive social experiences
                by bringing young people together through shared
                interests in gaming and esports.
            </p>
        </section>

        <section class="content-panel">
            <h2>Growing Our Community</h2>

            <p>
                We aim to develop relationships with volunteers,
                supporters and organisations that share our
                commitment to accessible gaming.
            </p>
        </section>

    </div>

    <div class="achievements-footer">
        <p>
            Our journey is just beginning. As Pixel Pals grows,
            we look forward to sharing completed milestones and
            the positive impact of our community.
        </p>

        <a href="{{ url('/events') }}" class="event-signup-button">
            View Upcoming Events
        </a>
    </div>

</section>

@endsection
