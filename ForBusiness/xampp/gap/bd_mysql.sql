-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 13-Jun-2017 às 11:54
-- Versão do servidor: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `taskas`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `calendar`
--

CREATE TABLE IF NOT EXISTS `calendar` (
`id` int(11) NOT NULL,
  `utilizador` int(11) NOT NULL,
  `titulo` varchar(25) NOT NULL,
  `corpo` text NOT NULL,
  `data_inicio` varchar(10) NOT NULL,
  `data_fim` varchar(10) NOT NULL,
  `criacao_utilizador` int(11) NOT NULL,
  `cor` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) CHARACTER SET latin1 NOT NULL,
  `email` varchar(254) NOT NULL,
  `morada` varchar(255) NOT NULL,
  `localidade` varchar(50) NOT NULL,
  `codpostal` varchar(50) NOT NULL,
  `telefone` varchar(25) NOT NULL,
  `fax` varchar(25) NOT NULL,
  `telemovel` varchar(50) NOT NULL,
  `contribuinte` varchar(50) NOT NULL,
  `saldo` varchar(50) NOT NULL,
  `obs` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contrato`
--

CREATE TABLE IF NOT EXISTS `contrato` (
`id` int(11) NOT NULL,
  `cliente` int(11) NOT NULL,
  `tempo_contratado` varchar(10) NOT NULL,
  `tempo_restante` varchar(10) NOT NULL,
  `contrato_inicio` varchar(10) NOT NULL,
  `contrato_fim` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `dic_node`
--

CREATE TABLE IF NOT EXISTS `dic_node` (
`id` int(11) NOT NULL,
  `id_parent` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `syntax` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=171 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `dic_parent`
--

CREATE TABLE IF NOT EXISTS `dic_parent` (
`id` int(11) NOT NULL,
  `nome` varchar(55) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `dic_subparent`
--

CREATE TABLE IF NOT EXISTS `dic_subparent` (
`id` int(11) NOT NULL,
  `id_parent` int(11) NOT NULL,
  `nome` varchar(55) NOT NULL,
  `desc` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `log`
--

CREATE TABLE IF NOT EXISTS `log` (
`id` int(11) NOT NULL,
  `msg` text NOT NULL,
  `datetime` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagem`
--

CREATE TABLE IF NOT EXISTS `mensagem` (
`id` int(11) NOT NULL,
  `assunto` varchar(200) NOT NULL,
  `corpo` text NOT NULL,
  `remetente` int(11) NOT NULL,
  `destinatario` int(11) NOT NULL,
  `datahora` varchar(10) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `movimento`
--

CREATE TABLE IF NOT EXISTS `movimento` (
`id` int(11) NOT NULL,
  `utilizador` varchar(50) CHARACTER SET latin1 NOT NULL,
  `cliente` varchar(50) CHARACTER SET latin1 NOT NULL,
  `tarefa` varchar(50) CHARACTER SET latin1 NOT NULL,
  `data_i` varchar(10) CHARACTER SET latin1 NOT NULL,
  `data_f` varchar(10) CHARACTER SET latin1 NOT NULL,
  `contador` varchar(10) CHARACTER SET latin1 NOT NULL,
  `relatorio` text CHARACTER SET latin1 NOT NULL,
  `mail_sent` int(1) NOT NULL DEFAULT '0',
  `conta_cat` varchar(1) NOT NULL,
  `id_projecto` int(11) NOT NULL,
  `data_pedido` varchar(10) CHARACTER SET latin1 NOT NULL,
  `quem_pediu` varchar(55) NOT NULL,
  `tipo_faturacao` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2694 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `perms`
--

CREATE TABLE IF NOT EXISTS `perms` (
  `utilizador` int(11) NOT NULL,
  `admin` int(1) NOT NULL,
  `god` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `perms`
--

INSERT INTO `perms` (`utilizador`, `admin`, `god`) VALUES
(2, 1, 1),
(5, 1, 1),
(7, 1, 1),
(8, 1, 0),
(9, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `projecto`
--

CREATE TABLE IF NOT EXISTS `projecto` (
`id` int(11) NOT NULL,
  `referencia` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `cliente` int(11) NOT NULL,
  `data_inicio` varchar(10) NOT NULL,
  `horas_previstas` varchar(10) NOT NULL,
  `horas_reais` varchar(15) NOT NULL,
  `data_fim` varchar(10) NOT NULL,
  `fechado` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tarefa`
--

CREATE TABLE IF NOT EXISTS `tarefa` (
  `id` varchar(50) CHARACTER SET latin1 NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tmp_mov`
--

CREATE TABLE IF NOT EXISTS `tmp_mov` (
`id` int(11) NOT NULL,
  `username` varchar(55) CHARACTER SET latin1 NOT NULL,
  `cliente` int(11) NOT NULL,
  `tarefa` varchar(50) CHARACTER SET latin1 NOT NULL,
  `data_i` varchar(10) CHARACTER SET latin1 NOT NULL,
  `data` varchar(10) CHARACTER SET latin1 NOT NULL,
  `contador` varchar(10) CHARACTER SET latin1 NOT NULL,
  `activo` int(1) NOT NULL,
  `id_projecto` varchar(55) NOT NULL,
  `data_pedido` varchar(10) NOT NULL,
  `quem_pediu` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4879 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `todo_list`
--

CREATE TABLE IF NOT EXISTS `todo_list` (
`id` int(11) NOT NULL,
  `username` varchar(50) CHARACTER SET latin1 NOT NULL,
  `data` varchar(10) CHARACTER SET latin1 NOT NULL,
  `texto` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=104 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `todo_tasks`
--

CREATE TABLE IF NOT EXISTS `todo_tasks` (
`id` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `problem` text NOT NULL,
  `level` int(11) NOT NULL,
  `date_time` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `username` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `nicename` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `email` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `password` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `utilizador_id` int(11) NOT NULL,
  `cor` varchar(9) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(64) COLLATE utf8_unicode_ci NOT NULL,
  `salt` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nicename` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `tecnico` int(11) NOT NULL,
  `completeName` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizador`
--

CREATE TABLE IF NOT EXISTS `utilizador` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contrato`
--
ALTER TABLE `contrato`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dic_node`
--
ALTER TABLE `dic_node`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dic_parent`
--
ALTER TABLE `dic_parent`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dic_subparent`
--
ALTER TABLE `dic_subparent`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mensagem`
--
ALTER TABLE `mensagem`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movimento`
--
ALTER TABLE `movimento`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `perms`
--
ALTER TABLE `perms`
 ADD PRIMARY KEY (`utilizador`);

--
-- Indexes for table `projecto`
--
ALTER TABLE `projecto`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tarefa`
--
ALTER TABLE `tarefa`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_mov`
--
ALTER TABLE `tmp_mov`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `todo_list`
--
ALTER TABLE `todo_list`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `todo_tasks`
--
ALTER TABLE `todo_tasks`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `user_n` (`username`), ADD UNIQUE KEY `user_e` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`), ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `utilizador`
--
ALTER TABLE `utilizador`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calendar`
--
ALTER TABLE `calendar`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `contrato`
--
ALTER TABLE `contrato`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `dic_node`
--
ALTER TABLE `dic_node`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=171;
--
-- AUTO_INCREMENT for table `dic_parent`
--
ALTER TABLE `dic_parent`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `dic_subparent`
--
ALTER TABLE `dic_subparent`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `mensagem`
--
ALTER TABLE `mensagem`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `movimento`
--
ALTER TABLE `movimento`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2694;
--
-- AUTO_INCREMENT for table `projecto`
--
ALTER TABLE `projecto`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `tmp_mov`
--
ALTER TABLE `tmp_mov`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4879;
--
-- AUTO_INCREMENT for table `todo_list`
--
ALTER TABLE `todo_list`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=104;
--
-- AUTO_INCREMENT for table `todo_tasks`
--
ALTER TABLE `todo_tasks`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=151;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
