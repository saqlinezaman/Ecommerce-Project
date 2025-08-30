<?php
if (session_status() === PHP_SESSION_NONE)
  session_start();
// make dynamic link for url
$BASE = defined('BASE_URL') ? BASE_URL : ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . '/ecommerce');

$isLoggedIn = !empty($_SESSION['user_id']);
$username = $_SESSION['user_name'] ?? 'Account';

// cart count
$cartCount = 0;
try {

  require_once __DIR__ . '/../admin/DBConfig.php';

  if ($isLoggedIn && isset($DB_connection)) {
    $user_id = (int) $_SESSION['user_id'];
    $statement = $DB_connection->prepare('SELECT id FROM carts WHERE user_id = ? AND  status="open" LIMIT 1');
    $statement->execute([$user_id]);
    $cart_id = $statement->fetch(PDO::FETCH_ASSOC)['id'] ?? null;

    if ($cart_id) {
      $statement = $DB_connection->prepare('SELECT COALESCE(SUM(quantity),0) AS c FROM cart_items WHERE cart_id = ?');
      $statement->execute([$cart_id]);

      $cartCount = (int) $statement->fetch(PDO::FETCH_ASSOC)['c'] ?? 0;

    }
  } else {
    if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {

      foreach ($_SESSION['cart'] as $q) {
        $cartCount += (int) $q;
      }
    }
  }
} catch (Throwable $e) {

}
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
   /* Control button গুলো মোটা কালো গোল */
#clothCarousel .carousel-control-prev-icon,
#clothCarousel .carousel-control-next-icon {
  background-color: black;   /* কালো রঙ */
  border-radius: 50%;        /* গোল বাটন */
  width: 40px;
  height: 40px;
  background-size: 60%, 60%;
}

/* Control container এর ভেতর রাখবো */
#clothCarousel .carousel-control-prev,
#clothCarousel .carousel-control-next {
  width: 8%;          /* সাইজ fix */
  opacity: 0.8;       /* হালকা ট্রান্সপারেন্সি */
}

/* Hover করলে আরো স্পষ্ট */
#clothCarousel .carousel-control-prev:hover,
#clothCarousel .carousel-control-next:hover {
  opacity: 1;
}
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mx-1">
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
          <li class="nav-item"><a class="nav-link" href="<?= $BASE ?>/aboutUs.php"">About us</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= $BASE ?>/shop.php">Shop</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= $BASE ?>/contact.php">Contact</a></li>
        </ul>

        

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
              <ul class="dropdown-menu dropdown-menu-end m-1 p-1" aria-labelledby="accMenu">
                <li><a class="dropdown-item mb-1" href="<?= $BASE ?>/profile.php">Profile</a></li>
                <li><a class="dropdown-item bg-danger text-white" href="<?= $BASE ?>/auth/logout.php">Logout</a></li>

              </ul>

            </div>

          </div>
        <?php endif; ?>

      </div>
      <!-- cart btn -->
    </div>
     <a class="mx-2 text-black position-relative" style="font-size:20px;" href="<?= $BASE ?>/cart.php">
        <i class="fa-solid fa-cart-shopping text-dark"></i>
        <span id="navCardCount" class="badge text-bg-danger rounded-pill" style="position: absolute; top: 2px; right: 0%; transform: translate(50%,-50%);
               font-size: 12px; min-width: 18px; padding: 3px 6px;">
          <?= $cartCount; ?>
        </span>
      </a>
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
            <small class="text-muted">Don't have account ? <a href="<?= $BASE ?>/auth/register.php">Register
                now</a></small>
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
                <input type="text" class="form-control" name="username" id="username" placeholder="Input your username"
                  required autocomplete="username">
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
            <small class="text-muted">Already have account ? <a href="<?= $BASE ?>/auth/login.php">Login now</a></small>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <script>
    window.updateNavCartBadge =function(totalQty){
      var badge = document.getElementById('navCardCount');

      if(!badge) return;
      badge.textContent = (parseInt(totalQty,10) || 0);
    }
  </script>