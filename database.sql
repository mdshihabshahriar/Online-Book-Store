-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2026 at 12:55 AM
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
-- Database: `online_book_store`
--

CREATE DATABASE IF NOT EXISTS `online_book_store`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE `online_book_store`;


-- --------------------------------------------------------
--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `profile_picture` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Dumping data for table `users`
--

INSERT INTO `users`
(`id`, `name`, `email`, `password_hash`, `role`, `profile_picture`, `address`, `phone`, `created_at`)
VALUES
(1, 'Admin', 'admin@bookstore.com',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Y5W2N7vL4X2YQ6q',
 'admin', NULL, 'Dhaka, Bangladesh', '01700000000', '2026-09-15 00:00:00');


-- --------------------------------------------------------
--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Dumping data for table `categories`
--

INSERT INTO `categories`
(`id`, `name`, `created_at`)
VALUES
(1, 'Fiction', '2026-09-15 00:00:00'),
(2, 'Science', '2026-09-15 00:00:00'),
(3, 'Technology', '2026-09-15 00:00:00'),
(4, 'Programming', '2026-09-15 00:00:00'),
(5, 'Biography', '2026-09-15 00:00:00'),
(6, 'History', '2026-09-15 00:00:00');


-- --------------------------------------------------------
--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Dumping data for table `books`
--

INSERT INTO `books`
(`id`, `title`, `author`, `description`, `price`, `category_id`, `image_path`, `stock`)
VALUES
(1, 'The Alchemist',
 'Paulo Coelho',
 'A famous novel about dreams, hope and following your goals.',
 450.00, 1, 'assets/images/books/alchemist.jpg', 20),

(2, 'Clean Code',
 'Robert C. Martin',
 'A practical guide to writing clean and maintainable software.',
 850.00, 4, 'assets/images/books/clean-code.jpg', 15),

(3, 'Atomic Habits',
 'James Clear',
 'A practical book about building good habits and breaking bad ones.',
 600.00, 1, 'assets/images/books/atomic-habits.jpg', 25),

(4, 'A Brief History of Time',
 'Stephen Hawking',
 'An introduction to the universe, space, time and modern physics.',
 700.00, 2, 'assets/images/books/brief-history-of-time.jpg', 10),

(5, 'The Pragmatic Programmer',
 'Andrew Hunt',
 'A guide to becoming a better and more effective programmer.',
 900.00, 3, 'assets/images/books/pragmatic-programmer.jpg', 12);


-- --------------------------------------------------------
--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------
--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','shipped','delivered') NOT NULL DEFAULT 'pending',
  `payment_method` enum('Credit Card','bKash','Nagad','Bank Transfer','COD') NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------
--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------
--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------
--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);


--
-- Indexes for table `categories`
--

ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);


--
-- Indexes for table `books`
--

ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);


--
-- Indexes for table `cart`
--

ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_book` (`user_id`,`book_id`),
  ADD KEY `book_id` (`book_id`);


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
  ADD KEY `book_id` (`book_id`);


--
-- Indexes for table `payments`
--

ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);


-- --------------------------------------------------------
--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


--
-- AUTO_INCREMENT for table `categories`
--

ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;


--
-- AUTO_INCREMENT for table `books`
--

ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


--
-- AUTO_INCREMENT for table `cart`
--

ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


--
-- AUTO_INCREMENT for table `orders`
--

ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


--
-- AUTO_INCREMENT for table `order_items`
--

ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


--
-- AUTO_INCREMENT for table `payments`
--

ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


-- --------------------------------------------------------
--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--

ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1`
  FOREIGN KEY (`category_id`)
  REFERENCES `categories` (`id`)
  ON UPDATE CASCADE
  ON DELETE RESTRICT;


--
-- Constraints for table `cart`
--

ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1`
  FOREIGN KEY (`user_id`)
  REFERENCES `users` (`id`)
  ON UPDATE CASCADE
  ON DELETE CASCADE,

  ADD CONSTRAINT `cart_ibfk_2`
  FOREIGN KEY (`book_id`)
  REFERENCES `books` (`id`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;


--
-- Constraints for table `orders`
--

ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1`
  FOREIGN KEY (`user_id`)
  REFERENCES `users` (`id`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;


--
-- Constraints for table `order_items`
--

ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1`
  FOREIGN KEY (`order_id`)
  REFERENCES `orders` (`id`)
  ON UPDATE CASCADE
  ON DELETE CASCADE,

  ADD CONSTRAINT `order_items_ibfk_2`
  FOREIGN KEY (`book_id`)
  REFERENCES `books` (`id`)
  ON UPDATE CASCADE
  ON DELETE RESTRICT;


--
-- Constraints for table `payments`
--

ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1`
  FOREIGN KEY (`order_id`)
  REFERENCES `orders` (`id`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;


COMMIT;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
