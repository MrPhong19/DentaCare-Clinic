<header class="header header-sticky mb-4">
  <div class="container-fluid border-bottom px-4 d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-2">
      <button class="header-toggler" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
        <svg class="icon icon-lg"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-menu"></use></svg>
      </button>
    </div>
    <ul class="header-nav ms-auto">
      <li class="nav-item dropdown">
        <a class="nav-link py-0 pe-0 d-flex align-items-center" data-coreui-toggle="dropdown" href="#" role="button">
          <div class="avatar avatar-md"><img class="avatar-img" src="assets/img/avatars/8.jpg" alt="user"></div>
          <span class="ms-2 d-none d-sm-inline"><?= htmlspecialchars($_SESSION['full_name']) ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-end pt-0">
          <a class="dropdown-item" href="logout.php">
            <svg class="icon me-2"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use></svg> Đăng xuất
          </a>
        </div>
      </li>
    </ul>
  </div>
</header>