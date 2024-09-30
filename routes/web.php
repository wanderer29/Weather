<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use \App\Http\Controllers\HomeController;
use \App\Services\OpenMeteoService;

Route::get('/', [UserController::class, 'showWelcome'])->name('welcome');
Route::get('/login', [UserController::class, 'showLogin'])->name('login.index');
Route::get('/register', [UserController::class, 'showRegistration'])->name('register.index');
Route::get('/home', [HomeController::class, 'showHome'])->name('home');
Route::get('/weather', [OpenMeteoService::class, 'getWeatherForecast'])->name('weather.get');
Route::get('/home/search', [HomeController::class, 'searchLocations'])->name('location.search');

Route::post('/register', [UserController::class, 'register'])->name('user.register');
Route::post('/login', [UserController::class, 'login'])->name('user.login');
Route::post('/location', [HomeController::class, 'addLocation'])->name('location.add');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/location/{location}', [HomeController::class, 'deleteLocation'])->name('location.delete');
