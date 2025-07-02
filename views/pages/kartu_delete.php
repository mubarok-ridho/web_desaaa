<?php
include_once __DIR__ . '/../../app/koneksi_data_penduduk.php';
$koneksi = $mysqli_data_penduduk;

if (!$koneksi) {
    die("Koneksi database gagal.");
}

if (isset($_GET['kode'])) {
    $id_kk = $_GET['kode'];

    $sql_hapus = "DELETE FROM tb_kk WHERE id_kk='$id_kk'";
    $query_hapus = mysqli_query($koneksi, $sql_hapus);

    if ($query_hapus) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script src='https://cdn.lordicon.com/lordicon.js'></script>";
        echo "<script>
        Swal.fire({
          title: 'Data Dihapus!',
          html: `
            <div style='margin-top: 10px;'>
              <lord-icon
                  src='https://cdn.lordicon.com/kfzfxczd.json'
                  trigger='loop'
                  delay='200'
                  colors='primary:#e74c3c,secondary:#f9c74f'
                  style='width:100px;height:100px'>
              </lord-icon>
              <p class='mt-3 mb-0' style='font-size:15px;'>Data KK berhasil dihapus.</p>
            </div>
          `,
          showConfirmButton: false,
          timer: 2500
        }).then(() => {
          window.location.href = '/simkbs/data_kependudukan';
        });
        </script>";
        exit;
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
        Swal.fire({
            title: 'Hapus Data Gagal',
            text: 'Terjadi kesalahan saat menghapus data.',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then(() => {
window.location.href = '/simkbs/data_kependudukan?tab=kk';
        });
        </script>";
        exit;
    }
}
?>
