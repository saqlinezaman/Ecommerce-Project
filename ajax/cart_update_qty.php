<?php
if(session_status() === PHP_SESSION_NONE) session_start();

header('Content-Type: application/json; charset=UTF-8');

if(empty($_SESSION['user_id'])){
    echo json_encode(['ok' => false, 'error' => 'unauthorized']);
    exit;
}

require_once __DIR__ . '/../config/db_config.php';

$user_id = (int) $_SESSION['user_id'];
$item_id = (int) ($_POST['item_id'] ?? 0);
$qty = (int) ($_POST['qty'] ?? 1);

if($qty < 1) $qty = 1;

// Check if item exists in user's open cart
$sql = "SELECT ci.id, ci.unit_price FROM cart_items ci 
        JOIN carts c ON c.id = ci.cart_id AND c.user_id = ? AND c.status ='open' 
        WHERE ci.id = ?";
$stmt = $DB_connection->prepare($sql);
$stmt->execute([$user_id, $item_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$row){
    echo json_encode(['ok' => false, 'error' => 'Item not found in cart']);
    exit;
}

// Update quantity
$update = "UPDATE cart_items SET quantity = ? WHERE id = ?";
$stmt = $DB_connection->prepare($update);
$stmt->execute([$qty, $item_id]);

// Calculate line total
$line_total = $qty * (float)$row['unit_price'];

echo json_encode([
    'ok' => true,
    'message' => 'Quantity updated',
    'line_total' => number_format($line_total, 2)
]);
