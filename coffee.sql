-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Jun 2024 pada 07.05
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
  `kategori` varchar(30) DEFAULT NULL,
  `deskripsi` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id_produk`, `nama_produk`, `harga_produk`, `gambar_produk`, `kategori`, `deskripsi`) VALUES
(11, 'MACCHIATO COFFEE', '20000', '664f1c189a397.png', 'coffee', 'Macchiato Coffee merupakam gabungan unik antara espresso kaya dan beraroma dengan lapisan tipis susu yang lembut di atasnya. Dengan sentuhan ini, minuman ini menawarkan pengalaman yang seimbang antara kekuatan dan kelembutan, ideal untuk dinikmati sebagai penyegar di pagi hari atau sebagai penemani di waktu istirahat.'),
(12, 'CARAMEL COFFEE', '20000', '664c8ea075098.png', 'coffee', 'Caramel Coffee menghadirkan perpaduan yang sempurna antara aroma kopi yang kaya dan manisnya karamel yang lembut. Minuman ini merupakan gabungan yang menggoda antara espresso yang kuat dengan sentuhan manis karamel yang melengkapi setiap tegukan. Dipanggang dengan cermat oleh para barista kami, Caramel Coffee menawarkan pengalaman minum kopi yang memanjakan lidah Anda dengan rasa yang lembut dan kenikmatan yang memikat. '),
(13, 'FRAPPE COFFEE', '22000', '664c8eaaa9ca7.png', 'coffee', 'Frappe Coffee adalah segelas kelezatan yang menyegarkan dan memuaskan, memberikan sensasi dingin yang menyegarkan dengan kekuatan kopi yang mendalam. Diciptakan untuk menemani hari-hari panas atau sebagai penyegar di tengah hari, Frappe Coffee menghadirkan perpaduan sempurna antara es yang lembut, kopi yang dipanggang dengan hati-hati, dan susu yang kaya.'),
(14, 'ESPRESSO COFFEE', '18000', '664c8eb49cec2.png', 'coffee', 'Espresso Coffee adalah esensi dari kopi yang murni. Dibuat dengan tekanan tinggi dan waktu ekstraksi yang singkat, espresso memiliki kekuatan dan kekentalan yang memukau. Meskipun ukurannya kecil, tetapi rasanya yang kaya dan pekat menghadirkan pengalaman kopi yang tak tertandingi. Minuman ini sering dianggap sebagai dasar dari berbagai minuman kopi lainnya. '),
(15, 'MILK COFFEE', '18000', '664c8ec195eeb.png', 'coffee', 'Milk Coffee adalah perpaduan yang lembut antara aroma kopi yang kaya dengan kelembutan susu yang memikat. Dalam minuman ini, kopi yang dipanggang dengan cermat dipadukan dengan susu hangat, menciptakan harmoni cita rasa yang menggugah selera. Dengan setiap tegukan, Anda akan merasakan sentuhan manis susu yang melengkapi kekuatan dan kompleksitas kopi.'),
(16, 'FRAPUCCINO COFFEE', '20000', '664c8ecae0d84.png', 'coffee', 'Frapuccino Coffee adalah kombinasi segar dari kopi yang menggugah dan kesegaran es. Diciptakan untuk menyegarkan hari Anda, minuman ini menghadirkan perpaduan yang sempurna antara espresso yang kuat dengan es yang lembut dan susu yang lembut. Setiap tegukan Frapuccino Coffee akan memberikan Anda sensasi menyegarkan yang membangkitkan semangat, sementara keharuman kopi yang khas tetap terasa dalam setiap goresan lidah.'),
(20, 'MACCA LATTE', '27000', '664c986eadd00.png', 'coffee', 'Macca Latte adalah reinterpretasi yang lembut dan menggoda dari klasik Latte, menambahkan sentuhan kekhasan pada pengalaman minum kopi Anda. Dibandingkan dengan Latte tradisional, Macca Latte menghadirkan nuansa yang lebih dalam dengan tambahan subtil kopi Macchiato, memberikan dimensi rasa yang lebih kompleks dan memikat.'),
(30, 'Cromboloni coklat', '26000', '664f867a754d9.png', 'makanan', 'Cromboloni Coklat adalah sajian istimewa yang memikat dengan rasa manis dan kelembutan. Setiap gigitan membawa sensasi luar biasa dari kombinasi adonan lembut yang digoreng dengan sempurna dan isian coklat yang melimpah. Dibuat dengan cinta dan keahlian, Cromboloni Coklat menghadirkan kelezatan yang tak terlupakan, menjadikannya pilihan sempurna sebagai camilan di waktu santai atau sebagai sajian penutup yang memuaskan. '),
(31, 'kentang goreng', '16000', '664f890a2ab20.png', 'makanan', 'Kentang Goreng adalah hidangan klasik yang merayakan kesederhanaan dengan cita rasa yang menggugah selera. Dipotong menjadi irisan tipis dan digoreng hingga kecokelatan yang sempurna, kentang goreng ini memanjakan lidah dengan tekstur renyah di luar dan lembut di dalam. Setiap gigitan menghadirkan kombinasi yang sempurna antara kelembutan kentang dan rasa gurih yang khas. '),
(32, 'croffle', '28000', '664f8a5c162f8.png', 'makanan', 'Croffle adalah perpaduan menarik antara croissant yang lembut dan wafel yang renyah, menciptakan sajian yang unik dan memikat. Dengan tekstur yang kaya akan lapisan-lapisan croissant yang lembut namun renyah, serta sentuhan manis wafel yang terasa di setiap gigitannya, croffle menawarkan pengalaman kuliner yang istimewa. '),
(33, 'chessecake', '34000', '664f8af33f2ab.png', 'makanan', 'Cheesecake adalah kelezatan manis yang klasik dan memikat, yang memadukan kelembutan keju dengan sentuhan manis gurih yang tak terlupakan. Dibuat dengan teliti menggunakan bahan-bahan berkualitas tinggi, cheesecake menghadirkan tekstur lembut yang meleleh di mulut, disertai dengan rasa kaya dan berlimpah. Sangat cocok sebagai hidangan penutup yang mewah atau sebagai teman setia untuk momen bersantai.'),
(34, 'pancake', '33000', '664f8b640d17f.png', 'makanan', 'Pancake adalah sajian sarapan yang ikonik dan memikat, yang menggoda dengan kelembutan dan kelezatan yang tak tertandingi. Dibuat dengan campuran tepung, telur, susu, dan mentega, pancake menghadirkan tekstur lembut di dalam dan kecokelatan yang renyah di luar. Setiap gigitan membawa sensasi manis yang memikat, disertai dengan rasa yang hangat dan menggugah selera. '),
(35, 'LEMON TEA', '13000', '6652e5c014446.png', 'non-coffee', 'Lemon Tea adalah minuman yang menyegarkan dan memikat, yang menggabungkan keharuman teh dengan kesegaran dari perasan lemon. Dibuat dengan menyeduh teh dengan air mendidih dan menambahkan irisan lemon segar serta sedikit pemanis, Lemon Tea menghadirkan kombinasi yang seimbang antara rasa ringan dan aroma yang menyegarkan. '),
(36, 'CHOCOLATTE MILK', '19000', '6652e796bdb5e.png', 'non-coffee', 'Chocolatte Milk adalah minuman indulgensi yang memikat, yang memadukan kelezatan cokelat dengan kelembutan susu yang memuaskan. Dibuat dengan campuran cokelat yang kaya dan susu hangat yang lembut, Chocolatte Milk menghadirkan sensasi manis yang memanjakan lidah Anda. Setiap tegukan membawa cita rasa cokelat yang lezat, disertai dengan kelembutan susu yang melimpah, menciptakan kombinasi yang sempurna dari manis dan kreami. '),
(37, 'Sandwich', '23000', '665407383d677.png', 'makanan', 'Sandwich adalah sajian yang praktis dan serbaguna, yang terdiri dari lapisan roti yang diisi dengan beragam bahan yang lezat. Dari kombinasi klasik seperti daging, keju, dan sayuran, hingga varian yang lebih kreatif seperti roti panggang dengan selai atau abu-abu makanan yang baru, sandwich menawarkan berbagai pilihan rasa dan tekstur. Setiap gigitan membawa sensasi yang memuaskan, dengan perpaduan yang sempurna antara berbagai bahan yang disusun secara rapi di antara dua lapisan roti.'),
(38, 'Hamburger', '38000', '6654076cb956c.png', 'makanan', 'Hamburger adalah sajian ikonik yang terdiri dari patty daging, sayuran, dan saus yang disajikan di antara dua irisan roti bundar. Dengan rasa yang gurih dan tekstur yang menggoda, hamburger telah menjadi favorit di seluruh dunia. Patty daging yang digoreng atau dipanggang menghadirkan cita rasa yang kaya, sementara sayuran segar seperti selada, tomat, dan bawang merah memberikan kesegaran dan renyah. Ditambah dengan beragam saus seperti saus tomat, mayones, atau saus BBQ, hamburger memberikan kombinasi rasa yang memikat.'),
(39, 'Spagetti', '37000', '665407bbf2178.png', 'makanan', 'Spaghetti adalah hidangan pasta yang lezat dan mendalam, yang terdiri dari mi pasta yang panjang dan ramping, disajikan dengan saus yang melimpah. Pasta spaghetti yang dimasak al dente (tak terlalu lunak atau keras) menghadirkan tekstur yang sempurna, sementara sausnya dapat bervariasi mulai dari saus tomat yang klasik hingga saus daging yang gurih, atau saus krim yang kaya. '),
(40, 'Wedhang jahe', '21000', '66540899bcac2.png', 'non-coffee', 'Wedhang Jahe adalah minuman tradisional Jawa yang kaya akan rasa dan manfaat kesehatan. Dibuat dengan merebus jahe segar bersama dengan rempah-rempah lainnya seperti kayu manis, cengkeh, dan gula merah, Wedhang Jahe menghadirkan kombinasi yang hangat dan membangkitkan semangat. Minuman ini tidak hanya menyegarkan dan menghangatkan tubuh, tetapi juga dipercaya memiliki beragam manfaat kesehatan.'),
(41, 'Citrus Splash', '18000', '66540909ce449.png', 'non-coffee', 'Citrus Splash adalah minuman segar yang memikat dengan perpaduan buah-buahan citrus yang menyegarkan. Dibuat dengan campuran perasan jeruk segar seperti jeruk nipis, jeruk lemon, dan jeruk orange, Citrus Splash menghadirkan kesegaran yang tak tertandingi. Setiap tegukan membawa cita rasa yang khas dari buah-buahan citrus, disertai dengan aroma yang menyegarkan dan melebur di lidah Anda.'),
(42, 'Chicken Wings', '33000', '6654096e121bc.png', 'makanan', 'Chicken Wings adalah sajian yang populer dan lezat yang terdiri dari sayap ayam yang dimasak dengan berbagai cara yang berbeda. Dari yang digoreng hingga dipanggang atau dibakar, Chicken Wings menghadirkan kombinasi yang sempurna antara daging ayam yang juicy dan kulit yang renyah. Biasanya disajikan dengan beragam saus yang menggugah selera seperti saus BBQ, saus pedas, atau saus mentega bawang putih, Chicken Wings menjadi pilihan camilan yang favorit di berbagai acara, mulai dari pesta di rumah hingga pertandingan olahraga.'),
(43, 'Creamy Dream Latte', '27000', '66540a0313aea.png', 'coffee', 'Creamy Dream Latte adalah minuman kopi yang menggoda dengan kelembutan dan cita rasa yang memikat. Dibuat dengan perpaduan espresso yang kuat dan susu yang kaya, Creamy Dream Latte menghadirkan tekstur yang lembut dan krimi dengan setiap tegukan. Tambahan sirup vanila atau karamel memberikan sentuhan manis yang sempurna, menciptakan minuman yang memanjakan lidah dan memenuhi kenikmatan.');

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
(21, 5, 'Asep Thiago', 'MENU MENU NYA ENAK ENAK BANEGT SUKA POKONYA!', 27, '665096e8df6c2.jpg'),
(23, 5, 'reyjuno', 'Tempat yang hebat untuk menikmati kopi yang lezat dalam suasana yang menyenangkan.', 29, '66582540c0bf6.jpeg'),
(25, 4, 'cobaa', 'WKWKWK KEREN BGT SI', 26, '664f43df4e9ab.jpeg'),
(29, 5, 'ben', 'kata mama keren kamu qaysar ', 21, '664d88021e546.jpg');

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
  `waktu_transaksi` time DEFAULT NULL,
  `rating` int(1) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Konfirmasi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_user`, `id_produk`, `total_transaksi`, `metode_transaksi`, `tanggal_transaksi`, `jumlah`, `waktu_transaksi`, `rating`, `status`) VALUES
(142, 3, 12, '100000', 'Cash', '2024-06-05', '5', '11:07:00', 5, 'Pemesanan Selesai'),
(143, 27, 30, '260000', 'Cash', '2024-06-05', '10', '11:12:00', NULL, 'Pemesanan Selesai'),
(144, 34, 16, '4200000', 'Cash', '2024-06-05', '210', '11:33:00', 4, 'Pemesanan Selesai'),
(145, 34, 32, '28000', 'Cash', '2024-06-05', '1', '11:33:00', 5, 'Pemesanan Selesai'),
(146, 34, 33, '34000', 'Cash', '2024-06-05', '1', '11:33:00', 5, 'Pemesanan Selesai'),
(147, 34, 34, '33000', 'Cash', '2024-06-05', '1', '11:33:00', 5, 'Pemesanan Selesai'),
(148, 3, 32, '140000', 'Cash', '2024-06-05', '5', '11:37:00', 5, 'Pemesanan Selesai'),
(149, 3, 30, '130000', 'Cash', '2024-06-05', '5', '11:39:00', NULL, 'Pemesanan Selesai'),
(150, 3, 37, '115000', 'Cash', '2024-06-06', '5', '11:39:00', NULL, 'Pemesanan Selesai'),
(151, 23, 14, '90000', 'Cash', '2024-06-05', '5', '20:49:00', 5, 'Pemesanan Selesai'),
(152, 23, 31, '80000', 'Cash', '2024-06-05', '5', '20:56:00', 5, 'Pemesanan Selesai'),
(154, 23, 30, '26000', 'Cash', '2024-06-05', '1', '21:04:00', 5, 'Pemesanan Selesai'),
(156, 4, 42, '330000', 'Cash', '2024-06-05', '10', '21:41:00', 5, 'Pemesanan Selesai'),
(157, 4, 20, '270000', 'Cash', '2024-06-05', '10', '21:43:00', 5, 'Pemesanan Selesai'),
(158, 4, 33, '170000', 'Cash', '2024-06-05', '5', '21:43:00', 5, 'Pemesanan Selesai'),
(159, 21, 43, '135000', 'Cash', '2024-06-05', '5', '21:52:00', 5, 'Pemesanan Selesai'),
(160, 21, 38, '190000', 'Cash', '2024-06-05', '5', '21:53:00', 5, 'Pemesanan Selesai'),
(161, 34, 39, '185000', 'Cash', '2024-06-06', '5', '10:58:00', 4, 'Pemesanan Selesai'),
(162, 34, 43, '27000', 'Cash', '2024-06-06', '1', '10:58:00', 4, 'Pemesanan Selesai'),
(163, 34, 43, '27000', 'Cash', '2024-06-06', '1', '10:59:00', 4, 'Pemesanan Selesai'),
(164, 34, 41, '180000', 'Cash', '2024-06-06', '10', '11:01:00', 4, 'Pemesanan Selesai'),
(165, 34, 33, '340000', 'Cash', '2024-06-06', '10', '11:01:00', 5, 'Pemesanan Selesai'),
(166, 4, 35, '130000', 'Cash', '2024-06-06', '10', '11:10:00', 4, 'Pemesanan Selesai'),
(167, 4, 38, '38000', 'Cash', '2024-06-06', '1', '11:21:00', 5, 'Pemesanan Selesai'),
(168, 4, 30, '26000', 'Cash', '2024-06-06', '1', '11:22:00', 5, 'Pemesanan Selesai'),
(169, 4, 33, '34000', 'Cash', '2024-06-06', '1', '11:22:00', 5, 'Pemesanan Selesai'),
(170, 35, 34, '165000', 'Cash', '2024-06-06', '5', '11:29:00', 4, 'Pemesanan Selesai'),
(171, 35, 37, '115000', 'Cash', '2024-06-06', '5', '11:48:00', NULL, 'Pemesanan Selesai'),
(173, 3, 12, '40000', 'Cash', '2024-06-07', '2', '14:34:00', 5, 'Pemesanan Selesai'),
(175, 3, 39, '74000', 'Cash', '2024-06-07', '2', '14:34:00', 5, 'Pemesanan Selesai'),
(176, 3, 40, '21000', 'Cash', '2024-06-07', '1', '14:34:00', NULL, 'Pemesanan Selesai'),
(177, 3, 37, '69000', 'Cash', '2024-06-07', '3', '14:34:00', NULL, 'Pemesanan Selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `level` varchar(10) NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `level`, `foto_profil`) VALUES
(1, 'admin', 'admin', 'qaysaraqeel71@gmail.com', 'admin', '66607714ecd20.png'),
(2, 'user', 'user', 'qaysaraqeel71@gmail.com', 'user', '664d9aafcf9f2.jpg'),
(3, 'qaesyaar', 'qaesyaar', 'qaysaraqeel71@gmail.com', 'user', '664dfbfbb7150.jpg'),
(4, 'aatharnibos', 'aathar', 'qaysaraqeel71@gmail.com', 'user', '664e31454ca4c.jpeg'),
(21, 'ben', 'ben', 'ben@gmail.com', 'user', '664d88021e546.jpg'),
(22, 'Jean Messi', '123', 'nugraha@gmail.com', 'user', '664d850868307.jpeg'),
(23, 'felilulu', '123', 'felilulu@gmail.com', 'user', '664f154392619.jpg'),
(26, 'cobaa', '123', 'coba@gmail.com', 'user', '664f43df4e9ab.jpeg'),
(27, 'Asep Thiago', 'asep', 'asepthiago99@gmail.com', 'user', '665096e8df6c2.jpg'),
(29, 'reyjuno', '123', 'oke@gmail.com', 'user', '66582540c0bf6.jpeg'),
(32, 'barista', '123', 'baristanya@gmail.com', 'barista', '665edc25945db.png'),
(33, 'barini', '123', 'bubari@gmail.com', 'barista', '665f3cb33d450.png'),
(34, 'ike', '123', 'ike@gmail.com', 'user', '665fe86f483bd.jpg'),
(35, 'rasedd', '123', 'qaysaraqeel08@gmail.com', 'user', '66613a3717eb1.jpg');

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
  MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT untuk tabel `rating`
--
ALTER TABLE `rating`
  MODIFY `id_rating` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

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
