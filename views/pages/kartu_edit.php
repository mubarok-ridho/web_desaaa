<?php
include_once __DIR__ . '/../../app/koneksi.php';
$koneksi = $mysqli;

$data_cek = null;
$dusunList = [];

// Default redirect
$redirectPage = "http://localhost/simkbs/data_kependudukan";
if (isset($_GET['from']) && $_GET['from'] === 'anggota_kk' && isset($_GET['kode'])) {
  $redirectPage = 'index.php?page=anggota_kk&kode=' . $_GET['kode'];
}

// Ambil data dusun
$dusunQuery = mysqli_query($koneksi, "SELECT * FROM tabel_dusun ORDER BY id ASC");
while ($d = mysqli_fetch_assoc($dusunQuery)) {
  $dusunList[] = $d;
}

// Ambil data penduduk
if (isset($_GET['nik'])) {
  $nik = $_GET['nik'];
  $sql_cek = "SELECT * FROM tabel_kependudukan WHERE NIK = '$nik'";
  $query_cek = mysqli_query($koneksi, $sql_cek);
  $data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);
}

// Jika tidak ditemukan
if (!$data_cek) {
  echo "<script>
    alert('Data tidak ditemukan!');
  window.history.back();
  </script>";
  exit;
}

// Proses update
if (isset($_POST['Ubah'])) {
  $sql_ubah = "UPDATE tabel_kependudukan SET 
    NAMA_LGKP = '" . $_POST['NAMA_LGKP'] . "',
    HBKEL = '" . $_POST['HBKEL'] . "',
    JK = '" . $_POST['JK'] . "',
    DSN = '" . $_POST['DSN'] . "',
    KECAMATAN = '" . $_POST['KECAMATAN'] . "',
    KELURAHAN = '" . $_POST['KELURAHAN'] . "'
    WHERE NIK = '" . $_POST['NIK'] . "'";

  $query_ubah = mysqli_query($koneksi, $sql_ubah);
  mysqli_close($koneksi);

  if ($query_ubah) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
      Swal.fire({
        title: '✅ Berhasil!',
        text: 'Data berhasil diubah.',
        icon: 'success',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = '$redirectPage';
        }
      });
    </script>";
    exit;
  } else {
    echo "<script>
      Swal.fire({
        title: '❌ Gagal Mengubah Data!',
        text: 'Periksa koneksi atau data input.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    </script>";
  }
}
?>

<style>
  .card {
    margin-top: 50px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  }

  .card-header {
    background-color: #d4f1f9;
    border-bottom: 1px solid #c0e0eb;
    font-weight: bold;
    color: #004d66;
  }

  .form-group {
    margin-bottom: 1.2rem;
  }

  .form-group label {
    font-weight: 500;
  }

  .btn {
    padding: 0.45rem 1rem;
    font-size: 0.95rem;
    border-radius: 6px;
  }

  .btn-success {
    background-color: #8ee4af;
    border-color: #5cc3a3;
    color: #004d3c;
  }

  .btn-secondary {
    background-color: #eee;
    color: #444;
  }

  @media (max-width: 768px) {
    .form-group.row {
      flex-direction: column;
      align-items: flex-start;
    }
  }
</style>

<div class="card card-success">
  <div class="card-header">
    <h3 class="card-title"><i class="fa fa-edit"></i> Ubah Data KK</h3>
  </div>

  <form action="" method="post" class="p-3">
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">NIK</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" name="NIK" value="<?= $data_cek['NIK'] ?>" readonly>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-3 col-form-label">No KK</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" value="<?= $data_cek['NO_KK'] ?>" readonly>
        <input type="hidden" name="NO_KK" value="<?= $data_cek['NO_KK'] ?>">
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Nama</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" name="NAMA_LGKP" value="<?= $data_cek['NAMA_LGKP'] ?>" required>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Hubungan Keluarga</label>
      <div class="col-sm-6">
        <select class="form-control" name="HBKEL" required>
          <option hidden value="">-- Pilih Hubungan --</option>
          <option value="1" <?= $data_cek['HBKEL'] == 1 ? 'selected' : '' ?>>Kepala Keluarga</option>
          <option value="2" <?= $data_cek['HBKEL'] == 2 ? 'selected' : '' ?>>Istri</option>
          <option value="3" <?= $data_cek['HBKEL'] == 3 ? 'selected' : '' ?>>Anak</option>
          <option value="4" <?= $data_cek['HBKEL'] == 4 ? 'selected' : '' ?>>Kakek</option>
          <option value="5" <?= $data_cek['HBKEL'] == 5 ? 'selected' : '' ?>>Nenek</option>
          <option value="6" <?= $data_cek['HBKEL'] == 6 ? 'selected' : '' ?>>Family Lain</option>
        </select>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
      <div class="col-sm-6">
        <select class="form-control" name="JK" required>
          <option hidden value="">-- Pilih Jenis Kelamin --</option>
          <option value="1" <?= $data_cek['JK'] == 1 ? 'selected' : '' ?>>Laki-laki</option>
          <option value="2" <?= $data_cek['JK'] == 2 ? 'selected' : '' ?>>Perempuan</option>
        </select>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Dusun</label>
      <div class="col-sm-6">
        <select class="form-control" name="DSN" required>
          <option hidden value="">-- Pilih Dusun --</option>
          <?php foreach ($dusunList as $dusun): ?>
            <option value="<?= $dusun['id'] ?>" <?= $data_cek['DSN'] == $dusun['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($dusun['dusun']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Kecamatan</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" name="KECAMATAN" value="<?= $data_cek['KECAMATAN'] ?>" required>
      </div>
    </div>

    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Kelurahan</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" name="KELURAHAN" value="<?= $data_cek['KELURAHAN'] ?>" required>
      </div>
    </div>

    <div class="card-footer">
      <button type="submit" name="Ubah" class="btn btn-success">
        <i class="fa fa-save"></i> Simpan Perubahan
      </button>
      <a href="<?= $redirectPage ?>" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
