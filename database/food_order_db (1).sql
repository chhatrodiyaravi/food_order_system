-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2025 at 05:15 PM
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
-- Database: `food_order_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'ravi', 'ravi123');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `food_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `food_id`, `quantity`) VALUES
(4, 2, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`) VALUES
(9, 'Pizza', 'pizza.jpg'),
(10, 'Burgers', 'burger.jpg'),
(11, 'Drinks', 'drinks.jpg'),
(12, 'Desserts', 'dessert.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `food_items`
--

CREATE TABLE `food_items` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `available` tinyint(1) DEFAULT 1,
  `discount_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `discount_active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`id`, `category_id`, `name`, `description`, `price`, `image`, `available`, `discount_percent`, `discount_active`) VALUES
(1, 9, 'Margherita Pizza', 'Classic cheese pizza', 249.00, 'Pizza1.webp', 1, 5.00, 1),
(2, 9, 'Farmhouse Pizza', 'Veggie toppings', 299.00, 'pizza2.jpg', 1, 10.00, 1),
(3, 10, 'Cheese Burger', 'Beef patty with cheese', 149.00, 'burger1.jpg', 1, 0.00, 0),
(4, 10, 'Veg Burger', 'Paneer patty', 100.00, 'burger2.jpg', 1, 20.00, 1),
(5, 11, 'Coke', '330ml bottle', 50.00, 'coke.jpg', 1, 2.00, 1),
(6, 10, 'burger ', 'There is one Burger King location in Rajkot, offering a wide menu of burgers, sides, and shakes.', 100.00, '1762622600_burger.jpeg', 1, 0.00, 0),
(10, 9, 'Margherita Pizza', 'Classic cheese pizza', 199.00, 'margherita.jpg', 1, 10.00, 1),
(11, 9, 'Pepperoni Pizza', 'Loaded with pepperoni slices', 299.00, 'pepperoni.jpg', 1, 2.00, 1),
(12, 10, 'Veg Burger', 'Fresh & crispy veggies inside', 99.00, 'veg_burger.jpg', 1, 5.00, 1),
(15, 12, 'Chocolate Cake', 'Rich dark chocolate slice', 120.00, 'cake.jpg', 1, 10.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('Pending','Accepted','Preparing','Out for Delivery','Delivered','Cancelled') DEFAULT 'Pending',
  `address` varchar(255) DEFAULT NULL,
  `payment_method` enum('COD','Online') DEFAULT 'COD',
  `payment_status` enum('Pending','Paid','Failed','Cancelled') DEFAULT 'Pending',
  `cashfree_order_id` varchar(255) DEFAULT NULL,
  `payment_session_id` varchar(255) DEFAULT NULL,
  `items` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `email`, `phone`, `user_id`, `total_amount`, `status`, `address`, `payment_method`, `payment_status`, `cashfree_order_id`, `payment_session_id`, `items`, `created_at`) VALUES
(4, 'ravi', 'r12@gmail.com', '45455646546', NULL, 159.00, 'Pending', 'Rajkot (M Corp. + OG) AHIR BOARDING', 'Online', 'Pending', NULL, NULL, NULL, '2025-11-09 17:20:41'),
(5, 'virat', 'v@gmail.com', '7896541236', NULL, 139.00, 'Pending', 'ahemdabad', 'Online', 'Pending', NULL, NULL, NULL, '2025-11-09 17:22:42'),
(6, NULL, NULL, NULL, 2, 149.00, 'Cancelled', 'rajkot', 'COD', 'Paid', NULL, NULL, NULL, '2025-11-12 13:41:02'),
(7, 'ravi ahir', 'r12@gmail.com', '7896541236', 2, 149.00, 'Pending', 'rajkot', 'COD', 'Paid', NULL, NULL, NULL, '2025-11-12 13:45:14'),
(8, 'john', 'john12@gamail.com', '454545555555555', 4, 299.00, 'Out for Delivery', 'vvasca', 'COD', 'Paid', NULL, NULL, NULL, '2025-11-18 12:57:35'),
(9, 'Ravi', 'ravi@example.com', '9876543210', 1, 348.00, 'Delivered', 'Rajkot, India', 'COD', 'Paid', NULL, NULL, NULL, '2025-11-20 16:07:16'),
(10, 'john', 'r12@gmail.com', '4567893215', 4, 269.00, 'Cancelled', 'Rajkot (M Corp. + OG) AHIR BOARDING', 'COD', 'Paid', NULL, NULL, NULL, '2025-11-23 10:52:19'),
(11, 'john', 'john12@gamail.com', '1236456978', 4, 249.00, 'Preparing', 'Rajkot (M Corp. + OG) ', 'COD', 'Paid', NULL, NULL, NULL, '2025-11-23 11:03:44'),
(12, 'john', 'trendcart04@gmail.com', '7896541236', 4, 149.00, 'Pending', 'rajkot', 'COD', 'Paid', NULL, NULL, NULL, '2025-11-24 04:26:45'),
(13, 'Ravi', 'raviahir12@gmail.com', '4569871236', 7, 129.00, 'Out for Delivery', 'Bhaktinager Rajkot', 'COD', 'Paid', NULL, NULL, NULL, '2025-11-25 16:27:25'),
(14, 'john', 'john12@gamail.com', '7896541236', 4, 299.00, 'Pending', 'rajkot', 'Online', 'Pending', NULL, NULL, 'Farmhouse Pizza (x1)', '2025-12-02 04:12:42'),
(15, 'trendcart', 'trendcart04@gmail.com', '4569782136', 4, 299.00, 'Pending', 'Rajkot (M Corp. + OG) AHIR BOARDING', 'Online', 'Pending', 'ORDER_15_1764649280', 'session_kFq7YxMPC8bRuQ_rYOQ618TC0L07bBnjVvp3SNBMCX3vK7A_0pD-mSl4P-sLo31Y8CT0KPpfEH72iajaK3b7XFp51jaUcD6SCqiRCcYaGdOQJGhaMK3VHe44jAHHDApaymentpayment', 'Farmhouse Pizza (x1)', '2025-12-02 04:16:37'),
(16, 'trendcart', 'john12@gamail.com', '4578962145', 4, 149.00, 'Pending', 'Rajkot (M Corp. + OG) AHIR BOARDING', 'Online', 'Pending', 'ORDER_16_1764649487', 'session_6f7LAkRszjU-GkSJ-i_qBmxRu7P8SHqDMzlAhHITJrY6rU0J4-smM-8IPey83Q-karo8cUW-dySV897Yi82OQUS7L90FPI8VA39kGBJ9tDupgW9itsakSw7Sr1Ts5Qpaymentpayment', 'Cheese Burger (x1)', '2025-12-02 04:23:23'),
(17, 'john', 'john12@gamail.com', '7896541236', 4, 447.00, 'Pending', 'rajkot', 'COD', 'Paid', NULL, NULL, 'Cheese Burger (x3)', '2025-12-02 04:41:47'),
(18, 'john', 'john12@gamail.com', '1234567896', 4, 498.00, 'Out for Delivery', 'rajkot', 'COD', 'Paid', NULL, NULL, 'Margherita Pizza (x2)', '2025-12-02 06:05:02'),
(19, 'john', 'john12@gamail.com', '4569782136', 4, 100.00, 'Pending', 'rajkot', 'Online', 'Pending', NULL, NULL, 'burger  (x1)', '2025-12-02 10:07:52'),
(20, 'john', 'john12@gamail.com', '4545564654', 4, 100.00, 'Pending', 'rajkot', 'Online', 'Pending', 'order_1090380236HkRYz6t3ucSRiyVzqBfEHHITR', '', 'burger  (x1)', '2025-12-02 10:10:09'),
(21, 'ravi', 'r12@gmail.com', '1236547896', 7, 486.00, 'Pending', 'Rajkot (M Corp. + OG) AHIR BOARDING', 'Online', 'Pending', NULL, NULL, 'Cheese Burger (x3), Coke (x1)', '2025-12-02 10:29:26'),
(22, 'ghdt', 'shyam@gmail.com', '4536897525', 8, 249.00, 'Pending', 'hjqssghwhxfwks', 'Online', 'Pending', NULL, NULL, 'Margherita Pizza (x1)', '2025-12-03 04:46:10'),
(23, 'xyz', 'john12@gamail.com', '4569782136', 8, 548.00, 'Pending', 'rajkot', 'COD', 'Paid', NULL, NULL, 'Margherita Pizza (x1), Farmhouse Pizza (x1)', '2025-12-03 05:05:59'),
(24, 'shyam', 'shyam@gmail.com', '4578962145', 8, 299.00, 'Pending', 'rajkot', 'Online', 'Pending', NULL, NULL, 'Farmhouse Pizza (x1)', '2025-12-03 05:06:40'),
(25, 'john', 'john12@gamail.com', '7896541236', 4, 39.00, 'Cancelled', 'Rajkot ', 'COD', 'Pending', NULL, NULL, 'Coke (x1)', '2025-12-03 05:11:40'),
(26, 'ravi', 'raviahir12@gmail.com', '4578962145', 7, 120.00, 'Accepted', 'rajkot', 'COD', 'Pending', NULL, NULL, 'Chocolate Cake (x1)', '2025-12-03 07:39:02'),
(27, 'ravi', 'r12@gmail.com', '1236547896', 7, 99.00, 'Cancelled', 'rajkot', 'COD', 'Pending', NULL, NULL, NULL, '2025-12-03 09:48:41'),
(28, 'john', 'john@gmail.com', '1234567897', 4, 39.00, 'Pending', 'rajkot', 'COD', 'Pending', NULL, NULL, NULL, '2025-12-03 10:18:13'),
(29, 'johnny', 'j@gmail.com', '1213216544', 4, 149.00, 'Cancelled', 'ahmedabad', 'COD', 'Pending', NULL, NULL, NULL, '2025-12-03 10:23:28'),
(30, 'john', 'john@gmail.com', '1213456787', 4, 299.00, 'Cancelled', 'rajkot', 'COD', 'Pending', NULL, NULL, NULL, '2025-12-03 10:27:23'),
(31, 'Raviahir', 'raviahir@gamil.com', '1236547896', 9, 338.00, 'Delivered', 'rajkot', 'COD', 'Pending', NULL, NULL, NULL, '2025-12-24 14:56:47'),
(32, 'ravi', 'r@gmail.com', '1236547896', 9, 285.55, 'Pending', 'rajkot', 'COD', 'Pending', NULL, NULL, NULL, '2025-12-24 15:48:40');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `food_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `food_id`, `quantity`, `price`) VALUES
(6, 5, 5, 1, 39.00),
(7, 5, 6, 1, 100.00),
(8, 7, 3, 1, 149.00),
(9, 8, 2, 1, 299.00),
(13, 10, 3, 1, 149.00),
(14, 10, 15, 1, 120.00),
(15, 11, 1, 1, 249.00),
(16, 12, 3, 1, 149.00),
(17, 13, 4, 1, 129.00),
(18, 14, 2, 1, 299.00),
(19, 15, 2, 1, 299.00),
(20, 16, 3, 1, 149.00),
(21, 17, 3, 3, 149.00),
(22, 18, 1, 2, 249.00),
(23, 19, 6, 1, 100.00),
(24, 20, 6, 1, 100.00),
(25, 21, 3, 3, 149.00),
(26, 21, 5, 1, 39.00),
(27, 22, 1, 1, 249.00),
(28, 23, 1, 1, 249.00),
(29, 23, 2, 1, 299.00),
(30, 24, 2, 1, 299.00),
(31, 25, 5, 1, 39.00),
(32, 26, 15, 1, 120.00),
(33, 27, 12, 1, 99.00),
(34, 28, 5, 1, 39.00),
(35, 29, 3, 1, 149.00),
(36, 30, 2, 1, 299.00),
(37, 31, 2, 1, 299.00),
(38, 31, 5, 1, 39.00),
(39, 32, 1, 1, 236.55),
(40, 32, 5, 1, 49.00);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `user_id`, `food_id`, `rating`, `review`, `created_at`) VALUES
(1, 9, 2, 5, 'testy food', '2025-12-24 16:06:09'),
(2, 9, 5, 3, '', '2025-12-24 16:00:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `reset_token`, `token_expiry`) VALUES
(1, 'ravi', 'trendcart04@gmail.com', '$2y$10$n8z8xU6DNKmQ.ZnGYlQh2O.0RXmgCXdz/wP7wXrSfsI5oODXofEOu', 'user', '2025-11-06 11:12:57', '0fd94c19c77aa65150a79deedc959eff5eae9e4200b031f8cb58e77269af28e1', '2025-12-01 07:18:56'),
(2, 'ravi', 'r12@gmail.com', '$2y$10$3.oRYz9lwSHSBOb93bqLceV/DHnb2/NJIsUoyqDCYUZwv8Gp8GM2W', 'user', '2025-11-09 17:01:31', NULL, NULL),
(3, 'virat', 'v@gmail.com', '$2y$10$.1Zq5Dh9TXVU0O6rK6Rapug1xEOMs4G3uWSHM/ofsUf3j5yLj9VGK', 'user', '2025-11-09 17:21:39', NULL, NULL),
(4, 'jonny', 'john12@gamail.com', '$2y$10$b5KIewAtjdnmdBYfEgyEN.y3e24/3/Fjhd0t39S97HcAhhlBV2XjC', 'user', '2025-11-18 12:41:22', NULL, NULL),
(5, 'Ravi', 'ravi@example.com', '$2y$10$ZKz2f5f7DyNYuHna2HydN.hbzYyQqCkCM7THQpX3JfR7ME/Yyyv2O', 'user', '2025-11-20 16:07:16', NULL, NULL),
(6, 'Amit', 'amit@example.com', '$2y$10$ZKz2f5f7DyNYuHna2HydN.hbzYyQqCkCM7THQpX3JfR7ME/Yyyv2O', 'user', '2025-11-20 16:07:16', NULL, NULL),
(7, 'Ravi ahir', 'raviahir12@gmail.com', '$2y$10$rgPqW/XCiyhE.rWYnBERmeSRXG.AvJQZGdTQHZ/B9t79COIwLztD2', 'user', '2025-11-25 16:26:04', NULL, NULL),
(8, 'shyam', 'shyam@gmail.com', '$2y$10$EhUSFqnZ.RK8UjcEyP07kOBjGgoF0tteQlIE5g2oDjYfkE/V6KzVm', 'user', '2025-12-03 04:45:01', NULL, NULL),
(9, 'raviahir', 'raviahir@gmail.com', '$2y$10$zrYq14oQc2cLCz49VQEpmeJIAHoEu22Sslwpd2e83RW.vWZWgztMa', 'user', '2025-12-24 14:33:34', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `food_id` (`food_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_items`
--
ALTER TABLE `food_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);
ALTER TABLE `food_items` ADD FULLTEXT KEY `ft_name_desc` (`name`,`description`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_cashfree_order_id` (`cashfree_order_id`),
  ADD KEY `idx_payment_session_id` (`payment_session_id`),
  ADD KEY `idx_payment_status` (`payment_status`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `food_id` (`food_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ratings_ibfk_1` (`user_id`),
  ADD KEY `ratings_ibfk_2` (`food_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`food_id`) REFERENCES `food_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `food_items`
--
ALTER TABLE `food_items`
  ADD CONSTRAINT `food_items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`food_id`) REFERENCES `food_items` (`id`);

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`food_id`) REFERENCES `food_items` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
