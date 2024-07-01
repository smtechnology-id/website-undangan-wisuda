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
                            <a href="<?= base_url('admin/acara') ?>" class="btn btn-outline-primary mb-3"><i class="ri-arrow-left-line"></i> Kembali</a>
                            <a href="<?= base_url('admin/cetakBukuTamu?id=') . $undangan->id ?>" class="btn btn-success mb-3">Cetak Excel</a>
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Tamu</th>
                                        <th>No HP</th>
                                        <th>Status Undangan</th>
                                        <th>Link Undangan</th>
                                        <th>Tambah Kehadiran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($tamu) : ?>
                                        <?php foreach ($tamu as $key => $t) : ?>
                                            <tr>
                                                <td><?= $key + 1 ?></td>
                                                <td><?= $t->nama_tamu ?></td>
                                                <td><?= $t->no_hp ?></td>
                                                <td>
                                                    <?php
                                                    // Tentukan status undangan berdasarkan keberadaan tamu di buku tamu
                                                    $status = 'Belum Hadir';
                                                    foreach ($buku_tamu as $bt) {
                                                        if ($bt->id_tamu == $t->id && $bt->id_undangan == $undangan->id) {
                                                            $status = 'Hadir';
                                                            break;
                                                        }
                                                    }
                                                    echo $status;
                                                    ?>
                                                </td>
                                                <td>
                                                    <a target="_blank" href="<?= base_url('admin/undanganWisuda?id_undangan=') . $undangan->id . '&id_tamu=' . $t->id ?>" class="btn btn-outline-primary btn-sm">Link Undangan</a>
                                                </td>
                                                <td>
                                                    <?php if ($status == 'Hadir') : ?>
                                                        <a href="<?= base_url('admin/detailUndangan/') . $undangan->id ?>">Detail Undangan</a>
                                                    <?php else : ?>
                                                        <a href="<?= base_url('admin/tambahKehadiran?id_undangan=') . $undangan->id . '&id_tamu=' . $t->id ?>" class="btn btn-primary btn-sm">Tambah Kehadiran</a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada tamu yang terdaftar untuk golongan ini.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>


                            </table>
                        </div>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div> <!-- end row -->
        </div> <!-- container -->

    </div> <!-- content -->
</div> <!-- content-page -->