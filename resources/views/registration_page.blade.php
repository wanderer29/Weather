<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
</head>
<body>
<header>

</header>
<div>
    <form action="{{ route('register') }}" method="POST" onsubmit="return checkPasswords()">
        @csrf

        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirm password</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <button type="submit">
            Register
        </button>
    </form>
</div>

    <script>
        function checkPasswords() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            resetPasswords();
            if (password !== confirmPassword) {
                alert("Пароли не совпадают!");

                return false;
            }
            return true;
        }

        function resetPasswords() {
            document.getElementById("password").value = "";
            document.getElementById("confirm_password").value = "";
        }
    </script>

</body>
</html>
