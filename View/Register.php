<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" class="dark-theme">
<head>
    <title>Register | studern</title>
    <link rel="stylesheet" href="Css/register.css">

    <script>
        function registerUser() {
            let name = document.getElementById("name").value.trim();
            let email = document.getElementById("email").value.trim();
            let password = document.getElementById("password").value.trim();
            let confirm = document.getElementById("confirm_password").value.trim();
            let role = document.getElementById("role").value;
            let result = document.getElementById("result");

            result.innerHTML = "";

            if (name === "" || email === "" || password === "" || confirm === "" || role === "") {
                result.innerHTML = "All fields are required";
                return;
            }

            if (password !== confirm) {
                result.innerHTML = "Passwords do not match";
                return;
            }

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../Controller/RegisterControl.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                        let res = JSON.parse(xhr.responseText);
                        if (res.success) {
                            result.style.color = "green";
                            result.innerHTML = res.message;
                            setTimeout(() => {
                                window.location.href = "Login.php";
                            }, 1500);
                        } else {
                            result.style.color = "red";
                            result.innerHTML = res.message;
                        }
                    } catch (e) {
                        result.innerHTML = "Server error";
                        console.log(xhr.responseText);
                    }
                }
            };

            xhr.send(
                "name=" + encodeURIComponent(name) +
                "&email=" + encodeURIComponent(email) +
                "&password=" + encodeURIComponent(password) +
                "&confirm_password=" + encodeURIComponent(confirm) +
                "&role=" + encodeURIComponent(role)
            );
        }

        function checkEmail() {
            let email = document.getElementById("email").value;
            let err = document.getElementById("emailError");

            if (email === "") {
                err.innerHTML = "";
                return;
            }

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../Controller/RegisterControl.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    err.innerHTML = xhr.responseText;
                }
            };

            xhr.send("email=" + encodeURIComponent(email));
        }
    </script>
</head>

<body class="dark-theme">

<div class="register-page">

    <div class="register-card glass">

        <h2 class="register-title">Create Account</h2>
        <p class="register-subtitle">Join studern and start building your future</p>

        <form id="registerForm" class="register-form" onsubmit="event.preventDefault(); registerUser();">

            <div class="form-group">
                <label class="form-label">Name</label>
                <input type="text" id="name" placeholder="Enter your name" autocomplete="name">
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" id="email" onkeyup="checkEmail()" placeholder="Enter your email" autocomplete="email">
                <span id="emailError" class="error-text"></span>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" id="password" placeholder="Enter your password" autocomplete="new-password">
            </div>

            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <input type="password" id="confirm_password" placeholder="Confirm your password" autocomplete="new-password">
            </div>

            <div class="form-group">
                <label class="form-label">Register As</label>
                <select id="role">
                    <option value="">Select role</option>
                    <option value="student">Student</option>
                    <option value="customer">Customer</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-register">Register</button>
                <input type="reset" value="Reset" class="btn-reset">
            </div>

            <div id="result" class="result-message"></div>

        </form>

        <div class="login-link">
            Already have an account? <a href="Login.php" class="login-link-text">Login</a>
        </div>

    </div>

</div>

</body>
</html>