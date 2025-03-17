-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 14, 2025 at 06:55 PM
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
-- Database: `gerencia`
--

-- --------------------------------------------------------

--
-- Table structure for table `faults`
--

CREATE TABLE `faults` (
  `id` bigint UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `deleted_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faults`
--

INSERT INTO `faults` (`id`, `active`, `title`, `number`, `code`, `created_at`, `updated_at`, `updated_by`, `created_by`, `deleted_at`, `deleted_by`) VALUES
(4, 1, 'Faltar à verdade', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 1, 'Utilizar-se de livros, cadernos ou outros materiais pertencentes a colegas, sem o devido consentimento', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 1, 'Deixar de comparecer ou chegar atrasado às atividades programadas', '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 1, 'Apresentar-se com uniforme diferente do que foi previamente estabelecido', '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 1, 'Ter pouco cuidado com o asseio próprio ou coletivo e com sua apresentação individual', '5', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 1, 'Trocar de uniforme em locais não apropriados', '6', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 1, 'Deixar material ou dependência sob sua responsabilidade desarrumada ou com má apresentação, ou para tal contribuir', '7', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 1, 'Deixar de apresentar material, documento ou trabalhos escolares de sua responsabilidade, nas atividades escolares ou quando solicitado, em dia e em ordem', '8', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 1, 'Deixar de cumprir o prescrito nos regulamentos, normas e orientações, ou contribuir para tal', '9', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 1, 'Ocupar-se durante as aulas com qualquer outro trabalho estranho a elas', '10', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 1, 'Ausentar-se das atividades escolares sem autorização', '11', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 1, 'Representar o Colégio ou por ele tomar compromisso, sem estar para isso autorizado', '12', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 1, 'Simular doença para esquivar-se ao atendimento de obrigações e atividades escolares', '13', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 1, 'Causar danos materiais a outro aluno', '14', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 1, 'Ter em seu poder, introduzir, ler ou distribuir, dentro do colégio, cartazes, jornais ou publicações, de cunho político-partidário ou que atentem contra a disciplina ou a moral', '15', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 1, 'Propor ou aceitar transação pecuniária de qualquer natureza, no interior do colégio', '16', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 1, 'Deixar de usar ou usar de maneira irregular, peças de uniforme previstas no RUE/CM ou nas normas vigentes', '17', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 1, 'Deixar de devolver à subunidade, dentro do prazo estipulado, qualquer documento, devidamente assinado pelo pai ou responsável', '18', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 1, 'Utilizar-se do nome do Colégio para fins estranhos aos seus interesses', '19', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 1, 'Divulgar informações inverídicas a respeito do Colégio, seus integrantes ou atividades', '20', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 1, 'Dirigir-se de forma desrespeitosa a qualquer integrante do Colégio', '21', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 1, 'Promover ou participar de algazarra, desordem ou perturbação do ambiente escolar', '22', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 1, 'Portar-se de maneira inconveniente ou ofensiva dentro ou fora do Colégio', '23', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 1, 'Usar linguagem inadequada ao ambiente escolar', '24', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 1, 'Praticar jogos de azar dentro das dependências do Colégio', '25', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 1, 'Adquirir ou vender mercadorias dentro do Colégio, sem autorização', '26', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 1, 'Praticar qualquer forma de discriminação ou assédio', '27', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 1, 'Apresentar comportamento inadequado nas atividades escolares internas ou externas', '28', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 1, 'Desacatar ordens ou instruções de superiores hierárquicos ou professores', '29', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 1, 'Deixar de respeitar as normas de segurança estabelecidas pelo Colégio', '30', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 1, 'Utilizar equipamentos eletrônicos sem autorização em sala de aula ou outras atividades escolares', '31', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 1, 'Portar objetos inadequados ao ambiente escolar, como armas, substâncias ilícitas ou materiais perigosos', '32', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 1, 'Utilizar-se de redes sociais ou outros meios para prejudicar a imagem do Colégio ou de seus integrantes', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 1, 'Difundir ideologias ou fazer propaganda política dentro do ambiente escolar', '34', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 1, 'Divulgar, sem autorização, informações ou documentos internos do Colégio', '35', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 1, 'Ausentar-se sem permissão de eventos ou solenidades obrigatórias', '36', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 1, 'Descumprir qualquer outra norma disciplinar prevista no Regimento Interno do Colégio', '37', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 1, 'Fazer uso de perfis falsos em redes sociais para a difusão de informações.', '38', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 1, 'Divulgar imagens gravadas dentro dos CM sem apreciação e autorização do Comandante.', '39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 1, 'Formar grupos ou promover algazarras, vaias ou distúrbios nas salas de aula ou outras dependências e nas imediações do estabelecimento, bem como perturbar, por qualquer outro modo, o sossego das aulas e a ordem natural.', '40', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 1, 'Participar de movimentos de indisciplina coletiva, impedir a entrada de colegas na sala de aula ou incitá-los a ausências coletivas.', '41', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 1, 'Utilizar material didático copiado total ou parcial, sem a devida autorização dos detentores dos diretos autorais ou da Administração do Colégio. (Sujeito à penalidade da lei).', '42', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 1, 'Utilizar de processos fraudulentos na realização de provas e trabalhos escolares, bem como a adulteração de documentação.', '43', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 1, 'Praticar atos de bullying ou ciberbullying (colocar apelidos pejorativos, xingar, discriminar) ou expor a situações embaraçosas colegas, professores e funcionários.', '44', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 1, 'Realizar gravação de imagem, vídeo ou áudio de outro aluno sem o prévio conhecimento/autorização para tal.', '45', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 1, 'Usar fogos de artifício, bombas ou rojões, sob pena de afastamento automático.', '46', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faults`
--
ALTER TABLE `faults`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faults`
--
ALTER TABLE `faults`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
