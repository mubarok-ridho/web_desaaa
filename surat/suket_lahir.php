<?php
session_start(); // WAJIB
include_once '../app/koneksi.php';
$koneksi = $mysqli;
?>

<div style="border:1px solid #007bff; border-radius:8px; padding:18px; max-width:760px; font-family:Arial, sans-serif; margin:24px auto;">
    <!-- Header -->
    <div style="background:#007bff; color:#fff; padding:12px 14px; border-radius:6px; margin-bottom:16px; display:flex; align-items:center; gap:10px;">
        <span style="display:inline-flex; width:22px; height:22px; align-items:center; justify-content:center;">📄</span>
        <h3 style="margin:0; font-size:18px; font-weight:700;">Surat Keterangan Kelahiran</h3>
    </div>

    <form action="../report/cetak_lahir.php" method="post" enctype="multipart/form-data" style="display:block;">
        <!-- Baris: pilih data kelahiran -->
        <div style="margin-bottom:14px; display:flex; align-items:center;">
            <label for="id_lahir" style="width:160px; font-weight:bold;">Nama Bayi</label>
            <select name="id_lahir" id="id_lahir"
                    style="flex:1; max-width:360px; padding:8px 10px; border:1px solid #cfd5e1; border-radius:6px; outline:none;"
                    required>
                <option value="" selected>- Pilih Data -</option>
                <?php
                $query = "SELECT NIK, NAMA_LGKP, TGL_LHR FROM tabel_kependudukan ORDER BY NAMA_LGKP ASC";
                $hasil = mysqli_query($koneksi, $query);
                while ($row = mysqli_fetch_assoc($hasil)) {
                    ?>
                    <option value="<?php echo htmlspecialchars($row['NIK']); ?>">
                        <?php echo htmlspecialchars($row['NAMA_LGKP']); ?> (<?php echo date('d-m-Y', strtotime($row['TGL_LHR'])); ?>)
                    </option>
                    <?php
                }
                ?>
            </select>
        </div>

        <!-- Footer tombol -->
        <div style="display:flex; justify-content:flex-start; gap:10px; margin-left:160px;">
            <button type="submit" name="btnCetak"
                    style="background:#17a2b8; color:white; border:none; padding:9px 18px; border-radius:6px; font-weight:600; cursor:pointer;">
                Cetak Surat
            </button>
            <button type="reset"
                    style="background:#eef2f7; color:#111827; border:1px solid #cfd5e1; padding:9px 14px; border-radius:6px; cursor:pointer;">
                Reset
            </button>
        </div>
    </form>
</div>
