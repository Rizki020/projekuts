<?php
session_start();
include 'koneksi.php';

// Mengambil data dari form
$nama = $_POST['nama'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir_hari = $_POST['tanggal_lahir_hari'];
$tanggal_lahir_bulan = $_POST['tanggal_lahir_bulan'];
$tanggal_lahir_tahun = $_POST['tanggal_lahir_tahun'];
$alamat = $_POST['alamat'];
$asal_sma = $_POST['asal_sma'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$tahun_tamat = $_POST['tahun_tamat'];
$nama_orangtua = $_POST['nama_orangtua'];
$jurusan = $_POST['jurusan'];
$program_studi = $_POST['program_studi'];

// Mengubah nama bulan menjadi angka
$bulan_angka = [
    "Januari" => "01",
    "Februari" => "02",
    "Maret" => "03",
    "April" => "04",
    "Mei" => "05",
    "Juni" => "06",
    "Juli" => "07",
    "Agustus" => "08",
    "September" => "09",
    "Oktober" => "10",
    "November" => "11",
    "Desember" => "12"
];
$bulan_numerik = $bulan_angka[$tanggal_lahir_bulan];

// Menggabungkan menjadi format YYYY-MM-DD
$tanggal_lahir = "$tanggal_lahir_tahun-$bulan_numerik-$tanggal_lahir_hari";

// Inisialisasi variabel gambar
$gambar = '';

// Menyimpan file yang di-upload dari form
if (isset($_FILES['uploadImage']) && $_FILES['uploadImage']['error'] == 0) {
    $target_dir = "admin/images/";
    $target_file = $target_dir . basename($_FILES["uploadImage"]["name"]);

    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($imageFileType, $allowedTypes)) {
        echo "<script>alert('Hanya file .jpg, .jpeg, .png, dan .gif yang diperbolehkan.'); window.history.back();</script>";
        exit;
    }

    if (move_uploaded_file($_FILES["uploadImage"]["tmp_name"], $target_file)) {
        $gambar = "images/" . basename($_FILES["uploadImage"]["name"]);
    } else {
        echo "<script>alert('Terjadi kesalahan saat meng-upload file.'); window.history.back();</script>";
        exit;
    }
}

// Jika tidak ada gambar dari upload, periksa gambar dari webcam
if (empty($gambar) && !empty($_POST['gambar'])) {
    $data = $_POST['gambar'];
    list($type, $data) = explode(';', $data);
    list(, $data) = explode(',', $data);
    $data = base64_decode($data);

    $gambar_nama = preg_replace('/\s+/', '_', strtolower($nama));
    $file_name = 'admin/images/' . $gambar_nama . '.jpg';

    if (file_put_contents($file_name, $data) !== false) {
        $gambar = "images/" . $gambar_nama . '.jpg';
    } else {
        echo "<script>alert('Gambar tidak dapat disimpan.'); window.history.back();</script>";
        exit;
    }
}

if (empty($gambar)) {
    echo "<script>alert('Data gambar kosong. Pastikan Anda mengupload gambar.'); window.history.back();</script>";
    exit;
}

// Mengambil ID terakhir dari tabel
$result = mysqli_query($conn, "SELECT id FROM CALONMAHASISWA ORDER BY id DESC LIMIT 1");
$row = mysqli_fetch_assoc($result);

// Jika ada ID sebelumnya, lanjutkan dari sana, jika tidak mulai dari 2024001
if ($row) {
    $last_id = (int)$row['id'];
    $new_id = $last_id + 1;
} else {
    $new_id = 2024001; // Memulai dari 2024001
}

// Melakukan penyimpanan ke database
$insert = mysqli_query($conn, "INSERT INTO CALONMAHASISWA (id, gambar, nama, tempat_lahir, tanggal_lahir, alamat, asal_sma, jenis_kelamin, tahun_tamat, nama_orangtua, jurusan, program_studi) VALUES ('$new_id', '$gambar', '$nama', '$tempat_lahir', '$tanggal_lahir', '$alamat', '$asal_sma', '$jenis_kelamin', '$tahun_tamat', '$nama_orangtua', '$jurusan', '$program_studi')");

if ($insert) {
    echo "<script>alert('Berhasil mendaftar!'); window.location.href='index.php';</script>";
} else {
    echo "<script>alert('Data gagal disimpan.'); window.history.back();</script>";
}
?>
