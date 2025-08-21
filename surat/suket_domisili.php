<?php
session_start(); // <- WAJIB ADA!
include_once '../app/koneksi.php';
$koneksi = $mysqli;
?>

<div style="border:1px solid #007bff; border-radius:5px; padding:15px; max-width:750px; font-family:Arial, sans-serif; margin:auto; margin-top:20px;">
    <div style="background-color:#007bff; color:white; padding:10px; border-radius:3px; margin-bottom:15px;">
        <h3 style="margin:0; font-size:18px;">
            <i class="fa fa-file"></i> Surat Keterangan Domisili
        </h3>
    </div>

    <form action="../report/cetak_domisili.php" method="post" enctype="multipart/form-data">
        <div style="margin-bottom:15px;">
            <label style="display:inline-block; width:120px; font-weight:bold;">Penduduk</label>
            <select name="id_pend" id="id_pend" style="width:300px; padding:5px; border:1px solid #ccc; border-radius:3px;" required>
                <option selected="selected">- Pilih Data -</option>
                <?php
                $query = "SELECT NO_KK, NIK, NAMA_LGKP FROM tabel_kependudukan ORDER BY NAMA_LGKP ASC";
                $hasil = mysqli_query($koneksi, $query);
                while ($row = mysqli_fetch_assoc($hasil)) {
                ?>
                    <option value="<?php echo $row['NIK'] ?>">
                        <?php echo $row['NIK'] ?> - <?php echo $row['NAMA_LGKP'] ?>
                    </option>
                <?php
                }
                ?>
            </select>
        </div>

        <div>
            <button type="submit" class="btn" name="btnCetak" target="_blank"
                style="background-color:#17a2b8; color:white; border:none; padding:7px 20px; cursor:pointer; border-radius:3px; font-weight:bold;">
                Cetak Surat
            </button>
        </div>
    </form>
</div>
