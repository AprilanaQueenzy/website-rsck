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
-- Struktur dari tabel `poliklinik`
--

CREATE TABLE `poliklinik` (
  `id_poli` varchar(10) NOT NULL,
  `nama_poli` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `poliklinik`
--

INSERT INTO `poliklinik` (`id_poli`, `nama_poli`) VALUES
('P001', 'POLI ANAK'),
('P002', 'POLI ANASTHESI'),
('P003', 'POLI BEDAH MULUT'),
('P004', 'POLI BEDAH UMUM'),
('P005', 'POLI BEDAH UROLOGI'),
('P006', 'POLI GIGI KONSERVASI'),
('P007', 'POLI GIGI PROSTHODONTI'),
('P008', 'POLI GIGI SPESIALIS ORTHODONTI'),
('P009', 'POLI GIGI UMUM'),
('P010', 'POLI GIZI'),
('P011', 'POLI JANTUNG'),
('P012', 'POLI KULIT DAN KECANTIKAN'),
('P013', 'POLI MATA'),
('P014', 'POLI OBGYN'),
('P015', 'POLI ORTHOPEDI'),
('P016', 'POLI PENYAKIT DALAM'),
('P017', 'POLI REHAB MEDIK'),
('P018', 'POLI SARAF'),
('P019', 'POLI SPESIALIS KESEHATAN GIGI ANAK'),
('P020', 'POLI THT'),
('P021', 'POLI KEDOKTERAN JIWA'),
('P022', 'POLI PARU');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `poliklinik`
--
ALTER TABLE `poliklinik`
  ADD PRIMARY KEY (`id_poli`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
