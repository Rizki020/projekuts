<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Ambil nama dan id dari sesi
$nama = $_SESSION['nama'];
$id_user = $_SESSION['username']; // Mengambil ID pengguna dari sesi

// Debugging: tampilkan ID pengguna
echo "ID Pengguna: " . htmlspecialchars($id_user) . "<br>"; // Debugging ID

// Query untuk mengambil data calon mahasiswa berdasarkan ID pengguna
$sql = "SELECT * FROM CALONMAHASISWA WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id_user); // Pastikan tipe data sesuai
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
            Kamu dapat mengubah informasi mu di halaman <strong>Informasi</strong> pada bagian navigasi hingga waktu yang ditentukan.
            </div>

            <h3 class="text-center">Data Calon Mahasiswa</h3>
            <div class="row justify-content-center">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="col-md-4 mb-4">
                            <div class="info-box">
                                <img src="admin/<?= $row['gambar']; ?>" class="img-fluid mb-3" alt="Foto Calon Mahasiswa" style="max-width: 200px;">
                                <h5 class="card-title">Id Pengguna: <?= htmlspecialchars($row['id']); ?></h5>
                                <div class="info-row">
                                    <span><strong>Nama:</strong> <?= htmlspecialchars($row['nama']); ?></span>
                                </div>
                                <div class="info-row">
                                    <span><strong>Tempat Lahir:</strong> <?= htmlspecialchars($row['tempat_lahir']); ?></span>
                                </div>
                                <div class="info-row">
                                    <span><strong>Tanggal Lahir:</strong> <?= htmlspecialchars($row['tanggal_lahir']); ?></span>
                                </div>
                                <div class="info-row">
                                    <span><strong>Alamat:</strong> <?= htmlspecialchars($row['alamat']); ?></span>
                                </div>
                                <div class="info-row">
                                    <span><strong>Asal SMA:</strong> <?= htmlspecialchars($row['asal_sma']); ?></span>
                                </div>
                                <div class="info-row">
                                    <span><strong>Jenis Kelamin:</strong> <?= htmlspecialchars($row['jenis_kelamin']); ?></span>
                                </div>
                                <div class="info-row">
                                    <span><strong>Tahun Tamat:</strong> <?= htmlspecialchars($row['tahun_tamat']); ?></span>
                                </div>
                                <div class="info-row">
                                    <span><strong>Jurusan:</strong> <?= htmlspecialchars($row['jurusan']); ?></span>
                                </div>
                                <div class="info-row">
                                    <span><strong>Program Studi:</strong> <?= htmlspecialchars($row['program_studi']); ?></span>
                                </div>
                                <div class="info-row">
                                    <span><strong>Status:</strong> <?= htmlspecialchars($row['status']); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Tidak ada data calon mahasiswa yang ditemukan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script1.js"></script>
</body>
</html>
