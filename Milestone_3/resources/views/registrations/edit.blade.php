@extends('layouts.app')

@section('title', 'Edit Team | Pixel Pals')

@section('content')

<div class="events-page">

    <section class="content-panel registration-panel">

        <h1>Edit Your Team</h1>

        <h2>{{ $registration->event->name }}</h2>

        <div class="registration-event-details">
            <p><strong>Game:</strong> {{ $registration->event->game }}</p>
            <p><strong>Date:</strong> {{ $registration->event->event_date->format('d M Y') }}</p>
            <p><strong>Players Per Team:</strong> {{ $registration->event->team_size }}</p>
        </div>

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

        <form method="POST"
              action="{{ route('registrations.update', $registration) }}"
              class="registration-form">

            @csrf
            @method('PUT')

            <div class="registration-field">
                <label for="team_name">Team Name</label>
                <input type="text" id="team_name" name="team_name"
                    value="{{ old('team_name', $registration->team_name) }}"
                    maxlength="255" required>
            </div>

            <div class="registration-field">
                <label for="contact_name">Contact Name</label>
                <input type="text" id="contact_name" name="contact_name"
                    value="{{ old('contact_name', $registration->contact_name) }}"
                    maxlength="255" required>
            </div>

            <div class="registration-field">
                <label for="contact_email">Contact Email</label>
                <input type="email" id="contact_email" name="contact_email"
                    value="{{ old('contact_email', $registration->contact_email) }}"
                    maxlength="255" required>
            </div>

            <h3>Team Players</h3>

            <p>Update the gaming usernames of your registered players.</p>

            @for ($i = 0; $i < $registration->event->team_size; $i++)

                <div class="registration-field">
                    <label for="player_{{ $i }}">
                        Player {{ $i + 1 }} Username
                    </label>

                    <input type="text"
                        id="player_{{ $i }}"
                        name="players[]"
                        value="{{ old('players.' . $i, $registration->players->get($i)?->username) }}"
                        maxlength="100"
                        required>
                </div>

            @endfor

            <div class="registration-actions">
                <a href="{{ route('registrations.index') }}"
                   class="registration-back-button">
                    Back to My Teams
                </a>

                <button type="submit" class="registration-submit-button">
                    Save Changes
                </button>
            </div>

        </form>

    </section>

</div>

@endsection
