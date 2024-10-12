<?php

namespace Tests\Feature;

use App\Services\OpenMeteoService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Mockery;
use Mockery\MockInterface;
use Psr\Http\Message\RequestInterface;
use Tests\TestCase;

class OpenMeteoServiceTest extends TestCase
{
    public function testGetWatherForecastSuccessfully()
    {
        // Mock!!
        $mockClient = Mockery::mock(Client::class);
        $mockClient->shouldReceive('get')
            ->once()
            ->with('https://api.open-meteo.com/v1/forecast', Mockery::any())
            ->andReturn(new Response(200, [], json_encode([
                'current_weather' => ['weathercode' => 1],
                'daily' => ['weathercode' => [2, 3]],
            ])));

        $openMeteoService = new OpenMeteoService($mockClient);

        $result = $openMeteoService->getWeatherForecast(12, 12);

        $this->assertNotNull($result);
        $this->assertEquals('Cloudy', $result['daily']['weather_description'][0]);
        $this->assertEquals('Overcast', $result['daily']['weather_description'][1]);
    }

    public function testGetWeatherForecastWithError()
    {
        $mockClient = Mockery::mock(Client::class);
        $mockClient->shouldReceive('get')
            ->once()
            ->with('https://api.open-meteo.com/v1/forecast', Mockery::any())
            ->andThrow(new RequestException('Error connect to server', Mockery::mock(RequestInterface::class)));

        $openMeteoService = new OpenMeteoService($mockClient);

        $result = $openMeteoService->getWeatherForecast(12, 12);

        $this->assertNull($result);
    }
}
