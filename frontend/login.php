<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | Real Estate E-System 
</title>
    <?php require("header.php");?>
  
</head>

<body>
  <div class="login-container d-flex">
    <!-- Left Side (with background image) -->
    <div class="login-left">
      <h1>Welcome to <br><span>Real Estate E-System 
</span></h1>
      <p class="mt-3" style="max-width: 320px;">Buy, sell, or rent properties with ease, trusted by thousands of customers.</p>
    </div>

    <!-- Right Side -->
    <div class="login-right">
      <div class="login-box">
        <h3 class="mb-4">Sign In</h3>
        <form>
          <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" class="form-control" placeholder="Enter your email" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>
            <input type="password" class="form-control" placeholder="Enter your password" required>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="rememberMe">
              <label class="form-check-label" for="rememberMe">Remember me</label>
            </div>
            <a href="#" class="text-decoration-none text-danger small">Forgot password?</a>
          </div>
          <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <p class="mt-4 text-center text-muted">Don’t have an account?
          <a href="signup.php" class="text-decoration-none" style="color: var(--color-primary); font-weight: 600;">Sign Up</a>
        </p>
      </div>
    </div>
  </div>

  <?php require("script.php");?>
</body>
</html>
