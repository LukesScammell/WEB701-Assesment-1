
<?php

use Illuminate\Support\Facades\Route;
use App\Models\Event;

// Display the Pixel Pals homepage
Route::get('/', function () {
    return view('home');
});

// Retrieve upcoming events from SQLite
Route::get('/events', function () {
    // This makes it so the default order by is set to a ascending for both the date and time if its closer to the date time so it shows ones coming up
    $events = Event::where('event_date', '>=', today())
        ->orderBy('event_date', 'asc')
        ->orderBy('event_time', 'asc')
        ->get();

    return view('events', [
        'events' => $events
    ]);
});
