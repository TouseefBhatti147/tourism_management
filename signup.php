<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up | Real Estate E-System 
</title>
    <?php require("header.php");?>
  
</head>

<body>
  <div class="login-container">
    <!-- Left Side (Background Image) -->
    <div class="login-left">
      <h1>Join <br>  <span>Real Estate E-System 
</span>  </h1>
      <p class="mt-3" style="max-width: 320px;">Create your free account and start exploring thousands of properties across the country.</p>
    </div>

    <!-- Right Side (Sign Up Form) -->
    <div class="login-right">
      <div class="signup-box">
        <h3 class="mb-4">Create Account</h3>
        <form>
          <div class="mb-3">
            <label class="form-label fw-semibold">Full Name</label>
            <input type="text" class="form-control" placeholder="Enter your full name" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Email Address</label>
            <input type="email" class="form-control" placeholder="Enter your email" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>
            <input type="password" class="form-control" placeholder="Create a password" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Confirm Password</label>
            <input type="password" class="form-control" placeholder="Re-enter your password" required>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="terms" required>
            <label class="form-check-label" for="terms">
              I agree to the <a href="#" style="color: var(--color-primary); text-decoration: none;">Terms & Conditions</a>
            </label>
          </div>
          <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
        <p class="mt-4 text-center text-muted">Already have an account?
          <a href="login.php" class="text-decoration-none" style="color: var(--color-primary); font-weight: 600;">Login</a>
        </p>
      </div>
    </div>
  </div>

  <?php require("script.php");?>
</body>
</html>
