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
                        <h4 class="page-title">Selamat Datang <?= $user['name'] ?>, Anda Login Sebagai Panitia</h4>
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
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Acara</th>
                                            <th>Detail Acara</th>
                                            <th>Golongan</th>
                                            <th>Status</th>
                                            <th>Link Preview</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($undangan as $u) : ?>
                                            <tr>
                                                <td><?= $u->id ?></td>
                                                <td><?= $u->nama_acara ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detail<?= $u->id ?>">Detail</button>
                                                    <div id="detail<?= $u->id ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="standard-modalLabel">Form Add Data</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <h5>Detail Acara</h5>
                                                                    <table class="table table-borderless">
                                                                        <tr>
                                                                            <td>Nama Acara</td>
                                                                            <td>:</td>
                                                                            <td><?= $u->nama_acara ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Detail Acara</td>
                                                                            <td>:</td>
                                                                            <td><?= $u->detail_acara ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Waktu</td>
                                                                            <td>:</td>
                                                                            <td><?= format_indonesia($u->waktu) ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Tempat Acara</td>
                                                                            <td>:</td>
                                                                            <td><?= $u->tempat ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Alamat Acara</td>
                                                                            <td>:</td>
                                                                            <td>
                                                                                <a href="<?= $u->link_maps ?>" class="btn btn-link" target="_blank"><?= $u->alamat_acara ?></a>
                                                                            </td>
                                                                        </tr>

                                                                    </table>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>

                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                </td>
                                                <td><?= $u->nama_golongan ?></td> <!-- Menampilkan nama golongan -->
                                                <td><?= $u->status ?></td>
                                                <td><a href="<?= base_url('user/preview') ?>?id=<?= $u->id?>" class="btn btn-link" target="_blank">Preview Undangan</a></td>
                                                <td>
                                                    <a href="<?= base_url('user/setujuiUndangan')?>?id=<?= $u->id?>" class="btn btn-primary">Setujui Undangan</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- container -->


    </div>
    <!-- content -->

