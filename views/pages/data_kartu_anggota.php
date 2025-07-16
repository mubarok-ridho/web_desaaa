<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once __DIR__ . '/../../app/koneksi.php';
$koneksi = $mysqli;

if (isset($_GET['kode'])) {
  $karkel = $_GET['kode'];
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

  .table thead {
    background-color: #e6f0ff;
  }

  .btn-sm {
  padding: 0.3rem 0.75rem;
  font-size: 0.85rem;
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

</style>

<main class="main-content">
  <div class="container">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-users"></i> Data Anggota Keluarga</h3>
      </div>

      <!-- TABEL ANGGOTA -->
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead class="bg-light">
              <tr>
                <th>NIK</th>
                <th>Nama</th>
                <th>Hubungan Keluarga</th>
                <th>Jenis Kelamin</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = $koneksi->query("
              SELECT 
  a.NIK, a.NAMA_LGKP AS NAMA, 
  CASE a.JK
    WHEN 1 THEN 'Laki-laki' 
    WHEN 2 THEN 'Perempuan' 
    ELSE '-' 
  END AS jekel,
  a.NO_KK, 
  CASE a.HBKEL
    WHEN 1 THEN 'Kepala Keluarga'
    WHEN 2 THEN 'Istri'
    WHEN 3 THEN 'Anak'
    WHEN 4 THEN 'Kakek'
    WHEN 5 THEN 'Nenek'
    WHEN 6 THEN 'Family Lain'
    ELSE 'Tidak Diketahui'
  END AS hubungan 
FROM tabel_kependudukan a
WHERE a.NO_KK = '$karkel'
ORDER BY a.HBKEL ASC;
");


              while ($data = $sql->fetch_assoc()) {
              ?>
                <tr>
                  <td><?= htmlspecialchars($data['NIK']) ?></td>
                  <td><?= htmlspecialchars($data['NAMA']) ?></td>
                  <td><?= htmlspecialchars($data['hubungan']) ?></td>
                  <td><?= htmlspecialchars($data['jekel']) ?></td>
                  <td>
                     <a href="index.php?page=kartu-edit&nik=<?= $data['NIK'] ?>&from=anggota_kk&kode=<?= $karkel ?>" class="btn btn-warning btn-sm">
                      <i class="fa fa-edit"></i> Edit
                    </a>

                    <a href="index.php?page=kartu-delete&nik=<?= $data['NIK'] ?>&kk=<?= $karkel ?>" class="btn btn-danger btn-sm" 
                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                      <i class="fa fa-trash"></i> Hapus
                    </a>

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
