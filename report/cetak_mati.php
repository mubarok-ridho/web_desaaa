<?php
session_start(); // WAJIB
include_once '../app/koneksi.php';
$koneksi = $mysqli;


if (isset($_POST['btnCetak'])) {
	$id = $_POST['id_meninggal']; // NIK
	$tglMeninggal = $_POST['tgl_meninggal'];
	$sebabMeninggal = $_POST['sebab_meninggal'];
}

$tanggal = date("m/y");
$tgl = date("d/m/y");
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>CETAK SURAT</title>
</head>

<body>
	<center>
		<h2>PEMERINTAH KABUPATEN BANTUL </h2>
		<h3>KECAMATAN KASIHAN <br>DESA TAMANTIRTO</h3>
		<p>________________________________________________________________________</p>

		<?php
		// ambil data warga sesuai NIK
		$sql_tampil = "SELECT * FROM tabel_kependudukan WHERE NIK='$id'";
		$query_tampil = mysqli_query($koneksi, $sql_tampil);
		while ($data = mysqli_fetch_array($query_tampil, MYSQLI_BOTH)) {
		?>
	</center>

	<center>
		<h4><u>SURAT KETERANGAN KEMATIAN</u></h4>
		<h4>No Surat : <?php echo $data['NIK']; ?>/Ket.Kematian/<?php echo $tanggal; ?></h4>
	</center>

	<p>Yang bertandatangan dibawah ini Kepala Desa Tamantirto, Kecamatan Kasihan, Kabupaten Bantul, dengan ini
		menerangkan bahwa :</p>

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
				<td>Tanggal Kematian</td>
				<td>:</td>
				<td><?php echo date("d-m-Y", strtotime($tglMeninggal)); ?></td>
			</tr>
			<tr>
				<td>Sebab</td>
				<td>:</td>
				<td><?php echo htmlspecialchars($sebabMeninggal); ?></td>
			</tr>
		</tbody>
	</table>

	<p>Benar-benar telah <b>Meninggal Dunia</b>, pada waktu yang telah disebutkan di atas.</p>
	<p>Demikian Surat ini dibuat, agar dapat digunakan sebagaimana mestinya.</p>

	<br><br><br><br><br>
	<p align="right">
		Bantul, <?php echo $tgl; ?><br>
		KEPALA DESA TAMANTIRTO
		<br><br><br><br><br><br>
		( WISNU ARDI )
	</p>

	<?php } ?>

	<script>
		window.print();
	</script>

</body>
</html>
