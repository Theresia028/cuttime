-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Apr 2022 pada 18.39
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `socmed`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `follow`
--

CREATE TABLE `follow` (
  `id_user` int(20) NOT NULL,
  `id_user_follow` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `follow`
--

INSERT INTO `follow` (`id_user`, `id_user_follow`) VALUES
(4, 5),
(5, 10),
(4, 9),
(4, 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `photos`
--

CREATE TABLE `photos` (
  `id_photos` int(20) NOT NULL,
  `id_user` int(20) DEFAULT NULL,
  `nama_photos` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `keterangan` varchar(256) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `photos`
--

INSERT INTO `photos` (`id_photos`, `id_user`, `nama_photos`, `keterangan`) VALUES
(26, 4, 'senja.jpg', 'ketenangan dapat dimiliki oleh siapa yang mengerti ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(20) NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `alamat` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `no_hp` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `tempat_lahir` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `photos` varchar(100) COLLATE utf8_bin NOT NULL,
  `level` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `email`, `alamat`, `no_hp`, `tgl_lahir`, `tempat_lahir`, `photos`, `level`, `password`) VALUES
(4, 'Theresia', 'user123@gmail.com', 'Malang', '0851234598761', '1999-04-12', 'madura', 'me.jpg', 'user', '$2y$10$CarU52x2vSdhDWqG3yCnJeklHUwqMZxCmbMyMWev7aIPu1MMbkB92'),
(5, 'maman sutarman', 'maman@gmail.com', 'jln. sudirman', '089123456788', '2021-11-24', 'Mojokerto', 'laki02.jpg', 'user', '$2y$10$YTTTuZj65HZyUi8Fh9Ue4.JcalEVPE6N2JAMHSw6a5vYuNAGBYDNe'),
(9, 'dika satu', 'dika@gmail.com', 'jln. sukijan', '08123456789', '2021-11-18', 'madura', 'laki1.jpg', 'user', '$2y$10$V0QmTTD9XRsLScJf5nn/YO3F150dN4sgK/6H1omJGeIEnk.zvhf0O'),
(10, 'dino', 'dino@gmail.com', 'jln. patimura', '085215007503', '2021-11-23', 'Mojokerto', '1.png', 'user', '$2y$10$aRv1ZM241F2Un4p8aL3P5.x2eenwc12vnlMHeI5ltT0pj1IwQhjHO'),
(12, 'dono', 'dono@gmail.com', 'Jln. sunandar', '0812959498459', '2021-11-19', 'bandung', 'dono.jpeg', 'user', '$2y$10$UhV9/bLcDFQCnXRycD.vLePKTJqqXzcCo6DKmpWc0XiM7ipKgbkjG'),
(15, 'there', 'there@gmail.com', 'Jember', '089697770338', '2000-02-08', 'Probolinggo', 'hh.jpg', 'admin', '$2y$10$n0lotBRBaWIxq4DbetZ2DufbZoRPfv1piqie.HwgiPVmDM1J8p51G');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `follow`
--
ALTER TABLE `follow`
  ADD KEY `id_user_follow` (`id_user_follow`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id_photos`),
  ADD KEY `id_user2` (`id_user`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `photos`
--
ALTER TABLE `photos`
  MODIFY `id_photos` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `follow_ibfk_1` FOREIGN KEY (`id_user_follow`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `follow_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
