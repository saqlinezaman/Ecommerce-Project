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
            <div class="col-md-8">
                <div class="card border-none">
                    <div
                        class="card-header bg-dark  bg-opacity-70 text-white d-flex justify-content-between align-items-center mb-4 ">
                        <h2>Your cart</h2>
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
                                class="btn btn-success text-white fw-medium">Browse Product</a>
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
                                <tbody id="cart-body">
                                    <?php foreach ($items as $item):

                                        $img = (!empty($item['product_image']) && file_exists(__DIR__ . "/admin/uploads" . $item['product_image'])) ? 'admin/uploads/' . $item['product_image'] : 'assets/images/default.jpg';

                                        $line = $line = (float) $item['unit_price'] * (int) $item['quantity'];
                                        ?>
                                        <tr class="" data-item-id="<?= (int) $item['id'] ?>">
                                            <!-- image -->
                                            <td>
                                                <img src="<?= htmlspecialchars($img) ?>" alt="" class="">
                                            </td>
                                            <!-- name -->
                                            <td>
                                                <div class="fw-medium">
                                                    <?= htmlspecialchars($item['product_name']) ?>
                                                </div>
                                            </td>
                                            <!-- unit-price -->
                                            <td class="text-right">
                                                $ <span class="unit"><?= number_format($item['unit_price'], 2) ?></span>
                                            </td>
                                            <!-- quantity -->
                                            <td>
                                                <input type="number"  name="quantity" class="form-control-sm qty" min="1"
                                                    value="<?= htmlspecialchars($item['quantity']) ?>">
                                            </td>
                                            <td class="text-right">
                                                <span class="line-total"><?= number_format($line, 2) ?><?= number_format($line, 2) ?></span>
                                            </td>
                                            <td>
                                                <button class="remove"><i class="fa-solid fa-trash text-danger"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right">Grand Total</td>
                                        <td class="text-right">$ <span id="grandTotal"><?= number_format($grands) ?></span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php endif ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-success text-white summary-card">
                        <strong>Order Summary</strong>
                    </div>
                    <div class="card-body">
                        <!-- subtotal -->
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-medium">Subtotal: </span>
                            <strong>$ <span id="sumSubtotal"><?= number_format($grands, 2) ?></span> </strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-muted align-items-center">
                            <span>Shipping Charge</span>
                            <span>Calculated at checkout</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between h5">
                            <span class="fw-medium">Total: </span>
                            <Strong>$ <span id="sumGrand"><?= number_format($grands, 2) ?></span> </Strong>
                        </div>

                    </div>
                    <div class="card-footer">
                        <?php if (!empty($items)): ?>
                            <form action="cart_order.php" class="mb-2" method="POST">
                                <button class="btn btn-dark text-white w-100">
                                    Order
                                </button>
                            </form>
                        <?php endif; ?>
                        <a href="<?= htmlspecialchars($BASE) ?>/index.php" class="btn btn-outline-success w-100 text-black fw-semibold"> Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="asset/js/script.js"></script>
</body>
</html>

<?php
// footer include
if (file_exists(__DIR__ . '/partials/footer.php'))
    include __DIR__ . '/partials/footer.php';
?>