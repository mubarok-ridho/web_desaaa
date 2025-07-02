<?php
session_start();

// Validasi: hanya blokir user biasa, bukan admin
if (isset($_SESSION['username']) && isset($_SESSION['level']) && $_SESSION['level'] == 'user') {
?>
    <script>
        alert('Anda sedang aktif, tidak dapat mengakses halaman ini!');
        window.location.href = 'dashboard';
    </script>
<?php
    return false;
}

$base_url = 'http://localhost/simkbs/';
include 'app/koneksi.php';

$sql_profil = "SELECT * FROM tabel_control WHERE id=1";
$result_profil = $mysqli->query($sql_profil);
$row_profil = $result_profil->fetch_object();

include 'views/layout/user/header.php';
include 'views/layout/user/navbar.php';
?>

<?php
// Routing halaman
if (isset($_GET['views_user']) && $_GET['views_user'] == "beranda") {
    include 'views/pages/user/beranda.php';

} else if (isset($_GET['views_user']) && $_GET['views_user'] == "list_data") {
    include 'views/pages/user/list_data.php';

} else if (isset($_GET['page']) && $_GET['page'] == "data_kependudukan") {
    include 'views/pages/data_kependudukan.php';

} else if (isset($_GET['page']) && $_GET['page'] == "add-kartu") {
    include 'views/pages/data_kartu_add.php';

} else if (isset($_GET['page']) && $_GET['page'] == "kartu-add") {
    include 'views/pages/kartu_add.php';
    
} else if (isset($_GET['page']) && $_GET['page'] == "kartu-edit") {
    include 'views/pages/kartu_edit.php';

} else if (isset($_GET['page']) && $_GET['page'] == "kartu-delete") {
    include 'views/pages/kartu_delete.php';

} else if (isset($_GET['page']) && $_GET['page'] == "anggota_kk") {
    include 'views\pages\data_kartu_anggota.php';

} else if (isset($_GET['page']) && $_GET['page'] == "del-kartu") {
    include 'views/pages/data_kartu_delete.php';

} else if (isset($_GET['page']) && $_GET['page'] == "add-kartu") {
    include 'views/pages/add_kartu copy.php';

} elseif (isset($_GET['page']) && $_GET['page'] == "deleteanggota") {
  include 'views/pages/deleteanggota.php';

} else {
    include 'views/pages/user/beranda.php';
}
?>

<?php include 'views/layout/user/footer.php'; ?>
