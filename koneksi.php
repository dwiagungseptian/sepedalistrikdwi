<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "sepedalistrik";

// Koneksi ke database
$conn = mysqli_connect($host, $username, $password, $database);

// Periksa koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

?>
