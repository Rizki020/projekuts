<?php
session_start();
include 'koneksi.php';

// Pastikan pengguna sudah login, jika tidak, arahkan ke login.php
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Ambil id_user dan password dari sesi
$id_user = $_SESSION['username'];


// Ambil data calon mahasiswa dari database
$sql = "SELECT * FROM CALONMAHASISWA WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id_user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Data tidak ditemukan.'); window.location.href='dashboard1.php';</script>";
    exit();
}

$data = $result->fetch_assoc();

// Simpan data ke variabel
$gambar = $data['gambar'];
$nama = $data['nama'];
$tempat_lahir = $data['tempat_lahir'];
$tanggal_lahir = $data['tanggal_lahir'];
$alamat = $data['alamat'];
$asal_sma = $data['asal_sma'];
$jenis_kelamin = $data['jenis_kelamin'];
$tahun_tamat = $data['tahun_tamat'];
$nama_orangtua = $data['nama_orangtua'];
$jurusan = $data['jurusan'];
$program_studi = $data['program_studi'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Calon Mahasiswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/stylesd.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div id="mySidebar" class="sidebar">
        <a href="dashboard1.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="editcalon.php"><i class="fas fa-user-graduate"></i> Informasi</a>
        <a href="logout1.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div id="main">
        <nav class="navbar navbar-expand navbar-dark">
            <button class="openbtn" id="sidebarToggle">☰</button>
            <h2 class="text-white ml-3">Selamat datang, <?= htmlspecialchars($nama); ?>!</h2>
        </nav>

        <div class="container mt-4">
        <div class="alert alert-info" role="alert">
            Kamu harus mengupload <strong>Gambar/Fotomu</strong> jika ingin mengedit atau gambarmu akan hilang, dan Pastikan kamu mengunduh gambar setelah memperbarui gambarmu!
            </div>
            <h3 class="text-center">Informasi mu</h3>
            <form action="editaksi.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                <div class="form-group">
                    <label>Foto Calon Mahasiswa</label><br>
                    <button type="button" class="btn btn-secondary mb-2" id="startCameraButton">Ambil Foto</button>
                    <div id="cameraContainer" style="display:none;">
                        <video id="video" width="320" height="240" autoplay class="mb-2"></video>
                        <button type="button" class="btn btn-primary" id="snap">Ambil Foto</button>
                        <button type="button" class="btn btn-danger" id="removeImage" style="display:none;">Hapus Gambar</button>
                        <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
                        <input type="hidden" name="gambar" id="gambarInput" value="<?= htmlspecialchars($gambar); ?>">
                        <img id="takenImage" style="display:none; width: 320px; height: 240px;" src="<?= htmlspecialchars($gambar); ?>" />
                    </div>
                    <label for="uploadImage" class="mt-2">Atau unggah foto dari file:</label>
                    <input type="file" name="uploadImage" id="uploadImage" accept="image/*" class="form-control-file">
                </div>
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($nama); ?>"
                        required>
                </div>
                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir:</label>
                    <input type="text" name="tempat_lahir" class="form-control"
                        value="<?= htmlspecialchars($tempat_lahir); ?>" required>
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir:</label>
                    <input type="date" name="tanggal_lahir" class="form-control"
                        value="<?= htmlspecialchars($tanggal_lahir); ?>" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <textarea name="alamat" class="form-control" required><?= htmlspecialchars($alamat); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="asal_sma">Asal SMA:</label>
                    <input type="text" name="asal_sma" class="form-control" value="<?= htmlspecialchars($asal_sma); ?>"
                        required>
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin:</label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="laki-laki" <?= $jenis_kelamin == 'laki-laki' ? 'selected' : ''; ?>>Laki-laki
                        </option>
                        <option value="perempuan" <?= $jenis_kelamin == 'perempuan' ? 'selected' : ''; ?>>Perempuan
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tahun_tamat">Tahun Tamat:</label>
                    <input type="number" name="tahun_tamat" class="form-control"
                        value="<?= htmlspecialchars($tahun_tamat); ?>" required>
                </div>
                <div class="form-group">
                    <label for="nama_orangtua">Nama Orang Tua:</label>
                    <input type="text" name="nama_orangtua" class="form-control"
                        value="<?= htmlspecialchars($nama_orangtua); ?>" required>
                </div>
                <div class="form-group">
                    <label for="jurusan">Jurusan:</label>
                    <select name="jurusan" class="form-control" required>
                        <option value="Teknik Komputer dan Informatika" <?= $jurusan == 'Teknik Komputer dan Informatika' ? 'selected' : ''; ?>>Teknik Komputer dan Informatika</option>
                        <option value="Administrasi Bisnis" <?= $jurusan == 'Administrasi Bisnis' ? 'selected' : ''; ?>>
                            Administrasi Bisnis</option>
                        <option value="Teknik Sipil" <?= $jurusan == 'Teknik Sipil' ? 'selected' : ''; ?>>Teknik Sipil
                        </option>
                        <option value="Teknik Mesin" <?= $jurusan == 'Teknik Mesin' ? 'selected' : ''; ?>>Teknik Mesin
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="program_studi">Program Studi:</label>
                    <select name="program_studi" class="form-control" required>
                        <option value="Teknik Komputer" <?= $program_studi == 'Teknik Komputer' ? 'selected' : ''; ?>>
                            Teknik Komputer</option>
                        <option value="Teknik Sipil" <?= $program_studi == 'Teknik Sipil' ? 'selected' : ''; ?>>Teknik
                            Sipil</option>
                        <option value="Administrasi Bisnis" <?= $program_studi == 'Administrasi Bisnis' ? 'selected' : ''; ?>>Administrasi Bisnis</option>
                        <option value="Teknik Mesin" <?= $program_studi == 'Teknik Mesin' ? 'selected' : ''; ?>>Teknik
                            Mesin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" class="form-control"
                        placeholder="Masukkan password baru (kosongkan jika tidak ingin mengganti)">
                    <input type="hidden" name="old_password" value="<?= htmlspecialchars($data['PASSWORD']); ?>">
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script1.js"></script>
</body>

</html>