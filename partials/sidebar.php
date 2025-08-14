<?php
include 'admin/DBConfig.php';
$statement = $DB_connection->prepare("SELECT * FROM categories ORDER BY id ASC");
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<aside class="col-md-3 mb-4">
  <h5>Categories</h5>
  <ul class="list-group" id="categoryList">
    <li class="list-group-item mb-1 category-item active bg-dark text-light" data-id="0">
      <a href="#productContainer" class="text-light text-decoration-none">All Products</a>
    </li>
    <?php foreach($categories as $category): ?>
      <li class="list-group-item mb-1 category-item" data-id="<?= $category['id'] ?>">
        <a href="#productContainer" class="text-decoration-none"><?= $category['category_name'] ?></a>
      </li>
    <?php endforeach; ?>
  </ul>
</aside>
