<?php
include __DIR__ . '/admin/DBConfig.php';
include("partials/header.php");

// category

$category_statement = $DB_connection->prepare("SELECT * FROM categories ORDER BY id DESC");
$category_statement->execute();
$categories = $category_statement->fetchAll(PDO::FETCH_ASSOC);

// product
$statement = $DB_connection->prepare("SELECT * FROM products ORDER BY id DESC");
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);


?>


  <section>
    <div>
      <div
        class="slideshow slide-in arrow-absolute text-white" style="height: 70vh;">
        <div class="swiper-wrapper">
          
          <div class="swiper-slide jarallax swiper-slide-next">

            <img src="asset/images/slide-2.jpg" class="jarallax-img" alt="slideshow">
            <div class="banner-content w-100">
              <div class="container-fluid">
                <div class="row justify-content-center text-center">
                  <div class="col-md-10 pt-5">
                    <h2 class="display-xl text-white ls-0 mt-5 pt-5 txt-fx slide-up">Sports Collection</h2>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          <div class="swiper-slide jarallax">

            <img src="asset/images/slide-3.jpg" class="jarallax-img" alt="slideshow">
            <div class="banner-content w-100">
              <div class="container-fluid">
                <div class="row justify-content-center text-center">
                  <div class="col-md-10 pt-5">
                    <h2 class="display-xl text-white ls-0 mt-5 pt-5 txt-fx slide-up">Casual Shoes</h2>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="swiper-slide jarallax">

            <img src="asset/images/slide-4.jpg" class="jarallax-img" alt="slideshow">
            <div class="banner-content w-100">
              <div class="container-fluid">
                <div class="row justify-content-center text-center">
                  <div class="col-md-10 pt-5">
                    <h2 class="display-xl text-white ls-0 mt-5 pt-5 txt-fx slide-up">Clearance Sale</h2>
                  </div>
                </div>
              </div>
            </div>
            
          </div>

        </div>
        <div class="pagination-wrapper position-absolute">
          <div class="container">
            <div class="slideshow-swiper-pagination text-center"></div>
          </div>
        </div>
        <div class="icon-arrow icon-arrow-left text-white"><svg width="50" height="50" viewBox="0 0 24 24">
            <use xlink:href="#arrow-left"></use>
          </svg></div>
        <div class="icon-arrow icon-arrow-right text-white"><svg width="50" height="50" viewBox="0 0 24 24">
            <use xlink:href="#arrow-right"></use>
          </svg></div>
        
      </div>
    </div>
  </section>

  <section class="features" style="position:relative; margin-top: -100px; z-index: 2;">
    <div class="container-lg">
      <div class="bg-white p-5">
        <div class="row">
          <div class="col-md-4">
            <div class="row">
              <div class="col-2">
                <svg width="40" height="40">
                  <use xlink:href="#cart"></use>
                </svg>
              </div>
              <div class="col-10">
                <h4 class="element-title text-capitalize mb-2">Pick up in store</h4>
                <p>At imperdiet dui accumsan sit amet nulla risus est ultricies quis.</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="row">
              <div class="col-2">
                <svg width="40" height="40">
                  <use xlink:href="#gift"></use>
                </svg>
              </div>
              <div class="col-10">
                <h4 class="element-title text-capitalize mb-2">Special packaging</h4>
                <p>At imperdiet dui accumsan sit amet nulla risus est ultricies quis.</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="row">
              <div class="col-2">
                <svg width="40" height="40">
                  <use xlink:href="#love"></use>
                </svg>
              </div>
              <div class="col-10">
                <h4 class="element-title text-capitalize mb-2">Free global returns</h4>
                <p>At imperdiet dui accumsan sit amet nulla risus est ultricies quis.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-4">
    <div class="container-fluid">
      <div class="row">

        <div class="col-md-6">
          <div class="banner-ad bg-secondary-subtle mb-3"
            style="background: url('asset/images/ad-image-1.png');background-repeat: no-repeat;background-position: right bottom;">
            <div class="banner-content p-5">

              <div class="fs-6 pt-5">Upto 25% Off</div>
              <h3 class="banner-title">Sports Shoes</h3>
              <a href="#" class="btn btn-dark text-uppercase">Show Now</a>

            </div>

          </div>
        </div>
        <div class="col-md-6">
          <div class="banner-ad bg-secondary-subtle"
            style="background: url('asset/images/ad-image-2.png');background-repeat: no-repeat;background-position: right bottom;">
            <div class="banner-content p-5">

              <div class="fs-6 pt-5">Upto 25% Off</div>
              <h3 class="banner-title">Kids Collection</h3>
              <a href="#" class="btn btn-dark text-uppercase">Show Now</a>

            </div>

          </div>
        </div>

      </div>
    </div>
  </section>
  <div class="m-3">
     <h3>All Product</h3>
  </div>
  <!-- cat -->
   <div class="container-fluid">
      <div class="row py-3">
        <div class="d-flex  justify-content-center justify-content-sm-between align-items-center">
          <nav class="main-menu d-flex navbar navbar-expand-lg">

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
              aria-controls="offcanvasNavbar">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar">

            <!-- category -->

              <div class="offcanvas-header justify-content-center">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>

              <div class="offcanvas-body">

                <ul class="navbar-nav justify-content-end menu-list list-unstyled d-flex gap-md-5 mb-0 text-black text-uppercase fw-bold">
                    <?php foreach($categories as $category): ?>
                  <li class="nav-item active">
                    <a href="" class="nav-link"><?= $category['category_name'] ?></a>
                  </li>
                  <?php endforeach; ?>
               
                </ul>

              </div>

            </div>

          </nav>

        </div>
      </div>
    </div>
<!-- product -->
  <section class="py-5">
    <div class="container-fluid">

      <div class="row">
        <div class="col-md-12">
          <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">

              <?php foreach($products as $product): ?>
            <div class="col shadow-sm m-4 p-2">
              <div class="product-item">
                <span class="badge bg-success position-absolute m-3">-30%</span>
                <figure class="d-flex justify-content-center">
                  <a href="single-product.html" title="Product Title">
                    <img src="admin/uploads/<?= htmlspecialchars($product['product_image']); ?>" alt="Product Thumbnail" class="" style="width:180px; height: 200px;">
                  </a>
                </figure>
                <span><?= $product['product_name'] ?></span>
                <div class="d-flex justify-content-between">
                  <p><span class="text-dark"><?= $product['selling_price'] ?></span></p>
                  <span class="d-flex">
                    <a href="#" class="btn btn-primary">Add to cart</a>
                  </span>
                </div>
              </div>
            </div>
            <?php endforeach; ?>

          </div>
          <!-- / product-grid -->

        </div>
      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container-fluid">
      <div class="row">

        <div class="col-md-6">
          <div class="banner-ad bg-secondary-subtle mb-3"
            style="background: url('asset/images/ad-image-3.png');background-repeat: no-repeat;background-position: right bottom;">
            <div class="banner-content p-5">

              <div class="fs-6 pt-5">Upto 25% Off</div>
              <h3 class="banner-title">Gentlemen Classics</h3>
              <a href="#" class="btn btn-dark text-uppercase">Show Now</a>

            </div>

          </div>
        </div>
        <div class="col-md-6">
          <div class="banner-ad bg-secondary-subtle"
            style="background: url('asset/images/ad-image-4.png');background-repeat: no-repeat;background-position: right bottom;">
            <div class="banner-content p-5">

              <div class="fs-6 pt-5">Upto 25% Off</div>
              <h3 class="banner-title">Casual Wears</h3>
              <a href="#" class="btn btn-dark text-uppercase">Show Now</a>

            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

  <section class="py-5 overflow-hidden">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">

          <div class="section-header d-flex flex-wrap justify-content-between my-5">

            <h2 class="section-title">Best selling products</h2>

            <div class="d-flex align-items-center">
              <a href="#" class="btn-link text-decoration-none">View All Categories →</a>
              <div class="swiper-buttons">
                <button class="swiper-prev products-carousel-prev btn btn-primary">❮</button>
                <button class="swiper-next products-carousel-next btn btn-primary">❯</button>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="row">
        <div class="col-md-12">

          <div class="products-carousel swiper">
            <div class="swiper-wrapper">

              <div class="swiper-slide">
                <div class="product-item">
                  <span class="badge bg-success position-absolute m-3">-30%</span>
                  <figure>
                    <a href="single-product.html" title="Product Title">
                      <img src="asset/images/product-thumb-1.png" alt="Product Thumbnail" class="img-fluid">
                    </a>
                  </figure>
                  <p>Super Shoes</p>
                  <div class="d-flex justify-content-between">
                    <p><span class="text-dark">$18.00</span><del>$23</del><span class="text-success">-30%</span></p>
                    <span class="d-flex">
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                    </span>
                  </div>
                </div>
              </div>

              <div class="swiper-slide">
                <div class="product-item">
                  <span class="badge bg-success position-absolute m-3">-30%</span>
                  <figure>
                    <a href="single-product.html" title="Product Title">
                      <img src="asset/images/product-thumb-2.png" alt="Product Thumbnail" class="img-fluid">
                    </a>
                  </figure>
                  <p>Leather Brown</p>
                  <div class="d-flex justify-content-between">
                    <p><span class="text-dark">$18.00</span><del>$23</del><span class="text-success">-30%</span></p>
                    <span class="d-flex">
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                    </span>
                  </div>
                </div>
              </div>

              <div class="swiper-slide">
                <div class="product-item">
                  <span class="badge bg-success position-absolute m-3">-30%</span>
                  <figure>
                    <a href="single-product.html" title="Product Title">
                      <img src="asset/images/product-thumb-3.png" alt="Product Thumbnail" class="img-fluid">
                    </a>
                  </figure>
                  <p>Trending Shoes Party Wear For Men</p>
                  <div class="d-flex justify-content-between">
                    <p><span class="text-dark">$18.00</span><del>$23</del><span class="text-success">-30%</span></p>
                    <span class="d-flex">
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-outline"></use>
                      </svg>
                    </span>
                  </div>
                </div>
              </div>

              <div class="swiper-slide">
                <div class="product-item">
                  <figure>
                    <a href="single-product.html" title="Product Title">
                      <img src="asset/images/product-thumb-4.png" alt="Product Thumbnail" class="img-fluid">
                    </a>
                  </figure>
                  <p>Sports Shoes Training & Gym Shoes For Men</p>
                  <div class="d-flex justify-content-between">
                    <p><span class="text-dark">$18.00</span><del>$23</del><span class="text-success">-30%</span></p>
                    <span class="d-flex">
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                    </span>
                  </div>
                </div>
              </div>

              <div class="swiper-slide">
                <div class="product-item">
                  <figure>
                    <a href="single-product.html" title="Product Title">
                      <img src="asset/images/product-thumb-5.png" alt="Product Thumbnail" class="img-fluid">
                    </a>
                  </figure>
                  <p>Kids Shoes</p>
                  <div class="d-flex justify-content-between">
                    <p><span class="text-dark">$18.00</span><del>$23</del><span class="text-success">-30%</span></p>
                    <span class="d-flex">
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                    </span>
                  </div>
                </div>
              </div>

              <div class="swiper-slide">
                <div class="product-item">
                  <figure>
                    <a href="single-product.html" title="Product Title">
                      <img src="asset/images/product-thumb-6.png" alt="Product Thumbnail" class="img-fluid">
                    </a>
                  </figure>
                  <p>Super Shoes</p>
                  <div class="d-flex justify-content-between">
                    <p><span class="text-dark">$18.00</span><del>$23</del><span class="text-success">-30%</span></p>
                    <span class="d-flex">
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                    </span>
                  </div>
                </div>
              </div>

              <div class="swiper-slide">
                <div class="product-item">
                  <figure>
                    <a href="single-product.html" title="Product Title">
                      <img src="asset/images/product-thumb-7.png" alt="Product Thumbnail" class="img-fluid">
                    </a>
                  </figure>
                  <p>Super Shoes</p>
                  <div class="d-flex justify-content-between">
                    <p><span class="text-dark">$18.00</span><del>$23</del><span class="text-success">-30%</span></p>
                    <span class="d-flex">
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                    </span>
                  </div>
                </div>
              </div>

              <div class="swiper-slide">
                <div class="product-item">
                  <figure>
                    <a href="single-product.html" title="Product Title">
                      <img src="asset/images/product-thumb-5.png" alt="Product Thumbnail" class="img-fluid">
                    </a>
                  </figure>
                  <p>Super Shoes</p>
                  <div class="d-flex justify-content-between">
                    <p><span class="text-dark">$18.00</span><del>$23</del><span class="text-success">-30%</span></p>
                    <span class="d-flex">
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                    </span>
                  </div>
                </div>
              </div>

              <div class="swiper-slide">
                <div class="product-item">
                  <figure>
                    <a href="single-product.html" title="Product Title">
                      <img src="asset/images/product-thumb-6.png" alt="Product Thumbnail" class="img-fluid">
                    </a>
                  </figure>
                  <p>Super Shoes</p>
                  <div class="d-flex justify-content-between">
                    <p><span class="text-dark">$18.00</span><del>$23</del><span class="text-success">-30%</span></p>
                    <span class="d-flex">
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                    </span>
                  </div>
                </div>
              </div>

              <div class="swiper-slide">
                <div class="product-item">
                  <figure>
                    <a href="single-product.html" title="Product Title">
                      <img src="asset/images/product-thumb-7.png" alt="Product Thumbnail" class="img-fluid">
                    </a>
                  </figure>
                  <p>Super Shoes</p>
                  <div class="d-flex justify-content-between">
                    <p><span class="text-dark">$18.00</span><del>$23</del><span class="text-success">-30%</span></p>
                    <span class="d-flex">
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                      <svg width="18" height="18" class="text-warning">
                        <use xlink:href="#star-solid"></use>
                      </svg>
                    </span>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <!-- / products-carousel -->

        </div>
      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container-fluid">

      <div class="bg-warning py-5">
          <div class="container">
            <div class="row">
              <div class="col-md-6 p-5">
                <div class="section-header">
                  <h2 class="section-title display-4">Get <span class="text-danger">25% Discount</span> on your first
                    purchase</h2>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Dictumst amet, metus, sit massa posuere
                  maecenas. At tellus ut nunc amet vel egestas.</p>
              </div>
              <div class="col-md-6 p-5">
                <form>
                  <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control form-control-lg" name="name" id="name" placeholder="Name">
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control form-control-lg" name="email" id="email"
                      placeholder="abc@mail.com">
                  </div>
                  <div class="form-check form-check-inline mb-3">
                    <label class="form-check-label" for="subscribe">
                      <input class="form-check-input" type="checkbox" id="subscribe" value="subscribe">
                      Subscribe to the newsletter</label>
                  </div>
                  <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-dark btn-lg">Submit</button>
                  </div>
                </form>
  
              </div>
  
            </div>
  
          </div>
        </div>

    </div>
  </section>

  <section id="latest-blog" class="py-5">
    <div class="container-fluid">
      <div class="row">
        <div class="section-header d-flex align-items-center justify-content-between my-5">
          <h2 class="section-title">Our Recent Blog</h2>
          <div class="btn-wrap align-right">
            <a href="#" class="d-flex align-items-center nav-link">Read All Articles <svg width="24" height="24">
                <use xlink:href="#arrow-right"></use>
              </svg></a>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <article class="post-item card border-0 shadow-sm p-3">
            <div class="image-holder zoom-effect">
              <a href="#">
                <img src="asset/images/post-thumb-1.jpg" alt="post" class="card-img-top">
              </a>
            </div>
            <div class="card-body">
              <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
                <div class="meta-date"><svg width="16" height="16">
                    <use xlink:href="#calendar"></use>
                  </svg>22 Aug 2021</div>
                <div class="meta-categories"><svg width="16" height="16">
                    <use xlink:href="#category"></use>
                  </svg>tips & tricks</div>
              </div>
              <div class="post-header">
                <h3 class="post-title">
                  <a href="#" class="text-decoration-none">Top 10 casual look ideas to dress up your kids</a>
                </h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipi elit. Aliquet eleifend viverra enim tincidunt donec
                  quam. A in arcu, hendrerit neque dolor morbi...</p>
              </div>
            </div>
          </article>
        </div>
        <div class="col-md-4">
          <article class="post-item card border-0 shadow-sm p-3">
            <div class="image-holder zoom-effect">
              <a href="#">
                <img src="asset/images/post-thumb-2.jpg" alt="post" class="card-img-top">
              </a>
            </div>
            <div class="card-body">
              <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
                <div class="meta-date"><svg width="16" height="16">
                    <use xlink:href="#calendar"></use>
                  </svg>25 Aug 2021</div>
                <div class="meta-categories"><svg width="16" height="16">
                    <use xlink:href="#category"></use>
                  </svg>trending</div>
              </div>
              <div class="post-header">
                <h3 class="post-title">
                  <a href="#" class="text-decoration-none">Latest trends of wearing street wears supremely</a>
                </h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipi elit. Aliquet eleifend viverra enim tincidunt donec
                  quam. A in arcu, hendrerit neque dolor morbi...</p>
              </div>
            </div>
          </article>
        </div>
        <div class="col-md-4">
          <article class="post-item card border-0 shadow-sm p-3">
            <div class="image-holder zoom-effect">
              <a href="#">
                <img src="asset/images/post-thumb-3.jpg" alt="post" class="card-img-top">
              </a>
            </div>
            <div class="card-body">
              <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
                <div class="meta-date"><svg width="16" height="16">
                    <use xlink:href="#calendar"></use>
                  </svg>28 Aug 2021</div>
                <div class="meta-categories"><svg width="16" height="16">
                    <use xlink:href="#category"></use>
                  </svg>inspiration</div>
              </div>
              <div class="post-header">
                <h3 class="post-title">
                  <a href="#" class="text-decoration-none">10 Different Types of comfortable clothes ideas for women</a>
                </h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipi elit. Aliquet eleifend viverra enim tincidunt donec
                  quam. A in arcu, hendrerit neque dolor morbi...</p>
              </div>
            </div>
          </article>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container-fluid">
      <div class="row row-cols-1 row-cols-sm-3 row-cols-lg-5">
        <div class="col">
          <div class="card mb-3 border-0">
            <div class="row">
              <div class="col-md-2 text-dark">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                  <path fill="currentColor"
                    d="M21.5 15a3 3 0 0 0-1.9-2.78l1.87-7a1 1 0 0 0-.18-.87A1 1 0 0 0 20.5 4H6.8l-.33-1.26A1 1 0 0 0 5.5 2h-2v2h1.23l2.48 9.26a1 1 0 0 0 1 .74H18.5a1 1 0 0 1 0 2h-13a1 1 0 0 0 0 2h1.18a3 3 0 1 0 5.64 0h2.36a3 3 0 1 0 5.82 1a2.94 2.94 0 0 0-.4-1.47A3 3 0 0 0 21.5 15Zm-3.91-3H9L7.34 6H19.2ZM9.5 20a1 1 0 1 1 1-1a1 1 0 0 1-1 1Zm8 0a1 1 0 1 1 1-1a1 1 0 0 1-1 1Z" />
                </svg>
              </div>
              <div class="col-md-10">
                <div class="card-body p-0">
                  <h5>Free delivery</h5>
                  <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card mb-3 border-0">
            <div class="row">
              <div class="col-md-2 text-dark">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                  <path fill="currentColor"
                    d="M19.63 3.65a1 1 0 0 0-.84-.2a8 8 0 0 1-6.22-1.27a1 1 0 0 0-1.14 0a8 8 0 0 1-6.22 1.27a1 1 0 0 0-.84.2a1 1 0 0 0-.37.78v7.45a9 9 0 0 0 3.77 7.33l3.65 2.6a1 1 0 0 0 1.16 0l3.65-2.6A9 9 0 0 0 20 11.88V4.43a1 1 0 0 0-.37-.78ZM18 11.88a7 7 0 0 1-2.93 5.7L12 19.77l-3.07-2.19A7 7 0 0 1 6 11.88v-6.3a10 10 0 0 0 6-1.39a10 10 0 0 0 6 1.39Zm-4.46-2.29l-2.69 2.7l-.89-.9a1 1 0 0 0-1.42 1.42l1.6 1.6a1 1 0 0 0 1.42 0L15 11a1 1 0 0 0-1.42-1.42Z" />
                </svg>
              </div>
              <div class="col-md-10">
                <div class="card-body p-0">
                  <h5>100% secure payment</h5>
                  <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card mb-3 border-0">
            <div class="row">
              <div class="col-md-2 text-dark">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                  <path fill="currentColor"
                    d="M22 5H2a1 1 0 0 0-1 1v4a3 3 0 0 0 2 2.82V22a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-9.18A3 3 0 0 0 23 10V6a1 1 0 0 0-1-1Zm-7 2h2v3a1 1 0 0 1-2 0Zm-4 0h2v3a1 1 0 0 1-2 0ZM7 7h2v3a1 1 0 0 1-2 0Zm-3 4a1 1 0 0 1-1-1V7h2v3a1 1 0 0 1-1 1Zm10 10h-4v-2a2 2 0 0 1 4 0Zm5 0h-3v-2a4 4 0 0 0-8 0v2H5v-8.18a3.17 3.17 0 0 0 1-.6a3 3 0 0 0 4 0a3 3 0 0 0 4 0a3 3 0 0 0 4 0a3.17 3.17 0 0 0 1 .6Zm2-11a1 1 0 0 1-2 0V7h2ZM4.3 3H20a1 1 0 0 0 0-2H4.3a1 1 0 0 0 0 2Z" />
                </svg>
              </div>
              <div class="col-md-10">
                <div class="card-body p-0">
                  <h5>Quality guarantee</h5>
                  <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card mb-3 border-0">
            <div class="row">
              <div class="col-md-2 text-dark">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                  <path fill="currentColor"
                    d="M12 8.35a3.07 3.07 0 0 0-3.54.53a3 3 0 0 0 0 4.24L11.29 16a1 1 0 0 0 1.42 0l2.83-2.83a3 3 0 0 0 0-4.24A3.07 3.07 0 0 0 12 8.35Zm2.12 3.36L12 13.83l-2.12-2.12a1 1 0 0 1 0-1.42a1 1 0 0 1 1.41 0a1 1 0 0 0 1.42 0a1 1 0 0 1 1.41 0a1 1 0 0 1 0 1.42ZM12 2A10 10 0 0 0 2 12a9.89 9.89 0 0 0 2.26 6.33l-2 2a1 1 0 0 0-.21 1.09A1 1 0 0 0 3 22h9a10 10 0 0 0 0-20Zm0 18H5.41l.93-.93a1 1 0 0 0 0-1.41A8 8 0 1 1 12 20Z" />
                </svg>
              </div>
              <div class="col-md-10">
                <div class="card-body p-0">
                  <h5>guaranteed savings</h5>
                  <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card mb-3 border-0">
            <div class="row">
              <div class="col-md-2 text-dark">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                  <path fill="currentColor"
                    d="M18 7h-.35A3.45 3.45 0 0 0 18 5.5a3.49 3.49 0 0 0-6-2.44A3.49 3.49 0 0 0 6 5.5A3.45 3.45 0 0 0 6.35 7H6a3 3 0 0 0-3 3v2a1 1 0 0 0 1 1h1v6a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3v-6h1a1 1 0 0 0 1-1v-2a3 3 0 0 0-3-3Zm-7 13H8a1 1 0 0 1-1-1v-6h4Zm0-9H5v-1a1 1 0 0 1 1-1h5Zm0-4H9.5A1.5 1.5 0 1 1 11 5.5Zm2-1.5A1.5 1.5 0 1 1 14.5 7H13ZM17 19a1 1 0 0 1-1 1h-3v-7h4Zm2-8h-6V9h5a1 1 0 0 1 1 1Z" />
                </svg>
              </div>
              <div class="col-md-10">
                <div class="card-body p-0">
                  <h5>Daily offers</h5>
                  <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php
include("partials/footer.php");
?>