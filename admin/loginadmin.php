<?php
session_start(); // Memulai sesi untuk menyimpan data pengguna sementara, seperti login

include 'koneksi.php';

// Mengecek apakah request yang diterima adalah POST (form telah disubmit)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil nilai dari input pengguna
    $username = $_POST['username']; // Mengambil nilai username dari form
    $password = $_POST['password']; // Mengambil nilai password dari form

    // Mengecek username dan password dengan database
    $sql = "SELECT * FROM ADMIN WHERE USERNAME=? AND PASSWORD=?"; // Membuat query untuk memeriksa username dan password
    $stmt = $conn->prepare($sql); // Mempersiapkan query
    $stmt->bind_param("ss", $username, $password); // Mengikat parameter (username dan password)
    $stmt->execute(); // Menjalankan query
    $result = $stmt->get_result(); // Mengambil hasil dari query

    if ($result->num_rows > 0) {
        // Jika ada data yang cocok, berarti login berhasil

        // Ambil data admin dari hasil query
        $row = $result->fetch_assoc();

        // Set session untuk menandakan bahwa admin sudah login
        $_SESSION['loggedin'] = true;
        $_SESSION['NAMA'] = $row['NAMA']; // Menyimpan nama admin ke dalam sesi

        // Mengarahkan ke halaman statistik.php setelah berhasil login
        header("Location: statistik.php");
        exit; // Menghentikan eksekusi lebih lanjut setelah redirect
    } else {
        // Jika username atau password salah, beri pesan error
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
</head>

<body>
    <div class="box-formulir">
        <h2>Login Sebagai Admin</h2>
        <form method="post">
            <input type="text" name="username" class="input-control" placeholder="Username" required>
            <input type="password" name="password" class="input-control" placeholder="Password" required>
            <button type="submit" class="btn-submit">Login</button>
            <?php if (isset($error))
                echo "<p>$error</p>"; ?> <!-- Menampilkan pesan error jika login gagal -->
        </form>
    </div>
</body>

</html>