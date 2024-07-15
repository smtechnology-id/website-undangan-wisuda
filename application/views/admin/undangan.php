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
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addData">Tambah Data</button>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Acara</th>
                                            <th>Detail Acara</th>
                                            <th>Golongan</th>
                                            <th>Periode</th>
                                            <th>Status</th>
                                            <th>Link Preview</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($undangan as $u) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
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
                                                <td><?= $u->nama_golongan ?></td>
                                                <td><?= $u->periode ?></td>                                                <td><?= $u->status ?></td>
                                                <td><a href="<?= base_url('admin/preview') ?>?id=<?= $u->id?>" class="btn btn-link">Preview Undangan</a></td>
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#update<?= $u->id ?>">Update</button>
                                                    <div id="update<?= $u->id ?>" class=" modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="standard-modalLabel">Form Update Data</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="<?= base_url('admin/updateUndangan') ?>" method="post">
                                                                        <input type="hidden" name="id" id="id" value="<?= $u->id ?>">
                                                                        <div class="form-group mb-3">
                                                                            <label for="nama_acara">Nama Acara</label>
                                                                            <input type="text" name="nama_acara" id="nama_acara" class="form-control" value="<?= $u->nama_acara ?>">
                                                                            <?= form_error('nama_acara', '<small class="text-danger">', '</small>'); ?>
                                                                        </div>

                                                                        <div class="form-group mb-3">
                                                                            <label for="detail_acara">Detail Acara</label>
                                                                            <textarea name="detail_acara" id="detail_acara" class="form-control"><?= $u->detail_acara ?></textarea>
                                                                            <?= form_error('detail_acara', '<small class="text-danger">', '</small>'); ?>
                                                                        </div>

                                                                        <div class="form-group mb-3">
                                                                            <label for="waktu">Waktu</label>
                                                                            <input type="datetime-local" name="waktu" id="waktu" class="form-control" value="<?= $u->waktu ?>">
                                                                            <?= form_error('waktu', '<small class="text-danger">', '</small>'); ?>
                                                                        </div>

                                                                        <div class="form-group mb-3">
                                                                            <label for="tempat">Tempat</label>
                                                                            <input type="text" name="tempat" id="tempat" class="form-control" value="<?= $u->tempat ?>">
                                                                            <?= form_error('tempat', '<small class="text-danger">', '</small>'); ?>
                                                                        </div>

                                                                        <div class="form-group mb-3">
                                                                            <label for="alamat_acara">Alamat Acara</label>
                                                                            <textarea name="alamat_acara" id="alamat_acara" class="form-control"><?= $u->alamat_acara ?></textarea>
                                                                            <?= form_error('alamat_acara', '<small class="text-danger">', '</small>'); ?>
                                                                        </div>

                                                                        <div class="form-group mb-3">
                                                                            <label for="link_maps">Link Maps</label>
                                                                            <input type="text" name="link_maps" id="link_maps" class="form-control" value="<?= $u->link_maps ?>">
                                                                            <?= form_error('link_maps', '<small class="text-danger">', '</small>'); ?>
                                                                        </div>
                                                                        <div class="form-group mb-3">
                                                                            <label for="golongan_id">Golongan</label>
                                                                            <select name="golongan_id" id="golongan_id" class="form-control">
                                                                                <option value="">Pilih Golongan</option>
                                                                                <?php foreach ($golongan as $gol) : ?>
                                                                                    <option value="<?= $gol->id ?>" <?= set_select('golongan_id', $gol->id, $gol->id == $u->golongan_id) ?>><?= $gol->nama_golongan ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                            <?= form_error('golongan_id', '<small class="text-danger">', '</small>'); ?>
                                                                        </div>

                                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                    <a href="<?= base_url('admin/deleteUndangan')?>?id=<?= $u->id?>" class="btn btn-danger">Delete</a>
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

    <div id="addData" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Form Add Data</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('admin/addUndangan') ?>" method="post">
                        <div class="form-group mb-3">
                            <label for="nama_acara">Nama Acara</label>
                            <input type="text" name="nama_acara" id="nama_acara" class="form-control" value="<?= set_value('nama_acara'); ?>">
                            <?= form_error('nama_acara', '<small class="text-danger">', '</small>'); ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="detail_acara">Detail Acara</label>
                            <textarea name="detail_acara" id="detail_acara" class="form-control"><?= set_value('detail_acara'); ?></textarea>
                            <?= form_error('detail_acara', '<small class="text-danger">', '</small>'); ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="waktu">Waktu</label>
                            <input type="datetime-local" name="waktu" id="waktu" class="form-control" value="<?= set_value('waktu'); ?>">
                            <?= form_error('waktu', '<small class="text-danger">', '</small>'); ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tempat">Tempat</label>
                            <input type="text" name="tempat" id="tempat" class="form-control" value="<?= set_value('tempat'); ?>">
                            <?= form_error('tempat', '<small class="text-danger">', '</small>'); ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat_acara">Alamat Acara</label>
                            <textarea name="alamat_acara" id="alamat_acara" class="form-control"><?= set_value('alamat_acara'); ?></textarea>
                            <?= form_error('alamat_acara', '<small class="text-danger">', '</small>'); ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="link_maps">Link Maps</label>
                            <input type="text" name="link_maps" id="link_maps" class="form-control" value="<?= set_value('link_maps'); ?>">
                            <?= form_error('link_maps', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for="golongan_id">Golongan</label>
                            <select name="golongan_id" id="golongan_id" class="form-control">
                                <option value="">Pilih Golongan</option>
                                <?php foreach ($golongan as $gol) : ?>
                                    <option value="<?= $gol->id ?>" <?= set_select('golongan_id', $gol->id); ?>><?= $gol->nama_golongan ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('golongan_id', '<small class="text-danger">', '</small>'); ?>
                        </div>

                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->