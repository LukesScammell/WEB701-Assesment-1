<?php

use Illuminate\Support\Facades\Route;
use App\Models\Event;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Display the Pixel Pals homepage
Route::get('/', function () {
    return view('home');
});

// Retrieve upcoming events from SQLite
Route::get('/events', function () {

    $events = Event::withCount('registrations')
        ->where('event_date', '>=', today())
        // This makes it so the default order by is set to a ascending for both the date and time if its closer to the date time so it shows ones coming up
        ->orderBy('event_date', 'asc')
        ->orderBy('event_time', 'asc')
        ->get();

    return view('events', [
        'events' => $events
    ]);
});

// Display the team registration form
Route::get('/events/{event}/register', function (Event $event) {
    return view('registrations.create', compact('event'));
})->name('registrations.create');

// Store a team registration
Route::post('/events/{event}/register', [RegistrationController::class, 'store'])
    ->name('registrations.store');

// Routes for users who are not logged in
Route::middleware('guest')->group(function () {

    // Display the account registration page
    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');

    // Create a new user account
    Route::post('/register', [RegisteredUserController::class, 'store']);

    // Display the login page
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // Authenticate the user
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// Log out an authenticated user
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
