<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- ======== TOP NAVIGATION BAR (Elegant Menu) ======== -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm border-bottom" style="font-size: 15px;">
  <div class="container-fluid">

    <!-- LEFT SIDE -->
    <a class="navbar-brand fw-bold" href="./client-dashboard.php">
      🏠 Dashboard
    </a>

    <!-- Hamburger for Mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- MENU ITEMS -->
    <div class="collapse navbar-collapse" id="topNavbar">
  

      <!-- RIGHT SIDE USER MENU -->
     <?php if(isset($_SESSION['username'])) { ?>
    <a class="nav-link dropdown-toggle fw-bold" href="#" data-bs-toggle="dropdown">
        <?php echo $_SESSION['username']; ?>
    </a>
<?php } ?>

      
    </div>

  </div>
</nav>
<!-- ======== END TOP NAVIGATION BAR ======== -->
