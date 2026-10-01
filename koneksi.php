<?php
$host = "localhost";
$user = "root";
$pass = "root"; // Kosongkan bagian ini untuk Laragon
$db   = "db_rumahsakit";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>