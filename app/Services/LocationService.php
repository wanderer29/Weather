<?php

namespace App\Services;

use App\Models\Location;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class LocationService
{
    public function __construct(
        protected OpenMeteoService $openMeteoService,
    )
    {
    }

    public function getLocation(int $locationId): Location
    {
        return Location::where('id', $locationId)->where('user_id', Auth::id())->first();
    }

    public function getUserLocations(): Collection
    {
        return Location::where('user_id', Auth::id())->get();
    }

    public function getWeatherForecastForLocation(Location $location): array
    {
        return $this->openMeteoService->getWeatherForecast($location->latitude, $location->longitude);
    }

    public function getWeatherForecastForLocations(Collection $locations): array
    {
        $weatherData = [];

        foreach ($locations as $location) {
            $weather = $this->openMeteoService->getWeatherForecast($location->latitude, $location->longitude);
            $weatherData[$location->name] = $weather;
        }
        return $weatherData;
    }

    public function searchLocationsForUser(Request $request) : array
    {
        $query = $request->input('query');
        $user = Auth::user();
        $locations = Location::where('user_id', $user->id)->where('name', 'LIKE', '%' . $query . '%')->get();
        $weatherData = $this->getWeatherForecastForLocations($locations);

        return [
            'user' => $user,
            'locations' => $locations,
            'weatherData' => $weatherData,
        ];
    }
}
