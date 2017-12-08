-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 08-Dez-2017 às 01:45
-- Versão do servidor: 5.5.27
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tasks_voxus`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `historicos_auditoria`
--

CREATE TABLE IF NOT EXISTS `historicos_auditoria` (
`id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` int(11) NOT NULL,
  `campo` varchar(255) NOT NULL,
  `anterior` text,
  `novo` text,
  `usuario_id` int(11) DEFAULT NULL,
  `criado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `phinxlog`
--

CREATE TABLE IF NOT EXISTS `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `phinxlog`
--

INSERT INTO `phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20171207171555, 'CriarTabelaUsuarios', '2017-12-07 21:23:35', '2017-12-07 21:23:35', 0),
(20171207171600, 'CriarTabelaHistoricosAuditoria', '2017-12-07 21:23:35', '2017-12-07 21:23:35', 0),
(20171207171608, 'CriarTabelaTasks', '2017-12-07 21:23:35', '2017-12-07 21:23:35', 0),
(20171207195240, 'CriarTabelaTasksArquivos', '2017-12-07 22:26:47', '2017-12-07 22:26:47', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
`id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `prioridade` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `concluida` tinyint(1) NOT NULL,
  `usuario_concluido_id` int(11) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `criado` datetime NOT NULL,
  `modificado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tasks_arquivos`
--

CREATE TABLE IF NOT EXISTS `tasks_arquivos` (
`id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `arquivo` varchar(255) NOT NULL,
  `nome_original` varchar(255) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `criado` datetime NOT NULL,
  `modificado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
`id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `administrador` tinyint(1) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `criado` datetime NOT NULL,
  `modificado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_login`
--

CREATE TABLE IF NOT EXISTS `usuarios_login` (
`id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `historicos_auditoria`
--
ALTER TABLE `historicos_auditoria`
 ADD PRIMARY KEY (`id`), ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `phinxlog`
--
ALTER TABLE `phinxlog`
 ADD PRIMARY KEY (`version`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
 ADD PRIMARY KEY (`id`), ADD KEY `usuario_id` (`usuario_id`), ADD KEY `usuario_concluido_id` (`usuario_concluido_id`);

--
-- Indexes for table `tasks_arquivos`
--
ALTER TABLE `tasks_arquivos`
 ADD PRIMARY KEY (`id`), ADD KEY `task_id` (`task_id`), ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios_login`
--
ALTER TABLE `usuarios_login`
 ADD PRIMARY KEY (`id`), ADD KEY `usuario_id` (`usuario_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `historicos_auditoria`
--
ALTER TABLE `historicos_auditoria`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tasks_arquivos`
--
ALTER TABLE `tasks_arquivos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuarios_login`
--
ALTER TABLE `usuarios_login`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `historicos_auditoria`
--
ALTER TABLE `historicos_auditoria`
ADD CONSTRAINT `historicos_auditoria_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `tasks`
--
ALTER TABLE `tasks`
ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`usuario_concluido_id`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `tasks_arquivos`
--
ALTER TABLE `tasks_arquivos`
ADD CONSTRAINT `tasks_arquivos_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`),
ADD CONSTRAINT `tasks_arquivos_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `usuarios_login`
--
ALTER TABLE `usuarios_login`
ADD CONSTRAINT `usuarios_login_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
