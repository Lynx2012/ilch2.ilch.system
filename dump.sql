-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 20. Jul 2012 um 18:50
-- Server Version: 5.5.16
-- PHP-Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Datenbank: `ilch2`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group` (`group`,`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `config`
--

INSERT INTO `config` (`id`, `group`, `key`, `value`) VALUES
(1, 'system_theme', 'frontend', 's:1:"3";'),
(2, 'system_theme', 'backend', 's:1:"3";'),
(3, 'system', 'index_page', 's:10:"user/login";');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `root` tinyint(1) unsigned NOT NULL,
  `key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `menu_widget`
--

CREATE TABLE IF NOT EXISTS `menu_widget` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL,
  `widget` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `installed` tinyint(1) unsigned NOT NULL,
  `activated` tinyint(1) unsigned NOT NULL,
  `position` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Daten für Tabelle `module`
--

INSERT INTO `module` (`id`, `name`, `version`, `installed`, `activated`, `position`) VALUES
(1, 'userguide', '1', 1, 1, 1),
(2, 'oneall', '1', 1, 0, 2),
(3, 'bootstrap', '', 1, 1, 1),
(5, 'fontawesome', '', 1, 1, 1),
(6, 'jquery', '', 1, 1, 1),
(7, 'lessphp', '', 1, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `navigation`
--

CREATE TABLE IF NOT EXISTS `navigation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `root` tinyint(1) unsigned NOT NULL,
  `key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `navigation_element`
--

CREATE TABLE IF NOT EXISTS `navigation_element` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `navigation_id` int(11) unsigned NOT NULL,
  `position` int(11) unsigned NOT NULL,
  `follow` tinyint(1) unsigned NOT NULL,
  `target` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `theme`
--

CREATE TABLE IF NOT EXISTS `theme` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `installed` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `theme`
--

INSERT INTO `theme` (`id`, `name`, `version`, `installed`) VALUES
(2, 'test', '1.0', 1),
(3, 'pluto', '1.0', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

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

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `status`, `registered`, `last_active`, `email`, `nickname`, `first_name`, `last_name`, `config`) VALUES
(4, 'VERIFICATION', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'hallo@dududu.ddudu', 'Florian', '', '', NULL),
(5, 'VERIFICATION', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'sdasda@dudu.de', 'sdasdas', '', '', NULL),
(6, 'VERIFICATION', '2012-07-11 07:56:02', NULL, 'dsfs@dshl.de', 'Florians', '', '', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_auth`
--

CREATE TABLE IF NOT EXISTS `user_auth` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `auth_token` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_agent` (`user_agent`,`auth_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_auth_service`
--

CREATE TABLE IF NOT EXISTS `user_auth_service` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `service` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `auth_token` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `root` int(1) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `permission` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_group_member`
--

CREATE TABLE IF NOT EXISTS `user_group_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_id` (`group_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
