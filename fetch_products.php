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
    <div class="card h-100">
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
            <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
            <input type="hidden" name="qty" value="1">
            <button type="submit" class="btn btn-dark btn-sm">Add to Cart</button>
          </form>
        <?php else: ?>
          <button class="btn btn-info text-white btn-sm">Login to add to cart</button>
        <?php endif; ?>

        <a href="product_details.php?id=<?= $product['id']; ?>" class="btn btn-outline-success btn-sm">View</a>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>
