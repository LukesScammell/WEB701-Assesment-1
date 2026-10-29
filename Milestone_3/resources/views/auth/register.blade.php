@extends('layouts.app')

@section('title', 'Create Account | Pixel Pals')

@section('content')

<div class="events-page">

    <section class="content-panel">

        <h1>Create an Account</h1>

        <p>
            Register for a Pixel Pals account to participate
            in our esports community.
        </p>

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

        <form method="POST"
              action="{{ route('register') }}"
              class="registration-form">
            @csrf

            <div class="registration-field">
                <label for="name">Full Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    autocomplete="name"
                    required
                >
            </div>

            <div class="registration-field">
                <label for="email">Email Address</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    required
                >
            </div>

            <div class="registration-field">
                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    autocomplete="new-password"
                    minlength="8"
                    required
                >
            </div>

            <div class="registration-field">
                <label for="password_confirmation">
                    Confirm Password
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    autocomplete="new-password"
                    minlength="8"
                    required
                >
            </div>

            <button type="submit" class="registration-submit">
                Create Account
            </button>

        </form>

    </section>

</div>

@endsection
