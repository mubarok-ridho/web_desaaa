<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/simkbs/app/koneksi_data_penduduk.php';
$koneksi = $mysqli_data_penduduk;

if (isset($_POST['import_anggota']) && isset($_FILES['csv_anggota']) && isset($_POST['id_kk_csv'])) {
  $file = $_FILES['csv_anggota']['tmp_name'];
  $id_kk = (int) $_POST['id_kk_csv'];

  if (!file_exists($file)) {
    echo "<script>
      alert('❌ File tidak ditemukan!');
      window.location.href = '../../index.php?page=anggota&kode=$id_kk';
    </script>";
    exit;
  }

  // Baca isi CSV dan konversi encoding
  $content = file_get_contents($file);
  $content = mb_convert_encoding($content, 'UTF-8', 'auto');
  $tempPath = tempnam(sys_get_temp_dir(), 'csv_anggota_');
  file_put_contents($tempPath, $content);

  $handle = fopen($tempPath, 'r');
  if (!$handle) {
    echo "<script>
      alert('❌ Gagal membuka file.');
      window.location.href = '../../index.php?page=anggota&kode=$id_kk';
    </script>";
    exit;
  }

  $firstLine = fgets($handle);
  $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';
  rewind($handle);
  fgetcsv($handle, 1000, $delimiter); // skip header jika ada

  $sukses = 0;
  $gagal = 0;
  $notfound = [];

  while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
    if (count($data) < 2) continue;

    list($nik, $hubungan) = array_map('trim', $data);
    $nik = mysqli_real_escape_string($koneksi, $nik);
    $hubungan = mysqli_real_escape_string($koneksi, $hubungan);

    if (empty($nik) || empty($hubungan)) continue;

    $q = mysqli_query($koneksi, "SELECT id_pend FROM tb_pdd WHERE nik='$nik' AND status='Ada' LIMIT 1");
    if ($q && mysqli_num_rows($q) > 0) {
      $row = mysqli_fetch_assoc($q);
      $id_pend = $row['id_pend'];

      $check = mysqli_query($koneksi, "SELECT * FROM tb_anggota WHERE id_kk=$id_kk AND id_pend=$id_pend");
      if (mysqli_num_rows($check) == 0) {
        mysqli_query($koneksi, "INSERT INTO tb_anggota (id_kk, id_pend, hubungan) VALUES ($id_kk, $id_pend, '$hubungan')");
        $sukses++;
      } else {
        $gagal++;
      }
    } else {
      $notfound[] = $nik;
    }
  }

  fclose($handle);
  unlink($tempPath);

  // Buat pesan hasil
  $msg = "✅ <b>$sukses</b> anggota berhasil ditambahkan.<br>⚠️ <b>$gagal</b> data duplikat.";
  if (!empty($notfound)) {
    $msg .= "<br>❌ <b>" . count($notfound) . "</b> NIK tidak ditemukan:<br><small>" . implode(', ', $notfound) . "</small>";
  }

  // Tampilkan animasi SweetAlert
  echo "
  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
  <script src='https://cdn.lordicon.com/lordicon.js'></script>
  <script>
    Swal.fire({
      html: `
        <div class='text-center'>
          <lord-icon
              src='https://cdn.lordicon.com/lupuorrc.json'
              trigger='loop'
              delay='100'
              colors='primary:#0ab39c,secondary:#00bcd4'
              style='width:80px;height:80px'>
          </lord-icon>
          <h5 class='mt-3'>Import Selesai!</h5>
          <div class='mt-2' style='font-size:14px;text-align:left'>
            $msg
          </div>
        </div>
      `,
      showConfirmButton: false,
      timer: 3500,
      timerProgressBar: true,
      willClose: () => {
        window.location.href = '../../index.php?page=anggota&kode=$id_kk';
      }
    });
  </script>";
  exit;
}
?>
