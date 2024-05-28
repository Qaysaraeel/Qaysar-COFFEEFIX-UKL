-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Bulan Mei 2024 pada 06.21
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
-- Database: `coffee`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kontak`
--

CREATE TABLE `kontak` (
  `id_pesan` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `pesan` varchar(300) NOT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kontak`
--

INSERT INTO `kontak` (`id_pesan`, `username`, `email`, `pesan`, `id_user`) VALUES
(34, 'qaesyaar', 'qaysaraqeel71@gmail.com', 'mantap banget coy sangat bagus', 3),
(40, 'COBA', 'COBA@GMAIL.COM', 'TIDAK ADA MANTAP POKONYAAA', 26),
(41, 'Asep Thiago', 'asepthiago99@gmail.com', 'Website tidak ada bug mantap', 27),
(42, 'user', 'qaysaraqeel71@gmail.com', 'Websita yang bagus bagus bagus', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(30) NOT NULL,
  `harga_produk` varchar(11) NOT NULL,
  `gambar_produk` varchar(255) DEFAULT NULL,
  `kategori` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id_produk`, `nama_produk`, `harga_produk`, `gambar_produk`, `kategori`) VALUES
(11, 'MACCHIATO COFFEE', '20000', '664f1c189a397.png', 'coffee'),
(12, 'CARAMEL COFFEE', '20000', '664c8ea075098.png', 'coffee'),
(13, 'FRAPPE COFFEE', '22000', '664c8eaaa9ca7.png', 'coffee'),
(14, 'ESPRESSO COFFEE', '18000', '664c8eb49cec2.png', 'coffee'),
(15, 'MILK COFFEE', '18000', '664c8ec195eeb.png', 'coffee'),
(16, 'FRAPUCCINO COFFEE', '20000', '664c8ecae0d84.png', 'coffee'),
(20, 'MACCA LATTE', '27000', '664c986eadd00.png', 'coffee'),
(30, 'Cromboloni coklat', '26000', '664f867a754d9.png', 'makanan'),
(31, 'kentang goreng', '16000', '664f890a2ab20.png', 'makanan'),
(32, 'croffle', '28000', '664f8a5c162f8.png', 'makanan'),
(33, 'chessecake', '34000', '664f8af33f2ab.png', 'makanan'),
(34, 'pancake', '33000', '664f8b640d17f.png', 'makanan'),
(35, 'LEMON TEA', '13000', '6652e5c014446.png', 'non-coffee'),
(36, 'CHOCOLATTE MILK', '19000', '6652e796bdb5e.png', 'non-coffee'),
(37, 'Sandwich', '23000', '665407383d677.png', 'makanan'),
(38, 'Hamburger', '38000', '6654076cb956c.png', 'makanan'),
(39, 'Spagetti', '37000', '665407bbf2178.png', 'makanan'),
(40, 'Wedhang jahe', '21000', '66540899bcac2.png', 'non-coffee'),
(41, 'Citrus Splash', '18000', '66540909ce449.png', 'non-coffee'),
(42, 'Chicken Wings', '33000', '6654096e121bc.png', 'makanan'),
(43, 'Creamy Dream Latte', '27000', '66540a0313aea.png', 'coffee'),
(44, 'Es cendol dawet', '20000', '66540a328407c.png', 'non-coffee');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rating`
--

CREATE TABLE `rating` (
  `id_rating` int(11) NOT NULL,
  `rating` int(1) NOT NULL,
  `username` varchar(30) NOT NULL,
  `pesan` varchar(255) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rating`
--

INSERT INTO `rating` (`id_rating`, `rating`, `username`, `pesan`, `id_user`, `foto_profil`) VALUES
(14, 5, 'nugraha', 'Cafe Coffee Modern menawarkan kualitas kopi premium dengan suasana yang modern dan nyaman.', 22, '664d850868307.jpeg'),
(16, 4, 'aathar', 'Tempat yang hebat untuk menikmati kopi yang lezat dalam suasana yang menyenangkan.', 4, '664e2d669d3dd.jpeg'),
(17, 5, 'qaesyaar', 'Their coffee is fresh and diverse, the atmosphere is cozy, and the service is friendly.', 3, '664dfbfbb7150.jpg'),
(21, 5, 'Asep Thiago', 'MENU MENU NYA ENAK ENAK BANEGT SUKA POKONYA!', 27, '665096e8df6c2.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `total_transaksi` varchar(11) NOT NULL,
  `metode_transaksi` varchar(20) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `jumlah` varchar(11) DEFAULT NULL,
  `waktu_transaksi` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_user`, `id_produk`, `total_transaksi`, `metode_transaksi`, `tanggal_transaksi`, `jumlah`, `waktu_transaksi`) VALUES
(14, 23, 12, '40000', 'Cash', '2024-05-23', '2', '19:50:00'),
(15, 23, 20, '135000', 'Cash', '2024-05-23', '5', '19:51:00'),
(16, 23, 15, '54000', 'Cash', '2024-05-23', '3', '20:04:00'),
(17, 24, 11, '100000', 'Cash', '2024-05-23', '5', '20:22:00'),
(18, 24, 20, '216000', 'Cash', '2024-05-23', '8', '20:22:00'),
(19, 24, 12, '60000', 'Cash', '2024-05-23', '3', '20:22:00'),
(20, 26, 20, '108000', 'Credit', '2024-05-23', '4', '20:26:00'),
(21, 26, 15, '72000', 'Cash', '2024-05-23', '4', '20:26:00'),
(22, 26, 12, '60000', 'Debit', '2024-05-23', '3', '20:26:00'),
(23, 3, 34, '66000', 'Cash', '2024-05-24', '2', '12:26:00'),
(24, 3, 33, '102000', 'Cash', '2024-05-24', '3', '12:33:00'),
(25, 3, 14, '54000', 'Cash', '2024-05-24', '3', '12:35:00'),
(27, 27, 32, '84000', 'Cash', '2024-05-24', '3', '20:32:00'),
(28, 27, 30, '130000', 'Debit', '2024-05-24', '5', '20:33:00'),
(29, 27, 31, '48000', 'Cash', '2024-05-24', '3', '20:33:00'),
(30, 27, 20, '81000', 'Cash', '2024-05-24', '3', '20:33:00'),
(31, 27, 34, '132000', 'Debit', '2024-05-24', '4', '20:33:00'),
(32, 2, 11, '20000', 'Cash', '2024-05-26', '1', '16:01:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `level` varchar(5) NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `level`, `foto_profil`) VALUES
(1, 'admin', 'admin', 'qaysaraqeel71@gmail.com', 'admin', '664eab34eeb25.jpg'),
(2, 'user', 'user', 'qaysaraqeel71@gmail.com', 'user', '664d9aafcf9f2.jpg'),
(3, 'qaesyaar', 'qaesyaar', 'qaysaraqeel71@gmail.com', 'user', '664dfbfbb7150.jpg'),
(4, 'aatharnibos', 'aathar', 'qaysaraqeel71@gmail.com', 'user', '664e31454ca4c.jpeg'),
(21, 'ben', 'ben', 'ben@gmail.com', 'user', '664d88021e546.jpg'),
(22, 'Jean Messi', '123', 'nugraha@gmail.com', 'user', '664d850868307.jpeg'),
(23, 'felilulu', '123', 'felilulu@gmail.com', 'user', '664f154392619.jpg'),
(24, 'ALHAMDULILLAH', '123', 'DEMO@GMAIL.COM', 'user', '664f979b5528d.jpg'),
(25, 'DEMOWEBSITE', '123', 'DEMO@GMAIL.COM', 'user', '664f977d185c9.jpg'),
(26, 'COBA', '123', 'COBA@GMAIL.COM', 'user', '664f43df4e9ab.jpeg'),
(27, 'Asep Thiago', 'asep', 'asepthiago99@gmail.com', 'user', '665096e8df6c2.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id_pesan`),
  ADD KEY `fk_kontak_relation_user` (`id_user`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id_rating`),
  ADD KEY `fk_rating_relation_user` (`id_user`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `fk_transaksi_relation_user` (`id_user`),
  ADD KEY `fk_transaksi_relation_products` (`id_produk`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `rating`
--
ALTER TABLE `rating`
  MODIFY `id_rating` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kontak`
--
ALTER TABLE `kontak`
  ADD CONSTRAINT `fk_kontak_relation_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `fk_rating_relation_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_transaksi_relation_products` FOREIGN KEY (`id_produk`) REFERENCES `products` (`id_produk`),
  ADD CONSTRAINT `fk_transaksi_relation_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
