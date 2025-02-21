-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 15/11/2024 às 23:14
-- Versão do servidor: 5.7.23-23
-- Versão do PHP: 8.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistemaaerov2`
--

--
-- Despejando dados para a tabela `conditions_flights`
--

INSERT INTO `conditions_flights` (`id`, `active`, `title`, `nick`, `created_at`, `updated_at`, `updated_by`, `created_by`, `updated_because`, `deleted_at`, `deleted_because`, `deleted_by`) VALUES
(1, 1, 'VOO VISUAL', 'VFR', '2022-04-01 03:15:06', '2022-04-01 03:15:06', NULL, 'OSVALDO LAINI', NULL, NULL, NULL, NULL),
(2, 1, 'VOO POR INSTRUMENTO', 'IFR', '2022-04-01 03:15:22', '2022-04-01 03:15:22', NULL, 'OSVALDO LAINI', NULL, NULL, NULL, NULL);

--
-- Despejando dados para a tabela `learning_levels`
--

INSERT INTO `learning_levels` (`id`, `active`, `title`, `nick`, `obs`, `created_at`, `updated_at`, `updated_by`, `created_by`, `updated_because`, `deleted_at`, `deleted_because`, `deleted_by`) VALUES
(1, 1, 'MEMORIZAÇÃO', 'M', 'O ALUNO TEM INFORMAÇÃO SUFICIENTE SOBRE O EXERCÍCIO E MOEMORIZA OS PROCEDIMENTOS PARA INICIAR O TREINAMENTO', '2022-04-01 03:10:17', '2022-04-01 03:10:17', NULL, 'OSVALDO LAINI', NULL, NULL, NULL, NULL),
(2, 1, 'COMPREENSÃO', 'C', 'O ALUNO DEMONSTRA PERFEITA COMPREENSÃO DO EXERCÍCIO E PRATICA-O COM AUXÍLIO DO INSTRUTOR', '2022-04-01 03:11:22', '2022-04-01 03:11:22', NULL, 'OSVALDO LAINI', NULL, NULL, NULL, NULL),
(3, 1, 'APLICAÇÃO', 'A', 'O aluno demonstra compreender o exercício, mas comete erros nosmais durante a prática.', '2022-04-01 03:08:40', '2022-04-01 03:08:40', NULL, 'OSVALDO LAINI', NULL, NULL, NULL, NULL),
(4, 1, 'EXECUÇÃO', 'E', 'O ALUNO EXECUTA OS EXERCÍCIOS SEGUNDO PADRÕES ACEITÁVEIS, LEVANDO-SE EM CONTA A MAIOR OU MENOR DIFICULDADE', '2022-04-01 03:12:19', '2022-04-01 03:12:19', NULL, 'OSVALDO LAINI', NULL, NULL, NULL, NULL),
(5, 1, 'EXPERIÊNCIA', 'X', 'EXPERIÊNCIA JA ADIQUIRIDA EM MISSÕES ANTERIORES', '2022-04-01 03:12:55', '2022-04-01 03:13:32', 'OSVALDO LAINI', 'OSVALDO LAINI', NULL, NULL, NULL, NULL),
(6, 1, 'NÃO SE APLICA', 'N', 'NÃO SE APLICA', '2022-04-01 03:13:18', '2022-04-01 03:13:18', NULL, 'OSVALDO LAINI', NULL, NULL, NULL, NULL);

--
-- Despejando dados para a tabela `type_flights`
--

INSERT INTO `types_flights` (`id`, `active`, `title`, `nick`, `created_at`, `updated_at`, `updated_by`, `created_by`, `updated_because`, `deleted_at`, `deleted_because`, `deleted_by`) VALUES
(1, 1, 'DUPLO COMANDO', 'DC', '2022-04-01 03:14:16', '2022-04-01 03:14:16', NULL, 'OSVALDO LAINI', NULL, NULL, NULL, NULL),
(2, 1, 'SOLO', 'SL', '2022-04-01 03:14:28', '2022-04-01 03:14:28', NULL, 'OSVALDO LAINI', NULL, NULL, NULL, NULL),
(3, 1, 'PILOTO EM COMANDO', 'CMD', '2022-04-01 03:14:42', '2022-04-01 03:14:42', NULL, 'OSVALDO LAINI', NULL, NULL, NULL, NULL);

--
-- Despejando dados para a tabela `types_instructions`
--

INSERT INTO `types_instructions` (`id`, `active`, `title`, `nick`, `created_at`, `updated_at`, `updated_by`, `created_by`, `updated_because`, `deleted_at`, `deleted_because`, `deleted_by`) VALUES
(1, 1, 'EM SOLO', 'EM SOLO', '2022-04-01 03:15:37', '2022-04-01 03:15:37', NULL, 'OSVALDO LAINI', NULL, NULL, NULL, NULL),
(2, 1, 'EM VOO', 'EM VOO', '2022-04-01 03:15:48', '2022-04-01 03:15:48', NULL, 'OSVALDO LAINI', NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
