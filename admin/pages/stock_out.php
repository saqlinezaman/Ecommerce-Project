<?php
include __DIR__ . '/../DBConfig.php';

$successMessage = "";

// fetch products for stock in
$statement = $DB_connection->query("SELECT id, product_name, stock_amount FROM products ORDER BY product_name");
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

// check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $remark = $_POST['remark'];

    // update new stock amount
    $update_statement = $DB_connection->prepare("UPDATE products SET stock_amount = stock_amount - ? WHERE id = ?");
    $update_statement->execute([$quantity, $product_id]);

    // insert stock in record
    $insert_statement = $DB_connection->prepare("INSERT INTO inventory (product_id, change_type, quantity, remark) VALUES (?, 'out', ?, ?)");
    $insert_statement->execute([$product_id, $quantity, $remark]);

    header("Location: index.php?page=products&success=1");
    exit;
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';
?>

<div class="content pl-3">
    <div class="col-md-7 mx-auto mt-2">
        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div class='alert alert-success'>Stock Reduce Successfully</div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5>Stock Out</h5>
            </div>
            <div class="card-body">

                <form action="" method="POST">
                    <!-- select product -->
                    <div class="form-group">
                        <label for="">Select Product</label>
                        <select name="product_id" id="product_id" class="form-control" required>
                            <option value="">select</option>
                            <?php foreach ($products as $product): ?>
                                <option value="<?= $product['id'] ?>">
                                    <?= $product['product_name'] ?> (Current : <?= $product['stock_amount'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Quantity -->
                    <div class="form-group">
                        <label for="">Quantity</label>
                        <input type="number" name="quantity" class="form-control" placeholder="Enter Quantity" required>
                    </div>

                    <!-- Remarks -->
                    <div class="form-group">
                        <label for="">Remarks</label>
                        <input type="text" name="remark" class="form-control" placeholder="Enter Remarks">
                    </div>

                    <!-- submit button -->
                    <button type="submit" class="btn btn-danger mt-3">Reduce Stock</button>
                </form>

            </div>
        </div>
    </div>
</div>
<?php
include __DIR__ . '/../includes/footer.php';
?>
