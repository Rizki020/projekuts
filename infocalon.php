<?php
session_start();
include 'koneksi.php';

// Get the last inserted Nopendaftaran from session
if (isset($_SESSION['last_nopendaftaran'])) {
    $last_nopendaftaran = $_SESSION['last_nopendaftaran'];

    // Fetch the data for the last inserted record
    $query = "SELECT * FROM CALONMAHASISWA WHERE nopendaftaran = '$last_nopendaftaran'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
} else {
    echo "Tidak ada data baru.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Calon Mahasiswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/info.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-info text-white text-center">
                <h4>Informasi Calon Mahasiswa Baru</h4>
            </div>
            <div class="card-body text-center">
                <h5 class="card-title"><?= $row['nama']; ?></h5>
                
                <!-- Gambar mahasiswa -->
                <img src="admin/<?= $row['gambar']; ?>" class="img-fluid mb-3" alt="Foto Calon Mahasiswa" style="max-width: 200px;">
                
                <!-- Teks dan tombol unduh gambar -->
                <p><strong>Mohon untuk mengunduh gambar sebelum melanjutkan!</strong></p>
                <a href="admin/<?= $row['gambar']; ?>" class="btn btn-warning" download>Unduh Gambar</a>
                
                <!-- Data mahasiswa lainnya -->
                <p class="card-text text-left mt-3">
                    <strong>No Pendaftaran:</strong> <?=$row['nopendaftaran']; ?><br>
                    <strong>Tempat Lahir:</strong> <?= $row['tempat_lahir']; ?><br>
                    <strong>Tanggal Lahir:</strong> <?= $row['tanggal_lahir']; ?><br>
                    <strong>Alamat:</strong> <?= $row['alamat']; ?><br>
                    <strong>Asal SMA:</strong> <?= $row['asal_sma']; ?><br>
                    <strong>Jenis Kelamin:</strong> <?= $row['jenis_kelamin']; ?><br>
                    <strong>Tahun Tamat:</strong> <?= $row['tahun_tamat']; ?><br>
                    <strong>Nama Orang Tua:</strong> <?= $row['nama_orangtua']; ?><br>
                    <strong>Jurusan:</strong> <?= $row['jurusan']; ?><br>
                    <strong>Program Studi:</strong> <?= $row['program_studi']; ?><br>
                    <strong>Password:</strong> <?= $row['PASSWORD']; ?><br>
                </p>
                <p class="text-success"><strong>Anda telah menyelesaikan pendaftaran, mohon login untuk melanjutkan sesi Anda.</strong></p>
                <p class="text-danger"><strong>Mohon id dan password diingat!</strong></p>
                <a href="login.php" class="btn btn-primary mt-3">Login Sekarang</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
