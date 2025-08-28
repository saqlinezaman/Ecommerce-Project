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
        <div class="d-flex justify-content-between items-center px-3">
            <div class="">
                <h3>Users feedback</h3>
                <span class="badge text-bg-info mb-2">Total: <?= count($rows) ?></span>
            </div>
            <div class="">
                <button id="select_delete" class="btn btn-danger btn-sm">Delete</button>
            </div>
        </div>

        <table class="table text-center" id="feedback_table">
            <thead class="table-dark">
                <tr >
                    <th style="width: 40px; text-align: start;" >
                        Select
                        <input type="checkbox" name="selectAll" id="selectAll">
                    </th>
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
                    <tr data-id="<?= (int)$row["id"] ?>">
                        <td style="text-align: start;">
                            <input type="checkbox" name="delete_single" class="delete_single" value="<?= (int)$row["id"] ?>">
                        </td>
                        <td><?= $r + 1 ?></td>
                        <td>
                            <div class="">
                                <strong><?= htmlspecialchars($row['name']) ?>
                                    <?php if ((int) $row['is_registered'] === 0): ?>
                                        <small><i class="fa-solid fa-user-xmark text-danger"
                                                title="Not registered"></i></small></strong>
                                <?php endif; ?>

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
    // reply
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

            var btn = $(this);
            btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Sending...').prop('disabled', true);

            $.ajax({
                url: 'ajax/send_reply.php',
                method: 'POST',
                data: { id: id, reply: txt }
            })
            .done(function (response) {
                if (response.ok) {
                    alert('Reply Sent!');
                    location.reload();
                } else {
                    alert('Error: ' + (response.err || 'Failed to send'));
                }
            })
            .fail(function () {
                alert('Network error. Please try again.');
            })
            .always(function () {
                btn.html('Send').prop('disabled', false);
            });
        });
        });
        // Select all + delete system
        (function () {
            var selectAll = document.getElementById('selectAll');
            var table = document.getElementById('feedback_table');
            var deleteBtn = document.getElementById('select_delete');

            // default hide delete button
            if (deleteBtn) deleteBtn.style.display = "none";

            function updateDeleteBtnState() {
                var sel = table.querySelectorAll('tbody .delete_single:checked').length >0;
                if (deleteBtn) {
                    deleteBtn.style.display = (sel > 0) ? "inline-block" : "none";
                }
            }

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    var rows = table.querySelectorAll('tbody .delete_single');
                    rows.forEach(function (chk) {
                        chk.checked = selectAll.checked;
                    });
                    updateDeleteBtnState();
                });
            }

            table.addEventListener('change', function (e) {
                if (e.target.classList.contains('delete_single')) {
                    var all = table.querySelectorAll('tbody .delete_single').length;
                    var sel = table.querySelectorAll('tbody .delete_single:checked').length;

                    if (selectAll) {
                        selectAll.checked = (all > 0 && sel === all);
                    }
                    updateDeleteBtnState();
                }
            });

          deleteBtn.addEventListener('click', function() {
    var ids = Array.from(table.querySelectorAll('tbody .delete_single:checked')).map(chk => chk.value);

    if(ids.length === 0) return;

    if(!confirm('Delete ' + ids.length + ' message(s)? This action cannot be undone.')) return;

    fetch('ajax/delete_feedback.php', {
        method: "POST",
        headers: {'Content-Type': 'application/json'}, // fix typo
        credentials: 'same-origin',
        body: JSON.stringify({ids: ids})
    })
    .then(r => r.json())
    .then(d => {
        if(d.ok){
            alert('Deleted: '+d.deleted+' message(s).');
            location.reload();
        } else {
            alert(d.error || 'Delete failed');
        }
    })
    .catch(() => alert('Unexpected error'));
});

        })();
    
</script>
