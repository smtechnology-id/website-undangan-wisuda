<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Velonic</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Welcome!</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Selamat Datang <?= $user['name'] ?>, Anda Login Sebagai Panitia</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xxl-3 col-sm-6">
                    <div class="card widget-flat text-bg-pink">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-eye-line widget-icon"></i>
                            </div>
                            <h6 class="text-uppercase mt-0" title="Customers">Jumlah Golongan</h6>
                            <h2 class="my-2"><?= $jumlah_golongan ?></h2>
                            </p>
                        </div>
                    </div>
                </div> <!-- end col-->

                <div class="col-xxl-3 col-sm-6">
                    <div class="card widget-flat text-bg-purple">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-wallet-2-line widget-icon"></i>
                            </div>
                            <h6 class="text-uppercase mt-0" title="Customers">Jumlah Undangan</h6>
                            <h2 class="my-2"><?= $jumlah_undangan ?></h2>
                        </div>
                    </div>
                </div> <!-- end col-->
                <div class="col-xxl-3 col-sm-6">
                    <div class="card widget-flat text-bg-warning">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="ri-wallet-2-line widget-icon"></i>
                            </div>
                            <h6 class="text-uppercase mt-0" title="Customers">Jumlah Data Tamu</h6>
                            <h2 class="my-2"><?= $jumlah_tamu ?></h2>
                        </div>
                    </div>
                </div> <!-- end col-->
            </div>
        </div>
        <!-- container -->

    </div>
    <!-- content -->