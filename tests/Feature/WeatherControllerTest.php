<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\User;
use App\Services\OpenMeteoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;

class WeatherControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testWeatherControllerRetrunDataSuccessfuly(): void
    {
        $user = User::create([
            'login' => 'Test User',
            'password' => Hash::make('testPassword'),
        ]);

        Location::create([
            'user_id' => $user->id,
            'name' => 'Vladivostok',
            'latitude' => '43.10',
            'longitude' => '131.87',
        ]);

        //Mock !!!
        $serviceMock = Mockery::mock(OpenMeteoService::class);
        $serviceMock->shouldReceive('getWeatherForecast')
            ->once()
            ->andReturn([
                'daily' => ['temperature_2m_max' => [15], 'temperature_2m_min' => [5]],
            ]);

        $this->app->instance(OpenMeteoService::class, $serviceMock);

        $response = $this->get(route('weather.get'));
        $response->assertStatus(200);
        $response->assertSee('Vladivostok');
        $response->assertSee('43.10');
        $response->assertSee('131.87');
    }
}
