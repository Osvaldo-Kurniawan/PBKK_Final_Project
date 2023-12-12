-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 16 Nov 2021 pada 17.44
-- Versi server: 5.7.33
-- Versi PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_penilaian`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_autentikasi`
--

CREATE TABLE `tb_autentikasi` (
  `id` bigint(20) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(60) NOT NULL,
  `role` enum('admin','manager') NOT NULL,
  `nama` varchar(25) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan','','') DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `nip` varchar(25) DEFAULT NULL,
  `pendidikan_terakhir` varchar(25) DEFAULT NULL,
  `agama` varchar(25) DEFAULT NULL,
  `no_hp` varchar(25) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_autentikasi`
--

INSERT INTO `tb_autentikasi` (`id`, `username`, `password`, `role`, `nama`, `jenis_kelamin`, `tanggal_lahir`, `nip`, `pendidikan_terakhir`, `agama`, `no_hp`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'G. I. Osvaldo Kurniawan', 'Laki-laki', '2001-05-05', '000000000000000000', 'S1 Teknik Informatika', 'Katolik', '08113552625', 'Jl. Imajinasi 0', '2023-12-12 03:24:07', '2023-12-12 03:24:07'),
(2, 'manager1', 'c240642ddef994358c96da82c0361a58', 'manager', 'Victor Gustinova', 'Laki-laki', '2003-01-07', '123456789012345669', 'S1 Teknik Informatika', 'Katolik', '087780337067', 'Jl. Imajinasi 321', '2023-12-12 03:24:07', '2023-12-12 03:24:07'),
(3, 'manager2', '8df5127cd164b5bc2d2b78410a7eea0c', 'manager', 'RR Diajeng A. A.', 'Perempuan', '2002-12-03', '987654321987654321', 'S1 Teknik Informatika', 'Islam', '08113313209', 'Jl. Imajinasi 123', '2023-12-12 03:24:07', '2023-12-12 03:24:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_data_proyek`
--

CREATE TABLE `tb_data_proyek` (
  `id_proyek` bigint(20) NOT NULL,
  `kode_proyek` varchar(10) NOT NULL,
  `proyek` varchar(26) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_data_proyek`
--

INSERT INTO `tb_data_proyek` (`id_proyek`, `kode_proyek`, `proyek`, `created_at`, `updated_at`) VALUES
(1, 'BTS', 'Proyek 1', '2023-12-12 03:24:07', '2023-12-12 03:24:07'),
(2, 'IRIS', 'Proyek 2', '2023-12-12 03:24:07', '2023-12-12 03:24:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_data_karyawan`
--

CREATE TABLE `tb_data_karyawan` (
  `id_karyawan` bigint(20) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan','','') NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nama_ibu` varchar(25) NOT NULL,
  `tahun_masuk` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_data_karyawan`
--

INSERT INTO `tb_data_karyawan` (`id_karyawan`, `nama`, `jenis_kelamin`, `tanggal_lahir`, `nama_ibu`, `tahun_masuk`, `created_at`, `updated_at`) VALUES
(1, 'Sunt maxime dolor vo', 'Laki-laki', '2000-11-16', 'Sunt maxime', '2020', '2023-12-12 03:24:07', '2023-12-12 03:24:07'),
(2, 'Amet ut ut nemo dol', 'Perempuan', '2000-10-16', 'Amet ut ut', '2020', '2023-12-12 03:24:07', '2023-12-12 03:24:07'),
(3, 'Pariatur Ipsum dolo', 'Perempuan', '2000-06-20', 'Quidem rep', '2020', '2023-12-12 03:24:07', '2023-12-12 03:24:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_data_tahun`
--

CREATE TABLE `tb_data_tahun` (
  `id_ta` bigint(20) NOT NULL,
  `tahun` varchar(15) NOT NULL,
  `semester` varchar(5) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_data_tahun`
--

INSERT INTO `tb_data_tahun` (`id_ta`, `tahun`, `semester`, `created_at`, `updated_at`) VALUES
(1, '2021', '2', '2023-12-12 03:24:07', '2023-12-12 03:24:07'),
(2, '2022', '1', '2023-12-12 03:24:07', '2023-12-12 03:24:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_nilai`
--

CREATE TABLE `tb_nilai` (
  `pekerjaan_id` bigint(20) NOT NULL,
  `karyawan_id` bigint(20) NOT NULL,
  `proyek_id` bigint(20) NOT NULL,
  `nilai` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_nilai`
--

INSERT INTO `tb_nilai` (`pekerjaan_id`, `karyawan_id`, `proyek_id`, `nilai`) VALUES
(1, 1, 1, 70),
(1, 1, 2, 80),
(1, 2, 1, 0),
(1, 2, 2, 0),
(1, 3, 1, 39),
(1, 3, 2, 50);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pekerjaan`
--

CREATE TABLE `tb_pekerjaan` (
  `id_pekerjaan` bigint(20) NOT NULL,
  `manager_id` bigint(20) NOT NULL,
  `ta_id` bigint(20) NOT NULL,
  `job` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pekerjaan`
--

INSERT INTO `tb_pekerjaan` (`id_pekerjaan`, `manager_id`, `ta_id`, `job`) VALUES
(1, 2, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pekerjaan_proyek`
--

CREATE TABLE `tb_pekerjaan_proyek` (
  `pekerjaan_id` bigint(20) NOT NULL,
  `proyek_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pekerjaan_proyek`
--

INSERT INTO `tb_pekerjaan_proyek` (`pekerjaan_id`, `proyek_id`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pekerjaan_karyawan`
--

CREATE TABLE `tb_pekerjaan_karyawan` (
  `pekerjaan_id` bigint(20) NOT NULL,
  `karyawan_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pekerjaan_karyawan`
--

INSERT INTO `tb_pekerjaan_karyawan` (`pekerjaan_id`, `karyawan_id`) VALUES
(1, 1),
(1, 2),
(1, 3);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_autentikasi`
--
ALTER TABLE `tb_autentikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_data_proyek`
--
ALTER TABLE `tb_data_proyek`
  ADD PRIMARY KEY (`id_proyek`);

--
-- Indeks untuk tabel `tb_data_karyawan`
--
ALTER TABLE `tb_data_karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indeks untuk tabel `tb_data_tahun`
--
ALTER TABLE `tb_data_tahun`
  ADD PRIMARY KEY (`id_ta`);

--
-- Indeks untuk tabel `tb_nilai`
--
ALTER TABLE `tb_nilai`
  ADD PRIMARY KEY (`pekerjaan_id`,`karyawan_id`,`proyek_id`),
  ADD KEY `tb_nilai_ibfk_3` (`karyawan_id`),
  ADD KEY `tb_nilai_ibfk_4` (`proyek_id`);

--
-- Indeks untuk tabel `tb_pekerjaan`
--
ALTER TABLE `tb_pekerjaan`
  ADD PRIMARY KEY (`id_pekerjaan`),
  ADD KEY `manager_id` (`manager_id`),
  ADD KEY `ta_id` (`ta_id`);

--
-- Indeks untuk tabel `tb_pekerjaan_proyek`
--
ALTER TABLE `tb_pekerjaan_proyek`
  ADD PRIMARY KEY (`pekerjaan_id`,`proyek_id`),
  ADD KEY `tb_pekerjaan_proyek_ibfk_1` (`proyek_id`);

--
-- Indeks untuk tabel `tb_pekerjaan_karyawan`
--
ALTER TABLE `tb_pekerjaan_karyawan`
  ADD PRIMARY KEY (`pekerjaan_id`,`karyawan_id`),
  ADD KEY `tb_pekerjaan_karyawan_ibfk_2` (`karyawan_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_autentikasi`
--
ALTER TABLE `tb_autentikasi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_data_proyek`
--
ALTER TABLE `tb_data_proyek`
  MODIFY `id_proyek` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_data_karyawan`
--
ALTER TABLE `tb_data_karyawan`
  MODIFY `id_karyawan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_data_tahun`
--
ALTER TABLE `tb_data_tahun`
  MODIFY `id_ta` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_pekerjaan`
--
ALTER TABLE `tb_pekerjaan`
  MODIFY `id_pekerjaan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_nilai`
--
ALTER TABLE `tb_nilai`
  ADD CONSTRAINT `tb_nilai_ibfk_2` FOREIGN KEY (`pekerjaan_id`) REFERENCES `tb_pekerjaan` (`id_pekerjaan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_nilai_ibfk_3` FOREIGN KEY (`karyawan_id`) REFERENCES `tb_pekerjaan_karyawan` (`karyawan_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_nilai_ibfk_4` FOREIGN KEY (`proyek_id`) REFERENCES `tb_pekerjaan_proyek` (`proyek_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pekerjaan`
--
ALTER TABLE `tb_pekerjaan`
  ADD CONSTRAINT `tb_pekerjaan_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `tb_autentikasi` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_pekerjaan_ibfk_2` FOREIGN KEY (`ta_id`) REFERENCES `tb_data_tahun` (`id_ta`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pekerjaan_proyek`
--
ALTER TABLE `tb_pekerjaan_proyek`
  ADD CONSTRAINT `tb_pekerjaan_proyek_ibfk_1` FOREIGN KEY (`proyek_id`) REFERENCES `tb_data_proyek` (`id_proyek`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_pekerjaan_proyek_ibfk_2` FOREIGN KEY (`pekerjaan_id`) REFERENCES `tb_pekerjaan` (`id_pekerjaan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pekerjaan_karyawan`
--
ALTER TABLE `tb_pekerjaan_karyawan`
  ADD CONSTRAINT `tb_pekerjaan_karyawan_ibfk_1` FOREIGN KEY (`pekerjaan_id`) REFERENCES `tb_pekerjaan` (`id_pekerjaan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_pekerjaan_karyawan_ibfk_2` FOREIGN KEY (`karyawan_id`) REFERENCES `tb_data_karyawan` (`id_karyawan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
