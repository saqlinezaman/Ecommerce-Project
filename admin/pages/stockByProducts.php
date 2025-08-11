<?php
include __DIR__ . '/../DBConfig.php';

// fetch products
$statement = $DB_connection->query("SELECT id, product_name, stock_amount FROM products ORDER BY product_name");
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

$selected_product_id = $_GET['product_id'] ?? null;
$logs = [];

if($selected_product_id){
    // select product logs
    $query = "SELECT i.*, p.product_name FROM inventory i JOIN products p ON i.product_id = p.id WHERE i.product_id = ? ORDER BY i.created_at DESC";
    $statement2 = $DB_connection->prepare($query);
    $statement2->execute([$selected_product_id]);
    $logs = $statement2->fetchAll(PDO::FETCH_ASSOC);
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';
?>

<div class="content">
    <div class="row">
        <div class="col-sm-7 mx-auto mt-3">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h3 class="card-title">Stock by Product</h3>
                </div>
                <div class="card-body">
                    <form action="" method="GET" class="row gy-2 gx-2 align-items-end">
                        <input type="hidden" name="page" value="stockByProducts">
                        <div class="col-md-9">
                            <label for="product_id">Select Product</label>
                            <select name="product_id" class="form-control" required>
                                <option value="">Select</option>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?= $product['id'] ?>" <?= $selected_product_id == $product['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($product['product_name']) ?> (Stock: <?= htmlspecialchars($product['stock_amount']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">Show</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php if($selected_product_id): ?>
        <div class="col-sm-10 mx-auto mt-3">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title">
                        Stock history for <?= htmlspecialchars($logs[0]['product_name'] ?? 'Unknown Product') ?>
                    </h3>
                </div>
                <div class="card-body">
                    <?php if(count($logs) > 0): ?>
                    <table class="table table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th>Date</th>
                                <th>Change Type</th>
                                <th>Quantity</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs as $log): ?>
                                <tr>
                                    <td><?= htmlspecialchars($log['created_at']) ?></td>
                                    <td>
                                        <?php if($log['change_type'] === 'in'): ?>
                                            <span class="badge bg-success">IN</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">OUT</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($log['quantity']) ?></td>
                                    <td><?= htmlspecialchars($log['remark']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                        <div class="alert alert-warning mb-0">No stock history found for this product.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<!-- Make sure Bootstrap JS is loaded properly -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- If you're using jQuery, make sure it's loaded before Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
