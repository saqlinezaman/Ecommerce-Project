<?php
if (session_status() == PHP_SESSION_NONE) session_start();

include 'admin/DBConfig.php';

$category_id = isset($_GET['category_id']) ? (int) $_GET['category_id'] : 0;

if ($category_id == 0) {
    $stmt = $DB_connection->prepare("SELECT * FROM products ORDER BY id DESC");
    $stmt->execute();
} else {
    $stmt = $DB_connection->prepare("SELECT * FROM products WHERE category_id = ? ORDER BY id DESC");
    $stmt->execute([$category_id]);
}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row row-cols-1 row-cols-md-3 g-4">
<?php foreach ($products as $product): ?>
  <div class="col">
    <div class="card h-100 product-card">
      <div class="overflow-hidden" style="height: 250px;">
        <img src="admin/uploads/<?= htmlspecialchars($product['product_image']); ?>" 
             class="w-100 h-100"
             alt="<?= htmlspecialchars($product['product_name']); ?>" 
             style="object-fit: cover;">
      </div>
      <div class="card-body">
        <h6 class="card-title"><?= htmlspecialchars($product['product_name']); ?></h6>
        <p>$<?= htmlspecialchars($product['product_price']); ?></p>

        <!-- Cart -->
        <div class="d-flex gap-2">
        <?php if (!empty($_SESSION['user_id'])): ?>
          <form action="cart_add.php" method="POST" class="m-0">
            <input type="hidden" name="product_id" value="<?=(int) $product['id']; ?>">
            <button type="submit" class="btn btn-dark btn-sm"> <i class="bi bi-cart-plus"></i> Add to Cart</button>
          </form>
        <?php else: ?>
          <button class="btn btn-info text-white btn-sm login-cart-btn">Login to add to cart</button>
        <?php endif; ?>

        <!-- View Button - Modal Trigger -->
        <button type="button" 
                class="btn btn-outline-success btn-sm" 
                data-bs-toggle="modal" 
                data-bs-target="#productModal<?= $product['id']; ?>">
          View
        </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for this Product -->
  <!-- Product Modal -->
<div class="modal fade" id="productModal<?= $product['id']; ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      
      <!-- Header -->
      <div class="modal-header border-0 bg-gradient bg-dark text-white py-3">
        <h5 class="modal-title fw-bold">
          <i class="bi bi-box-seam"></i> <?= htmlspecialchars($product['product_name']); ?>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body p-4">
        <div class="row g-4 align-items-center">
          
          <!-- Product Image -->
          <div class="col-md-6">
            <div class="ratio ratio-4x3 border rounded shadow-sm bg-light">
              <img src="admin/uploads/<?= htmlspecialchars($product['product_image']); ?>" 
                   class="img-fluid rounded object-fit-cover" 
                   alt="<?= htmlspecialchars($product['product_name']); ?>">
            </div>
          </div>

          <!-- Product Details -->
          <div class="col-md-6">
            <h4 class="fw-bold mb-2"><?= htmlspecialchars($product['product_name']); ?></h4>
            <h5 class="text-success mb-3">$<?= htmlspecialchars($product['product_price']); ?></h5>
            <p class="text-muted mb-4">
              <?= !empty($product['description']) ? htmlspecialchars($product['description']) : 'No description available.'; ?>
            </p>

            <?php if (!empty($_SESSION['user_id'])): ?>
              <form action="cart_add.php" method="POST" class="d-flex align-items-end gap-3">
                <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                <div>
                  <label for="qty<?= $product['id']; ?>" class="form-label small fw-semibold mb-1">Quantity</label>
                  <input type="number" id="qty<?= $product['id']; ?>" 
                         name="qty" value="1" min="1" 
                         class="form-control form-control-sm" 
                         style="width:90px;">
                </div>
                <button type="submit" class="btn btn-dark px-4 py-2  shadow-sm w-100">
                  <i class="bi bi-cart-plus"></i> Add to Cart
                </button>
              </form>
            <?php else: ?>
              <a href="auth/login.php" class="btn btn-info text-white px-4 py-2 w-100 shadow-sm">
                <i class="bi bi-box-arrow-in-right"></i> Login to add to cart
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div class="modal-footer border-0 bg-light py-3">
        <button type="button" class="btn btn-secondary rounded px-4" data-bs-dismiss="modal">
          <i class="bi bi-x-circle"></i> Close
        </button>
      </div>
    </div>
  </div>
</div>


<?php endforeach; ?>
</div>
