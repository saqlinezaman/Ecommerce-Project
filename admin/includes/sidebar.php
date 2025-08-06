<div class="sidebar"
    style="position: fixed; top: 60px; left: 0; width: 250px; height: calc(100vh - 60px); background-color: #153a4fff; overflow-y: auto;">
    <div class="p-2 pt-3" style="font-weight: 600; display: flex; flex-direction: column; gap: 10px;">
        <!-- dashboard -->
        <a href="index.php?page=dashboard" style="color: white; text-decoration: none;">
            <i class="fa-solid fa-house-chimney mr-2"></i> Dashboard
        </a>

        <!-- product -->
        <a href="index.php?page=products" style="color: white; text-decoration: none;">
            <i class="fa-solid fa-cart-shopping mr-2"></i> Products
        </a>

        <!-- category -->
        <a href="index.php?page=categories" style="color: white; text-decoration: none;">
            <i class="fa-solid fa-list mr-2"></i> Categories
        </a>

        <!-- attributes -->
        <a href="index.php?page=showProduct" style="color: white; text-decoration: none;">
            <i class="fa-solid fa-arrow-right mr-2"></i> Attributes
        </a>

        <!-- inventory with collapse -->
        <a href="#inventory" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="inventory"
            style="color: white; text-decoration: none; display: flex; justify-content: space-between; align-items: center;">

            <span><i class="fa-solid fa-boxes-stacked me-2"></i>Inventory</span>
            <i class="fa-solid fa-caret-down"></i>
        </a>
        <!-- collapse items of inventory -->
        <div class="collapse ps-3" id="inventory">
            <!-- stock in -->
            <a href="index.php?page=stock_in" style="color: white; text-decoration: none;"><i
                    class="fa-solid fa-arrow-right mr-2"></i> Stock In</a>
            <!-- stock out -->
            <a href="index.php?page=stock_out" style="color: white; text-decoration: none;"> <i
                    class="fa-solid fa-arrow-right mr-2"></i> Stock Out </a>
            <!-- stock by product -->
            <a href="index.php?page=stockByProducts" style="color: white; text-decoration: none;"><i class="fa-solid fa-arrow-right mr-2"></i> Stock by Product</a>
            <!-- report -->
            <a href="index.php?page=inventory_report" style="color: white; text-decoration: none;"><i class="fa-solid fa-arrow-right mr-2"></i>Report</a>
        </div>
    </div>
</div>