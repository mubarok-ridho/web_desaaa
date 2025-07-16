<?php error_reporting(0); ?>

<!-- Content Header -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12 d-flex justify-content-between align-items-center">
        <h3><i class="nav-icon fas fa-users"></i> Data Kependudukan</h3>
      </div>
    </div>
  </div>
</section>

<?php
include_once __DIR__ . '/../../app/koneksi_data_penduduk.php';
$koneksi = $mysqli_data_penduduk;

if (isset($_POST['import_kk'])) {
  $file = $_FILES['csv_kk']['tmp_name'];
  $handle = fopen($file, "r");
  $row = 0;
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    if ($row == 0) { $row++; continue; } // Skip header
    $no_kk = $data[0];
    $kepala = $data[1];
    $desa = $data[2];
    $rt = $data[3];
    $rw = $data[4];
    $kec = $data[5];
    $kab = $data[6];
    $prov = $data[7];

    $cek = mysqli_query($koneksi, "SELECT no_kk FROM tabel_kependudukan WHERE no_kk='$no_kk'");
    if (mysqli_num_rows($cek) == 0) {
      mysqli_query($koneksi, "INSERT INTO tabel_kependudukan (no_kk, kepala, desa, rt, rw, kec, kab, prov) VALUES ('$no_kk', '$kepala', '$desa', '$rt', '$rw', '$kec', '$kab', '$prov')");
    }
  }
  fclose($handle);
  echo "<script>
    Swal.fire({title: 'Upload Berhasil', text: 'Data berhasil ditambahkan.', icon: 'success', confirmButtonText: 'OK'})
    .then((result) => {
      if (result.value) { window.location = 'index.php?page=data_kependudukan&tab=kk'; }
    });
  </script>";
}
?>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">

        <!-- ALERT HASIL UPLOAD -->
        <div id="uploadResult" class="mt-2 mb-3 text-right text-success" style="font-size: 14px;"></div>

        <!-- Tombol Tab -->
        <ul class="nav nav-tabs mb-3" id="tabSwitcher">
          <li class="nav-item">
            <a class="nav-link active" href="#" data-tab="penduduk">Data Kependudukan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" data-tab="kk">Data KK</a>
          </li>
        </ul>

        <!-- Konten Dinamis -->
        <div id="tab-content">
          <?php include 'app/post/post_data_kependudukan.php'; ?>
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between mb-2">
                <div>
                  <a href="input_data_kependudukan" class="btn btn-primary">
                    <i class="fas fa-plus-square"></i> Tambah Data Kependudukan
                  </a>
                  <a href="app/print/data_kependudukan.php" target="_blank" class="btn btn-success">
                    <i class="fas fa-print"></i> Print
                  </a>
                </div>
                <div id="uploadCSVKKContainer" style="display: none;">
                  <form method="post" enctype="multipart/form-data" class="form-inline">
                    <input type="file" name="csv_kk" class="form-control mr-2" accept=".csv" required>
                    <button type="submit" name="import_kk" class="btn btn-warning btn-sm">
                      <i class="fas fa-file-csv"></i> Upload CSV KK
                    </button>
                  </form>
                </div>
              </div>
              <div class="table-responsive">
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
            </div>
          </div>
        </div> <!-- END TAB CONTENT -->

      </div>
    </div>
  </div>
</section>

<!-- SCRIPT JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    // Handle tab switching
    $('#tabSwitcher a').click(function (e) {
      e.preventDefault();
      $('#tabSwitcher a').removeClass('active');
      $(this).addClass('active');

      const selectedTab = $(this).data('tab');
      if (selectedTab === 'penduduk') {
        location.href = 'data_kependudukan';
      } else if (selectedTab === 'kk') {
        $('#tab-content').load('views/pages/user/data_kartu_kk.php');
        $('#uploadCSVKKContainer').show();
      }
    });

    // Auto switch ke tab KK jika URL mengandung ?tab=kk
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab');
    if (tab === 'kk') {
      $('#tabSwitcher a[data-tab="kk"]').trigger('click');
      $('#uploadCSVKKContainer').show();
    }
  });
</script>
