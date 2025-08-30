<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit;
}

require_once __DIR__ . "/config/db_config.php";

// Database connection
$database = new Database();
$DB_connection = $database->db_connection();

// make dynamic link for url
$BASE = defined('BASE_URL')
    ? BASE_URL
    : ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http')
        . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost')
        . '/ecommerce');

$userId = (int) $_SESSION['user_id'];

// fetch cart id
$statement = $DB_connection->prepare('SELECT id FROM carts WHERE user_id = ? AND status = "open" LIMIT 1');
$statement->execute([$userId]);
$cartId = ($statement->fetch(PDO::FETCH_ASSOC)['id'] ?? null);

$items = [];
$grands = 0.00;

if ($cartId) {
    $sql = 'SELECT ci.id AS item_id, ci.product_id, ci.quantity, ci.unit_price, 
                  p.product_name, p.product_image
            FROM cart_items ci
            JOIN products p ON p.id = ci.product_id
            WHERE ci.cart_id = ?';

    $statement = $DB_connection->prepare($sql);
    $statement->execute([$cartId]);
    $items = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($items as $item) {
        $grands += (float) ($item['unit_price'] * (int) ($item['quantity']));
    }
}

// header include
if (file_exists(__DIR__ . '/partials/header.php'))
    include __DIR__ . '/partials/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body>
    <div class="container my-3">
        <div class="row">
            <div class="col-md-7">
                <div class="card border-none">
                    <div
                        class="card-header bg-dark  bg-opacity-70 text-white d-flex justify-content-between align-items-center mb-4 ">
                        <h1>Your cart</h1>
                        <a href="<?= htmlspecialchars($BASE) ?>/index.php"
                            class="btn btn-sm btn-light fw-semibold">Continue Shopping</a>
                    </div>
                    <?php
                    if (empty($items)):
                        ?>
                        <div class="cart-body bg-danger  bg-opacity-10 text-center py-4">
                            <h5 class="">Your Cart is empty</h5>
                            <p class="text-muted"> Add some products to see them here</p>
                            <a href="<?= htmlspecialchars($BASE) ?>/index.php?>"
                                class="btn btn-info text-white fw-medium">Browse Product</a>
                        </div>
                    <?php else: ?>

                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 88px;">Image</th>
                                        <th>Products</th>
                                        <th class="text-right" style="width: 130px;">Unit Price</th>
                                        <th style="width: 140px;">Qty</th>
                                        <th class="text-right" style="width: 140px;">Total</th>
                                        <th class="text-center" style="width: 80px;">Remove</th>
                                    </tr>
                                </thead>
                                <tbody class="cart-body">
                                    <?php foreach($items as $item):
                                        
                                        $img = (!empty($item['product_image']) && file_exists(__DIR__. "/admin/uploads".$item['product_image'])) ? 'admin/uploads/'.$item['product_image'] : 'assets/images/default.jpg';

                                        $line = $line = (float)$item['unit_price'] * (int)$item['quantity'];
                                        ?>
                                        <tr>
                                            <td></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>

                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
// footer include
if (file_exists(__DIR__ . '/partials/footer.php'))
    include __DIR__ . '/partials/footer.php';
?>