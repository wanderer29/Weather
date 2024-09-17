<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home_page');
})->name('home');

Route::get('/login', function () {
    return view('authorization_page');
})->name('login.index');

Route::get('/register', function () {
    return view('registration_page');
})->name('register.index');

Route::post('/register', [UserController::class, 'register'])->name('user.register');

Route::post('/login', [UserController::class, 'login'])->name('user.login');

