#App sql generated on: 2010-11-26 01:22:02 : 1290741722

DROP TABLE IF EXISTS `drg_acos`;
DROP TABLE IF EXISTS `drg_agendamentos`;
DROP TABLE IF EXISTS `drg_aros`;
DROP TABLE IF EXISTS `drg_aros_acos`;
DROP TABLE IF EXISTS `drg_destinos`;
DROP TABLE IF EXISTS `drg_fontes`;
DROP TABLE IF EXISTS `drg_frequencias`;
DROP TABLE IF EXISTS `drg_ganhos`;
DROP TABLE IF EXISTS `drg_gastos`;
DROP TABLE IF EXISTS `drg_sugestos`;
DROP TABLE IF EXISTS `drg_usuarios`;


CREATE TABLE `drg_acos` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`parent_id` int(10) DEFAULT NULL,
	`model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`foreign_key` int(10) DEFAULT NULL,
	`alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`lft` int(10) DEFAULT NULL,
	`rght` int(10) DEFAULT NULL,	PRIMARY KEY  (`id`))	;

CREATE TABLE `drg_agendamentos` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`usuario_id` int(11) DEFAULT NULL,
	`model` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`frequencia_id` int(11) DEFAULT NULL,
	`fonte_id` int(11) DEFAULT NULL,
	`destino_id` int(11) DEFAULT NULL,
	`valor` float DEFAULT NULL,
	`datadevencimento` date DEFAULT NULL,
	`numdeparcelas` int(2) DEFAULT NULL,
	`observacoes` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,
	`status` tinyint(1) DEFAULT 1,	PRIMARY KEY  (`id`),
	KEY `frequencia_id` (`frequencia_id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `drg_aros` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`parent_id` int(10) DEFAULT NULL,
	`model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`foreign_key` int(10) DEFAULT NULL,
	`alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`lft` int(10) DEFAULT NULL,
	`rght` int(10) DEFAULT NULL,	PRIMARY KEY  (`id`))	;

CREATE TABLE `drg_aros_acos` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`aro_id` int(10) NOT NULL,
	`aco_id` int(10) NOT NULL,
	`_create` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '0' NOT NULL,
	`_read` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '0' NOT NULL,
	`_update` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '0' NOT NULL,
	`_delete` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '0' NOT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `ARO_ACO_KEY` (`aro_id`, `aco_id`))	;

CREATE TABLE `drg_destinos` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`usuario_id` int(11) DEFAULT NULL,
	`nome` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,
	`status` tinyint(1) DEFAULT 1,	PRIMARY KEY  (`id`),
	KEY `usuario_id` (`usuario_id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `drg_fontes` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`usuario_id` int(11) DEFAULT NULL,
	`nome` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,
	`status` tinyint(1) DEFAULT 1,	PRIMARY KEY  (`id`),
	KEY `usuario_id` (`usuario_id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `drg_frequencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE `drg_ganhos` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`usuario_id` int(11) DEFAULT NULL,
	`agendamento_id` int(11) DEFAULT NULL,
	`fonte_id` int(11) DEFAULT NULL,
	`valor` float DEFAULT NULL,
	`datadabaixa` date DEFAULT NULL,
	`datadevencimento` date DEFAULT NULL,
	`observacoes` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,
	`status` tinyint(1) DEFAULT 1,	PRIMARY KEY  (`id`),
	KEY `fonte_id` (`fonte_id`),
	KEY `agendamento_id` (`agendamento_id`),
	KEY `usuario_id` (`usuario_id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `drg_gastos` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`usuario_id` int(11) DEFAULT NULL,
	`agendamento_id` int(11) DEFAULT NULL,
	`destino_id` int(11) DEFAULT NULL,
	`valor` float DEFAULT NULL,
	`datadabaixa` date DEFAULT NULL,
	`datadevencimento` date DEFAULT NULL,
	`observacoes` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,
	`status` tinyint(1) DEFAULT 1,	PRIMARY KEY  (`id`),
	KEY `destino_id` (`destino_id`),
	KEY `agendamento_id` (`agendamento_id`),
	KEY `usuario_id` (`usuario_id`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `drg_sugestos` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`usuario_id` int(11) DEFAULT NULL,
	`titulo` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`texto` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`status` tinyint(1) DEFAULT 1,	PRIMARY KEY  (`id`),
	KEY `status` (`status`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=MyISAM;

CREATE TABLE `drg_usuarios` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`nome` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`email` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`login` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`password` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`foto` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`ultimologin` datetime DEFAULT NULL,
	`numdeacessos` int(11) DEFAULT NULL,
	`hash` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,
	`status` tinyint(1) DEFAULT 1,	PRIMARY KEY  (`id`),
	UNIQUE KEY `login` (`login`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=MyISAM;


INSERT INTO `drg_acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'root', 1, 22),
(2, 1, NULL, NULL, 'users', 2, 17),
(3, 1, NULL, NULL, 'admin', 18, 21),
(4, 2, 'Usuario', NULL, 'usuario', 3, 4),
(5, 2, 'Ganho', NULL, 'ganho', 5, 6),
(6, 2, 'Gasto', NULL, 'gasto', 7, 8),
(7, 2, 'Destino', NULL, 'destino', 9, 10),
(8, 2, 'Fonte', NULL, 'fonte', 11, 12),
(9, 2, 'Agendamento', NULL, 'agendamento', 13, 14),
(10, 2, 'Sugestao', NULL, 'sugestao', 15, 16),
(11, 3, 'Frequencia', NULL, 'frequencia', 19, 20);


INSERT INTO `drg_aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'root', 1, 4),
(2, NULL, NULL, NULL, 'users', 5, 10),
(3, NULL, NULL, NULL, 'admin', 11, 12),
(4, 2, 'Usuario', 1, NULL, 6, 7),
(5, 2, 'Usuario', 2, NULL, 8, 9),
(6, 1, 'Usuario', 3, NULL, 2, 3);



INSERT INTO `drg_aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 1, 1, '1', '1', '1', '1'),
(2, 3, 3, '1', '1', '1', '1'),
(3, 2, 2, '1', '1', '1', '1');



INSERT INTO `drg_frequencias` (`id`, `nome`, `created`, `modified`, `status`) VALUES
(1, 'Semanal', '2010-08-29 00:06:07', '2010-08-29 00:06:07', 0),
(2, 'Quinzenal', '2010-08-29 00:06:16', '2010-10-29 22:58:23', 0),
(3, '1 mês', '2010-08-29 00:06:27', '2010-11-17 12:10:40', 1),
(4, '2 mêses', '2010-08-29 00:06:35', '2010-11-17 12:10:48', 1),
(5, '3 mêses', '2010-08-29 00:06:41', '2010-11-17 12:10:58', 1),
(8, '4 mêses', '2010-11-17 12:11:40', '2010-11-17 12:16:44', 1),
(6, '6 mêses', '2010-08-29 00:06:54', '2010-11-17 12:11:06', 1),
(7, 'Anual', '2010-08-29 00:07:08', '2010-11-17 12:11:17', 1),
(9, '5 mêses', '2010-11-17 12:16:02', '2010-11-17 12:16:02', 1);


INSERT INTO `drg_usuarios` (`id`, `nome`, `email`, `login`, `password`, `foto`, `ultimologin`, `numdeacessos`, `hash`, `created`, `modified`, `status`) VALUES
(1, 'dfgdfsgd', 'mail@mail.com', 'fake', '715b524b39c5cdb7b5d31595e4c89edbe3183541', NULL, NULL, NULL, NULL, '2010-11-25 01:21:09', '2010-11-25 01:21:09', 1),
(2, 'dfgdfsgd', 'fake@fake.com', 'fakes', '715b524b39c5cdb7b5d31595e4c89edbe3183541', NULL, NULL, NULL, NULL, '2010-11-25 01:21:09', '2010-11-25 01:21:09', 1),
(3, 'GodFather', 'godfather@mail.com', 'godfather', 'e201b919f7913e66181dce15e0c9e83214d3bc3d', NULL, NULL, NULL, NULL, '2010-11-25 01:21:09', '2010-11-25 01:21:09', 1);

