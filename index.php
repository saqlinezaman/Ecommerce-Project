<?php
if (session_status() == PHP_SESSION_NONE) session_start();

include 'admin/DBConfig.php';
include("partials/header.php");

$cloth_statement = $DB_connection->prepare("SELECT * FROM products WHERE category_id = 34 ORDER BY id DESC");
$cloth_statement->execute();
$cloths = $cloth_statement->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container-fluid my-4">
  <!-- Search -->
       <div class="container-fluid px-4 py-3 mb-3 rounded-1 shadow-sm">
    <form class="d-flex align-items-center justify-content-center ">
        <div class="input-group rounded" style="max-width: 500px; border: 1px solid black; ">
            <span class="input-group-text bg-dark border-0 text-light">
                <i class="fas fa-search"></i>
            </span>
            <input class="form-control bg-light border-0 text-dark "  
                   type="search" 
                   placeholder="Search here..."">
        </div>
        <button class="btn btn-success ms-3 rounded-sm px-4 fw-semibold" type="submit">
            <i class="fas fa-arrow-right me-1"></i>Search
        </button>
    </form>
</div>
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

    <!-- cloth section -->
   <h3 class="mt-5 mb-5">Cloths For you</h3>

<div id="clothCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">

    <?php 
    // প্রতি slide এ 3টা product
    $chunked_cloths = array_chunk($cloths, 3); 
    $active = true;
    foreach ($chunked_cloths as $group): 
    ?>
      <div class="carousel-item <?php echo $active ? 'active' : ''; ?>">
        <div class="">
          <div class="row justify-content-center">
            <?php foreach ($group as $cloth): ?>
              <div class="col-md-4">
                <div class="card mb-3 shadow-sm">
                  <img src="admin/uploads/<?php echo $cloth['product_image']; ?>" 
                       class="card-img-top" 
                       style="height: 300px; object-fit: cover;" 
                       alt="<?php echo $cloth['product_name']; ?>">

                  <div class="card-body text-center">
                    <h6 class="card-title"><?php echo $cloth['product_name']; ?></h6>
                    <p class="card-text"><?php echo $cloth['product_price']; ?> ৳</p>

                    <div class="d-flex gap-2 justify-content-center">
                      <?php if (!empty($_SESSION['user_id'])): ?>
                        <form action="cart_add.php" method="POST" class="m-0">
                          <input type="hidden" name="product_id" value="<?= $cloth['id']; ?>">
                          <input type="hidden" name="qty" value="1">
                          <button type="submit" class="btn btn-dark btn-sm">
                            <i class="bi bi-cart-plus"></i> Add to Cart
                          </button>
                        </form>
                      <?php else: ?>
                        <button class="btn btn-info text-white btn-sm login-cart-btn">
                          Login to add to cart
                        </button>
                      <?php endif; ?>

                      <!-- View Button - Modal Trigger -->
                      <button type="button" 
                              class="btn btn-outline-success btn-sm" 
                              data-bs-toggle="modal" 
                              data-bs-target="#productModal<?= $cloth['id']; ?>">
                        View
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php 
      $active = false;
    endforeach; 
    ?>
  </div>

  <!-- Controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#clothCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#clothCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>





    </div>
  </div>
</main>

<?php include("partials/footer.php"); ?>

