
<!-- ======== TOP NAVIGATION BAR (USER / ADMIN ONLY) ======== -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm border-bottom" style="font-size: 15px;">
  <div class="container-fluid">

    <!-- LEFT SIDE -->
    <a class="navbar-brand fw-bold" href="/real_estate_esystem/admin/index.php">
      🏠 Dashboard
    </a>

    <!-- Hamburger for Mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- MENU -->
    <div class="collapse navbar-collapse" id="topNavbar">

    

      <!-- RIGHT SIDE USER MENU -->
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-bold" href="#" data-bs-toggle="dropdown">
             <?php echo htmlspecialchars($_SESSION['username']); ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow">
            <li><a class="dropdown-item text-danger" href="/real_estate_esystem/admin/logout.php">🚪 Logout</a></li>
          </ul>
        </li>
      </ul>

    </div>

  </div>
</nav>
<!-- ======== END TOP NAVIGATION BAR ======== -->
