<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Location;
use App\Services\OpenMeteoService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LocationController extends Controller
{
    protected OpenMeteoService $openMeteoService;

    public function __construct()
    {
        $this->openMeteoService = new OpenMeteoService();
    }

    public function addLocation(LocationRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->createLocation($validatedData);

        return redirect()->route('home')->with('success', 'Location added successfully');
    }

    public function deleteLocation(int $locationId): RedirectResponse
    {
        $user = Auth::user();
        $location = $this->getLocation($locationId);

        if ($location) {
            $location->delete();
            return redirect()->route('home')->with('success', 'Location deleted successfully');
        }

        return redirect()->route('home')->with('error', 'Location not found');
    }

    public function searchLocations(Request $request): View
    {
        $query = $request->input('query');
        $user = Auth::user();
        $locations = Location::where('user_id', $user->id)->where('name', 'LIKE', '%' . $query . '%')->get();
        $weatherData = $this->getWeatherForecastForLocations($locations);

        return view('home', [
            'userLogin' => $user->login,
            'locations' => $locations,
            'weatherData' => $weatherData
        ]);
    }

    private function createLocation(array $validatedData): Location
    {
        return Location::create([
            'user_id' => Auth::id(),
            'name' => $validatedData['name'],
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
        ]);
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

}
