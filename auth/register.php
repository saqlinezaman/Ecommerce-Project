<?php
require_once __DIR__. "/../config/class.user.php";

$user = new User();

$message = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    try{

        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

        if(empty($password) || empty($confirm_password)){
            throw new Exception('Password fields cannot be empty');
        }

        if($password !== $confirm_password) {
            throw new Exception('Password does not match');
        }

        $user->register($username, $email, $password);

        $message = '<div class="alert alert-success">Registration successfully done, Please check your email to verify</div>';

    }catch(Exception $e){
        $message = '<div class="alert alert-danger">'.htmlspecialchars($e->getMessage()).'</div>';
    }
}
?>


<?php require_once __DIR__.'/../partials/header.php';?>

<div class="container mt-5">
    <h3>Create an account</h3>
    <?= $message ;?>
    <form method="POST" class="col-md-5 p-0" >
        <!-- username -->
        <div class="form-group mb-1">
            <label for="">Username:</label>
             <input class="form-control" name="username" placeholder="Input your username" required>
        </div>
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
        <!-- confirm-password -->
        <div class="form-group mb-2">
            <label for="">Confirm Password:</label>
             <input type="password" class="form-control" name="confirm_password" placeholder="Confirm your password" required>
        </div>
        <!-- button -->
        <div class="text-center my-3">
                <button type="submit" class="btn btn-dark" style="width: 100%;">Register</button>
        </div>
    </form>
    <small class="text-muted">Already have account ? <a href="<?= $BASE ?>/auth/login.php">Log in Now</a></small>
</div>

<?php require_once __DIR__.'/../partials/footer.php';?>
