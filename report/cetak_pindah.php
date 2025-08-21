<?php
session_start();
include "../app/koneksi.php"; // pastikan path sudah benar
$koneksi = $mysqli;

if (isset($_POST['btnCetak'])) {
    $id = $_POST['id_pend']; // NIK / id_pend
}

$tanggal = date("m/y");
$tgl = date("d/m/y");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>CETAK SURAT PINDAH</title>
</head>

<body>
    <center>
        <h2>PEMERINTAH KABUPATEN BANTUL</h2>
        <h3>KECAMATAN KASIHAN <br> DESA TAMANTIRTO</h3>
        <p>________________________________________________________________________</p>

        <?php
		    $nik = $_POST['id_pend']; // NIK sebagai identifier unik

    	$sql_tampil = "SELECT * FROM tabel_kependudukan WHERE NIK = '$nik'";
        $query_tampil = mysqli_query($koneksi, $sql_tampil);
        while ($data = mysqli_fetch_array($query_tampil, MYSQLI_BOTH)) {
        ?>
    </center>

    <center>
        <h4><u>SURAT KETERANGAN PINDAH</u></h4>
        <h4>No Surat : <?php echo $data['NIK']; ?>/Ket.Pindah/<?php echo $tanggal; ?></h4>
    </center>

    <p>Yang bertandatangan di bawah ini Kepala Desa Tamantirto, Kecamatan Kasihan, Kabupaten Bantul,
        dengan ini menerangkan bahwa:</p>

    <table>
        <tbody>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td><?php echo $data['NIK']; ?></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?php echo $data['NAMA_LGKP']; ?></td>
            </tr>
            <tr>
                <td>Tempat/Tanggal Lahir</td>
                <td>:</td>
                <td><?php echo $data['TMPT_LHR']; ?> / <?php echo date("d-m-Y", strtotime($data['TGL_LHR'])); ?></td>
            </tr>
        </tbody>
    </table>

    <p>Benar-benar telah <b>Pindah</b> dari Desa Tamantirto, Kecamatan Kasihan, Kabupaten Bantul.</p>
    <p>Demikian surat ini dibuat untuk dipergunakan sebagaimana mestinya.</p>

    <br><br><br>
    <p align="right">
        Bantul, <?php echo $tgl; ?><br>
        KEPALA DESA TAMANTIRTO
        <br><br><br><br><br>
        ( WISNU ARDI )
    </p>

    <?php } ?>

    <script>
        window.print();
    </script>

</body>

</html>
