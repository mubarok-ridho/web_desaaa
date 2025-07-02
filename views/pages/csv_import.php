<?php
ob_start();
session_start();

// Koneksi DB
include_once $_SERVER['DOCUMENT_ROOT'] . '/simkbs/app/koneksi_data_penduduk.php';
$koneksi = $mysqli_data_penduduk;

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
    if (count($data) < 8) continue;

    list($no_kk, $kepala, $desa, $rt, $rw, $kec, $kab, $prov) = array_map(
      fn($val) => mysqli_real_escape_string($koneksi, trim($val)),
      $data
    );

    if (empty($no_kk) || empty($kepala)) continue;

    $cek = mysqli_query($koneksi, "SELECT no_kk FROM tb_kk WHERE no_kk='$no_kk'");
    if (mysqli_num_rows($cek) == 0) {
      mysqli_query($koneksi, "INSERT INTO tb_kk (no_kk, kepala, desa, rt, rw, kec, kab, prov)
                              VALUES ('$no_kk', '$kepala', '$desa', '$rt', '$rw', '$kec', '$kab', '$prov')");
      $sukses++;
    } else {
      $duplikat++;
      $duplicates[] = $no_kk;
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
