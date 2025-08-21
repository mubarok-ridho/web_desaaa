<?php
session_start();
include "../app/koneksi.php"; 
$koneksi = $mysqli;

if (isset($_POST['btnCetak'])) {
    $id = $_POST['id_datang'];
    $tgl_datang = $_POST['tgl_datang']; // <-- ambil dari input manual

    $sql_tampil = "SELECT * FROM tabel_kependudukan WHERE NIK = '$id'";
    $query_tampil = mysqli_query($koneksi, $sql_tampil);

    if ($query_tampil && mysqli_num_rows($query_tampil) > 0) {
        $data = mysqli_fetch_assoc($query_tampil);
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.history.back();</script>";
        exit;
    }

    $tanggal = date("m/y");
    $tgl = date("d/m/y");

    // manipulasi JK
    $jk = $data['JK'] == '1' ? "Laki-laki" : ($data['JK'] == '2' ? "Perempuan" : "Tidak Diketahui");

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
    
    <h4><u>SURAT KETERANGAN PENDATANG</u></h4>
    <h4>No Surat : <?php echo $id; ?>/Ket.Pendatang/<?php echo $tanggal; ?></h4>

    <p>Yang bertandatangan di bawah ini Kepala Desa Tamantirto, Kecamatan Kasihan, Kabupaten Bantul, dengan ini menerangkan bahwa :</p>

    <table>
        <tr><td>NIK</td><td>:</td><td><?php echo $data['NIK']; ?></td></tr>
        <tr><td>Nama</td><td>:</td><td><?php echo $data['NAMA_LGKP']; ?></td></tr>
        <tr><td>Jenis Kelamin</td><td>:</td><td><?php echo $jk; ?></td></tr>
        <tr><td>Tanggal Datang</td><td>:</td><td><?php echo date("d-m-Y", strtotime($tgl_datang)); ?></td></tr>
    </table>

    <p>Benar-benar telah datang dan berencana untuk tinggal di Desa Tamantirto, Kecamatan Kasihan, Kabupaten Bantul.</p>
    <p>Demikian surat ini dibuat agar dapat digunakan sebagaimana mestinya.</p>

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
