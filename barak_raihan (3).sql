-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jul 2025 pada 12.46
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barak_raihan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `raihan_detail_pesanan`
--

CREATE TABLE `raihan_detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `raihan_detail_pesanan`
--

INSERT INTO `raihan_detail_pesanan` (`id_detail`, `id_pesanan`, `id_menu`, `jumlah`, `subtotal`) VALUES
(20, 20, 16, 3, 45000.00),
(24, 24, 16, 3, 45000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `raihan_grafik_log`
--

CREATE TABLE `raihan_grafik_log` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `id_menu` int(11) NOT NULL,
  `jumlah_terjual` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `raihan_grafik_log`
--

INSERT INTO `raihan_grafik_log` (`id`, `tanggal`, `id_menu`, `jumlah_terjual`) VALUES
(48, '2025-07-13', 24, 1),
(49, '2025-07-14', 16, 3),
(50, '2025-07-15', 16, 6),
(51, '2025-07-15', 24, 2147483647);

-- --------------------------------------------------------

--
-- Struktur dari tabel `raihan_kategori`
--

CREATE TABLE `raihan_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `raihan_kategori`
--

INSERT INTO `raihan_kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'makanan'),
(2, 'minuman');

-- --------------------------------------------------------

--
-- Struktur dari tabel `raihan_menu`
--

CREATE TABLE `raihan_menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `raihan_menu`
--

INSERT INTO `raihan_menu` (`id_menu`, `nama_menu`, `deskripsi`, `harga`, `gambar`, `id_kategori`) VALUES
(9, 'nasi goreng ', 'nasi goreng spesial ala barak raihan', 10000.00, 'Nasi-Goreng-telor.jpg', 1),
(10, 'mie bangladesh', 'mie bangladesh spesial ala barak raihan', 11000.00, 'mie bangladesh.jpg', 1),
(11, 'mie rebus', 'mie rebus spesial ala barak raihan', 11000.00, 'mie rebus.webp', 1),
(12, 'mie ayam', 'mie ayam spesial ala barak raihan', 12000.00, 'mie ayam.jpg', 1),
(13, 'mie goreng', 'mie goreng spesial ala barak raihan', 11000.00, 'mie goreng.jpg', 1),
(14, 'ayam smackdown', 'ayam geprek spesial ala barak raihan', 12000.00, 'ayam geprek.jpg', 1),
(15, 'soto padang', 'soto padang spesial ala barak raihan', 12000.00, 'soto padang.jpg', 1),
(16, 'ayam sambal bakar', 'ayam sambal bakar spesial ala barak raihan sudah include nasi', 15000.00, 'sambal bakar.jpg', 1),
(17, 'seblak', 'seblak spesial ala barak raihan', 13000.00, 'seblak.jpg', 1),
(18, 'bakso kuah', 'bakso kuah spesial ala barak raihan', 10000.00, 'bakso.jpeg', 1),
(19, 'es teh ', '', 4000.00, 'es teh.jpg', 2),
(20, 'kopi hitam', '', 5000.00, 'kopi.jpg', 2),
(21, 'jus jeruk', '', 7000.00, 'jus jeruk.jpg', 2),
(22, 'jus mangga', '', 7000.00, 'jus mangga.jpg', 2),
(23, 'jus alpukat', '', 7000.00, 'jus alpukat.jpg', 2),
(24, 'dalgona coffee', '', 9000.00, 'dalgona.jpg', 2),
(25, 'es teler', '', 7000.00, 'es teler.jpg', 2),
(26, 'teh tarik', '', 6000.00, 'teh tarik.jpg', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `raihan_pesanan`
--

CREATE TABLE `raihan_pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `alamat_pengantaran` text DEFAULT NULL,
  `tanggal_ambil` datetime DEFAULT NULL,
  `total_harga` decimal(10,2) DEFAULT NULL,
  `status` enum('diproses','selesai') NOT NULL,
  `tanggal_pesan` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `raihan_pesanan`
--

INSERT INTO `raihan_pesanan` (`id_pesanan`, `nama_pelanggan`, `telepon`, `alamat_pengantaran`, `tanggal_ambil`, `total_harga`, `status`, `tanggal_pesan`) VALUES
(20, 'raihan', '0897987090', 'jl', '2025-07-09 22:23:00', 45000.00, 'selesai', '2025-07-09 17:23:55'),
(24, 'dita', '04574953489508', 'jl', '2025-07-15 23:35:00', 45000.00, 'selesai', '2025-07-15 18:35:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `raihan_users`
--

CREATE TABLE `raihan_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('admin') DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `raihan_users`
--

INSERT INTO `raihan_users` (`id`, `username`, `password`, `level`) VALUES
(1, 'admin@gmail.com', '$2a$12$aB5tg3ahL0dBZiGuP6oAteRVs0aRp7yxLMdaDy5rTNWEN.0tr4H5O', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `raihan_detail_pesanan`
--
ALTER TABLE `raihan_detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indeks untuk tabel `raihan_grafik_log`
--
ALTER TABLE `raihan_grafik_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indeks untuk tabel `raihan_kategori`
--
ALTER TABLE `raihan_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `raihan_menu`
--
ALTER TABLE `raihan_menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `raihan_pesanan`
--
ALTER TABLE `raihan_pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indeks untuk tabel `raihan_users`
--
ALTER TABLE `raihan_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `raihan_detail_pesanan`
--
ALTER TABLE `raihan_detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `raihan_grafik_log`
--
ALTER TABLE `raihan_grafik_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `raihan_kategori`
--
ALTER TABLE `raihan_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `raihan_menu`
--
ALTER TABLE `raihan_menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `raihan_pesanan`
--
ALTER TABLE `raihan_pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `raihan_users`
--
ALTER TABLE `raihan_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `raihan_detail_pesanan`
--
ALTER TABLE `raihan_detail_pesanan`
  ADD CONSTRAINT `raihan_detail_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `raihan_pesanan` (`id_pesanan`),
  ADD CONSTRAINT `raihan_detail_pesanan_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `raihan_menu` (`id_menu`);

--
-- Ketidakleluasaan untuk tabel `raihan_grafik_log`
--
ALTER TABLE `raihan_grafik_log`
  ADD CONSTRAINT `raihan_grafik_log_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `raihan_menu` (`id_menu`);

--
-- Ketidakleluasaan untuk tabel `raihan_menu`
--
ALTER TABLE `raihan_menu`
  ADD CONSTRAINT `raihan_menu_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `raihan_kategori` (`id_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
