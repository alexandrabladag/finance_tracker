<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Dashboard');
});
