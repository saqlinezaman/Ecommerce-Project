<?php
include 'admin/DBConfig.php';
$statement = $DB_connection->prepare("SELECT * FROM categories ORDER BY id ASC");
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<aside class="col-md-3 mb-4">
  <h5>Categories</h5>
  <ul class="list-group" id="categoryList">
    <a href="#productContainer" class="list-group-item mb-1 category-item active bg-dark text-light" data-id="0">All Products</a>
    <?php foreach($categories  as $category ): ?>
      <a href="#productContainer" class="list-group-item mb-1 category-item" data-id="<?= $category['id'] ?>"><?= $category['category_name'] ?></a>
    <?php endforeach;?>
  </ul>
</aside>