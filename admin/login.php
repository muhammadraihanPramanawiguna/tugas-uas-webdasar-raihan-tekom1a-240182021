<?php
session_start();
include '../koneksi.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  if (empty($username) || empty($password)) {
    $error = "Isi dulu semua kolomnya!";
  } else {
    $cek = mysqli_query($conn, "SELECT * FROM raihan_users WHERE username='$username'");
    if (mysqli_num_rows($cek) == 1) {
      $data = mysqli_fetch_assoc($cek);
      if (password_verify($password, $data['password'])) {
        $_SESSION['login_admin'] = $data['username'];
        header("Location: dashboard.php");
        exit;
      } else {
        $error = "Username atau Password salah!";
      }
    } else {
      $error = "Username atau Password salah!";
    }
  }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Login Admin - BARAK RAIHAN</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet"> 
</head>
<body>

<nav class="navbar navbar-dark fixed-top shadow">
  <div class="container">
    <a class="navbar-brand" href="../index.php"><i class="fas fa-store"></i> BARAK RAIHAN</a>
  </div>
</nav>

<div class="moving-background">
  <div class="moving-menu atas">
  <img src="../gambar/bakso.jpeg">
    <img src="../gambar/mie ayam.jpg">
    <img src="../gambar/mie bangladesh.jpg">
    <img src="../gambar/mie goreng.jpg">
    <img src="../gambar/mie rebus.jpg">
    <img src="../gambar/Nasi-Goreng-telor.jpg">
    <img src="../gambar/sambal bakar.jpeg">
    <img src="../gambar/seblak.jpg">
    <img src="../gambar/soto padang.jpg">
    <img src="../gambar/ayam geprek.jpg">
    <img src="../gambar/bakso.jpeg">
    <img src="../gambar/mie ayam.jpg">
    <img src="../gambar/mie bangladesh.jpg">
    <img src="../gambar/mie goreng.jpg">
    <img src="../gambar/mie rebus.jpg">
    <img src="../gambar/Nasi-Goreng-telor.jpg">
    <img src="../gambar/sambal bakar.jpeg">
    <img src="../gambar/seblak.jpg">
    <img src="../gambar/soto padang.jpg">
  </div>

  <div class="hero">
    <h1><i class="fas fa-fire"></i> BARAK RAIHAN</h1>

    <div class="login-card mt-4">
      <h4>Login Admin</h4>

      <?php if (!empty($error)) { ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php } ?>

      <form method="POST">
        <div>
          <label for="username">Masukkan Username</label>
          <input type="text" value="admin@gmail.com" name="username" id="username" class="form-control" placeholder="Username">
        </div>
        <div>
          <label for="password">Masukkan Password</label>
          <input type="password" value="@min20675." name="password" id="password" class="form-control" placeholder="Password">
        </div>
        <div class="d-grid gap-2 mt-3">
          <button type="submit" class="btn btn-warning">Masuk Admin</button>
          <a href="../index.php" class="btn btn-secondary">Kembali</a>
        </div>
      </form>
    </div>
  </div>

  <div class="moving-menu bawah">
  <img src="../gambar/dalgona.jpg">
    <img src="../gambar/es teh.jpg">
    <img src="../gambar/es teler.jpg">
    <img src="../gambar/jus alpukat.jpg">
    <img src="../gambar/jus jeruk.jpg">
    <img src="../gambar/jus mangga.jpg">
    <img src="../gambar/kopi.jpg">
    <img src="../gambar/teh tarik.jpg">
    <img src="../gambar/dalgona.jpg">
    <img src="../gambar/es teh.jpg">
    <img src="../gambar/es teler.jpg">
    <img src="../gambar/jus alpukat.jpg">
    <img src="../gambar/jus jeruk.jpg">
    <img src="../gambar/jus mangga.jpg">
    <img src="../gambar/kopi.jpg">
    <img src="../gambar/teh tarik.jpg">
  </div>
</div>

<footer>
<div class="container">
    <p class="mb-2">BARAK RAIHAN — Perut Kenyang, Hatipun Senang!</p>
    <p>Alamat: Jl. jundul 1 blok 1 no 10, Padang | Telepon & WA: 0852-7447-5855</p>
    <div class="sosmed mt-3">
      <a href="#"><i class="fab fa-facebook"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
      <a href="#"><i class="fab fa-whatsapp"></i></a>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
