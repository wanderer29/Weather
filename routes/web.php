<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use \App\Http\Controllers\HomeController;
use \App\Services\OpenMeteoService;


Route::get('/', function () {
    return view('welcome_page');
})->name('welcome');

Route::get('/home', [HomeController::class, 'showHome'])->name('home');

Route::get('/login', function () {
    return view('authorization_page');
})->name('login.index');

Route::get('/register', function () {
    return view('registration_page');
})->name('register.index');

Route::post('/register', [UserController::class, 'register'])->name('user.register');
Route::post('/login', [UserController::class, 'login'])->name('user.login');

Route::get('/weather', [OpenMeteoService::class, 'getWeatherForecast'])->name('weather.get');

Route::post('/location', [HomeController::class, 'addLocation'])->name('location.add');
