-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Jul 2026 pada 10.12
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
-- Database: `mua_ulva`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `hari_libur`
--

CREATE TABLE `hari_libur` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) DEFAULT 'Libur Studio',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `kuota` int(11) DEFAULT 1,
  `status` enum('tersedia','penuh') DEFAULT 'tersedia',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id`, `tanggal`, `jam_mulai`, `jam_selesai`, `kuota`, `status`, `created_at`) VALUES
(1, '2026-07-05', '09:00:00', '11:00:00', 1, 'tersedia', '2026-07-04 17:56:55'),
(2, '2026-07-05', '13:00:00', '15:00:00', 1, 'tersedia', '2026-07-04 17:56:55'),
(3, '2026-07-05', '19:00:00', '21:00:00', 1, 'tersedia', '2026-07-04 17:56:55'),
(4, '2026-07-06', '09:00:00', '11:00:00', 1, 'tersedia', '2026-07-04 17:56:55'),
(5, '2026-07-06', '13:00:00', '15:00:00', 1, 'tersedia', '2026-07-04 17:56:55'),
(6, '2026-07-06', '19:00:00', '21:00:00', 1, 'tersedia', '2026-07-04 17:56:55'),
(7, '2026-07-07', '09:00:00', '11:00:00', 1, 'tersedia', '2026-07-04 17:56:55'),
(8, '2026-07-07', '13:00:00', '15:00:00', 1, 'tersedia', '2026-07-04 17:56:55'),
(9, '2026-07-07', '19:00:00', '21:00:00', 1, 'tersedia', '2026-07-04 17:56:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `paket`
--

CREATE TABLE `paket` (
  `id` int(11) NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `durasi_jam` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `kategori` enum('regular','wedding') DEFAULT 'regular',
  `dp_persen` int(11) DEFAULT 30,
  `is_aktif` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `paket`
--

INSERT INTO `paket` (`id`, `nama_paket`, `deskripsi`, `harga`, `durasi_jam`, `created_at`, `kategori`, `dp_persen`, `is_aktif`) VALUES
(1, 'Paket Wisuda', 'Rias pengantin lengkap dengan trial dan retouch', 1500000.00, 8, '2026-07-04 17:56:55', 'regular', 30, 1),
(2, 'Paket Lamaran', 'Rias wisuda + dokumentasi singkat', 750000.00, 2, '2026-07-04 17:56:55', 'regular', 30, 1),
(3, 'Paket Wisuda + Keluarga', 'Rias pesta malam elegan', 500000.00, 1, '2026-07-04 17:56:55', 'regular', 30, 1),
(4, 'Paket Makeup Natural Daily', 'Riasan sehari-hari yang fresh dan natural. Cocok untuk acara casual, gathering, atau sekedar tampil percaya diri.', 200000.00, 1, '2026-07-05 01:47:35', 'regular', 30, 1),
(5, 'Paket Prewedding', 'Riasan glamor untuk sesi foto prewedding. MUA akan mendampingi sepanjang sesi foto untuk touch-up berkala.', 850000.00, 5, '2026-07-05 01:47:35', 'regular', 30, 1),
(6, 'Paket Wedding Full Day', 'Paket pernikahan lengkap. MUA akan mendampingi pengantin dari persiapan pagi hingga acara resepsi selesai. Termasuk riasan akad dan resepsi, hair styling, dan touch-up sepanjang hari.', 2500000.00, 12, '2026-07-05 01:47:35', 'wedding', 50, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan_jadwal`
--

CREATE TABLE `pengaturan_jadwal` (
  `id` int(11) NOT NULL,
  `jam_mulai` time NOT NULL DEFAULT '03:00:00',
  `jam_selesai` time NOT NULL DEFAULT '23:00:00',
  `durasi_slot_menit` int(11) NOT NULL DEFAULT 120,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengaturan_jadwal`
--

INSERT INTO `pengaturan_jadwal` (`id`, `jam_mulai`, `jam_selesai`, `durasi_slot_menit`, `updated_at`) VALUES
(1, '03:00:00', '23:00:00', 120, '2026-07-05 01:47:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `portofolio`
--

CREATE TABLE `portofolio` (
  `id` int(11) NOT NULL,
  `paket_id` int(11) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `urutan` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `portofolio`
--

INSERT INTO `portofolio` (`id`, `paket_id`, `caption`, `gambar`, `created_at`, `urutan`) VALUES
(1, 1, 'Pengantin 1', 'public/img/pengantin1.jpeg', '2026-07-04 17:56:55', 0),
(2, 1, 'Pengantin 2', 'public/img/pengantin2.jpeg', '2026-07-04 17:56:55', 0),
(3, 4, 'Natural MakeUp Daily', 'public/img/narural2.webp', '2026-07-04 17:56:55', 0),
(4, 2, 'Pesta 1', 'public/img/glam1.jpeg', '2026-07-04 17:56:55', 0),
(5, 4, 'paket Makeup Daily', 'public/img/narural2.webp', '2026-07-07 08:39:29', 0),
(6, 4, 'paket Makeup Daily', 'public/img/party2.webp', '2026-07-07 08:39:29', 0),
(7, 1, 'Paket Wisuda', 'public/img/wisuda1.jpeg', '2026-07-07 08:40:57', 0),
(8, 1, 'Paket Wisuda', 'public/img/wisuda2.jpeg', '2026-07-07 08:40:57', 0),
(9, 4, 'Paket Makeup Daily', 'public/img/glam3.webp', '2026-07-07 08:41:55', 6),
(10, 4, 'makeup daily', 'public/img/party2.webp', '2026-07-07 09:35:04', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `reservasi`
--

CREATE TABLE `reservasi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `paket_id` int(11) NOT NULL,
  `jadwal_id` int(11) DEFAULT NULL,
  `tanggal_reservasi` date NOT NULL,
  `status` enum('pending','dikonfirmasi','selesai','batal') DEFAULT 'pending',
  `status_pembayaran` enum('belum','dp','lunas') DEFAULT 'belum',
  `total_harga` decimal(10,2) NOT NULL,
  `dp_dibayar` decimal(10,2) DEFAULT 0.00,
  `total_dp` decimal(10,2) DEFAULT 0.00,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `jenis_lokasi` enum('studio','customer') DEFAULT 'studio',
  `catatan` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `is_full_day` tinyint(1) DEFAULT 0,
  `alamat_customer` text DEFAULT NULL,
  `whatsapp_sent` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `reservasi`
--

INSERT INTO `reservasi` (`id`, `user_id`, `paket_id`, `jadwal_id`, `tanggal_reservasi`, `status`, `status_pembayaran`, `total_harga`, `dp_dibayar`, `total_dp`, `bukti_pembayaran`, `jenis_lokasi`, `catatan`, `keterangan`, `created_at`, `jam_mulai`, `jam_selesai`, `is_full_day`, `alamat_customer`, `whatsapp_sent`) VALUES
(2, 5, 6, NULL, '2026-07-06', 'dikonfirmasi', 'belum', 2500000.00, 0.00, 1250000.00, NULL, 'customer', 'looks natural', 'butuh 3 tema makeup', '2026-07-05 02:29:08', '03:00:00', '23:00:00', 1, 'Jl.Lancang Kuning, Rumbai, Pekanbaru, Riau.', 0),
(3, 7, 4, NULL, '2026-07-20', 'pending', 'belum', 200000.00, 0.00, 60000.00, NULL, 'customer', 'bawakan orang ganteng untuk makeup in aku', 'bebas', '2026-07-07 07:52:07', '05:00:00', '07:00:00', 0, 'jl. rambutan sari', 0),
(4, 8, 4, NULL, '2026-07-21', 'selesai', 'dp', 200000.00, 200000.00, 60000.00, NULL, 'studio', '-', '-', '2026-07-07 09:25:50', '05:00:00', '07:00:00', 0, '', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `testimoni`
--

CREATE TABLE `testimoni` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `isi` text NOT NULL,
  `rating` int(11) DEFAULT 5,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `paket` varchar(150) DEFAULT NULL,
  `is_tampil` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `testimoni`
--

INSERT INTO `testimoni` (`id`, `nama`, `isi`, `rating`, `foto`, `created_at`, `user_id`, `paket`, `is_tampil`) VALUES
(1, 'Ayu', 'Makeupnya sangat bagus dan tahan lama, saya puas sekali!', 5, NULL, '2026-07-04 17:56:55', NULL, NULL, 1),
(2, 'Rina', 'Pelayanan ramah, hasilnya memuaskan, recommended banget!', 5, NULL, '2026-07-04 17:56:55', NULL, NULL, 1),
(3, 'Dewi', 'Profesional dan tepat waktu. Hasil makeup sesuai keinginan.', 4, NULL, '2026-07-04 17:56:55', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `email`, `no_hp`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$4lJxUEW5kdAZsIFCEckcmOjTC2NJEPoj26U8xK1lh4wYm44s3P2uG', 'Administrator', 'admin@muaulva.com', NULL, 'admin', '2026-07-04 17:56:55'),
(2, 'rachel', '$2y$10$Vz0KNKvKCPoPygRvwGfzW.umx1Xvg1cr.wBH63hYKle8pkCuP1QQi', 'Rachel Kumala Samosir', 'rachel25si@mahasiswa.pcr.ac.id', '0823456798', 'customer', '2026-07-04 18:28:30'),
(4, 'customer', '$2y$10$TKh8H1.PfYikXggekklm2uiTsV0WZGflFO8jSxzJMZvVDW4AluPu6', 'Sari Dewi', 'sari@gmail.com', '082112345678', 'customer', '2026-07-05 01:47:35'),
(5, 'acell', '$2y$10$II7FcSBg8Biq39s.n6wy3OzNu/yUkBvLEIfc59b9TsKlRWwzRsATS', 'rachel samosir', 'rachelksamosir@gmail.com', '081364624756', 'customer', '2026-07-05 02:07:41'),
(6, 'nafisa', '$2y$10$MEM6nUdwmMGEk.1wob8jT..w4UFyItKub7NbcjNvfAEt6SdK7.Pie', 'Nafisa Khalila Sisyananda', 'nafisa@gmail.com', '0823456798', 'customer', '2026-07-07 06:13:48'),
(7, 'acacu', '$2y$10$onoH7YTUpq0CbzB5Y5dhh.wtJvc/dYVQssves0e/dQQObpgbMM55C', 'rasya algantengi', 'rasya@gmail.com', '089515697645', 'customer', '2026-07-07 07:50:20'),
(8, 'zakikiut', '$2y$10$74Wq.dlrd65s2U2DelDeBOOy2WaBPEjhbxdSpN.1MHlrY8WWEkv6.', 'Dzaki Fadil Rahman', 'zaki@gmail.com', '0821435678', 'customer', '2026-07-07 09:24:46');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `hari_libur`
--
ALTER TABLE `hari_libur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tanggal` (`tanggal`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengaturan_jadwal`
--
ALTER TABLE `pengaturan_jadwal`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `portofolio`
--
ALTER TABLE `portofolio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paket_id` (`paket_id`);

--
-- Indeks untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `paket_id` (`paket_id`),
  ADD KEY `jadwal_id` (`jadwal_id`);

--
-- Indeks untuk tabel `testimoni`
--
ALTER TABLE `testimoni`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `hari_libur`
--
ALTER TABLE `hari_libur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `paket`
--
ALTER TABLE `paket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pengaturan_jadwal`
--
ALTER TABLE `pengaturan_jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `portofolio`
--
ALTER TABLE `portofolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `testimoni`
--
ALTER TABLE `testimoni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `portofolio`
--
ALTER TABLE `portofolio`
  ADD CONSTRAINT `portofolio_ibfk_1` FOREIGN KEY (`paket_id`) REFERENCES `paket` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  ADD CONSTRAINT `reservasi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reservasi_ibfk_2` FOREIGN KEY (`paket_id`) REFERENCES `paket` (`id`),
  ADD CONSTRAINT `reservasi_ibfk_3` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
