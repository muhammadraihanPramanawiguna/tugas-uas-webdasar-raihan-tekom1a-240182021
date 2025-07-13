<?php 
include '../koneksi.php'; 
include 'session.php';

if (isset($_POST['tambah'])) {
  $nama = $_POST['nama'];
  $deskripsi = $_POST['deskripsi'];
  $harga = $_POST['harga'];
  $kategori = $_POST['kategori'];

  if (empty($kategori)) {
    $error = "Kategori wajib dipilih!";
  } else {
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $type = $_FILES['gambar']['type'];

    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
    if (in_array($type, $allowedTypes)) {
      if (!is_dir("../gambar")) {
        mkdir("../gambar");
      }

      $target = "../gambar/" . $gambar;

      if (move_uploaded_file($tmp, $target)) {
        mysqli_query($conn, "INSERT INTO raihan_menu 
          (nama_menu, deskripsi, harga, gambar, id_kategori) 
          VALUES 
          ('$nama', '$deskripsi', '$harga', '$gambar', '$kategori')");
        header("Location: kelola-menu.php");
        exit;
      } else {
        $error = "Upload gambar gagal!";
      }
    } else {
      $error = "File harus berupa gambar (JPG, JPEG, PNG, WEBP)";
    }
  }
}
?>

<!doctype html>
<html>
<head>
  <title>Kelola Menu</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  <link href="../css/style-admin.css" rel="stylesheet">
</head>
<body>

<div class="sidebar">
  <h5><i class="fas fa-fire"></i> BARAK RAIHAN</h5>
  <a href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a>
  <a href="kelola-menu.php"><i class="fas fa-utensils"></i> Kelola Menu</a>
  <a href="pesanan.php"><i class="fas fa-receipt"></i> Riwayat Pesanan</a>
  <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="content">
  <h3>Kelola Menu</h3>

  <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

  <form method="POST" enctype="multipart/form-data" class="mb-4">
    <input name="nama" class="form-control mb-2" placeholder="Nama Menu" required>
    <textarea name="deskripsi" class="form-control mb-2" placeholder="Deskripsi"></textarea>
    <input name="harga" type="number" class="form-control mb-2" placeholder="Harga (Rp)" required>

    <select name="kategori" class="form-select mb-2" required>
      <option value="">-- Pilih Kategori --</option>
      <?php
      $kat = mysqli_query($conn, "SELECT * FROM raihan_kategori");
      while($k = mysqli_fetch_assoc($kat)){
        echo "<option value='{$k['id_kategori']}'>{$k['nama_kategori']}</option>";
      }
      ?>
    </select>

    <input type="file" name="gambar" class="form-control mb-2" accept="image/*" required>
    <button class="btn btn-warning" name="tambah"><i class="fas fa-plus-circle"></i> Tambah Menu</button>
    <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
  </form>

  <table class="table table-bordered table-striped">
    <thead class="table-warning text-center">
      <tr>
        <th>No</th>
        <th>Nama Menu</th>
        <th>Harga</th>
        <th>Kategori</th>
        <th>Gambar</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
    <?php
    $no=1;
    $menu = mysqli_query($conn,"SELECT * FROM raihan_menu 
                                INNER JOIN raihan_kategori 
                                ON raihan_menu.id_kategori=raihan_kategori.id_kategori");
    while($m=mysqli_fetch_assoc($menu)){
      echo "<tr class='text-center'>
        <td>$no</td>
        <td>{$m['nama_menu']}</td>
        <td>Rp ".number_format($m['harga'],0,',','.')."</td>
        <td>{$m['nama_kategori']}</td>
        <td><img src='../gambar/{$m['gambar']}'></td>
        <td>
          <a href='edit-menu.php?id={$m['id_menu']}' class='btn btn-sm btn-info'><i class='fas fa-edit'></i></a> 
          <a href='hapus-menu.php?id={$m['id_menu']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus menu ini?\")'><i class='fas fa-trash'></i></a>
        </td>
      </tr>";
      $no++;
    }
    ?>
    </tbody>
  </table>
</div>


<footer>
  © <?= date('Y') ?> BARAK RAIHAN — Dashboard Admin
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
