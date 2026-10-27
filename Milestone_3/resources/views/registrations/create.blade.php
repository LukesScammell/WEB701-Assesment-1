
@extends('layouts.app')

@section('title', 'Team Registration | Pixel Pals')

@section('content')

<div class="events-page">

    <section class="content-panel registration-panel">

        <h1>Register Your Team</h1>

        <h2>{{ $event->name }}</h2>

        <div class="registration-event-details">
            <p>
                <strong>Game:</strong> {{ $event->game }}
            </p>

            <p>
                <strong>Date:</strong>
                {{ $event->event_date->format('d M Y') }}
            </p>

            <p>
                <strong>Location:</strong> {{ $event->location }}
            </p>
        </div>

        @if (session('success'))
            <div class="registration-success" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="registration-errors" role="alert">
                <p>Please correct the following errors:</p>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('registrations.store', $event) }}"
            class="registration-form"
        >
            @csrf

            <div class="registration-field">
                <label for="team_name">Team Name</label>

                <input
                    type="text"
                    id="team_name"
                    name="team_name"
                    value="{{ old('team_name') }}"
                    maxlength="255"
                    required
                >
            </div>

            <div class="registration-field">
                <label for="contact_name">Contact Name</label>

                <input
                    type="text"
                    id="contact_name"
                    name="contact_name"
                    value="{{ old('contact_name') }}"
                    maxlength="255"
                    required
                >
            </div>

            <div class="registration-field">
                <label for="contact_email">Contact Email</label>

                <input
                    type="email"
                    id="contact_email"
                    name="contact_email"
                    value="{{ old('contact_email') }}"
                    maxlength="255"
                    required
                >
            </div>

            <div class="registration-actions">
                <a
                    href="{{ url('/events') }}"
                    class="registration-back-button"
                >
                    Back to Events
                </a>

                <button type="submit" class="registration-submit-button">
                    Register Team
                </button>
            </div>

        </form>

    </section>

</div>

@endsection
