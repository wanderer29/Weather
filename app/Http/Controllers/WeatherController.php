<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Services\OpenMeteoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WeatherController extends Controller
{
    protected OpenMeteoService $openMeteoService;

    public function __construct()
    {
        $this->openMeteoService = new OpenMeteoService();
    }

    public function showWeather(Request $request): View
    {
        $locations = Location::where('user_id', Auth::id())->get();
        $weatherData = [];

        foreach ($locations as $location) {
            $forecast = $this->openMeteoService->getWeatherForecast($location->latitude, $location->longitude);
            if ($forecast) {
                $weatherData[] = [
                    'location' => $location,
                    'forecast' => $forecast,
                ];
            }
        }

        return view('home', ['weatherData' => $weatherData, 'locations' => $locations]);
    }

}
