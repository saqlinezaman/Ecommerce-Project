<?php
require_once __DIR__. "/../config/class.user.php";
$user = new User();

$BASE = defined('BASE_URL') ? BASE_URL : ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http'). '://'.($_SERVER['HTTP_HOST'] ?? 'localhost').'/ecommerce');

$massage = '';

$token = $_GET['token'] ?? '';
$email = $_GET['email'] ?? '';

try{
    if(!$token || !$email){
        throw new Exception('Invalid verification');
}
// verify

$user->verify( $email, $token );

$massage = '<div class="alert alert-success mb-3">Your account has been verified you can login now </div>';


}catch(Exception $e){
    $massage = '<div class="alert alert-danger mb-3">'.htmlspecialchars($e->getMessage()).'</div>';
}

 ?>
 <?php require_once __DIR__.'/../partials/header.php';?>

 <div class="container mx-auto my-5 col-md-5">
    <div class="card">
        <div class="card-body">
            <h4 class="mb-3">Email verification</h4>
            <?= $massage ;?>
            <div class="">
                <a class="btn btn-dark" href="<?= $BASE ?>/auth/login.php">Go to login</a>
                <a href="<?= $BASE ?>/index.php" class="btn btn-link">Home</a>
            </div>
        </div>
    </div>
 </div>

 