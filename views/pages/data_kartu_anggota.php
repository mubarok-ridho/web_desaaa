<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once __DIR__ . '/../../app/koneksi_data_penduduk.php';
$koneksi = $mysqli_data_penduduk;

if (isset($_GET['kode'])) {
  $sql_cek = "SELECT * FROM tb_kk WHERE id_kk='" . $_GET['kode'] . "'";
  $query_cek = mysqli_query($koneksi, $sql_cek);
  $data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);
  $karkel = $data_cek['id_kk'];
}

if (isset($_SESSION['alert'])) {
  echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
  echo "<script>
    Swal.fire({
      icon: '{$_SESSION['alert']['type']}',
      title: '{$_SESSION['alert']['title']}',
      html: `{$_SESSION['alert']['message']}`,
      confirmButtonText: 'OK'
    }).then(() => {
      window.location.href = window.location.href;
    });
  </script>";
  unset($_SESSION['alert']);
}
?>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
  body {
    background-color: #f8f9fb;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    color: #333;
  }

  main.main-content {
    flex: 1;
    padding-top: 100px;
    padding-bottom: 60px;
  }

  footer {
    background-color: #cce6ff;
    color: #003366;
    text-align: center;
    padding: 1rem;
    font-size: 0.9rem;
  }

  .card {
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
  }

  .card-header {
    font-weight: bold;
    background: #dfeeff;
    color: #333;
    border-bottom: 1px solid #ccc;
  }

  .btn {
    padding: 0.45rem 1rem;
    font-size: 0.9rem;
    border-radius: 0.4rem;
  }

  .btn-sm {
    padding: 0.3rem 0.75rem;
    font-size: 0.85rem;
  }

  .btn i {
    margin-right: 0.4rem;
  }

  .btn-success {
    background-color: #98e2b7;
    border-color: #80d2a0;
    color: #1e4d3a;
  }

  .btn-warning {
    background-color: #ffe9a8;
    border-color: #f3d97e;
    color: #5a4b00;
  }

  .btn-danger {
    background-color: #ffb3b3;
    border-color: #e68080;
    color: #6b0000;
  }

  .btn-outline-secondary {
    background-color: #eee;
    border-color: #ccc;
    color: #333;
  }

  .table thead {
    background-color: #e6f0ff;
  }

  .csv-upload-container {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
    margin-bottom: 0.5rem;
  }

  .csv-upload-container input[type="file"] {
    max-width: 250px;
  }
</style>

<main class="main-content">
  <div class="container">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-users"></i> Tambah Anggota Keluarga</h3>
      </div>

      <!-- FORM TAMBAH MANUAL -->
      <form action="" method="post">
        <div class="card-body">
          <input type="hidden" name="id_kk" value="<?= $data_cek['id_kk'] ?>">

          <div class="form-group row mb-3">
            <label class="col-sm-2 col-form-label">No KK / Kepala</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" value="<?= $data_cek['no_kk'] ?>" readonly>
            </div>
            <div class="col-sm-4">
              <input type="text" class="form-control" value="<?= $data_cek['kepala'] ?>" readonly>
            </div>
          </div>

          <div class="form-group row mb-3">
            <label class="col-sm-2 col-form-label">Alamat</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" value="<?= "{$data_cek['desa']}, RT {$data_cek['rt']} RW {$data_cek['rw']} ({$data_cek['kec']} - {$data_cek['kab']} - {$data_cek['prov']})" ?>" readonly>
            </div>
          </div>

          <div class="form-group row mb-3">
            <label class="col-sm-2 col-form-label">Anggota</label>
            <div class="col-sm-4">
              <select name="id_pend" class="form-control select2bs4" required>
                <option selected disabled>- Pilih Penduduk -</option>
                <?php
                $query = "SELECT * FROM tb_pdd WHERE status='Ada'";
                $hasil = mysqli_query($koneksi, $query);
                while ($row = mysqli_fetch_array($hasil)) {
                  echo "<option value='{$row['id_pend']}'>{$row['nik']} - {$row['nama']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-sm-4">
              <select name="hubungan" class="form-control" required>
                <option selected disabled>- Hubungan Keluarga -</option>
                <option>Kepala Keluarga</option>
                <option>Istri</option>
                <option>Anak</option>
                <option>Orang Tua</option>
                <option>Mertua</option>
                <option>Menantu</option>
                <option>Cucu</option>
                <option>Famili Lain</option>
              </select>
            </div>
            <div class="col-sm-2 d-flex align-items-end">
              <button type="submit" name="Simpan" class="btn btn-success w-100">
                <i class="fa fa-plus-circle"></i> Tambah
              </button>
            </div>
          </div>
        </div>
      </form>

      <!-- FORM UPLOAD CSV -->
      <div class="card-body border-top pt-3">
        <form method="post" enctype="multipart/form-data" class="csv-upload-container">
          <input type="hidden" name="id_kk_csv" value="<?= $data_cek['id_kk'] ?>">
          <label class="mb-0">Upload CSV Anggota:</label>
          <input type="file" name="csv_anggota" accept=".csv" required class="form-control form-control-sm">
          <button type="submit" name="import_anggota" class="btn btn-warning btn-sm">
            <i class="fas fa-file-upload"></i> Import CSV
          </button>
        </form>
        <small class="text-muted d-block mt-2">Format CSV: <code>NIK;Hubungan</code></small>
      </div>

      <!-- TABEL ANGGOTA -->
      <div class="card-body pt-0">
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead class="bg-light">
              <tr>
                <th>NIK</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Hubungan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = $koneksi->query("SELECT p.nik, p.nama, p.jekel, a.hubungan, a.id_anggota 
                                      FROM tb_pdd p 
                                      INNER JOIN tb_anggota a ON p.id_pend = a.id_pend 
                                      WHERE status = 'Ada' AND id_kk = $karkel");
              while ($data = $sql->fetch_assoc()) {
              ?>
                <tr>
                  <td><?= $data['nik'] ?></td>
                  <td><?= $data['nama'] ?></td>
                  <td><?= $data['jekel'] ?></td>
                  <td><?= $data['hubungan'] ?></td>
                  <td>
                    <form method="post" style="display:inline;">
                      <input type="hidden" name="hapus_id" value="<?= $data['id_anggota'] ?>">
                      <input type="hidden" name="kk_id" value="<?= $karkel ?>">
                      <button type="submit" name="hapus" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                        <i class="fa fa-trash"></i> Hapus
                      </button>
                    </form>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="card-footer">
        <a href="http://localhost/simkbs/data_kependudukan" class="btn btn-warning">
  <i class="fa fa-arrow-left"></i> Kembali
</a>

      </div>
    </div>
  </div>
</main>

<footer>
  © Copyright PEMDES KALIPUTIH. All Rights Reserved | Versi 1.0
</footer>

<?php
// === TAMBAH ===
if (isset($_POST['Simpan'])) {
  $query = mysqli_query($koneksi, "INSERT INTO tb_anggota (id_kk, id_pend, hubungan) 
                                   VALUES ('{$_POST['id_kk']}', '{$_POST['id_pend']}', '{$_POST['hubungan']}')");
  $_SESSION['alert'] = [
    'type' => $query ? 'success' : 'error',
    'title' => $query ? 'Berhasil!' : 'Gagal!',
    'message' => $query ? 'Data berhasil ditambahkan.' : 'Gagal menambahkan data.'
  ];
  echo "<script>window.location.href = window.location.href;</script>";
  exit;
}

// === IMPORT CSV ===
if (isset($_POST['import_anggota']) && isset($_FILES['csv_anggota'])) {
  $id_kk = $_POST['id_kk_csv'];
  $file = $_FILES['csv_anggota']['tmp_name'];

  $content = file_get_contents($file);
  $content = mb_convert_encoding($content, 'UTF-8', 'auto');
  $temp = tmpfile();
  fwrite($temp, $content);
  rewind($temp);

  $sukses = $gagal = $duplikat = 0;

  while (($data = fgetcsv($temp, 1000, ';')) !== FALSE) {
    if (count($data) < 2) continue;
    $nik = mysqli_real_escape_string($koneksi, trim($data[0]));
    $hub = mysqli_real_escape_string($koneksi, trim($data[1]));

    $pendQuery = mysqli_query($koneksi, "SELECT id_pend FROM tb_pdd WHERE nik = '$nik'");
    if ($pend = mysqli_fetch_assoc($pendQuery)) {
      $id_pend = $pend['id_pend'];
      $cek = mysqli_query($koneksi, "SELECT * FROM tb_anggota WHERE id_kk = '$id_kk' AND id_pend = '$id_pend'");
      if (mysqli_num_rows($cek) == 0) {
        mysqli_query($koneksi, "INSERT INTO tb_anggota (id_kk, id_pend, hubungan) VALUES ('$id_kk', '$id_pend', '$hub')");
        $sukses++;
      } else {
        $duplikat++;
      }
    } else {
      $gagal++;
    }
  }
  fclose($temp);

  $_SESSION['alert'] = [
    'type' => 'success',
    'title' => 'Import Selesai!',
    'message' => "✅ <b>$sukses</b> berhasil<br>⚠️ <b>$duplikat</b> duplikat<br>❌ <b>$gagal</b> tidak ditemukan"
  ];
  echo "<script>window.location.href = window.location.href;</script>";
  exit;
}

// === HAPUS ===
if (isset($_POST['hapus'])) {
  $id = $_POST['hapus_id'];
  $id_kk = $_POST['kk_id'];

  $query = mysqli_query($koneksi, "DELETE FROM tb_anggota WHERE id_anggota='$id'");

  $_SESSION['alert'] = [
    'type' => $query ? 'success' : 'error',
    'title' => $query ? 'Berhasil dihapus!' : 'Gagal!',
    'message' => $query ? 'Data anggota berhasil dihapus.' : 'Data gagal dihapus.'
  ];

  echo "<script>window.location.href = window.location.href;</script>";
  exit;
}
?>
