<?php

include __DIR__ . '/../DBConfig.php';

$query = "SELECT i.*, p.product_name FROM inventory i JOIN products p ON i.product_id = p.id ORDER BY i.created_at DESC";
$statement = $DB_connection->query($query);
$logs = $statement->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';

?>

<div class="content">
    <div class="row">
        <div class="col-12 col-md-9 mx-auto mt-3">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title">Inventory report</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>Date</th>
                                    <th>Product</th>
                                    <th>Change type</th>
                                    <th>Quantity</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($logs as $log): ?>
                                <tr>
                                    <td><?= $log['created_at'] ?></td>
                                    <td><?= htmlspecialchars($log['product_name']) ?></td>
                                    <td>
                                        <?php if($log['change_type'] === 'in'): ?>
                                            <span class="badge bg-success">IN</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">OUT</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $log['quantity'] ?></td>
                                    <td><?= $log['remark'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Prevent horizontal scroll -->
<style>
    body {
        overflow-x: hidden;
    }
</style>
