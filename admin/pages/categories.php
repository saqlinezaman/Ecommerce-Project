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

if(isset($_POST['submit-btn'])){
    $category_name = trim($_POST['category_name']);
    if(empty($category_name)){
        $errorMessage = "Category name is required.";
    } else {
        // insert category into database
        $insert_statement = $DB_connection->prepare("INSERT INTO categories (category_name) VALUES (:category_name)");
        // bind the parameter
        $insert_statement->bindParam(':category_name', $category_name);
        
        if($insert_statement->execute()){
            $successMessage = "Category added successfully.";
        } else {
            $errorMessage = "Failed to add category. Please try again.";
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
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="content">
        <section class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 shadow p-5 bg-white rounded">
                    <h3 class="mt-3 text-primary">Add Category</h3>

                    <?php if (!empty($errorMessage)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
                    <?php endif; ?>

                    <?php if (!empty($successMessage)): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Category Name :</label>
                            <input type="text" name="category_name" id="category_name" class="form-control"
                                placeholder="Enter Category Name" required />
                        </div>
                        <button type="submit" name="submit-btn" class="btn btn-success">Add Category</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</body>

</html>