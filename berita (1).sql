-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 01 Okt 2026 pada 04.08
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
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `id` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `tanggal` varchar(50) NOT NULL,
  `konten` text NOT NULL,
  `foto` varchar(500) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `berita`
--

INSERT INTO `berita` (`id`, `judul`, `tanggal`, `konten`, `foto`, `created_at`) VALUES
(1, 'OHOHOOHOOHOHHOOHOH', '2026-09-24', 'WKWKWKKWWKWKDKWDWKKKKWFKMASKMFKMASKMFKAMSKFNSAMKFMSAKNFOMSDNASFBFNSDANFJ FKSNLLDSKFNFKNDSKFKDSNFMDKNFAMKFNJOSDLPFMXK LK KMLK CXKS VM XM M VDKFMDKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKFSKAFMKSMKFMSKAMFKSMFKSMKFIONIFMOQK20RK0I0IEWQPDKS,ALDLS,AL,DLSA,DLSA,LDLS,DLAS,', '1790219606_bpjskesehatan.jpeg', '2026-09-24 03:13:26'),
(2, 'AKDOWAKODKWAOKDOAKDOA', '2026-09-24', 'F,SAVMMAMVASVAVASSA', '1790219643_tzuchilogo.png', '2026-09-24 03:14:03'),
(3, 'MEOKOMGOMMGKOAMGPMDG', '2026-09-24', 'GDSGGEWGDSG', '1790219881_biggy.jpeg', '2026-09-24 03:18:01'),
(4, 'MSP2O0WURJRFWIAIJCJEDMDMWLSMFSFLKMFKSMKAWKSDMLLKEFKFPWPW', '2026-09-20', 'FSAFGAGDAGAGA', '1790219915_daai.jpeg', '2026-09-24 03:18:35'),
(5, 'mfkodsmioqemfmq', '2026-09-27', 'afsafasfasfasfas', '1790219980_cws.jpeg', '2026-09-24 03:19:40'),
(6, 'minbcessswsser', '2026-09-25', 'hndgngdnsfnfsn', '1790230988_jasaraharja.jpeg', '2026-09-24 06:23:08'),
(7, 'gregggdgegsga', '2026-09-13', 'gesgdgdsgdsgoimominiufhhd7snfvmdsmvksmvmomvkjdiimalkfmksnfmods,k,c', '1790233016_sinarmas.png', '2026-09-24 06:56:56');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
