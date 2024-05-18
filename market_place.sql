-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2024 at 10:17 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `market_place`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `reply` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `subject`, `message`, `user_id`, `reply`, `created_at`) VALUES
(1, 'Product', 'Error in product services', 1, NULL, '2024-05-14 09:38:28'),
(2, 'Linking of', 'tttt', 1, 'We are working on it', '2024-05-14 10:14:16'),
(3, 'Paymment', 'Im having issues with the my customers payment.', 5, NULL, '2024-05-16 08:14:07');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `artist_id` int(11) DEFAULT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_status` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `buyer_id`, `artist_id`, `order_id`, `order_date`, `order_status`, `total_amount`) VALUES
(1, 1, 1, 'ORD001', '2024-05-14 10:27:43', 'Pending', 100.00),
(2, 2, 1, 'ORD002', '2024-05-14 10:27:43', 'In Progress', 150.00),
(3, 3, 1, 'ORD003', '2024-05-14 10:27:43', 'Shipped', 200.00),
(4, 4, 1, 'ORD004', '2024-05-14 10:27:43', 'Delivered', 175.50),
(5, 5, 1, 'ORD005', '2024-05-14 10:27:43', 'Pending', 120.00),
(6, 6, 1, 'ORD006', '2024-05-14 10:27:43', 'In Progress', 180.00),
(7, 7, 1, 'ORD007', '2024-05-14 10:27:43', 'Shipped', 220.00),
(8, 8, 1, 'ORD008', '2024-05-14 10:27:43', 'Delivered', 195.75),
(9, 9, 1, 'ORD009', '2024-05-14 10:27:43', 'Pending', 130.00),
(10, 10, 1, 'ORD010', '2024-05-14 10:27:43', 'In Progress', 170.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `artist_id`, `name`, `description`, `price`, `created_at`) VALUES
(1, 1, 'Malaysian Landscape Painting', 'A stunning painting depicting the lush greenery and natural beauty of Malaysia', 150.00, '2024-05-14 10:58:05'),
(2, 1, 'Traditional Malaysian Batik Art', 'Hand-dyed fabric featuring intricate Malaysian batik patterns', 120.00, '2024-05-14 10:58:05'),
(3, 1, 'Tropical Rainforest Sculpture', 'A wooden sculpture inspired by the rich biodiversity of Malaysia\'s rainforests', 200.00, '2024-05-14 10:58:05'),
(4, 1, 'Malay Traditional Keris Dagger', 'Crafted replica of a Malay traditional keris dagger, symbolizing courage and honor', 80.00, '2024-05-14 10:58:05'),
(5, 1, 'Petronas Twin Towers Artwork', 'Artistic representation of the iconic Petronas Twin Towers, a symbol of Malaysia\'s modernity', 180.00, '2024-05-14 10:58:05'),
(6, 1, 'Borneo Tribal Mask', 'Intricately carved wooden mask inspired by the indigenous tribes of Borneo', 90.00, '2024-05-14 10:58:05'),
(7, 1, 'Malaysian Sunset Painting', 'Vibrant painting capturing the breathtaking beauty of a Malaysian sunset', 250.00, '2024-05-14 10:58:05'),
(8, 1, 'Malaysian Handwoven Tapestry', 'Exquisite tapestry handwoven with traditional Malaysian motifs and colors', 100.00, '2024-05-14 10:58:05'),
(9, 1, 'Malaysia\'s Majestic Mountains Artwork', 'Artwork showcasing the majestic mountains of Malaysia, a sight to behold', 170.00, '2024-05-14 10:58:05'),
(10, 1, 'Malay Songket Fabric', 'Luxurious handwoven fabric adorned with intricate Malay songket motifs, a cultural treasure', 150.00, '2024-05-14 10:58:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `privilege` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `password`, `privilege`) VALUES
(1, 'Ibrahim Mohammed', 'artist@gmail.com', '08108101246', 'No.  5 Badawa', '$2y$10$Ior1sDuJRgBi3nA5zjx0E.XAf4DUEHkkzz69/M1MH0eALH/F0zQXW', 1),
(2, 'Admin', 'admin@gmail.com', '0905678999', 'Layin Alhaji Hamisu', '$2y$10$KNOF/kCl471Un59GoWKnNeVt9w9OsXDaBP6PcidlKq.DnAVUPiMbe', 2),
(3, 'Artist One', 'artist1@example.com', '1234567890', 'Address 1', '$2y$10$KNOF/kCl471Un59GoWKnNeVt9w9OsXDaBP6PcidlKq.DnAVUPiMbe', 1),
(4, 'Artist Two', 'artist2@example.com', '1234567891', 'Address 2', '$2y$10$KNOF/kCl471Un59GoWKnNeVt9w9OsXDaBP6PcidlKq.DnAVUPiMbe', 1),
(5, 'Artist Three', 'artist7@example.com', '1234567892', 'Address 3', '$2y$10$KNOF/kCl471Un59GoWKnNeVt9w9OsXDaBP6PcidlKq.DnAVUPiMbe', 1),
(6, 'Artist Four', 'artist4@example.com', '1234567893', 'Address 4', '$2y$10$KNOF/kCl471Un59GoWKnNeVt9w9OsXDaBP6PcidlKq.DnAVUPiMbe', 1),
(7, 'Artist Five', 'artist5@example.com', '1234567894', 'Address 5', '$2y$10$KNOF/kCl471Un59GoWKnNeVt9w9OsXDaBP6PcidlKq.DnAVUPiMbe', 1),
(8, 'Artist Six', 'artist6@example.com', '1234567895', 'Address 6', '$2y$10$KNOF/kCl471Un59GoWKnNeVt9w9OsXDaBP6PcidlKq.DnAVUPiMbe', 1),
(9, 'Artist Seven', 'artist7@example.com', '1234567896', 'Address 7', '$2y$10$KNOF/kCl471Un59GoWKnNeVt9w9OsXDaBP6PcidlKq.DnAVUPiMbe', 1),
(10, 'Artist Eight', 'artist8@example.com', '1234567897', 'Address 8', '$2y$10$KNOF/kCl471Un59GoWKnNeVt9w9OsXDaBP6PcidlKq.DnAVUPiMbe', 1),
(11, 'Artist Nine', 'artist9@gmail.com', '1234567898', 'No. 7 Kuala Lumpur, Malaysia', '$2y$10$KNOF/kCl471Un59GoWKnNeVt9w9OsXDaBP6PcidlKq.DnAVUPiMbe', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
