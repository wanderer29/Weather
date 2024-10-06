@extends('layouts.app')

@section('title', 'Weather in ' . $location->name)

@section('styles')
    .day-forecast {
    margin-bottom: 30px;
    }

    .card-title {
    font-weight: bold;
    }

    .btn-back {
    margin-top: 20px;
    }
@endsection

@section('content')
    <a href="{{ route('home') }}" class="btn btn-primary mb-4">Back to Home</a>

    <h1 class="text-center mb-4">Weather Details for {{ $location->name }}</h1>
    <div class="text-center mb-4">
        <h3>Current Temperature: {{ $forecast['current_weather']['temperature'] }} °C</h3>
        <h3>Weather: {{ $forecast['current_weather_description'] }}</h3>
        <h3>Wind Speed: {{ number_format($forecast['current_weather']['windspeed'] / 3.6, 1) }} m/s</h3>
    </div>

    <h2 class="text-center mb-4">7-Day Forecast:</h2>
    <div class="row justify-content-center">
        @foreach($forecast['daily']['time'] as $index => $date)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card day-forecast">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $date }}</h5>
                        <p class="class-text">Min Temperature: {{ $forecast['daily']['temperature_2m_min'][$index] }}
                            °C</p>
                        <p class="class-text">Max Temperature: {{ $forecast['daily']['temperature_2m_max'][$index] }}
                            °C</p>
                        <p class="class-text">Weather: {{ $forecast['daily']['weather_description'][$index] }}</p>
                        <p class="class-text">Max Wind
                            Speed: {{ number_format($forecast['daily']['wind_speed_10m_max'][$index] / 3.6, 1) }}
                            m/s</p>
                        <p class="class-text">Precipitation: {{ $forecast['daily']['precipitation_sum'][$index] }}
                            mm</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

