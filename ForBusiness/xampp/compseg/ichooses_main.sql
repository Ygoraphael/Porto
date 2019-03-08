-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Máquina: 127.0.0.1
-- Data de Criação: 02-Out-2017 às 18:11
-- Versão do servidor: 5.6.11
-- versão do PHP: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `ichooses_main`
--
CREATE DATABASE IF NOT EXISTS `ichooses_main` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ichooses_main`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `idCompany` int(11) NOT NULL AUTO_INCREMENT,
  `data_base` varchar(50) DEFAULT NULL,
  `license` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted` int(11) DEFAULT '0',
  `nif` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `zipcode` varchar(50) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `language` int(11) NOT NULL,
  PRIMARY KEY (`idCompany`),
  KEY `FK_Company_License` (`license`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=297 ;

--
-- Extraindo dados da tabela `company`
--

INSERT INTO `company` (`idCompany`, `data_base`, `license`, `status`, `created_at`, `deleted_at`, `deleted`, `nif`, `phone`, `address`, `zipcode`, `location`, `country`, `language`) VALUES
(290, 'ichooses_emp1', 332, 0, '2017-10-02 10:43:45', NULL, 0, '123456789', '220000000', 'Rua Dummy', '4000', 'Porto', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `idLanguage` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(10) NOT NULL,
  `text` varchar(60) NOT NULL,
  PRIMARY KEY (`idLanguage`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `language`
--

INSERT INTO `language` (`idLanguage`, `lang`, `text`) VALUES
(1, 'pt', 'Portuguese (Portugal)'),
(2, 'en-us', 'English (United States)');

-- --------------------------------------------------------

--
-- Estrutura da tabela `license`
--

CREATE TABLE IF NOT EXISTS `license` (
  `idLicense` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `users_license` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted` int(11) DEFAULT '0',
  PRIMARY KEY (`idLicense`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=339 ;

--
-- Extraindo dados da tabela `license`
--

INSERT INTO `license` (`idLicense`, `code`, `status`, `users_license`, `created_at`, `deleted_at`, `deleted`) VALUES
(332, 'ics1', 1, 50, '2017-10-02 10:43:45', NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `idMenu` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `page` int(11) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `translate` int(11) NOT NULL DEFAULT '1',
  `ord` int(11) NOT NULL DEFAULT '0',
  `level_min` int(11) NOT NULL DEFAULT '0',
  `level_max` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idMenu`),
  UNIQUE KEY `order` (`ord`),
  KEY `FK_Menu_Page` (`page`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Extraindo dados da tabela `menu`
--

INSERT INTO `menu` (`idMenu`, `name`, `page`, `icon`, `parent`, `status`, `translate`, `ord`, `level_min`, `level_max`) VALUES
(1, 'Home', 4, 'icon-home3', 0, 0, 1, 0, 0, 0),
(2, 'Users', 5, 'icon-users', 0, 1, 1, 2, 1, 3),
(3, 'Companies', 3, 'icon-office', 0, 1, 1, 1, 1, 1),
(11, 'Surveys', 7, 'icon-map22', 0, 0, 1, 4, 0, 0),
(12, 'Insecurities', 8, 'icon-bullhorn', 0, 0, 1, 5, 0, 0),
(14, 'Logout', 9, 'icon-switch', 0, 0, 1, 10, 0, 0),
(18, 'Dialogues', 11, 'icon-bubbles2', 0, 0, 1, 6, 1, 1),
(24, 'Safety Walks', 15, 'icon-truck', 0, 0, 1, 7, 1, 1),
(29, 'Settings', 18, 'icon-cog', 0, 1, 1, 13, 2, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `idNotification` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `table1` varchar(50) DEFAULT NULL,
  `value1` int(11) DEFAULT NULL,
  `table2` varchar(50) DEFAULT NULL,
  `value2` int(11) DEFAULT NULL,
  `date_limit` datetime NOT NULL,
  `title` longtext NOT NULL,
  `description` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`idNotification`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `idPage` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `permission` int(11) NOT NULL,
  `level_min` int(11) NOT NULL,
  `level_max` int(11) NOT NULL,
  PRIMARY KEY (`idPage`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Extraindo dados da tabela `page`
--

INSERT INTO `page` (`idPage`, `title`, `link`, `status`, `parent`, `permission`, `level_min`, `level_max`) VALUES
(3, 'companies', '/panel/companys', 1, 0, 1, 1, 1),
(4, 'panel', '/panel', 1, 0, 1, 1, 3),
(5, 'users', '/panel/users', 1, 0, 1, 1, 2),
(7, 'surveys', '/panel/surveys', 1, 0, 1, 2, 3),
(8, 'insecurities', '/panel/insecuritys', 1, 0, 1, 2, 3),
(9, 'logout', '/logout', 1, 0, 1, 0, 0),
(10, 'surveys answer', '/survey/answer', 1, 0, 1, 2, 3),
(11, 'security dialogue', '/panel/securitydialogs', 1, 0, 1, 2, 3),
(12, 'factories', '/panel/factory', 1, 0, 1, 2, 2),
(14, 'sector', '/panel/sector', 1, 0, 1, 2, 2),
(15, 'safety walks', '/panel/safetywalks', 1, 0, 1, 2, 3),
(16, 'profiles', '/panel/profile', 1, 0, 1, 2, 2),
(17, 'categories', '/panel/category', 1, 0, 1, 2, 2),
(18, 'settings', '/panel/settings', 1, 0, 1, 2, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `idPermission` int(11) NOT NULL AUTO_INCREMENT,
  `page` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `permission_group` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `action` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPermission`),
  KEY `FK_Permission_User` (`user`),
  KEY `FK_Permission_Page` (`page`),
  KEY `FK_Permission_PermissionGroup` (`permission_group`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=580 ;

--
-- Extraindo dados da tabela `permission`
--

INSERT INTO `permission` (`idPermission`, `page`, `user`, `permission_group`, `status`, `action`, `created_at`, `deleted_at`, `deleted`) VALUES
(27, 3, 11, 3, 1, 0, NULL, NULL, NULL),
(31, 5, 11, 3, 1, 0, NULL, NULL, NULL),
(55, 4, 11, NULL, 1, 1, '2017-07-27 02:19:09', NULL, 0),
(484, 4, 452, NULL, 1, 1, '2017-10-02 10:43:46', NULL, 0),
(485, 5, 452, NULL, 1, 1, '2017-10-02 10:43:46', NULL, 0),
(486, 7, 452, NULL, 1, 1, '2017-10-02 10:43:46', NULL, 0),
(487, 8, 452, NULL, 1, 1, '2017-10-02 10:43:46', NULL, 0),
(488, 10, 452, NULL, 1, 1, '2017-10-02 10:43:46', NULL, 0),
(489, 11, 452, NULL, 1, 1, '2017-10-02 10:43:46', NULL, 0),
(490, 12, 452, NULL, 1, 1, '2017-10-02 10:43:46', NULL, 0),
(491, 14, 452, NULL, 1, 1, '2017-10-02 10:43:46', NULL, 0),
(492, 15, 452, NULL, 1, 1, '2017-10-02 10:43:46', NULL, 0),
(493, 16, 452, NULL, 1, 1, '2017-10-02 10:43:46', NULL, 0),
(494, 17, 452, NULL, 1, 1, '2017-10-02 10:43:46', NULL, 0),
(495, 18, 452, NULL, 1, 1, '2017-10-02 10:43:46', NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissiongroup`
--

CREATE TABLE IF NOT EXISTS `permissiongroup` (
  `idPermissionGroup` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `user_type` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`idPermissionGroup`),
  KEY `FK_PermissionGroup_UserType` (`user_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `permissiongroup`
--

INSERT INTO `permissiongroup` (`idPermissionGroup`, `name`, `user_type`, `status`) VALUES
(2, 'Default', 3, 1),
(3, 'Default', 1, 1),
(4, 'Default', 2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `translate`
--

CREATE TABLE IF NOT EXISTS `translate` (
  `idTranslate` int(11) NOT NULL AUTO_INCREMENT,
  `text_default` varchar(50) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `text` varchar(50) NOT NULL,
  PRIMARY KEY (`idTranslate`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=144 ;

--
-- Extraindo dados da tabela `translate`
--

INSERT INTO `translate` (`idTranslate`, `text_default`, `lang`, `text`) VALUES
(1, 'Home', 'pt', 'Início'),
(2, 'Users', 'pt', 'Utilizadores'),
(3, 'Companies', 'pt', 'Empresas'),
(4, 'Surveys', 'pt', 'Observações'),
(5, 'Insecurities', 'pt', 'Inseguranças'),
(6, 'Logout', 'pt', 'Logout'),
(7, 'Login', 'pt', 'Login'),
(8, 'Dialogues', 'pt', 'Diálogos'),
(9, 'Factory', 'pt', 'Fábrica'),
(10, 'Sector', 'pt', 'Local'),
(11, 'Notifications', 'pt', 'Notificações'),
(12, 'Read All Notifications', 'pt', 'Ler Todas as Notificações'),
(13, 'No Notifications', 'pt', 'Sem Notificações'),
(14, 'Categories', 'pt', 'Categorias'),
(15, 'Profiles', 'pt', 'Perfis'),
(16, 'Safety Walks', 'pt', 'Safety Walks'),
(17, 'Factories', 'pt', 'Fábricas'),
(18, 'Sectors', 'pt', 'Locais'),
(19, 'Surveys Answered', 'pt', 'Observações Respondidas'),
(20, 'Code', 'pt', 'Código'),
(21, 'First name', 'pt', 'Primeiro Nome'),
(22, 'Last name', 'pt', 'Último Nome'),
(23, 'Action', 'pt', 'Ação'),
(24, 'New User', 'pt', 'Novo Utilizador'),
(25, 'Personal Info', 'pt', 'Dados Pessoais'),
(26, 'Company', 'pt', 'Empresa'),
(27, 'Name', 'pt', 'Nome'),
(28, 'Surname', 'pt', 'Apelido'),
(29, 'Email', 'pt', 'Email'),
(30, 'User Type', 'pt', 'Tipo de Utilizador'),
(32, 'Select Factory', 'pt', 'Selecione a fábrica'),
(33, 'Select Type', 'pt', 'Selecione o tipo'),
(35, 'Select Profile', 'pt', 'Selecione o perfil'),
(36, 'System', 'pt', 'Sistema'),
(37, 'Active', 'pt', 'Ativo'),
(38, 'Suspended', 'pt', 'Suspenso'),
(39, 'Completed', 'pt', 'Concluído'),
(40, 'Waiting', 'pt', 'Aguardando'),
(41, 'Assigned', 'pt', 'Atribuído'),
(42, 'Undefined', 'pt', 'Indefinido'),
(43, 'Opened', 'pt', 'Em aberto'),
(44, 'Delayed', 'pt', 'Atrasado'),
(45, 'Cancel', 'pt', 'Cancelar'),
(46, 'Save', 'pt', 'Guardar'),
(47, 'Surveys Answer', 'pt', 'Responder a Observações'),
(48, 'New Survey', 'pt', 'Nova Observação'),
(49, 'Search', 'pt', 'Pesquisar'),
(50, 'All Replies', 'pt', 'Todas as Respostas'),
(51, 'Reply to surveys', 'pt', 'Responder a Observações'),
(52, 'Start Date', 'pt', 'Data Início'),
(53, 'End Date', 'pt', 'Data Fim'),
(54, 'Periodicity', 'pt', 'Periodicidade'),
(55, 'Created At', 'pt', 'Criado Em'),
(56, 'User', 'pt', 'Utilizador'),
(57, 'Answered At', 'pt', 'Respondido em'),
(58, 'Limit Date', 'pt', 'Data Limite'),
(59, 'Select an User', 'pt', 'Selecione um Utilizador'),
(60, 'Expired', 'pt', 'Expirado'),
(61, 'Select a Status', 'pt', 'Selecione um Estado'),
(62, 'All', 'pt', 'Todos'),
(63, 'Attribution', 'pt', 'Atribuição'),
(64, 'Resume', 'pt', 'Resumo'),
(65, 'New Insecurity', 'pt', 'Nova Insegurança'),
(66, 'Survey', 'pt', 'Observação'),
(67, 'Notification', 'pt', 'Notificação'),
(68, 'Profile', 'pt', 'Perfil'),
(69, 'New Profile', 'pt', 'Novo Perfil'),
(70, 'Dialogues for Reply', 'pt', 'Diálogos por Responder'),
(71, 'Dialogues Rules', 'pt', 'Regras Diálogos'),
(72, 'New Dialogue', 'pt', 'Novo Diálogo'),
(73, 'Theme', 'pt', 'Tema'),
(74, 'Surveys to Answer', 'pt', 'Observações por Responder'),
(75, 'Factory Direction', 'pt', 'Direção de Fábrica'),
(76, 'Direction', 'pt', 'Direção'),
(77, 'Boss', 'pt', 'Chefia'),
(78, 'Operational', 'pt', 'Operacional'),
(79, 'Security Direction', 'pt', 'Direção de Segurança'),
(80, 'Edit User', 'pt', 'Editar Utilizador'),
(81, 'Responsible', 'pt', 'Responsável'),
(82, 'Date', 'pt', 'Data'),
(83, 'Hour', 'pt', 'Hora'),
(84, 'Who Accompanied', 'pt', 'Quem Acompanhou'),
(85, 'Tasks Observed', 'pt', 'Tarefa(s) Observada(s)'),
(86, 'Image', 'pt', 'Imagem'),
(87, 'Insecurity', 'pt', 'Insegurança'),
(88, 'Description', 'pt', 'Descrição'),
(89, 'Status', 'pt', 'Estado'),
(90, 'Permissions', 'pt', 'Permissões'),
(91, 'Yes', 'pt', 'Sim'),
(92, 'No', 'pt', 'Não'),
(93, 'Select Sector', 'pt', 'Selecione o Local'),
(94, 'Assign Insecurity', 'pt', 'Atribuir Insegurança'),
(95, 'Close Insecurity', 'pt', 'Fechar Insegurança'),
(96, 'Mark as resolved', 'pt', 'Marcar como resolvido'),
(97, 'Text', 'pt', 'Texto'),
(98, 'Presence', 'pt', 'Presenças'),
(99, 'Settings', 'pt', 'Definições'),
(100, 'Leader', 'pt', 'Líder'),
(101, 'Week', 'pt', 'Semana'),
(102, 'Year', 'pt', 'Ano'),
(103, 'Change Year', 'pt', 'Mudar Ano'),
(104, 'There are no dialogues to respond', 'pt', 'Não existem diálogos para responder'),
(105, 'No surveys to answer', 'pt', 'Não existem observações para responder'),
(106, 'No Profiles', 'pt', 'Sem Perfis'),
(107, 'Basic Info', 'pt', 'Informações Básicas'),
(108, 'There are no safety walks', 'pt', 'Não existem safety walks'),
(109, 'New Safety Walk', 'pt', 'Nova Safety Walk'),
(110, 'Reply to Safety Walks', 'pt', 'Responder a Safety Walks'),
(111, 'Safety Walk for Respond', 'pt', 'Safety Walk por Responder'),
(112, 'There are no safety walk to respond', 'pt', 'Não existem safety walk para responder'),
(113, 'New Sector', 'pt', 'Novo Local'),
(114, 'License', 'pt', 'Licença'),
(115, 'Database', 'pt', 'Base de Dados'),
(116, 'No Results', 'pt', 'Sem Resultados'),
(117, 'No registered users', 'pt', 'Não há utilizadores registados'),
(118, 'No One', 'pt', 'Ninguém'),
(119, 'Quantity Monitor', 'pt', 'Monitor de Quantidade'),
(120, 'Quality Monitor', 'pt', 'Monitor de Qualidade'),
(121, 'Last Month', 'pt', 'Último Mês'),
(122, 'Last 3 Month', 'pt', 'Últimos 3 Meses'),
(123, 'Predicted Next Month', 'pt', 'Previsto Mês Seguinte'),
(124, 'Survey to Answer', 'pt', 'Observação por responder'),
(125, 'Reply to Survey Until', 'pt', 'Responder a Observação até'),
(126, 'Reply to Dialogue Until', 'pt', 'Responder a Diálogo até'),
(127, 'Dialogue to Answer', 'pt', 'Diálogo por responder'),
(128, 'Reply to Safety Walk Until', 'pt', 'Responder a Safety Walk até'),
(129, 'Safety Walk to Answer', 'pt', 'Diálogo por responder'),
(130, 'January', 'pt', 'Janeiro'),
(131, 'February', 'pt', 'Fevereiro'),
(132, 'March', 'pt', 'Março'),
(133, 'April', 'pt', 'Abril'),
(134, 'May', 'pt', 'Maio'),
(135, 'June', 'pt', 'Junho'),
(136, 'July', 'pt', 'Julho'),
(137, 'August', 'pt', 'Agosto'),
(138, 'September', 'pt', 'Setembro'),
(139, 'October', 'pt', 'Outubro'),
(140, 'November', 'pt', 'Novembro'),
(141, 'December', 'pt', 'Dezembro'),
(142, 'Forget Password', 'pt', 'Esqueceu a Senha'),
(143, 'Remember Me', 'pt', 'Lembrar-me');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `user_type` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `hash` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted` int(11) DEFAULT '0',
  `loged` varchar(50) DEFAULT NULL,
  `profile` int(11) NOT NULL,
  `factory` int(11) DEFAULT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `email` (`email`),
  KEY `FK_User_UserType` (`user_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=461 ;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`idUser`, `email`, `code`, `password`, `name`, `last_name`, `user_type`, `status`, `hash`, `created_at`, `deleted_at`, `deleted`, `loged`, `profile`, `factory`) VALUES
(11, 'lfeiteira@ltm.pt', '1500289179', '14e5bf841c74303fd45788895b7968fb', 'Ludgero', 'Feiteira', 1, 1, '70ca868e8d9ead08be7c695618dd369069cab597be77f162d7d8184672673e4ac764144a3e42e2dde34e647eddb8d0154f862a65af3dfa078bc3b6244d7ce7bf', '2017-07-17 11:59:43', NULL, 0, '', 0, 0),
(452, 'admin@dummy.com', '1506937426', '14e5bf841c74303fd45788895b7968fb', 'Super', 'Admin', 2, 1, '6fe7644517b582cb264022b09f2187d49ff5a6d44a3daf29eec9129a5ed6107c85b5d44d54caf0f013ec01af59f84626cff5bc8873983be78deba4c783d2118e', '2017-10-02 10:43:46', NULL, 0, '', 2, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `userlicense`
--

CREATE TABLE IF NOT EXISTS `userlicense` (
  `idUserLicense` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted` int(11) DEFAULT '0',
  PRIMARY KEY (`idUserLicense`),
  KEY `FK_UserLicense_User` (`user`),
  KEY `FK_UserLicense_Company` (`company`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

--
-- Extraindo dados da tabela `userlicense`
--

INSERT INTO `userlicense` (`idUserLicense`, `user`, `status`, `company`, `created_at`, `deleted_at`, `deleted`) VALUES
(70, 452, 1, 290, '2017-10-02 10:43:46', NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usertype`
--

CREATE TABLE IF NOT EXISTS `usertype` (
  `idUserType` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted` int(11) DEFAULT '0',
  PRIMARY KEY (`idUserType`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `usertype`
--

INSERT INTO `usertype` (`idUserType`, `level`, `name`, `created_at`, `deleted_at`, `deleted`) VALUES
(1, 1, 'Master', NULL, NULL, 0),
(2, 2, 'Empresa', NULL, NULL, 0),
(3, 3, 'Fabrica', NULL, NULL, 0),
(4, 0, 'Visitante', NULL, NULL, 0);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `FK_Company_License` FOREIGN KEY (`license`) REFERENCES `license` (`idLicense`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `FK_Menu_Page` FOREIGN KEY (`page`) REFERENCES `page` (`idPage`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `permission`
--
ALTER TABLE `permission`
  ADD CONSTRAINT `FK_Permission_Page` FOREIGN KEY (`page`) REFERENCES `page` (`idPage`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Permission_PermissionGroup` FOREIGN KEY (`permission_group`) REFERENCES `permissiongroup` (`idPermissionGroup`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Permission_User` FOREIGN KEY (`user`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `permissiongroup`
--
ALTER TABLE `permissiongroup`
  ADD CONSTRAINT `FK_PermissionGroup_UserType` FOREIGN KEY (`user_type`) REFERENCES `usertype` (`idUserType`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_User_UserType` FOREIGN KEY (`user_type`) REFERENCES `usertype` (`idUserType`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `userlicense`
--
ALTER TABLE `userlicense`
  ADD CONSTRAINT `FK_UserLicense_Company` FOREIGN KEY (`company`) REFERENCES `company` (`idCompany`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_UserLicense_User` FOREIGN KEY (`user`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
