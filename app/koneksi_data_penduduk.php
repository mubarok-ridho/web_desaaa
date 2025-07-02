<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "data_penduduk";
$port = 3305;

$mysqli_data_penduduk = new mysqli($host, $user, $pass, $db, $port);

if ($mysqli_data_penduduk->connect_error) {
    die("Koneksi ke database data_penduduk gagal: " . $mysqli_data_penduduk->connect_error);
}
?>
