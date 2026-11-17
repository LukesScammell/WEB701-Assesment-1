@extends('layouts.app')

@section('title', 'Contact - Pixel Pals')

@section('content')

<section class="contact-page">

    <h1>Contact Pixel Pals</h1>

    <p class="contact-intro">
        Have a question about our events, donations or partnerships?
        Send us a message using the form below.
    </p>

    <div class="content-panel contact-panel">

        @if (session('success'))
            <div class="registration-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="registration-errors">
                <p>Please correct the following errors:</p>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('contact.store') }}" class="registration-form">
            @csrf

            <div class="registration-field">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name"
                       value="{{ old('name') }}" maxlength="100" required>
            </div>

            <div class="registration-field">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email') }}" maxlength="255" required>
            </div>

            <div class="registration-field">
                <label for="subject">Subject</label>

                <select id="subject" name="subject" required>
                    <option value="">Select an enquiry type</option>

                    @foreach (['General Enquiry', 'Events', 'Donations', 'Sponsorship', 'Volunteering'] as $subject)
                        <option value="{{ $subject }}" @selected(old('subject') === $subject)>
                            {{ $subject }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="registration-field">
                <label for="message">Message</label>

                <textarea id="message" name="message"
                          rows="6" maxlength="2000" required>{{ old('message') }}</textarea>
            </div>

            <div class="registration-actions">
                <a href="{{ url('/') }}" class="registration-back-button">
                    Back to Home
                </a>

                <button type="submit" class="registration-submit-button">
                    Send Message
                </button>
            </div>

        </form>

    </div>

</section>

@endsection
