<?php

require_once __DIR__ . "/../config/class.user.php";
$user = new User();
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = trim($_POST['email']);
    $user->requestPasswordReset($email);
    $message = '<div class="alert alert-success">If the email exist, reset link has been sent</div>';

}


?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-5">
    <h3 class="mb-4">Forget password</h3>
    <form method="POST" class="col-md-5 p-0" >
        <?= $message ;?>
         <!-- email -->
        <div class="form-group mb-2">
            <label for="">Email:</label>
             <input type="email" class="form-control" name="email" placeholder="Input your email" required>
        </div>
        <!-- button -->
         <div class="text-center my-3">
                <button type="submit" class="btn btn-dark" style="width: 100%;">Send link</button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>