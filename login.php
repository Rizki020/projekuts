<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nopendaftaran = $_POST['nopendaftaran']; // Mengambil nopendaftaran dari input
    $password = $_POST['password'];

    // Cek jika password diisi atau tidak
    if (empty($password)) {
        // Jika password tidak diisi, lakukan query untuk mengecek nopendaftaran saja
        $sql = "SELECT * FROM CALONMAHASISWA WHERE nopendaftaran=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nopendaftaran); // Pastikan tipe data sesuai
    } else {
        // Jika password diisi, lakukan query untuk mengecek nopendaftaran dan password
        $sql = "SELECT * FROM CALONMAHASISWA WHERE nopendaftaran=? AND PASSWORD=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nopendaftaran, $password); // Pastikan tipe data sesuai
    }
    
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $row['nopendaftaran']; // Simpan nopendaftaran pengguna
        $_SESSION['nama'] = $row['nama']; // Simpan nama pengguna
        $_SESSION['PASSWORD'] = $row['password']; // Simpan password dari database

        header("Location: dashboard1.php");
        exit;
    } else {
        $error = "Nomor Pendaftaran atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
    <div class="box-formulir">
        <h2>Silahkan Login</h2>
        <form method="post">
            <input type="text" name="nopendaftaran" class="input-control" placeholder="Nomor Pendaftaran" required>
            <input type="password" name="password" class="input-control" placeholder="Password"></input>
            <button type="submit" class="btn-submit">Login</button>
            <?php if (isset($error)) echo "<p>$error</p>"; ?>
        </form>
        <p>Belum mendaftar? <a href="index.php">Daftar di sini</a></p>
    </div>
</body>
</html>
