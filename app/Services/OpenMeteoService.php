<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

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
                    'current' => '',
                    'timezone' => 'auto',
                ]
            ]);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody(), true);
            }

            return null;
        } catch (GuzzleException $e) {
            // Не забыть придумать логику
            return null;
        }
    }
}
