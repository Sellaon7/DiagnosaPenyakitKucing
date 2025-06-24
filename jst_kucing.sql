-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 02, 2025 at 05:36 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jst_kucing`
--

-- --------------------------------------------------------

--
-- Table structure for table `gejala`
--

CREATE TABLE `gejala` (
  `id` int NOT NULL,
  `nama_gejala` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gejala`
--

INSERT INTO `gejala` (`id`, `nama_gejala`) VALUES
(1, 'Demam Tinggi'),
(2, 'Demam Ringan'),
(3, 'Muntah'),
(4, 'Diare Berat'),
(5, 'Diare Ringan'),
(6, 'Bulu Rontok'),
(7, 'Mata Merah dan Berair'),
(8, 'Penurunan Berat Badan'),
(9, 'Bercak Kemerahan'),
(10, 'Kuku Rapuh'),
(11, 'Kebotakan'),
(12, 'Air Liur Berlebihan'),
(13, 'Lemas dan Lesu'),
(14, 'Dehidrasi'),
(15, 'Mengeong Berlebihan'),
(16, 'Hidung Berlendir'),
(17, 'Nafsu Makan Berlebih\r\n'),
(18, 'Penurunan Nafsu Makan');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_kucing`
--

CREATE TABLE `jenis_kucing` (
  `id` int NOT NULL,
  `nama_jenis` varchar(100) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `deskripsi` text,
  `berat` varchar(50) DEFAULT NULL,
  `tinggi` varchar(50) DEFAULT NULL,
  `umur` varchar(50) DEFAULT NULL,
  `mantel_bulu` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jenis_kucing`
--

INSERT INTO `jenis_kucing` (`id`, `nama_jenis`, `gambar`, `deskripsi`, `berat`, `tinggi`, `umur`, `mantel_bulu`) VALUES
(1, 'Kucing Anggora', 'assets/img/portfolio/k1.jpg', 'Kucing anggora berasal dari kota Anggora (sekarang Ankara) yang ada di Turki. Kucing anggora merupakan salah satu kucing ras tertua yang ada di dunia. Tidak ada yang tahu asal-usul pastinya, tetapi diyakini bahwa kucing anggora berasal dari kucing liar Afrika, dan bulunya yang panjang dan halus adalah hasil mutasi alami. Kucing ini mulai dibawa ke Eropa pada tahun 1600-an.', '5 - 20 pon', '11 - 15 inci', '12 - 18 tahun', 'Panjang dan lebat'),
(2, 'Kucing Persia', 'assets/img/portfolio/k2.jpg', 'Kucing persia berasal dari Persia atau yang kini dikenal sebagai Iran. Kucing persia sangat populer di kalangan bangsawan Eropa sejak tahun 1600-an. Sama seperti angora, bulu panjangnya adalah hasil mutasi alamiah.', '8 - 12 pon', '11 - 15 inci', '16 - 20 tahun', 'Panjang dan mewah'),
(3, 'Kucing Domestik', 'assets/img/portfolio/k3.jpg', 'Kucing domestik telah didomestikasi sejak sekitar 10.000 tahun yang lalu di Timur Tengah. Diduga, nenek moyang mereka adalah kucing liar Afrika (Felis lybica). Kucing domestik kemudian menyebar ke seluruh dunia melalui perdagangan dan migrasi manusia.', '7 - 15 pon', '10 - 13 inci', '8 - 15 tahun', 'Panjang dan lurus'),
(4, 'Kucing Siam', 'assets/img/portfolio/k4.jpg', 'Kucing Siam berasal dari Siam (sekarang Thailand) dan telah dipelihara di sana selama berabad-abad. Kucing ini pertama kali diperkenalkan ke Barat pada abad ke-19 dan menjadi populer karena penampilannya yang unik dan kepribadiannya yang ceria.', '4 - 9 pon', '8 - 14 inci', '10 - 16 tahun', 'Pendek dan halus'),
(5, 'Kucing Sphynx', 'assets/img/portfolio/k5.jpg', 'Kucing Sphynx pertama kali muncul di Kanada pada tahun 1966 akibat mutasi genetik alami. Kucing ini menjadi populer di tahun 1970-an dan 1980-an karena penampilannya yang unik dan kepribadiannya yang ramah.', '12 pon', '8 - 10 inci', '16 tahun', 'Tanpa bulu'),
(6, 'Kucing Scottish Fold', 'assets/img/portfolio/k6.jpg', 'Ciri yang paling mencolok dari kucing Scottish Fold adalah telinganya yang kecil dan terlipat rapat ke depan untuk menutupi lubang telinga. Ujung telinganya juga membulat. Scottish Fold berukuran sedang dengan bentuk badan yang kokoh. Kepalanya bulat dengan bantalan kumis yang jelas, terletak di leher mereka yang pendek. Mereka memiliki mata yang besar dengan ekspresi manis. Rambut dari kucing jenis Scottish Fold pendek dan padat dan datang dalam berbagai warna serta pola.', '6 - 12 pon', '11 - 16 inci', '9 - 17 tahun', 'Pendek atau panjang'),
(7, 'Kucing Ragdoll', 'assets/img/portfolio/k7.jpg', 'Kucing Ragdoll pertama kali dibiakkan di Amerika Serikat pada tahun 1960-an oleh Ann Baker. Kucing ini mendapatkan namanya karena sifatnya yang rileks dan floppy ketika digendong. Kucing Ragdoll menjadi populer di tahun 1970-an dan 1980-an karena penampilannya yang cantik dan kepribadiannya yang penyayang.', '10 - 20 pon', '9 - 11 inci', '13 - 18 tahun', 'Panjang, bulu halus dan lembut');

-- --------------------------------------------------------

--
-- Table structure for table `penyakit`
--

CREATE TABLE `penyakit` (
  `id` int NOT NULL,
  `nama_penyakit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `informasi` text COLLATE utf8mb4_unicode_ci,
  `gejala_detail` text COLLATE utf8mb4_unicode_ci,
  `solusi` text COLLATE utf8mb4_unicode_ci,
  `link_penjelasan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penyakit`
--

INSERT INTO `penyakit` (`id`, `nama_penyakit`, `gambar`, `informasi`, `gejala_detail`, `solusi`, `link_penjelasan`) VALUES
(1, 'Feline Panleukopenia Virus 1', 'assets/img/penyakit/feline1.jpg', 'Feline Panleukopenia Virus (FPV), juga dikenal sebagai Feline Distemper atau Feline Parvovirus, adalah penyakit virus yang sangat menular pada kucing. Virus ini menyerang sel-sel yang membelah dengan cepat di dalam tubuh kucing, termasuk sel-sel di saluran pencernaan, sumsum tulang, dan sistem kekebalan tubuh. Penyakit ini sering kali bersifat fatal, terutama pada anak kucing muda dan kucing yang tidak divaksinasi.', '1. Demam Tinggi : Suhu tubuh kucing dapat meningkat secara signifikan.\r\n2. Muntah : Kucing yang terinfeksi sering mengalami muntah.\r\n3. Diare Berat : Diare yang sering kali berdarah.\r\n4. Dehidrasi : Karena muntah dan diare yang berlebihan.\r\n5. Penurunan Nafsu Makan : Kucing mungkin kehilangan nafsu makan sepenuhnya.\r\n6. Letargi : Kucing terlihat sangat lemah dan tidak aktif.\r\n7. Penurunan Berat Badan : Karena kurangnya asupan makanan dan dehidrasi.\r\n8. Kekuningan pada Gusi dan Kulit : Tanda ini menunjukkan adanya masalah pada hati.', '1. Perawatan Medis\r\n   - Hospitalisasi : Kucing yang terkena FPV sering memerlukan perawatan di rumah sakit hewan.\r\n   - Antibiotik : Untuk mengobati infeksi bakteri yang mungkin terjadi.\r\n   - Cairan IV : Untuk mengatasi dehidrasi dan menjaga keseimbangan elektrolit.\r\n   - Obat Anti-Muntah dan Anti-Diare : Untuk mengontrol gejala muntah dan diare.\r\n2. Nutrisi dan Perawan Tambahan\r\n   - Nutrisi : Dalam kasus yang parah, nutrisi mungkin diberikan secara intravena.\r\n   - Makanan Cair : Untuk kucing yang masih bisa makan, makanan yang lembut dan mudah dicerna diberikan.\r\n3. Pencegahan\r\n   - Vaksinasi : Vaksinasi rutin sangat penting untuk mencegah FPV. Vaksin FPV biasanya diberikan sebagai bagian dari vaksinasi dasar untuk kucing.\r\n   - Kebersihan dan Sanitasi : Menjaga lingkungan kucing tetap bersih dan higienis untuk mencegah penyebaran virus.\r\n   - Isolasi : Kucing yang terinfeksi harus diisolasi dari kucing lain untuk mencegah penularan.', 'feline1.php'),
(2, 'Corona Virus', 'assets/img/penyakit/feline2.jpg', 'Feline Coronavirus (FCoV) adalah virus yang umum ditemukan pada kucing dan terutama menyerang saluran pencernaan. Sebagian besar infeksi FCoV tidak menyebabkan gejala yang serius dan dapat sembuh dengan sendirinya. Namun, dalam beberapa kasus, FCoV dapat bermutasi menjadi Feline Infectious Peritonitis Virus (FIPV), yang menyebabkan Feline Infectious Peritonitis (FIP), penyakit yang sering kali bersifat fatal.', '1. Demam Ringan : Suhu tubuh kucing mungkin sedikit meningkat.\r\n2. Muntah : Kucing yang terinfeksi sering mengalami muntah.\r\n3. Diare Ringan : Ini adalah gejala yang paling umum.\r\n4. Lemas : Kucing bisa terlihat lemah atau tidak aktif.\r\n5. Penurunan Nafsu Makan : Kucing mungkin kehilangan nafsu makan sepenuhnya.', '1. Perawatan Medis\r\n   - Pengobatan Simptomatik : Mengatasi gejala seperti diare dan muntah dengan obat-obatan yang sesuai.\r\n   - Hidrasi : Memberikan cairan untuk mencegah dehidrasi.\r\n   - Diet Khusus : Memberikan makanan yang mudah dicerna untuk mengurangi tekanan pada saluran pencernaan.\r\n2. Pencegahan\r\n   - Pengelolaan Populasi : Menghindari kepadatan kucing yang tinggi, terutama di tempat penampungan dan rumah pemeliharaan kucing.\r\n   - Kebersihan dan Sanitasi : Menjaga lingkungan kucing tetap bersih dan higienis untuk mencegah penyebaran virus.\r\n   - Isolasi : Kucing yang terinfeksi harus diisolasi dari kucing lain untuk mencegah penularan.', 'feline2.php'),
(3, 'Ringworm', 'assets/img/penyakit/ringworm.jpg', 'Ringworm atau dermatofitosis adalah infeksi jamur yang mempengaruhi kulit, bulu, dan kuku pada kucing. Meskipun disebut \"ringworm\" (cacing cincin), penyakit ini tidak disebabkan oleh cacing, melainkan oleh jamur dermatofita. Jamur ini dapat menyebar melalui kontak langsung dengan hewan yang terinfeksi atau benda yang terkontaminasi, seperti tempat tidur, mainan, atau alat perawatan.', '1. Kebotakan : Area yang terkena sering kehilangan bulu.\n2. Gatal dan Garukan : Kucing mungkin sering menggaruk area yang terinfeksi.\n3. Kemerahan : Kulit yang terinfeksi mungkin tampak merah dan meradang.\n4. Kuku Rusak : Infeksi bisa mempengaruhi kuku dan area sekitarnya, menyebabkan kerusakan atau infeksi pada kuku.\n5. Kulit Mengelupas : Kulit di area yang terinfeksi mungkin tampak mengelupas atau bersisik.', '1. Perawatan Medis\n   - Antijamur Topikal : Mengatasi gejala seperti diare dan muntah dengan obat-obatan yang sesuai.\n   - Sampo Medis : Mandi dengan sampo antijamur khusus dapat membantu menghilangkan jamur dari bulu dan kulit kucing.\n   - Antijamur Oral : Dalam kasus yang lebih parah, dokter hewan mungkin meresepkan obat antijamur oral seperti itraconazole atau terbinafine.\n2. Pencegahan\n   - Membersihkan Lingkungan : Menjaga kebersihan lingkungan kucing, termasuk mencuci tempat tidur, mainan, dan alat perawatan secara teratur.\n   - Meningkatkan Sistem Kekebalan Tubuh : Menyediakan makanan bergizi dan suplemen yang sesuai untuk membantu memperkuat sistem kekebalan tubuh kucing.\n   - Hindari Kontak Langsung : Menghindari kontak langsung dengan kucing yang terinfeksi dan mencuci tangan setelah merawat kucing tersebut.\n   - Isolasi : Kucing yang terinfeksi harus diisolasi dari kucing lain untuk mencegah penularan.', 'ringworm.php'),
(4, 'Rabies', 'assets/img/penyakit/rabies.jpg', 'Rabies adalah penyakit virus yang mematikan dan dapat menular melalui gigitan atau cakaran hewan yang terinfeksi. Virus rabies menyerang sistem saraf pusat, menyebabkan ensefalitis (radang otak) yang parah. Rabies dapat menginfeksi semua mamalia, termasuk manusia, dan merupakan salah satu penyakit zoonosis yang paling berbahaya.', '1. Furious Rabies\n   - Perubahan Perilaku : Kucing menjadi agresif, gelisah, atau sangat takut.\n   - Hipereksitabilitas : Reaksi berlebihan terhadap rangsangan.\n   - Mengeong Berlebihan : Suara mengeong yang tidak biasa atau terus-menerus.\n   - Disorientasi : Kucing terlihat bingung dan tidak dapat mengenali lingkungannya.\n   - Paralisis : Biasanya dimulai dari rahang dan tenggorokan, menyebabkan kesulitan menelan dan air liur berlebihan.\n2. Dumb Rabies\n   - Kelemahan dan Paralisis : Kelemahan otot yang progresif, dimulai dari ekstremitas dan akhirnya mempengaruhi seluruh tubuh.\n   - Kelesuan : Kucing menjadi sangat lemah dan tidak responsif.\n   - Kesulitan Menelan : Akibat paralisis otot tenggorokan.', '1. Perawatan Medis\n   - Tidak Ada Pengobatan untuk Rabies yang Sudah Gejala : Sayangnya, setelah gejala klinis muncul, rabies hampir selalu berakibat fatal pada hewan dan manusia.\n   - Euthanasia : Dalam banyak kasus, kucing yang didiagnosis dengan rabies akan di-euthanasia untuk mencegah penyebaran penyakit dan menghindari penderitaan yang tidak perlu.\n2. Pencegahan\n   - Vaksinasi : Vaksin rabies adalah metode pencegahan yang paling efektif. Semua kucing harus menerima vaksin rabies sesuai dengan jadwal vaksinasi yang direkomendasikan oleh dokter hewan.\n   - Lapor Gigitan Hewan : Segera melaporkan setiap gigitan atau cakaran hewan kepada dokter hewan dan petugas kesehatan setempat untuk mendapatkan tindakan pencegahan yang tepat.\n   - Hindari Kontak dengan Hewan Liar : Menghindari kontak dengan hewan liar atau hewan yang mungkin terinfeksi rabies.\n   - Pengawasan Ketat : Mengawasi kucing saat berada di luar rumah untuk mencegah pertemuan dengan hewan liar yang mungkin terinfeksi.', 'rabies.php'),
(5, 'Flu Kucing', 'assets/img/penyakit/flu kucing.jpg', 'Flu kucing adalah istilah umum untuk menggambarkan infeksi saluran pernapasan atas yang disebabkan oleh beberapa virus dan bakteri. Penyakit ini sangat menular di antara kucing dan terutama mempengaruhi kucing muda, tua, atau yang memiliki sistem kekebalan tubuh yang lemah. Dua agen penyebab utama flu kucing adalah Feline Herpesvirus (FHV) dan Feline Calicivirus (FCV).', '1. Demam : Suhu tubuh kucing mungkin sedikit meningkat.\n2. Bersin : Bersin yang sering dan berulang.\n3. Keluarnya Lendir dari Hidung : Lendir bisa berwarna jernih atau bernanah.\n4. Lemas : Kucing bisa terlihat lemah atau tidak aktif.\n5. Mata Merah dan Berair : Peradangan pada mata (konjungtivitis).', '1. Perawatan Medis\n   - Obat Penghilang Nyeri : Untuk mengurangi ketidaknyamanan yang disebabkan oleh luka atau sariawan di mulut.\n   - Antibiotik : Untuk mengobati infeksi bakteri yang mungkin terjadi.\n   - Tetes Mata dan Hidung : Untuk mengurangi peradangan dan membantu membersihkan lendir.\n2. Perawatan di Rumah\n   - Hidrasi yang Cukup : Pastikan kucing tetap terhidrasi dengan memberikan banyak air minum.\n   - Makanan Lembut : Makanan yang mudah dicerna dan memiliki aroma kuat untuk menarik nafsu makan kucing.\n   - Kebersihan : Bersihkan hidung dan mata kucing secara teratur dengan kain lembut dan basah.\n   - Lingkungan yang Hangat dan Nyaman : Sediakan tempat yang hangat dan nyaman untuk kucing beristirahat.\n3. Pencegahan\n   - Vaksinasi : Vaksinasi rutin sangat penting untuk mencegah flu kucing. Vaksin tersedia untuk FHV dan FCV.\n   - Menghindari Kontak dengan Kucing yang Terinfeksi : Isolasi kucing yang terinfeksi untuk mencegah penyebaran penyakit ke kucing lain.', 'flu.php'),
(6, 'Hyperthyroidism', 'assets/img/penyakit/hyper.jpg', 'Hyperthyroidism adalah kondisi di mana kelenjar tiroid kucing menghasilkan hormon tiroid dalam jumlah berlebih. Kondisi ini biasanya terjadi pada kucing yang lebih tua dan dapat menyebabkan berbagai masalah kesehatan serius jika tidak diobati. Penyebab utama Hyperthyroidism pada kucing adalah adenoma tiroid, yaitu tumor jinak yang menyebabkan kelenjar tiroid membesar dan menghasilkan lebih banyak hormon tiroid.', '1. Penurunan Berat Badan : Meskipun nafsu makan meningkat.\n2. Nafsu Makan Berlebihan : Kucing makan lebih banyak dari biasanya.\n3. Kegelisahan : Kucing tampak gelisah atau hiperaktif.\n4. Bulu Rontok : Kualitas bulu yang menurun.', '1. Perawatan Medis\n   - Diagnosa Dokter Hewan : Tes darah diperlukan untuk mengukur tingkat hormon tiroid.\n   - Obat-obatan : Obat antitiroid seperti methimazole digunakan untuk mengurangi produksi hormon tiroid.\n   - Operasi : Dalam beberapa kasus, pembedahan untuk mengangkat kelenjar tiroid yang membesar mungkin diperlukan.\n2. Perawatan di Rumah\n   - Diet Khusus : Memberikan makanan yang rendah yodium untuk membantu mengelola kondisi kucing.\n   - Monitoring Gejala : Mengawasi tanda-tanda memburuknya kondisi kucing dan segera mencari bantuan medis jika diperlukan.\n   - Lingkungan yang Hangat dan Nyaman : Memberikan lingkungan yang tenang dan nyaman untuk mengurangi stres pada kucing.\n3. Pencegahan\n   - Pemeriksaan Rutin : Membawa kucing ke dokter hewan untuk pemeriksaan kesehatan rutin, terutama pada kucing yang lebih tua.\n   - Diet Seimbang : Memberikan makanan berkualitas tinggi yang seimbang untuk menjaga kesehatan kucing.', 'hyperthyroidism.php'),
(7, 'Insomnia', 'assets/img/penyakit/penyakit_68122bc6a40436.04148255.jpg', 'contoh', 'contoh', 'contoh', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `penyakit_gejala`
--

CREATE TABLE `penyakit_gejala` (
  `id` int NOT NULL,
  `penyakit_id` int DEFAULT NULL,
  `gejala_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penyakit_gejala`
--

INSERT INTO `penyakit_gejala` (`id`, `penyakit_id`, `gejala_id`) VALUES
(1, 1, 1),
(2, 1, 3),
(3, 1, 4),
(4, 1, 8),
(5, 1, 14),
(7, 2, 2),
(8, 2, 3),
(9, 2, 5),
(10, 2, 13),
(11, 2, 18),
(12, 3, 9),
(16, 4, 15),
(18, 4, 13),
(19, 5, 2),
(20, 5, 16),
(21, 5, 13),
(22, 5, 7),
(23, 6, 17),
(24, 6, 8),
(41, 7, 16);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` tinyint UNSIGNED NOT NULL,
  `nama_role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `nama_role`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Nama lengkap pengguna',
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Path ke foto profil',
  `role_id` tinyint UNSIGNED NOT NULL DEFAULT '2' COMMENT 'Foreign key ke tabel roles',
  `is_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=Belum Aktif, 1=Aktif',
  `otp_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Kode OTP untuk aktivasi',
  `otp_expiry` datetime DEFAULT NULL COMMENT 'Waktu kedaluwarsa OTP',
  `reset_token` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Token untuk reset password',
  `reset_token_expiry` datetime DEFAULT NULL COMMENT 'Waktu kedaluwarsa reset token',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `name`, `photo`, `role_id`, `is_active`, `otp_code`, `otp_expiry`, `reset_token`, `reset_token_expiry`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'luqmannaufal170@gmail.com', '$2y$10$vJIH8rSoMbkcUXqJJs4bTOeJYX3bGrKFalgySjpbUwqOKzydFDQKW', NULL, NULL, 1, 1, '352458', '2025-05-01 04:17:43', NULL, NULL, '2025-05-01 04:07:43', '2025-05-02 02:04:13'),
(5, 'User', 'luqmannaufal171@gmail.com', '$2y$10$E7xxXpAJsYbJqwoBbFmNZOhfLeaqBmtQSC4OZHJkf4DMMlGnpZay.', 'Luqman Anas Naufal', 'uploads/profile_5_1746077544.jpg', 2, 1, NULL, NULL, NULL, NULL, '2025-05-01 05:00:35', '2025-05-01 05:32:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_kucing`
--
ALTER TABLE `jenis_kucing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penyakit`
--
ALTER TABLE `penyakit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_penyakit_UNIQUE` (`nama_penyakit`);

--
-- Indexes for table `penyakit_gejala`
--
ALTER TABLE `penyakit_gejala`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penyakit_id` (`penyakit_id`),
  ADD KEY `gejala_id` (`gejala_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_role_unique` (`nama_role`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_unique` (`username`),
  ADD UNIQUE KEY `email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gejala`
--
ALTER TABLE `gejala`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `jenis_kucing`
--
ALTER TABLE `jenis_kucing`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `penyakit`
--
ALTER TABLE `penyakit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `penyakit_gejala`
--
ALTER TABLE `penyakit_gejala`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `penyakit_gejala`
--
ALTER TABLE `penyakit_gejala`
  ADD CONSTRAINT `penyakit_gejala_ibfk_1` FOREIGN KEY (`penyakit_id`) REFERENCES `penyakit` (`id`),
  ADD CONSTRAINT `penyakit_gejala_ibfk_2` FOREIGN KEY (`gejala_id`) REFERENCES `gejala` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
