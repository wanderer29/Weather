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
                'query' => $this->buildQuery($latitude, $longitude),
            ]);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody(), true);
                $data = $this->setCurrentWeatherDescription($data);
                $data = $this->setDailyWeatherDescription($data);

                return $data;
            }

            return null;
        } catch (GuzzleException $e) {
            Log::error('Error fetching weather data: ' . $e->getMessage());
            return null;
        }
    }

    private function getWeatherDescription(int $weatherCode): string
    {
        return match ($weatherCode) {
            0 => 'Clear',
            1 => 'Partly Cloudy',
            2 => 'Cloudy',
            3 => 'Overcast',
            45 => 'Fog',
            61 => 'Rain',
            default => 'Unknown',
        };
    }

    private function buildQuery(float $latitude, float $longitude): array
    {
        return [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'current_weather' => 'true',
            'daily' => 'temperature_2m_min,temperature_2m_max,precipitation_sum,wind_speed_10m_max,weathercode',
            'timezone' => 'auto',
        ];
    }

    private function setCurrentWeatherDescription(array $data): array
    {
        $data['current_weather_description'] = $this->getWeatherDescription($data['current_weather']['weathercode']);
        return $data;
    }

    private function setDailyWeatherDescription(array $data): array
    {
        foreach ($data['daily']['weathercode'] as $index => $weatherCode) {
            $data['daily']['weather_description'][$index] = $this->getWeatherDescription($weatherCode);
        }
        return $data;
    }
}
