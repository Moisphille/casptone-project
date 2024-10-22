<?php
$host = 'localhost';    // Host MySQL
$user = 'root';         // Username MySQL
$password = '';         // Password MySQL (default kosong)
$dbname = 'login_system'; // Nama database yang baru dibuat

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} else {
    // echo "Koneksi berhasil!";
}
?>
