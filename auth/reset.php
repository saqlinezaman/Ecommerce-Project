<?PHP

require_once __DIR__ . "/../config/class.user.php";
$user = new User();

$BASE = defined('BASE_URL')
    ? BASE_URL
    : (
        (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http')
        . '://'
        . ($_SERVER['HTTP_HOST'] ?? 'localhost')
        . '/ecommerce'
    );

$message = '';
$token = $_GET['token'] ?? '';
$email = $_GET['email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    try {
        $new = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (!$token || !$email) {
            throw new Exception('Invalid reset link');
        }

        if (strlen($new) < 6) {
            throw new Exception('Password must me at list 6 character.');
        }
        if ($new != $confirm_password) {
            throw new Exception('Password does not match!');
        }
        $user->resetPassword($email, $token, $new);
        $message = '<div class="alert alert-success">Password successfully reset you can now log in</div>';
    } catch (Exception $e) {
        $message = '<div class="alert alert-danger">' . htmlspecialchars($e->getMessage()) . '</div>';
    }

}

?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-5" style="max-width: 720px;">
    <div class="card">
        <div class="card-header">
            <h3 class="mb-1">Reset password</h3>
            <?php if ($message): ?>
                <?= $message ?>
                <?php if (strpos($message, 'successfully') !== false): ?>

                    <a href="<?= $BASE ?>/auth/login.php" class="btn btn-dark">Go to login</a>
                    <a href="<?= $BASE ?>/index.php" class="btn btn-primary">Back to home</a>

                <?php endif; ?>
            <?php endif; ?>

            <?php if (!$message || strpos($message, 'successfully') === false): ?>
                <?php if ($token || $email): ?>

                    <form method="POST" class="col-md-6 p-0">
                        <!-- new password -->
                        <div class="form-group mb-2">
                            <label for="">New password:</label>
                            <input type="password" class="form-control" name="password" placeholder="Input your password"
                                required minlength="6" autocomplete="new-password">
                        </div>

                        <!-- confirm password -->
                        <div class="form-group mb-2">
                            <label for="">Confirm password:</label>
                            <input type="password" class="form-control" name="confirm_password"
                                placeholder="Input your password" required minlength="6" autocomplete="new-password">
                        </div>

                        <div class="text-center my-3">
                            <button type="submit" class="btn btn-dark" style="width: 100%;">Reset password</button>
                        </div>


                    </form>
                <?php else: ?>
                    <div class="alert alert-warning mb-0">Invalid or missing link, please request a new link form the <a href="<?= $base?>/auth/forget_password.php">Forget password</a>
                 </div>
                 <?php endif;?>
                 <?php endif;?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>