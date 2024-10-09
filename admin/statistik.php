<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: loginadmin.php");
    exit;
}

// Pastikan statistik sudah dihitung sebelum melanjutkan
if (!isset($_SESSION['statistics'])) {
    header("Location: statistikaksi.php");
    exit;
}

// Ambil statistik dari sesi
$statistics = $_SESSION['statistics'];

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Statistik Calon Mahasiswa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="dashboardstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>

<body>
    <div class="sidebar">
        <h2>Halo, <?php echo htmlspecialchars($_SESSION['NAMA']); ?>!</h2>
        <a href="statistik.php"><i class="fas fa-tachometer-alt"></i> Statistik Calon Mahasiswa</a>
        <a href="dashboard.php"><i class="fas fa-info-circle"></i> Daftar Calon Mahasiswa</a>
        <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="wrapper">
        <div class="container mt-5">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Calon Mahasiswa</h5>
                            <p class="card-text text-white"><?php echo $statistics['total']; ?> Orang</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Lulus</h5>
                            <p class="card-text text-white"><?php echo $statistics['total_lulus']; ?> Orang</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Belum Ditentukan</h5>
                            <p class="card-text text-white"><?php echo $statistics['total_belum_ditentukan']; ?> Orang
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-danger mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Yang Gagal</h5>
                            <p class="card-text text-white" style="color: white;">
                                <?php echo $statistics['total_tidak_lulus']; ?> Orang</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>

</html>

<?php
// Hapus data statistik dari sesi jika tidak lagi dibutuhkan
unset($_SESSION['statistics']);
?>