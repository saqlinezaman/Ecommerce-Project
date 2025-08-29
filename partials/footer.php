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

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- fetch product + smooth scroll -->
<script>
$(document).ready(function(){
  $('.category-item').click(function(e){
    e.preventDefault();

    // Active class toggle
    $('.category-item').removeClass('active');
    $(this).addClass('active');

    let categoryId = $(this).data('id');

    // Fetch products via Ajax
    $.ajax({
      url: 'fetch_products.php',
      type: 'GET',
      data: {category_id: categoryId},
      success: function(response){
        $('#productContainer').html(response);

        // Smooth scroll to product section
        $('html, body').animate({
          scrollTop: $('#productContainer').offset().top - 50
        }, 500);
      }
    });
  });
});
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</body>
</html>
