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
                        <h4 class="page-title">Daftar Tamu</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTamu">Tambah Tamu</button>

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
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateTamu<?= $tm->id ?>">Update</button>
                                                <a href="<?= base_url('admin/deleteTamu')?>?id=<?= $tm->id ?>" class="btn btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
