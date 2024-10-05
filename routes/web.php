<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use \App\Services\OpenMeteoService;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LocationController;

Route::middleware('guest')->group(function () {
    Route::get('/', [PageController::class, 'showWelcome'])->name('welcome');
    Route::get('/login', [PageController::class, 'showLogin'])->name('login');
    Route::get('/register', [PageController::class, 'showRegistration'])->name('register.index');

    Route::post('/register', [UserController::class, 'register'])->name('user.register');
    Route::post('/login', [UserController::class, 'login'])->name('user.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [PageController::class, 'showHome'])->name('home')  ;
    Route::get('/home/search', [LocationController::class, 'searchLocations'])->name('location.search');
    Route::get('/weather', [OpenMeteoService::class, 'getWeatherForecast'])->name('weather.get');

    Route::get('/location/{location}', [LocationController::class, 'deleteLocation'])->name('location.delete');
    Route::get('/location/{id}/details', [PageController::class, 'showLocationDetails'])->name('location.details');

    Route::post('/location', [LocationController::class, 'addLocation'])->name('location.add');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});
