<div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-8 col-lg-10">
                <div class="card overflow-hidden bg-opacity-25">
                    <div class="row g-0">
                        <div class="col-lg-6 d-none d-lg-block p-2">
                            <img src="<?= base_url() ?>assets/images/auth-img.jpg" alt="" class="img-fluid rounded h-100">
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex flex-column h-100">

                                <div class="p-4 my-auto">
                                    <h4 class="fs-20">Free Sign Up</h4>
                                    <p class="text-muted mb-3">Enter your email address and password to access
                                        account.</p>

                                    <!-- form -->
                                    <form action="<?= base_url('') ?>auth/register" method="POST">
                                        <div class="mb-3">
                                            <label for="fullname" class="form-label">Full Name</label>
                                            <input class="form-control" type="text" name="name" id="fullname" placeholder="Enter your name" value="<?= set_value('name') ?>">
                                            <small class="text-danger"><?= form_error('name') ?></small>
                                        </div>
                                        <div class="mb-3">
                                            <label for="emailaddress" class="form-label">Email address</label>
                                            <input class="form-control" name="email" type="email" id="emailaddress" placeholder="Enter your email" value="<?= set_value('email') ?>">
                                            <small class="text-danger"><?= form_error('email') ?></small>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input class="form-control" name="password1" type="password" id="password" placeholder="Enter your password">
                                            <small class="text-danger"><?= form_error('password1') ?></small>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password Confirmation</label>
                                            <input class="form-control" name="password2" type="password" id="password" placeholder="Repeat your password">
                                        </div>
                                        <div class="mb-0 d-grid text-center mb-2">
                                            <button class="btn btn-primary fw-semibold" type="submit">Sign
                                                Up</button>
                                        </div>
                                        <div class="mb-0 d-grid text-center">
                                            <a href="<?= basename('') ?>auth" class="btn btn-soft-primary w-100">Login</a>
                                        </div>

                                    </form>
                                    <!-- end form-->
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>