<?php
include '../koneksi.php';
include 'session.php';

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM raihan_menu WHERE id_menu=$id"));
if (file_exists("../gambar/".$data['gambar'])) {
    unlink("../gambar/".$data['gambar']);
}

mysqli_query($conn, "DELETE FROM raihan_detail_pesanan WHERE id_menu=$id");

mysqli_query($conn, "DELETE FROM raihan_menu WHERE id_menu=$id");

header("Location: kelola-menu.php");
?>
