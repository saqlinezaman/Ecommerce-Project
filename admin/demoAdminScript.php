<?php

require_once 'DbConfig.php';
$username = 'admin';
$password = 'password123';

$sql = "SELECT * FROM admins WHERE username = ?";
$statement = $DB_connection->prepare($sql);
$statement->execute([$username]);

if ($statement->rowCount() > 0) {
    echo "<h3>Admin User Already exist</h3>";
} else {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $insert_sql = "INSERT INTO admins (username, password) VALUES (?, ?)";
    $insert_statement = $DB_connection->prepare($insert_sql);
    if ($insert_statement->execute([$username, $hashed_password])) {
        echo "<h3>DEMO Admin User Created Successfully</h3>";
        echo "<p><b>Username :</b> $username</p>";
        echo "<p><b>Password :</b> $password</p>";
        echo "<a href='login.php'>Go to the Login</a>";
    } else {
        echo "<h3>Error creating admin user</h3>";
    }
}


?>