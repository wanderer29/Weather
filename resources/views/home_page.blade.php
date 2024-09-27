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
</head>
<body>


<div class="container">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Logout</button>
    </form>

    <form action="{{ route('location.search') }}" method="GET" class="mb-4">
        <div class="index-group">
            <input type="text" name="query" class="form-control" placeholder="Search location..."
                   value="{{request('query')}}">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </form>
    <h1>Your locations:</h1>
    <div class="row">
        @forelse($locations as $location)
            <div class="col-md-4">
                <div class="card-md-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $location->name }}</h5>
                    </div>
                    <p class="class-text">
                        Temperature: {{ $weatherData[$location->name]['current_weather']['temperature'] }} °C
                    </p>
                    {{--                    <form action="{{ route('location.delete', $location->id) }}" method="POST"--}}
                    {{--                          onsubmit="return confirm('Are you sure you want to delete this location?');">--}}
                    {{--                        @csrf--}}
                    {{--                        @method('DELETE')--}}
                    {{--                        <button type="submit" class="btn btn-danger">Delete</button>--}}
                    {{--                    </form>--}}
                    {{--                    <form action="{{ route('location.delete', $location->id) }}" method="POST"--}}
                    {{--                          onsubmit="return confirm('Are you sure you want to delete this location?');">--}}
                    {{--                        @csrf--}}
                    {{--                        @method('DELETE')--}}
                    {{--                        <button type="submit" class="btn btn-danger">Delete</button>--}}
                    {{--                    </form>--}}
                    <a href="{{route('location.delete', $location->id)}}" class="btn btn-primary">Delete</a>
                </div>
            </div>
        @empty
            <p>You have no locations added.</p>
        @endforelse
    </div>

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
