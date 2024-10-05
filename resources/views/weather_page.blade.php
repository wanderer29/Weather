<div>
    @extends('layouts.app')

    @section('content')
        <h1>Weather Forecast</h1>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(isset($weather))
            <h3>Max Temp: {{ $weather['daily']['temperature_2m_max'][40.7128] }}°C</h3>
            <h3>Min Temp: {{ $weather['daily']['temperature_2m_min'][-74.0060] }}°C</h3>
        @else
            <p>No weather data available</p>
        @endif
    @endsection
</div>
