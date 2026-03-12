
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

      <ul class="navbar-nav me-auto">

        <!-- PROPERTY MANAGEMENT -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Property Management</a>
          <ul class="dropdown-menu shadow">
            <li><a class="dropdown-item" href="/real_estate_esystem/admin/plots/plots_list.php">All Plots</a></li>
            <li><a class="dropdown-item" href="/real_estate_esystem/admin/plots/form_plot.php">Add Plot</a></li>
            <li><a class="dropdown-item" href="/real_estate_esystem/admin/memberplot/memberplot_list.php">Assign/Allot Plots</a></li>
            <li><a class="dropdown-item" href="/real_estate_esystem/admin/transfer/transfer_list.php">Transfer Plots</a></li>
          </ul>
        </li>

        <!-- PROJECTS -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Projects</a>
          <ul class="dropdown-menu shadow">
            <li><a class="dropdown-item" href="/real_estate_esystem/admin/projects/projects.php">Projects</a></li>
            <li><a class="dropdown-item" href="/real_estate_esystem/admin/sectors/sectors.php">Sectors</a></li>
            <li><a class="dropdown-item" href="/real_estate_esystem/admin/streets/streets.php">Streets</a></li>
            <li><a class="dropdown-item" href="/real_estate_esystem/admin/plot_sizes/plot_size_list.php">Plot Sizes</a></li>
            <li><a class="dropdown-item" href="/real_estate_esystem/admin/charges/charges.php">Charges</a></li>
            <li><a class="dropdown-item" href="/real_estate_esystem/admin/property_type/property_type.php">Property Types</a></li>
          </ul>
        </li>

        <!-- MEMBERS -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Members</a>
          <ul class="dropdown-menu shadow">
            <li><a class="dropdown-item" href="/real_estate_esystem/admin/members/member_list.php">Members List</a></li>
            <li><a class="dropdown-item" href="/real_estate_esystem/admin/members/form_member.php">Add Member</a></li>
          </ul>
        </li>

        <!-- USERS -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Users</a>
          <ul class="dropdown-menu shadow">
            <li><a class="dropdown-item" href="/real_estate_esystem/admin/users/user_list.php">Users List</a></li>
            <li><a class="dropdown-item" href="/real_estate_esystem/admin/users/form_user.php">Add User</a></li>
          </ul>
        </li>

        <!-- MEDIA -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Media</a>
          <ul class="dropdown-menu shadow">
            <li><a class="dropdown-item" href="/real_estate_esystem/admin/sliders/slider_list.php">Slider</a></li>
            <li><a class="dropdown-item" href="/real_estate_esystem/admin/news/news_list.php">News</a></li>
            <li><a class="dropdown-item" href="/real_estate_esystem/admin/sales_centers/sale_center_list.php">Sales Center</a></li>
          </ul>
        </li>

      </ul>

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
