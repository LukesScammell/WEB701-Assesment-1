<?php

use Illuminate\Support\Facades\Route;

// Display the Pixel Pals homepage
Route::get('/', function () {
    return view('home');
});