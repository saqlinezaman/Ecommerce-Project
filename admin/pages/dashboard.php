<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../DBConfig.php';

$admin_id = $_SESSION['admin_logged_in'] ?? null;

if (!$admin_id) {
    header("Location: ../login.php");
    exit;
}

$statement = $DB_connection->prepare('SELECT * FROM admins WHERE id = ?');
$statement->execute([$admin_id]);
$admin = $statement->fetch(PDO::FETCH_ASSOC);

$admin_image = $admin['profile_image'] ?? 'default.png'; // যদি image না থাকে
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';
?>

<div class="content py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center">
                    <!-- Profile Image -->
                    <div class="mb-4">
                        <img src="uploads/admins/<?= htmlspecialchars($admin_image); ?>" 
                             alt="Admin Photo" 
                             class="rounded-circle border border-3 border-secondary"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    </div>

                    <!-- Admin Name -->
                    <h2 class="card-title mb-2 fw-bold text-primary">
                        Hey <?= htmlspecialchars($admin['username']); ?>!
                    </h2>

                    <!-- Admin Email -->
                    <p class="card-text text-muted mb-3">
                        <i class="bi bi-envelope-fill me-2"></i>
                        <?= htmlspecialchars($admin['email']); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<?php
include __DIR__ . '/../includes/footer.php';
?>
