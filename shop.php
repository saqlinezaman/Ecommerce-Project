<?php
include __DIR__ . "/partials/header.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .shop-banner {
            background: url('asset/images/shop-banner.jpg') center/cover no-repeat;
            height: 50vh;
            position: relative;
        }

        .shop-banner::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            /* dark overlay */
        }

        .shop-banner>div {
            position: relative;
            z-index: 2;
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <div class="shop-banner d-flex align-items-center justify-content-center text-center text-white">
            <div>
                <h1 class="fw-bold">Welcome to Our Shop</h1>
                <p class="lead">Best Products at the Best Price</p>
            </div>
        </div>
    </div>
    <div class="container my-5">
        <h2 class="mb-4">New arrivals</h2>
        <?php include __DIR__ ."/fetch_products.php"; ?>
    </div>

</body>

</html>

<?php include __DIR__ . "/partials/footer.php"; ?>