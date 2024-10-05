<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<header class="text-center bg-primary text-white p-3">
    <h1>Registration</h1>
</header>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="card col-md-6">
            <div class="card-header">
                <h2>Create an Account</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('user.register') }}" method="POST" onsubmit="return checkPasswords()">
                    @csrf

                    <div class="mb-3">
                        <label for="login" class="form-label">Login:</label>
                        <input type="text" class="form-control" id="login" name="login" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password">Password:</label>
                        <input class="form-control" type="password" id="password" name="password" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="confirm_password">Confirm password:</label>
                        <input class="form-control" type="password" id="password_confirmation"
                               name="password_confirmation"
                               required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Register
                    </button>
                    <a href="{{ route('login') }}" class="btn btn-link">Login</a>
                    <a href="{{ route('welcome') }}" class="btn btn-secondary">Back to Home</a>
                </form>
                @if ($errors->any())
                    <div class="alert alert-danger m-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


<script>
    function checkPasswords() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("password_confirmation").value;
        if (password !== confirmPassword) {
            resetPasswords();
            alert("Passwords do not match!");
            return false;
        }
        return true;
    }

    function resetPasswords() {
        document.getElementById("password").value = "";
        document.getElementById("password_confirmation").value = "";
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
