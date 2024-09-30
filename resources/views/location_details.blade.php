<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Home page</title>

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
<div class="container">
    <h1>Weather Details for {{ $location->name }}</h1>
    <h3>Current Temperature: {{ $forecast['current_weather']['temperature'] }} °C</h3>
    <h3>Wind Speed: {{ $forecast['current_weather']['windspeed'] }} km/h</h3>

    <h2>3-Day Forecast:</h2>
    @foreach($forecast['daily']['time'] as $index => $date)
        <div class="day-forecast">
            <h4>{{ $date }}</h4>
            <p>Min Temperature: {{ $forecast['daily']['temperature_2m_min'][$index] }} °C</p>
            <p>Max Temperature: {{ $forecast['daily']['temperature_2m_max'][$index] }} °C</p>
            <p>Max Wind Speed: {{ $forecast['daily']['wind_speed_10m_max'][$index] }} km/h</p>
            <p>Precipitation: {{ $forecast['daily']['precipitation_sum'][$index] }} mm</p>
        </div>
    @endforeach
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
