<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// লগইন চেক
if (empty($_SESSION['user_id'])) {
    $_SESSION['flash'] = 'Please log in to add items to your cart.';
    header('Location: auth/login.php');
    exit;
}

require_once __DIR__ . '/config/db_config.php';

// Database connection
$database = new Database();
$DB_connection = $database->db_connection();

// Product ID এবং Quantity
$product_id = (int) ($_POST['product_id'] ?? $_GET['product_id'] ?? 0);
$qty = (int) ($_POST['qty'] ?? $_GET['qty'] ?? 1);

if ($qty <= 0) $qty = 1;
if ($product_id <= 0) {
    header('Location: cart.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// প্রোডাক্ট price fetch
$statement = $DB_connection->prepare('SELECT selling_price FROM products WHERE id = ? LIMIT 1');
$statement->execute([$product_id]);
$product = $statement->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: cart.php');
    exit;
}

$unit_price = (float) $product['selling_price'];

// খোলা cart fetch বা তৈরি
$st = $DB_connection->prepare('SELECT id FROM carts WHERE user_id = ? AND status = "open" LIMIT 1');
$st->execute([$user_id]);
$cart_id = ($st->fetch(PDO::FETCH_ASSOC)['id'] ?? null);

if (!$cart_id) {
    $insert = $DB_connection->prepare('INSERT INTO carts (user_id, status) VALUES (?, "open")');
    $insert->execute([$user_id]);
    $cart_id = $DB_connection->lastInsertId();
}

// cart_items চেক এবং update বা insert
$st = $DB_connection->prepare('SELECT id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ? LIMIT 1');
$st->execute([$cart_id, $product_id]);
$it = $st->fetch(PDO::FETCH_ASSOC);

if ($it) {
    $new_qty = (int) $it['quantity'] + $qty;
    $update = $DB_connection->prepare('UPDATE cart_items SET quantity = ? WHERE id = ? LIMIT 1');
    $update->execute([$new_qty, $it['id']]);
} else {
    $insert = $DB_connection->prepare('INSERT INTO cart_items (cart_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)');
    $insert->execute([$cart_id, $product_id, $qty, $unit_price]);
}

// আগের পেজে redirect
$back = $_SERVER['HTTP_REFERER'] ?? 'cart.php';
header('Location: ' . $back);
exit;
?>
