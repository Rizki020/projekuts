<?php
session_start();
include 'koneksi.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Ambil id_user dari sesi
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

$data = $result->fetch_assoc(); // Ambil data lama

// Ambil data dari form
$nama = $_POST['nama'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$alamat = $_POST['alamat'];
$asal_sma = $_POST['asal_sma'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$tahun_tamat = $_POST['tahun_tamat'];
$nama_orangtua = $_POST['nama_orangtua'];
$jurusan = $_POST['jurusan'];
$program_studi = $_POST['program_studi'];
$password = $_POST['password']; // Password baru (jika ada)
$old_password = $_POST['old_password']; // Password lama

// Cek apakah ada gambar yang diunggah atau diambil dari kamera
$uploadImage = $_FILES['uploadImage'];
$gambarKamera = isset($_POST['gambar']) ? $_POST['gambar'] : "";

// Validasi apakah gambar diunggah atau diambil dari kamera
if (empty($gambarKamera) && $uploadImage['error'] === UPLOAD_ERR_NO_FILE) {
    // Tidak ada gambar dari kamera atau unggahan
    echo "<script>alert('Gambar harus diupload atau diambil dari kamera.'); window.history.back();</script>";
    exit(); // Hentikan eksekusi jika tidak ada gambar
}

// Validasi gambar dari kamera atau upload
if (empty($_POST['gambar']) && $uploadImage['error'] === UPLOAD_ERR_NO_FILE) {
    // Jika tidak ada gambar baru, gunakan gambar lama
    $gambar = $data['gambar']; // Pastikan gambar lama digunakan tanpa perubahan
} else {
    // Proses gambar dari kamera jika ada
    if (!empty($_POST['gambar'])) {
        $gambarData = $_POST['gambar'];
        $img = explode(',', $gambarData)[1]; // Ambil data base64
        $img = base64_decode($img);
        $filePath = generateNewImageName($nama, '.jpg', $conn); // Buat nama file baru

        // Cek apakah file berhasil disimpan
        if (file_put_contents($filePath, $img) === false) {
            echo "<script>alert('Gagal menyimpan gambar dari kamera.'); window.history.back();</script>";
            exit();
        }
        $gambar = 'images/' . basename($filePath); // Simpan path relatif
    } elseif ($uploadImage['error'] === UPLOAD_ERR_OK) {
        // Proses unggahan gambar
        $filePath = generateNewImageName($nama, '.' . pathinfo($uploadImage['name'], PATHINFO_EXTENSION), $conn);
        if (!move_uploaded_file($uploadImage['tmp_name'], $filePath)) {
            echo "<script>alert('Gagal menyimpan file yang diunggah.'); window.history.back();</script>";
            exit();
        }
        $gambar = 'images/' . basename($filePath);
    }
}

// Gunakan password baru jika diisi, jika tidak gunakan password lama
$newPassword = !empty($password) ? $password : $old_password; // Gunakan password baru jika diisi

// Update data calon mahasiswa di database
$update_sql = "UPDATE CALONMAHASISWA SET 
    gambar = ?, 
    nama = ?, 
    tempat_lahir = ?, 
    tanggal_lahir = ?, 
    alamat = ?, 
    asal_sma = ?, 
    jenis_kelamin = ?, 
    tahun_tamat = ?, 
    nama_orangtua = ?, 
    jurusan = ?, 
    program_studi = ?, 
    password = ? 
    WHERE id = ?";

$stmt = $conn->prepare($update_sql);
$stmt->bind_param(
    "sssssssssssss",
    $gambar,
    $nama,
    $tempat_lahir,
    $tanggal_lahir,
    $alamat,
    $asal_sma,
    $jenis_kelamin,
    $tahun_tamat,
    $nama_orangtua,
    $jurusan,
    $program_studi,
    $newPassword,
    $id_user
);

if ($stmt->execute()) {
    echo "<script>alert('Data berhasil diperbarui.'); window.location.href='dashboard1.php';</script>";
} else {
    echo "<script>alert('Terjadi kesalahan saat memperbarui data.'); window.history.back();</script>";
}

// Periksa apakah gambar lama ada dan tidak kosong
if (!empty($data['gambar']) && file_exists($data['gambar'])) {
    // Hapus gambar lama jika diperlukan
    // unlink($data['gambar']); // Uncomment jika ingin menghapus gambar lama
}

// Tutup koneksi
$stmt->close();
$conn->close();

// Fungsi untuk membuat nama file gambar baru
function generateNewImageName($baseName, $extension, $conn) {
    $i = 0;
    $newFileName = 'admin/images/' . $baseName . $extension;
    do {
        if ($i > 0) {
            $newFileName = 'admin/images/' . $baseName . $i . $extension;
        }
        $query = "SELECT * FROM CALONMAHASISWA WHERE gambar = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $newFileName);
        $stmt->execute();
        $result = $stmt->get_result();
        $i++;
    } while ($result->num_rows > 0);
    return $newFileName;
}
?>
