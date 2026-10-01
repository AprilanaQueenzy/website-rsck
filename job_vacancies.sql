-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 01 Okt 2026 pada 04.09
-- Versi server: 8.4.3
-- Versi PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `db_rumahsakit`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_vacancies`
--

CREATE TABLE `job_vacancies` (
  `id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `employment_type` varchar(50) DEFAULT 'Penuh Waktu',
  `description` text NOT NULL,
  `requirements` text NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data untuk tabel `job_vacancies`
--

INSERT INTO `job_vacancies` (`id`, `title`, `department`, `location`, `employment_type`, `description`, `requirements`, `is_active`, `created_at`, `updated_at`) VALUES
(15, 'Kasir', 'Keuangan', 'Perumahan Cinta Kasih Tzu Chi, Jl. Kamal Raya Outer Ring Road, Cengkareng Timur, Jakarta Barat 11730', 'Penuh Waktu', 'Melayani', '1\r\n2\r\n1', 1, '2026-09-24 07:00:31', '2026-09-25 04:33:17'),
(16, 'weq', 'qwe', 'Perumahan Cinta Kasih Tzu Chi, Jl. Kamal Raya Outer Ring Road, Cengkareng Timur, Jakarta Barat 11730', 'Penuh Waktu', 'wqe', '23\r\n32', 1, '2026-09-25 04:40:03', '2026-09-28 03:43:58'),
(17, 'Maintanance', 'Sarpras', 'Perumahan Cinta Kasih Tzu Chi, Jl. Kamal Raya Outer Ring Road, Cengkareng Timur, Jakarta Barat 11730', 'Penuh Waktu', 'w', 'Bisa Kerja\r\nBisa Jujur', 1, '2026-09-28 06:29:27', '2026-09-28 06:29:27');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `job_vacancies`
--
ALTER TABLE `job_vacancies`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `job_vacancies`
--
ALTER TABLE `job_vacancies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
