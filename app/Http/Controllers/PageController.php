<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Services\LocationService;
use App\Services\OpenMeteoService;
use GuzzleHttp\Client;
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
        $client = new Client();
        $openMeteoService = new OpenMeteoService($client);
        $locationService = new LocationService($openMeteoService);
        $locations = $locationService->getUserLocationsPaginated();
        $weatherData = $locationService->getWeatherForecastForLocations($locations);

        return view('home', [
            'userLogin' => $userLogin,
            'locations' => $locations,
            'weatherData' => $weatherData,
        ]);
    }

    public function showLocationDetails(int $locationId): View
    {
        $client = new Client();
        $openMeteoService = new OpenMeteoService($client);
        $locationService = new LocationService($openMeteoService);
        $location = $locationService->getLocation($locationId);
        $forecast = $locationService->getWeatherForecastForLocation($location);

        return view('location_details', [
            'location' => $location,
            'forecast' => $forecast,
        ]);

    }
}
