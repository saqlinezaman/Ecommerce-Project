<?php
include_once __DIR__ . "/config/db_config.php";
include_once __DIR__ . "/partials/header.php";

$flag = $_GET["msg"] ?? '';
?>

<div class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-4 shadow">
                    <h4>Contact us</h4>
                    <?php if ($flag == 'ok'): ?>
                        <div class="alert alert-success">Thanks! Your message has been successfully submitted.</div>
                    <?php elseif ($flag == 'err'): ?>
                        <div class="alert alert-danger">Something went wrong, try again latter!</div>
                    <?php endif ?>
                    <form method="POST" action="save_contact.php" class="needs-validation" novalidate>
                        <!-- name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Your name</label>
                            <input type="text" class="form-control" name="name" placeholder="Input your name" required>
                            <div class="invalid-feedback">Name is require</div>
                        </div>
                        <!-- email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Your email</label>
                            <input type="email" class="form-control" name="email" placeholder="Input your email"
                                required>
                            <div class="invalid-feedback">Email is require</div>
                        </div>
                        <!-- subject -->
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" name="subject" placeholder="Input your subject"
                                required>
                            <div class="invalid-feedback">Subject is require</div>
                        </div>
                        <!-- message -->
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a message here" name="message"
                                style="height: 100px" required></textarea>
                            <label for="floatingTextarea2">Leave message</label>
                            <div class="invalid-feedback">Message can not be empty!</div>
                        </div>
                        <!-- button -->
                        <div class="text-center my-3">
                            <button type="submit" class="btn btn-dark" style="width: 100%;">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body text-bg-dark shadow rounded">
                    <h5>Our Location</h5>
                    <p>29 Puran Paltan, Nurjahan sharif plaza</p>
                    <p><strong>Phone Number: </strong>+88 017234-56789</p>
                    <p><strong>Email: </strong>dummy@gmail.com</p>
                </div>
            </div>
            <div class="card p-1" style="width: 100%; height: 310px; margin-top: 15px;">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d3652.5169553936894!2d90.41202212407582!3d23.72893797868503!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sCogent!5e0!3m2!1sen!2sbd!4v1756560160555!5m2!1sen!2sbd"
                    style="width: 100%; height: 100%; border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            </section>
        </div>
    </div>
</div>

<script>
    (function () {
        'use strict';
        const forms = document.getElementsByClassName('needs-validation');

        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                event.stopPropagation();

                if (form.checkValidity()) {
                    form.submit(); // ফর্ম সাবমিট করা
                } else {
                    form.classList.add('was-validated');
                }
            }, false);
        });
    })();
</script>

<?php include_once __DIR__ . "/partials/footer.php"; ?>