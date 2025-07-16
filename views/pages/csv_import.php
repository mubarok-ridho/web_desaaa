<?php
ob_start();
session_start();

// Koneksi DB
include_once $_SERVER['DOCUMENT_ROOT'] . '/simkbs/app/koneksi.php';
$koneksi = $mysqli;

// Import CSV jika dikirim
if (isset($_POST['import_kk']) && isset($_FILES['csv_kk'])) {
  $file = $_FILES['csv_kk']['tmp_name'];

  if (!file_exists($file)) {
    echo "<script>
      alert('File tidak ditemukan!');
      window.history.back();
    </script>";
    exit;
  }

  // Konversi encoding
  $content = file_get_contents($file);
  $content = mb_convert_encoding($content, 'UTF-8', 'auto');

  // Simpan ke file sementara
  $tempPath = tempnam(sys_get_temp_dir(), 'csv_kk_');
  file_put_contents($tempPath, $content);

  $handle = fopen($tempPath, 'r');
  if (!$handle) {
    echo "<script>
      alert('Gagal membuka file');
      window.history.back();
    </script>";
    exit;
  }

  // Deteksi delimiter
  $firstLine = fgets($handle);
  $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';
  rewind($handle);
  fgetcsv($handle, 1000, $delimiter); // skip header

  $sukses = 0;
  $duplikat = 0;
  $duplicates = [];

  // Loop tiap baris
  while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
    if (count($data) < 20) continue;

    list(
        $no_kk, $nik, $nama_lgkp, $hbkel, $jk, $tmpt_lhr, $tgl_lhr, $tahun, $bulan, $hari,
        $nama_ayah, $nama_ibu, $kecamatan, $kelurahan, $dsn, $agama,
        $bantuan, $jenis_bantuan, $ibu_hamil, $disabilitas
    ) = array_map(fn($val) => mysqli_real_escape_string($koneksi, trim($val)), $data);

    if (empty($no_kk) || empty($nik)) continue;

    $cek = mysqli_query($koneksi, "SELECT * FROM tabel_kependudukan WHERE NIK = '$nik'");
    if (mysqli_num_rows($cek) == 0) {
        $insert = "INSERT INTO tabel_kependudukan (
            NO_KK, NIK, NAMA_LGKP, HBKEL, JK, TMPT_LHR, TGL_LHR, TAHUN, BULAN, HARI,
            NAMA_LGKP_AYAH, NAMA_LGKP_IBU, KECAMATAN, KELURAHAN, DSN, AGAMA,
            bantuan, jenis_bantuan, ibu_hamil, disabilitas
        ) VALUES (
            '$no_kk', '$nik', '$nama_lgkp', '$hbkel', '$jk', '$tmpt_lhr', '$tgl_lhr', '$tahun', '$bulan', '$hari',
            '$nama_ayah', '$nama_ibu', '$kecamatan', '$kelurahan', '$dsn', '$agama',
            '$bantuan', '$jenis_bantuan', '$ibu_hamil', '$disabilitas'
        )";
        mysqli_query($koneksi, $insert);
        $sukses++;
    } else {
        $duplikat++;
        $duplicates[] = $nik;
    }
}


  fclose($handle);
  unlink($tempPath);

  // Kirim hasil ke halaman sebelumnya lewat session alert
  $_SESSION['alert'] = [
    'type' => 'success',
    'message' => "✅ <b>$sukses</b> data berhasil ditambahkan. <br>⚠️ <b>$duplikat</b> data duplikat.",
    'duplicates' => $duplicates
  ];

  header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../../index.php?page=data_kependudukan&tab=kk'));
  exit;
}
?>
