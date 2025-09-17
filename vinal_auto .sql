-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2025 at 06:38 PM
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
-- Database: `vinal_auto`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `vehicle` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `sent_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending',
  `reply` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `message`, `created_at`, `status`, `reply`) VALUES
(1, 'Thisal Chathnuka', 'thisalchathnuka@gmail.com', 'thisalchathnuka@gmail.com', '2025-08-29 07:38:44', 'Pending', NULL),
(5, 'PRAMUDITA', 'pramudithamunasinghe11@gmail.com', 'fergerterteryeryewr', '2025-09-03 02:53:26', 'Pending', NULL),
(6, 'PRAMUDITA', 'pramudithamunasinghe11@gmail.com', 'can  you ask car prices list', '2025-09-04 06:37:36', 'Pending', NULL),
(7, 'ranithu', 'ranithu.sensith@gmail.com', 'CAN YOU GET VEHICL PRICE LIST PDF', '2025-09-06 04:10:17', 'Pending', NULL),
(8, 'THISAL', 'chathnukathisal@gmail.com', 'we are', '2025-09-06 04:14:20', 'Pending', NULL),
(9, 'THISAL', 'chathnukathisal@gmail.com', 'fdvnmefgh4uityuiwsjv', '2025-09-06 13:16:51', 'Pending', NULL),
(10, 'THISAL', 'chathnukathisal@gmail.com', 'j4yji5tyji5', '2025-09-10 07:43:54', 'Pending', NULL),
(11, 'THISAL', 'chathnukathisal@gmail.com', 'HI CAN YOU GET CAR PRICE LIST', '2025-09-10 10:43:17', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_code` varchar(50) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(150) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `part_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_code`, `customer_name`, `customer_email`, `phone`, `user_id`, `created_at`, `part_id`, `total_amount`) VALUES
(1, 'C8F779', 'Thisal Chathnuka', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-02 01:06:11', 5, 0.00),
(2, 'B001D8', 'Thisal Chathnuka', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-02 01:08:57', 5, 0.00),
(3, '9E0E4E', 'Thisal Chathnuka', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-02 01:23:37', 5, 0.00),
(4, '53C5CA', 'Thisal Chathnuka', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-02 01:28:30', 4, 0.00),
(5, 'F0AB21', 'Thisal Chathnuka', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-02 01:30:57', 5, 0.00),
(6, '232C26', 'Thisal Chathnuka', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-02 01:34:23', 5, 0.00),
(7, 'CF58C9', 'Thisal Chathnuka', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-02 01:45:56', 5, 0.00),
(8, 'FC3C6E', 'Thisal Chathnuka', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-02 01:46:03', 5, 0.00),
(9, '5214E1', 'Thisal Chathnuka', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-02 01:47:31', 5, 0.00),
(10, '920479', 'Thisal Chathnuka', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-02 03:10:32', 5, 0.00),
(11, 'A8A3BF', 'Thisal Chathnuka', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-02 03:10:46', 5, 0.00),
(12, '03139E', 'Thisal Chathnuka', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-02 03:15:18', 5, 0.00),
(13, '919499', 'Thisal Chathnuka', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-02 03:39:06', 10, 0.00),
(14, 'D19E25', 'DB_NAME', 'thisalchathnuka@gamil.com', '0768291088', 0, '2025-09-02 04:01:52', 11, 0.00),
(15, 'B72E10', 'Thisal Chathnuka', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-02 05:48:40', 11, 0.00),
(16, '826EA6', 'Thisal Chathnuka', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-02 08:44:36', 11, 0.00),
(17, '6D2B53', 'Thisal Chathnuka', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-02 08:46:33', 11, 0.00),
(18, '1909A1', 'Thisal Chathnuka', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-02 09:27:01', 9, 0.00),
(19, '8C841D', 'Thisal Chathnuka', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-02 11:52:46', 13, 0.00),
(20, 'E3A3B0', 'Thisal Chathnuka', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-02 11:53:22', 13, 0.00),
(21, 'A79C73', 'admin root', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-03 05:51:57', 13, 0.00),
(22, 'BBAD30', 'admin root', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-03 06:28:07', 13, 0.00),
(23, '5B3D67', 'thisal', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-03 07:48:47', 13, 0.00),
(24, '128263', 'thisal', 'pramudithamunasinghe11@gmail.com', '0768291088', 0, '2025-09-03 10:53:16', 6, 0.00),
(25, '5E4347', 'thisal', 'pramudithamunasinghe11@gmail.com', '0768291088', 0, '2025-09-04 06:36:44', 5, 0.00),
(26, '44820B', 'thisal', 'pramudithamunasinghe11@gmail.com', '0768291088', 0, '2025-09-05 16:05:26', 12, 0.00),
(27, '89FF6C', 'ranith', 'ranithu.sensith@gmail.com', '+94740611624', 0, '2025-09-06 03:51:16', 6, 0.00),
(28, '779C59', 'ranith', 'ranithu.sensith@gmail.com', '+94740611624', 0, '2025-09-06 13:16:11', 5, 0.00),
(29, 'D7D795', 'ranith', 'ranithu.sensith@gmail.com', '+94740611624', 0, '2025-09-08 08:55:12', 12, 0.00),
(30, '12912D', 'ranith', 'ranithu.sensith@gmail.com', '+94740611624', 0, '2025-09-10 10:42:02', 14, 0.00),
(31, '8EEE01', 'THISAL CHATHNUKA', 'thisalchathnuka@gmail.com', '0768291088', 0, '2025-09-15 06:57:50', 13, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parts`
--

CREATE TABLE `parts` (
  `part_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `part_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parts`
--

INSERT INTO `parts` (`part_id`, `name`, `price`, `part_name`) VALUES
(1, 'Brake Pad', 4500.00, 'Brake Pad'),
(2, 'Engine Oil', 3200.00, 'Air Filter'),
(3, 'Air Filter', 1800.00, ''),
(4, 'Car Battery', 25000.00, '');

-- --------------------------------------------------------

--
-- Table structure for table `part_messages`
--

CREATE TABLE `part_messages` (
  `id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `reply` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_code` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `part_messages`
--

INSERT INTO `part_messages` (`id`, `part_id`, `customer_name`, `phone`, `message`, `reply`, `status`, `created_at`, `order_code`, `email`) VALUES
(1, 5, 'Thisal Chathnuka', '0768291088', 'New order placed. Code: C8F779. Customer: Thisal Chathnuka (0768291088)', 'hhhhh', 'Replied', '2025-09-02 01:06:11', NULL, NULL),
(2, 5, 'Thisal Chathnuka', '0768291088', 'New order placed. Code: B001D8. Customer: Thisal Chathnuka (0768291088)', NULL, 'unread', '2025-09-02 01:08:57', NULL, NULL),
(3, 5, 'Thisal Chathnuka', '0768291088', 'New order placed. Code: 9E0E4E. Customer: Thisal Chathnuka (0768291088)', NULL, 'unread', '2025-09-02 01:23:37', NULL, NULL),
(5, 5, 'Thisal Chathnuka', '0768291088', 'New order placed. Code: F0AB21. Customer: Thisal Chathnuka (0768291088)', 'fejifjweifjewirjewijreijrqeuriqweijfwekjfwejtrie3t3tuwdkjjfwdkjfweioj3iot3qoit', 'Pending', '2025-09-02 01:30:57', NULL, NULL),
(6, 5, 'Thisal Chathnuka', '0768291088', 'New order placed. Code: 232C26. Customer: Thisal Chathnuka (0768291088)', 'dud', 'Pending', '2025-09-02 01:34:23', NULL, NULL),
(7, 5, 'Thisal Chathnuka', '0768291088', 'නව order එකක් ලැබී ඇත. කේතය: CF58C9. ගනුදෙනුකරු: Thisal Chathnuka (0768291088)', NULL, 'unread', '2025-09-02 01:45:56', NULL, NULL),
(8, 5, 'Thisal Chathnuka', '0768291088', 'නව order එකක් ලැබී ඇත. කේතය: FC3C6E. ගනුදෙනුකරු: Thisal Chathnuka (0768291088)', NULL, 'approved', '2025-09-02 01:46:03', NULL, NULL),
(9, 5, 'Thisal Chathnuka', '0768291088', 'නව order එකක් ලැබී ඇත. කේතය: 5214E1. ගනුදෙනුකරු: Thisal Chathnuka (0768291088)', NULL, 'unread', '2025-09-02 01:47:31', NULL, NULL),
(10, 5, 'Thisal Chathnuka', '0768291088', 'නව order එකක් ලැබී ඇත. කේතය: 920479. ගනුදෙනුකරු: Thisal Chathnuka (0768291088)', NULL, 'unread', '2025-09-02 03:10:32', NULL, NULL),
(11, 5, 'Thisal Chathnuka', '0768291088', 'නව order එකක් ලැබී ඇත. කේතය: A8A3BF. ගනුදෙනුකරු: Thisal Chathnuka (0768291088)', 'YES', 'Replied', '2025-09-02 03:10:46', NULL, NULL),
(12, 5, 'Thisal Chathnuka', '0768291088', 'නව order එකක් ලැබී ඇත. කේතය: 03139E. ගනුදෙනුකරු: Thisal Chathnuka (0768291088)', NULL, 'unread', '2025-09-02 03:15:18', NULL, NULL),
(13, 10, 'Thisal Chathnuka', '0768291088', 'නව order එකක් ලැබී ඇත. කේතය: 919499. ගනුදෙනුකරු: Thisal Chathnuka (0768291088)', NULL, 'approved', '2025-09-02 03:39:06', NULL, NULL),
(18, 9, 'Thisal Chathnuka', '0768291088', 'නව order එකක් ලැබී ඇත. කේතය: 1909A1. ගනුදෙනුකරු: Thisal Chathnuka (0768291088)', NULL, 'approved', '2025-09-02 09:27:01', NULL, NULL),
(19, 13, 'Thisal Chathnuka', '0768291088', 'නව order එකක් ලැබී ඇත. කේතය: 8C841D. ගනුදෙනුකරු: Thisal Chathnuka (0768291088)', NULL, 'rejected', '2025-09-02 11:52:46', NULL, NULL),
(20, 13, 'Thisal Chathnuka', '0768291088', 'නව order එකක් ලැබී ඇත. කේතය: E3A3B0. ගනුදෙනුකරු: Thisal Chathnuka (0768291088)', '4', 'replied', '2025-09-02 11:53:22', NULL, NULL),
(21, 13, 'admin root', '0768291088', 'නව order එකක් ලැබී ඇත. කේතය: A79C73. ගනුදෙනුකරු: admin root (0768291088)', NULL, 'unread', '2025-09-03 05:51:57', NULL, NULL),
(22, 13, 'admin root', '0768291088', 'නව order එකක් ලැබී ඇත. කේතය: BBAD30. ගනුදෙනුකරු: admin root (0768291088)', NULL, 'unread', '2025-09-03 06:28:07', NULL, NULL),
(23, 13, 'thisal', '0768291088', 'නව order එකක් ලැබී ඇත. කේතය: 5B3D67. ගනුදෙනුකරු: thisal (0768291088)', NULL, 'unread', '2025-09-03 07:48:47', NULL, NULL),
(24, 6, 'thisal', '0768291088', 'නව order එකක් ලැබී ඇත. කේතය: 128263. ගනුදෙනුකරු: thisal (0768291088)', NULL, 'unread', '2025-09-03 10:53:16', NULL, NULL),
(25, 5, 'thisal', '0768291088', 'නව order එකක් ලැබී ඇත. කේතය: 5E4347. ගනුදෙනුකරු: thisal (0768291088)', NULL, 'unread', '2025-09-04 06:36:44', NULL, NULL),
(26, 12, 'thisal', '0768291088', 'නව order එකක් ලැබී ඇත. කේතය: 44820B. ගනුදෙනුකරු: thisal (0768291088)', 'we have add this pack', 'replied', '2025-09-05 16:05:26', NULL, NULL),
(27, 6, 'ranith', '+94740611624', 'නව order එකක් ලැබී ඇත. කේතය: 89FF6C. ගනුදෙනුකරු: ranith (+94740611624)', NULL, 'unread', '2025-09-06 03:51:16', NULL, NULL),
(28, 5, 'ranith', '+94740611624', 'නව order එකක් ලැබී ඇත. කේතය: 779C59. ගනුදෙනුකරු: ranith (+94740611624)', NULL, 'approved', '2025-09-06 13:16:11', NULL, NULL),
(29, 12, 'ranith', '+94740611624', 'නව order එකක් ලැබී ඇත. කේතය: D7D795. ගනුදෙනුකරු: ranith (+94740611624)', NULL, 'unread', '2025-09-08 08:55:12', NULL, NULL),
(30, 14, 'ranith', '+94740611624', 'නව order එකක් ලැබී ඇත. කේතය: 12912D. ගනුදෙනුකරු: ranith (+94740611624)', NULL, 'approved', '2025-09-10 10:42:02', NULL, NULL),
(31, 13, 'THISAL CHATHNUKA', '0768291088', 'නව order එකක් ලැබී ඇත. කේතය: 8EEE01. ගනුදෙනුකරු: THISAL CHATHNUKA (0768291088)', NULL, 'unread', '2025-09-15 06:57:50', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `part_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`part_id`, `name`, `price`, `image`, `category`) VALUES
(1, 'THISAL CHATHNUKA', 1000.00, 'a (7).png', 'Engine'),
(2, 'THISAL CHATHNUKA', 1000.00, '', 'Engine'),
(3, 'THISAL CHATHNUKA', 1000.00, 'c14.jpg', 'Engine');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `name` varchar(120) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` enum('pending','approved') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `vehicle_id`, `name`, `rating`, `comment`, `status`, `created_at`) VALUES
(1, NULL, 'THISAL CHATHNUKA', 4, 'good', 'approved', '2025-08-29 08:10:24'),
(5, NULL, 'don', 4, 'not bad   good shop', 'approved', '2025-09-04 06:37:09'),
(6, NULL, 'VALVOLINE VR 1 RACING 15W40', 4, 'wow', 'approved', '2025-09-05 16:33:17'),
(7, NULL, 'join', 4, 'goood service in this shop', 'approved', '2025-09-06 03:10:44'),
(9, NULL, 'Jeewa', 5, 'superb', 'approved', '2025-09-08 08:56:37'),
(10, NULL, 'THISAL CHATHNUKA', 4, 'GOOOD', 'approved', '2025-09-10 09:47:28'),
(11, NULL, 'JAYASHANTHA', 5, 'GOOD SHOP WE ARE RECOMONTED IT', 'approved', '2025-09-10 10:42:38');

-- --------------------------------------------------------

--
-- Table structure for table `test_drive_bookings`
--

CREATE TABLE `test_drive_bookings` (
  `id` int(11) NOT NULL,
  `name` varchar(60) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_drive_bookings`
--

INSERT INTO `test_drive_bookings` (`id`, `name`, `email`, `phone`, `vehicle_id`, `time`, `status`) VALUES
(1, 'THISAL CHATHNUKA', '', '0768291088', 1, '2025-09-04 13:43:00', 'Cancelled'),
(2, 'THISAL CHATHNUKA', '', '0768291088', 1, '2025-09-05 11:32:00', 'Pending'),
(3, 'THISAL CHATHNUKA', 'thisalchathnuka@gmail.com', '0768291088', 1, '2025-09-05 11:20:00', 'Cancelled'),
(4, 'THISAL CHATHNUKA', 'thisalchathnuka@gmail.com', '0768291088', 1, '2025-09-05 11:20:00', 'Confirmed'),
(5, 'THISAL CHATHNUKA', 'thisalchathnuka@gmail.com', '0768291088', 1, '2025-09-05 11:20:00', 'Confirmed'),
(6, 'THISAL CHATHNUKA', 'thisalchathnuka@gmail.com', '0768291088', 1, '2025-09-05 11:20:00', 'Confirmed'),
(7, 'ranithu', 'ranithu.sensith@gmail.com', '0740611624', 1, '2025-09-27 09:38:00', 'Confirmed'),
(8, 'ranithu', 'ranithu.sensith@gmail.com', '0740611624', 1, '2025-09-27 09:38:00', 'Pending'),
(9, 'ranithu', 'thisalchathnuka@gmail.com', '0740611624', 1, '2025-09-28 23:47:00', 'Pending'),
(10, 'THISAL CHATHNUKA', 'thisalchathnuka@gmail.com', '0740611624', 1, '2025-09-28 23:47:00', 'Cancelled'),
(11, 'Jeewa', 'jeewva@gmail.com', '0716993944', 1, '2025-09-28 15:30:00', 'Pending'),
(12, 'Jeewa', 'Ranithu.Sensith@gmail.com', '0716993944', 1, '2025-09-28 15:30:00', 'Pending'),
(13, 'THISAL CHATHNUKA', 'thisalchathnuka@gmail.com', '0768291088', 1, '2025-09-15 20:30:00', 'Confirmed'),
(14, 'THISAL CHATHNUKA', 'ranithu.sensith@gmail.com', '0768291088', 1, '2025-09-15 20:30:00', 'Pending'),
(15, 'henuka', 'chathnukathisal@gmail.com', '0768291088', 1, '2025-10-15 12:00:00', 'Pending'),
(16, 'henuka', 'chathnukathisal@gmail.com', '0768291088', 1, '2025-10-15 16:17:00', 'Pending'),
(17, 'henuka', 'thisalchathnuka80@gmail.com', '0768291088', 1, '2025-10-15 16:17:00', 'Confirmed'),
(18, 'henuka', 'jeewva@gmail.com', '0768291088', 1, '2025-10-15 16:17:00', 'Pending'),
(19, 'ai jayashantha', 'aijayawickramaanupama@gmail.com', '0768291088', 1, '2025-10-29 17:00:00', 'Confirmed'),
(20, 'ranitu yaka', 'ranithu.sensith@gmail.com', '0716993944', 1, '2025-12-06 16:17:00', 'Pending'),
(21, 'ranitu yaka', 'ranithu.sensith@gmail.com', '0716993944', 1, '2025-12-06 22:24:00', 'Confirmed'),
(22, 'ranitu yaka', 'ranithu.sensith@gmail.com', '0716993944', 1, '2025-12-06 22:24:00', 'Confirmed'),
(23, 'JAYASHANTHA', 'aijayawickramaanupama@gmail.com', '0716993944', 1, '2025-12-06 14:17:00', 'Pending'),
(24, 'JAYASHANTHA', 'aijayawickramaanupama@gmail.com', '0716993944', 1, '2025-12-06 14:17:00', 'Pending'),
(25, 'THISAL CHATHNUKA', 'thisalchathnuka@gmail.com', '0768291088', 1, '2025-09-11 11:20:00', 'Pending'),
(26, 'THISAL CHATHNUKA', 'aijayawickramaanupama@gmail.com', '0768291088', 1, '2025-09-11 15:51:00', 'Pending'),
(27, 'THISAL CHATHNUKA', 'aijayawickramaanupama@gmail.com', '0768291088', 1, '2025-09-11 11:11:00', 'Confirmed'),
(28, 'THISAL CHATHNUKA', 'aijayawickramaanupama@gmail.com', '0768291088', 1, '2025-09-11 11:11:00', 'Pending'),
(29, 'THISAL CHATHNUKA', 'aijayawickramaanupama@gmail.com', '0768291088', 1, '2025-09-11 11:11:00', 'Pending'),
(30, 'THISAL CHATHNUKA', 'thisalchathnuka@gmail.com', '0768291088', 1, '2025-09-11 11:11:00', 'Pending'),
(31, 'THISAL CHATHNUKA', 'thisalchathnuka@gmail.com', '0768291088', 1, '2025-10-03 14:13:00', 'Pending'),
(32, 'THISAL CHATHNUKA', 'thisalchathnuka@gmail.com', '0768291088', 1, '2025-10-03 14:13:00', 'Pending'),
(33, 'THISAL CHATHNUKA', 'thisalchathnuka@gmail.com', '0768291088', 1, '2025-11-09 21:30:00', 'Pending'),
(34, 'THISAL CHATHNUKA', 'thisalchathnuka@gmail.com', '0768291088', 1, '2025-11-09 21:30:00', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','staff') NOT NULL DEFAULT 'staff',
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `role`, `reset_token`, `token_expiry`, `email`, `otp`, `otp_expiry`) VALUES
(1, 'admin', '$2y$10$QFN0QnaMFBtXawNkVesyNuiC.KM1/kya11GjYpvqjcUl/iU3Dl9.G', 'admin', NULL, NULL, NULL, NULL, NULL),
(3, 'ss', '$2y$10$Z8BW4.hMBX1PFU/gnvnGC.rAXe/WAa11Ur9tjJAwj4Jo2mxyZn1oe', 'staff', NULL, NULL, NULL, NULL, NULL),
(4, 'thisal', '$2y$10$UJ495RqsbihJDDpJWHm2MuKodX67mhN.bR/n2Ms6Jow.kAuEs6fsS', 'admin', NULL, NULL, NULL, NULL, NULL),
(5, '1234', '$2y$10$FbpZQ2p7HHFfPOSzELYk0OXK3HyA5F/n5V1tg9KhpiSueMiEtR.Tm', 'staff', NULL, NULL, NULL, NULL, NULL),
(6, 'TC', '$2y$10$oqhzOQgwply4iSXOBwlHx.RscCnv/tLGYrmu5zZ9XCago3Kjwxw6m', 'admin', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `make` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `price` decimal(12,2) DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `mileage` decimal(12,1) DEFAULT 0.0,
  `transmission` varchar(50) DEFAULT NULL,
  `fuel` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `images` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `make`, `model`, `year`, `price`, `image`, `mileage`, `transmission`, `fuel`, `description`, `created_at`, `images`) VALUES
(2, 'Toyota', 'Corolla', 0, 0.00, '', 0.0, NULL, NULL, NULL, '2025-09-04 07:05:40', NULL),
(3, 'japn', 'byd', 2024, 50000.00, NULL, 10000.0, 'Automatic', 'Hybrid', 'AZaxa', '2025-08-30 21:42:26', NULL),
(4, 'japn', 'byd', 2024, 50000.00, NULL, 10000.0, '', '', 'AZaxa', '2025-08-31 03:01:55', NULL),
(5, 'japn', 'byd', 2024, 50000.00, NULL, 10000.0, '', '', '', '2025-08-31 03:10:40', NULL),
(6, 'japn', 'byd', 2024, 50000.00, NULL, 10000.0, '', '', '', '2025-08-31 04:51:34', NULL),
(7, 'japn', 'byd', 2024, 50000.00, NULL, 10000.0, '', '', 'xasxs', '2025-08-31 04:54:41', NULL),
(8, 'japn', 'byd', 2024, 50000.00, NULL, 10000.0, '', '', '', '2025-08-31 05:27:50', NULL),
(9, 'japn', 'Seal', 2025, 1000000.00, NULL, 20000.0, 'Manual', 'Petrol', 'CFVGBHNMKL,', '2025-09-01 06:06:04', NULL),
(10, 'japn', 'Seal', 2025, 1000000.00, NULL, 20000.0, '', 'Diesel', 'v cgfvbhjml,;./', '2025-09-01 07:14:21', NULL),
(11, 'japn', 'Seal', 2025, 1000000.00, NULL, 20000.0, 'Manual', 'Diesel', 'fvgvbgtb', '2025-09-01 08:35:04', NULL),
(12, 'japn', 'Seal', 2025, 1000000.00, NULL, 20000.0, '', '', '', '2025-09-02 03:16:19', NULL),
(13, 'japn', 'Seal', 2025, 1000000.00, NULL, 20000.0, 'Automatic', 'Petrol', 'vgvvvb', '2025-09-02 03:36:58', NULL),
(15, 'japn', 'Seal', 2020, 1000000.00, NULL, 1000.0, 'Manual', 'Diesel', '', '2025-09-14 05:19:44', NULL),
(16, 'japn', 'Seal', 2020, 1000000.00, NULL, 1000.0, 'Manual', 'Petrol', 'sxqsxwcwec', '2025-09-14 05:37:43', NULL),
(20, 'Toyota', 'Voxy SZ', 2024, 32900000.00, 'car_68c832d1317f59.84156648.png', 10000.0, 'Manual', 'Petrol', '2qe32r', '2025-09-15 15:37:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_list`
--

CREATE TABLE `vehicle_list` (
  `id` int(11) NOT NULL,
  `model_name` varchar(100) DEFAULT NULL,
  `fuel_efficiency` varchar(50) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `resale_value` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle_list`
--

INSERT INTO `vehicle_list` (`id`, `model_name`, `fuel_efficiency`, `price`, `resale_value`) VALUES
(1, 'COROLLA', '50l', 1000000, '1000000'),
(2, 'COROLLA', '50l', 1000000, '1000000'),
(6, 'tata', '10', 1000000, '10000');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_parts`
--

CREATE TABLE `vehicle_parts` (
  `id` int(11) NOT NULL,
  `part_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle_parts`
--

INSERT INTO `vehicle_parts` (`id`, `part_name`, `description`, `price`, `stock`, `image`, `created_at`, `category_id`, `name`) VALUES
(1, 'Engine Oil 5W-30', 'Premium synthetic oil', 3500.00, 20, NULL, '2025-08-30 06:55:59', NULL, NULL),
(3, 'THISAL CHATHNUKA', '', 11.00, 1, '', '2025-09-01 15:46:54', NULL, NULL),
(5, 'THISAL CHATHNUKA', '', 11.00, 1, '', '2025-09-01 16:47:03', NULL, NULL),
(6, 'VALVOLINE VR 1 RACING 15W40', 'Valvoline VR1 Racing 15W40 is a premium high performance motor oil specially designed for ultimate perfomance in turbo anf non-turbo charged petrol engines. Extra additives resist extreme operating conditions during rallying and racing.\r\n\r\n', 13000.00, 10, 'car.jpeg', '2025-09-02 03:30:23', NULL, NULL),
(7, 'VALVOLINE VR 1 RACING 15W40', '', 13000.00, 10, '', '2025-09-02 03:33:32', NULL, NULL),
(8, 'VALVOLINE VR 1 RACING 15W40', '', 13000.00, 10, 'car.jpeg', '2025-09-02 03:33:47', NULL, NULL),
(9, 'VALVOLINE VR 1 RACING 15W40', '', 13000.00, 10, 'a (6).png', '2025-09-02 03:34:12', NULL, NULL),
(10, 'VALVOLINE VR 1 RACING 15W40', '', 13000.00, 10, '', '2025-09-02 03:36:14', NULL, NULL),
(12, 'Toyota AC-102EX (Cabin Filter - EX Type) ', 'Toyota AC-102EX Cabin Filter – EX Type\r\nKeep your ride fresh and your engine breathing clean with the Toyota AC-102EX Cabin Filter (EX Type)—engineered for optimal air purification and long-lasting performance.\r\n🔧 Compatible Models:\r\nToyota Estima Toyota Harrier Toyota Land Cruiser Prado\r\nAdvanced EX-type filtration for enhanced dust and pollen capture\r\nDurable construction for extended service life\r\nEasy installation—OEM fit for supported Toyota models\r\nImproves cabin air quality and HVAC efficiency\r\n\r\nWhether you are upgrading for comfort or maintaining peak performance, the AC-102EX is a smart choice for Toyota owners who value clean air and reliable parts.', 40000.00, 1, 'mAyIZo8BdRPnwlx69eltf9DWRMpHzja176u6lM0E.jpg', '2025-09-02 11:19:40', NULL, NULL),
(13, 'Toyota AC-102EX (Cabin Filter - EX Type) ', 'tfvbrfhvfrhvh4gvhr4hvgh2', 40000.00, 1, 'mAyIZo8BdRPnwlx69eltf9DWRMpHzja176u6lM0E.jpg', '2025-09-02 11:52:16', NULL, NULL),
(14, 'VALVOLINE VR 1 RACING 15W40', '1000000', 1000.00, 1, '', '2025-09-06 13:21:52', NULL, NULL),
(15, 'THISAL CHATHNUKA', '4\r\n5', 1000.00, 1, 'a (1).png', '2025-09-15 04:22:33', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `part_id` (`part_id`);

--
-- Indexes for table `parts`
--
ALTER TABLE `parts`
  ADD PRIMARY KEY (`part_id`);

--
-- Indexes for table `part_messages`
--
ALTER TABLE `part_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `part_id` (`part_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`part_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reviews_vehicle` (`vehicle_id`);

--
-- Indexes for table `test_drive_bookings`
--
ALTER TABLE `test_drive_bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_list`
--
ALTER TABLE `vehicle_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_parts`
--
ALTER TABLE `vehicle_parts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parts`
--
ALTER TABLE `parts`
  MODIFY `part_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `part_messages`
--
ALTER TABLE `part_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `part_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `test_drive_bookings`
--
ALTER TABLE `test_drive_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `vehicle_list`
--
ALTER TABLE `vehicle_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vehicle_parts`
--
ALTER TABLE `vehicle_parts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`part_id`) REFERENCES `parts` (`part_id`) ON DELETE CASCADE;

--
-- Constraints for table `part_messages`
--
ALTER TABLE `part_messages`
  ADD CONSTRAINT `part_messages_ibfk_1` FOREIGN KEY (`part_id`) REFERENCES `vehicle_parts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_vehicle` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `vehicle_parts`
--
ALTER TABLE `vehicle_parts`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
