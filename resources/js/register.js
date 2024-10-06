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
