<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class OpenMeteoService
{
    protected $client;
    protected $baseUrl = 'https://api.open-meteo.com/v1/forecast';

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getWeatherForecast(float $latitude, float $longitude): array|null
    {
        try {
            $response = $this->client->get($this->baseUrl, [
                'query' => [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'current_weather' => 'true',
                    'daily' => 'temperature_2m_min,temperature_2m_max,precipitation_sum,wind_speed_10m_max',
                    'timezone' => 'auto',
                ]
            ]);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody(), true);
            }

            return null;
        } catch (GuzzleException $e) {
            Log::error('Error fetching weather data: ' . $e->getMessage());
            return null;
        }
    }
}
