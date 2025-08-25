<?php
require_once __DIR__ . "/../../config/db_config.php";
$database = new Database();
$connect = $database->db_connection();
$connect->exec("UPDATE contact_message SET is_read = 1 WHERE is_read = 0");

$sql = "SELECT cm.*, 
    CASE WHEN u.id IS NULL THEN 0 ELSE 1 END AS is_registered 
    FROM contact_message cm
    LEFT JOIN users u ON u.email = cm.email 
    ORDER BY cm.created_at DESC";

$statement = $connect->query($sql);
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content ">
    <div class="table-responsive col-md-12 mx-auto">
        <h3>Users feedback</h3>
        <span class="badge badge-info">Total: <?= count($rows) ?></span>
        <table class="table text-center">
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
                        <td><?= $r + 1 ?></td>
                        <td>
                            <div class="">
                                <strong><?= htmlspecialchars($row['name']) ?>
                                <?php if((int)$row['is_registered'] === 0): ?>
                            <small><i class="fa-solid fa-user-xmark text-danger" title="Not registered"></i></small></strong>
                            <?php endif;?>

                            </div>
                            <?= htmlspecialchars($row['email']) ?>
                        </td>
                        <td><?= htmlspecialchars($row['subject']) ?></td>
                        <td class="small" style="max-width:250px;">
                            <?= nl2br(htmlspecialchars($row['message'] ?: '--')) ?>
                        </td>
                        <td class="small"> <?= htmlspecialchars($row['created_at']) ?></td>
                        <td>
                            <?php if ((int) $row['is_replied'] === 1): ?>
                                <span class="badge rounded-pill text-bg-success">Replied</span>
                            <?php else: ?>
                                <span class="badge rounded-pill text-bg-warning">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td style="min-width: 240px;">
                            <?php if ((int) $row['is_replied'] === 0): ?>
                                <button class="btn btn-success text-white replyBtn" data-id="<?= $row['id'] ?>">Send
                                    reply</button>

                                <!-- reply box -->
                                <div class="replyBox mt-2 text-start d-none" id="replyBox-<?= $row['id']; ?>">
                                    <textarea id="rt-<?= $row['id']; ?>" name="reply" class="form-control mb-2" cols="3"
                                        placeholder="Input your reply..."></textarea>

                                    <button class="btn btn-success sendReply" data-id="<?= $row['id']; ?>">Send</button>
                                    <div class="small text-muted mt-2">This will be emailed to the <b><?= $row['name'] ?></b>
                                    </div>
                                </div>

                            <?php else: ?>
                                <small class=" small text-muted">The reply has been sent to <b><?= $row['name'] ?></b> at
                                    <b><?= htmlspecialchars($row['replied_at']) ?: '--'; ?></b></small>

                                <!-- view reply -->
                                <?php
                                if (!empty($row['replied_text'])): ?>
                                    <details class="mt-1">
                                        <summary>View reply</summary>
                                        <div class="small" style="">
                                            <?= nl2br(htmlspecialchars($row['replied_text'])); ?>
                                        </div>
                                    </details>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(function () {
        $(document).on('click', '.replyBtn', function () {
            var id = $(this).data('id');
            $('#replyBox-' + id).toggleClass('d-none');
        });

        $(document).on('click', '.sendReply', function () {
            var id = $(this).data('id');
            var txt = ($('#rt-' + id).val() || '').trim();

            if (!txt) {
                alert('Please write your reply');
                return;
            }

            // Show loading state
            var btn = $(this);
            btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Sending...').prop('disabled', true);
            
            // AJAX request
            $.ajax({
                url: 'ajax/send_reply.php',
                method: 'POST',
                data: {
                    id: id,
                    reply: txt
                }
            })
            .done(function(response) {
                if (response.ok) {
                    alert('Reply Sent!');
                    location.reload();
                } else {
                    alert('Error: ' + (response.err || 'Failed to send'));
                }
            })
            .fail(function() {
                alert('Network error. Please try again.');
            })
            .always(function() {
                btn.html('Send').prop('disabled', false);
            });
        });
    });
</script>