-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2025 at 02:20 PM
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
(5, 'Burger', 'burger.jpg'),
(6, 'Drinks', 'drinks.jpg'),
(7, 'South Indian', 'south-indian.jpg'),
(8, 'Desserts', 'desserts.jpg'),
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
  `available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`id`, `category_id`, `name`, `description`, `price`, `image`, `available`) VALUES
(1, NULL, 'Margherita Pizza', 'Classic cheese pizza', 249.00, 'Pizza1.webp', 1),
(2, NULL, 'Farmhouse Pizza', 'Veggie toppings', 299.00, 'pizza2.jpg', 1),
(3, NULL, 'Cheese Burger', 'Beef patty with cheese', 149.00, 'burger1.jpg', 1),
(4, NULL, 'Veg Burger', 'Paneer patty', 129.00, 'burger2.jpg', 1),
(5, NULL, 'Coke', '330ml bottle', 39.00, 'coke.jpg', 1),
(6, NULL, 'burger ', 'There is one Burger King location in Rajkot, offering a wide menu of burgers, sides, and shakes.', 100.00, '1762622600_burger.jpeg', 1),
(7, NULL, 'dcasddcsc', 'scfasascs', 20.00, '1762622934_burger.jpeg', 1),
(9, NULL, 'xyz', 'cascsacs', 59.00, '1762692679_burger.jpeg', 1),
(10, NULL, 'Margherita Pizza', 'Classic cheese pizza', 199.00, 'margherita.jpg', 1),
(11, NULL, 'Pepperoni Pizza', 'Loaded with pepperoni slices', 299.00, 'pepperoni.jpg', 1),
(12, NULL, 'Veg Burger', 'Fresh & crispy veggies inside', 99.00, 'veg_burger.jpg', 1),
(13, NULL, 'Chicken Burger', 'Juicy grilled chicken patty', 149.00, 'chicken_burger.jpg', 1),
(14, NULL, 'Coca Cola', 'Chilled soft drink', 40.00, 'coke.jpg', 1),
(15, NULL, 'Chocolate Cake', 'Rich dark chocolate slice', 120.00, 'cake.jpg', 1);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `email`, `phone`, `user_id`, `total_amount`, `status`, `address`, `payment_method`, `created_at`) VALUES
(3, NULL, NULL, NULL, 2, 159.00, 'Pending', 'Rajkot (M Corp. + OG) AHIR BOARDING', 'Online', '2025-11-09 17:19:02'),
(4, 'ravi', 'r12@gmail.com', '45455646546', NULL, 159.00, 'Pending', 'Rajkot (M Corp. + OG) AHIR BOARDING', 'Online', '2025-11-09 17:20:41'),
(5, 'virat', 'v@gmail.com', '7896541236', NULL, 139.00, 'Pending', 'ahemdabad', 'Online', '2025-11-09 17:22:42'),
(6, NULL, NULL, NULL, 2, 149.00, 'Pending', 'rajkot', 'COD', '2025-11-12 13:41:02'),
(7, 'ravi ahir', 'r12@gmail.com', '7896541236', 2, 149.00, 'Pending', 'rajkot', 'COD', '2025-11-12 13:45:14'),
(8, 'john', 'john12@gamail.com', '454545555555555', 4, 299.00, 'Pending', 'vvasca', 'COD', '2025-11-18 12:57:35'),
(9, 'Ravi', 'ravi@example.com', '9876543210', 1, 348.00, 'Delivered', 'Rajkot, India', 'COD', '2025-11-20 16:07:16'),
(10, 'john', 'r12@gmail.com', '4567893215', 4, 269.00, 'Pending', 'Rajkot (M Corp. + OG) AHIR BOARDING', 'COD', '2025-11-23 10:52:19'),
(11, 'john', 'john12@gamail.com', '1236456978', 4, 249.00, 'Preparing', 'Rajkot (M Corp. + OG) ', 'COD', '2025-11-23 11:03:44');

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
(4, 4, 9, 1, 59.00),
(5, 4, 6, 1, 100.00),
(6, 5, 5, 1, 39.00),
(7, 5, 6, 1, 100.00),
(8, 7, 3, 1, 149.00),
(9, 8, 2, 1, 299.00),
(13, 10, 3, 1, 149.00),
(14, 10, 15, 1, 120.00),
(15, 11, 1, 1, 249.00);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'ravi', 'trendcart04@gmail.com', '$2y$10$ni680uYX68CmDuEmNnRt1.M0LFYVjdjOhZ7RRv9mRF/y7fS0HuEHS', 'user', '2025-11-06 11:12:57'),
(2, 'ravi', 'r12@gmail.com', '$2y$10$3.oRYz9lwSHSBOb93bqLceV/DHnb2/NJIsUoyqDCYUZwv8Gp8GM2W', 'user', '2025-11-09 17:01:31'),
(3, 'virat', 'v@gmail.com', '$2y$10$.1Zq5Dh9TXVU0O6rK6Rapug1xEOMs4G3uWSHM/ofsUf3j5yLj9VGK', 'user', '2025-11-09 17:21:39'),
(4, 'jonny', 'john12@gamail.com', '$2y$10$6jSG5kx9HOzqyLnnnq5UEeX87utj6s6T7tgBpaEcHLPZmqOsJVUjC', 'user', '2025-11-18 12:41:22'),
(5, 'Ravi', 'ravi@example.com', '$2y$10$ZKz2f5f7DyNYuHna2HydN.hbzYyQqCkCM7THQpX3JfR7ME/Yyyv2O', 'user', '2025-11-20 16:07:16'),
(6, 'Amit', 'amit@example.com', '$2y$10$ZKz2f5f7DyNYuHna2HydN.hbzYyQqCkCM7THQpX3JfR7ME/Yyyv2O', 'user', '2025-11-20 16:07:16');

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

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `food_id` (`food_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
