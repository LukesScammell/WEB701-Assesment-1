
@extends('layouts.app')

@section('title', 'Login | Pixel Pals')

@section('content')
<div class="events-page">
    <section class="content-panel">
        <h1>Login to Pixel Pals</h1>

        <p>Enter your account details to access your Pixel Pals account.</p>

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

        <form method="POST" action="{{ route('login') }}" class="registration-form">
            @csrf

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
                    autocomplete="current-password"
                    required
                >
            </div>

            <button type="submit" class="registration-submit">
                Login
            </button>
        </form>

        <p>
            Don't have an account?
            <a href="{{ route('register') }}">Create an account</a>
        </p>
    </section>
</div>
@endsection
