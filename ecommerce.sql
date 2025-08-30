-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2025 at 07:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(6) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `image`, `created_at`) VALUES
(3, 'admin', 'admin@gmail.com', '$2y$10$Tq63Qo6CLu9PlExoR18hyu6w/D7MV2B6MbBmDh8KGijc0caMjOpaK', '1755208020-user profile.jpg', '2025-08-09 21:48:48');

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` int(6) NOT NULL,
  `product_id` int(6) NOT NULL,
  `sizes` varchar(200) DEFAULT NULL,
  `colors` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `product_id`, `sizes`, `colors`, `created_at`) VALUES
(42, 74, 'M,L,XL,XXL', '#ebeaec', '2025-08-11 18:02:54'),
(43, 75, 'M,L,XL', '#e8f2ef', '2025-08-11 18:04:18'),
(44, 79, '', '#000000,#ffffff,#d81818', '2025-08-11 21:14:32'),
(45, 80, 'M,L,XL,XXL', '#000000,#d4d4d4', '2025-08-13 19:08:57'),
(46, 81, 'L,XXL', '#4620d7,#000000', '2025-08-28 18:57:45');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('open','ordered') DEFAULT 'open',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,0) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(6) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `created_at`) VALUES
(34, 'Cloths', '2025-08-11 17:50:23'),
(35, 'Electronics', '2025-08-11 17:50:32'),
(36, 'Food', '2025-08-11 17:50:36'),
(37, 'Books', '2025-08-11 17:50:47'),
(38, 'accessories', '2025-08-11 17:51:30');

-- --------------------------------------------------------

--
-- Table structure for table `contact_message`
--

CREATE TABLE `contact_message` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(200) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `is_replied` int(11) DEFAULT 0,
  `is_read` int(1) NOT NULL DEFAULT 0,
  `replied_text` text DEFAULT NULL,
  `replied_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `change_type` enum('in','out') NOT NULL,
  `quantity` int(11) NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_id`, `change_type`, `quantity`, `remark`, `created_at`) VALUES
(36, 79, 'in', 20, '', '2025-08-13 19:52:14'),
(37, 79, 'out', 10, 'hi', '2025-08-19 19:25:05');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL COMMENT 'Primary Key',
  `product_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `selling_price` int(8) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `stock_amount` int(11) NOT NULL,
  `has_attributes` tinyint(1) DEFAULT NULL,
  `category_id` int(6) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `description`, `product_price`, `selling_price`, `product_image`, `stock_amount`, `has_attributes`, `category_id`, `created_at`) VALUES
(74, 'T shirt', 'Dolor fuga Quia non', 350.00, 500, '467445.jpg', 100, 1, 34, '2025-08-11 18:02:54'),
(75, 'Pants', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 450.00, 800, '187227.jpg', 100, 1, 34, '2025-08-11 18:04:18'),
(76, 'Ornament', 'Id qui rerum id lab', 100000.00, 120000, '675500.jpg', 5, 0, 38, '2025-08-11 18:05:51'),
(77, 'burger', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 200.00, 250, '194907.jpg', 20, 0, 36, '2025-08-11 18:06:39'),
(78, 'Book', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy.', 200.00, 350, '739882.jpg', 30, 0, 37, '2025-08-11 18:16:01'),
(79, 'Headphone', 'Lorem ipum', 990.00, 1500, '26994.jpg', 20, 1, 35, '2025-08-11 21:14:32'),
(80, 'Trouser', 'Sit laboris itaque', 800.00, 1200, '997643.jpg', 60, 1, 34, '2025-08-13 19:08:57'),
(81, 'Raymond Vaughn', 'Qui dolore quo quis', 455.00, 341, '393504.png', 71, 1, 37, '2025-08-28 18:57:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(6) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(150) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `reset_token` varchar(150) NOT NULL,
  `reset_expires` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `token`, `verified`, `reset_token`, `reset_expires`, `created_at`) VALUES
(7, 'vumet', 'kimlupigno@necub.com', '$2y$10$ElbRD6ptndQKmGSa/vDoHuxWad8rHeF16bST8AVTHHCqUQw0.h83q', '', 1, '', '0000-00-00 00:00:00', '2025-08-18 21:59:53'),
(8, 'jecugo', 'dulturedro@necub.com', '$2y$10$ULARbgUKUpBkfrupkGD.eOjrr.AOq2Z/XWa9nFJqHerkKirFn7bka', '', 1, '', '0000-00-00 00:00:00', '2025-08-19 07:19:04'),
(9, 'vesepoxiq', 'saqlinemoaj@gmail.com', '$2y$10$BfcHorgVRHO35S5PGzEpDOiFeWoVB93PPlhFwxCeCnDNp8UYKM6o2', '', 1, '', '0000-00-00 00:00:00', '2025-08-19 18:06:38'),
(10, 'lymyqepoh', 'lysyw@mailinator.com', '$2y$10$6PI0rRYcIUj1eOYCgCf91..90u69yvqwDKDmg3vCIBfyVp06Mwnn2', '89862778b4e81be79257ea23841bf1a2', 0, '', '0000-00-00 00:00:00', '2025-08-25 18:40:32'),
(11, 'lumenocybu', 'yaniwil154@namestal.com', '$2y$10$coH4meo/JKmnidwlPvZiJuIGf5SkGVLoxsAgzqCeCCg49ptggXOv.', '', 1, '', '0000-00-00 00:00:00', '2025-08-25 18:41:36'),
(12, 'laguhyliqe', 'qily@mailinator.com', '$2y$10$x8X6qfckF1clkAgADhNuCeU/oPyp4iTWsW0lcbMtGK2C1YAwAe65i', 'b35367a33b6a4384c5041ff694385b2b', 0, '', '0000-00-00 00:00:00', '2025-08-30 12:02:34'),
(13, 'dufavoratu', 'vakojon709@noidem.com', '$2y$10$omeMERwa0lAENaWAObQjL.tyrQ.EHXR84z4qoJYZkxkqT6YM2JRY2', '', 1, '', '0000-00-00 00:00:00', '2025-08-30 12:03:59'),
(14, 'vawyquqi', 'goydumoste@necub.com', '$2y$10$BRlFCzyDq4EpEUbewqRvd.blCzEX0pOjzfag2c7r5d.gzAt1qlaba', '', 1, '', '0000-00-00 00:00:00', '2025-08-30 12:33:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_cart_product` (`cart_id`,`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_message`
--
ALTER TABLE `contact_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_contact_email` (`email`),
  ADD KEY `idx_contact_is_replied` (`is_replied`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `contact_message`
--
ALTER TABLE `contact_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key', AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attributes`
--
ALTER TABLE `attributes`
  ADD CONSTRAINT `attributes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
