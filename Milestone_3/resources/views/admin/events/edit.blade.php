@extends('layouts.app')

@section('title', 'Edit Event | Pixel Pals')

@section('content')
<div class="events-page">
    <section class="content-panel">
        <h1>Edit Event</h1>
        <p>Update the details for {{ $event->name }}.</p>

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

        <form method="POST" action="{{ route('admin.events.update', $event) }}" class="registration-form">
            @csrf
            @method('PUT')

            <div class="registration-field">
                <label for="name">Event Name</label>
                <input type="text" id="name" name="name"
                    value="{{ old('name', $event->name) }}" required>
            </div>

            <div class="registration-field">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                    rows="4" required>{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="registration-field">
                <label for="event_date">Event Date</label>
                <input type="date" id="event_date" name="event_date"
                    value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}" required>
            </div>

            <div class="registration-field">
                <label for="event_time">Event Time</label>
                <input type="time" id="event_time" name="event_time"
                    value="{{ old('event_time', substr($event->event_time, 0, 5)) }}" required>
            </div>

            <div class="registration-field">
                <label for="location">Location</label>
                <input type="text" id="location" name="location"
                    value="{{ old('location', $event->location) }}" required>
            </div>

            <div class="registration-field">
                <label for="game">Game</label>
                <input type="text" id="game" name="game"
                    value="{{ old('game', $event->game) }}" required>
            </div>

            <div class="registration-field">
                <label for="max_teams">Maximum Teams</label>
                <input type="number" id="max_teams" name="max_teams"
                    value="{{ old('max_teams', $event->max_teams) }}"
                    min="{{ max(1, $event->registrations()->count()) }}" required>
            </div>

            <div class="event-actions">
                <button type="submit" class="registration-submit">
                    Save Changes
                </button>

                <a href="{{ route('admin.events.index') }}" class="event-signup-button">
                    Cancel
                </a>
            </div>
        </form>
    </section>
</div>
@endsection
