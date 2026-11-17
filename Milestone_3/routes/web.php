<?php

use Illuminate\Support\Facades\Route;
use App\Models\Event;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DonationController;

// Display the homepage with the next three upcoming events
Route::get('/', function () {

    $currentDate = now()->toDateString();
    $currentTime = now()->format('H:i:s');

    $events = Event::withCount('registrations')
        ->where(function ($query) use ($currentDate, $currentTime) {
            $query->whereDate('event_date', '>', $currentDate)
                ->orWhere(function ($query) use ($currentDate, $currentTime) {
                    $query->whereDate('event_date', $currentDate)
                        ->whereTime('event_time', '>=', $currentTime);
                });
        })
        ->orderBy('event_date', 'asc')
        ->orderBy('event_time', 'asc')
        ->limit(3)
        ->get();

    return view('home', [
        'events' => $events
    ]);
});

// Display About Us with live fundraising progress
Route::get('/about', function () {

    $fundraisingTarget = 10000;

    $totalDonated = \App\Models\Donation::where('status', 'completed')
        ->sum('amount');

    $fundraisingPercentage = min(100, ($totalDonated / $fundraisingTarget) * 100);

    return view('about', [
        'totalDonated' => $totalDonated,
        'fundraisingTarget' => $fundraisingTarget,
        'fundraisingPercentage' => $fundraisingPercentage,
    ]);

})->name('about');

// Display the Achievements page
Route::get('/achievements', function () {
    return view('achievements');
})->name('achievements');

// Display the Sponsors & Partners page
Route::get('/sponsors', function () {
    return view('sponsors');
})->name('sponsors');

// Display the contact page
Route::get('/contact', [ContactController::class, 'create'])
    ->name('contact');

// Store a contact message
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

// Display the Donations page to all visitors
Route::get('/donations', [DonationController::class, 'create'])
    ->name('donations');

// Only authenticated users can donate tokens
Route::post('/donations', [DonationController::class, 'store'])
    ->middleware(['auth', 'throttle:5,1'])
    ->name('donations.store');


// Retrieve upcoming events from SQLite, closest first
Route::get('/events', function () {

    $currentDate = now()->toDateString();
    $currentTime = now()->format('H:i:s');

    $events = Event::withCount('registrations')
        ->where(function ($query) use ($currentDate, $currentTime) {
            $query->whereDate('event_date', '>', $currentDate)
                ->orWhere(function ($query) use ($currentDate, $currentTime) {
                    $query->whereDate('event_date', $currentDate)
                        ->whereTime('event_time', '>=', $currentTime);
                });
        })
        ->orderBy('event_date', 'asc')
        ->orderBy('event_time', 'asc')
        ->get();

    return view('events', [
        'events' => $events
    ]);
});

// Only authenticated users can register and manage their teams
Route::middleware('auth')->group(function () {

    // Display the team registration form
    Route::get('/events/{event}/register', function (Event $event) {
        return view('registrations.create', compact('event'));
    })->name('registrations.create');

    // Store a team registration
    Route::post('/events/{event}/register', [RegistrationController::class, 'store'])
        ->name('registrations.store');

    // Display the logged-in user's registered teams
    Route::get('/my-teams', [RegistrationController::class, 'index'])
        ->name('registrations.index');

    // Display the edit form for a registered team
    Route::get('/my-teams/{registration}/edit', [RegistrationController::class, 'edit'])
        ->name('registrations.edit');

    // Update an existing team registration
    Route::put('/my-teams/{registration}', [RegistrationController::class, 'update'])
        ->name('registrations.update');

});

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


// Only authenticated administrators can manage events
Route::middleware(['auth', 'can:manage-events'])->group(function () {

    // Display all events for administrators
    Route::get('/admin/events', [EventController::class, 'index'])
        ->name('admin.events.index');

    // Display the create event form
    Route::get('/admin/events/create', [EventController::class, 'create'])
        ->name('admin.events.create');

    // Save a new event to SQLite
    Route::post('/admin/events', [EventController::class, 'store'])
        ->name('admin.events.store');

    // Display the edit form for a selected event
    Route::get('/admin/events/{event}/edit', [EventController::class, 'edit'])
        ->name('admin.events.edit');

    // Update the selected event in SQLite
    Route::put('/admin/events/{event}', [EventController::class, 'update'])
        ->name('admin.events.update');

    // Delete an event from SQLite
    Route::delete('/admin/events/{event}', [EventController::class, 'destroy'])
        ->name('admin.events.destroy');

});
