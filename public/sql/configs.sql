-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 04, 2024 at 11:33 AM
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
-- Dumping data for table `configs`
--

INSERT INTO `configs` (`id`, `name`, `slug`, `cpf_cnpj`, `postalCode`, `number`, `address`, `district`, `city`, `state`, `complement`, `board`, `airfield_codigoOaci`, `airfield_ciad`, `airfield_name`, `airfield_city`, `airfield_state`, `logo_path`, `emails`, `contacts`, `updated_by`, `created_at`, `updated_at`, `chart_categories`, `payment_form`, `chart_category_id`) VALUES
(1, 'AEROCLUBE DE MONTENEGRO', 'aeroclube-de-montenegro', '91.374.967/0001-99', '92527-470', 'SN', 'Rodovia RS-124', 'Aeroclube', 'Montenegro', 'RS', NULL, '[{\"position\":\"Presidente\",\"name\":\"Osvaldo Laini\"},{\"position\":\"SGSO\",\"name\":\"\"}]', 'SSNG', 'RS0046', 'HELIO ALVES DE OLIVEIRA', 'MONTENEGRO', 'RIO GRANDE DO SUL', 'aeroclube-de-montenegro.png', NULL, '[{\"type\":\"fixo\",\"contact\":null}]', NULL, '2024-08-14 02:48:34', '2024-11-01 01:09:20', NULL, '[\"boleto\", \"dinheiro\", \"pix\", \"debito\"]', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
