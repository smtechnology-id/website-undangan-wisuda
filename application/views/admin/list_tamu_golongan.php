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
                            <a href="<?= base_url('admin/golongan') ?>" class="btn btn-outline-primary mb-3"><i class="ri-arrow-left-line"></i> Kembali</a>
                            <table class="table table-bordered text-center mt-3">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Tamu</th>
                                        <th>No HP</th>
                                        <th>Alamat</th>
                                        <th>Golongan</th>
                                        <th>Aksi</th>
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
                                            <td>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#update<?= $tm->id ?>">Update</button>
                                                <div id="update<?= $tm->id ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="standard-modalLabel">Form Update Data Tamu Golongan <?= $tm->nama_golongan ?></h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="<?= base_url('admin/updateTamu') ?>" method="post">
                                                                    <div class="form-group mb-3">
                                                                        <label for="nama_tamu">Nama Tamu</label>
                                                                        <input type="text" name="nama_tamu" id="nama_tamu" class="form-control" value="<?= $tm->nama_tamu ?>">
                                                                        <?= form_error('nama_tamu', '<small class="text-danger">', '</small>'); ?>
                                                                    </div>
                                                                    <input type="hidden" name="id" value="<?= $tm->id ?>">

                                                                    <div class="form-group mb-3">
                                                                        <label for="no_hp">No HP</label>
                                                                        <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?= $tm->no_hp ?>">
                                                                        <?= form_error('no_hp', '<small class="text-danger">', '</small>'); ?>
                                                                    </div>

                                                                    <div class="form-group mb-3">
                                                                        <label for="alamat">Alamat</label>
                                                                        <textarea name="alamat" id="alamat" class="form-control"><?= $tm->alamat ?></textarea>
                                                                        <?= form_error('alamat', '<small class="text-danger">', '</small>'); ?>
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



                                                <a href="<?= base_url('admin/deleteTamu') ?>?id=<?= $tm->id ?>" class="btn btn-danger">Delete</a>


                                            </td>
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