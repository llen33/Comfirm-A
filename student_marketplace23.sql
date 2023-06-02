-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2023 at 06:57 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_marketplace23`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `admin_name` varchar(50) NOT NULL,
  `admin_password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`admin_name`, `admin_password`) VALUES
('thiviyaa', 'csd21010'),
('bhuant', 'csd21003'),
('jingyi', 'csd21005'),
('ellen', 'csd21007');

-- --------------------------------------------------------

--
-- Table structure for table `buyer`
--

CREATE TABLE `buyer` (
  `buyer_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buyer`
--

INSERT INTO `buyer` (`buyer_id`, `user_id`) VALUES
(1, 22),
(2, 24),
(3, 25),
(4, 26),
(5, 27);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `name`, `price`, `image`, `quantity`) VALUES
(0, 'test', '3.00', '', 1),
(0, 'huhuh', '30.00', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `image_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `path` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`image_id`, `product_id`, `path`) VALUES
(11, 10, 'uploaded_img/phn1.jpg'),
(12, 11, 'uploaded_img/1a9686d0cbb248c09a0b559619a98119.png'),
(14, 13, 'uploaded_img/1a9686d0cbb248c09a0b559619a98119.png');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(255) NOT NULL,
  `name` varchar(500) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(255) NOT NULL,
  `method` varchar(100) NOT NULL,
  `flat` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `pin_code` int(10) NOT NULL,
  `total_products` varchar(255) NOT NULL,
  `total_price` varchar(255) NOT NULL,
  `country` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `name`, `number`, `email`, `method`, `flat`, `street`, `city`, `state`, `pin_code`, `total_products`, `total_price`, `country`) VALUES
(1, '0', '01164896041', 'bhuant09@gmail.com', '0', 'Block 3,13 floor,1 house Desa mawar,lintang kampung melayu 2', 'Farlim', 'Air itam', 'Penang', 11500, 'burger (1) ', '16', 'MALAYSIA'),
(2, '0', '01164896041', 'bhuant09@gmail.com', '0', 'Block 3,13 floor,1 house Desa mawar,lintang kampung melayu 2', 'Farlim', 'Air itam', 'Penang', 11500, 'Nokia (5) ', '450', 'MALAYSIA');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `quantity` int(10) DEFAULT NULL,
  `product_condition` varchar(255) DEFAULT NULL,
  `seller_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `price`, `description`, `category`, `quantity`, `product_condition`, `seller_id`) VALUES
(10, 'huhuh', 30.00, 'askjwajnn', 'Book', 10, '10/10', 8),
(11, 'test', 3.00, 'fhggyjytuyt', 'Stationary', 3, 'terytrytr', 9),
(13, 'tvyanew', 3.00, 'qwer', 'Stationary', 1, '10/10', 9);

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `seller_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`seller_id`, `user_id`) VALUES
(7, 20),
(8, 21),
(9, 23);

-- --------------------------------------------------------

--
-- Table structure for table `test_order`
--

CREATE TABLE `test_order` (
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(10) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_order`
--

INSERT INTO `test_order` (`user_id`, `product_id`, `name`, `price`, `quantity`, `total`, `order_id`) VALUES
(0, 12, 'shoe', 3.00, 2, 9.00, 17),
(NULL, 12, 'shoe', 3.00, 2, 12.00, 20),
(NULL, 11, 'test', 3.00, 2, 12.00, 21),
(NULL, 12, 'shoe', 3.00, 1, 3.00, 22),
(NULL, 12, 'shoe', 3.00, 1, 3.00, 23),
(NULL, 11, 'test', 3.00, 2, 6.00, 24),
(NULL, 10, 'huhuh', 30.00, 1, 30.00, 25),
(NULL, 11, 'test', 3.00, 1, 3.00, 26),
(NULL, 10, 'huhuh', 30.00, 1, 39.00, 27),
(NULL, 11, 'test', 3.00, 2, 39.00, 28),
(NULL, 13, 'tvyanew', 3.00, 1, 39.00, 29),
(NULL, 11, 'test', 3.00, 3, 9.00, 30);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `home_address` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `username`, `password`, `email`, `phone_number`, `home_address`, `role`) VALUES
(20, 'bhuant', 'gg', 'messi', '1234', 'bhuant09@gmail.com', '01164896041', 'Block 3,13 floor,1 house Desa mawar,lintang kampung melayu 2', 'seller'),
(21, 'luffy', 'monkey', 'luffy', '4321', 'bhuant90@gmail.com', '0192839922', 'Block 3,13 floor,1 house Desa mawar,lintang kampung melayu 2', 'seller'),
(22, 'naruto', 'uzumaki', 'naruto', '2425', 'bhuant90@gmail.com', '0192839922', 'Block 3,13 floor,1 house Desa mawar,lintang kampung melayu 2', 'buyer'),
(23, 'Thiviyaa', 'Sarawanan', 'test2323', '1234', 'tvyatvya2003@gmail.com', '0175506860', '15-5-05 Sri Impian,lengkok angsana,bandar baru air itam', 'seller'),
(24, 'Thiviyaa', 'Sarawanan', 'test24', '1234', 'tvyatvya2003@gmail.com', '0175506860', '15-5-05 Sri Impian,lengkok angsana,bandar baru air itam', 'buyer'),
(25, 'Thiviyaa', 'Sarawanan', 'tvyauser', '1234', 'tvyatvya2003@gmail.com', '0175506860', '15-5-05 Sri Impian,lengkok angsana,bandar baru air itam', 'buyer'),
(26, 'Thiviyaa', 'Sarawanan', 'tvyabuyer', '1234', 'tvyatvya2003@gmail.com', '0175506860', '15-5-05 Sri Impian,lengkok angsana,bandar baru air itam', 'buyer'),
(27, 'Thiviyaa', 'Sarawanan', 'lufi', '1234', 'tvyatvya2003@gmail.com', '0175506860', '15-5-05 Sri Impian,lengkok angsana,bandar baru air itam', 'buyer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyer`
--
ALTER TABLE `buyer`
  ADD PRIMARY KEY (`buyer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`seller_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `test_order`
--
ALTER TABLE `test_order`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buyer`
--
ALTER TABLE `buyer`
  MODIFY `buyer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `seller_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `test_order`
--
ALTER TABLE `test_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buyer`
--
ALTER TABLE `buyer`
  ADD CONSTRAINT `buyer_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `seller` (`seller_id`);

--
-- Constraints for table `seller`
--
ALTER TABLE `seller`
  ADD CONSTRAINT `seller_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
