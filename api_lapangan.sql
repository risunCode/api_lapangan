-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2025 at 04:56 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `api_lapangan`
--

-- --------------------------------------------------------

--
-- Table structure for table `buydetail`
--

CREATE TABLE `buydetail` (
  `id_trx` int(11) NOT NULL,
  `id_item` varchar(20) NOT NULL,
  `nama_item` varchar(50) NOT NULL,
  `jumlah_slot` varchar(10) NOT NULL,
  `harga_total` varchar(50) NOT NULL,
  `lokasi` varchar(50) NOT NULL,
  `deskripsi` varchar(50) NOT NULL,
  `tanggal_pemesanan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buydetail`
--

INSERT INTO `buydetail` (`id_trx`, `id_item`, `nama_item`, `jumlah_slot`, `harga_total`, `lokasi`, `deskripsi`, `tanggal_pemesanan`) VALUES
(13, '207', 'Phoebe via postman', '1', '90000000', 'Rinascita new', 'Mawaif 2am', '2025-01-15 23:38:02'),
(14, '207', 'Phoebe via postman', '1', '90000000', 'Rinascita new', 'Mawaif 2am', '2025-01-15 23:38:02');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_item` varchar(20) NOT NULL,
  `jumlah_slot` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `nama_member` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `no_telp` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `nama_member`, `email`, `no_telp`) VALUES
(1, 'dimasturu', 'risundaily@gmail.com', '0851');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id_item` int(100) NOT NULL,
  `nama_item` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `harga` varchar(255) NOT NULL,
  `sisa_slot` int(255) NOT NULL,
  `gambar` text NOT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id_item`, `nama_item`, `deskripsi`, `lokasi`, `harga`, `sisa_slot`, `gambar`, `tanggal_input`, `updated_at`, `created_at`) VALUES
(212, 'Lapangan Besar', 'Stadion Bong', 'Gatau', '100.000', 2, 'https://i0.wp.com/zaloraadmin.wpcomstaging.com/wp-content/uploads/2024/07/ukuran-lapangan-sepak-bola.png?fit=1200%2C620&ssl=1', '2025-01-16 09:04:20', '2025-01-16 09:04:20', '2025-01-16 03:04:20'),
(214, 'Stadion Paris 1', 'test', 'paris', '800.000.000', 1, 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f4/Paris_Parc_des_Princes_1.jpg/1200px-Paris_Parc_des_Princes_1.jpg', '2025-01-16 13:16:30', '2025-01-16 13:16:30', '2025-01-16 07:16:30'),
(215, 'Futsal Paris 1', 'Lapangan untuk futsal', 'Paris 1 Pontianak', '100.000', 2, 'https://wasaka.kalselprov.go.id/wp-content/uploads/2023/03/img-20230318-wa00808931221357714421146-1024x576.jpg', '2025-01-16 13:20:48', '2025-01-16 13:20:48', '2025-01-16 07:20:48'),
(216, 'Futsal aris', 'Lapangan Sedang', 'Sudirman', '100.000', 2, 'https://ultimatesport.co.id/wp-content/uploads/2017/11/gn3_400397447.jpg', '2025-01-16 13:22:07', '2025-01-16 13:22:07', '2025-01-16 07:22:07');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role`) VALUES
(1, 'admin'),
(2, 'member');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `created_at` date NOT NULL,
  `modified` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `email`, `password`, `role_id`, `is_active`, `created_at`, `modified`) VALUES
(107, 'Dimas Debugging', 'sundebug@gmail.com', '$2y$10$SUkOE7qDLWaOedy8X1AE4OVSHlQb6JD76Xt4Bb9zU5D8dKvadwlBK', 2, 1, '2025-01-14', '0000-00-00'),
(108, 'Risun as User', 'usertest@gmail.com', '$2y$10$KeGPsHaWVajqJIdrt85gYeTimB7KceJ0VxhXy7v8qFtw3YXvTO4F6', 2, 1, '2025-01-14', '0000-00-00'),
(109, 'realuser', 'realuser@gmail.com', '$2y$10$xzaosV84wL8GHrrAjWNBhuRIb40toRncGWEsXCC8tub8B1/zj7ZG.', 2, 1, '2025-01-14', '0000-00-00'),
(110, 'yubi', 'yubi@gmail.com', '$2y$10$U0dXIhKVvGUzAG5x2Dr9EuQW6HDBf7yUu20e0RVT5HUipRvhm4Gi6', 2, 1, '2025-01-15', '0000-00-00'),
(111, 'userspace', 'userspace@gmail.com', '$2y$10$uWFN3mkdakc4BTxoi6iX..P7SmCnnZRaeEol0CUHuEN65LXNpAoY.', 2, 1, '2025-01-16', '0000-00-00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buydetail`
--
ALTER TABLE `buydetail`
  ADD KEY `id_trx` (`id_trx`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD KEY `gambar_produk` (`id_item`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `id` (`id_user`,`nama`,`email`,`password`,`role_id`,`is_active`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buydetail`
--
ALTER TABLE `buydetail`
  MODIFY `id_trx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id_item` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
