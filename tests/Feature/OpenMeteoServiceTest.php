<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OpenMeteoServiceTest extends TestCase
{

    public function testWeatherServiceReturnDataSuccessfully(): void
    {
        //Moke!
        Http::fake([
            'api.open-meteo.com/*' => Http::response([
                'latitude' => 52,
                'longitude' => 12.4,
                'current_weather' => [
                    'temperature' => 15,
                    'windspeed' => 1,
                ]
            ], 200)
        ]);

        $response = $this->get('/weather?latitude=52&longitude=12.4');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'latitude' => 52,
            'longitude' => 12.4,
            'current_weather' => [
                'temperature' => 15,
                'windspeed' => 1,
            ]
        ]);
    }
}
