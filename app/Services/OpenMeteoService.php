<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class OpenMeteoService
{
    protected string $baseUrl = 'https://api.open-meteo.com/v1/forecast';

    protected const WEATHER_CLEAR = 0;
    public const WEATHER_PARTLY_CLOUDY = 1;
    public const WEATHER_CLOUDY = 2;
    public const WEATHER_OVERCAST = 3;
    public const WEATHER_FOG = 45;
    public const WEATHER_RAIN = 61;

    public function __construct(protected Client $client)
    {
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
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
            }

            return $data;
        } catch (GuzzleException $e) {
            Log::error('Error fetching weather data: ' . $e->getMessage());
            return null;
        }
    }

    private function getWeatherDescription(int $weatherCode): string
    {
        return match ($weatherCode) {
            self::WEATHER_CLEAR => 'Clear',
            self::WEATHER_PARTLY_CLOUDY => 'Partly Cloudy',
            self::WEATHER_CLOUDY => 'Cloudy',
            self::WEATHER_OVERCAST => 'Overcast',
            self::WEATHER_FOG => 'Fog',
            self::WEATHER_RAIN => 'Rain',
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
