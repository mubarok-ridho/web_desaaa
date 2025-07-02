<?php
session_start(); // <- WAJIB ADA!
include_once __DIR__ . '/../../../app/koneksi_data_penduduk.php';
$koneksi = $mysqli_data_penduduk;
?>

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
  .card {
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    margin-top: 40px;
  }

  .card-header {
    background: #e0f0ff;
    border-bottom: 1px solid #cce0ff;
    padding: 1rem 1.25rem;
  }

  .card-title {
    font-weight: 600;
    color: #004080;
    margin: 0;
  }

  .btn {
    font-size: 0.9rem;
    border-radius: 6px;
  }

  .btn i {
    margin-right: 0.4rem;
  }

  .btn-primary {
    background-color: #a3d5ff;
    border-color: #90caff;
    color: #003366;
  }

  .btn-warning {
    background-color: #ffe9a8;
    border-color: #f3d97e;
    color: #5a4b00;
  }

  .btn-outline-info {
    border-color: #80dfff;
    color: #007099;
  }

  .btn-outline-success {
    border-color: #a2e8c8;
    color: #2b6b55;
  }

  .btn-outline-danger {
    border-color: #ffb3b3;
    color: #992626;
  }

  .thead-dark {
    background-color: #d5e9ff;
    color: #003366;
  }

  .table-hover tbody tr:hover {
    background-color: #f0f8ff;
  }

  .form-inline input[type="file"] {
    max-width: 220px;
  }

  .form-inline .btn {
    margin-left: 8px;
  }

  @media (max-width: 768px) {
    .card-header .d-flex {
      flex-direction: column;
      align-items: flex-start;
    }
  }
</style>

<?php if (isset($_SESSION['alert'])): ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      Swal.fire({
        icon: '<?= $_SESSION['alert']['type'] === 'success' ? 'success' : 'warning' ?>',
        title: '<?= $_SESSION['alert']['type'] === 'success' ? 'Berhasil!' : 'Perhatian!' ?>',
        html: `<?= $_SESSION['alert']['message']; ?><?= !empty($_SESSION['alert']['duplicates']) ? '<br><small><strong>Duplikat NO KK:</strong> ' . implode(', ', $_SESSION['alert']['duplicates']) . '</small>' : '' ?>`,
        showConfirmButton: false,
        timer: 4000
      });
    });
  </script>
  <?php unset($_SESSION['alert']); ?>
<?php endif; ?>

<div class="card shadow">
  <div class="card-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
      <h3 class="card-title mb-2 mb-md-0">
        <i class="fa fa-table"></i> Data Kartu Keluarga (KK)
      </h3>
      <div class="d-flex flex-wrap align-items-center">
  <!-- Tombol Tambah Data -->
  <a href="index.php?page=kartu-add" title="Tambah Data" class="btn btn-primary btn-sm mr-2 mb-2">
    <i class="fa fa-plus-circle"></i> Tambah Data
  </a>

  <!-- Form Upload CSV -->
  <form method="post" action="views/pages/csv_import.php" enctype="multipart/form-data" class="form-inline mb-2">
    <input type="file" name="csv_kk" accept=".csv" required class="form-control form-control-sm mr-2" style="width: 200px;">
    <button type="submit" name="import_kk" class="btn btn-warning btn-sm">
      <i class="fas fa-file-upload"></i> Upload CSV
    </button>
  </form>
</div>

    </div>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table id="example1" class="table table-bordered table-striped table-hover">
        <thead class="thead-dark text-center">
          <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 15%;">NO KK</th>
            <th style="width: 20%;">Kepala Keluarga</th>
            <th>Alamat</th>
            <th style="width: 15%;">Anggota KK</th>
            <th style="width: 20%;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          $sql = $koneksi->query("SELECT * FROM tb_kk ORDER BY id_kk DESC");
          while ($data = $sql->fetch_assoc()) {
          ?>
            <tr>
              <td class="text-center"><?= $no++; ?></td>
              <td><?= htmlspecialchars($data['no_kk']); ?></td>
              <td><?= htmlspecialchars($data['kepala']); ?></td>
              <td><?= htmlspecialchars($data['desa']); ?>, RT <?= htmlspecialchars($data['rt']); ?>/RW <?= htmlspecialchars($data['rw']); ?></td>
              <td class="text-center">
                <a href="index.php?page=anggota_kk&kode=<?= $data['id_kk']; ?>" class="btn btn-outline-info btn-sm" title="Lihat Anggota KK">
                  <i class="fa fa-users"></i> Lihat
                </a>
              </td>
              <td class="text-center">
                <a href="index.php?page=kartu-edit&kode=<?= $data['id_kk']; ?>" class="btn btn-outline-success btn-sm" title="Edit Data">
                  <i class="fa fa-edit"></i> Edit
                </a>
                <a href="index.php?page=kartu-delete&kode=<?= $data['id_kk']; ?>" class="btn btn-outline-danger btn-sm" title="Hapus Data" onclick="return confirm('Yakin ingin menghapus data ini?');">
                  <i class="fa fa-trash"></i> Hapus
                </a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
