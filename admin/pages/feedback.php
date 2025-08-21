<?php

require_once __DIR__ . "/../../config/db_config.php";
$database = new Database();
$connect = $database->db_connection();

$sql = "SELECT cm.*, 

    CASE WHEN u.id IS NULL THEN 0 ELSE 1 END AS is_registered FROM contact_message cm
    LEFT JOIN users u ON u.email = cm.email ORDER BY cm.created_at DESC

";

$statement = $connect->query($sql);
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="content ">
    <div class="table-responsive col-md-12 mx-auto">
        <h3>Users feedback</h3>
        <span class="badge badge-info">Total: <?= count($rows) ?></span>
        <table class="table ">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Message</th>
                    <th scope="col">Receive</th>
                    <th scope="col">Status</th>
                    <th scope="col">Reply</th>

                </tr>
            </thead>

            <tbody>
                <?php foreach ($rows as $r => $row): ?>
                    <tr>
                        <td><?= $r = 1 ?></td>
                        <td>
                            <div class="">
                                <strong><?= htmlspecialchars($row['name']) ?></strong>
                            </div>
                            <?= htmlspecialchars($row['email']) ?>
                        </td>
                        <td><?= htmlspecialchars($row['subject']) ?></td>
                        <td class="small" style="max-width:250px;">
                            <?= nl2br(htmlspecialchars($row['message'] ?: '--')) ?></td>
                        <td class="small" > <?= htmlspecialchars($row['created_at'])
                        ?></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>