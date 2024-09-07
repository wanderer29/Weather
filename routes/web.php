<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('authorization_page');
});

Route::get('/register', function () {
    return view('registration_page');
});

Route::post('/register', function () {})->name('register');

Route::post('/login', function () {})->name('login');

