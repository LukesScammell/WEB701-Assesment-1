
<?php

use Illuminate\Support\Facades\Route;
use App\Models\Event;
use App\Http\Controllers\RegistrationController;

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

Route::get('/events/{event}/register', function (Event $event) {
    return view('registrations.create', compact('event'));
})->name('registrations.create');

Route::post('/events/{event}/register', [RegistrationController::class, 'store'])
    ->name('registrations.store');
