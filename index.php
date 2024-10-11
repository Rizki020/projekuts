<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card">
                    <div class="card-header text-center bg-info text-white">
                        <h2>Formulir Pendaftaran</h2>
                        <a href="login.php" class="btn btn-outline-light mt-2">Login Jika Telah Mendaftar</a>
                    </div>
                    <div class="card-body">
                        <!-- Gabungkan semua bagian dalam satu form -->
                        <form action="simpandata.php" method="post" enctype="multipart/form-data"
                            onsubmit="return validateForm();">
                            <!-- Informasi Pribadi -->
                            <div class="mb-4">
                                <div class="section-header">
                                    <h4>Informasi Pribadi</h4>
                                    <hr>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama Calon Mahasiswa Baru</label>
                                    <input type="text" name="nama" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <div class="form-row">
                                        <div class="col">
                                            <select name="tanggal_lahir_hari" class="form-control" required>
                                                <option value="" disabled selected>Pilih Tanggal</option>
                                                <?php for ($i = 1; $i <= 31; $i++)
                                                    echo "<option value='$i'>$i</option>"; ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select name="tanggal_lahir_bulan" class="form-control" required>
                                                <option value="" disabled selected>Pilih Bulan</option>
                                                <?php
                                                $bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                                                foreach ($bulan as $b) {
                                                    echo "<option value='$b'>$b</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select name="tanggal_lahir_tahun" class="form-control" required>
                                                <option value="" disabled selected>Pilih Tahun</option>
                                                <?php for ($i = 1998; $i <= 2020; $i++)
                                                    echo "<option value='$i'>$i</option>"; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label><br>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="jenis_kelamin" value="laki-laki"
                                            class="form-check-input" required>
                                        <label class="form-check-label">Laki-laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="jenis_kelamin" value="perempuan"
                                            class="form-check-input" required>
                                        <label class="form-check-label">Perempuan</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_orangtua">Nama Orang Tua</label>
                                    <input type="text" name="nama_orangtua" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Foto Calon Mahasiswa</label><br>
                                    <button type="button" class="btn btn-secondary mb-2" id="startCameraButton">Ambil
                                        Foto</button>
                                    <div id="cameraContainer" style="display:none;">
                                        <video id="video" width="320" height="240" autoplay class="mb-2"></video>
                                        <button type="button" class="btn btn-primary" id="snap">Ambil Foto</button>
                                        <button type="button" class="btn btn-danger" id="removeImage"
                                            style="display:none;">Hapus Gambar</button>
                                        <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
                                        <input type="hidden" name="gambar" id="gambarInput">
                                        <img id="takenImage" style="display:none; width: 320px; height: 240px;" />
                                    </div>
                                    <label for="uploadImage">Ambil Foto langsung disini</label>
                                    <input type="file" name="uploadImage" id="uploadImage" accept="image/*"
                                        class="form-control-file">
                                </div>
                            </div>

                            <!-- Sekolah -->
                            <div class="mb-4">
                                <div class="section-header">
                                    <h4>Sekolah</h4>
                                    <hr>
                                </div>
                                <div class="form-group">
                                    <label for="asal_sma">Asal SMA</label>
                                    <input type="text" name="asal_sma" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="tahun_tamat">Tahun Tamat</label>
                                    <input type="number" name="tahun_tamat" class="form-control" required>
                                </div>
                            </div>

                            <!-- Jurusan -->
                            <div class="mb-4">
                                <div class="section-header">
                                    <h4>Jurusan</h4>
                                    <hr>
                                </div>
                                <div class="form-group">
                                    <label for="jurusan">Jurusan</label>
                                    <select name="jurusan" class="form-control" required>
                                        <option value="" disabled selected>Pilih Jurusan</option>
                                        <option value="Teknik Komputer dan Informatika">Teknik Komputer dan Informatika
                                        </option>
                                        <option value="Teknik Sipil">Teknik Sipil</option>
                                        <option value="Administrasi Bisnis">Administrasi Bisnis</option>
                                        <option value="Teknik Mesin">Teknik Mesin</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="program_studi">Program Studi</label>
                                    <select name="program_studi" class="form-control" required>
                                        <option value="" disabled selected>Pilih Program Studi</option>
                                        <option value="Teknik Komputer">Teknik Komputer</option>
                                        <option value="Teknik Sipil">Teknik Sipil</option>
                                        <option value="Administrasi Bisnis">Administrasi Bisnis</option>
                                        <option value="Teknik Mesin">Teknik Mesin</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Daftar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="capture.js"></script>
</body>

</html>