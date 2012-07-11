-- ----------------------------------------------------------
-- ------- New statements have to be positioned above -------
-- ----------------------------------------------------------


-- ----------------------------------------------------------
-- ---------------------- 11.07.2012 ------------------------
-- ----------------------------------------------------------

ALTER TABLE  `user` ADD  `registered` DATETIME NOT NULL AFTER  `status` ,
ADD  `last_active` DATETIME NOT NULL AFTER  `registered`;

ALTER TABLE  `user` CHANGE  `last_active`  `last_active` DATETIME NULL;

ALTER TABLE  `user_auth_service` ADD  `name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER  `service`;

TRUNCATE TABLE  `config`;

INSERT INTO `config` (`id`, `group`, `key`, `name`, `callback`, `callback_param`, `rules`, `value`) VALUES
(1, 'system', 'index_page', 'Home page', 'a:2:{i:0;s:20:"Bootstrap_Form_Input";i:1;s:4:"init";}', 'a:1:{s:4:"name";s:0:"";}', 's:0:"";', 's:3:"erw";');

-- ----------------------------------------------------------
-- ---------------------- 05.07.2012 ------------------------
-- ----------------------------------------------------------

RENAME TABLE  `ilch2`.`user_service` TO  `ilch2`.`user_auth_service` ;


-- ----------------------------------------------------------
-- ---------------------- 26.06.2012 ------------------------
-- ----------------------------------------------------------

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `type` text NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group` (`group`,`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `config` (`id`, `group`, `key`, `type`, `value`) VALUES
(1, 'system', 'index_controller', 'a:2:{i:0;s:23:"Config_Field_Controller";i:1;s:4:"init";}', 's:5:"index";'),
(2, 'system', 'theme_frontend', 'a:2:{i:0;s:18:"Config_Field_Theme";i:1;s:8:"frontend";}', 'i:1;'),
(3, 'system', 'theme_backend', 'a:2:{i:0;s:18:"Config_Field_Theme";i:1;s:7:"backend";}', 'i:1;');

CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `installed` tinyint(1) unsigned NOT NULL,
  `activated` tinyint(1) unsigned NOT NULL,
  `position` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `module` (`id`, `name`, `version`, `installed`, `activated`, `position`) VALUES
(1, 'userguide', '1', 1, 1, 1);

CREATE TABLE IF NOT EXISTS `theme` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `installed` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `theme` (`id`, `name`, `version`, `installed`) VALUES
(1, 'pluto', '1.0', 1);

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` enum('VERIFICATION','ACTIVE','INACTIVE','BLOCKED') NOT NULL DEFAULT 'VERIFICATION',
  `email` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `config` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nickname` (`nickname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `user_auth` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `auth_token` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_agent` (`user_agent`,`auth_token`)
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

CREATE TABLE IF NOT EXISTS `user_service` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `service` varchar(255) NOT NULL,
  `auth_token` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
