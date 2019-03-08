-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2017 at 06:58 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `acadprof_inqdemo`
--

-- --------------------------------------------------------

--
-- Table structure for table `acoes`
--

CREATE TABLE `acoes` (
  `ID` int(255) NOT NULL,
  `NomeAcao` text,
  `DataInicio` date DEFAULT NULL,
  `DataFim` date DEFAULT NULL,
  `Sessoes` int(50) DEFAULT NULL,
  `Info` text,
  `Horario` varchar(1500) NOT NULL,
  `Localidade` varchar(1500) NOT NULL,
  `Morada` varchar(1500) NOT NULL,
  `Formato` varchar(1500) NOT NULL,
  `RefCurso` varchar(1500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Ações que acontecem em referencia aos cursos';

-- --------------------------------------------------------

--
-- Table structure for table `cursos`
--

CREATE TABLE `cursos` (
  `ID` int(50) NOT NULL,
  `CC` varchar(50) DEFAULT NULL,
  `NomeCurso` text,
  `Objectivos` text,
  `Contexto` text,
  `PublicoTarget` text,
  `Info` text,
  `Preco` varchar(100) NOT NULL,
  `Conteudos` varchar(1500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela referente aos cursos a serem criados/usados';

-- --------------------------------------------------------

--
-- Table structure for table `empresa`
--

CREATE TABLE `empresa` (
  `ID` int(100) NOT NULL,
  `NomeEmpresa` text,
  `Morada` text,
  `CodigoPostal` varchar(500) DEFAULT NULL,
  `Localidade` text,
  `NIF` int(15) DEFAULT NULL,
  `PessoaContacto` text,
  `Email` text,
  `Telemovel` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `formandos`
--

CREATE TABLE `formandos` (
  `ID` int(255) NOT NULL,
  `NomeFormando` text NOT NULL,
  `DataNasc` date NOT NULL,
  `Morada` text NOT NULL,
  `CodigoPostal` varchar(50) NOT NULL,
  `Localidade` text NOT NULL,
  `Email` text NOT NULL,
  `Telemovel` int(9) NOT NULL,
  `CartaoCidadao` varchar(50) NOT NULL,
  `Validade` date NOT NULL,
  `nCartaConducao` varchar(50) NOT NULL,
  `LocalEmissao` text NOT NULL,
  `DataEmissao` date NOT NULL,
  `DataValidade` date NOT NULL,
  `Categoria` varchar(25) NOT NULL,
  `NIF` int(20) NOT NULL,
  `DataRenovADR` date NOT NULL,
  `DataRenovCAM` date NOT NULL,
  `AcaoF` varchar(1500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inscricoes`
--

CREATE TABLE `inscricoes` (
  `nInsc` int(255) NOT NULL,
  `Curso` varchar(1500) NOT NULL,
  `Acao` varchar(1500) NOT NULL,
  `Nome` varchar(1500) NOT NULL,
  `Morada` varchar(1500) NOT NULL,
  `NIF` varchar(1500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acoes`
--
ALTER TABLE `acoes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `cursos`
--
ALTER TABLE `cursos`
  ADD UNIQUE KEY `ID` (`ID`,`CC`);

--
-- Indexes for table `empresa`
--
ALTER TABLE `empresa`
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `formandos`
--
ALTER TABLE `formandos`
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `inscricoes`
--
ALTER TABLE `inscricoes`
  ADD PRIMARY KEY (`nInsc`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acoes`
--
ALTER TABLE `acoes`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `cursos`
--
ALTER TABLE `cursos`
  MODIFY `ID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `empresa`
--
ALTER TABLE `empresa`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `formandos`
--
ALTER TABLE `formandos`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `inscricoes`
--
ALTER TABLE `inscricoes`
  MODIFY `nInsc` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
