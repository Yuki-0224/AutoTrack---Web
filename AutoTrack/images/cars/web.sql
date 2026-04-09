-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2026 at 12:00 PM
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
-- Database: `web`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `plate_number` varchar(20) DEFAULT NULL,
  `color` varchar(30) DEFAULT NULL,
  `price_per_day` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Available',
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `brand`, `model`, `year`, `plate_number`, `color`, `price_per_day`, `status`, `image`) VALUES
(7, 'Audi', 'A4', 2024, 'AUD-0721', 'Black', 79.99, 'Not Available', 'images/cars/audi_a4.jpg'),
(8, 'Mercedes', 'C-Class', 2024, 'MBC-0822', 'Silver', 119.99, 'Available', 'images/cars/mercedes_c.jpg'),
(9, 'Volkswagen', 'Golf', 2024, 'VW-0923', 'Blue', 44.99, 'Available', 'images/cars/vw_golf.jpg'),
(10, 'Hyundai', 'Tucson', 2024, 'HYU-1024', 'White', 59.99, 'Available', 'images/cars/hyundai_tucson.jpg'),
(11, 'Kia', 'Sportage', 2024, 'KIA-1125', 'Red', 64.99, 'Available', 'images/cars/kia_sportage.jpg'),
(12, 'Toyota', 'RAV4', 2024, 'RAV-1226', 'Gray', 69.99, 'Available', 'images/cars/toyota_rav4.jpg'),
(13, 'Honda', 'Accord', 2024, 'ACC-0113', 'Black', 54.99, 'Available', 'images/cars/honda_accord.jpg'),
(14, 'Suzuki', 'Swift', 2024, 'SWI-0214', 'White', 39.99, 'Available', 'images/cars/suzuki_swift.jpg'),
(15, 'Chevrolet', 'Cruze', 2024, 'CHV-0315', 'Blue', 49.99, 'Available', 'images/cars/chevrolet_cruze.jpg'),
(16, 'Nissan', 'Rogue', 2024, 'NIS-0416', 'Silver', 66.99, 'Available', 'images/cars/nissan_rogue.jpg'),
(17, 'Jeep', 'Wrangler', 2024, 'JEP-0517', 'Green', 99.99, 'Available', 'images/cars/jeep_wrangler.jpg'),
(18, 'Subaru', 'Outback', 2024, 'SUB-0618', 'Brown', 74.99, 'Available', 'images/cars/subaru_outback.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `driver_license` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `user_id`, `first_name`, `last_name`, `email`, `phone`, `address`, `driver_license`, `created_at`) VALUES
(2, 3, 'John Adrian', 'Clapis', 'johnclapis24@gmail.com', '09627546504', 'Baco, Oriental Mindoro', 'DL123987454', '2026-04-09 06:53:03');

-- --------------------------------------------------------

--
-- Table structure for table `damages`
--

CREATE TABLE `damages` (
  `damage_id` int(11) NOT NULL,
  `rental_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `repair_cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `maintenance_id` int(11) NOT NULL,
  `car_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `maintenance_date` date DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `rental_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL,
  `reservation_id` int(11) DEFAULT NULL,
  `paid_amount` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `rental_id`, `payment_date`, `amount`, `payment_method`, `payment_status`, `reservation_id`, `paid_amount`) VALUES
(0, 0, '2026-04-09', 500.00, 'paypal', 'Completed', NULL, 0),
(0, 0, '2026-04-09', 300.00, 'paypal', 'Partial Payment', NULL, 0),
(0, 0, '2026-04-09', 300.00, 'paypal', 'Partial Payment', NULL, 0),
(0, 0, '2026-04-09', 300.00, 'credit', 'Partial Payment', NULL, 0),
(0, 0, '2026-04-09', 300.00, 'credit', 'Partial Payment', NULL, 0),
(0, 0, '2026-04-09', 300.00, 'paypal', 'Partial Payment', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rentals`
--

CREATE TABLE `rentals` (
  `rental_id` int(11) NOT NULL,
  `reservation_id` int(11) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `rental_start` datetime NOT NULL,
  `rental_end` datetime NOT NULL,
  `actual_return` datetime DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `extra_charges` decimal(10,2) DEFAULT 0.00,
  `car_condition_out` text DEFAULT NULL,
  `car_condition_in` text DEFAULT NULL,
  `fuel_level_out` varchar(50) DEFAULT NULL,
  `fuel_level_in` varchar(50) DEFAULT NULL,
  `odometer_out` int(11) DEFAULT NULL,
  `odometer_in` int(11) DEFAULT NULL,
  `rental_status` enum('Ongoing','Returned','Late','Cancelled') DEFAULT 'Ongoing',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rentals`
--

INSERT INTO `rentals` (`rental_id`, `reservation_id`, `customer_id`, `car_id`, `rental_start`, `rental_end`, `actual_return`, `total_amount`, `extra_charges`, `car_condition_out`, `car_condition_in`, `fuel_level_out`, `fuel_level_in`, `odometer_out`, `odometer_in`, `rental_status`, `created_at`) VALUES
(0, 9, 2, 8, '2026-04-10 17:08:00', '2026-04-17 17:08:00', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, '', '2026-04-09 09:18:32'),
(0, 10, 2, 7, '2026-04-10 17:33:00', '2026-04-17 17:33:00', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, '', '2026-04-09 09:34:05'),
(0, 10, 2, 7, '2026-04-10 17:33:00', '2026-04-17 17:33:00', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, '', '2026-04-09 09:38:17'),
(0, 10, 2, 7, '2026-04-10 17:33:00', '2026-04-17 17:33:00', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, '', '2026-04-09 09:39:02'),
(0, 10, 2, 7, '2026-04-10 17:33:00', '2026-04-17 17:33:00', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, '', '2026-04-09 09:40:38'),
(0, 11, 2, 7, '2026-04-10 17:46:00', '2026-04-17 17:46:00', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, '', '2026-04-09 09:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `pickup_date` datetime NOT NULL,
  `return_date` datetime NOT NULL,
  `pickup_location` varchar(100) DEFAULT NULL,
  `dropoff_location` varchar(100) DEFAULT NULL,
  `reservation_status` enum('Pending','Confirmed','Cancelled','Completed') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `customer_id`, `car_id`, `pickup_date`, `return_date`, `pickup_location`, `dropoff_location`, `reservation_status`, `created_at`) VALUES
(11, 2, 7, '2026-04-10 17:46:00', '2026-04-17 17:46:00', 'Main Office', 'Airport', 'Pending', '2026-04-09 09:46:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `created_at`) VALUES
(3, 'John Adrian Clapis', 'johnclapis24@gmail.com', '$2y$10$83G9DNMLaWV4jr2OrhqkReRlfjoJ8FR34k/CO5t1b5UnKJhRXOO5C', '2026-04-09 06:53:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
