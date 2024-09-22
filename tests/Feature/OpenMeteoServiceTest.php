<?php

namespace Tests\Feature;

use App\Services\OpenMeteoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OpenMeteoServiceTest extends TestCase
{

    public function testWeatherServiceReturnDataSuccessfully(): void
    {
        $latitude = 49.00;
        $longitude = 10.2;

        $service = new OpenMeteoService();
        $response = $service->getWeatherForecast($latitude, $longitude);

        $this->assertNotNull($response);
        $this->assertArrayHasKey('daily', $response);
    }

    public function testWeatherServiceReturnNull(): void
    {
        //Such coordinates should not exist
        $latitude = 999.99;
        $longitude = 999.99;

        $service = new OpenMeteoService();
        $response = $service->getWeatherForecast($latitude, $longitude);

        $this->assertNull($response);
    }
}
