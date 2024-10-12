<?php

namespace App\Services;

use App\Models\Location;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function getUserLocationsPaginated(int $perPage = 7): LengthAwarePaginator
    {
        return Location::where('user_id', Auth::id())->paginate($perPage);
    }

    public function getWeatherForecastForLocation(Location $location): array
    {
        return $this->openMeteoService->getWeatherForecast($location->latitude, $location->longitude);
    }

    public function getWeatherForecastForLocations(LengthAwarePaginator $locations): array
    {
        $weatherData = [];

        foreach ($locations as $location) {
            $weather = $this->openMeteoService->getWeatherForecast($location->latitude, $location->longitude);
            if ($weather !== null) {
                $weatherData[$location->name] = $weather;
            } else {
                Log::warning("Weather data not available for location: {$location->name}");
            }
        }

        return $weatherData;
    }

    public function searchLocationsForUser(Request $request, int $perPage = 7) : array
    {
        $query = $request->input('query');
        $user = Auth::user();

        $locations = Location::where('user_id', $user->id)
            ->where('name', 'LIKE', '%' . $query . '%')
            ->paginate($perPage);

        $weatherData = $this->getWeatherForecastForLocations($locations);

        return [
            'user' => $user,
            'locations' => $locations,
            'weatherData' => $weatherData,
        ];
    }
}
