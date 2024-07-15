-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Jun 2024 pada 17.58
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
-- Database: `db_uut`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2024-04-24-081645', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1713946675, 1),
(2, '2024-04-24-082641', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1713947233, 2),
(3, '2024-04-24-094842', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1713952130, 3),
(4, '2024-06-06-144417', 'App\\Database\\Migrations\\CreateProdukTable', 'default', 'App', 1717685076, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(5) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `nama`, `harga`, `jumlah`, `foto`, `created_at`, `updated_at`) VALUES
(19, 'ASUS TUF A15 FA506NF', 10899000, 5, '1717688768_3f1b6ea77e9860f27da2.jpg', '2024-06-06 15:46:08', '2024-06-06 15:46:08'),
(20, 'Asus Vivobook 14 A1404ZA', 6899000, 5, '1717689180_6a05b594dae785fbf6c7.jpg', '2024-06-06 15:53:00', '2024-06-06 15:53:00'),
(21, 'ASUS TUF A12 FA506NF', 7000000, 5, '1717689217_9b3b1fd34b4008fbffdc.jpg', '2024-06-06 15:53:37', '2024-06-06 15:53:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `name`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '$2y$10$5LOkazdKlVIEY.uWQJ919.7kq1eQvtwjFGaVC54XQAqW7FGzFfZn.', 'admin', '2024-04-24 09:49:26', '2024-04-24 09:49:26'),
(4, 'uut', 'uut', 'uut@gmail.com', '$2y$10$B0naTHK0nEetawwjkIajPuHPVaQieq7AwLL/8zSc.E.ecqGb/TIVi', 'admin', '2024-04-25 04:42:26', '2024-04-25 04:42:26'),
(5, 'Gentha Arya', 'dev', 'mgentaaryaps@gmail.com', '$2y$10$p7OGp.wdBXszz0sudsfmwe3JzTaxTurPCyEC/nk8bwWPY8jioboYq', 'admin', '2024-06-06 14:41:00', '2024-06-06 14:41:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
