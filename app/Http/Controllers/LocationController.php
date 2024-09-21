<?php

namespace App\Http\Controllers;

use App\Services\OpenMeteoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LocationController extends Controller
{
    protected OpenMeteoService $openMeteoService;

    public function __construct(OpenMeteoService $openMeteoService)
    {
        $this->openMeteoService = $openMeteoService;
    }

    public function showWeather(Request $request): View|RedirectResponse
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        $weather = $this->openMeteoService->getWeatherForecast($latitude, $longitude);

        if ($weather) {
            return view('weather', ['weather' => $weather]);
        } else {
            return back()->with('error', 'Unable to retrieve weather data');
        }
    }
}
