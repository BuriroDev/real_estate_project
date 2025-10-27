<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="author" content="Untree.co" />
  <link rel="shortcut icon" href="favicon.png" />

  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap5" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap"
    rel="stylesheet" />

  <link rel="stylesheet" href="fonts/icomoon/style.css" />
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css" />

  <link rel="stylesheet" href="css/tiny-slider.css" />
  <link rel="stylesheet" href="css/aos.css" />
  <link rel="stylesheet" href="css/style.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <title>
    Real Estate Management
  </title>

  <style>
    #mainDiv {
      margin-top: 100px;
    }
  </style>
</head>

<body>
  <div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header">
      <div class="site-mobile-menu-close">
        <span class="icofont-close js-menu-toggle"></span>
      </div>
    </div>
    <div class="site-mobile-menu-body"></div>
  </div>

  <nav class="site-nav">
    <div class="container">
      <div class="menu-bg-wrap">
        <div class="site-navigation">
          <a href="#" class="logo m-0 float-start">Best Property Site in Pakistan</a>

          <?php if (isset($_SESSION['login'])) : ?>
            <ul
              class="js-clone-nav d-none d-lg-inline-block text-start site-menu float-end">
              <li><a href="home.php">Home</a></li>
              <li class="has-children">
                <a href="properties.php">Properties</a>
                <ul class="dropdown">
                  <li><a href="#">Buy Property</a></li>
                  <li><a href="#">Sell Property</a></li>
                  <li class="has-children">
                    <a href="#">Dropdown</a>
                    <ul class="dropdown">
                      <li><a href="#">Sub Menu One</a></li>
                      <li><a href="#">Sub Menu Two</a></li>
                      <li><a href="#">Sub Menu Three</a></li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li><a href="services.php">Services</a></li>
              <li><a href="about.php">About</a></li>
              <li class="active"><a href="contact.php">Contact Us</a></li>
              <li class="active"><a href="logout.php">logout</a></li>

              <li class="has-children">
                <a href="properties.php">User Info</a>
                <ul class="dropdown">
                  <li><a href="#">Profile</a></li>
                  <li><a href="myPurchase.php">My Purchases</a></li>
                </ul>
              </li>
            </ul>
          <?php endif; ?>

          <a
            href="#"
            class="burger light me-auto float-end mt-1 site-menu-toggle js-menu-toggle d-inline-block d-lg-none"
            data-toggle="collapse"
            data-target="#main-navbar">
            <span></span>
          </a>
        </div>
      </div>
    </div>
  </nav>