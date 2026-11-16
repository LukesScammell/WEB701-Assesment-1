@extends('layouts.app')

@section('title', 'Create Event | Pixel Pals')

@section('content')
<div class="events-page">
    <section class="content-panel">
        <h1>Create New Event</h1>
        <p>Add a new esports event to the Pixel Pals website.</p>

        @if ($errors->any())
            <div role="alert">
                <p>Please correct the following errors:</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.events.store') }}" class="registration-form">
            @csrf

            <div class="registration-field">
                <label for="name">Event Name</label>
                <input type="text" id="name" name="name"
                    value="{{ old('name') }}" required>
            </div>

            <div class="registration-field">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                    rows="4" required>{{ old('description') }}</textarea>
            </div>

            <div class="registration-field">
                <label for="event_date">Event Date</label>
                <input type="date" id="event_date" name="event_date"
                    value="{{ old('event_date') }}"
                    min="{{ now()->toDateString() }}" required>
            </div>

            <div class="registration-field">
                <label for="event_time">Event Time</label>
                <input type="time" id="event_time" name="event_time"
                    value="{{ old('event_time') }}" required>
            </div>

            <div class="registration-field">
                <label for="location">Location</label>
                <input type="text" id="location" name="location"
                    value="{{ old('location') }}" required>
            </div>

            <div class="registration-field">
                <label for="game">Game</label>
                <input type="text" id="game" name="game"
                    value="{{ old('game') }}" required>
            </div>

            <div class="registration-field">
                <label for="max_teams">Maximum Teams</label>
                <input type="number" id="max_teams" name="max_teams"
                    value="{{ old('max_teams') }}" min="1" required>
            </div>

            <div class="event-actions">
                <button type="submit" class="registration-submit">
                    Create Event
                </button>

                <a href="{{ route('admin.events.index') }}" class="event-signup-button">
                    Cancel
                </a>
            </div>
        </form>
    </section>
</div>
@endsection
