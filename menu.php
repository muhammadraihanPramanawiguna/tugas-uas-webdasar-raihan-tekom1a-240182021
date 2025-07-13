<?php include 'koneksi.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Menu - BARAK RAIHAN</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow">
  <div class="container">
    <a class="navbar-brand" href="index.php"><i class="fas fa-store"></i> BARAK RAIHAN</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="menu.php"><i class="fas fa-utensils"></i> Menu</a></li>
        <li class="nav-item"><a class="nav-link" href="admin/login.php"><i class="fas fa-user-cog"></i> Admin</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="moving-background">
<div class="moving-menu atas">
  <img src="gambar/bakso.jpeg">
    <img src="gambar/mie ayam.jpg">
    <img src="gambar/mie bangladesh.jpg">
    <img src="gambar/mie goreng.jpg">
    <img src="gambar/mie rebus.jpg">
    <img src="gambar/Nasi-Goreng-telor.jpg">
    <img src="gambar/sambal bakar.jpeg">
    <img src="gambar/seblak.jpg">
    <img src="gambar/soto padang.jpg">
    <img src="gambar/ayam geprek.jpg">
    <img src="gambar/bakso.jpeg">
    <img src="gambar/mie ayam.jpg">
    <img src="gambar/mie bangladesh.jpg">
    <img src="gambar/mie goreng.jpg">
    <img src="gambar/mie rebus.jpg">
    <img src="gambar/Nasi-Goreng-telor.jpg">
    <img src="gambar/sambal bakar.jpeg">
    <img src="gambar/seblak.jpg">
    <img src="gambar/soto padang.jpg">
  </div>
  <div class="hero">
    <h1><i class="fas fa-fire"></i> BARAK RAIHAN</h1>
    <p>"Nikmati sensasi makan enak, porsi puas, harga ramah kantong, cuma di Barak Raihan!"</p>
  </div>
  <div class="moving-menu bawah">
  <img src="gambar/dalgona.jpg">
    <img src="gambar/es teh.jpg">
    <img src="gambar/es teler.jpg">
    <img src="gambar/jus alpukat.jpg">
    <img src="gambar/jus jeruk.jpg">
    <img src="gambar/jus mangga.jpg">
    <img src="gambar/kopi.jpg">
    <img src="gambar/teh tarik.jpg">
    <img src="gambar/dalgona.jpg">
    <img src="gambar/es teh.jpg">
    <img src="gambar/es teler.jpg">
    <img src="gambar/jus alpukat.jpg">
    <img src="gambar/jus jeruk.jpg">
    <img src="gambar/jus mangga.jpg">
    <img src="gambar/kopi.jpg">
    <img src="gambar/teh tarik.jpg">
  </div>
</div>


<div class="container py-5">
  <?php
  $kategori = mysqli_query($conn, "SELECT * FROM raihan_kategori");
  while($kat = mysqli_fetch_assoc($kategori)) {
    echo "<h3 class='mt-4'>{$kat['nama_kategori']}</h3>";
    $menu = mysqli_query($conn, "SELECT * FROM raihan_menu WHERE id_kategori={$kat['id_kategori']}");
    echo '<div class="row">';
    while($m = mysqli_fetch_assoc($menu)) {
      echo 
      "<div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
        <div class='card menu-card'>
          <img src='gambar/{$m['gambar']}' class='card-img-top'>
          <div class='card-body'>
            <h5 class='card-title text-warning'>{$m['nama_menu']}</h5>
            <p>{$m['deskripsi']}</p>
            <p><strong>Rp " . number_format($m['harga'],0,',','.') . "</strong></p>
            <button class='btn btn-warning' onclick=\"openPesanModal('{$m['id_menu']}', '{$m['nama_menu']}', '{$m['deskripsi']}', {$m['harga']}, '{$m['gambar']}')\">Pesan</button>
          </div>
        </div>
      </div>";
    }
    echo '</div>';
  }
  ?>
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

<div class="modal fade" id="pesanModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pesan: <span id="menuNama"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-5 text-center">
            <img id="menuGambar" src="" alt="Menu" class="img-fluid rounded mb-3">
            <p id="menuDeskripsi"></p>
            <h5>Harga: <span id="menuHarga"></span></h5>
          </div>
          <div class="col-md-7">
  <form id="formPesan">
    <div class="form-section">
      <h5>Data Pemesan</h5>
      <input type="hidden" id="idMenu" name="id_menu">
      <input type="hidden" id="hargaMenu" name="harga">

      <label class="fw-bold mt-2">Nama Pemesan:</label>
      <input type="text" name="nama" id="nama" class="form-control mb-2" placeholder="Contoh: Raihan" required>

      <label class="fw-bold">No Telepon:</label>
      <input type="text" name="telepon" id="telepon" class="form-control mb-2" placeholder="08xxxxxxxxxx" required>

      <label class="fw-bold">Alamat Pengiriman:</label>
      <textarea name="alamat" id="alamat" class="form-control mb-2" placeholder="Alamat lengkap" required></textarea>

      <label class="fw-bold">Tanggal & Jam Ambil:</label>
      <input type="datetime-local" name="tanggal" id="tanggal" class="form-control mb-2" required>

      <label class="fw-bold">Jumlah Pesanan:</label>
      <input type="number" name="jumlah" id="jumlah" class="form-control mb-2" value="1" min="1" required>

      <label class="fw-bold">Total Harga:</label>
      <p id="totalHarga" class="text-danger fw-bold">Rp 0</p>

      <div class="d-flex justify-content-between mt-3">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
        <button type="submit" class="btn btn-warning">Beli</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openPesanModal(id, nama, deskripsi, harga, gambar) {
  document.getElementById('formPesan').reset();
  document.getElementById('menuNama').innerText = nama;
  document.getElementById('menuDeskripsi').innerText = deskripsi;
  document.getElementById('menuHarga').innerText = 'Rp ' + harga.toLocaleString();
  document.getElementById('menuGambar').src = 'gambar/' + gambar;
  document.getElementById('idMenu').value = id;
  document.getElementById('hargaMenu').value = harga;

  document.getElementById('jumlah').value = 1;
  document.getElementById('totalHarga').innerText = 'Rp ' + harga.toLocaleString();

  document.getElementById('jumlah').oninput = function() {
    let total = this.value * harga;
    document.getElementById('totalHarga').innerText = 'Rp ' + total.toLocaleString();
  }

  new bootstrap.Modal(document.getElementById('pesanModal')).show();
}

document.getElementById('formPesan').onsubmit = function(e) {
  e.preventDefault();

  let nama = document.getElementById('nama').value;
  let telepon = document.getElementById('telepon').value;
  let alamat = document.getElementById('alamat').value;
  let tanggal = document.getElementById('tanggal').value;
  let jumlah = document.getElementById('jumlah').value;
  let total = document.getElementById('totalHarga').innerText;

  if (!nama || !telepon || !alamat || !tanggal || !jumlah) {
    alert("Lengkapi semua data dulu ya bro!");
    return;
  }

  let konfirmasi = confirm(`Apakah data sudah sesuai?\n\nNama: ${nama}\nTelepon: ${telepon}\nAlamat: ${alamat}\nAmbil: ${tanggal}\nJumlah: ${jumlah}\nTotal: ${total}`);

  if (konfirmasi) {
    let formData = new FormData(this);

    fetch('proses-pesan.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(data => {
      alert("Terima kasih bro, pesanan kamu sudah masuk! Admin akan hubungi kamu.");
      let modal = bootstrap.Modal.getInstance(document.getElementById('pesanModal'));
      modal.hide();
    })
    .catch(error => {
      alert("Gagal kirim pesanan. Coba lagi ya bro.");
      console.error(error);
    });
  }
}

</script>
</body>
</html>
