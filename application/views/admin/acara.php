<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<?php
function format_indonesia($date_string)
{
    setlocale(LC_TIME, 'id_ID.UTF-8');
    $date = new DateTime($date_string);
    return strftime('%A, %d %B %Y %H:%M', $date->getTimestamp());
}
?>
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Selamat Datang <?= $user['name'] ?>, Anda Login Sebagai Admin</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <?= $this->session->flashdata('message') ?>
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <div class="table-responsive">
                                <h5>Data Undangan Yang Telah Di ACC</h5>
                                <div class="row">
                                    <?php foreach ($undangan as $u) : ?>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="card text-bg-primary">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= $u->nama_acara ?> (<?= $u->waktu ?>)</h5>
                                                    <p class="card-text"><?= $u->detail_acara ?>.</p>
                                                    <a href="<?= base_url('admin/bukuTamu') ?>?id=<?= $u->id ?>" class="btn btn-light btn-sm">Buku Tamu</a>
                                                </div> <!-- end card-body-->
                                            </div> <!-- end card-->
                                        </div> <!-- end col-->
                                    <?php endforeach; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- container -->


    </div>
    <!-- content -->