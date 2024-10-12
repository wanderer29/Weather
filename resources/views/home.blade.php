@php use App\Models\Location; @endphp

@extends('layouts.app')

@section('title', 'Home page')

@section('styles')
    .search-bar {
    max-width: 400px;
    margin: 0 auto 30px;
    }

    .location-card {
    margin-bottom: 30px;
    }

    .card-title {
    font-weight: bold;
    }

    .add-location {
    margin-top: 50px;
    }

    .btn-logout {
    text-align: right;
    margin-bottom: 20px;
    margin-top: 15px;
    top: 20px;
    right: 20px;

    .pagination {
    justify-content: center;
    }

    .pagination .page-item .page-link {
    color: #007bff;
    }

    .pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    }

    .pagination .page-item.disabled .page-link {
    color: #6c757d;
    }
@endsection

@section('content')
    <div class="container mt-4">

        {{--Login--}}
        <div class="btn-logout">
            <span class="username">Login: {{ $userLogin }}</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>

        {{--Search--}}
        <div class="search-bar">
            <form action="{{ route('location.search') }}" method="GET" class="d-flex">
                <input type="text" name="query" class="form-control me-2" placeholder="Search location..."
                       value="{{request('query')}}">
                <button class="btn btn-primary" type="submit">Search</button>
            </form>
        </div>

        {{--Locations--}}
        @php
            /** @var Location[] $locations */
            /** @var array $weatherData */
        @endphp

        <h1 class="text-center mb-4">Your locations:</h1>
        <div class="row justify-content-center">
            @forelse($locations as $location)
                @php /** @var Location $location */ @endphp
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card location-card">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $location->name }}</h5>
                            @if (isset($weatherData[$location->name]))
                                <p class="class-text">
                                    Temperature: {{ $weatherData[$location->name]['current_weather']['temperature'] }}
                                    °C
                                </p>
                                <p class="class-text">
                                    Weather: {{ $weatherData[$location->name]['current_weather_description'] }}
                                </p>
                                <p class="class-text">
                                    Wind
                                    Speed: {{ number_format($weatherData[$location->name]['current_weather']['windspeed'] / 3.6, 1) }}
                                    m/s
                                </p>
                            @else
                                <p class="text-danger">Weather data not available</p>
                            @endif
                            <a href="{{route('location.delete', $location->id)}}" class="btn btn-danger mt-3">Delete</a>
                            <a href="{{route('location.details', $location->id)}}" class="btn btn-info mt-3">Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>You have no locations added.</p>
            @endforelse

            <div class="mt-4">
                {{ $locations->links('pagination::bootstrap-5') }}
            </div>
        </div>

        {{--Add Location--}}
        <h2>Add Location</h2>
        <form action="{{ route('location.add') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Location Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" class="form-control" id="latitude" name="latitude" required>
            </div>
            <div class="mb-3">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" class="form-control" id="longitude" name="longitude" required>
            </div>
            <button type="submit" class="btn btn-primary mb-3">Add Location</button>
        </form>
    </div>

    {{--Validation errors--}}
    @php
        /** @var Error[] $errors */
    @endphp

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
@endpush
