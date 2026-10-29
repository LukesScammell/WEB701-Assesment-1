<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Pixel Pals')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>

    <header class="site-header">
        <nav class="navbar" aria-label="Main navigation">

            <a href="{{ url('/') }}" class="site-logo">
                Pixel Pals
            </a>

            <div class="nav-links">
                <a href="{{ url('/events') }}">Events</a>
                <a href="{{ url('/donations') }}">Donations</a>
                <a href="{{ url('/about') }}">About Us</a>
                <a href="{{ url('/achievements') }}">Achievements</a>
                <a href="{{ url('/sponsors') }}">Sponsors & Partners</a>
                <a href="{{ url('/contact') }}">Contact</a>
            </div>

            <div class="nav-account">
                @guest
                    <a href="{{ route('register') }}" class="login-button">
                        Register
                    </a>

                    <a href="{{ route('login') }}" class="login-button">
                        Login
                    </a>
                @endguest

                @auth
                    <span class="nav-username">
                        {{ Auth::user()->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit" class="login-button">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>

        </nav>
    </header>

    <main class="site-content">
        @yield('content')
    </main>

    <footer class="site-footer">
        <p>&copy; {{ date('Y') }} Pixel Pals. All rights reserved.</p>
    </footer>

    @livewireScripts

</body>
</html>
