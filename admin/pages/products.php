<?php
include __DIR__ . '/../DBConfig.php';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';
// fetch products from the database
$statement = $DB_connection->prepare("SELECT * FROM products ORDER BY id DESC");
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>
    <!-- bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .thumbnail-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }

        .color-box {
            width: 20px;
            height: 20px;
            display: inline-block;
            margin-right: 5px;
            border-radius: 50%;
            border: 1px solid #000;
        }
    </style>
</head>

<body>
     <div class="content">
        <div class="container">
            <!-- header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>All Product</h2>
             <a href="?page=addProduct" class="btn btn-info text-white">Add Product</a>
        </div>
        <!-- table -->
         <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Image</th>
      <th scope="col">Name</th>
      <th scope="col">Description</th>
      <th scope="col">Stock Amount</th>
      <th scope="col">Product Price</th>
      <th scope="col">Selling Price</th>
      <th scope="col">Category</th>
      <th scope="col">Size</th>
      <th scope="col">Colors</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <!-- get item -->
  <?php if($products): ?>
    <?php foreach ($products as $product): ?>
        <?php
             $product_id = $product['id'];
             $encrypted_id = urldecode(base64_decode($product_id));
             $attribute_statement = $DB_connection->prepare("SELECT * FROM attributes WHERE product_id = ?");
             $attribute_statement->execute([$product_id]);
             $attribute = $attribute_statement->fetch(PDO::FETCH_ASSOC);
             $sizes = $attribute['sizes'] ?? '';
             $colors = $attribute['colors'] ?? '';
            $colorsArray = explode(',', $colors);
            
              ?>
  <tbody>
    <tr>
      <th scope="row"><?= $product['id']; ?></th>
      <td><img class="thumbnail-image" src="uploads/<?php echo htmlspecialchars($product['product_image']);?>" alt=""></td>

      <td><?= $product['product_name']; ?></td>
      <td><?= $product['description']; ?></td>
      <td><?= $product['stock_amount']; ?></td>
      <td><?= $product['product_price']; ?></td>
      <td><?= $product['selling_price']; ?></td>
      <td>
        <?php 
        if(!empty($product['category_id'])) {
            $category_statement = $DB_connection->prepare("SELECT category_name FROM categories WHERE id = ?");
            $category_statement->execute([$product['category_id']]);
            echo htmlspecialchars($category_statement->fetchColumn());
        } else {
            echo 'No category';
        }
         ?>
    </td>
      <td><?php echo $sizes ? htmlspecialchars($sizes) : 'N/A' ?></td>
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
            <a href=""><i class="fa-solid fa-pen-to-square text-secondary"></i></a>
            <a href="" ><i class="fa-solid fa-trash text-danger"></i></a>
        </td>

    </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tbody>
        <tr>
        <td colspan="11" class="text-center">No products found.</td>
        </tr>
    <?php endif; ?>
   
  </tbody>
</table>
     </div> 
     </div>  
</body>

</html>