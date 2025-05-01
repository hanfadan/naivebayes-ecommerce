-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 01 Bulan Mei 2025 pada 17.46
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pro_naive_bayes`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `carts`
--

CREATE TABLE `carts` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `slug`) VALUES
(1, 0, 'Pakaian Pria', 'pakaian-pria'),
(2, 0, 'Pakaian Wanita', 'pakaian-wanita'),
(4, 1, 'Jaket', 'jaket'),
(5, 1, 'Kaos', 'kaos'),
(6, 1, 'Sweater', 'sweater'),
(7, 1, 'Batik', 'batik'),
(8, 1, 'Kemeja', 'kemeja'),
(9, 1, 'Jas', 'jas'),
(10, 1, 'Celana', 'celana'),
(11, 2, 'Dress', 'dress'),
(12, 2, 'Kaos Polo', 'kaos-polo'),
(13, 2, 'Cardigan', 'cardigan'),
(14, 2, 'Bluse', 'bluse'),
(15, 2, 'Kemeja Casual', 'kemeja-casual'),
(16, 2, 'Baju Muslim', 'baju-muslim'),
(17, 2, 'Celana Casual', 'celana-casual');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `stok` int(11) NOT NULL,
  `price` double NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `image`, `stok`, `price`, `description`, `status`, `created`, `modified`) VALUES
(1, 4, 'Jaket 1', 'jaket-1', '1718557521.jpg', 1, 100000, 'p', 1, '2024-06-17', '2024-06-17'),
(2, 4, 'Jaket 2', 'jaket-2', '1718557587.jpg', 1, 100000, 'p', 1, '2024-06-17', '2024-06-17'),
(3, 4, 'Jaket 3', 'jaket-3', '1718557709.jpg', 1, 100000, 'p', 1, '2024-06-17', '2024-06-17'),
(4, 4, 'Jaket 4', 'jaket-4', '1718557768.jpg', 1, 100000, 'p', 1, '2024-06-17', '2024-06-17'),
(5, 5, 'Kaos 1', 'kaos-1', '1718557885.jpg', 1, 100000, 'p', 1, '2024-06-17', '2024-06-17'),
(6, 4, 'jacket black 250k', 'jacket-black-250k', '1718730364.jpg', 1, 250000, 'q', 1, '2024-06-19', '2024-06-19'),
(7, 4, 'jacket black new 250k', 'jacket-black-new-250k', '1718730432.jpg', 1, 250000, 'q', 1, '2024-06-19', '2024-06-19'),
(8, 4, 'jacket black white 250k', 'jacket-black-white-250k', '1718730453.jpg', 1, 250000, '', 1, '2024-06-19', '2024-06-19'),
(9, 4, 'jacket black zipper 250k', 'jacket-black-zipper-250k', '1718730502.jpg', 1, 250000, 'q', 1, '2024-06-19', '2024-06-19'),
(10, 4, 'jacket blue 250k', 'jacket-blue-250k', '1718730668.jpg', 1, 250000, '', 1, '2024-06-19', '2024-06-19'),
(11, 4, 'jacket blue two 250k', 'jacket-blue-two-250k', '1718730696.jpg', 1, 250000, '', 1, '2024-06-19', '2024-06-19'),
(12, 4, 'jacket bomber black brown 250k', 'jacket-bomber-black-brown-250k', '1718730749.jpg', 1, 250000, '', 1, '2024-06-19', '2024-06-19'),
(13, 4, 'jacket bomber brown 250k', 'jacket-bomber-brown-250k', '1718730778.jpg', 1, 250000, '', 1, '2024-06-19', '2024-06-19'),
(14, 1, 'jacket bomber n 250k', 'jacket-bomber-n-250k', '1718730815.jpg', 1, 250000, '', 1, '2024-06-19', '2024-06-19'),
(15, 5, 'kaos abu new 100k', 'kaos-abu-new-100k', '1718730864.jpg', 1, 100000, '', 1, '2024-06-19', '2024-06-19'),
(16, 1, 'kaos black donald 100k', 'kaos-black-donald-100k', '1718730883.jpg', 1, 100000, '', 1, '2024-06-19', '2024-06-19'),
(17, 5, 'kaos blue 100k', 'kaos-blue-100k', '1718730906.jpg', 1, 100000, '', 1, '2024-06-19', '2024-06-19'),
(18, 5, 'kaos blue japan 100k', 'kaos-blue-japan-100k', '1718730932.jpg', 1, 100000, '', 1, '2024-06-19', '2024-06-19'),
(19, 5, 'kaos  brown100k', 'kaos-brown100k', '1718730951.jpg', 1, 100000, '', 1, '2024-06-19', '2024-06-19'),
(20, 5, 'kaos corak random 100k', 'kaos-corak-random-100k', '1718730977.jpg', 1, 250000, '', 1, '2024-06-19', '2024-06-19'),
(21, 5, 'kaos harimau 100k', 'kaos-harimau-100k', '1718731065.jpg', 1, 100000, '', 1, '2024-06-19', '2024-06-19'),
(22, 5, 'kaos samurai 100k', 'kaos-samurai-100k', '1718731086.jpg', 1, 100000, '', 1, '2024-06-19', '2024-06-19'),
(23, 5, 'kaos tom jerry 100k', 'kaos-tom-jerry-100k', '1718731185.jpg', 1, 100000, '', 1, '2024-06-19', '2024-06-19'),
(24, 6, 'sweater chess 275k', 'sweater-chess-275k', '1718731228.jpg', 1, 275000, '', 1, '2024-06-19', '2024-06-19'),
(25, 6, 'sweater crewneck cream 275k', 'sweater-crewneck-cream-275k', '1718731251.jpg', 1, 275000, '', 1, '2024-06-19', '2024-06-19'),
(26, 6, 'sweater crewneck star wars 275k', 'sweater-crewneck-star-wars-275k', '1718731299.jpg', 1, 275000, '', 1, '2024-06-19', '2024-06-19'),
(27, 11, 'dress 300k', 'dress-300k', '1718731328.jpg', 1, 300000, '', 1, '2024-06-19', '2024-06-19'),
(28, 11, 'dress 2 300k', 'dress-2-300k', '1718731351.jpg', 1, 300000, '', 1, '2024-06-19', '2024-06-19'),
(29, 11, 'dress 3 300k', 'dress-3-300k', '1718731436.jpg', 1, 300000, '', 1, '2024-06-19', '2024-06-19'),
(30, 11, 'dress 4 300k', 'dress-4-300k', '1718731454.jpg', 1, 300000, '', 1, '2024-06-19', '2024-06-19'),
(31, 11, 'dress 5 300k', 'dress-5-300k', '1718731482.jpg', 1, 300000, '', 1, '2024-06-19', '2024-06-19'),
(32, 11, 'dress 7 300k', 'dress-7-300k', '1718731509.jpg', 1, 300000, '', 1, '2024-06-19', '2024-06-19'),
(33, 11, 'dress 8 300k', 'dress-8-300k', '1718731545.jpg', 1, 300000, '', 1, '2024-06-19', '2024-06-19'),
(34, 12, 'kaos 1 125k', 'kaos-1-125k', '1718731648.jpg', 1, 125000, '', 1, '2024-06-19', '2024-06-19'),
(35, 12, 'kaos 2 125k', 'kaos-2-125k', '1718731710.jpg', 1, 125000, '', 1, '2024-06-19', '2024-06-19'),
(36, 12, 'kaos 3 125k', 'kaos-3-125k', '1718731732.jpg', 1, 125000, '', 1, '2024-06-19', '2024-06-19'),
(37, 12, 'kaos 4 125k', 'kaos-4-125k', '1718731749.jpg', 1, 125000, '', 1, '2024-06-19', '2024-06-19'),
(38, 12, 'kaos 5 125k', 'kaos-5-125k', '1718731770.jpg', 1, 125000, '', 1, '2024-06-19', '2024-06-19'),
(39, 12, 'kaos 6 125k', 'kaos-6-125k', '1718731792.jpg', 1, 125000, '', 1, '2024-06-19', '2024-06-19'),
(40, 12, 'kaos 7 125k', 'kaos-7-125k', '1718731816.jpg', 1, 125000, '', 1, '2024-06-19', '2024-06-19'),
(41, 12, 'kaos 15 125k', 'kaos-15-125k', '1718731871.jpg', 1, 125000, '', 1, '2024-06-19', '2024-06-19'),
(42, 12, 'kaos 14 125k', 'kaos-14-125k', '1718731893.jpg', 1, 125000, '', 1, '2024-06-19', '2024-06-19'),
(43, 12, 'kaos 13 125k', 'kaos-13-125k', '1718731910.jpg', 1, 125000, '', 1, '2024-06-19', '2024-06-19'),
(44, 12, 'kaos 12 125k', 'kaos-12-125k', '1718731943.jpg', 1, 125000, '', 1, '2024-06-19', '2024-06-19'),
(45, 12, 'kaos 11 125k', 'kaos-11-125k', '1718731963.jpg', 1, 125000, '', 1, '2024-06-19', '2024-06-19'),
(46, 12, 'kaos 10 125k', 'kaos-10-125k', '1718731987.jpg', 1, 125000, '', 1, '2024-06-19', '2024-06-19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `searchs`
--

CREATE TABLE `searchs` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `view` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `invoice` varchar(128) NOT NULL,
  `total` double NOT NULL,
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `invoice`, `total`, `created`, `modified`) VALUES
(1, 2, 'INV202406170001', 100000, '2024-06-17', '2024-06-17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions_details`
--

CREATE TABLE `transactions_details` (
  `id` int(11) UNSIGNED NOT NULL,
  `tran_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transactions_details`
--

INSERT INTO `transactions_details` (`id`, `tran_id`, `product_id`, `qty`, `price`) VALUES
(1, 1, 5, 1, 100000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `phone` varchar(24) NOT NULL,
  `birth` date DEFAULT NULL,
  `gender` varchar(8) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(64) NOT NULL,
  `role` varchar(64) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `birth`, `gender`, `address`, `password`, `role`, `status`) VALUES
(1, 'admin', 'admin@gmail.com', '1234567890', '1970-01-01', 'm', 'idjfi', 'b102ce1d5eebac2b6d74bda8c87c47a050c80491', 'admin', 1),
(2, 'dede', 'dede@gmail.com', '08987654321', '1970-01-01', 'm', 'k', 'caa1c169e6f2b673711faa838aba10533ab6fb02', 'user', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `searchs`
--
ALTER TABLE `searchs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transactions_details`
--
ALTER TABLE `transactions_details`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `searchs`
--
ALTER TABLE `searchs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `transactions_details`
--
ALTER TABLE `transactions_details`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
