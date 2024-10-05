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

    <style>
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
        }

    </style>
</head>
<body>


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
    <h1 class="text-center mb-4">Your locations:</h1>
    <div class="row justify-content-center">
        @forelse($locations as $location)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card location-card">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $location->name }}</h5>
                        <p class="class-text">
                            Temperature: {{ $weatherData[$location->name]['current_weather']['temperature'] }} °C
                        </p>
                        <a href="{{route('location.delete', $location->id)}}" class="btn btn-danger mt-3">Delete</a>
                        <a href="{{route('location.details', $location->id)}}" class="btn btn-info mt-3">Details</a>
                    </div>
                </div>
            </div>
        @empty
            <p>You have no locations added.</p>
        @endforelse
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
        <button type="submit" class="btn btn-primary">Add Location</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
