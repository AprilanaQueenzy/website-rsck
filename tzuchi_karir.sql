-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 28 Sep 2026 pada 07.33
-- Versi server: 5.7.24
-- Versi PHP: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tzuchi_karir`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'rsck', '$2y$10$ETsR8l.kJyZJvctOhFA27eRV9zT3AtuSfXYSib609M3nIHPuiBIU.', '2026-09-24 07:54:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `applied_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `full_name` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `resume_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `applications`
--

INSERT INTO `applications` (`id`, `job_id`, `applied_at`, `full_name`, `phone`, `email`, `resume_path`) VALUES
(11, 16, '2026-09-28 02:36:27', 'Devin Manggalaputta', '213131312', 'manggalaputtadevin@gmail.com', 'uploads/1790562987_midtransphpmaster.zip'),
(12, 17, '2026-09-28 06:30:18', 'Agus', '123123', 'agus1232@gmail.com', 'uploads/1790577018_midtransphpmaster.zip');

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_vacancies`
--

CREATE TABLE `job_vacancies` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `employment_type` varchar(50) DEFAULT 'Penuh Waktu',
  `description` text NOT NULL,
  `requirements` text NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `job_vacancies`
--

INSERT INTO `job_vacancies` (`id`, `title`, `department`, `location`, `employment_type`, `description`, `requirements`, `is_active`, `created_at`, `updated_at`) VALUES
(15, 'Kasir', 'Keuangan', 'Perumahan Cinta Kasih Tzu Chi, Jl. Kamal Raya Outer Ring Road, Cengkareng Timur, Jakarta Barat 11730', 'Penuh Waktu', 'Melayani', '1\r\n2\r\n1', 1, '2026-09-24 07:00:31', '2026-09-25 04:33:17'),
(16, 'weq', 'qwe', 'Perumahan Cinta Kasih Tzu Chi, Jl. Kamal Raya Outer Ring Road, Cengkareng Timur, Jakarta Barat 11730', 'Penuh Waktu', 'wqe', '23\r\n32', 1, '2026-09-25 04:40:03', '2026-09-28 03:43:58'),
(17, 'Maintanance', 'Sarpras', 'Perumahan Cinta Kasih Tzu Chi, Jl. Kamal Raya Outer Ring Road, Cengkareng Timur, Jakarta Barat 11730', 'Penuh Waktu', 'w', 'Bisa Kerja\r\nBisa Jujur', 1, '2026-09-28 06:29:27', '2026-09-28 06:29:27');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `job_vacancies`
--
ALTER TABLE `job_vacancies`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `job_vacancies`
--
ALTER TABLE `job_vacancies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
