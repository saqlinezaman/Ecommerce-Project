<?php
include __DIR__ . '/../DBConfig.php';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';
?>

<div class="content pl-3">
    <div class="col-md-7 mx-auto mt-2">
        <div class="card">
        <div class="card-header bg-secondary text-white">
            <h5>Stock In</h5>
        </div>
        <div class="card-body">
             <form action="POST">
        <div class="form-group">
            <label for="">Select Product</label>
            <select name="product_id" id="product_id" class="form-control" required>
                <option value="">select</option>
                <?php
                   
                ?>
            </select>
        </div>
    </form>
        </div>
    </div>
    </div>
   
</div>