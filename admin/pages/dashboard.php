<?php
if (session_status() === PHP_SESSION_NONE) { // FIX: prevents double session start
    session_start();
}

include __DIR__ . '/../DBConfig.php'; // If DBConfig.php is inside /admin/

$admin_id = $_SESSION['admin_logged_in'] ?? null;

if (!$admin_id) {
    header("Location: ../login.php");
    exit;
}

$statement = $DB_connection->prepare('SELECT * FROM admins WHERE id = ?');
$statement->execute([$admin_id]);
$admin = $statement->fetch(PDO::FETCH_ASSOC);

// If "includes" folder is inside /admin/
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';

// If "includes" folder is in project root /Ecommerce/
// include __DIR__ . '/../../includes/header.php';
// include __DIR__ . '/../../includes/sidebar.php';
?>
<div class="content">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card bg-info bg-opacity-25">
                <div class="card-body">
                    <div class="mb-3">
                        <img  src="uploads/admins/<?= htmlspecialchars($admin_image) ?>" alt="No photo found" height="300px" width="300px">
                    </div>
                    <h2 class="card-title">
                        HEY <?= htmlspecialchars($admin['username']); ?>
                    </h2>
                    <h3>Your Email is: <?= htmlspecialchars($admin['email']); ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Make sure Bootstrap JS is loaded properly -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- If you're using jQuery, make sure it's loaded before Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<?php
include __DIR__ . '/../includes/footer.php';
?>

