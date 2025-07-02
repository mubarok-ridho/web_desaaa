<?php
// Pastikan koneksi dan fungsi tersedia
include_once '../../app/koneksi.php';
include_once '../../app/post/post_data_kependudukan.php';

// Jika pakai session atau login checker:
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>

<div class="table-responsive">
  <a href="input_data_kependudukan" class="btn btn-primary mb-2">
    <i class="fas fa-plus-square"></i> Tambah Data Kependudukan
  </a>
  <a href="app/print/data_kependudukan.php" target="_blank" class="btn btn-success mb-2">
    <i class="fas fa-print"></i> Print
  </a>
  <table class="table table-bordered table-striped example3" style="font-size: 14px;">
    <thead>
      <tr>
        <th>No KK</th>
        <th>NIK</th>
        <th>Nama</th>
        <th>Jenis Kelamin</th>
        <th>Hubungan Keluarga</th>
        <th>Tempat Tanggal Lahir</th>
        <th>Pekerjaan Utama</th>
        <th>Penghasilan per Bulan</th>
        <th>Dusun</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php tampil_data($mysqli); ?>
    </tbody>
  </table>
</div>
