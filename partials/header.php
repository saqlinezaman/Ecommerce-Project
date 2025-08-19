<?php
if (session_status() === PHP_SESSION_NONE)
  session_start();
// make dynamic link for url
$BASE = defined('BASE_URL') ? BASE_URL : ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . '/ecommerce');

$isLoggedIn = !empty($_SESSION['user_id']);
$username = $_SESSION['user_name'] ?? 'Account';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Marhaba eCommerce</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    /* Sidebar link color default black */
    #categoryList a {
      color: black;
    }

    /* Active category style */
    .category-item.active a {
      color: white !important;
    }

    .category-item.active {
      background-color: black !important;
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="#">Marhaba</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- FIXED: added 'div' -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Menu -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link active" href="<?= $BASE ?>">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#">About us</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Shop</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
        </ul>

        <!-- Search -->
        <form class="d-flex me-3">
          <input class="form-control me-2" type="search" placeholder="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>

        <!-- Register & Login OR Dropdown -->
        <?php if (!$isLoggedIn): ?>
          <div>
            <a href="<?= $BASE ?>/register.php" data-bs-target="#registerModal" data-bs-toggle="modal"
              class="btn btn-dark btn-sm">Register</a>
            <!-- login -->
            <a href="<?= $BASE ?>/login.php" data-bs-target="#loginModal" data-bs-toggle="modal"
              class="btn btn-dark btn-sm">Login</a>

          </div>
        <?php else: ?>
          <div class="navbar-nav">
            <div class="nav-item dropdown">
              <a href="#" class="nav-link dropdown-toggle" id="accMenu" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bi bi-person-circle"></i> <?= htmlspecialchars($username) ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accMenu">
                <li><a class="dropdown-item" href="<?= $BASE ?>/profile.php">Profile</a></li>
                <li><a class="dropdown-item" href="<?= $BASE ?>/auth/logout.php">Logout</a></li>
              </ul>
            </div>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </nav>

  <?php if (!$isLoggedIn): ?>

    <!-- login -->

    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Login Marhaba</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <!-- login form -->

            <form method="POST" action="<?= $BASE ?>/auth/login.php">
              <!-- email -->
              <div class="mb-3">
                <label for="username" class="col-form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Input your email" required
                  autocomplete="email">
              </div>
              <!-- password -->
              <div class="mb-1">
                <label for="password" class="col-form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password"
                  placeholder="Input your password" required autocomplete="current-password">
              </div>
              <small><a href="<?= $BASE ?>/auth/forget_password.php">Forget Password</a></small>
              <div class="text-center my-3">
                <button type="submit" class="btn btn-dark" style="width: 100%;">Login</button>
              </div>
            </form>
             <small>Don't have account ? <a href="<?= $BASE ?>/auth/register.php">Register now</a></small>
          </div>
        </div>
      </div>
    </div>

    <!-- register -->

    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Create an account in Marhaba</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <!-- register form -->

            <form method="POST" action="<?= $BASE ?>/auth/register.php">
              <!-- username -->
              <div class="mb-1">
                <label for="username" class="col-form-label">Username:</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Input your username" required autocomplete="username">
              </div>
              <!-- email -->
              <div class="mb-1">
                <label for="username" class="col-form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Input your email" required
                  autocomplete="email">
              </div>
              <!-- password -->
              <div class="mb-1">
                <label for="password" class="col-form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password"
                  placeholder="Input your password" required autocomplete="new-password" minlength="6">
              </div>
              <!-- confirm-password -->
              <div class="mb-1">
                <label for="password" class="col-form-label">Confirm password:</label>
                <input type="password" class="form-control" id="confirm-password" name="confirm-password"
                  placeholder="Confirm your password" required autocomplete="confirm-password" minlength="6">
              </div>
              <small class="mb-1 text-muted">By creating an account, you agree and terms.</small>

              <div class="text-center my-3">
                <button type="submit" class="btn btn-dark" style="width: 100%;">Register</button>
              </div>
            </form>
            <small>Already have account ? <a href="<?= $BASE ?>/auth/login.php">Login now</a></small>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>