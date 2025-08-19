<?php

require_once __DIR__ ."/../config/class.user.php";

$user = new User();

$message = '';

if($_SERVER["REQUEST_METHOD"] == 'POST') {

    try{
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ??'';
        $user->login($email, $password);
        $user->redirect($user->basUrl ?? '/');

    }catch(Exception $e){
        $message = '<div class="alert alert-danger">'.htmlspecialchars($e->getMessage()).'</div>';
    }

}

?>
<?php require_once __DIR__.'/../partials/header.php';?>

<div class="container mt-5">
    <h3>Login</h3>
     <?= $message ;?>
      <form action="POST" class="col-md-5 p-0" >
         <!-- email -->
        <div class="form-group mb-2">
            <label for="">Email:</label>
             <input type="email" class="form-control" name="email" placeholder="Input your email" required>
        </div>
        <!-- password -->
        <div class="form-group mb-2">
            <label for="">Password:</label>
             <input type="password" class="form-control" name="password" placeholder="Input your password" required>
        </div>
        <small><a href="<?= $BASE ?>/auth/forget_password.php">Forget Password</a></small>
        <div class="text-center my-3">
                <button type="submit" class="btn btn-dark" style="width: 100%;">Login</button>
              </div>
      </form>
      <small class="text-muted">Don't have account ? <a href="<?= $BASE ?>/auth/register.php">Register now</a></small>
</div>

<?php require_once __DIR__.'/../partials/footer.php';?>