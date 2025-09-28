-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2025 at 05:52 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `md_service_sklad`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
                          `id` int(11) NOT NULL,
                          `image` varchar(255) NOT NULL DEFAULT 'default/avatar.png',
                          `type_id` int(11) DEFAULT NULL,
                          `name` varchar(255) NOT NULL,
                          `phone` varchar(255) DEFAULT NULL,
                          `phone_two` varchar(255) DEFAULT NULL,
                          `comment` varchar(255) DEFAULT NULL,
                          `balance` decimal(12,2) DEFAULT 0.00,
                          `status` int(11) DEFAULT 1,
                          `created` datetime DEFAULT current_timestamp(),
                          `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                          `register_id` int(11) DEFAULT NULL,
                          `modify_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `image`, `type_id`, `name`, `phone`, `phone_two`, `comment`, `balance`, `status`, `created`, `updated`, `register_id`, `modify_id`) VALUES
                                                                                                                                                                    (1, 'default/avatar.png', 1, 'Test', '(99)967-0395', '', '', '0.00', -1, '2025-08-21 00:35:26', '2025-09-27 18:08:09', 1, 1),
                                                                                                                                                                    (2, 'client/1758978404.3146.jpg', 1, 'Dilmurod', '(99)967-0395', '', '123213', '0.00', 1, '2025-09-07 16:24:11', '2025-09-27 18:07:51', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `client_type`
--

CREATE TABLE `client_type` (
                               `id` int(11) NOT NULL,
                               `name` varchar(255) NOT NULL,
                               `status` int(11) DEFAULT 1,
                               `created` datetime DEFAULT current_timestamp(),
                               `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                               `register_id` int(11) DEFAULT NULL,
                               `modify_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_type`
--

INSERT INTO `client_type` (`id`, `name`, `status`, `created`, `updated`, `register_id`, `modify_id`) VALUES
                                                                                                         (1, 'Umumiy', 1, '2025-08-18 20:51:45', '2025-08-18 20:51:45', NULL, NULL),
                                                                                                         (2, 'Usta', 1, '2025-08-18 20:51:45', '2025-08-18 20:51:45', NULL, NULL),
                                                                                                         (3, 'testbek', -1, '2025-09-20 12:20:48', '2025-09-25 13:27:59', 1, 1),
                                                                                                         (4, 'ertet', -1, '2025-09-20 12:21:13', '2025-09-20 12:23:22', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `paid`
--

CREATE TABLE `paid` (
                        `id` int(11) NOT NULL,
                        `sale_id` int(11) DEFAULT NULL,
                        `price` decimal(12,2) NOT NULL,
                        `payment_id` int(11) NOT NULL,
                        `client_id` int(11) DEFAULT NULL,
                        `date` date DEFAULT NULL,
                        `status` int(11) DEFAULT 1,
                        `created` datetime DEFAULT current_timestamp(),
                        `updated` datetime DEFAULT current_timestamp(),
                        `register_id` int(11) DEFAULT NULL,
                        `modify_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paid_other`
--

CREATE TABLE `paid_other` (
                              `id` int(11) NOT NULL,
                              `type` enum('INCOME','OUTCOME') DEFAULT NULL,
                              `group_id` int(11) DEFAULT NULL,
                              `description` text DEFAULT NULL,
                              `paid_date` date DEFAULT NULL,
                              `payment_id` int(11) DEFAULT NULL,
                              `price` decimal(12,2) DEFAULT NULL,
                              `status` int(11) DEFAULT 1,
                              `created` datetime DEFAULT current_timestamp(),
                              `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                              `register_id` int(11) DEFAULT NULL,
                              `modify_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paid_other_group`
--

CREATE TABLE `paid_other_group` (
                                    `id` int(11) NOT NULL,
                                    `name` varchar(255) DEFAULT NULL,
                                    `status` int(11) DEFAULT 1,
                                    `created` datetime DEFAULT current_timestamp(),
                                    `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                                    `register_id` int(11) DEFAULT NULL,
                                    `modify_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paid_other_group`
--

INSERT INTO `paid_other_group` (`id`, `name`, `status`, `created`, `updated`, `register_id`, `modify_id`) VALUES
                                                                                                              (1, 'Yo\'l xarajatlari', 1, '2025-09-25 13:55:21', '2025-09-25 13:55:21', 1, 1),
(2, 'Qaytarib berilgan pullar', 1, '2025-09-25 13:55:49', '2025-09-25 13:55:49', 1, 1),
(3, 'Testbek', -1, '2025-09-25 13:55:58', '2025-09-25 13:57:37', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `paid_worker`
--

CREATE TABLE `paid_worker` (
  `id` int(11) NOT NULL,
  `worker_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `price` decimal(12,2) DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `register_id` int(11) DEFAULT NULL,
  `modify_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `register_id` int(11) DEFAULT NULL,
  `modify_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `name`, `status`, `created`, `updated`, `register_id`, `modify_id`) VALUES
(1, 'Naqd', 1, '2025-08-18 20:55:08', '2025-09-07 16:11:30', 1, 1),
(2, 'Plastik', 1, '2025-08-18 20:55:08', '2025-09-07 16:11:33', 1, 1),
(3, 'Click', 1, '2025-08-18 20:55:08', '2025-09-07 16:11:35', 1, 1),
(4, 'Bank', 1, '2025-08-18 20:55:08', '2025-09-07 16:12:39', 1, 1),
(6, 'testbekas', -1, '2025-09-25 13:59:02', '2025-09-25 13:59:09', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `type` enum('SERVICE','PRODUCT') DEFAULT 'SERVICE' COMMENT '1-mahsulot 2-xizmat',
  `name` varchar(255) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `price` decimal(12,2) DEFAULT 0.00,
  `register_id` int(11) DEFAULT NULL,
  `modify_id` int(11) DEFAULT NULL,
  `min_volume` decimal(12,2) DEFAULT NULL,
  `volume_price` decimal(12,2) DEFAULT NULL,
  `price_worker` decimal(12,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Mahsulot yoki xizmat';

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `type`, `name`, `group_id`, `unit_id`, `image`, `status`, `created`, `updated`, `price`, `register_id`, `modify_id`, `min_volume`, `volume_price`, `price_worker`) VALUES
(1, 'SERVICE', 'Stayashka', 1, 2, 'default/nophoto.png', 1, '2025-08-21 00:32:29', '2025-09-28 20:12:14', '20000.00', 1, 1, '100.00', '1200000.00', '18000.00'),
(2, 'SERVICE', 'Testbek', 1, 1, 'goods/1758967581.8821.jpg', -1, '2025-09-27 15:05:53', '2025-09-27 18:00:04', '25000.00', 1, 1, '100.00', '1200000.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `product_group`
--

CREATE TABLE `product_group` (
  `id` int(11) NOT NULL COMMENT '1-mahsulot, 2-xizmat',
  `name` varchar(255) NOT NULL,
  `status` int(11) DEFAULT 1,
  `image` varchar(255) DEFAULT NULL,
  `type` enum('SERVICE','PRODUCT') NOT NULL DEFAULT 'SERVICE',
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `register_id` int(11) DEFAULT NULL,
  `modify_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_group`
--

INSERT INTO `product_group` (`id`, `name`, `status`, `image`, `type`, `created`, `updated`, `register_id`, `modify_id`) VALUES
(1, 'Qurilish', 1, 'default/nophoto.png', 'SERVICE', '2025-08-21 00:29:26', '2025-08-21 00:29:26', NULL, NULL),
(2, 'asdasd', -1, 'goodsgroup/1758789767.7046.jpg', 'SERVICE', '2025-09-25 13:41:54', '2025-09-25 13:42:56', 1, 1),
(3, 'tewstbek', -1, 'default/nophoto.png', 'SERVICE', '2025-09-25 13:59:26', '2025-09-25 14:00:39', 1, 1),
(4, 'testasd', -1, 'goodsgroup/1758790848.6891.jpg', 'SERVICE', '2025-09-25 14:00:42', '2025-09-25 14:00:50', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_unit`
--

CREATE TABLE `product_unit` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `register_id` int(11) DEFAULT NULL,
  `modify_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_unit`
--

INSERT INTO `product_unit` (`id`, `name`, `status`, `created`, `updated`, `register_id`, `modify_id`) VALUES
(1, 'Kv.m.', 1, '2025-09-24 23:26:28', '2025-09-24 23:26:28', 1, 1),
(2, 'Kub', 1, '2025-09-24 23:27:01', '2025-09-24 23:27:01', 1, 1),
(3, 'test', -1, '2025-09-24 23:27:29', '2025-09-24 23:29:07', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `code_id` int(11) DEFAULT 1,
  `client_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(12,2) DEFAULT 0.00,
  `debt` decimal(12,2) DEFAULT 0.00,
  `credit` decimal(12,2) DEFAULT 0.00,
  `worker_id` int(11) NOT NULL,
  `state` enum('NEW','RUNNING','DONE','CANCELLED') DEFAULT 'NEW',
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `register_id` int(11) DEFAULT NULL,
  `modify_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `volume` decimal(12,2) DEFAULT 0.00,
  `volume_estimated` decimal(12,2) DEFAULT 0.00,
  `address` varchar(255) DEFAULT NULL,
  `price_per` decimal(12,2) DEFAULT 0.00,
  `min_volume` decimal(12,2) DEFAULT 0.00,
  `min_price` decimal(12,2) DEFAULT 0.00,
  `price_worker` decimal(12,2) DEFAULT 0.00,
  `total_price_worker` decimal(12,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`id`, `date`, `code`, `code_id`, `client_id`, `product_id`, `price`, `debt`, `credit`, `worker_id`, `state`, `created`, `updated`, `register_id`, `modify_id`, `status`, `volume`, `volume_estimated`, `address`, `price_per`, `min_volume`, `min_price`, `price_worker`, `total_price_worker`) VALUES
(1, '2025-09-28', NULL, 1, 2, 1, '4400000.00', '0.00', '0.00', 1, 'NEW', '2025-09-28 16:53:16', '2025-09-28 18:40:27', 1, 1, 1, '0.00', '220.00', 'Urganch shahar IT Park binosi', '20000.00', '100.00', '1200000.00', NULL, '0.00'),
(2, '2025-09-28', '252', 2, 2, 1, '5600000.00', '0.00', '0.00', 1, 'DONE', '2025-09-28 18:49:36', '2025-09-28 20:40:12', 1, 1, 1, '280.00', '120.00', 'Test', '20000.00', '100.00', '1200000.00', '18000.00', '5040000.00');

-- --------------------------------------------------------

--
-- Table structure for table `sale_log`
--

CREATE TABLE `sale_log` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `register_id` int(11) DEFAULT NULL,
  `state` enum('NEW','RUNNING','UPDATED','COMPLETED','CANCELLED') DEFAULT 'NEW',
  `created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale_log`
--

INSERT INTO `sale_log` (`id`, `sale_id`, `register_id`, `state`, `created`) VALUES
(1, 1, 1, 'NEW', '2025-09-28 18:37:29'),
(2, 2, 1, 'NEW', '2025-09-28 18:49:36'),
(3, 2, 1, 'UPDATED', '2025-09-28 18:52:52'),
(4, 2, 1, 'UPDATED', '2025-09-28 20:15:48'),
(5, 2, 1, 'RUNNING', '2025-09-28 20:26:29'),
(6, 2, 1, 'COMPLETED', '2025-09-28 20:40:12');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(500) DEFAULT NULL,
  `auth_key` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `access_token` varchar(500) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) DEFAULT 1,
  `role_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'default/avatar.png',
  `phone` varchar(255) NOT NULL DEFAULT '',
  `chat_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `auth_key`, `token`, `code`, `access_token`, `created`, `updated`, `status`, `role_id`, `image`, `phone`, `chat_id`) VALUES
(1, 'Admin', 'admin', '$2y$13$cW4FDIl.S5zCEEAl4we0FuRahZRLtTQYUz4nUHcX2k2bz6yZ9kTyy', NULL, NULL, NULL, NULL, '2024-10-10 18:51:55', '2025-09-07 16:13:44', 1, 100, 'avatar/1757243624.9893.png', '+998997317978', NULL),
(3, 'Dilmurod', 'dilmurod', '$2y$13$rNfE6FoxNBnFeieOB/8G.ef6SNjbXQgiU.LXUr6dZsLxyPH/pXRVy', NULL, NULL, NULL, NULL, '2025-01-05 12:44:39', '2025-09-25 13:58:43', 1, 100, 'avatar/1758790723.3385.jpg', '+998999670395', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `name`, `url`, `status`, `created`, `updated`) VALUES
(50, 'Haydovchi', '/driver/', 1, '2025-09-01 20:18:04', '2025-09-01 20:18:04'),
(60, 'Xizmat ko\'rsatuvchi', '/service/', 1, '2025-09-01 20:18:04', '2025-09-01 20:18:04'),
                                                                                                              (70, 'Sotuvchi', '/sale/', 1, '2025-09-01 20:18:04', '2025-09-01 20:18:04'),
                                                                                                              (80, 'Call center', '/cc/', 1, '2025-09-01 20:18:04', '2025-09-01 20:18:04'),
                                                                                                              (90, 'Sklad', '/wh/', 1, '2025-09-01 20:18:04', '2025-09-01 20:18:04'),
                                                                                                              (100, 'Admin', '/cp/', 1, '2025-09-01 20:18:04', '2025-09-01 20:18:04');

-- --------------------------------------------------------

--
-- Table structure for table `worker`
--

CREATE TABLE `worker` (
                          `id` int(11) NOT NULL,
                          `name` varchar(255) NOT NULL DEFAULT '',
                          `phone` varchar(255) DEFAULT NULL,
                          `description` text DEFAULT NULL,
                          `image` varchar(255) DEFAULT NULL,
                          `status` int(11) DEFAULT 1,
                          `created` datetime DEFAULT current_timestamp(),
                          `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                          `register_id` int(11) DEFAULT NULL,
                          `modify_id` int(11) DEFAULT NULL,
                          `balance` decimal(12,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `worker`
--

INSERT INTO `worker` (`id`, `name`, `phone`, `description`, `image`, `status`, `created`, `updated`, `register_id`, `modify_id`, `balance`) VALUES
                                                                                                                                                (1, 'Dilmurod', '(99) 967-03-95', '', 'avatar/1758966552.7765.jpg', 1, '2025-09-27 14:46:50', '2025-09-27 14:49:12', 1, 1, '0.00'),
                                                                                                                                                (2, 'Testbek', '(99) 967-03-95', '', 'default/nophoto.png', -1, '2025-09-27 14:55:09', '2025-09-27 14:55:14', 1, 1, '0.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
    ADD PRIMARY KEY (`id`),
  ADD KEY `FK_client_type_id` (`type_id`),
  ADD KEY `IDX_client_name` (`name`),
  ADD KEY `IDX_client_phone` (`phone`),
  ADD KEY `IDX_client_status` (`status`),
  ADD KEY `FK_client_register_id` (`register_id`),
  ADD KEY `FK_client_modify_id` (`modify_id`);

--
-- Indexes for table `client_type`
--
ALTER TABLE `client_type`
    ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_client_type_name` (`name`),
  ADD KEY `IDX_client_type_status` (`status`),
  ADD KEY `FK_client_type_register_id` (`register_id`),
  ADD KEY `FK_client_type_modify_id` (`modify_id`);

--
-- Indexes for table `paid`
--
ALTER TABLE `paid`
    ADD PRIMARY KEY (`id`),
  ADD KEY `FK_paid_payment_id` (`payment_id`),
  ADD KEY `FK_paid_register_id` (`register_id`),
  ADD KEY `FK_paid_modify_id` (`modify_id`),
  ADD KEY `FK_paid_client_id` (`client_id`),
  ADD KEY `FK_paid_sale_id` (`sale_id`),
  ADD KEY `IDX_paid_date` (`date`),
  ADD KEY `IDX_paid_status` (`status`);

--
-- Indexes for table `paid_other`
--
ALTER TABLE `paid_other`
    ADD PRIMARY KEY (`id`),
  ADD KEY `FK_paid_other_group_id` (`group_id`),
  ADD KEY `FK_paid_other_payment_id` (`payment_id`),
  ADD KEY `IDX_paid_other_paid_date` (`paid_date`),
  ADD KEY `IDX_paid_other_status` (`status`),
  ADD KEY `FK_paid_other_register_id` (`register_id`),
  ADD KEY `FK_paid_other_modify_id` (`modify_id`);

--
-- Indexes for table `paid_other_group`
--
ALTER TABLE `paid_other_group`
    ADD PRIMARY KEY (`id`),
  ADD KEY `FK_other_paid_type_register_id` (`register_id`),
  ADD KEY `FK_other_paid_type_modify_id` (`modify_id`),
  ADD KEY `IDX_paid_other_group_name` (`name`);

--
-- Indexes for table `paid_worker`
--
ALTER TABLE `paid_worker`
    ADD PRIMARY KEY (`id`),
  ADD KEY `FK_paid_worker_worker_id` (`worker_id`),
  ADD KEY `FK_paid_worker_payment_id` (`payment_id`),
  ADD KEY `FK_paid_worker_register_id` (`register_id`),
  ADD KEY `FK_paid_worker_modify_id` (`modify_id`),
  ADD KEY `FK_paid_worker_sale_id` (`sale_id`),
  ADD KEY `IDX_paid_worker_date` (`date`),
  ADD KEY `IDX_paid_worker_status` (`status`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
    ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_payment_name` (`name`),
  ADD KEY `IDX_payment_status` (`status`),
  ADD KEY `FK_payment_register_id` (`register_id`),
  ADD KEY `FK_payment_modify_id` (`modify_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
    ADD PRIMARY KEY (`id`),
  ADD KEY `FK_goods_group_id` (`group_id`),
  ADD KEY `FK_goods_unit_id` (`unit_id`),
  ADD KEY `IDX_product_status` (`status`),
  ADD KEY `IDX_product_type` (`type`),
  ADD KEY `IDX_product_name` (`name`),
  ADD KEY `FK_product_register_id` (`register_id`),
  ADD KEY `FK_product_modify_id` (`modify_id`);

--
-- Indexes for table `product_group`
--
ALTER TABLE `product_group`
    ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_product_group_name` (`name`),
  ADD KEY `IDX_product_group_status` (`status`),
  ADD KEY `IDX_product_group_type` (`type`),
  ADD KEY `FK_product_group_register_id` (`register_id`),
  ADD KEY `FK_product_group_modify_id` (`modify_id`);

--
-- Indexes for table `product_unit`
--
ALTER TABLE `product_unit`
    ADD PRIMARY KEY (`id`),
  ADD KEY `FK_product_unit_register_id` (`register_id`),
  ADD KEY `FK_product_unit_modify_id` (`modify_id`),
  ADD KEY `IDX_product_unit_name` (`name`),
  ADD KEY `IDX_product_unit_status` (`status`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
    ADD PRIMARY KEY (`id`),
  ADD KEY `FK_sale_client_id` (`client_id`),
  ADD KEY `FK_sale_product_id` (`product_id`),
  ADD KEY `FK_sale_register_id` (`register_id`),
  ADD KEY `FK_sale_modify_id` (`modify_id`),
  ADD KEY `FK_sale_worker_id` (`worker_id`),
  ADD KEY `IDX_sale_date` (`date`),
  ADD KEY `IDX_sale_code` (`code`),
  ADD KEY `IDX_sale_status` (`status`),
  ADD KEY `IDX_sale_state` (`state`);

--
-- Indexes for table `sale_log`
--
ALTER TABLE `sale_log`
    ADD PRIMARY KEY (`id`),
  ADD KEY `FK_sale_log_sale_id` (`sale_id`),
  ADD KEY `FK_sale_log_register_id` (`register_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `FK_user_role_id` (`role_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `worker`
--
ALTER TABLE `worker`
    ADD PRIMARY KEY (`id`),
  ADD KEY `FK_worker_register_id` (`register_id`),
  ADD KEY `FK_worker_modify_id` (`modify_id`),
  ADD KEY `IDX_worker_name` (`name`),
  ADD KEY `IDX_worker_phone` (`phone`),
  ADD KEY `IDX_worker_status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `client_type`
--
ALTER TABLE `client_type`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `paid`
--
ALTER TABLE `paid`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paid_other`
--
ALTER TABLE `paid_other`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paid_other_group`
--
ALTER TABLE `paid_other_group`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `paid_worker`
--
ALTER TABLE `paid_worker`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_group`
--
ALTER TABLE `product_group`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '1-mahsulot, 2-xizmat', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_unit`
--
ALTER TABLE `product_unit`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sale_log`
--
ALTER TABLE `sale_log`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `worker`
--
ALTER TABLE `worker`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `client`
--
ALTER TABLE `client`
    ADD CONSTRAINT `FK_client_modify_id` FOREIGN KEY (`modify_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_client_register_id` FOREIGN KEY (`register_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_client_type_id` FOREIGN KEY (`type_id`) REFERENCES `client_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `client_type`
--
ALTER TABLE `client_type`
    ADD CONSTRAINT `FK_client_type_modify_id` FOREIGN KEY (`modify_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_client_type_register_id` FOREIGN KEY (`register_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `paid`
--
ALTER TABLE `paid`
    ADD CONSTRAINT `FK_paid_client_id` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_paid_modify_id` FOREIGN KEY (`modify_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_paid_payment_id` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_paid_register_id` FOREIGN KEY (`register_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_paid_sale_id` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `paid_other`
--
ALTER TABLE `paid_other`
    ADD CONSTRAINT `FK_paid_other_group_id` FOREIGN KEY (`group_id`) REFERENCES `paid_other_group` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_paid_other_modify_id` FOREIGN KEY (`modify_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_paid_other_payment_id` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_paid_other_register_id` FOREIGN KEY (`register_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `paid_other_group`
--
ALTER TABLE `paid_other_group`
    ADD CONSTRAINT `FK_other_paid_type_modify_id` FOREIGN KEY (`modify_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_other_paid_type_register_id` FOREIGN KEY (`register_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `paid_worker`
--
ALTER TABLE `paid_worker`
    ADD CONSTRAINT `FK_paid_worker_modify_id` FOREIGN KEY (`modify_id`) REFERENCES `worker` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_paid_worker_payment_id` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_paid_worker_register_id` FOREIGN KEY (`register_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_paid_worker_sale_id` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_paid_worker_worker_id` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
    ADD CONSTRAINT `FK_payment_modify_id` FOREIGN KEY (`modify_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_payment_register_id` FOREIGN KEY (`register_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
    ADD CONSTRAINT `FK_product_group_id` FOREIGN KEY (`group_id`) REFERENCES `product_group` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_product_modify_id` FOREIGN KEY (`modify_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_product_register_id` FOREIGN KEY (`register_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_product_unit_id` FOREIGN KEY (`unit_id`) REFERENCES `product_unit` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_group`
--
ALTER TABLE `product_group`
    ADD CONSTRAINT `FK_product_group_modify_id` FOREIGN KEY (`modify_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_product_group_register_id` FOREIGN KEY (`register_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_unit`
--
ALTER TABLE `product_unit`
    ADD CONSTRAINT `FK_product_unit_modify_id` FOREIGN KEY (`modify_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_product_unit_register_id` FOREIGN KEY (`register_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sale`
--
ALTER TABLE `sale`
    ADD CONSTRAINT `FK_sale_client_id` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_sale_modify_id` FOREIGN KEY (`modify_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_sale_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_sale_register_id` FOREIGN KEY (`register_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_sale_worker_id` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sale_log`
--
ALTER TABLE `sale_log`
    ADD CONSTRAINT `FK_sale_log_register_id` FOREIGN KEY (`register_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_sale_log_sale_id` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
    ADD CONSTRAINT `FK_user_role_id2` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `worker`
--
ALTER TABLE `worker`
    ADD CONSTRAINT `FK_worker_modify_id` FOREIGN KEY (`modify_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_worker_register_id` FOREIGN KEY (`register_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
