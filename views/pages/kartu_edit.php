<?php
include_once __DIR__ . '/../../app/koneksi_data_penduduk.php';
$koneksi = $mysqli_data_penduduk;

if (isset($_GET['kode'])) {
  $id_kk = $_GET['kode'];
  $sql_cek = "SELECT * FROM tb_kk WHERE id_kk='$id_kk'";
  $query_cek = mysqli_query($koneksi, $sql_cek);
  $data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);
}
?>

<div class="card card-success mt-5">
  <div class="card-header">
    <h3 class="card-title">
      <i class="fa fa-edit"></i> Ubah Data KK
    </h3>
  </div>

  <form action="" method="post">
    <div class="card-body">
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">ID Sistem</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="id_kk" value="<?= $data_cek['id_kk'] ?>" readonly>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-2 col-form-label">No KK</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="no_kk" value="<?= $data_cek['no_kk'] ?>" required>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Kepala Keluarga</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="kepala" value="<?= $data_cek['kepala'] ?>" required>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Desa</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="desa" value="<?= $data_cek['desa'] ?>" required>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-2 col-form-label">RT / RW</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" name="rt" value="<?= $data_cek['rt'] ?>" required placeholder="RT">
        </div>
        <div class="col-sm-3">
          <input type="text" class="form-control" name="rw" value="<?= $data_cek['rw'] ?>" required placeholder="RW">
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Kecamatan</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="kec" value="<?= $data_cek['kec'] ?>" required>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Kabupaten</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="kab" value="<?= $data_cek['kab'] ?>" required>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Provinsi</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="prov" value="<?= $data_cek['prov'] ?>" required>
        </div>
      </div>
    </div>

    <div class="card-footer">
      <button type="submit" name="Ubah" class="btn btn-success">
        <i class="fa fa-save"></i> Simpan Perubahan
      </button>
      <a href="?page=data-kartu" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>

<?php
if (isset($_POST['Ubah'])) {
  $sql_ubah = "UPDATE tb_kk SET 
    no_kk = '" . $_POST['no_kk'] . "',
    kepala = '" . $_POST['kepala'] . "',
    desa = '" . $_POST['desa'] . "',
    rt = '" . $_POST['rt'] . "',
    rw = '" . $_POST['rw'] . "',
    kec = '" . $_POST['kec'] . "',
    kab = '" . $_POST['kab'] . "',
    prov = '" . $_POST['prov'] . "'
    WHERE id_kk = '" . $_POST['id_kk'] . "'";

  $query_ubah = mysqli_query($koneksi, $sql_ubah);
  mysqli_close($koneksi);

  if ($query_ubah) {
    echo "<script>
      Swal.fire({
        title: '✅ Data KK Berhasil Diubah!',
        text: 'Perubahan telah disimpan.',
        icon: 'success',
        showConfirmButton: true,
        confirmButtonText: 'Kembali'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location = 'data_kependudukan?tab=kk';
        }
      });
    </script>";
  } else {
    echo "<script>
      Swal.fire({
        title: '❌ Gagal Mengubah Data!',
        text: 'Periksa koneksi atau data input.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    </script>";
  }
}
?>
