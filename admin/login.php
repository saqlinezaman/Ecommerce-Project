<?php
session_start();
include 'DBConfig.php';
$error = "";
// check login
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    // query 
    $statement = $DB_connection->prepare("SELECT * FROM admins WHERE username = ?");
    $statement->execute([$username]);
    // check
    if($statement->rowCount() === 1){
        $admin = $statement->fetch(PDO::FETCH_ASSOC);
        if(password_verify($password, $admin['password'])){
            $_SESSION['admin_logged_in'] = $admin['id'] ;
            $_SESSION['admin_username'] = $admin['username'];
            header("location: index.php");
            exit;
        }else{
            $error = "Invalid Password";
        }
    }else{
        $error = "Admin user not found";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css" integrity="sha512-rt/SrQ4UNIaGfDyEXZtNcyWvQeOq0QLygHluFQcSjaGB04IxWhal71tKuzP6K8eYXYB6vJV4pHkXcmFGGQ1/0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-light">
    <section class="container mt-5">
        <div class="row  justify-content-center">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="card-title text-center">Admin Login</h4>
                        <!-- error massage show -->
                        <?php if($error) : ?>
                            <div class="alert alert-danger">
                                <?= htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>

                        <!-- form -->
                         <form action="" method="POST">
                            <!-- username -->
                            <div class="form-group">
                                <label for="">UserName</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <!-- password -->
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" name="login-submit" class="btn btn-primary btn-block">
                                Submit
                            </button>
                         </form>
                            

                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>