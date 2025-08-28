<?php
include 'admin/DBConfig.php';
include("partials/header.php");

$product_statement = $DB_connection->prepare("SELECT * FROM products ORDER BY id DESC");
$product_statement->execute();
$products = $product_statement->fetchAll(PDO::FETCH_ASSOC);
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
      <h3  class="my-5">All Products</h3>
      <div class="row row-cols-1 row-cols-md-3 g-4" id="productContainer">
  <?php foreach ($products as $product): ?>
    <div class="col">
      <div class="card h-100">
        <div class="overflow-hidden" style="height: 250px;">
          <img src="admin/uploads/<?= htmlspecialchars($product['product_image']); ?>" class="w-100 h-100"
            alt="<?= htmlspecialchars($product['product_name']); ?>" style="object-fit: cover;">
        </div>
        <div class="card-body">
          <h6 class="card-title"><?= htmlspecialchars($product['product_name']); ?></h6>
          <p>$<?= htmlspecialchars($product['product_price']); ?></p>
          <a href="#" class="btn btn-dark btn-sm">Add to Cart</a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>


    </div>
  </div>
</main>

<?php include("partials/footer.php"); ?>
