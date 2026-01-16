<?php
$rememberedEmail = isset($_COOKIE['remember_email']) ? $_COOKIE['remember_email'] : '';
$rememberedPass  = isset($_COOKIE['remember_pass']) ? $_COOKIE['remember_pass'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>studern</title>
    <link rel="stylesheet" href="login.css">

    <script>
        function callAjax() {
            let email = document.getElementById("email").value.trim();
            let password = document.getElementById("password").value.trim();
            let result = document.getElementById("result");

            document.getElementById("emailError").innerHTML = "";
            document.getElementById("passwordError").innerHTML = "";
            result.innerHTML = "";

            if (email === "") {
                document.getElementById("emailError").innerHTML = "Email is required";
                return;
            }

            if (password === "") {
                document.getElementById("passwordError").innerHTML = "Password is required";
                return;
            }

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../Controller/LoginControl.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                        let jsObj = JSON.parse(xhr.responseText);

                        if (jsObj.success) {
                            window.location.href = jsObj.redirect;
                        } else {
                            result.style.color = "red";
                            result.innerHTML = jsObj.message;
                        }
                    } catch (e) {
                        result.style.color = "red";
                        result.innerHTML = "Server error";
                        console.log(xhr.responseText);
                    }
                }
            };

            let remember = document.getElementById("remember").checked;

            xhr.send(
                "email=" + encodeURIComponent(email) +
                "&password=" + encodeURIComponent(password) +
                "&remember=" + remember
            );
        }
    </script>
</head>

<body class="login-body">

<div class="login-container">

    <div>

        <h2 class="login-title">Welcome Back</h2>
        <p class="login-subtitle">Sign in to your account</p>

        <form id="loginForm" class="login-form" onsubmit="event.preventDefault(); callAjax();">

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email"
                    value="<?php echo htmlspecialchars($rememberedEmail); ?>">
                <span id="emailError" class="error-text"></span>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password"
                    value="<?php echo htmlspecialchars($rememberedPass); ?>">
                <span id="passwordError" class="error-text"></span>
            </div>

            <div>
                <label class="remember-label">
                    <input type="checkbox" id="remember" name="remember" <?php echo $rememberedEmail ? 'checked' : ''; ?>> Remember Me
                </label>
            </div>

            <button type="button" onclick="callAjax()" class="login-btn">Login</button>

            <span id="result" class="result-message"></span>
        </form>

        <div class="register-section">
            Don't have an account?
            <a href="Register.php" class="register">Register</a>
        </div>

    </div>

</div>

</body>
</html>
