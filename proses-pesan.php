<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id_menu = $_POST['id_menu'];
  $nama    = $_POST['nama'];
  $telepon = $_POST['telepon'];
  $alamat  = $_POST['alamat'];
  $tanggal = $_POST['tanggal'];
  $jumlah  = $_POST['jumlah'];
  $harga   = $_POST['harga'];
  $total   = $harga * $jumlah;

  $now = date('Y-m-d H:i:s'); 

  $insertPesanan = mysqli_query($conn, "INSERT INTO raihan_pesanan 
  (nama_pelanggan, telepon, alamat_pengantaran, tanggal_ambil, total_harga, status, tanggal_pesan)
  VALUES('$nama','$telepon','$alamat','$tanggal','$total','Diproses','$now')");

  if($insertPesanan){
    $id_pesanan = mysqli_insert_id($conn);

    $insertDetail = mysqli_query($conn, "INSERT INTO raihan_detail_pesanan 
    (id_pesanan, id_menu, jumlah, subtotal) 
    VALUES('$id_pesanan','$id_menu','$jumlah','$total')");

    if($insertDetail){
      echo "<script>alert('Pesanan berhasil dibuat!'); location.href='menu.php';</script>";
    } else {
      echo "Error simpan detail pesanan: ".mysqli_error($conn);
    }

  } else {
    echo "Error simpan pesanan: ".mysqli_error($conn);
  }
}
?>
