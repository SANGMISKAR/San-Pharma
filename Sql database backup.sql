-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2024 at 02:28 PM
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
-- Database: `online_pharmacy`
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
(1, 'sanket', '2003'),
(2, 'admin', '$2y$10$yN5IhWgzP7F.MZ2a1vF2QeP.z8ZHo6se4mbRV3tdwQ1PLjOHv9pCq'),
(3, 'ankita', '$2y$10$bYQoA4Oo16Iem848tmPJxeT2y3SjdjTTV5eJes1zmvK91WrgYv8Y6'),
(4, 'new@gmail.com', '$2y$10$Kj4P6LEdCCF/fxwN2jdL5ePaCqoT.rPxiWUd8INB97bkLYnAQjZ82'),
(5, 'admin12', '$2y$10$Pyu/z2Eo27l/1nLcvCf64.9OJj1z7AqFCXgClXQkQROcVCyEmSEfO'),
(7, 'admin13', '$2y$10$ggWLu3LIwJMVXXgBqItFduaJNHeJ.8TEJiE/tDe4oGntx3Dt4vXWe'),
(9, 'sayali', '$2y$10$dw87FVdnSDdWoXGo6Ja1yuj120dv8SvpPyedoxtFe9/./RWjYZC2a'),
(10, 'talib', '$2y$10$rND8CfJV9d6be88O48vj..Ef6b4ww1v955bHRn2oCmRyHWNsMuX6K');

-- --------------------------------------------------------

--
-- Table structure for table `admin_info`
--

CREATE TABLE `admin_info` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `class` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `class`) VALUES
(1, 'Allergy Relief', 'allergy-relief'),
(2, 'Health Care', 'health-care'),
(3, 'Fitness', 'fitness'),
(4, 'Baby Care', 'baby-care');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'sanket', 'sanket@gmail.com', 'bndsansannasm', 'dasnsansjnjasnassjndsajknj,kndjjc', '2024-09-13 13:12:34'),
(2, 'sanket', 'sanket@gmail.com', 'bndsansannasm', 'dasnsansjnjasnassjndsajknj,kndjjc', '2024-09-13 13:14:46'),
(3, 'Sanket Sangmiskar', 'sanketsangmiskar119@gmial.com', 'ffdfdssd', 'dfdsfgfdfdfgdfgd', '2024-09-13 13:20:00'),
(4, 'Sanket Sangmiskar', 'sanketsangmiskar119@gmial.com', 'ffdfdssd', 'dfdsfgfdfdfgdfgd', '2024-09-13 13:21:43'),
(5, 'Sanket Sangmiskar', 'sanketsangmiskar119@gmial.com', 'ffdfdssd', 'dfdsfgfdfdfgdfgd', '2024-09-13 13:24:53'),
(6, 'Sanket Sangmiskar', 'sanketsangmiskar119@gmial.com', 'ffdfdssd', 'dfdsfgfdfdfgdfgd', '2024-09-13 13:27:10'),
(7, 'Sanket Sangmiskar', 'sanketsangmiskar119@gmial.com', 'ffdfdssd', 'dfdsfgfdfdfgdfgd', '2024-09-13 13:29:07'),
(8, 'Sanket Sangmiskar', 'sanketsangmiskar119@gmial.com', 'ffdfdssd', 'dfdsfgfdfdfgdfgd', '2024-09-13 13:29:28'),
(9, 'Sanket Sangmiskar', 'sanketsangmiskar119@gmial.com', 'ffdfdssd', 'dfdsfgfdfdfgdfgd', '2024-09-13 13:31:07'),
(10, 'Sanket Sangmiskar', 'sanketsangmiskar119@gmial.com', 'ffdfdssd', 'dfdsfgfdfdfgdfgd', '2024-09-13 13:36:01'),
(11, 'Sanket Sangmiskar', 'sanketsangmiskar119@gmial.com', 'ffdfdssd', 'dfdsfgfdfdfgdfgd', '2024-09-13 13:37:23'),
(12, 'Sanket Sangmiskar', 'sanketsangmiskar119@gmial.com', 'ffdfdssd', 'dfdsfgfdfdfgdfgd', '2024-09-13 13:37:48'),
(13, 'Sanket Sangmiskar', 'sanketsangmiskar119@gmial.com', 'ffdfdssd', 'dfdsfgfdfdfgdfgd', '2024-09-13 13:37:59'),
(14, 'Sanket Sangmiskar', 'sanketsangmiskar119@gmial.com', 'ffdfdssd', 'dfdsfgfdfdfgdfgd', '2024-09-13 13:39:41'),
(15, 'Sanket Sangmiskar', 'sanketsangmiskar119@gmial.com', 'ffdfdssd', 'dfdsfgfdfdfgdfgd', '2024-09-13 13:40:28'),
(16, 'Sanket Sangmiskar', 'sanketsangmiskar119@gmial.com', 'ffdfdssd', 'dfdsfgfdfdfgdfgd', '2024-09-13 13:41:14'),
(17, 'Sanket Sangmiskar', 'sanketsangmiskar119@gmial.com', 'ffdfdssd', 'dfdsfgfdfdfgdfgd', '2024-09-13 13:42:21'),
(18, 'Sanket Sangmiskar', 'sanketsangmiskar119@gmial.com', 'cczxz', 'vvnjkjvjndjdsvdbjhvbcxvbhxc', '2024-09-17 09:22:30');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `final_total` decimal(10,2) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `name`, `address`, `phone`, `email`, `payment_method`, `total_amount`, `discount`, `final_total`, `order_date`) VALUES
(1, 6, 'Sanket Sangmiskar', 'Thane, thane, mahARASTRA, 454', '01234567890', 'sanketsangmiskar119@gmial.com', 'credit_card', 280.00, 42.00, 238.00, '2024-09-15 10:03:30'),
(2, 6, 'Sanket Sangmiskar', 'Thane, thane, mahARASTRA, 454', '01234567890', 'sanketsangmiskar119@gmial.com', 'credit_card', 230.00, 34.50, 195.50, '2024-09-15 10:04:00'),
(3, 6, 'Sanket Sangmiskar NEW', 'Thane, thane, mahARASTRA, 454', '01234567890', 'sanketsangmiskar119@gmial.com', 'credit_card', 230.00, 34.50, 195.50, '2024-09-15 10:06:32'),
(4, NULL, 'Sanket Sangmiskar  23', 'Thane, thane, mahARASTRA, 454', '01234567890', 'sanketsangmiskar119@gmial.com', 'paypal', 330.00, 49.50, 280.50, '2024-09-16 04:56:30'),
(5, 9, 'Sanket Sangmiskar  23', 'Thane, thane, mahARASTRA, 454', '01234567890', 'sanketsangmiskar119@gmial.com', 'credit_card', 180.00, 27.00, 153.00, '2024-09-16 06:40:49'),
(6, NULL, 'Sanket Sangmiskar  23', 'Thane, thane, mahARASTRA, 454', '01234567890', 'sanketsangmiskar119@gmial.com', 'debit_card', 125.93, 18.89, 107.04, '2024-09-17 09:19:00'),
(7, 7, 'trishu', 'asaa, sasc, scsac, saasc', 'sacscas', 'trishu411@gmail.com', 'credit_card', 180.00, 27.00, 153.00, '2024-09-18 06:05:27'),
(8, 7, 'trishu', 'eer, re, ere, saasc', 'reere', 'trishu41@gmail.com', 'credit_card', 180.00, 27.00, 153.00, '2024-09-18 06:08:01'),
(9, NULL, 'asd', 'Thane, thane, mahARASTRA, 454', '01234567890', 'sanketsangmiskar119@gmial.com', 'credit_card', 180.00, 27.00, 153.00, '2024-09-18 06:09:17'),
(10, 10, 'sanket', 'eer, re, ere, saasc', 'sacscas', 'sanketsangmiskar2003@gmail.com', 'credit_card', 180.00, 27.00, 153.00, '2024-09-18 06:32:15'),
(11, 10, 'trishu', 'eer, re, ere, saasc', '4444444444444', 'sanketsangmiskar2003@gmail.com', 'credit_card', 50.00, 7.50, 42.50, '2024-09-18 06:37:33'),
(12, NULL, 'asd', 'Thane, thane, mahARASTRA, 454', '01234567890', 'sanketsangmiskar2003@gmial.com', 'credit_card', 180.00, 27.00, 153.00, '2024-09-18 06:50:14'),
(13, NULL, 'asd', 'Thane, thane, mahARASTRA, 454', '01234567890', 'sanketsangmiskar2003@gmial.com', 'credit_card', 180.00, 27.00, 153.00, '2024-09-18 06:53:05'),
(14, 10, 'trishu', 'eer, re, er, saasc', '488848646846', 'sanketsangmiskar2003@gmail.com', 'credit_card', 50.00, 7.50, 42.50, '2024-09-18 06:56:39'),
(15, 10, 'trishu', 'eer, re, er, saasc', '488848646846', 'sanketsangmiskar2003@gmail.com', 'credit_card', 50.00, 7.50, 42.50, '2024-09-18 07:25:28'),
(16, 10, 'trishu', 'eer, re, er, saasc', '488848646846', 'sanketsangmiskar2003@gmail.com', 'credit_card', 50.00, 7.50, 42.50, '2024-09-18 07:26:50'),
(17, 10, 'trishu', 'eer, re, er, saasc', '488848646846', 'sanketsangmiskar2003@gmail.com', 'credit_card', 50.00, 7.50, 42.50, '2024-09-18 07:29:57'),
(18, 10, 'trishu', 'eer, re, ere, saasc', '488848646846', 'sanketsangmiskar2003@gmail.com', 'credit_card', 50.00, 7.50, 42.50, '2024-09-18 07:33:14'),
(19, 10, 'trishu', 'eer, re, er, saasc', '488848646846', 'sanketsangmiskar2003@gmail.com', 'credit_card', 50.00, 7.50, 42.50, '2024-09-18 07:33:43'),
(20, 10, 'trishu', 'eer, re, er, saasc', '488848646846', 'sanketsangmiskar2003@gmail.com', 'credit_card', 50.00, 7.50, 42.50, '2024-09-18 08:16:53'),
(21, 10, 'trishu', 'eer, re, er, saasc', '488848646846', 'dsforcs@gmail.com', 'credit_card', 180.00, 27.00, 153.00, '2024-09-18 10:18:58'),
(22, 10, 'sanket', 'eer, re, er, saasc', '488848646846', 'dsforcs@gmail.com', 'credit_card', 180.00, 27.00, 153.00, '2024-09-18 10:31:26');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`, `subtotal`) VALUES
(2, 1, 86, 'Fusion Allergy Nasal Spray', 1, 180.00, 180.00),
(3, 2, 86, 'Fusion Allergy Nasal Spray', 1, 180.00, 180.00),
(6, 3, 86, 'Fusion Allergy Nasal Spray', 1, 180.00, 180.00),
(7, 4, 86, 'Fusion Allergy Nasal Spray', 1, 180.00, 180.00),
(9, 5, 86, 'Fusion Allergy Nasal Spray', 1, 180.00, 180.00),
(12, 7, 86, 'Fusion Allergy Nasal Spray', 1, 180.00, 180.00),
(13, 8, 86, 'Fusion Allergy Nasal Spray', 1, 180.00, 180.00),
(14, 9, 86, 'Fusion Allergy Nasal Spray', 1, 180.00, 180.00),
(15, 10, 86, 'Fusion Allergy Nasal Spray', 1, 180.00, 180.00),
(17, 12, 86, 'Fusion Allergy Nasal Spray', 1, 180.00, 180.00),
(18, 13, 86, 'Fusion Allergy Nasal Spray', 1, 180.00, 180.00),
(26, 21, 86, 'Fusion Allergy Nasal Spray', 1, 180.00, 180.00),
(27, 22, 86, 'Fusion Allergy Nasal Spray', 1, 180.00, 180.00);

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) UNSIGNED NOT NULL,
  `patient_name` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `doctor_name` varchar(100) NOT NULL,
  `hospital_name` varchar(100) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `patient_name`, `date`, `doctor_name`, `hospital_name`, `file_name`, `file_path`, `uploaded_at`) VALUES
(2, 'Hayne', '2024-09-20', 'bakeu', 'kgenral hospital', 'Screenshot 2024-01-22 144019.png', 'user_prep_uploads/Screenshot 2024-01-22 144019.png', '2024-09-10 10:29:02'),
(3, 'Hayne', '2024-09-20', 'bakeu', 'kgenral hospital', 'Screenshot 2024-01-22 144019.png', 'user_prep_uploads/Screenshot 2024-01-22 144019.png', '2024-09-10 10:32:04'),
(5, 'Hayne', '2024-09-24', 'ghghghf', 'gfghghgh', 'Screenshot 2024-07-25 220457.png', 'user_prep_uploads/Screenshot 2024-07-25 220457.png', '2024-09-16 07:11:14'),
(6, 'omkar', '2024-09-16', 'sahabuddin khan', 'fortis', 'cart img.png', 'user_prep_uploads/cart img.png', '2024-09-16 07:53:10');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `availability` varchar(50) DEFAULT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `new_price` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ingredients` text DEFAULT NULL,
  `directions` text DEFAULT NULL,
  `warnings` text DEFAULT NULL,
  `manufacturer` varchar(100) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `package_quantity` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `sale_tag` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `brand`, `code`, `availability`, `old_price`, `new_price`, `description`, `ingredients`, `directions`, `warnings`, `manufacturer`, `expiry_date`, `package_quantity`, `image_url`, `category_id`, `sale_tag`) VALUES
(86, 'Fusion Allergy Nasal Spray', 'Fusion', NULL, 'In Stock', 250.00, 180.00, 'Fusion allergy nasal spray provides quick relief from nasal allergy symptoms,\r\nEffective for sneezing, runny nose, and nasal congestion.', 'Fluticasone Propionate,Propylene Glycol', 'Use 1-2 sprays in each nostril once or twice daily.', 'Do not use if you have a nasal infection.,Consult your doctor before use if you have any pre-existing conditions.', 'Fusion Pharmaceuticals', '2028-06-13', 0, 'product_uploads/Fusion-nasal-spray-2023.webp', 1, '50'),
(93, 'Nasacort Allergy 24HR', 'Nasacort', NULL, 'In Stock', 400.00, 350.00, 'Effective for 24-hour relief of nasal congestion, sneezing, runny nose, and itchy or watery eyes.', 'Triamcinolone Acetonide', 'Use 1-2 sprays in each nostril once daily.', 'Consult your doctor if you have any medical conditions.', 'AstraZeneca', '2026-11-30', 1, 'product_uploads/nasacort1.webp', 1, 'Discounted'),
(94, 'Afrin No Drip Extra Moisturizing Nasal Spray', 'Afrin', NULL, 'In Stock', 250.00, 200.00, 'Provides quick relief from nasal congestion and keeps nasal passages from drying out.', 'Oxymetazoline', 'Use 2-3 sprays in each nostril every 10-12 hours as needed.', 'Do not use for more than 3 days in a row.', 'Reckitt Benckiser', '2025-10-31', 1, 'product_uploads/afrin.webp', 1, 'Discounted'),
(95, 'Rhinocort Allergy', 'Rhinocort', NULL, 'In Stock', 300.00, 270.00, 'Delivers 24-hour relief from nasal congestion, sneezing, and runny or itchy nose.', 'Budesonide', 'Use 1-2 sprays in each nostril once daily.', 'Consult your doctor if you have a nasal infection or other conditions.', 'AstraZeneca', '2028-05-31', 1, 'product_uploads/rhinocort.webp', 1, 'Discounted'),
(96, 'Dymista Nasal Spray', 'Dymista', NULL, 'In Stock', 600.00, 550.00, 'Combines an antihistamine with a corticosteroid for powerful relief from allergy symptoms, including nasal congestion, sneezing, and runny nose.', 'Azelastine and Fluticasone Propionate', 'Use 1-2 sprays in each nostril twice daily.', 'Consult your doctor if you have a nasal infection or other conditions.', 'Valeant Pharmaceuticals', '2026-09-30', 1, 'product_uploads/dymista.webp', 1, 'Discounted'),
(97, 'Tylenol Extra Strength', 'Tylenol', NULL, 'In Stock', 200.00, 180.00, 'Provides relief from pain and fever with a powerful formula that helps reduce the severity of symptoms.', 'Acetaminophen', 'Take 1-2 tablets every 4-6 hours as needed. Do not exceed 8 tablets in 24 hours.', 'Consult a doctor if you have liver disease or other medical conditions.', 'Johnson & Johnson', '2026-12-31', 24, 'product_uploads/tylenol_extra_strength.webp', 2, 'Discounted'),
(98, 'Advair Diskus', 'Advair', NULL, 'In Stock', 1200.00, 1100.00, 'Helps control asthma and chronic obstructive pulmonary disease (COPD) symptoms with a combination of corticosteroid and long-acting beta-agonist.', 'Fluticasone Propionate, Salmeterol', 'Inhale 1 diskus twice daily. Do not use more than the prescribed dosage.', 'Not for acute asthma attacks. Consult your doctor if symptoms worsen.', 'GlaxoSmithKline', '2027-11-30', 60, 'product_uploads/advair_diskus.webp', 2, 'Discounted'),
(99, 'Aleve Pain Reliever', 'Aleve', NULL, 'In Stock', 250.00, 220.00, 'Long-lasting relief from pain and inflammation with an anti-inflammatory effect that provides up to 12 hours of relief.', 'Naproxen Sodium', 'Take 1-2 tablets every 8-12 hours as needed. Do not exceed 3 tablets in 24 hours.', 'Consult your doctor if you have heart disease or high blood pressure.', 'Bayer', '2025-09-30', 20, 'product_uploads/aleve_pain_reliever.webp', 2, 'Discounted'),
(100, 'Claritin Allergy Tablets', 'Claritin', NULL, 'In Stock', 180.00, 150.00, 'Provides relief from allergy symptoms such as sneezing, runny nose, and itchy eyes with a non-drowsy formula.', 'Loratadine', 'Take 1 tablet once daily. Do not exceed the recommended dosage.', 'Consult your doctor if you have liver or kidney conditions.', 'Bayer', '2026-06-30', 10, 'product_uploads/claritin_allergy_tablets.webp', 2, 'Discounted'),
(101, 'Prilosec OTC', 'Prilosec', NULL, 'In Stock', 400.00, 350.00, 'Effective treatment for frequent heartburn with a proton pump inhibitor that reduces stomach acid production.', 'Omeprazole', 'Take 1 capsule daily before a meal. Do not exceed 1 capsule in 24 hours.', 'Consult your doctor if you have severe liver disease or are taking other medications.', 'Procter & Gamble', '2027-04-30', 14, 'product_uploads/prilosec_otc.webp', 2, 'Discounted'),
(102, 'Benadryl Allergy Tablets', 'Benadryl', NULL, 'In Stock', 220.00, 190.00, 'Provides fast relief from allergy symptoms such as sneezing, runny nose, and itchy eyes with a sedating antihistamine.', 'Diphenhydramine Hydrochloride', 'Take 1-2 tablets every 4-6 hours as needed. Do not exceed 12 tablets in 24 hours.', 'May cause drowsiness. Avoid alcohol and other central nervous system depressants.', 'Johnson & Johnson', '2025-12-31', 24, 'product_uploads/benadryl_allergy_tablets.webp', 2, 'Discounted'),
(103, 'Zyrtec Allergy Relief', 'Zyrtec', NULL, 'In Stock', 250.00, 220.00, 'Provides relief from indoor and outdoor allergy symptoms with a non-drowsy formula that lasts up to 24 hours.', 'Cetirizine Hydrochloride', 'Take 1 tablet once daily. Do not exceed the recommended dosage.', 'Consult your doctor if you have liver or kidney conditions. May cause mild drowsiness.', 'UCB, Inc.', '2026-11-30', 30, 'product_uploads/zyrtec_allergy_relief.webp', 2, 'Discounted'),
(104, 'Mucinex DM Extended Release', 'Mucinex', NULL, 'In Stock', 350.00, 320.00, 'Relieves cough and chest congestion with a combination of expectorant and cough suppressant for up to 12 hours.', 'Guaifenesin, Dextromethorphan HBr', 'Take 1 tablet every 12 hours as needed. Do not exceed 2 tablets in 24 hours.', 'Consult your doctor if you have a persistent cough or chronic respiratory conditions.', 'Reckitt Benckiser', '2026-03-31', 14, 'product_uploads/mucinex_dm_extended_release.webp', 2, 'Discounted'),
(105, 'Whey Protein Powder', 'Optimum Nutrition', NULL, 'In Stock', 1500.00, 1300.00, 'High-quality whey protein powder for muscle recovery and growth. Contains essential amino acids.', 'Whey Protein Isolate, Whey Protein Concentrate', 'Mix 1 scoop with 200ml of water or milk and consume post-workout.', 'Consult with a healthcare provider if you have a dairy allergy.', 'Glanbia Performance Nutrition', '2025-06-30', 2, 'product_uploads/whey_protein_powder.webp', 3, 'Discounted'),
(106, 'BCAA Amino Acid Supplement', 'Cellucor', NULL, 'In Stock', 1200.00, 1000.00, 'Essential branched-chain amino acids (BCAAs) to support muscle recovery and reduce fatigue during workouts.', 'L-Leucine, L-Isoleucine, L-Valine', 'Mix 1 scoop with 300ml of water and consume before or during workouts.', 'Not recommended for pregnant or nursing women.', 'Cellucor LLC', '2025-09-30', 30, 'product_uploads/bcaa_amino_acid_supplement.webp', 3, 'Discounted'),
(107, 'Creatine Monohydrate', 'MuscleTech', NULL, 'In Stock', 1000.00, 850.00, 'Pure creatine monohydrate to enhance strength, power, and muscle mass.', 'Creatine Monohydrate', 'Take 1 scoop with 200ml of water or juice daily.', 'Consult with a physician if you have kidney issues.', 'MuscleTech', '2026-03-31', 500, 'product_uploads/creatine_monohydrate.webp', 3, 'Discounted'),
(108, 'Pre-Workout Energy Drink', 'Redcon1', NULL, 'In Stock', 1500.00, 1300.00, 'Boost your workout performance with this powerful pre-workout energy drink designed to increase energy and focus.', 'Caffeine, Beta-Alanine, Citrulline Malate', 'Mix 1 scoop with 200ml of water 30 minutes before workout.', 'Not suitable for individuals sensitive to caffeine.', 'Redcon1', '2025-12-31', 30, 'product_uploads/pre_workout_energy_drink.webp', 3, 'Discounted'),
(109, 'Post-Workout Recovery Shake', 'BSN', NULL, 'In Stock', 1800.00, 1600.00, 'Supports muscle recovery with a blend of protein, carbs, and essential nutrients to restore energy levels after workouts.', 'Whey Protein Isolate, Maltodextrin', 'Mix 1 scoop with 250ml of water or milk and consume within 30 minutes after exercise.', 'Contains milk and soy; consult if you have allergies.', 'BSN', '2025-08-31', 2, 'product_uploads/post_workout_recovery_shake.webp', 3, 'Discounted'),
(110, 'Multivitamin for Athletes', 'GNC', NULL, 'In Stock', 900.00, 750.00, 'Comprehensive multivitamin formula to support overall health and athletic performance.', 'Vitamin A, C, D, E, B-Complex, Minerals', 'Take 1 tablet daily with a meal.', 'Consult your physician if you are pregnant or have health conditions.', 'General Nutrition Centers', '2025-07-31', 90, 'product_uploads/multivitamin_for_athletes.webp', 3, 'Discounted'),
(111, 'Omega-3 Fish Oil Capsules', 'Nature Made', NULL, 'In Stock', 700.00, 600.00, 'High-quality fish oil supplement to support heart health and reduce inflammation.', 'Fish Oil (EPA and DHA)', 'Take 2 softgels daily with meals.', 'Consult with your doctor if you are on blood-thinning medication.', 'Nature Made', '2025-11-30', 120, 'product_uploads/omega_3_fish_oil_capsules.webp', 3, 'Discounted'),
(116, 'Voltaren Pain Relief Gel', 'Voltaren', NULL, 'In Stock', 600.00, 550.00, 'Topical gel for targeted relief of pain and inflammation in muscles and joints.', 'Diclofenac Sodium', 'Apply to the affected area 3-4 times daily.', 'Do not use on broken skin or near the eyes. Consult a doctor if you have allergies.', 'Voltaren', '2026-03-31', 100, 'product_uploads/voltaren_gel.webp', 3, 'Discounted'),
(117, 'IcyHot Pain Relief Patch', 'IcyHot', NULL, 'In Stock', 250.00, 220.00, 'Pain relief patch that provides warm and cool sensations to relieve muscle and joint pain.', 'Menthol, Methyl Salicylate', 'Apply to the affected area and wear for up to 8 hours.', 'Do not apply to broken skin. Consult a doctor if you have sensitive skin.', 'IcyHot', '2025-11-30', 5, 'product_uploads/icyhot_patch.webp', 3, 'Discounted'),
(118, 'Aleve Pain Reliever Tablets', 'Aleve', NULL, 'In Stock', 350.00, 300.00, 'Over-the-counter pain relief tablets for temporary relief of pain and inflammation.', 'Naproxen Sodium', 'Take 1 tablet every 8-12 hours as needed.', 'Do not exceed recommended dosage. Consult your doctor if you have health conditions.', 'Aleve', '2026-12-31', 20, 'product_uploads/aleve_tablets.webp', 3, 'Discounted'),
(119, 'Baby Tylenol Oral Suspension', 'Tylenol', NULL, 'In Stock', 400.00, 350.00, 'Pain and fever reducer for infants and children. Gentle on little tummies.', 'Acetaminophen', 'Give 1-2 teaspoons every 4-6 hours as needed.', 'Do not exceed 5 doses in 24 hours. Consult a doctor if symptoms persist.', 'Tylenol', '2025-09-30', 120, 'product_uploads/baby_tylenol.webp', 4, 'Discounted'),
(120, 'Similac Pro-Advance Infant Formula', 'Similac', NULL, 'In Stock', 1200.00, 1000.00, 'Infant formula with DHA and lutein for brain and eye development.', 'DHA, Lutein, Iron, Calcium', 'Prepare as directed and feed according to age and weight.', 'Consult your pediatrician before changing formulas.', 'Similac', '2026-07-31', 900, 'product_uploads/similac_formula.webp', 4, 'Discounted'),
(121, 'Johnson’s Baby Shampoo', 'Johnson’s', NULL, 'In Stock', 250.00, 220.00, 'Gentle baby shampoo that is as mild as water. Designed for delicate baby hair.', 'Water, Sodium Lauryl Sulfate', 'Apply to wet hair, lather, and rinse. Avoid contact with eyes.', 'For external use only. Avoid using near eyes.', 'Johnson’s', '2025-06-30', 200, 'product_uploads/baby_shampoo.webp', 4, 'Discounted'),
(122, 'Pampers Swaddlers Diapers', 'Pampers', NULL, 'In Stock', 900.00, 750.00, 'Soft and absorbent diapers for newborns with a breathable outer cover.', 'Polyethylene, Polypropylene', 'Change diapers frequently to maintain skin health.', 'Do not flush. Dispose of properly.', 'Pampers', '2025-11-30', 96, 'product_uploads/pampers_diapers.webp', 4, 'Discounted'),
(124, 'Desitin Rapid Relief Diaper Rash Cream', 'Desitin', NULL, 'In Stock', 400.00, 350.00, 'Provides immediate relief and helps heal diaper rash.', 'Zinc Oxide, Petrolatum', 'Apply generously to affected area with each diaper change.', 'For external use only. Avoid contact with eyes.', 'Desitin', '2025-10-31', 113, 'product_uploads/desitin_cream.webp', 4, 'Discounted'),
(125, 'Gerber Good Start Gentle Powder Infant Formula', 'Gerber', NULL, 'In Stock', 1100.00, 950.00, 'Easy-to-digest formula designed to be gentle on sensitive tummies.', 'Whey Protein, Lactose', 'Mix with water as directed and feed according to age.', 'Consult your pediatrician for proper usage.', 'Gerber', '2026-05-31', 800, 'product_uploads/gerber_formula.webp', 4, 'Discounted'),
(126, 'Aveeno Baby Daily Moisture Lotion', 'Aveeno', NULL, 'In Stock', 300.00, 250.00, 'Daily moisture lotion made with natural colloidal oatmeal for soft and smooth skin.', 'Colloidal Oatmeal, Dimethicone', 'Apply liberally to baby’s skin as needed.', 'For external use only. Avoid contact with eyes.', 'Aveeno', '2025-12-31', 150, 'product_uploads/aveeno_lotion.webp', 4, 'Discounted');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session_data` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `contact`, `password`, `created_at`) VALUES
(1, 'sanket', 'sanket@gmail.com', '7894561230', 'sanket', '2024-08-27 16:47:38'),
(3, 'sanket', 'sanket12@gmail.com', '7894561230', '2003', '2024-08-27 16:48:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `name`, `email`, `contact`, `password`, `created_at`) VALUES
(1, 'new', 'new@gmail.com', '4567891340', '$2y$10$RnpRYdkkn3X.kT3DWG0ANewnxsFdEZIio.ZQcnJNIZOUAv9zl56nO', '2024-09-05 03:36:07'),
(2, 'saif', 'saif@gmail.com', '7894561235', '$2y$10$wD84Lc.ORm6fmrOf6tGsjewK9qMzM3NCITo71pbiA6N.TjsAnS4cK', '2024-09-11 10:33:42'),
(3, 'sayali', 'sayali@gmail.com', '7894561235', '$2y$10$xB5OhyU3bARXhw4nVJ6CN.wgVNgkFTwFQooc7AFtQGkgEsDejWily', '2024-09-13 11:14:15'),
(6, 'Tanu sangmiskar', 'sayali21@gmail.com', '8793124103', '$2y$10$b1FpFMlx56mft72GeoFyN.oQBlwXd0GsA/gH4D5.ZQeTEv.T1Dt36', '2024-09-13 14:02:34'),
(7, 'san', 'trishu411@gmail.com', '4567891235', '$2y$10$3Uphg7/F2MgGvh4EOEnoB.zwcgf1W/Di6rJye5h9j5DdF5xKP7JTS', '2024-09-13 15:45:11'),
(8, 'test cart', 'cart@gmail.com', '7412589635', '$2y$10$cp7sMfOhJYBFg22E8wTab.YaIuq9TpD39oaSmYLKuTD7SCFcy2DfG', '2024-09-14 19:02:17'),
(9, 'omkar', 'om123@gmail.com', '7208298287', '$2y$10$5W55CzNfvEwV0iUKl7D6/e667nYlZxulrxqKUmz91ZLgRoCkMOsI2', '2024-09-16 04:58:18'),
(10, 'sanket ', 'sanketsangmiskar2003@gmail.com', '8793124012', '$2y$10$N1NEkRgqn0ihNCL3n29JFO/kHCsXTaRNkl1zDjb7dw87Z./3cxGZq', '2024-09-18 06:31:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `admin_info`
--
ALTER TABLE `admin_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `admin_info`
--
ALTER TABLE `admin_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
