<?php
$host = "localhost";
$dbname = "ecommerce";
$username = "root";
$password = "";

try {
    $DB_connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $DB_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
