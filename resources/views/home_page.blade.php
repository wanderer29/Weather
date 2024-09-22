<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home page</title>
</head>
<body>
    <h2>Your Locations:</h2>
    @if(count($locations) > 0)
        @foreach($locations as $location)
            <div>
                <h3>{{ $location->name }}</h3>
                @if(isset($weatherData[$location->name]))
                    <p>Max temp: {{ $weatherData[$location->name]['daily']['temperature_2m_max'][0] }}°C</p>
                    <p>Min temp: {{ $weatherData[$location->name]['daily']['temperature_2m_max'][0] }}°C</p>
                @else
                    <p>Weather data unavailable.</p>
                @endif
            </div>
        @endforeach
    @else
        <p>No locations added yet.</p>
    @endif
</body>
</html>
