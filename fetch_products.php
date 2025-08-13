<?php
include 'admin/DBConfig.php';

$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

if($category_id == 0){
    $stmt = $DB_connection->prepare("SELECT * FROM products ORDER BY id DESC");
    $stmt->execute();
} else {
    $stmt = $DB_connection->prepare("SELECT * FROM products WHERE category_id = ? ORDER BY id DESC");
    $stmt->execute([$category_id]);
}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($products as $product): ?>
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
