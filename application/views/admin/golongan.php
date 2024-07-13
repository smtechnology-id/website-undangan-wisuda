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

                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>Nama Golongan</td>
                                        <td>Keterangan</td>
                                        <td>Periode</td>
                                        <td>Jumlah Tamu Undangan</td>
                                        <td>Data Tamu</td>
                                        <td>Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($golongan as $gol) :
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $gol->nama_golongan ?></td>
                                            <td><?= $gol->keterangan ?></td>
                                            <td><?= $gol->periode ?></td>
                                            <td><?= $gol->jumlah_tamu ?></td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addTamu<?= $gol->id ?>"><i class="ri-folder-add-fill"></i></button>
                                                <div id="addTamu<?= $gol->id ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="standard-modalLabel">Form Tambah Data Tamu Golongan <?= $gol->nama_golongan ?></h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="<?= base_url('admin/addTamu') ?>" method="post">
                                                                    <div class="form-group mb-3">
                                                                        <label for="nama_tamu">Nama Tamu</label>
                                                                        <input type="text" name="nama_tamu" id="nama_tamu" class="form-control" value="<?= set_value('nama_tamu'); ?>">
                                                                        <?= form_error('nama_tamu', '<small class="text-danger">', '</small>'); ?>
                                                                    </div>

                                                                    <div class="form-group mb-3">
                                                                        <label for="no_hp">No HP</label>
                                                                        <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?= set_value('no_hp'); ?>">
                                                                        <?= form_error('no_hp', '<small class="text-danger">', '</small>'); ?>
                                                                    </div>

                                                                    <div class="form-group mb-3">
                                                                        <label for="alamat">Alamat</label>
                                                                        <textarea name="alamat" id="alamat" class="form-control"><?= set_value('alamat'); ?></textarea>
                                                                        <?= form_error('alamat', '<small class="text-danger">', '</small>'); ?>
                                                                    </div>

                                                                    <div class="form-group mb-3">
                                                                        <input type="hidden" name="id_golongan" value="<?= $gol->id ?>">
                                                                        <?= form_error('id_golongan', '<small class="text-danger">', '</small>'); ?>
                                                                    </div>

                                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                                </form>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>

                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                                <a href="<?= base_url('admin/listTamuGolongan') ?>?id=<?= $gol->id ?>" class="btn btn-outline-primary"><i class="ri-eye-line"></i></a>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#update<?= $gol->id ?>">Update</button>
                                                <div id="update<?= $gol->id ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="standard-modalLabel">Form Update Data</h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="<?= base_url('admin/updateGolongan') ?>" method="post">
                                                                    <div class="form-group mb-2">
                                                                        <label for="nama_golongan">Nama Golongan</label>
                                                                        <input type="text" name="nama_golongan" id="nama_golongan" class="form-control" value="<?= $gol->nama_golongan ?>">
                                                                        <!-- Hidden input untuk menyimpan ID golongan -->
                                                                        <input type="hidden" name="id" id="id" class="form-control" value="<?= $gol->id ?>">
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label for="keterangan">Keterangan</label>
                                                                        <textarea name="keterangan" id="keterangan" class="form-control"><?= $gol->keterangan ?></textarea>
                                                                    </div>
                                                                    <div class="form-group mb-2">
                                                                        <label for="periode">Periode</label>
                                                                        <input type="text" name="periode" id="periode" class="form-control" value="<?= $gol->periode ?>">
                                                                        <!-- Hidden input untuk menyimpan ID golongan -->
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

                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $gol->id ?>">Delete</button>
                                                <div id="delete<?= $gol->id ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="standard-modalLabel">Delete Data</h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Apakah Anda Yakin Ingin Menghapus Data Ini ?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                <a class="btn btn-danger" href="<?= base_url('admin/deleteGolongan') ?>?id=<?= $gol->id ?>">Delete</a>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                            </td>
                                        </tr>
                                    <?php
                                    endforeach
                                    ?>
                                </tbody>
                            </table>
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
                    <form action="<?= base_url('admin/addGolongan') ?>" method="post">
                        <div class="form-group mb-2">
                            <label for="nama_golongan">Nama Golongan</label>
                            <input type="text" name="nama_golongan" id="nama_golongan" class="form-control">
                            <?= form_error('nama_golongan', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="form-group mb-2">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                            <?= form_error('keterangan', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="form-group mb-2">
                            <label for="periode">Periode</label>
                            <input type="text" name="periode" id="periode" class="form-control">
                            <?= form_error('periode', '<small class="text-danger">', '</small>'); ?>
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