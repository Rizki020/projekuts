<?php
session_start(); 

// Mengecek apakah admin sudah login, jika belum maka redirect ke halaman login
if (!isset($_SESSION['loggedin'])) {
    header("Location: loginadmin.php"); 
    exit; 
}

// Koneksi ke database
include 'koneksi.php'; 



// Mengambil jumlah total calon mahasiswa
$total_sql = "SELECT COUNT(*) AS total FROM CALONMAHASISWA";
$total_result = $conn->query($total_sql);
$total = $total_result->fetch_assoc()['total'];

// Mengambil jumlah calon mahasiswa yang berstatus 'Lulus'
$total_lulus_sql = "SELECT COUNT(*) AS total_lulus FROM CALONMAHASISWA WHERE status = 'Lulus'";
$total_lulus_result = $conn->query($total_lulus_sql);
$total_lulus = $total_lulus_result->fetch_assoc()['total_lulus'];

// Mengambil jumlah calon mahasiswa yang berstatus 'TidakLulus'
$total_tidak_lulus_sql = "SELECT COUNT(*) AS total_tidak_lulus FROM CALONMAHASISWA WHERE status = 'TidakLulus'";
$total_tidak_lulus_result = $conn->query($total_tidak_lulus_sql);
$total_tidak_lulus = $total_tidak_lulus_result->fetch_assoc()['total_tidak_lulus'];

// Mengambil jumlah calon mahasiswa yang berstatus 'Belum Ditentukan'
$total_belum_ditentukan_sql = "SELECT COUNT(*) AS total_belum_ditentukan FROM CALONMAHASISWA WHERE status = 'Belum Ditentukan'";
$total_belum_ditentukan_result = $conn->query($total_belum_ditentukan_sql);
$total_belum_ditentukan = $total_belum_ditentukan_result->fetch_assoc()['total_belum_ditentukan'];

// Menyimpan statistik ke dalam array
$statistics = [
    'total' => $total, // Total semua calon mahasiswa
    'total_lulus' => $total_lulus, // Total calon mahasiswa yang lulus
    'total_tidak_lulus' => $total_tidak_lulus, // Total calon mahasiswa yang tidak lulus
    'total_belum_ditentukan' => $total_belum_ditentukan, // Total calon mahasiswa yang statusnya belum ditentukan
];

// Menutup koneksi database
$conn->close();

// Menyimpan statistik ke dalam sesi agar bisa digunakan di halaman lain
$_SESSION['statistics'] = $statistics;


header("Location: statistik.php");
exit; 

?>
