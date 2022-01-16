-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2022 at 08:32 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `IdOrder` bigint(20) NOT NULL,
  `IdUser` bigint(20) NOT NULL,
  `IdUserLazada` bigint(20) DEFAULT NULL,
  `IdUserShopee` bigint(20) DEFAULT NULL,
  `NoOrder` varchar(20) NOT NULL,
  `NamaPembeli` varchar(90) NOT NULL,
  `Harga` varchar(20) NOT NULL,
  `Status` varchar(30) NOT NULL,
  `TglPembuatanOrder` varchar(20) NOT NULL,
  `Platform` varchar(20) NOT NULL,
  `CreatedBy` bigint(20) NOT NULL,
  `CreatedOn` varchar(20) NOT NULL,
  `ModifiedBy` bigint(20) DEFAULT NULL,
  `ModifiedOn` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`IdOrder`, `IdUser`, `IdUserLazada`, `IdUserShopee`, `NoOrder`, `NamaPembeli`, `Harga`, `Status`, `TglPembuatanOrder`, `Platform`, `CreatedBy`, `CreatedOn`, `ModifiedBy`, `ModifiedOn`) VALUES
(568, 1, NULL, 332128107, '220114RD1Q74FX', 'hafizharsyil', 'Rp 32,900', 'Selesai', 'Shopee', '2022-01-14 05:50:50', 1, '2022-01-16 14:28:23', NULL, NULL),
(569, 1, NULL, 332128107, '220114R9MY24AA', 'wulanaurell26', 'Rp 29,900', 'Selesai', 'Shopee', '2022-01-14 04:50:02', 1, '2022-01-16 14:28:23', NULL, NULL),
(570, 1, NULL, 332128107, '220113MFFBFM0N', 'rahmadanitta', 'Rp 28,900', 'Selesai', 'Shopee', '2022-01-12 16:23:36', 1, '2022-01-16 14:28:23', NULL, NULL),
(571, 1, NULL, 332128107, '220109BXF9D5WA', 'caxf0el2mw', 'Rp 34,900', 'Selesai', 'Shopee', '2022-01-09 06:58:03', 1, '2022-01-16 14:28:23', NULL, NULL),
(572, 1, NULL, 332128107, '220113P74RP0GU', 'dettydianty', 'Rp 28,900', 'Selesai', 'Shopee', '2022-01-13 08:59:51', 1, '2022-01-16 14:28:23', NULL, NULL),
(573, 1, NULL, 332128107, '220110F8WPW3XN', 'diana_yulianti23', 'Rp 33,900', 'Selesai', 'Shopee', '2022-01-10 14:43:02', 1, '2022-01-16 14:28:23', NULL, NULL),
(574, 1, NULL, 332128107, '220115SN7SDC0G', 'lanymauliahadiani', 'Rp 29,900', 'Selesai', 'Shopee', '2022-01-14 17:50:04', 1, '2022-01-16 14:28:23', NULL, NULL),
(575, 1, NULL, 332128107, '220112JXUX13CK', 'irmayani2102', 'Rp 24,900', 'Selesai', 'Shopee', '2022-01-12 01:53:46', 1, '2022-01-16 14:28:23', NULL, NULL),
(576, 1, NULL, 332128107, '220114SD7WK6UB', 'putriwijayakaazahero', 'Rp 26,900', 'Selesai', 'Shopee', '2022-01-14 15:26:59', 1, '2022-01-16 14:28:23', NULL, NULL),
(577, 1, NULL, 332128107, '220112K90SE9TU', 'avenina', 'Rp 30,900', 'Selesai', 'Shopee', '2022-01-12 04:55:26', 1, '2022-01-16 14:28:23', NULL, NULL),
(578, 1, 400612677383, NULL, '773582477953859', 'Nur', 'Rp 60,000', 'shipped', 'Lazada', '2022-01-15 12:39:56 ', 1, '2022-01-16 14:30:41', NULL, NULL),
(579, 1, 400612677383, NULL, '773458861429122', 'teh ningrum', 'Rp 35,000', 'shipped', 'Lazada', '2022-01-15 09:13:04 ', 1, '2022-01-16 14:30:41', NULL, NULL),
(580, 1, 400612677383, NULL, '779884931294184', 'Boyethea', 'Rp 35,000', 'shipped', 'Lazada', '2022-01-15 06:48:33 ', 1, '2022-01-16 14:30:41', NULL, NULL),
(581, 1, 400612677383, NULL, '779710783309838', 'dodo', 'Rp 35,000', 'shipped', 'Lazada', '2022-01-14 20:43:21 ', 1, '2022-01-16 14:30:41', NULL, NULL),
(582, 1, 400612677383, NULL, '773145687350398', 'yati', 'Rp 35,000', 'delivered', 'Lazada', '2022-01-14 18:28:47 ', 1, '2022-01-16 14:30:41', NULL, NULL),
(583, 1, 400612677383, NULL, '779598161684571', 'wahono  marsam', 'Rp 35,000', 'shipped', 'Lazada', '2022-01-14 17:37:41 ', 1, '2022-01-16 14:30:41', NULL, NULL),
(584, 1, 400612677383, NULL, '773058290538085', 'usman', 'Rp 27,000', 'delivered', 'Lazada', '2022-01-14 15:42:40 ', 1, '2022-01-16 14:30:41', NULL, NULL),
(585, 1, 400612677383, NULL, '779408753360082', '08989115113', 'Rp 25,000', 'canceled', 'Lazada', '2022-01-14 12:20:28 ', 1, '2022-01-16 14:30:41', NULL, NULL),
(586, 1, 400612677383, NULL, '778024341309521', 'wiwik pujiati', 'Rp 30,000', 'shipped', 'Lazada', '2022-01-12 12:28:57 ', 1, '2022-01-16 14:30:41', NULL, NULL),
(587, 1, 400612677383, NULL, '771429634694837', 'nanda ayu', 'Rp 24,000', 'delivered', 'Lazada', '2022-01-12 08:42:41 ', 1, '2022-01-16 14:30:41', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `IdProduk` bigint(20) NOT NULL,
  `IdUser` bigint(20) NOT NULL,
  `IdUserLazada` bigint(20) DEFAULT NULL,
  `IdUSerShopee` bigint(20) DEFAULT NULL,
  `NoProduk` varchar(20) NOT NULL,
  `NamaProduk` varchar(100) NOT NULL,
  `Harga` varchar(20) NOT NULL,
  `Stock` varchar(10) NOT NULL,
  `Gambar` varchar(250) NOT NULL,
  `SKU` varchar(50) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `TglPembuatanProduk` varchar(20) NOT NULL,
  `Platform` varchar(30) NOT NULL,
  `CreatedBy` bigint(20) NOT NULL,
  `CreatedOn` varchar(20) NOT NULL,
  `ModifiedBy` bigint(20) DEFAULT NULL,
  `ModifiedOn` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`IdProduk`, `IdUser`, `IdUserLazada`, `IdUSerShopee`, `NoProduk`, `NamaProduk`, `Harga`, `Stock`, `Gambar`, `SKU`, `Status`, `TglPembuatanProduk`, `Platform`, `CreatedBy`, `CreatedOn`, `ModifiedBy`, `ModifiedOn`) VALUES
(11, 1, 400612677383, NULL, '6059044130', 'UMBI DEWA Kapsul Curah Herbal 600mg Tumor Kanker Diabetes Stroke Haid', '61000', '2000', 'https://id-live.slatic.net/p/eb83411336978df5d47d6b49c23dc916.png', '6059044130_ID-11627734390', 'active', '2022-01-01 13:51:02', 'Lazada', 1, '2022-01-16 12:56:46', 0, ''),
(12, 1, 400612677383, NULL, '6058972780', 'DAUN KERSEN 100 Kapsul Herbal Diabetes Stroke Tumor Asam Urat Imunitas', '32000', '2000', 'https://id-live.slatic.net/p/9762f21e65c7587984232292aa4f82b0.png', '6058972780_ID-11627688031', 'active', '2022-01-01 12:53:29', 'Lazada', 1, '2022-01-16 12:56:46', 0, ''),
(13, 1, 400612677383, NULL, '6058968795', 'DAUN KEMUNING 100 Kapsul Curah Herbal Eksim Kencing Nanah Kulit Halus', '25000', '2000', 'https://id-live.slatic.net/p/2f0e4bbcda38a0a9f4ac675ad7c63630.png', '6058968795_ID-11627624721', 'active', '2022-01-01 12:45:50', 'Lazada', 1, '2022-01-16 12:56:46', 0, ''),
(14, 1, 400612677383, NULL, '6058980260', 'DAUN KENIKIR 100 Kapsul Curah Herbal 600mg Asam Lambung Antioksidan', '36000', '2000', 'https://id-live.slatic.net/p/867ce6a14e577f829f7113589e0f10c7.png', '6058980260_ID-11627644492', 'active', '2022-01-01 12:38:58', 'Lazada', 1, '2022-01-16 12:56:46', 0, ''),
(15, 1, 400612677383, NULL, '6058996009', 'Kapsul Curah Herbal JATI CINA Pelangsing Metabolisme 100 capsul', '24000', '2000', 'https://id-live.slatic.net/p/7ff145da06ca8c79a4b1120333c576b9.png', '6058996009_ID-11627648198', 'active', '2022-01-01 12:31:35', 'Lazada', 1, '2022-01-16 12:56:46', 0, ''),
(16, 1, 400612677383, NULL, '6058956460', 'BELUNTAS Kapsul Herbal Bau Badan Mulut Vitalitas AntiAging 100 capsul', '25000', '2000', 'https://id-live.slatic.net/p/216bc774d611e981d0e0cecf5d37e804.png', '6058956460_ID-11627592946', 'active', '2022-01-01 12:20:34', 'Lazada', 1, '2022-01-16 12:56:46', 0, ''),
(17, 1, 400612677383, NULL, '5771122628', 'GINKGO BILOBA 100 Kapsul Curah Herbal', '61000', '1983', 'https://id-live.slatic.net/p/844de46aeebdc732fc9caf48691bf004.png', '5771122628_ID-11226506601', 'active', '2021-09-28 01:53:31', 'Lazada', 1, '2022-01-16 12:56:46', 0, ''),
(18, 1, 400612677383, NULL, '5767846895', 'BAWANG PUTIH Garlic 100 Kapsul Curah Herbal Wasir Sinusitis Psoriasis', '35000', '1995', 'https://id-live.slatic.net/p/0822365136f3ad2ef5983f4a17d6bcfd.png', '5767846895_ID-11222986240', 'active', '2021-09-26 15:19:23', 'Lazada', 1, '2022-01-16 12:56:46', 0, ''),
(19, 1, 400612677383, NULL, '5766822964', 'PURWACENG Libido Booster 100 kapsul Herbal Jamu Kuat Pria 100', '62000', '2000', 'https://id-live.slatic.net/p/401e68c21b4bb4d8250e247a738a5c01.png', '5766822964_ID-11221532714', 'active', '2021-09-26 04:17:12', 'Lazada', 1, '2022-01-16 12:56:46', 0, ''),
(20, 1, 400612677383, NULL, '5766840706', 'GINSENG Panax  100 Kapsul Curah Herbal Jamu Kuat Pria Herbal Libido', '63000', '1998', 'https://id-live.slatic.net/p/136f0c674ab26295e9e880945bc5ec66.png', '5766840706_ID-11221560082', 'active', '2021-09-26 04:12:19', 'Lazada', 1, '2022-01-16 12:56:46', 0, ''),
(31, 1, NULL, 332128107, '9974275981', 'BAJU/KAOS ANAK DISTRO/PAKAIAN ANAK LAKI-LAKI/KAOS ANAK PREMIUM', 'null', 'null', 'https://cf.shopee.co.id/file/89511ddf3f00a17b11ab05a27f13491b', 'chicago 1-10thn', 'NORMAL', 'Shopee', '2021-07-04 09:12:35', 1, '2022-01-16 13:59:48', NULL, NULL),
(32, 1, NULL, 332128107, '8673981790', 'KAOS ANAK, BAJU KAOS PREMIUM,KAOS ANAK MURAH,KAOS ANAK PEREMPUAN', 'null', 'null', 'https://cf.shopee.co.id/file/f6b7a205222a2ab7a7ccda6112440140', 'harley 1-10 thn', 'NORMAL', 'Shopee', '2021-07-03 10:18:58', 1, '2022-01-16 13:59:48', NULL, NULL),
(33, 1, NULL, 332128107, '7678044909', 'kaos distro anak/kaos anak laki laki/usia 1-5thn/pakaian anak laki-laki', 'null', 'null', 'https://cf.shopee.co.id/file/de2370ee998bc9b8058700f5c7dd4cc2', 'uniqlo 1-10thn', 'NORMAL', 'Shopee', '2021-01-25 10:34:22', 1, '2022-01-16 13:59:48', NULL, NULL),
(34, 1, NULL, 332128107, '8574460114', 'KAOS ANAK BRAND PREMIUM/ KAOS ANAK MURAH/ KAOS ANAK TERBARU', 'null', 'null', 'https://cf.shopee.co.id/file/8f3dc46abd877c5cda633eabfa4df007', 'uniqlo 1-10thn', 'NORMAL', 'Shopee', '2021-07-05 03:30:20', 1, '2022-01-16 13:59:48', NULL, NULL),
(35, 1, NULL, 332128107, '13235463857', 'KAOS ANAK DISTRO/KAOS ANAK LAKI-LAKI/KAOS ANAK PREMIUM', 'null', 'null', 'https://cf.shopee.co.id/file/63cdec5f3f76b9a37cf33afca0da734f', 'badman', 'NORMAL', 'Shopee', '2021-10-24 07:17:03', 1, '2022-01-16 13:59:48', NULL, NULL),
(36, 1, NULL, 332128107, '11466236080', 'kaos anak/kaos anak distro/kaos anak premium/pakain anak laki-laki/baju anak', 'null', 'null', 'https://cf.shopee.co.id/file/f7dbde3e231f65dd151c7130be0fd61e', 'pull dan bear hijau', 'NORMAL', 'Shopee', '2021-10-31 04:51:26', 1, '2022-01-16 13:59:48', NULL, NULL),
(37, 1, NULL, 332128107, '12440288416', 'KAOS ANAK, BAJU ANAK PREMIUM,KAOS ANAK DISTRO/PAKAIAN ANAK LAKI-LAKI', 'null', 'null', 'https://cf.shopee.co.id/file/94f9215fd5322252790f5c405c1a3e07', 'pull dan bear pth', 'NORMAL', 'Shopee', '2021-10-31 04:15:24', 1, '2022-01-16 13:59:48', NULL, NULL),
(38, 1, NULL, 332128107, '12841173679', 'kaos anak distro/kaos anak premium/pakaian anak laki-laki', 'null', 'null', 'https://cf.shopee.co.id/file/d1a53ec95313f269c68c6b78780216ed', 'gap hijau', 'NORMAL', 'Shopee', '2021-11-01 16:32:36', 1, '2022-01-16 13:59:48', NULL, NULL),
(39, 1, NULL, 332128107, '14901758763', 'Dirfay kids Baju Anak Kaos Anak Distro Pakaian Anak Laki Laki', 'null', 'null', 'https://cf.shopee.co.id/file/fb9aac52b8e102c93d2bb43c7bec4126', 'hitam salur', 'NORMAL', 'Shopee', '2021-11-18 14:33:10', 1, '2022-01-16 13:59:48', NULL, NULL),
(40, 1, NULL, 332128107, '10723406617', 'kaos anak,kaos anak premium,kaos anak distro', 'null', 'null', 'https://cf.shopee.co.id/file/3f141a243521962b7eac5b7bdccae8a7', 'salur kuning', 'NORMAL', 'Shopee', '2021-08-04 05:52:30', 1, '2022-01-16 13:59:48', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `toko`
--

CREATE TABLE `toko` (
  `IdToko` bigint(20) NOT NULL,
  `NamaToko` varchar(100) NOT NULL,
  `Alamat` varchar(300) NOT NULL,
  `Telp` varchar(15) NOT NULL,
  `MaxAkun` bigint(20) NOT NULL,
  `Expired` bigint(20) NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `CreatedBy` bigint(20) NOT NULL,
  `CreatedOn` varchar(20) NOT NULL,
  `ModifiedBy` bigint(20) DEFAULT NULL,
  `ModiffiedOn` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `toko`
--

INSERT INTO `toko` (`IdToko`, `NamaToko`, `Alamat`, `Telp`, `MaxAkun`, `Expired`, `Status`, `CreatedBy`, `CreatedOn`, `ModifiedBy`, `ModiffiedOn`) VALUES
(1, 'Super Admin', 'Alamat Super Admin', '62819110191', 900, 32535126000, 1, 1, '2022-01-13 10:40:29', 1, '2022-01-13 07:24:20');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `IdUser` bigint(20) NOT NULL,
  `IdToko` bigint(20) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `CreatedBy` bigint(20) NOT NULL,
  `CreatedOn` varchar(20) NOT NULL,
  `ModifiedBy` bigint(20) DEFAULT NULL,
  `ModiffiedOn` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`IdUser`, `IdToko`, `Username`, `Password`, `CreatedBy`, `CreatedOn`, `ModifiedBy`, `ModiffiedOn`) VALUES
(1, 1, 'SuperAdmin', '1217181787', 1, '2022-01-13 11:11:56', NULL, '2022-01-13 07:15:37');

-- --------------------------------------------------------

--
-- Table structure for table `user_lazada`
--

CREATE TABLE `user_lazada` (
  `IdUserLazada` bigint(20) NOT NULL,
  `IdUser` bigint(20) NOT NULL,
  `IdSeller` bigint(20) NOT NULL,
  `NamaShop` varchar(60) NOT NULL,
  `AksesToken` varchar(100) NOT NULL,
  `ExpiredToken` bigint(20) NOT NULL,
  `RefreshToken` varchar(100) NOT NULL,
  `ExpiredRefreshToken` bigint(20) NOT NULL,
  `CreatedBy` bigint(20) NOT NULL,
  `CreatedOn` varchar(20) NOT NULL,
  `ModifiedBy` bigint(20) DEFAULT NULL,
  `ModifiedOn` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_lazada`
--

INSERT INTO `user_lazada` (`IdUserLazada`, `IdUser`, `IdSeller`, `NamaShop`, `AksesToken`, `ExpiredToken`, `RefreshToken`, `ExpiredRefreshToken`, `CreatedBy`, `CreatedOn`, `ModifiedBy`, `ModifiedOn`) VALUES
(400612677383, 1, 400612677383, 'youshef49@gmail.com', '50000300305ba6pac1b9515e8TKmtkqBwzpTc92JvdHTbxwDYddv5qsUGWCKJtvu', 2592000, '50001300e41kuoynrd8cIVeJRETve9iBvArytdnHJjZDzVliYzNpD1a7644b5H6z', 15552000, 1, '2022-01-13 11:17:41', NULL, '2022-01-14 04:33:38'),
(400615470287, 1, 400615470287, 'zaek2704@gmail.com', '50000700441y7RbbrThVBmHOwMufhZn0HoTbztlAebSCKvVcI3pfa157fc450Y8w', 2592000, '50001700741cFTMesFlos0uQa83l2DpwEySeegjT6lU2CjFJJL9pX154d62114u0', 15552000, 1, '2022-01-13 11:17:41', NULL, '2022-01-14 04:32:07');

-- --------------------------------------------------------

--
-- Table structure for table `user_shopee`
--

CREATE TABLE `user_shopee` (
  `IdUserShopee` bigint(20) NOT NULL,
  `IdUser` bigint(20) NOT NULL,
  `IdSeller` bigint(20) NOT NULL,
  `NamaShop` varchar(60) NOT NULL,
  `AksesToken` varchar(100) NOT NULL,
  `ExpiredToken` bigint(20) NOT NULL,
  `RefreshToken` varchar(100) NOT NULL,
  `ExpiredRefreshToken` bigint(20) NOT NULL,
  `CreatedBy` bigint(20) NOT NULL,
  `CreatedOn` varchar(20) NOT NULL,
  `ModifiedBy` bigint(20) DEFAULT NULL,
  `ModifiedOn` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_shopee`
--

INSERT INTO `user_shopee` (`IdUserShopee`, `IdUser`, `IdSeller`, `NamaShop`, `AksesToken`, `ExpiredToken`, `RefreshToken`, `ExpiredRefreshToken`, `CreatedBy`, `CreatedOn`, `ModifiedBy`, `ModifiedOn`) VALUES
(332128107, 1, 332128107, 'dirfay kids shop', '536548547558526e7149535873416652', 14400, '456b4c6f7955464d754e6a4b474b7955', 0, 1, '16-01-2022', NULL, NULL),
(413909633, 1, 413909633, 'sonicfarms', '61594367447269456e5654754e444455', 14400, '686e484f45746454796a53736b69416f', 0, 1, '16-01-2022', NULL, NULL),
(471468662, 1, 471468662, 'medicalherbalindo', '5063535277544a4b7853596678716a44', 14400, '7566726872637a5054667246466f5346', 0, 1, '16-01-2022', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`IdOrder`),
  ADD UNIQUE KEY `NoOrder` (`NoOrder`),
  ADD KEY `IdOrder` (`IdOrder`,`IdUser`,`IdUserLazada`,`IdUserShopee`,`NoOrder`,`NamaPembeli`,`Harga`,`Status`,`TglPembuatanOrder`,`Platform`,`CreatedBy`,`CreatedOn`,`ModifiedBy`,`ModifiedOn`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`IdProduk`),
  ADD UNIQUE KEY `NoProduk` (`NoProduk`),
  ADD KEY `IdProduk` (`IdProduk`);

--
-- Indexes for table `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`IdToko`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`IdUser`);

--
-- Indexes for table `user_lazada`
--
ALTER TABLE `user_lazada`
  ADD PRIMARY KEY (`IdUserLazada`);

--
-- Indexes for table `user_shopee`
--
ALTER TABLE `user_shopee`
  ADD PRIMARY KEY (`IdUserShopee`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `IdOrder` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=588;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `IdProduk` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `toko`
--
ALTER TABLE `toko`
  MODIFY `IdToko` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `IdUser` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
