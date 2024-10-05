<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use App\Services\OpenMeteoService;
use Illuminate\Foundation\Console\PackageDiscoverCommand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class HomeController extends Controller
{
    protected OpenMeteoService $openMeteoService;

    public function __construct()
    {
        $this->openMeteoService = new OpenMeteoService();
    }

    public function showHome(Request $request): View|RedirectResponse
    {
        $userLogin = Auth::user()->login;
        $locations = Location::where('user_id', Auth::id())->get();
        $weatherData = [];

        foreach ($locations as $location) {
            $weather = $this->openMeteoService->getWeatherForecast($location->latitude, $location->longitude);
            $weatherData[$location->name] = $weather;
        }

        return view('home_page', ['userLogin' => $userLogin, 'locations' => $locations, 'weatherData' => $weatherData]);
    }

}
