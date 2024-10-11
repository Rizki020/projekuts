<?php
session_start(); // Memulai sesi
if (!isset($_SESSION['loggedin'])) {
    // Jika sesi belum terisi (belum login), maka redirect ke halaman login
    header("Location: loginadmin.php");
    exit;
}

// Koneksi ke database
include 'koneksi.php';

// Ambil kata kunci pencarian dan filter status dari input pengguna
$search = isset($_POST['search']) ? $_POST['search'] : ''; // Mengambil kata kunci pencarian
$status_filter = isset($_POST['status_filter']) ? $_POST['status_filter'] : ''; // Mengambil filter status

// Pengaturan pagination
$records_per_page = 6; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Mengambil data calon mahasiswa dengan pagination dan pencarian
$search_param = '%' . $search . '%'; // Mengatur parameter pencarian dengan wildcard
$sql = "SELECT * FROM CALONMAHASISWA WHERE (nama LIKE ? OR tempat_lahir LIKE ?)";
$params = [$search_param, $search_param];
// Menambahkan filter status jika ada
if ($status_filter !== '') {
    $sql .= " AND status = ?";
    $params[] = $status_filter;
}

// Menambahkan limit dan offset untuk pagination
$sql .= " LIMIT ? OFFSET ?";
$params[] = $records_per_page;
$params[] = $offset;

// Mempersiapkan statement SQL dan mengikat parameter
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($params) - 2) . 'ii', ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Mengambil total data untuk menghitung total halaman
$total_records_sql = "SELECT COUNT(*) AS total FROM CALONMAHASISWA WHERE (nama LIKE ? OR tempat_lahir LIKE ?)";
$total_params = [$search_param, $search_param];

// Menambahkan filter status jika ada
if ($status_filter !== '') {
    $total_records_sql .= " AND status = ?";
    $total_params[] = $status_filter;
}

// Mempersiapkan statement SQL untuk total data dan mengikat parameter
$total_stmt = $conn->prepare($total_records_sql);
$total_stmt->bind_param(str_repeat('s', count($total_params)), ...$total_params);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total']; // Total jumlah data
$total_pages = ceil($total_records / $records_per_page); // Menghitung jumlah halaman
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <!-- Menyertakan stylesheet Bootstrap dan CSS kustom -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="dashboardstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>

<body>
    <!-- Sidebar untuk navigasi -->
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="statistik.php"><i class="fas fa-tachometer-alt"></i> Statistik Calon Mahasiswa</a>
        <a href="dashboard.php"><i class="fas fa-info-circle"></i> Daftar Calon Mahasiswa</a>
        <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Wrapper untuk bagian konten utama -->
    <div class="wrapper">
        <div class="container mt-5">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="mx-auto">Data Calon Mahasiswa</h2>
                    <!-- Form Pencarian dan Filter Status -->
                    <form method="POST" class="form-inline ml-3">
                        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama..."
                            value="<?php echo htmlspecialchars($search); ?>"> <!-- Input pencarian -->
                        <select name="status_filter" class="form-control ml-2"> <!-- Dropdown filter status -->
                            <option value="">Semua Status</option>
                            <option value="Lulus" <?php echo $status_filter === 'Lulus' ? 'selected' : ''; ?>>Lulus
                            </option>
                            <option value="TidakLulus" <?php echo $status_filter === 'TidakLulus' ? 'selected' : ''; ?>>
                                Tidak Lulus</option>
                            <option value="Belum Ditentukan" <?php echo $status_filter === 'Belum Ditentukan' ? 'selected' : ''; ?>>Belum Ditentukan</option>
                        </select>
                        <!-- Tombol cari -->
                        <button type="submit" class="btn btn-primary ml-2">Cari</button>
                    </form>
                </div>
                <div class="card-body">
                    <form id="form-data" method="post" action="dashboardaksi.php">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <!-- Checkbox untuk memilih semua -->
                                        <td><input type='checkbox' id="select-all"></td>
                                        <th>ID</th>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>Tempat Lahir</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Alamat</th>
                                        <th>Asal SMA</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tahun Tamat</th>
                                        <th>Nama Orang Tua</th>
                                        <th>Jurusan</th>
                                        <th>Program Studi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        // Menampilkan data calon mahasiswa
                                        while ($row = $result->fetch_assoc()) {
                                            // Menentukan tampilan button berdasarkan status
                                            $status_button = '';
                                            if ($row['status'] == 'Lulus') {
                                                $status_button = "<button class='btn btn-success'>Lulus</button>";
                                            } elseif ($row['status'] == 'TidakLulus') {
                                                $status_button = "<button class='btn btn-danger'>Tidak Lulus</button>";
                                            } else {
                                                $status_button = "<button class='btn btn-secondary'>Belum Ditentukan</button>";
                                            }

                                            // Menampilkan baris data dalam tabel
                                            echo "<tr>
                                                <td><input type='checkbox' name='selected_ids[]' value='{$row['nopendaftaran']}'></td>
                                                <td>{$row['nopendaftaran']}</td>
                                                <td><img src='" . htmlspecialchars($row['gambar']) . "' width='150' /></td>
                                                <td>{$row['nama']}</td>
                                                <td>{$row['tempat_lahir']}</td>
                                                <td>{$row['tanggal_lahir']}</td>
                                                <td>{$row['alamat']}</td>
                                                <td>{$row['asal_sma']}</td>
                                                <td>{$row['jenis_kelamin']}</td>
                                                <td>{$row['tahun_tamat']}</td>
                                                <td>{$row['nama_orangtua']}</td>
                                                <td>{$row['jurusan']}</td>
                                                <td>{$row['program_studi']}</td>
                                                <td>{$status_button}</td> 
                                            </tr>";
                                        }
                                    } else {
                                        // Jika tidak ada data
                                        echo "<tr><td colspan='14' class='text-center'>Tidak ada data.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Bagian Aksi untuk mengubah status dan menghapus -->
                        <div class="actions d-flex justify-content-end mt-3">
                            <select name="ubah_status" class="form-control w-auto">
                                <option value="Lulus">Lulus</option>
                                <option value="TidakLulus">Tidak Lulus</option>
                                <option value="Belum Ditentukan">Belum Ditentukan</option>
                            </select>
                            <button type="submit" class="btn btn-primary ml-2" name="apply_status">Terapkan</button>
                            <button type="submit" name="delete_selected" class="btn btn-danger ml-2"
                                onclick="return confirmDelete()">Hapus</button>
                        </div>
                        <script>
                            function confirmDelete() {
                                // Konfirmasi untuk penghapusan data
                                return confirm("Apakah Anda yakin ingin menghapus kolom ini?");
                            }
                        </script>
                    </form>
                </div>

                <!-- Navigation untuk pagination -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="dashboard.php?page=<?php echo $page - 1; ?>"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php if ($i == $page)
                                echo 'active'; ?>">
                                <a class="page-link" href="dashboard.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="dashboard.php?page=<?php echo $page + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>

</html>

<?php
$conn->close();
?>