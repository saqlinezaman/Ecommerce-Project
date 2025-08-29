<?php
if (session_status() == PHP_SESSION_NONE) session_start();

include 'admin/DBConfig.php';
include("partials/header.php");
?>

<main class="container-fluid my-4">
  <div class="row">
    <?php include("partials/sidebar.php"); ?>
    <div class="col-md-9">

      <!-- Slider -->
      <div id="mainSlider" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="ratio ratio-21x9">
              <img src="asset/images/slider 1.jpg" class="d-block w-100" alt="Slider 1" style="object-fit: cover;">
            </div>
          </div>
          <div class="carousel-item">
            <div class="ratio ratio-21x9">
              <img src="asset/images/slider 2.jpg" class="d-block w-100" alt="Slider 2" style="object-fit: cover;">
            </div>
          </div>
          <div class="carousel-item">
            <div class="ratio ratio-21x9">
              <img src="asset/images/slider 3.jpg" class="d-block w-100" alt="Slider 3" style="object-fit: cover;">
            </div>
          </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#mainSlider" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainSlider" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>

      <!-- Products -->
      <h3 class="my-5">All Products</h3>
      <div id="productContainer">
        <?php include("fetch_products.php"); ?>
      </div>

    </div>
  </div>
</main>

<?php include("partials/footer.php"); ?>
