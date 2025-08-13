<!-- Footer -->
<footer class="bg-dark text-light pt-5 pb-3 mt-5">
  <div class="container">
    <div class="row">
      <!-- Logo & About -->
      <div class="col-md-4 mb-4">
        <h5 class="mb-3">Marhaba eCommerce</h5>
        <p>আপনার পছন্দের সব পণ্য এক জায়গায়। মান, দাম এবং দ্রুত ডেলিভারির নিশ্চয়তা দিচ্ছি।</p>
      </div>

      <!-- Quick Links -->
      <div class="col-md-2 mb-4">
        <h6 class="mb-3">Quick Links</h6>
        <ul class="list-unstyled">
          <li><a href="#" class="text-light text-decoration-none">Home</a></li>
          <li><a href="#" class="text-light text-decoration-none">About Us</a></li>
          <li><a href="#" class="text-light text-decoration-none">Shop</a></li>
          <li><a href="#" class="text-light text-decoration-none">Contact</a></li>
          <li><a href="#" class="text-light text-decoration-none">About Us</a></li>
        </ul>
      </div>

      <!-- Categories -->
      <div class="col-md-3 mb-4">
        <h6 class="mb-3">Categories</h6>
        <ul class="list-unstyled">
          <li><a href="#" class="text-light text-decoration-none">Electronics</a></li>
          <li><a href="#" class="text-light text-decoration-none">Fashion</a></li>
          <li><a href="#" class="text-light text-decoration-none">Home & Kitchen</a></li>
          <li><a href="#" class="text-light text-decoration-none">Sports</a></li>
        </ul>
      </div>

      <!-- Newsletter -->
      <div class="col-md-3 mb-4">
        <h6 class="mb-3">Subscribe</h6>
        <form>
          <div class="input-group">
            <input type="email" class="form-control" placeholder="Your email">
            <button class="btn btn-success" type="submit">Subscribe</button>
          </div>
        </form>
        <div class="mt-3">
          <a href="#" class="text-light me-3"><i class="bi bi-facebook"></i></a>
          <a href="#" class="text-light me-3"><i class="bi bi-instagram"></i></a>
          <a href="#" class="text-light"><i class="bi bi-twitter"></i></a>
        </div>
      </div>
    </div>

    <hr class="border-light">
    <div class="text-center">
      <p class="mb-0">&copy; 2025 Marhaba eCommerce. All Rights Reserved.</p>
    </div>
  </div>
</footer>

<!-- Bootstrap js cdn -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<!-- Bootstrap CSS -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- jquery -->
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <!-- fetch product -->
<script>
$(document).ready(function(){
  $('.category-item').click(function(){
    $('.category-item').removeClass('active bg-dark text-light');
    $(this).addClass('active bg-dark text-light');

    let categoryId = $(this).data('id');

    $.ajax({
      url: 'fetch_products.php',
      type: 'GET',
      data: {category_id: categoryId},
      success: function(response){
        $('#productContainer').html(response);
      }
    });
  });
});
</script>

</body>
</html>
