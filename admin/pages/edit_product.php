<?php
include __DIR__ . '/../DBConfig.php';
include __DIR__ . '/../includes/header.php';

if(!isset($_GET['id'])) {
   die('This page cannot be accessed directly.');
}
$decode_id = base64_decode($_GET['id']);
$statement = $DB_connection->prepare("SELECT * FROM products WHERE id = ?");
$statement->execute([$decode_id]);
$product = $statement->fetch(PDO::FETCH_ASSOC);
if (!$product) {
    die('Product not found.');
}
$pr
?>