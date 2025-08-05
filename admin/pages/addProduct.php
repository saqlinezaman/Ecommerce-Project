<?php
include __DIR__ . '/../DBConfig.php';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';

$errorMessage = "";
$successMessage = "";

// fetch categories from database
$category_statement = $DB_connection->prepare("SELECT * FROM categories");
$category_statement->execute();
$categories = $category_statement->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['submit-btn'])) {
    $product_name = trim($_POST['product_name']);
    $product_price = trim($_POST['product_price']);
    $selling_price = trim($_POST['selling_price']);
    $stock_amount = trim($_POST['stock_amount']);
    $category_id = $_POST['category_id'];
    $product_description = trim($_POST['product_description']);
    $has_attribute = isset($_POST['has_attributes']) ? 1 : 0;
    $sizes = isset($_POST['sizes']) ? implode(',', $_POST['sizes']) : '';
    $colors = isset($_POST['colors']) ? $_POST['colors'] : '';

    // Image details
    $image_file = $_FILES['product_image']['name'];
    $tmp_dir = $_FILES['product_image']['tmp_name'];
    $image_size = $_FILES['product_image']['size'];

    if (empty($product_name) || empty($product_price) || empty($selling_price) || empty($stock_amount) || empty($image_file) || empty($category_id) || empty($product_description)) {

        $errorMessage = "All fields are required.";
    } else {
        $upload_dir = __DIR__ . '/../uploads/';  // 
        $image_ext = strtolower(pathinfo($image_file, PATHINFO_EXTENSION));
        $valid_extensions = ["jpg", "jpeg", "png", "gif"];
        $product_pic = rand(1000, 1000000) . "." . $image_ext;

        if (in_array($image_ext, $valid_extensions) && $image_size < 5000000000) {
            if (!move_uploaded_file($tmp_dir, $upload_dir . $product_pic)) {
                $errorMessage = "Failed to upload image.";
            }
        } else {
            $errorMessage = "Invalid image file or size too large.";
        }
    }

    if (empty($errorMessage)) {
        $statement = $DB_connection->prepare("INSERT INTO products 
                (product_name, product_price, selling_price, product_image, stock_amount, category_id, description, has_attributes) VALUES (:name, :price, :selling_price, :image, :stock_amount, :category_id, :description, :has_attribute)");

        $statement->bindParam(':name', $product_name);
        $statement->bindParam(':price', $product_price);
        $statement->bindParam(':selling_price', $selling_price);
        $statement->bindParam(':image', $product_pic);
        $statement->bindParam(':stock_amount', $stock_amount);
        $statement->bindParam(':category_id', $category_id);
        $statement->bindParam(':description', $product_description);
        $statement->bindParam(':has_attribute', $has_attribute);

        if ($statement->execute()) {
           $last_id = $DB_connection->lastInsertId();

            // Insert attributes if they exist
            if ($has_attribute) {
                $attribute_statement = $DB_connection->prepare("INSERT INTO attributes (product_id, sizes, colors) VALUES (:product_id, :sizes, :colors)");
                $attribute_statement->bindParam(':product_id', $last_id);
                $attribute_statement->bindParam(':sizes', $sizes);
                $attribute_statement->bindParam(':colors', $colors);
                $attribute_statement->execute();
            }
            $successMessage = "Product added successfully.";
        } else {
            $errorMessage = "Failed to add product. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .content {
            margin-left: 120px;
            margin-top: 20px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="content">
        <section class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 shadow p-5 bg-white rounded">
                    <h3 class="mt-3 text-primary">Add Product</h3>
                <!-- error or success massage  -->
                    <?php if (!empty($errorMessage)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
                    <?php endif; ?>

                    <?php if (!empty($successMessage)): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
                    <?php endif; ?>
                        <!-- form start -->
                    <form action="" method="POST" enctype="multipart/form-data">

                        <!-- name -->
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name:</label>
                            <input type="text" name="product_name" id="product_name" class="form-control"
                                placeholder="Enter Product Name" required />
                        </div>

                        <!-- product price -->
                        <div class="mb-3">
                            <label for="product_price" class="form-label">Product Price:</label>
                            <input type="text" name="product_price" id="product_price" class="form-control"
                                placeholder="Enter Product Price" required />
                        </div>

                        <!-- selling price -->
                        <div class="mb-3">
                            <label for="product_price" class="form-label">Selling Price:</label>
                            <input type="text" name="selling_price" id="selling_price" class="form-control"
                                placeholder="Enter Selling Price" required />
                        </div>

                        <!-- image -->
                        <div class="mb-3">
                            <label for="product_image" class="form-label">Product Image:</label>
                            <input type="file" name="product_image" id="product_image" class="form-control"
                                accept="image/*" required />
                        </div>

                        <!-- stock amount -->
                        <div class="mb-3">
                            <label for="stock_amount" class="form-label">Stock Amount:</label>
                            <input type="number" name="stock_amount" id="stock_amount" class="form-control"
                                placeholder="Enter Stock Amount" required />
                        </div>
                        <!-- category -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category:</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="">Select category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category['id']) ?>">
                                        <?= htmlspecialchars($category['category_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- product description -->
                        <div class="mb-3">
                            <label for="product_description" class="form-label">Product Description:</label>
                            <textarea name="product_description" id="product_description" rows="4" class="form-control"
                                placeholder="Enter Product Description" required></textarea>
                        </div>
                        <!-- has attribute -->
                        <div class="form-check mb-3">
                            <input type="checkbox" name="has_attributes" class="form-check-input" id="hasAttributes"
                                onchange="toggleAttributes()">

                            <label class="form-check-label">Has Attributes ?</label>
                        </div>
                        <!-- has attribute sections color and size -->
                        <div id="attributeSection" style="display: none;">
                            <div class="form-group">
                                <label>Sizes:</label>
                                <label class="checkbox-inline mr-2">
                                    <input type="checkbox" name="sizes[]" value="L">L
                                </label>

                                <label class="checkbox-inline mr-2">
                                    <input type="checkbox" name="sizes[]" value="XL">XL
                                </label>

                                <label class="checkbox-inline mr-2">
                                    <input type="checkbox" name="sizes[]" value="XXL">XXL
                                </label>
                            </div>

                            <div class="form-group">
                                <div class="d-flex align-items-center gap-2">
                                <label>Colors:</label>
                                    <input type="color" name="colorPicker" class="color-input">
                                <button type="button" class="btn btn-sm btn-secondary" onclick="addColor()">Add Color</button>
                                </div>
                                <div id="colorList" class="mt-2" onclick="removeColor()"></div>
                                <input type="hidden" name="colors" id="colors">
                            </div>

                        </div>


                        <button type="submit" name="submit-btn" class="btn btn-success">Add Product</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</body>

</html>


<script>
    let selectedColors = [];

    function toggleAttributes() {
        const attrSection = document.getElementById('attributeSection');
        attrSection.style.display = document.getElementById('hasAttributes').checked ? 'block' : 'none';
    }

    function addColor() {
        const colorInput = document.querySelector('.color-input');
        const color = colorInput.value;

        if (!selectedColors.includes(color)) {
            selectedColors.push(color);
            updateColorList();
            updateHiddenColorsInput();
        }
    }

    function updateColorList() {
        const colorListDiv = document.getElementById('colorList');
        colorListDiv.innerHTML = '';

        selectedColors.forEach(color => {
            const colorBox = document.createElement('div');
            colorBox.style.display = 'inline-block';
            colorBox.style.width = '30px';
            colorBox.style.height = '30px';
            colorBox.style.marginRight = '5px';
            colorBox.style.backgroundColor = color;
            colorBox.style.border = '1px solid #000';
            colorListDiv.appendChild(colorBox);
        });
    }

    function updateHiddenColorsInput() {
        document.getElementById('colors').value = selectedColors.join(',');
    }
    function removeColor(color) {
        selectedColors = selectedColors.filter(c => c !== color);
        updateColorList();
        updateHiddenColorsInput();
    }
</script>

</body>

</html>