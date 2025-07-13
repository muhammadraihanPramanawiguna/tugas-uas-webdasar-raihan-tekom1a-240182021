<?php
session_start();
include '../koneksi.php';
$tanggal = isset($_GET['tanggal']) && $_GET['tanggal'] != "" ? $_GET['tanggal'] : date('Y-m-d');
$minggu = isset($_GET['minggu']) && $_GET['minggu'] != "" ? $_GET['minggu'] : date('oW');

$tanggal_option = mysqli_query($conn, 
  "SELECT DISTINCT tanggal 
   FROM raihan_grafik_log 
   WHERE tanggal BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()
   ORDER BY tanggal DESC"
);

$minggu_option = mysqli_query($conn,
"SELECT 
    MIN(tanggal) AS mulai, 
    MAX(tanggal) AS akhir 
  FROM (
    SELECT 
      tanggal, 
      FLOOR((DAY(tanggal))/7)+1 AS minggu_ke
    FROM raihan_grafik_log
    WHERE MONTH(tanggal)=MONTH(CURDATE()) AND YEAR(tanggal)=YEAR(CURDATE())
  ) AS sub
GROUP BY minggu_ke
ORDER BY mulai DESC
");

$data = mysqli_query($conn, 
  "SELECT m.nama_menu, SUM(g.jumlah_terjual) as total
   FROM raihan_grafik_log g
   JOIN raihan_menu m ON g.id_menu = m.id_menu
   WHERE g.tanggal = '$tanggal'
   GROUP BY g.id_menu"
);


$labels = $values = [];
while ($d = mysqli_fetch_assoc($data)) {
  $labels[] = $d['nama_menu'];
  $values[] = $d['total'];
}

$makanan = mysqli_query($conn, 
  "SELECT m.nama_menu, SUM(g.jumlah_terjual) as total
   FROM raihan_grafik_log g
   JOIN raihan_menu m ON g.id_menu = m.id_menu
   JOIN raihan_kategori k ON m.id_kategori = k.id_kategori
   WHERE g.tanggal = '$tanggal'
   AND k.nama_kategori = 'Makanan'
   GROUP BY g.id_menu"
);


$makananLabel = $makananValue = [];
while ($m = mysqli_fetch_assoc($makanan)) {
  $makananLabel[] = $m['nama_menu'];
  $makananValue[] = $m['total'];
}
$minuman = mysqli_query($conn, 
  "SELECT m.nama_menu, SUM(g.jumlah_terjual) as total
   FROM raihan_grafik_log g
   JOIN raihan_menu m ON g.id_menu = m.id_menu
   JOIN raihan_kategori k ON m.id_kategori = k.id_kategori
   WHERE g.tanggal = '$tanggal'
   AND k.nama_kategori = 'Minuman'
   GROUP BY g.id_menu"
);



$minumanLabel = $minumanValue = [];
while ($n = mysqli_fetch_assoc($minuman)) {
  $minumanLabel[] = $n['nama_menu'];
  $minumanValue[] = $n['total'];
}

if(isset($_GET['range']) && $_GET['range'] != ""){
  $exp = explode("_", $_GET['range']);
  $mulai = $exp[0];
  $akhir = $exp[1];
  $harian = mysqli_query($conn, 
  "SELECT g.tanggal, SUM(g.jumlah_terjual * m.harga) as total
  FROM raihan_grafik_log g
  JOIN raihan_menu m ON g.id_menu = m.id_menu
  WHERE g.tanggal BETWEEN '$mulai' AND '$akhir'
  GROUP BY g.tanggal
  ORDER BY g.tanggal ASC"
);

  $label_range = date('d M', strtotime($mulai)).' - '.date('d M Y', strtotime($akhir));
} else {
 $harian = mysqli_query($conn, 
  "SELECT g.tanggal, SUM(g.jumlah_terjual * m.harga) as total
  FROM raihan_grafik_log g
  JOIN raihan_menu m ON g.id_menu = m.id_menu
  WHERE MONTH(g.tanggal)=MONTH(CURDATE()) AND YEAR(g.tanggal)=YEAR(CURDATE())
  GROUP BY g.tanggal
  ORDER BY g.tanggal ASC"
);

  $label_range = 'minggu Ini';
}

$hariLabel = $hariValue = [];
while ($h = mysqli_fetch_assoc($harian)) {
  $hariLabel[] = $h['tanggal'];
  $hariValue[] = $h['total'];
}
?>
<!doctype html>
<html>
<head>
  <title>Dashboard Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  <link href="../css/style-admin.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="sidebar">
  <h4><i class="fas fa-fire"></i> BARAK RAIHAN</h4>
  <a href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a>
  <a href="kelola-menu.php"><i class="fas fa-utensils"></i> Kelola Menu</a>
  <a href="pesanan.php"><i class="fas fa-receipt"></i> Riwayat Pesanan</a>
  <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="content">
  <h3>Halo, <?= $_SESSION['login_admin'] ?>!</h3>
  <div class="row mb-3">
  <div class="col-md-6">
    <form method="get">
      <label>Pilih Tanggal Rekap Harian:</label>
      <select name="tanggal" class="form-select" onchange="this.form.submit()">
        <option value="">Hari Ini (<?= date('Y-m-d') ?>)</option>
        <?php while($t=mysqli_fetch_assoc($tanggal_option)) {
          $sel = $t['tanggal']==$tanggal ? 'selected' : '';
          echo "<option value='".$t['tanggal']."' $sel>".$t['tanggal']."</option>";
        } ?>
      </select>
    </form>
  </div>
  <?php $label_terpilih = ''; ?>
  <div class="col-md-6">
    <form method="get">
      <label>Pilih Minggu Grafik Garis:</label>
      <select name="range" class="form-select" onchange="this.form.submit()">
      <?php while($m=mysqli_fetch_assoc($minggu_option)) {
  $range = $m['mulai'].'_'.$m['akhir'];
  $label = date('d M', strtotime($m['mulai'])) .' - '. date('d M Y', strtotime($m['akhir']));
  $sel = (isset($_GET['range']) && $_GET['range'] == $range) ? 'selected' : '';


  if (isset($_GET['range']) && $_GET['range'] == $range) {
    $label_terpilih = $label;
  }

  echo "<option value='$range' $sel>$label</option>";
} ?>

      </select>
    </form>
  </div>

  <div class="card">
  <h5>Grafik Penjualan per Menu - <?= $tanggal ?></h5>
    <canvas id="grafikBatang"></canvas>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <h5>Pie Makanan</h5>
        <canvas id="pieMakanan"></canvas>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <h5>Pie Minuman</h5>
        <canvas id="pieMinuman"></canvas>
      </div>
    </div>
  </div>

  <div class="card">
  <h5>Grafik Penjualan bulanan (<?= $label_terpilih != '' ? $label_terpilih : $label_range ?>)</h5>
  <canvas id="grafikHarian"></canvas>
</div>

  </div>
</div>

<footer>
  © <?= date('Y') ?> BARAK RAIHAN — Dashboard Admin
</footer>

<script>
var ctx1 = document.getElementById("grafikBatang").getContext("2d");
new Chart(ctx1, {
  type: 'bar',
  data: {
    labels: <?= json_encode($labels); ?>,
    datasets: [{
      label: 'Jumlah Terjual',
      data: <?= json_encode($values); ?>,
      backgroundColor: 'rgba(255, 159, 64, 0.8)'
    }]
  }
});

var ctx2 = document.getElementById("pieMakanan").getContext("2d");
new Chart(ctx2, {
  type: 'pie',
  data: {
    labels: <?= json_encode($makananLabel); ?>,
    datasets: [{
      data: <?= json_encode($makananValue); ?>,
      backgroundColor: ['#FF6384','#FFCD56','#36A2EB','#FF9F40']
    }]
  }
});

var ctx3 = document.getElementById("pieMinuman").getContext("2d");
new Chart(ctx3, {
  type: 'pie',
  data: {
    labels: <?= json_encode($minumanLabel); ?>,
    datasets: [{
      data: <?= json_encode($minumanValue); ?>,
      backgroundColor: ['#4BC0C0','#FF6384','#FFCD56','#36A2EB']
    }]
  }
});

var ctx4 = document.getElementById("grafikHarian").getContext("2d");
new Chart(ctx4, {
  type: 'line',
  data: {
    labels: <?= json_encode(array_reverse($hariLabel)); ?>,
    datasets: [{
      label: 'Total Penjualan (Rp)',
      data: <?= json_encode(array_reverse($hariValue)); ?>,
      borderColor: '#ff7f3f',
      backgroundColor: 'rgba(255,127,63,0.2)',
      tension: 0.3,
      fill: true
    }]
  }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
