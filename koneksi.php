<?php
$host = 'localhost'; 
$db = 'dbpendaftaran'; 
$user = 'root';
$pass = ''; 

// Koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>