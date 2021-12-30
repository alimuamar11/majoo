-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2021 at 12:31 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `majoo`
--

-- --------------------------------------------------------

--
-- Table structure for table `c_base_menu`
--

CREATE TABLE `c_base_menu` (
  `id` int(11) NOT NULL,
  `title` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `order_no` int(2) NOT NULL,
  `end_point` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `access_code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `actions_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `has_child` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `c_base_menu`
--

INSERT INTO `c_base_menu` (`id`, `title`, `order_no`, `end_point`, `icon`, `access_code`, `actions_code`, `has_child`) VALUES
(3, 'Kategori', 3, 'master-data/kategori', 'fa-address-card', '', '', 0),
(2, 'Produk', 2, 'master-data/produk', 'fa-address-card', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `c_menus`
--

CREATE TABLE `c_menus` (
  `id` int(11) NOT NULL,
  `base_id` int(2) NOT NULL,
  `title` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `end_point` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `access_code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `actions_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `order_no` int(1) NOT NULL,
  `enabled` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `c_users`
--

CREATE TABLE `c_users` (
  `uid` int(11) NOT NULL,
  `uname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `passwd` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `accessibility` text COLLATE utf8_unicode_ci NOT NULL,
  `actions_code` text COLLATE utf8_unicode_ci NOT NULL,
  `level` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `last_page` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `related_pic` int(5) NOT NULL,
  `template` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'indonesia',
  `profile` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `provider_id` int(10) NOT NULL,
  `enabled` int(11) NOT NULL DEFAULT 1,
  `created_by` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_by` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `c_users`
--

INSERT INTO `c_users` (`uid`, `uname`, `passwd`, `email`, `name`, `accessibility`, `actions_code`, `level`, `last_page`, `related_pic`, `template`, `lang`, `profile`, `provider_id`, `enabled`, `created_by`, `created_at`, `update_by`, `updated_at`) VALUES
(136793619, 'amar', '87d9bb400c0634691f0e3baaf1e2fd0d', 'admin@majoo.com', 'majoo- Admin', '', '', 'c-spadmin', '', 0, 'ctc-azia-topbar', 'indonesia', '136793619.png', 1, 1, '', '2021-12-28 14:26:24', '', '2021-12-29 16:03:14');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `id_kategori` int(100) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Gadget'),
(2, 'Laptop'),
(4, 'Test e');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_produk`
--

CREATE TABLE `tbl_produk` (
  `id_produk` int(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` double NOT NULL,
  `fk_kategori` int(100) NOT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_produk`
--

INSERT INTO `tbl_produk` (`id_produk`, `nama`, `deskripsi`, `harga`, `fk_kategori`, `image`) VALUES
(21, 'produk 2 desktop', 'Lorem ipsum, atau ringkasnya lipsum, adalah teks standar yang ditempatkan untuk mendemostrasikan elemen grafis atau presentasi visual seperti font,', 2000000, 2, 'paket-desktop.png'),
(22, 'Laptop', 'Mix and match multiple content types to create the card you need, or throw everything in there. Shown below are image styles, blocks, text styles, and a list group&mdash;all wrapped in a fixed-width card.', 3000000, 2, 'paket-advance.png'),
(23, 'Edvice', 'Mix and match multiple content types to create the card you need, or throw everything in there. Shown below are image styles, blocks, text styles, and a list group&mdash;all wrapped in a fixed-width card.\r\n\r\nMix and match multiple content types to create the card you need, or throw everything in there. Shown below are image styles, blocks, text styles, and a list group&mdash;all wrapped in a fixed-width card.', 4000000, 2, 'standard_repo.png'),
(24, 'Lenowo', 'teks deskripsi sudah tidak asing lagi. Namun, mungkin ada sebagian dari kalian yang belum faham dan mengerti betul tentang teks deskripsi. Sebagian', 2000000, 1, 'paket-desktop5.png'),
(25, 'Produk 3', 'teks deskripsi sudah tidak asing lagi. Namun, mungkin ada sebagian dari kalian yang belum faham dan mengerti betul tentang teks deskripsi. Sebagian dari kalian mungkin belum bisa membedakan teks deskripsi dengan', 4000000, 4, 'paket-desktop4.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `c_base_menu`
--
ALTER TABLE `c_base_menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD KEY `access_code` (`access_code`),
  ADD KEY `end_point` (`end_point`),
  ADD KEY `icon` (`icon`),
  ADD KEY `actions_code` (`actions_code`);

--
-- Indexes for table `c_menus`
--
ALTER TABLE `c_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `base_id` (`base_id`,`title`,`end_point`,`access_code`),
  ADD KEY `actions_code` (`actions_code`),
  ADD KEY `enabled` (`enabled`);

--
-- Indexes for table `c_users`
--
ALTER TABLE `c_users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `uname` (`uname`),
  ADD KEY `passwd` (`passwd`,`email`,`name`,`level`,`enabled`),
  ADD KEY `related_pic` (`related_pic`),
  ADD KEY `template` (`template`),
  ADD KEY `lang` (`lang`),
  ADD KEY `last_page` (`last_page`);

--
-- Indexes for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `c_base_menu`
--
ALTER TABLE `c_base_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `c_menus`
--
ALTER TABLE `c_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  MODIFY `id_kategori` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  MODIFY `id_produk` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
