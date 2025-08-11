<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../DBConfig.php';

$admin_id = $_SESSION['admin_logged_in'] ?? null;

if (!$admin_id) {
    // FIXED: header syntax (removed double colon)
    header('Location: ../login.php');
    exit;
}

// fetch admin info
$statement = $DB_connection->prepare('SELECT * FROM admins WHERE id = ?');
$statement->execute([$admin_id]);
$admin = $statement->fetch(PDO::FETCH_ASSOC);

$message = "";

// define image_name and hashed_password with default old values
$image_name = $admin['image'];
$hashed_password = $admin['password'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];
    
    // REMOVED: $_POST["image"] (file uploads are handled via $_FILES)

    // image upload
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "uploads/admins/";
        if (!is_dir($target_dir)) {
            // FIXED: removed $ from mkdir and set correct permission (0777 not 777)
            mkdir($target_dir, 0777, true);
        }
        $image_name = time() . '-' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $image_name);
    }

    // password change logic
    if (!empty($current_password)) {
        if (password_verify($current_password, $admin['password'])) {
            if ($new_password == $confirm_password) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            } else {
                $message = '<div class="alert alert-danger">New Password does not match</div>';
            }
        } else {
            $message = '<div class=" alert alert-danger">Current password is incorrect</div>';
        }
    }

    // update database if no error
    if (empty($message)) {
        $statement = $DB_connection->prepare('UPDATE admins SET username = ?, email = ?, password = ?, image = ? WHERE id = ?');
        $statement->execute([$username, $email, $hashed_password, $image_name, $admin_id]);
        $message = '<div class="alert alert-success">Profile Updated Successfully</div>';

        // refresh form data
        $statement = $DB_connection->prepare("SELECT * FROM admins WHERE id = ?");
        $statement->execute([$admin_id]);
        $admin = $statement->fetch(PDO::FETCH_ASSOC);
    }
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';
?>

<div class="content">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h1>Update Your profile</h1>
                    <?= $message; ?>
                </div>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <!-- username -->
                        <div class="mb-3">
                            <label for="" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($admin['username']) ?>" aria-describedby="emailHelp">
                        </div>
                        <!-- email -->
                        <div class="mb-3">
                            <label for="" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($admin['email']) ?>" aria-describedby="emailHelp">
                        </div>
                        <!-- image -->
                        <div class="mb-3">
                            <label for="" class="form-label">Image</label>
                            <?php if ($admin['image']): ?>
                                <!-- FIXED: removed extra space after /admins/ -->
                                <img src="uploads/admins/<?= $admin['image'] ?>" width='80px' class='rounded mb-2' alt="No image found">
                            <?php endif; ?>    
                            <input type="file" name="image" class="form-control" aria-describedby="emailHelp">
                        </div>
                        <!-- current_password -->
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Old Password</label>
                            <input type="password" name="current_password" class="form-control" id="exampleInputPassword1">
                        </div>
                        <!-- new pass -->
                        <div class="mb-3">
                            <label for="exampleInputPassword2" class="form-label">New Password</label>
                            <input type="password" name="new_password" class="form-control" id="exampleInputPassword2">
                        </div>
                        <!-- confirm new pass -->
                        <div class="mb-3">
                            <label for="exampleInputPassword3" class="form-label">Confirm New Password</label>
                            <!-- FIXED: type was old_password, changed to password -->
                            <input type="password" name="confirm_password" class="form-control" id="exampleInputPassword3">
                        </div>
                        <button type="submit" class="btn btn-success">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ------------------------------------------------------------------------------------->
<!-- Make sure Bootstrap JS is loaded properly -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- If you're using jQuery, make sure it's loaded before Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<?php
include __DIR__ . '/../includes/footer.php';
?>
