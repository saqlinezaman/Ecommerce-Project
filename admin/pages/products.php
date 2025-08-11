<?php
include __DIR__ . '/../DBConfig.php';
// delete product
if (isset($_GET['delete_id'])) {
    $delete_id = (int)base64_decode(urldecode($_GET['delete_id']));
    $upload_dir = __DIR__ . '/../uploads/';

    // Image Fetch
    $stmtImg = $DB_connection->prepare("SELECT product_image FROM products WHERE id = ?");
    $stmtImg->execute([$delete_id]);
    $productImg = $stmtImg->fetchColumn();

    if ($productImg && file_exists($upload_dir . $productImg)) {
        if (!unlink($upload_dir . $productImg)) {
            echo "File delete failed: " . $upload_dir . $productImg;
        }
    } else {
        echo "File not found: " . $upload_dir . $productImg;
    }

    // Attribute Delete
    $stmtAttr = $DB_connection->prepare("DELETE FROM attributes WHERE product_id = ?");
    $stmtAttr->execute([$delete_id]);

    // Product Delete
    $stmtDel = $DB_connection->prepare("DELETE FROM products WHERE id = ?");
    $stmtDel->execute([$delete_id]);

    header('Location: ?page=products');
    exit;
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';

// fetch products from the database
$statement = $DB_connection->prepare("SELECT * FROM products ORDER BY id DESC");
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

  <div class="content">
    <div class="container">
      <!-- header -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>All Product</h2>
        <a href="?page=addProduct" class="btn btn-info text-white">Add Product</a>
      </div>
      <!-- table -->
      <table class="table text-center">
        <thead class="rounded">
          <tr class="table-dark">
            <th scope="col">#</th>
            <th scope="col">Image</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Stock</th>
            <th scope="col">Price</th>
            <th scope="col">Sell Price</th>
            <th scope="col">Category</th>
            <th scope="col">Size</th>
            <th scope="col">Colors</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <?php if ($products): ?>
          <?php foreach ($products as $product): ?>
            <?php
            $product_id = $product['id'];
            $encrypted_id = urlencode(base64_encode($product_id));

            // fetch attributes
            $attribute_statement = $DB_connection->prepare("SELECT * FROM attributes WHERE product_id = ?");
            $attribute_statement->execute([$product_id]);
            $attribute = $attribute_statement->fetch(PDO::FETCH_ASSOC);
            $sizes = $attribute['sizes'] ?? '';
            $colors = $attribute['colors'] ?? '';
            $colorsArray = explode(',', $colors);
            ?>
            <tbody class="">
              <tr>
                <th scope="row"><?= $product['id']; ?></th>
                <td><img class="thumbnail-image" src="uploads/<?= htmlspecialchars($product['product_image']); ?>" alt="" /></td>
                <td><?= htmlspecialchars($product['product_name']); ?></td>
                <td><?= htmlspecialchars($product['description']); ?></td>
                <td><?= htmlspecialchars($product['stock_amount']); ?></td>
                <td><?= htmlspecialchars($product['product_price']); ?></td>
                <td><?= htmlspecialchars($product['selling_price']); ?></td>
                <td>
                  <?php
                  if (!empty($product['category_id'])) {
                    $category_statement = $DB_connection->prepare("SELECT category_name FROM categories WHERE id = ?");
                    $category_statement->execute([$product['category_id']]);
                    echo htmlspecialchars($category_statement->fetchColumn());
                  } else {
                    echo 'No category';
                  }
                  ?>
                </td>
                <td><?= $sizes ? htmlspecialchars($sizes) : 'N/A' ?></td>
                <td>
                  <?php
                  if (!empty($colorsArray)) {
                    foreach ($colorsArray as $color) {
                      echo '<span class="color-box" style="background-color: ' . htmlspecialchars($color) . ';"></span>';
                    }
                  } else {
                    echo 'N/A';
                  }
                  ?>
                </td>
                <td>
                  <a href="?page=edit_product&id=<?= $encrypted_id; ?>"><i class="fa-solid fa-pen-to-square text-secondary"></i></a>
                  <!-- delete -->
                  <a href="?page=products&delete_id=<?= $encrypted_id; ?>" onclick="return confirm('Are you sure to delete this product?');"><i class="fa-solid fa-trash text-danger"></i></a>
                  <a href="view_product.php?id=<?= $encrypted_id; ?>"><i class="fa-solid fa-eye text-primary"></i></a>
                </td>
              </tr>
            </tbody>
          <?php endforeach; ?>
        <?php else: ?>
          <tbody>
            <tr>
              <td colspan="11" class="text-center">No products found.</td>
            </tr>
          </tbody>
        <?php endif; ?>
      </table>
    </div>
  </div>
  <!-- Make sure Bootstrap JS is loaded properly -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- If you're using jQuery, make sure it's loaded before Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<?php
include __DIR__ . '/../includes/footer.php';
?>
