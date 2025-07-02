<?php
ob_start();
include_once __DIR__ . '/../../app/koneksi_data_penduduk.php';
$koneksi = $mysqli_data_penduduk;

if (isset($_GET['kode'])) {
  $id_anggota = $_GET['kode'];

  // Cek dan ambil id_kk dulu
  $cek = $koneksi->query("SELECT id_kk FROM tb_anggota WHERE id_anggota = '$id_anggota'");
  $row = $cek->fetch_assoc();
  $id_kk = $row['id_kk'];

  // Eksekusi penghapusan
  $sql_hapus = "DELETE FROM tb_anggota WHERE id_anggota='$id_anggota'";
  $query_hapus = mysqli_query($koneksi, $sql_hapus);

  echo "
  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
  <script src='https://cdn.lordicon.com/lordicon.js'></script>
  <script>
    Swal.fire({
      html: `
        <div class='text-center'>
          <lord-icon
              src='https://cdn.lordicon.com/skkahier.json'
              trigger='loop'
              delay='50'
              state='morph-trash-in'
              colors='primary:#f06548,secondary:#e83e8c'
              style='width:80px;height:80px'>
          </lord-icon>
          <h5 class='mt-3'>Data berhasil dihapus</h5>
        </div>
      `,
      showConfirmButton: false,
      timer: 1800,
      didClose: () => {
        history.back();
      }
    });
  </script>";
}
?>
