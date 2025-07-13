<?php
include '../koneksi.php';
include 'session.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM raihan_menu WHERE id_menu=$id"));

if (isset($_POST['update'])) {
  $nama = $_POST['nama'];
  $deskripsi = $_POST['deskripsi'];
  $harga = $_POST['harga'];
  $kategori = $_POST['kategori'];

  if ($_FILES['gambar']['name']) {
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    if (file_exists("../gambar/".$data['gambar'])) {
      unlink("../gambar/".$data['gambar']);
    }

    move_uploaded_file($tmp, "../gambar/$gambar");
    mysqli_query($conn, "UPDATE raihan_menu SET nama_menu='$nama', deskripsi='$deskripsi', harga='$harga', gambar='$gambar', id_kategori='$kategori' WHERE id_menu=$id");
  } else {
    mysqli_query($conn, "UPDATE raihan_menu SET nama_menu='$nama', deskripsi='$deskripsi', harga='$harga', id_kategori='$kategori' WHERE id_menu=$id");
  }

  header("Location: kelola-menu.php");
}
?>

<!doctype html>
<html>
<head>
  <title>Edit Menu</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  <link href="../css/style-admin.css" rel="stylesheet">

<body>

<div class="sidebar">
  <h5><i class="fas fa-fire"></i> BARAK RAIHAN</h5>
  <a href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a>
  <a href="kelola-menu.php"><i class="fas fa-utensils"></i> Kelola Menu</a>
  <a href="pesanan.php"><i class="fas fa-receipt"></i> Riwayat Pesanan</a>
  <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="content">
  <div class="card">
    <h3>Edit Menu: <?= $data['nama_menu'] ?></h3>
    <form method="POST" enctype="multipart/form-data">
      <label class="fw-bold mt-3">Nama Menu:</label>
      <input name="nama" value="<?= $data['nama_menu'] ?>" class="form-control mb-3" required>

      <label class="fw-bold">Deskripsi:</label>
      <textarea name="deskripsi" class="form-control mb-3"><?= $data['deskripsi'] ?></textarea>

      <label class="fw-bold">Harga (Rp):</label>
      <input name="harga" type="number" value="<?= $data['harga'] ?>" class="form-control mb-3" required>

      <label class="fw-bold">Kategori:</label>
      <select name="kategori" class="form-control mb-3">
        <?php
        $kat = mysqli_query($conn, "SELECT * FROM raihan_kategori");
        while($k = mysqli_fetch_assoc($kat)){
          $selected = ($k['id_kategori'] == $data['id_kategori']) ? "selected" : "";
          echo "<option value='{$k['id_kategori']}' $selected>{$k['nama_kategori']}</option>";
        }
        ?>
      </select>

      <label class="fw-bold">Gambar Saat Ini:</label><br>
      <img src="../gambar/<?= $data['gambar'] ?>" width="120" class="mb-2"><br>
      <input type="file" name="gambar" accept="image/*" class="form-control mb-3">
      <small class="text-warning">Kosongkan jika tidak ingin ganti gambar.</small>

      <div class="mt-3">
        <button class="btn btn-success" name="update"><i class="fas fa-save"></i> Simpan Perubahan</button>
        <a href="kelola-menu.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
      </div>
    </form>
  </div>
</div>

<footer>
  © <?= date('Y') ?> BARAK RAIHAN — Dashboard Admin
</footer>

</body>
</html>
