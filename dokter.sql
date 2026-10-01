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
-- Struktur dari tabel `dokter`
--

CREATE TABLE `dokter` (
  `id_dokter` varchar(10) NOT NULL,
  `id_poli` varchar(10) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `spesialis` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `dokter`
--

INSERT INTO `dokter` (`id_dokter`, `id_poli`, `nama`, `spesialis`, `foto`) VALUES
('D001', 'P001', 'Amelia, Sp.A, dr.', 'Spesialis Anak', 'photo/D001.jpg'),
('D002', 'P001', 'Andhika Tiurmaida Hutapea, Sp.A, dr.', 'Spesialis Anak', 'img/default-doctor.jpg'),
('D003', 'P001', 'Cunito Apryanto, Sp.A, dr.', 'Spesialis Anak', 'photo/D003.jpg'),
('D004', 'P001', 'Iskandar, Sp.A, dr.', 'Spesialis Anak', 'photo/D004.jpg'),
('D005', 'P001', 'Khrisanti Dinata, Sp. A, dr.', 'Spesialis Anak', 'photo/D005.jpg'),
('D006', 'P001', 'Ronny Khrisnanda Rahardja, Sp.A, dr.', 'Spesialis Anak', 'img/default-doctor.jpg'),
('D007', 'P002', 'Jancolin Yani Sp.An-TI, dr.', 'Spesialis Anasthesi', 'photo/D007.jpg'),
('D008', 'P002', 'Muhammad Okyno, Sp.An, dr.', 'Spesialis Anasthesi', 'photo/D008.jpg'),
('D009', 'P002', 'Putu Sudarsana, Sp. An, dr.', 'Spesialis Anasthesi', 'photo/D009.jpg'),
('D010', 'P003', 'Rezky Amelia Ramadhani Putri Sjafruddin Marmin, Sp.BMM, drg.', 'Spesialis bedah Mulut', 'photo/D010.jpg'),
('D011', 'P004', 'Ida Bagus Darmasusila, Sp.B.-ET, dr.', 'Spesialis Bedah Umum', 'photo/D012.jpg'),
('D012', 'P004', 'Jefri Wijaya, Sp.B.-ET, dr.', 'Spesialis Bedah Umum', 'photo/D013.jpg'),
('D013', 'P004', 'Melina Oktavia Kurniawan, Sp. B.-ET, dr.', 'Spesialis Bedah Umum', 'photo/D014.jpg'),
('D014', 'P004', 'Michael Iskandar Zhang, Sp.B.-ET, AIFO-K, FICS, FINACS....', 'Spesialis Bedah Umum', 'photo/D015.jpg'),
('D015', 'P005', 'Stevano Lucianto Hotasi Sipahutar, Sp.U, FICRS, dr.', 'Spesialis Urologi', 'photo/D016.jpg'),
('D016', 'P006', 'Abdil Tio, Sp. KG, drg.', 'Spesialis Gigi Konservasi', 'img/default-doctor.jpg'),
('D017', 'P006', 'Mellisa, Sp.KG,drg.', 'Spesialis Gigi Konservasi', 'img/default-doctor.jpg'),
('D018', 'P007', 'Delidanti, Sp.Pros.,drg.', 'Spesialis Prosthodonti', 'photo/D020.jpg'),
('D019', 'P008', 'Linda Verniati, Sp.Ortho, drg.', 'Spesialis Orthodonti', 'img/default-doctor.jpg'),
('D020', 'P008', 'Rini Susanti, Sp.Ortho, drg.', 'Spesialis Orthodonti', 'img/default-doctor.jpg'),
('D021', 'P009', 'Ernywaty, drg.', 'Spesialis Gigi Umum', 'img/default-doctor.jpg'),
('D022', 'P009', 'Karina Iskandar, M.M, drg.', 'Spesialis Gigi Umum', 'img/default-doctor.jpg'),
('D023', 'P009', 'Than Anggita Vica, drg.', 'Spesialis Gigi Umum', 'photo/D026.jpg'),
('D024', 'P009', 'Theresia Avrilawati Wangsa, drg.', 'Spesialis Gigi Umum', 'photo/D027.jpg'),
('D025', 'P010', 'Natalia Emmy Luciana, MS, Sp. GK, dr.', 'Spesialis Gizi Klinik', 'photo/D029.jpg'),
('D026', 'P011', 'Agill Agassi Tsalitsa, Sp.JP, FIHA, dr.', 'Spesialis Jantung', 'img/default-doctor.jpg'),
('D027', 'P012', 'Audi Sugiharto, Sp.D.V.E, dr.', 'Spesialis Dermatologi & Venereologi', 'photo/D030.jpg'),
('D028', 'P012', 'Deasy Thio, Sp.D.V.E, FINSDV, FAADV, dr.', 'Spesialis Dermatologi & Venereologi', 'photo/D031.jpg'),
('D029', 'P012', 'Evelyn,Sp.D.V.E,dr.', 'Spesialis Dermatologi & Venereologi', 'photo/D032.jpg'),
('D030', 'P012', 'Michael Rolimpandoei, MBBS, Sp.DVE, dr.', 'Spesialis Dermatologi & Venereologi', 'img/default-doctor.jpg'),
('D031', 'P013', 'Airina Stefanie, Sp.M, dr.', 'Spesialis Mata', 'photo/D034.jpg'),
('D032', 'P013', 'Esti Wardhani, Sp.M, dr.', 'Spesialis Mata', 'photo/D035.jpg'),
('D033', 'P013', 'Grace, Sp.M, dr.', 'Spesialis Mata', 'photo/D036.jpg'),
('D034', 'P013', 'Vincent Wang Tahija, Sp.M, dr.', 'Spesialis Mata', 'photo/D037.jpg'),
('D035', 'P013', 'Calista Nathasya Gunawan, Sp.M, dr.', 'Spesialis Mata', 'img/default-doctor.jpg'),
('D036', 'P013', 'Gladys, Sp.M, dr.', 'Spesialis Mata', 'img/default-doctor.jpg'),
('D037', 'P014', 'Andri Hondir, SpOG, FMIGS, Int. Aff. RANZCOG, dr.', 'Spesialis Obstetri & Ginekologi', 'photo/D038.jpg'),
('D038', 'P014', 'Jennifer Uriah, Sp. OG, dr.', 'Spesialis Obstetri & Ginekologi', 'photo/D039.jpg'),
('D039', 'P014', 'Johanes Benarto, Sp.OG, dr.', 'Spesialis Obstetri & Ginekologi', 'photo/D040.jpg'),
('D040', 'P014', 'Rino Apin, Sp. OG, dr.', 'Spesialis Obstetri & Ginekologi', 'photo/D041.jpg'),
('D041', 'P015', 'Anastasia Pranoto, Sp. OT, dr.', 'Spesialis Orthopedi', 'photo/D042.jpg'),
('D042', 'P015', 'Nico Raga, Sp.OT , dr.', 'Spesialis Orthopedi', 'photo/D043.jpg'),
('D043', 'P016', 'Ardy, Sp.PD, dr.', 'Spesialis Penyakit Dalam', 'photo/D044.jpg'),
('D044', 'P016', 'Hardy Indradi, Sp.PD, dr.', 'Spesialis Penyakit Dalam', 'photo/D045.jpg'),
('D045', 'P016', 'Harris Hardian, Sp. PD, dr.', 'Spesialis Penyakit Dalam', 'photo/D046.jpg'),
('D046', 'P016', 'Silvister Nancy, Sp.PD, dr.', 'Spesialis Penyakit Dalam', 'photo/D047.jpg'),
('D047', 'P016', 'Syarif Hidayat, Sp PD, dr.', 'Spesialis Penyakit Dalam', 'photo/D048.jpg'),
('D048', 'P016', 'Toar Lendy Runtuwene, MKes, Sp.PD, FINASIM, dr.', 'Spesialis Penyakit Dalam', 'img/default-doctor.jpg'),
('D049', 'P017', 'Septania Elfira Simatupang, Sp KFR, dr.', 'Spesialis Kedokteran Fisik dan Rehabilitasi', 'photo/D049.jpg'),
('D050', 'P017', 'Yosef Stefan Sutanto, Sp.K.F.R., AIFO-K, dr.', 'Spesialis Kedokteran Fisik dan Rehabilitasi', 'img/default-doctor.jpg'),
('D051', 'P018', 'Caepy Gomer, Sp.N, dr.', 'Spesialis Saraf', 'photo/D050.jpg'),
('D052', 'P018', 'Michael Carrey, Sp.N, dr.', 'Spesialis Saraf', 'photo/D051.jpg'),
('D053', 'P018', 'Steven Sakasasmita, Sp.N,dr.', 'Spesialis Saraf', 'photo/D052.jpg'),
('D054', 'P019', 'Bariah, Sp.KGA,drg.', 'Spesialis Kesehatan Gigi Anak', 'photo/D053.jpg'),
('D055', 'P019', 'Luh Putu Puspitawati, Sp.KGA, drg.', 'Spesialis Kesehatan Gigi Anak', 'img/default-doctor.jpg'),
('D056', 'P020', 'Ivana Supit, Sp.THT-BKL, dr.', 'Spesialis THT', 'photo/D054'),
('D057', 'P020', 'Muhammad Fajar Ramadhan Irsyal, Sp. THT-KL, dr.', 'Spesialis THT', 'photo/D055'),
('D058', 'P021', 'Diana Atmaja, Sp.K.J, dr.', 'Spesialis Kedokteran Jiwa', 'img/default-doctor.jpg'),
('D059', 'P021', 'Handry Carlos Gunawan, Sp.KJ, dr.', 'Spesialis Kedokteran Jiwa', 'img/default-doctor.jpg'),
('D060', 'P022', 'Peter Krisdiyanto, Sp.P, dr.', 'Spesialis Paru', 'img/default-doctor.jpg'),
('D061', 'P022', 'Christa Graziella Muljono, Sp.P, dr.', 'Spesialis Paru', 'img/default-doctor.jpg'),
('D062', 'P006', 'Theresia Peggy Haryanti, drg.', 'Sp. KG', 'photo/D019');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id_dokter`),
  ADD KEY `fk_dokter_poli` (`id_poli`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `dokter`
--
ALTER TABLE `dokter`
  ADD CONSTRAINT `fk_dokter_poli` FOREIGN KEY (`id_poli`) REFERENCES `poliklinik` (`id_poli`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
