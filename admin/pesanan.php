<?php 
include '../koneksi.php'; 
include 'session.php';
if (isset($_POST['update'])) {
  $id = $_POST['id_pesanan'];
  $status = $_POST['status'];

  mysqli_query($conn, "UPDATE raihan_pesanan SET status='$status' WHERE id_pesanan='$id'");

  if($status == 'Selesai') {

    $detail = mysqli_query($conn, "SELECT id_menu, jumlah FROM raihan_detail_pesanan WHERE id_pesanan='$id'");
    while($d = mysqli_fetch_assoc($detail)) {
      $id_menu = $d['id_menu'];
      $jumlah  = $d['jumlah'];

      $cek = mysqli_query($conn, "SELECT * FROM raihan_grafik_log WHERE tanggal=CURDATE() AND id_menu='$id_menu'");
      if(mysqli_num_rows($cek) > 0){

        mysqli_query($conn, "UPDATE raihan_grafik_log SET jumlah_terjual = jumlah_terjual + $jumlah WHERE tanggal=CURDATE() AND id_menu='$id_menu'");
      } else {

        mysqli_query($conn, "INSERT INTO raihan_grafik_log (tanggal, id_menu, jumlah_terjual) VALUES (CURDATE(), '$id_menu', '$jumlah')");
      }
    }
  }

  header("Location: pesanan.php");
  exit;
}
if (isset($_POST['hapus'])) {
  $id = $_POST['id_pesanan'];

  mysqli_query($conn, "DELETE FROM raihan_detail_pesanan WHERE id_pesanan='$id'");

   mysqli_query($conn, "DELETE FROM raihan_pesanan WHERE id_pesanan='$id'");

  header("Location: pesanan.php");
  exit;
}

?>
<!doctype html>
<html>
<head>
  <title>Riwayat Pesanan</title>
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
  <h3><i class="fas fa-receipt"></i> Riwayat Pesanan</h3>
  <div class="card">
    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead class="table-warning text-center">
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Tanggal</th>
            <th>Menu</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
            <th>Total</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no=1;
          $data = mysqli_query($conn, 
            "SELECT p.id_pesanan, p.nama_pelanggan, p.telepon, p.alamat_pengantaran, p.tanggal_ambil, p.total_harga, p.status,
                   d.jumlah, d.subtotal, m.nama_menu
            FROM raihan_pesanan p
            JOIN raihan_detail_pesanan d ON p.id_pesanan = d.id_pesanan
            JOIN raihan_menu m ON d.id_menu = m.id_menu
            ORDER BY p.tanggal_ambil DESC
          ");
          while($d=mysqli_fetch_assoc($data)){
            echo 
            "<tr>
              <td class='text-center'>{$no}</td>
              <td>{$d['nama_pelanggan']}</td>
              <td>{$d['telepon']}</td>
              <td>{$d['alamat_pengantaran']}</td>
              <td>{$d['tanggal_ambil']}</td>
              <td>{$d['nama_menu']}</td>
              <td class='text-center'>{$d['jumlah']}</td>
              <td>Rp ".number_format($d['subtotal'],0,',','.')."</td>
              <td>Rp ".number_format($d['total_harga'],0,',','.')."</td>
              <td class='text-center'>{$d['status']}</td>
              <td>
                <form method='POST' class='d-flex'>
                  <input type='hidden' name='id_pesanan' value='{$d['id_pesanan']}'>
                  <select name='status' class='form-select form-select-sm me-1'>
                    <option value='Diproses' ".($d['status']=='Diproses'?'selected':'').">Diproses</option>
                    <option value='Selesai' ".($d['status']=='Selesai'?'selected':'').">Selesai</option>
                  </select>
                  <button name='update' class='btn btn-sm btn-success me-1' title='Update'><i class='fas fa-check'></i></button>
                  <button name='hapus' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus?\")' title='Hapus'><i class='fas fa-trash'></i></button>
                </form>
              </td>
            </tr>";
            $no++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<footer>
  © <?= date('Y') ?> BARAK RAIHAN — Dashboard Admin
</footer>

</body>
</html>
