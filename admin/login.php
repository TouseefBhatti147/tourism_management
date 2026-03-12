<?php
// --- PHP Session Block ---
// Start the session to manage user login state
session_start();

// If the user is already logged in, redirect them to the dashboard
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php"); // Assuming your main dashboard is index.php
    exit;
}
// --- End of PHP Block ---
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login | Real Estate E-system</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | Login" />

    <!-- Styles from your edit_project.php example -->
    <link rel="preload" href="./css/adminlte.css" as="style" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        crossorigin="anonymous"
        media="print"
        onload="this.media='all'" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="./css/adminlte.css" />
    <!-- Note: We use ./css/adminlte.css assuming login.php is in the root. 
         Adjust path if needed -->
</head>

<!-- 
  For a login page, we use 'login-page' class on the body
  instead of the full dashboard layout.
-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary login-page">

    <div class="login-box">
        <div class="login-logo">
            <!-- Assuming logo is in assets/img/logo.jpg relative to root -->
            <img src="assets/img/logo.jpg" alt="Real Estate E-System Logo" style="width: 150px; height: 150px; margin-bottom: 10px; border-radius: 50%; object-fit: cover;">
            <br>
            <a href="index.php"><b>Real Estate</b> E-System</a>
        </div>
        <!-- /.login-logo -->
        <div class="card shadow rounded">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <!-- Feedback area, similar to 'apiResponse' in your example -->
                <div id="loginError" class="alert" style="display: none;"></div>

                <!-- 
                  Form ID is 'loginForm'.
                  We prevent default submission and use AJAX.
                -->
                <form id="loginForm" method="POST">
                    <div class="input-group mb-3">
                        <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
                        <div class="input-group-text">
                            <span class="bi bi-person-fill"></span>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-text">
                            <span class="bi bi-lock-fill"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <div class="d-grid">
                                <button type="submit" id="loginButton" class="btn btn-primary">Sign In</button>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>


            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- Scripts from your edit_project.php example -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <!-- Adjust path to adminlte.js if needed -->
    <script src="./js/adminlte.js"></script>

    <!-- AJAX Form Submission Script (Pattern from your example) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loginForm = document.getElementById('loginForm');
            const loginButton = document.getElementById('loginButton');
            const loginError = document.getElementById('loginError');

            loginForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Stop default form submission

                // Show loading state
                setLoading(true);

                const formData = new FormData(this);

                // Send data to the AJAX handler
                // Create this file at 'ajax/ajax_login_handler.php'
                fetch('users/ajax_login_handler.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        const contentType = response.headers.get("content-type");
                        if (contentType && contentType.indexOf("application/json") !== -1) {
                            return response.json();
                        } else {
                            return response.text().then(text => {
                                throw new Error("Server did not return JSON. Response: " + text);
                            });
                        }
                    })
                    .then(result => {
                        if (result.success) {
                            // Success! Show success and redirect
                            showApiResponse(result.message, true);
                            setTimeout(() => {
                                window.location.href = "index.php"; // Redirect to dashboard
                            }, 1000);
                        } else {
                            // Failed login
                            showApiResponse(result.message, false);
                            setLoading(false);
                        }
                    })
                    .catch(err => {
                        console.error('Submit Error:', err);
                        showApiResponse('An error occurred: ' + err.message, false);
                        setLoading(false);
                    });
            });

            // --- Helper Functions ---
            function setLoading(isLoading) {
                if (isLoading) {
                    loginButton.disabled = true;
                    loginButton.innerHTML = `
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Signing In...
                    `;
                } else {
                    loginButton.disabled = false;
                    loginButton.innerHTML = "Sign In";
                }
            }

            function showApiResponse(message, isSuccess) {
                loginError.textContent = message;
                loginError.style.display = 'block';
                if (isSuccess) {
                    loginError.className = 'alert alert-success';
                } else {
                    loginError.className = 'alert alert-danger';
                }
            }
        });
    </script>
</body>

</html>