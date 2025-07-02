<?php

$mysqli = new mysqli('localhost','root','','simkbs', 3305);

if (!$mysqli) {
echo 'Koneksi database gagal : ' . mysqli_connect_error();
}
