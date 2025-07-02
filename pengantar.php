<?php
  $base_url = 'http://localhost/simkbs/';
  include 'app/koneksi.php';

  $sql_profil = "SELECT * FROM tabel_control WHERE id=1";
  $result_profil = $mysqli->query($sql_profil);
  $row_profil = $result_profil->fetch_object();
  include 'views/layout/user/header.php';
?>

<header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

        <div class="logo">
            <h1 class="text-light">
                <a href="beranda">
                    <img src="<?= $base_url; ?>asset_user/img/logo-putih.png" alt="logo">
                    <small>DESA KALIPUTIH</small>
                </a>
            </h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
        </div>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto" href="beranda">Beranda</a></li>
                <li><a class="nav-link scrollto active" href="administrasi">Layanan Administrasi</a></li>
                <li><a class="nav-link scrollto" href="beranda">Bansos</a></li>
                <li class="dropdown"><a href="#"><span>Kependudukan</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="beranda">Demografi Penduduk</a></li>
                        <li><a href="beranda">Pendidikan</a></li>
                        <li><a href="beranda">Pekerjaan</a></li>
                        <li><a href="beranda">Kelompok Umur</a></li>
                        <li><a href="beranda">Agama</a></li>
                        <li><a href="beranda">Dusun</a></li>
                    </ul>

                <li class="dropdown"><a href="#"><span>Kelola Surat</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="domisili">Surat Domisili</a></li>
                        <li><a href="kelahiran">Surat Kelahiran</a></li>
                        <li><a href="kematian">Surat Kematiah</a></li>
                        <li><a href="pendatang">Surat Pendatang</a></li>
                        <li><a href="pindah">Surat Pindah</a></li>
                        <li><a href="pengantar">Surat Pengantar</a></li>
                    </ul>
                </li>
                <li><a class="nav-link scrollto" href="beranda">Kontak</a></li>
                <li><a class="getstarted scrollto" href="login">Login</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->

<main id="main">
    <div class="pt-3" style="min-height: 629px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="text-center">
                    <img src="<?= $base_url; ?>asset_user/img/logo-campur.png" alt="logo" width="5%">
                    <h4>Form Surat Pengantar</h4>
                    <!-- pencarian -->
                </div>
            </div>

            <section class="content">
                <form action="cetak_administrasi" method="POST">
                    <a href="beranda" class="btn text-light" style="background-color: #042165;"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>

                    <div class="card mt-3">
                        <div class="card-header" style="background-color: #042165;">
                            <h3 class="card-title text-white">Pengajuan Surat Pengantar</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Nama Lengkap</label>
                                        <input type="text" name="nama" class="form-control" id="" placeholder="Masukkan Nama Lengkap">
                                    </div>
                                    <div class="form-group">
                                        <label for="">NIK</label>
                                        <input type="number" name="nik" class="form-control" id="" placeholder="Masukkan NIK">
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <select class="form-control select2" name="jk" style="width: 100%;">
                                            <option hidden>--Pilih Jenis Kelamin--</option>
                                            <option value="Laki-Laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tempat, Tanggal Lahir</label>
                                        <input type="text" name="ttl" class="form-control" id="" placeholder="Masukkan Tempat Tanggal Lahir">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Pekerjaan</label>
                                        <input type="text" name="pekerjaan" class="form-control" id="" placeholder="Masukkan Pekerjaan">
                                    </div>
                                    <div class="form-group">
                                        <label for="">alamat</label>
                                        <input type="text" name="alamat" class="form-control" id="" placeholder="Masukkan Alamat">
                                    </div>
                                    <div class="form-group">
                                        <label>Agama</label>
                                        <select class="form-control select2" name="agama" style="width: 100%;">
                                            <option hidden>--Pilih Agama--</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Kristen">Kristen</option>
                                            <option value="Katolik">Katolik</option>
                                            <option value="Budha">Budha</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Khonghucu">Khonghucu</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Status Perkawinan</label>
                                        <select class="form-control select2" name="status_perkawinan" style="width: 100%;">
                                            <option hidden>--Pilih Status Perkawinan--</option>
                                            <option value="Belum kKawin">Belum Kawin</option>
                                            <option value="Kawin">Kawin</option>
                                            <option value="Cerai Hidup">Cerai Hidup</option>
                                            <option value="Cerai Mati">Cerai Mati</option>
                                        </select>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Usaha Sekarang</label>
                                        <input type="text" name="usaha_sekarang" class="form-control" id="" placeholder="Masukkan Usaha Sekarang">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Waktu Usaha</label>
                                        <input type="text" name="waktu_usaha" class="form-control" id="" placeholder="Masukkan Waktu Usaha">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Luas Usaha</label>
                                        <input type="text" name="luas_usaha" class="form-control" id="" placeholder="Masukkan Luas Usaha">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Alamat Usaha</label>
                                        <input type="text" name="alamat_usaha" class="form-control" id="" placeholder="Masukkan Alamat Usaha">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <button type="submit" name="cetak_data_domisili" class="btn btn-block btn-success float-right"><i class="fas fa-save"></i> Cetak</button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</main>

<?php

?>