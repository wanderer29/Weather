<?php

namespace App\Http\Controllers;

use App\Models\Location;
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

    public function isAuthenticated(): bool
    {
        if (session('user_id')) {
            return true;
        }

        $userIdFromCookie = Cookie::get('user_id');
        if ($userIdFromCookie) {
            session(['user_id' => $userIdFromCookie]);
            return true;
        }

        return false;
    }

    public function showHome(Request $request): View|RedirectResponse
    {
        if (!$this->isAuthenticated()) {
            return redirect()->route('login.index')->with('error', 'You need to login first');
        }

        $userId = session('user_id');
        $locations = Location::where('user_id', $userId)->get();
        $weatherData = [];

        foreach ($locations as $location) {
            $weather = $this->openMeteoService->getWeatherForecast($location->latitude, $location->longitude);
            $weatherData[$location->name] = $weather;
        }

        return view('home_page', ['locations' => $locations, 'weatherData' => $weatherData]);
    }

    public function addLocation(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        Location::create([
            'user_id' => session('user_id'),
            'name' => $validated['name'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        return redirect()->route('home')->with('success', 'Location added successfully');
    }

    public function deleteLocation(int $locationId): RedirectResponse
    {
        $userId = session('user_id');
        $location = Location::where('id', $locationId)->where('user_id', $userId)->first();

        if ($location) {
            $location->delete();
            return redirect()->route('home')->with('success', 'Location deleted successfully');
        }

        return redirect()->route('home')->with('error', 'Location not found');
    }

    public function searchLocations(Request $request): View|RedirectResponse
    {
        if (!$this->isAuthenticated()) {
            return redirect()->route('login.index')->with('error', 'You need to login first');
        }

        $query = $request->input('query');
        $userId = session('user_id');

        $locations = Location::where('user_id', $userId)->where('name', 'LIKE', '%' . $query . '%')->get();

        $weatherData = [];
        foreach ($locations as $location) {
            $weather = $this->openMeteoService->getWeatherForecast($location->latitude, $location->longitude);
            $weatherData[$location->name] = $weather;
        }

        return view('home_page', ['locations' => $locations, 'weatherData' => $weatherData]);
    }

}
