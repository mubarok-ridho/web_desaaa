<?php
ob_start(); // Mencegah output sebelum SweetAlert
include_once __DIR__ . '/../../app/koneksi.php';
$koneksi = $mysqli;
?>

<!-- Tambahkan Animate.css & SweetAlert jika belum -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="card card-primary mt-4">
  <div class="card-header bg-primary text-white">
    <h3 class="card-title"><i class="fa fa-plus-circle"></i> Tambah Kartu Keluarga</h3>
  </div>

  <form action="" method="post">
    <div class="card-body">

      <div class="form-group row mb-3">
        <label class="col-sm-2 col-form-label">No KK</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="NO_KK" placeholder="Masukkan No KK" required>
        </div>
      </div>

      <div class="form-group row mb-3">
        <label class="col-sm-2 col-form-label">Kepala Keluarga</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="NAMA_LGKP" placeholder="Nama Kepala Keluarga" required>
        </div>
      </div>

      <div class="form-group row mb-3">
        <label class="col-sm-2 col-form-label">Desa</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="DSN" placeholder="Nama Desa" required>
        </div>
      </div>

      <!-- <div class="form-group row mb-3">
        <label class="col-sm-2 col-form-label">RT / RW</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" name="rt" placeholder="RT" required>
        </div>
        <div class="col-sm-3">
          <input type="text" class="form-control" name="rw" placeholder="RW" required>
        </div>
      </div> -->
      
      <div class="form-group row mb-3">
        <label class="col-sm-2 col-form-label">Kelurahan</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="KELURAHAN" placeholder="Kelurahan" required>
        </div>
      </div>

      <div class="form-group row mb-3">
        <label class="col-sm-2 col-form-label">Kecamatan</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="KECAMATAN" placeholder="Kecamatan" required>
        </div>
      </div>

      <!-- <div class="form-group row mb-3">
        <label class="col-sm-2 col-form-label">Kabupaten</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="kab" placeholder="Kabupaten" required>
        </div>
      </div> -->

      <!-- <div class="form-group row mb-3">
        <label class="col-sm-2 col-form-label">Provinsi</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="prov" placeholder="Provinsi" required>
        </div>
      </div>
    </div> -->

    <div class="card-footer d-flex justify-content-between">
      <button type="submit" name="Simpan" class="btn btn-primary">
        <i class="fas fa-save"></i> Simpan & Tambah Anggota
      </button>
      <a href="<?= $_SERVER['HTTP_REFERER'] ?? 'index.php?page=data_kependudukan' ?>" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Kembali
      </a>
    </div>
  </form>
</div>

<?php
if (isset($_POST['Simpan'])) {
  $sql_simpan = "INSERT INTO tabel_kependudukan (NO_KK, NAMA_LGKP, DSN, KELURAHAN, KECAMATAN) VALUES (
    '" . $_POST['NO_KK'] . "',
    '" . $_POST['NAMA_LGKP'] . "',
    '" . $_POST['DSN'] . "',
    '" . $_POST['KELURAHAN'] . "',
    '" . $_POST['KECAMATAN'] . "'
  )";

  $query_simpan = mysqli_query($koneksi, $sql_simpan);
  $id_kk_baru = mysqli_insert_id($koneksi);
  mysqli_close($koneksi);

  if ($query_simpan) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
echo "<script src='https://cdn.lordicon.com/lordicon.js'></script>"; // ini penting!
echo "<script>
  Swal.fire({
    title: 'Berhasil!',
    html: `
      <div style='margin-top: 10px;'>
        <lord-icon
            src='https://cdn.lordicon.com/lupuorrc.json'
            trigger='loop'
            delay='200'
            colors='primary:#0ab39c,secondary:#0d6efd'
            style='width:100px;height:100px'>
        </lord-icon>
        <p class='mt-3 mb-0' style='font-size:15px;'>Data KK berhasil disimpan!</p>
      </div>
    `,
    showConfirmButton: false,
    timer: 2500
  }).then(() => {
    window.location.href = '/simkbs/data_kependudukan';
  });
</script>";

  } else {
    echo "<script>
      Swal.fire({
        title: '❌ Gagal Menyimpan!',
        text: 'Periksa koneksi atau pastikan tidak duplikat.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    </script>";
  }
}
?>