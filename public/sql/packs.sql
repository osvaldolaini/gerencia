-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 31, 2024 at 10:56 PM
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
-- Dumping data for table `packs`
--

INSERT INTO `packs` (`id`, `slug`, `active`, `title`, `qtd`, `unity`, `minutes`, `pack_type`, `created_at`, `updated_at`, `updated_by`, `created_by`, `updated_because`, `deleted_at`, `deleted_because`, `deleted_by`) VALUES
(1, 'sistema-aero-1-hora-avulsa', 1, '1 HORA AVULSA', 1, 'H', 60, 1, NULL, '2024-11-01 00:38:47', 'OSVALDO LAINI', NULL, NULL, NULL, NULL, NULL),
(2, 'sistema-aero-pacote-10-horas', 1, 'PACOTE 10 HORAS', 10, 'H', 600, 1, NULL, '2024-11-01 00:36:11', 'OSVALDO LAINI', NULL, NULL, NULL, NULL, NULL),
(3, 'sistema-aero-pacote-15-horas', 1, 'PACOTE 15 HORAS', 15, 'H', 900, 1, NULL, '2024-11-01 00:36:23', 'OSVALDO LAINI', NULL, NULL, NULL, NULL, NULL),
(4, 'sistema-aero-pacote-20-horas', 1, 'PACOTE 20 HORAS', 20, 'H', 1200, 1, NULL, '2024-11-01 00:36:34', 'OSVALDO LAINI', NULL, NULL, NULL, NULL, NULL),
(5, NULL, 1, 'PACOTE 25 HORAS', 25, 'H', 1500, 1, NULL, '2022-10-07 19:00:44', 'OSVALDO LAINI', NULL, NULL, NULL, NULL, NULL),
(6, 'sistema-aero-pacote-35-horas', 1, 'PACOTE 35 HORAS', 35, 'H', 2100, 1, NULL, '2024-11-01 00:36:45', 'OSVALDO LAINI', NULL, NULL, NULL, NULL, NULL),
(7, NULL, 1, 'PROMOÇÃO', 1, 'H', 60, 1, NULL, '2022-10-06 01:24:28', 'OSVALDO LAINI', NULL, NULL, NULL, NULL, NULL),
(8, 'sistema-aero-panoramico-voo', 1, 'PANORÂMICO VOO', 1, 'V', 1, 2, '2022-04-28 00:10:36', '2024-11-01 00:37:29', 'OSVALDO LAINI', 'OSVALDO LAINI', NULL, NULL, NULL, NULL),
(9, NULL, 1, 'REBOCADOR', 19, 'M', 19, 3, '2022-04-28 00:10:59', '2022-04-28 00:10:59', NULL, 'OSVALDO LAINI', NULL, NULL, NULL, NULL),
(10, 'sistema-aero-minuto-planador', 1, 'MINUTO PLANADOR', 1, 'M', 1, 1, '2022-09-10 17:24:34', '2024-11-01 00:39:00', NULL, 'OSVALDO LAINI', NULL, NULL, NULL, NULL),
(11, 'sistema-aero-panoramico-hora', 1, 'PANORÂMICO HORA', 1, 'H', 60, 2, '2022-10-05 23:38:25', '2024-11-01 00:36:59', 'OSVALDO LAINI', 'OSVALDO LAINI', NULL, NULL, NULL, NULL),
(12, 'sistema-aero-panoramico-minutos', 1, 'PANORÂMICO MINUTOS', 1, 'M', 1, 2, '2022-10-05 23:39:05', '2024-11-01 00:37:09', NULL, 'OSVALDO LAINI', NULL, NULL, NULL, NULL),
(13, NULL, 1, 'REBOCADOR MINUTO', 1, 'M', 1, 3, '2022-10-09 17:54:35', '2022-10-09 17:54:35', NULL, 'OSVALDO LAINI', NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
