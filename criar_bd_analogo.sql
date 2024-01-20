-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17-Jul-2023 às 16:25
-- Versão do servidor: 10.4.25-MariaDB
-- versão do PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `analogo`
--
CREATE DATABASE IF NOT EXISTS `analogo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `analogo`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `logocarregada`
--

CREATE TABLE `logocarregada` (
  `id` int(11) NOT NULL,
  `Logo` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `logocarregada`
--

INSERT INTO `logocarregada` (`id`, `Logo`) VALUES
(346, 'Recortadateste10211.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `navegador`
--

CREATE TABLE `navegador` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `tipoUser` int(11) NOT NULL,
  `descricao` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `navegador`
--

INSERT INTO `navegador` (`id`, `name`, `email`, `password`, `tipoUser`, `descricao`) VALUES
(225, 'admin', 'admin@gmail.com', '123', 2, ''),
(228, 'João Emanuel Santos Miranda', 'jmiranda@ipcbcampus.pt', '1234', 1, 'Descrição personalizada feita por mim'),
(246, 'teste2', 'teste@gmail.com', 'qwerty', 1, 'Teste de descrição');

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto`
--

CREATE TABLE `projeto` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `original` tinyint(1) NOT NULL,
  `pixelizado` tinyint(1) NOT NULL,
  `blur` tinyint(1) NOT NULL,
  `favicon` tinyint(1) NOT NULL,
  `tamanho` tinyint(1) NOT NULL,
  `cores_negativas` tinyint(1) NOT NULL,
  `cores_cegas` tinyint(1) NOT NULL,
  `edit_cores` tinyint(1) NOT NULL,
  `cores_usadas` tinyint(1) NOT NULL,
  `cores_predom` tinyint(1) NOT NULL,
  `fatiada` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `projeto`
--

INSERT INTO `projeto` (`id`, `nome`, `original`, `pixelizado`, `blur`, `favicon`, `tamanho`, `cores_negativas`, `cores_cegas`, `edit_cores`, `cores_usadas`, `cores_predom`, `fatiada`) VALUES
(217, 'teste', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(218, 'teste', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(219, 'teste análise', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_factos`
--

CREATE TABLE `tb_factos` (
  `idLogo` int(11) NOT NULL,
  `idNavegador` int(11) NOT NULL,
  `idProjeto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_factos`
--

INSERT INTO `tb_factos` (`idLogo`, `idNavegador`, `idProjeto`) VALUES
(346, 246, 219);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `logocarregada`
--
ALTER TABLE `logocarregada`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `navegador`
--
ALTER TABLE `navegador`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `projeto`
--
ALTER TABLE `projeto`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `logocarregada`
--
ALTER TABLE `logocarregada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=347;

--
-- AUTO_INCREMENT de tabela `navegador`
--
ALTER TABLE `navegador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT de tabela `projeto`
--
ALTER TABLE `projeto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
