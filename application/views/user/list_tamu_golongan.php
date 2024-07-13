<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title"><?= $title ?></h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <a href="<?= base_url('user/undangan') ?>" class="btn btn-outline-primary mb-3"><i class="ri-arrow-left-line"></i> Kembali</a>
                            <table class="table table-bordered text-center mt-3">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Tamu</th>
                                        <th>No HP</th>
                                        <th>Alamat</th>
                                        <th>Golongan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($tamu as $tm) :
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $tm->nama_tamu ?></td>
                                            <td><?= $tm->no_hp ?></td>
                                            <td><?= $tm->alamat ?></td>
                                            <td><?= $tm->nama_golongan ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div> <!-- end row -->
        </div> <!-- container -->

    </div> <!-- content -->
</div> <!-- content-page -->