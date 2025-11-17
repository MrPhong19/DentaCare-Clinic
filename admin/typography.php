
<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>Typography | Admin</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/manifest.json">
    <meta name="theme-color" content="#ffffff">

    <!-- Vendors styles-->
    <link rel="stylesheet" href="vendors/simplebar/css/simplebar.css">
    <link rel="stylesheet" href="css/vendors/simplebar.css">

    <!-- Main styles -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/examples.css" rel="stylesheet">

    <script src="js/config.js"></script>
    <script src="js/color-modes.js"></script>
  </head>
  <body>
    <div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
      <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
          <svg class="sidebar-brand-full" width="88" height="32" alt="CoreUI Logo">
            <use xlink:href="assets/brand/coreui.svg#full"></use>
          </svg>
          <svg class="sidebar-brand-narrow" width="32" height="32" alt="CoreUI Logo">
            <use xlink:href="assets/brand/coreui.svg#signet"></use>
          </svg>
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-theme="dark" aria-label="Close" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"></button>
      </div>
      <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <!-- trang chính dùng .php -->
        <li class="nav-item"><a class="nav-link" href="index.php">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-speedometer"></use>
            </svg> Dashboard</a></li>

        <li class="nav-title">Theme</li>
        <li class="nav-item"><a class="nav-link" href="colors.php">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-drop"></use>
            </svg> Colors</a></li>
        <li class="nav-item"><a class="nav-link active" href="typography.php">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-pencil"></use>
            </svg> Typography</a></li>

        <li class="nav-title">Components</li>
        <!-- như các trang khác: demo trong folder con để .html -->
        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-puzzle"></use>
            </svg> Base</a>
          <ul class="nav-group-items compact">
            <li class="nav-item"><a class="nav-link" href="base/accordion.html">Accordion</a></li>
            <li class="nav-item"><a class="nav-link" href="base/breadcrumb.html">Breadcrumb</a></li>
            <li class="nav-item"><a class="nav-link" href="base/cards.html">Cards</a></li>
            <li class="nav-item"><a class="nav-link" href="base/carousel.html">Carousel</a></li>
            <li class="nav-item"><a class="nav-link" href="base/collapse.html">Collapse</a></li>
            <li class="nav-item"><a class="nav-link" href="base/list-group.html">List group</a></li>
            <li class="nav-item"><a class="nav-link" href="base/navs-tabs.html">Navs &amp; Tabs</a></li>
            <li class="nav-item"><a class="nav-link" href="base/pagination.html">Pagination</a></li>
            <li class="nav-item"><a class="nav-link" href="base/placeholders.html">Placeholders</a></li>
            <li class="nav-item"><a class="nav-link" href="base/popovers.html">Popovers</a></li>
            <li class="nav-item"><a class="nav-link" href="base/progress.html">Progress</a></li>
            <li class="nav-item"><a class="nav-link" href="base/spinners.html">Spinners</a></li>
            <li class="nav-item"><a class="nav-link" href="base/tables.html">Tables</a></li>
            <li class="nav-item"><a class="nav-link" href="base/tooltips.html">Tooltips</a></li>
          </ul>
        </li>

        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-cursor"></use>
            </svg> Buttons</a>
          <ul class="nav-group-items compact">
            <li class="nav-item"><a class="nav-link" href="buttons/buttons.html">Buttons</a></li>
            <li class="nav-item"><a class="nav-link" href="buttons/button-group.html">Buttons Group</a></li>
            <li class="nav-item"><a class="nav-link" href="buttons/dropdowns.html">Dropdowns</a></li>
          </ul>
        </li>

        <li class="nav-item"><a class="nav-link" href="charts.php">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chart-pie"></use>
            </svg> Charts</a></li>

        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-notes"></use>
            </svg> Forms</a>
          <ul class="nav-group-items compact">
            <li class="nav-item"><a class="nav-link" href="forms/checks-radios.html">Checks and radios</a></li>
            <li class="nav-item"><a class="nav-link" href="forms/floating-labels.html">Floating labels</a></li>
            <li class="nav-item"><a class="nav-link" href="forms/form-control.html">Form Control</a></li>
            <li class="nav-item"><a class="nav-link" href="forms/input-group.html">Input group</a></li>
            <li class="nav-item"><a class="nav-link" href="forms/select.html">Select</a></li>
            <li class="nav-item"><a class="nav-link" href="forms/layout.html">Layout</a></li>
            <li class="nav-item"><a class="nav-link" href="forms/validation.html">Validation</a></li>
          </ul>
        </li>

        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-star"></use>
            </svg> Pages</a>
          <ul class="nav-group-items compact">
            <li class="nav-item"><a class="nav-link" href="login.php" target="_top">
                <svg class="nav-icon">
                  <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                </svg> Login</a></li>
            <li class="nav-item"><a class="nav-link" href="register.php" target="_top">
                <svg class="nav-icon">
                  <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                </svg> Register</a></li>
            <li class="nav-item"><a class="nav-link" href="404.php" target="_top">
                <svg class="nav-icon">
                  <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bug"></use>
                </svg> Error 404</a></li>
            <li class="nav-item"><a class="nav-link" href="500.php" target="_top">
                <svg class="nav-icon">
                  <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bug"></use>
                </svg> Error 500</a></li>
          </ul>
        </li>

        <li class="nav-item mt-auto"><a class="nav-link" href="https://coreui.io/bootstrap/docs/templates/installation/" target="_blank">
            <svg class="nav-icon">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-description"></use>
            </svg> Docs</a></li>
      </ul>
      <div class="sidebar-footer border-top d-none d-md-flex">
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
      </div>
    </div>

    <div class="wrapper d-flex flex-column min-vh-100">
      <header class="header header-sticky p-0 mb-4">
        <div class="container-fluid border-bottom px-4">
          <button class="header-toggler" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()" style="margin-inline-start: -14px;">
            <svg class="icon icon-lg">
              <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-menu"></use>
            </svg>
          </button>
          <ul class="header-nav d-none d-lg-flex">
            <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
          </ul>
          <ul class="header-nav ms-auto">
            <li class="nav-item py-1">
              <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
            </li>
            <li class="nav-item dropdown">
              <button class="btn btn-link nav-link py-2 px-2 d-flex align-items-center" type="button" aria-expanded="false" data-coreui-toggle="dropdown">
                <svg class="icon icon-lg theme-icon-active">
                  <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-contrast"></use>
                </svg>
              </button>
              <ul class="dropdown-menu dropdown-menu-end" style="--cui-dropdown-min-width: 8rem;">
                <li>
                  <button class="dropdown-item d-flex align-items-center" type="button" data-coreui-theme-value="light">
                    <svg class="icon icon-lg me-3">
                      <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-sun"></use>
                    </svg>Light
                  </button>
                </li>
                <li>
                  <button class="dropdown-item d-flex align-items-center" type="button" data-coreui-theme-value="dark">
                    <svg class="icon icon-lg me-3">
                      <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-moon"></use>
                    </svg>Dark
                  </button>
                </li>
                <li>
                  <button class="dropdown-item d-flex align-items-center active" type="button" data-coreui-theme-value="auto">
                    <svg class="icon icon-lg me-3">
                      <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-contrast"></use>
                    </svg>Auto
                  </button>
                </li>
              </ul>
            </li>
            <li class="nav-item py-1">
              <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link py-0 pe-0 d-flex align-items-center" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-md"><img class="avatar-img" src="assets/img/avatars/8.jpg" alt="user"></div>
                <span class="ms-2 d-none d-sm-inline"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-end pt-0">
                <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2">Account</div>
                <a class="dropdown-item" href="logout.php">
                  <svg class="icon me-2">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                  </svg> Logout
                </a>
              </div>
            </li>
          </ul>
        </div>
        <div class="container-fluid px-4">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item"><span>Theme</span></li>
              <li class="breadcrumb-item active"><span>Typography</span></li>
            </ol>
          </nav>
        </div>
      </header>

      <div class="body flex-grow-1">
        <div class="container-lg px-4">
          <!-- phần nội dung demo typography giữ nguyên -->
          <div class="card mb-4">
            <div class="card-header">Headings</div>
            <div class="card-body">
              <p>Documentation and examples for Bootstrap typography, including global settings, headings, body text, lists, and more.</p>
              <table class="table">
                <thead>
                  <tr>
                    <th>Heading</th>
                    <th>Example</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><code>&lt;h1&gt;&lt;/h1&gt;</code></td>
                    <td><span class="h1">h1. Bootstrap heading</span></td>
                  </tr>
                  <tr>
                    <td><code>&lt;h2&gt;&lt;/h2&gt;</code></td>
                    <td><span class="h2">h2. Bootstrap heading</span></td>
                  </tr>
                  <tr>
                    <td><code>&lt;h3&gt;&lt;/h3&gt;</code></td>
                    <td><span class="h3">h3. Bootstrap heading</span></td>
                  </tr>
                  <tr>
                    <td><code>&lt;h4&gt;&lt;/h4&gt;</code></td>
                    <td><span class="h4">h4. Bootstrap heading</span></td>
                  </tr>
                  <tr>
                    <td><code>&lt;h5&gt;&lt;/h5&gt;</code></td>
                    <td><span class="h5">h5. Bootstrap heading</span></td>
                  </tr>
                  <tr>
                    <td><code>&lt;h6&gt;&lt;/h6&gt;</code></td>
                    <td><span class="h6">h6. Bootstrap heading</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- anh cứ giữ nguyên các card còn lại -->
        </div>
      </div>

      <footer class="footer px-4">
        <div><a href="https://coreui.io">CoreUI </a><a href="https://coreui.io/product/free-bootstrap-admin-template/">Bootstrap Admin Template</a> © 2025 creativeLabs.</div>
        <div class="ms-auto">Powered by&nbsp;<a href="https://coreui.io/bootstrap/docs/">CoreUI UI Components</a></div>
      </footer>
    </div>

    <!-- CoreUI and necessary plugins-->
    <script src="vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
    <script src="vendors/simplebar/js/simplebar.min.js"></script>
    <script>
      const header = document.querySelector('header.header');
      document.addEventListener('scroll', () => {
        if (header) {
          header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
        }
      });
    </script>
  </body>
</html>
