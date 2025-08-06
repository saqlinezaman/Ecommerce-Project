<?php

include __DIR__ . '/../DBConfig.php';

$query = "SELECT i.*, p.product_name FROM inventory i JOIN products P ON i.product_id = p.id ORDER BY i.created_at DESC ";

$statement = $DB_connection->query($query);
$logs = $statement->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory report</title>
</head>
<body>
    <div class="content">
    <div class="row">
        <div class="col-sm-10 mx-auto mt-3">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title">Inventory report</h3>
                </div>
                <div class="card-body">
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
                            <?php foreach($logs as $log):?>
                            <tr>
                                <td><?= $log['created_at'] ?></td>
                                <td><?= htmlspecialchars($log['product_name'])?></td>
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
                            <?php endforeach ;?>
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>