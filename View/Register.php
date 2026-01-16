<?php
 session_start(); 
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="register.css">

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

<body>

<h2>Create Account</h2>

<form onsubmit="event.preventDefault(); registerUser();">

    Name:
    <input type="text" id="name" placeholder="Enter your name"><br>

    Email:
    <input type="email" id="email" onkeyup="checkEmail()" placeholder="Enter your email"><br>

    Password:
    <input type="password" id="password" placeholder="Enter your password"><br>

    Confirm Password:
    <input type="password" id="confirm_password" placeholder="Confirm your password"><br><br>

    Register As:<br>
    <select id="role">
        <option value="">Select role</option>
        <option value="student">Student</option>
        <option value="customer">Customer</option>
    </select><br><br>

    <button type="submit">Register</button>
    <input type="reset" value="Reset">
</form>

<p id="result"></p>

<p>Already have an account? <a href="Login.php">Login</a></p>

</body>
</html>
