<div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-8 col-lg-10">
                <div class="card overflow-hidden">
                    <div class="row g-0">
                        <div class="col-lg-6 d-none d-lg-block p-2">
                            <img src="<?= base_url('') ?>assets/images/auth-img.jpg" alt="" class="img-fluid rounded h-100">
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex flex-column h-100">
                                <div class="auth-brand p-4">
                                    <a href="index.html" class="logo-light">
                                        <img src="<?= base_url('') ?>assets/images/logo.png" alt="logo" height="22">
                                    </a>
                                    <a href="index.html" class="logo-dark">
                                        <img src="<?= base_url('') ?>assets/images/logo-dark.png" alt="dark logo" height="22">
                                    </a>
                                </div>
                                <div class="p-4 my-auto">
                                    <h4 class="fs-20">Sign In</h4>
                                    <p class="text-muted mb-3">Enter your email address and password to access
                                        account.
                                    </p>
                                    <?= $this->session->flashdata('message') ?>
                                    <!-- form -->
                                    <form action="<?= base_url('auth/login'); ?>" method="post">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email address</label>
                                            <input class="form-control" name="email" type="email" id="email" placeholder="Enter your email" value="<?= set_value('email') ?>">
                                            <small class="text-danger"><?= form_error('email') ?></small>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input class="form-control" name="password" type="password" id="password" placeholder="Enter your password">
                                            <small class="text-danger"><?= form_error('password') ?></small>
                                        </div>
                                        <div class="mb-0 text-start">
                                            <button class="btn btn-soft-primary w-100 mb-3" type="submit"><i class="ri-login-circle-fill me-1"></i> <span class="fw-bold">Log In</span></button>
                                        </div>
                                        <div class="mb-0 text-start">
                                            <a href="<?= base_url('auth/register'); ?>" class="btn btn-primary w-100">Register</a>
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
        <div class="row">
            <div class="col-12 text-center">
                <p class="text-dark-emphasis">Don't have an account? <a href="auth-register.html" class="text-dark fw-bold ms-1 link-offset-3 text-decoration-underline"><b>Sign up</b></a>
                </p>
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->