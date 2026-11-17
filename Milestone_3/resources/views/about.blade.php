@extends('layouts.app')

@section('title', 'About Us | Pixel Pals')

@section('content')

<section class="about-page">

    <h1>About Pixel Pals</h1>

    <p>
        Pixel Pals is a non-profit esports charity focused on
        bringing young people together through gaming, teamwork
        and community events.
    </p>

    {{-- Our Mission --}}
    <section class="content-panel">

        <h2>Our Mission</h2>

        <p>
            Our mission is to make gaming more accessible for young
            people by providing opportunities to participate in
            esports events, connect with others and develop new skills.
        </p>

    </section>

    {{-- What We Do --}}
    <section class="content-panel">

        <h2>What We Do</h2>

        <p>
            Pixel Pals organises community gaming events and
            tournaments, supports access to gaming equipment and
            encourages positive experiences through esports.
        </p>

    </section>

    {{-- Who We Support --}}
    <section class="content-panel">

        <h2>Who We Support</h2>

        <p>
            We aim to support young gamers, students who may not
            have access to suitable technology, and young people
            who benefit from social connection and community activities.
        </p>

    </section>

    {{-- Get Involved --}}
    <section class="content-panel">

        <h2>Get Involved</h2>

        <p>
            Whether you want to participate in an event, volunteer
            or support our charity, there are different ways to
            get involved with Pixel Pals.
        </p>

    </section>

    {{-- Live fundraising progress --}}
    <section class="content-panel fundraising-progress-section">

        <h2>Our Fundraising Progress</h2>

        <p>
            Every Pixel Token donated helps support the Pixel Pals
            community and our charitable initiatives.
        </p>

        <div class="fundraising-circle"
             role="img"
             aria-label="{{ number_format($fundraisingPercentage, 1) }} percent of fundraising target reached"
             style="--progress: {{ $fundraisingPercentage }}%;">

            <div class="fundraising-circle-content">
                <strong>{{ number_format($totalDonated) }}</strong>
                <span>Pixel Tokens Raised</span>
            </div>

        </div>

        <p class="fundraising-target">
            Goal: {{ number_format($fundraisingTarget) }} Pixel Tokens
        </p>

        <p class="fundraising-percentage">
            {{ number_format($fundraisingPercentage, 1) }}% of our goal reached
        </p>

        <div class="fundraising-actions">
            <a href="{{ route('donations') }}" class="registration-submit-button">
                Donate Pixel Tokens
            </a>
        </div>
    </section>

    <a href="{{ url('/events') }}">
        Explore Upcoming Events
    </a>

</section>

@endsection
