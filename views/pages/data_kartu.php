<?php 
// koneksi ke database KK (dari Data-Kependudukan)
include 'koneksi_data_penduduk.php'; 
?>

<div class="card card-info">
	<div class="card-header">
		<h3 class="card-title">
			<i class="fa fa-table"></i> Data KK
		</h3>
	</div>

	<div class="card-body">
		<div class="table-responsive">
			<div class="mb-3">
				<a href="index.php?page=add-kartu" class="btn btn-primary">
					<i class="fa fa-edit"></i> Tambah Data
				</a>
			</div>

			<table id="example1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>No KK</th>
						<th>Kepala Keluarga</th>
						<th>Alamat</th>
						<th>Anggota KK</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
					$sql = $koneksi->query("SELECT * FROM tb_kk");
					while ($data = $sql->fetch_assoc()) {
					?>
						<tr>
							<td><?= $no++; ?></td>
							<td><?= $data['no_kk']; ?></td>
							<td><?= $data['kepala']; ?></td>
							<td><?= $data['desa']; ?> RT <?= $data['rt']; ?>/ RW <?= $data['rw']; ?></td>
							<td>
								<a href="index.php?page=anggota&kode=<?= $data['id_kk']; ?>" class="btn btn-info btn-sm" title="Anggota KK">
									<i class="fa fa-users"></i>
								</a>
							</td>
							<td>
								<a href="index.php?page=edit-kartu&kode=<?= $data['id_kk']; ?>" class="btn btn-success btn-sm" title="Ubah">
									<i class="fa fa-edit"></i>
								</a>
								<a href="index.php?page=del-kartu&kode=<?= $data['id_kk']; ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Apakah anda yakin hapus data ini ?')">
									<i class="fa fa-trash"></i>
								</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>

		</div>
	</div>
</div>
