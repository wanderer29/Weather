<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class OpenMeteoService
{
    protected $client;
    protected $baseUrl = 'https://api.openmeteo.com';

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getWeatherForecast(float $latitude, float $longitude) : array|null
    {
        try {
            $response = $this->client->get($this->baseUrl, [
                'query' => [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'daily' => 'temperature_2m_max,temperature_2m_min',
                    'timezone' => 'auto',
                ]
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            // Не забыть придумать логику
            return null;
        }
    }
}
