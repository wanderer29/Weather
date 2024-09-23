<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Services\OpenMeteoService;
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
        $userIdFromSession = session('user_id');

        \Log::info('Checking authentication via session', [
            'userIdFromSession' => $userIdFromSession,
        ]);

        return $userIdFromSession;
    }

    public function showHome(Request $request): View|RedirectResponse
    {

        if (!$this->isAuthenticated()) {
            return redirect()->route('login.index')->with('error', 'You need to login first');
        }

        $userId = session('userId');

        $locations = Location::where('user_id', Auth::id())->get();
        $weatherData = [];

        foreach ($locations as $location) {
            $weather = $this->openMeteoService->getWeatherForecast($location->latitude, $location->longitude);
            $weatherData[$location->name] = $weather;
        }

        return view('home', ['locations' => $locations, 'weatherData' => $weatherData]);
    }

    public function addLocation(Request $request) : RedirectResponse
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


}
