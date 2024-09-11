<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home_page');
})->name('home');

Route::get('/login', function () {
    return view('authorization_page');
});

Route::get('/register', function () {
    return view('registration_page');
});

Route::post('/register', [UserController::class, 'register'])->name('user.register');

Route::post('/login', function () {})->name('login');

