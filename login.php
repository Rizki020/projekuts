<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $password = $_POST['password'];

    // Cek jika password diisi atau tidak
    if (empty($password)) {
        // Jika password tidak diisi, lakukan query untuk mengecek ID saja
        $sql = "SELECT * FROM CALONMAHASISWA WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
    } else {
        // Jika password diisi, lakukan query untuk mengecek ID dan password
        $sql = "SELECT * FROM CALONMAHASISWA WHERE id=? AND PASSWORD=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $id, $password); // Pastikan tipe data sesuai
    }
    
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $row['id']; // Simpan ID pengguna
        $_SESSION['nama'] = $row['nama']; // Simpan nama pengguna
        $_SESSION['PASSWORD'] = $row['password']; // Simpan password dari database


        header("Location: dashboard1.php");
        exit;
    } else {
        $error = "ID atau password salah.";
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
            <input type="text" name="id" class="input-control" placeholder="ID" required>
            <input type="password" name="password" class="input-control" placeholder="Password"></input>
            <button type="submit" class="btn-submit">Login</button>
            <?php if (isset($error)) echo "<p>$error</p>"; ?>
        </form>
    </div>
</body>
</html>
