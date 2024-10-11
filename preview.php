<?php
include 'koneksi.php';

// Inisialisasi variabel pencarian
$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

// Mengambil data mahasiswa dengan filter pencarian
$sql = "SELECT * FROM CALONMAHASISWA WHERE nama LIKE '%$search%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Mahasiswa</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <section class="box-formulir">
        <h2>Status Mahasiswa</h2>

        <form method="POST" style="display: flex; justify-content: center; margin-bottom: 20px;">
            <input type="text" name="search" placeholder="Cari Nama Mahasiswa..."
                value="<?php echo htmlspecialchars($search); ?>" class="input-controlpencarian" required>
            <button type="submit" class="btn-submitpencarian">Cari</button>
        </form>

        <table class="table-form">
            <tr>
                <th>Nama</th>
                <th>Status</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $status = !empty($row['status']) ? $row['status'] : "Belum Ditentukan"; // Menetapkan status
                    
                    // Menentukan warna tombol berdasarkan status
                    $status_button = '';
                    if ($status == 'Lulus') {
                        $status_button = "<button style='background-color: green; color: white;'>Lulus</button>";
                    } elseif ($status == 'TidakLulus') {
                        $status_button = "<button style='background-color: red; color: white;'>Tidak Lulus</button>";
                    } else {
                        $status_button = "<button style='background-color: gray; color: white;'>Belum Ditentukan</button>";
                    }

                    echo "<tr>
                    <td>{$row['nama']}</td>
                    <td>{$status_button}</td>
                  </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>Tidak ada data.</td></tr>";
            }
            ?>
        </table>
    </section>
</body>

</html>

<?php
$conn->close();
?>
