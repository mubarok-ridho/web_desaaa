<?php
include 'app/post/post_data_kependudukan.php';
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3><i class="nav-icon fas fa-hands-helping"></i> Klasifikasi Surat</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Klasifikasi Surat</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Rekomendasi Bantuan -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Surat Domisili</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Surat Kelahiran</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Kematian</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Pendatang</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Pindah</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Pengantar</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                <a href="<?= $base_url ?>app/print/cetak_rekom_bpnt.php" target="_blank" class="btn btn-success">
                                    <i class="fas fa-print"></i> Print
                                </a>
                                <br><br>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NO KK</th>
                                            <th>NIK</th>
                                            <th>Kepala Keluarga</th>
                                            <th>Tgl Lahir</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Penghasilan</th>
                                            <th>Dusun</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        tampil_rekom_bpnt($mysqli);
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                <a href="<?= $base_url ?>app/print/cetak_rekom_pkh.php" target="_blank" class="btn btn-success">
                                    <i class="fas fa-print"></i> Print
                                </a>
                                <br><br>
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NO KK</th>
                                            <th>NIK</th>
                                            <th>Kepala Keluarga</th>
                                            <th>Tgl Lahir</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Penghasilan</th>
                                            <th>Dusun</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        tampil_rekom_pkh($mysqli);
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                                <a href="<?= $base_url ?>app/print/cetak_rekom_bst.php" target="_blank" class="btn btn-success">
                                    <i class="fas fa-print"></i> Print
                                </a>
                                <br><br>
                                <table id="example3" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NO KK</th>
                                            <th>NIK</th>
                                            <th>Kepala Keluarga</th>
                                            <th>Tgl Lahir</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Penghasilan</th>
                                            <th>Dusun</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        tampil_rekom_bst($mysqli);
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
                                <a href="<?= $base_url ?>app/print/cetak_rekom_blt.php" target="_blank" class="btn btn-success">
                                    <i class="fas fa-print"></i> Print
                                </a>
                                <br><br>
                                <table id="example4" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NO KK</th>
                                            <th>NIK</th>
                                            <th>Kepala Keluarga</th>
                                            <th>Tgl Lahir</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Penghasilan</th>
                                            <th>Dusun</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        tampil_rekom_blt($mysqli);
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Akhir Rekomendasi Bantuan -->
