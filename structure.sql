-- ----------------------------------------------------------
-- ------- New statements have to be positioned below -------
-- ----------------------------------------------------------


-- ----------------------------------------------------------
-- ---------------------- 13.07.2012 ------------------------
-- ----------------------------------------------------------

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `callback` text NOT NULL,
  `callback_param` text NOT NULL,
  `rules` text NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group` (`group`,`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `config` (`id`, `group`, `key`, `name`, `callback`, `callback_param`, `rules`, `value`) VALUES
(1, 'system', 'index_page', 'Home page', 'a:2:{i:0;s:20:"Bootstrap_Form_Input";i:1;s:4:"init";}', 'a:1:{s:4:"name";s:4:"test";}', 's:0:"";', 's:12:"blog/archive";'),
(2, 'system_theme', 'frontend', 'Frontend Theme', 'a:2:{i:0;s:18:"Config_Field_Theme";i:1;s:9:"installed";}', 'a:2:{s:4:"name";s:0:"";s:7:"section";s:8:"frontend";}', 's:0:"";', 's:5:"pluto";'),
(3, 'system_theme', 'backend', 'Backend Theme', 'a:2:{i:0;s:18:"Config_Field_Theme";i:1;s:9:"installed";}', 'a:2:{s:4:"name";s:0:"";s:7:"section";s:7:"backend";}', 's:0:"";', 's:5:"pluto";');

CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `installed` tinyint(1) unsigned NOT NULL,
  `activated` tinyint(1) unsigned NOT NULL,
  `position` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `module` (`id`, `name`, `version`, `installed`, `activated`, `position`) VALUES
(1, 'userguide', '1', 1, 1, 1),
(2, 'oneall', '1', 1, 0, 2);

CREATE TABLE IF NOT EXISTS `theme` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `installed` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `theme` (`id`, `name`, `version`, `installed`) VALUES
(1, 'pluto', '1.0', 1),
(2, 'test', '1.0', 1);

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` enum('VERIFICATION','ACTIVE','INACTIVE','BLOCKED') NOT NULL DEFAULT 'VERIFICATION',
  `registered` datetime NOT NULL,
  `last_active` datetime DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `config` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nickname` (`nickname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

INSERT INTO `user` (`id`, `status`, `registered`, `last_active`, `email`, `nickname`, `first_name`, `last_name`, `config`) VALUES
(4, 'VERIFICATION', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'hallo@dududu.ddudu', 'Florian', '', '', NULL),
(5, 'VERIFICATION', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'sdasda@dudu.de', 'sdasdas', '', '', NULL),
(6, 'VERIFICATION', '2012-07-11 07:56:02', NULL, 'dsfs@dshl.de', 'Florians', '', '', NULL);

CREATE TABLE IF NOT EXISTS `user_auth` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `auth_token` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_agent` (`user_agent`,`auth_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `user_auth_service` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `service` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `auth_token` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `user_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `root` int(1) unsigned NOT NULL,
  `translate` int(1) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `permission` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `user_group_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_id` (`group_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- ----------------------------------------------------------
-- ---------------------- 13.07.2012 ------------------------
-- ----------------------------------------------------------

ALTER TABLE `config`
  DROP `name`,
  DROP `callback`,
  DROP `callback_param`,
  DROP `rules`;

TRUNCATE TABLE  `config`;

INSERT INTO `module` (`id`, `name`, `version`, `installed`, `activated`, `position`) VALUES
(NULL, 'bootstrap', '', 1, 1, 1),
(NULL, 'fontawesome', '', 1, 1, 1),
(NULL, 'jquery', '', 1, 1, 1),
(NULL, 'lessphp', '', 1, 1, 1);