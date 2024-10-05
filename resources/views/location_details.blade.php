<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Weather in {{ $location->name }}  </title>

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <style>
        .day-forecast {
            margin-bottom: 30px;
        }

        .card-title {
            font-weight: bold;
        }

        .btn-back {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <a href="{{ route('home') }}" class="btn btn-primary mb-4">Back to Home</a>

    <h1 class="text-center mb-4">Weather Details for {{ $location->name }}</h1>
    <div class="text-center mb-4">
        <h3>Current Temperature: {{ $forecast['current_weather']['temperature'] }} °C</h3>
        <h3>Wind Speed: {{ number_format($forecast['current_weather']['windspeed'] / 3.6, 1) }} m/s</h3>
    </div>

    <h2 class="text-center mb-4">7-Day Forecast:</h2>
    <div class="row justify-content-center">
        @foreach($forecast['daily']['time'] as $index => $date)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card day-forecast">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $date }}</h5>
                        <p class="class-text">Min Temperature: {{ $forecast['daily']['temperature_2m_min'][$index] }} °C</p>
                        <p class="class-text">Max Temperature: {{ $forecast['daily']['temperature_2m_max'][$index] }} °C</p>
                        <p class="class-text">Max Wind Speed: {{ number_format($forecast['daily']['wind_speed_10m_max'][$index] / 3.6, 1) }} m/s</p>
                        <p class="class-text">Precipitation: {{ $forecast['daily']['precipitation_sum'][$index] }} mm</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
