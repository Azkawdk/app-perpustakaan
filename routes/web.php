<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route Group Admin
Route::prefix('admin')->group(function () {
    Route::get('/info', function () {
        return 'Ini adalah halaman informasi Admin';
    });
});