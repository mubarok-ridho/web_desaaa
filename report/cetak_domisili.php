<?php
session_start();
include "../app/koneksi.php"; // pastikan path sudah benar
$koneksi = $mysqli;

// cek apakah form cetak dikirim
if (isset($_POST['btnCetak'])) {
    $nik = $_POST['id_pend']; // NIK sebagai identifier unik

    // ambil data penduduk berdasarkan NIK
    $sql_tampil = "SELECT * FROM tabel_kependudukan WHERE NIK = '$nik'";
    $query_tampil = mysqli_query($koneksi, $sql_tampil);

    if ($query_tampil && mysqli_num_rows($query_tampil) > 0) {
        $data = mysqli_fetch_assoc($query_tampil);
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.history.back();</script>";
        exit;
    }

    $tanggal = date("m/y");
    $tgl = date("d/m/y");
} else {
    echo "<script>alert('Tidak ada data yang dipilih!'); window.history.back();</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CETAK SURAT</title>
    <style>
        table { margin:auto; }
        td { padding:5px 10px; }
    </style>
</head>
<body>
<center>
    <h2>PEMERINTAH KABUPATEN BANTUL</h2>
    <h3>KECAMATAN KASIHAN <br>DESA TAMANTIRTO</h3>
    <hr style="width:80%;">
    
    <h4><u>SURAT KETERANGAN DOMISILI</u></h4>
    <h4>No Surat : <?php echo $data['NO_KK']; ?>/Ket.Domisili/<?php echo $tanggal; ?></h4>

    <p>Yang bertandatangan dibawah ini Kepala Desa Tamantirto, Kecamatan Kasihan, Kabupaten Bantul, dengan ini menerangkan bahwa :</p>

    <table>
        <tr><td>NIK</td><td>:</td><td><?php echo $data['NIK']; ?></td></tr>
        <tr><td>Nama</td><td>:</td><td><?php echo $data['NAMA_LGKP']; ?></td></tr>
        <tr><td>Jenis Kelamin</td><td>:</td><td><?php echo ($data['JK'] == 1) ? 'Laki-laki' : 'Perempuan'; ?></td></tr>
        <tr><td>TTL</td><td>:</td><td><?php echo $data['TMPT_LHR']; ?> / <?php echo $data['TGL_LHR']; ?></td></tr>
    </table>

    <p>Adalah benar-benar warga Desa Tamantirto, Kecamatan Kasihan, Kabupaten Bantul.</p>
    <p>Demikian Surat ini dibuat agar dapat digunakan sebagaimana mestinya.</p>

    <p align="right">
        Bantul, <?php echo $tgl; ?><br>
        KEPALA DESA TAMANTIRTO<br><br><br><br>
        ( WISNU ARDI )
    </p>
</center>

<script>
    window.print();
</script>
</body>
</html>
