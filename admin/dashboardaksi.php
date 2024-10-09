<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: loginadmin.php");
    exit;
}

// Koneksi ke database
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Aksi untuk menghapus calon mahasiswa
    if (isset($_POST['delete_selected'])) {
        if (isset($_POST['selected_ids']) && !empty($_POST['selected_ids'])) {
            $ids = $_POST['selected_ids']; // Ambil array ID yang terpilih

            // Menggunakan prepared statement untuk menghindari SQL Injection
            $id_placeholders = rtrim(str_repeat('?,', count($ids)), ','); // Membuat placeholder
            
            // Persiapkan query untuk menghapus dari CALONMAHASISWA
            $sql_delete_mahasiswa = "DELETE FROM CALONMAHASISWA WHERE id IN ($id_placeholders)";
            $stmt_delete_mahasiswa = $conn->prepare($sql_delete_mahasiswa);
            $stmt_delete_mahasiswa->bind_param(str_repeat('s', count($ids)), ...$ids); // Bind parameter sesuai dengan jumlah ID

            // Eksekusi penghapusan dari CALONMAHASISWA
            if ($stmt_delete_mahasiswa->execute()) {
                header("Location: dashboard.php");
                exit;
            } else {
                echo "<script>alert('Error deleting calon mahasiswa records: " . $stmt_delete_mahasiswa->error . "'); window.location.href='dashboard.php';</script>";
            }
        } else {
            echo "<script>alert('Tidak ada data yang dipilih untuk dihapus.'); window.location.href='dashboard.php';</script>";
        }
    }

    // Aksi untuk mengubah status
    if (isset($_POST['apply_status'])) {
        if (isset($_POST['selected_ids']) && !empty($_POST['selected_ids'])) {
            $ids = $_POST['selected_ids']; // Ambil array ID yang terpilih
            $status = $_POST['ubah_status']; // Ambil status yang dipilih

            // Menggunakan prepared statement untuk menghindari SQL Injection
            $id_placeholders = rtrim(str_repeat('?,', count($ids)), ','); // Membuat placeholder
            $sql_update = "UPDATE CALONMAHASISWA SET status = ? WHERE id IN ($id_placeholders)";

            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param('s' . str_repeat('s', count($ids)), $status, ...$ids); // Bind status dan ID

            if ($stmt_update->execute()) {
                header("Location: dashboard.php");
                exit;
            } else {
                echo "<script>alert('Error updating record: " . $stmt_update->error . "'); window.location.href='dashboard.php';</script>";
            }
        } else {
            echo "<script>alert('Tidak ada data yang dipilih untuk diubah statusnya.'); window.location.href='dashboard.php';</script>";
        }
    }
}

$conn->close();
?>
