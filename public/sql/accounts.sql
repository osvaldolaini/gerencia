-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 31, 2024 at 10:53 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistemaaerov2`
--

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `active`, `title`, `bank`, `number`, `payment_form`, `value`, `created_at`, `updated_at`, `updated_by`, `created_by`, `updated_because`, `deleted_at`, `deleted_because`, `deleted_by`) VALUES
(1, 1, 'CAIXA AEROCLUBE', 'EM CAIXA', NULL, '[\"dinheiro\"]', '0.00', '2024-11-01 01:10:18', '2024-11-01 01:10:18', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, 'BB', 'BANCO DO BRASIL', NULL, '[\"pix\", \"boleto\", \"debito\"]', '3500.00', '2024-11-01 01:10:50', '2024-11-01 01:10:50', NULL, NULL, NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
