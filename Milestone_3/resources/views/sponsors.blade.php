@extends('layouts.app')

@section('title', 'Sponsors & Partners - Pixel Pals')

@section('content')

<section class="sponsors-page">

    <h1>Sponsors & Partners</h1>

    <p class="sponsors-intro">
        Pixel Pals aims to work with businesses, gaming communities
        and organisations that share our passion for making esports
        accessible to young people.
    </p>

    <div class="sponsors-grid">

        <section class="content-panel">
            <h2>Our Sponsors</h2>

            <p>
                Sponsors play an important role in helping charities
                support their communities. Pixel Pals welcomes
                organisations interested in contributing to our
                future events and activities.
            </p>
        </section>

        <section class="content-panel">
            <h2>Become a Sponsor</h2>

            <p>
                Businesses can support Pixel Pals through financial
                contributions, gaming equipment, prizes or services
                that help make esports more accessible.
            </p>
        </section>

        <section class="content-panel">
            <h2>Community Partnerships</h2>

            <p>
                We aim to build partnerships with schools, gaming
                communities and local organisations to create
                positive experiences for young gamers.
            </p>
        </section>

        <section class="content-panel">
            <h2>Volunteer Opportunities</h2>

            <p>
                Volunteers can help support gaming events,
                community activities and the development of
                a welcoming environment for participants.
            </p>
        </section>

    </div>

    <div class="sponsors-footer">

        <h2>Interested in Supporting Pixel Pals?</h2>

        <p>
            Whether you represent a business, organisation or
            gaming community, we would love to hear from you.
        </p>

        <a href="{{ url('/contact') }}" class="sponsors-contact-button">
            Contact Us
        </a>

    </div>

</section>

@endsection
