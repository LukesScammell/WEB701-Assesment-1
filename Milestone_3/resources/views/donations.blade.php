@extends('layouts.app')

@section('title', 'Donations - Pixel Pals')

@section('content')

<section class="donations-page">

    <h1>Support Pixel Pals</h1>

    <p class="donations-intro">
        Your support can help make gaming more accessible
        for young people through community events, equipment
        and esports opportunities.
    </p>

    <div class="content-panel donations-panel">

        <h2>Make a Donation</h2>

        <p class="donations-notice">
            Pixel Tokens are virtual credits provided when you create
            an account. Donations are simulated and do not involve
            real money.
        </p>

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

        @auth
        <div class="donation-balance">
            <p>Your Available Balance</p>

            <h3>{{ number_format(Auth::user()->token_balance) }} Pixel Tokens</h3>
        </div>

        <form method="POST" action="{{ route('donations.store') }}" class="registration-form">
            @csrf

            <fieldset class="donation-amount-field">
                <legend>Select a Donation Amount (Pixel Tokens)</legend>

                <div class="donation-amount-grid">
                    @foreach ([25, 50, 100, 150, 250, 500] as $amount)
                        <label class="donation-amount-option">
                            <input type="radio" name="amount"
                                   value="{{ $amount }}"
                                   @checked((string) old('amount', '25') === (string) $amount && $amount <= Auth::user()->token_balance)
                                   @disabled($amount > Auth::user()->token_balance)
                                   required>

                            <span>{{ $amount }} Tokens</span>
                        </label>
                    @endforeach
                </div>
            </fieldset>

            <div class="registration-actions">
                <a href="{{ url('/') }}" class="registration-back-button">
                    Back to Home
                </a>

                <button type="submit" class="registration-submit-button">
                    Donate Pixel Tokens
                </button>
            </div>

        </form>
        @else

        <div class="donations-login-prompt">
            <h2>Login Required</h2>

            <p>
                Please log in or create a Pixel Pals account
                to receive your starting 500 Pixel Tokens
                and make a donation.
            </p>

            <div class="registration-actions">
                <a href="{{ route('login') }}" class="registration-submit-button">
                    Login
                </a>

                <a href="{{ route('register') }}" class="registration-back-button">
                    Create Account
                </a>
            </div>
        </div>

        @endauth

    </div>

</section>

@endsection
