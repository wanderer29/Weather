<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Location;
use App\Services\LocationService;
use App\Services\OpenMeteoService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function __construct(
        protected LocationService $locationService,
    )
    {
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
        $location = $this->locationService->getLocation($locationId);

        if ($location) {
            $location->delete();
            return redirect()->route('home')->with('success', 'Location deleted successfully');
        }

        return redirect()->route('home')->with('error', 'Location not found');
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

    public function searchLocations(Request $request): View
    {
        $data = $this->locationService->searchLocationsForUser($request);

        return view('home', [
            'userLogin' => $data['user']->login,
            'locations' => $data['locations'],
            'weatherData' => $data['weatherData'],
        ]);
    }



}
