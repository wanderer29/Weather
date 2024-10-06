<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Services\OpenMeteoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PageController extends Controller
{
    public function showWelcome(): RedirectResponse|View
    {
        return view('welcome_page');
    }

    public function showLogin(): RedirectResponse|View
    {
        return view('auth.login');
    }

    public function showRegistration(): RedirectResponse|View
    {
        return view('auth.register');
    }

    public function showHome(Request $request): View|RedirectResponse
    {
        $userLogin = Auth::user()->login;
        $locationController = new LocationController();
        $locations = $locationController->getUserLocations();
        $weatherData = $locationController->getWeatherForecastForLocations($locations);

        return view('home_page', [
            'userLogin' => $userLogin,
            'locations' => $locations,
            'weatherData' => $weatherData,
        ]);
    }

    public function showLocationDetails(int $locationId): View
    {
        $locationController = new LocationController();
        $location = $locationController->getLocation($locationId);
        $forecast = $locationController->getWeatherForecastForLocation($location);

        return view('location_details', [
            'location' => $location,
            'forecast' => $forecast,
        ]);

    }
}
