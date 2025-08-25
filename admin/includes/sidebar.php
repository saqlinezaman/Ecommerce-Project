<div class="sidebar"
    style="position: fixed; top: 60px; left: 0; width: 250px; height: calc(100vh - 60px); background-color: #153a4fff; overflow-y: auto;">
    <div class="p-2 pt-3" style="font-weight: 600; display: flex; flex-direction: column; gap: 10px;">
        <!-- dashboard -->
        <a href="../index.php" style="color: white; text-decoration: none;">
            <i class="fa-solid fa-eye me-1"></i> View website
        </a>
        <!-- dashboard -->
        <a href="index.php?page=dashboard" style="color: white; text-decoration: none;">
            <i class="fa-solid fa-house-chimney me-1"></i> Dashboard
        </a>

        <!-- product -->
        <a href="index.php?page=products" style="color: white; text-decoration: none;">
            <i class="fa-solid fa-cart-shopping me-1"></i> Products
        </a>

        <!-- category -->
        <a href="index.php?page=categories" style="color: white; text-decoration: none;">
            <i class="fa-solid fa-list me-1"></i> Categories
        </a>

        <!-- attributes -->
        <a href="index.php?page=showProduct" style="color: white; text-decoration: none;">
            <i class="fa-solid fa-arrow-right me-1"></i> Attributes
        </a>

        <!-- inventory with collapse -->
        <a href="#inventory" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="inventory"
            style="color: white; text-decoration: none; display: flex; justify-content: space-between; align-items: center;">

            <span><i class="fa-solid fa-boxes-stacked me-1"></i>Inventory</span>
            <i class="fa-solid fa-caret-down"></i>
        </a>
        <!-- collapse items of inventory -->
        <div class="collapse ps-3" id="inventory">
            <!-- stock in -->
            <a href="index.php?page=stock_in" style="color: white; text-decoration: none;"><i
                    class="fa-solid fa-arrow-right me-1"></i> Stock In</a>
            <!-- stock out -->
            <a href="index.php?page=stock_out" style="color: white; text-decoration: none;"> <i
                    class="fa-solid fa-arrow-right me-1"></i> Stock Out </a>
            <!-- stock by product -->
            <a href="index.php?page=stockByProducts" style="color: white; text-decoration: none;"><i
                    class="fa-solid fa-arrow-right me-1"></i> Stock by Product</a>
            <!-- report -->
            <a href="index.php?page=inventory_report" style="color: white; text-decoration: none;"><i
                    class="fa-solid fa-arrow-right me-1"></i>Report</a>
        </div>
        <!-- Feedback -->
        <a href="index.php?page=feedback" class="position-relative" style="color: white; text-decoration: none;">
            <i class="fa-regular fa-comment-dots me-1"></i>Feedback
            <span id="feedbackCount" class="position-absolute badge rounded-pill bg-danger mx-1">
                0
                <span class="visually-hidden">unread messages</span>
            </span>
        </a>
    </div>
</div>
<!-- jquery cdn -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

 <script>
    (function pollFeedback(params) {
        $.ajax({
            url: 'ajax/feedback_count.php',
            method: 'get',
            dataType: 'json'

        }).done(function (d) {
            $('#feedbackCount').text((d && d.count) ? d.count : 0);
        }).always(function () {
            setTimeout(pollFeedback,2000);
        });
    })();
 </script>