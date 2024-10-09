<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: loginadmin.php");
    exit;
}

// Koneksi ke database
include 'koneksi.php';

// Pastikan 'id' tersedia di parameter URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Menggunakan prepared statement untuk mencegah SQL Injection
    $sql = "DELETE FROM CALONMAHASISWA WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // 'i' untuk tipe data integer

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID tidak ditemukan.";
}

$conn->close();
?>
