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
        if (!Auth::check()) {
            return redirect()->route('login.index')->with('error', 'You need to login first');
        }

        $userLogin = Auth::user()->login;
        $locations = Location::where('user_id', Auth::id())->get();
        $weatherData = [];

        foreach ($locations as $location) {
            $weather = $this->openMeteoService->getWeatherForecast($location->latitude, $location->longitude);
            $weatherData[$location->name] = $weather;
        }

        return view('home_page', ['userLogin' => $userLogin, 'locations' => $locations, 'weatherData' => $weatherData]);
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
        if (!Auth::check()) {
            return redirect()->route('login.index')->with('error', 'You need to login first');
        }

        $user = Auth::user();
        $location = Location::where('id', $locationId)->where('user_id', $user->id)->first();

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
        $user = Auth::user();

        $locations = Location::where('user_id', $user->id)->where('name', 'LIKE', '%' . $query . '%')->get();

        $weatherData = [];
        foreach ($locations as $location) {
            $weather = $this->openMeteoService->getWeatherForecast($location->latitude, $location->longitude);
            $weatherData[$location->name] = $weather;
        }

        return view('home_page', ['userLogin' => $user->login, 'locations' => $locations, 'weatherData' => $weatherData]);
    }

}
