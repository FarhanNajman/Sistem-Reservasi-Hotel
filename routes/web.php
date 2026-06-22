<?php

use Illuminate\Support\Facades\Route;
use App\Models\Room;

Route::get('/', function () {
    $rooms = Room::all();
    return view('welcome', compact('rooms'));
});

