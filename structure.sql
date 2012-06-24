-- ----------------------------------------------------------
-- ---------------------- 28.03.2012 ------------------------
-- ----------------------------------------------------------

CREATE TABLE IF NOT EXISTS `configurations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group` (`group`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- ----------------------------------------------------------
-- ---------------------- 01.04.2012 ------------------------
-- ----------------------------------------------------------

ALTER TABLE  `configurations` DROP INDEX  `group`;
ALTER TABLE  `configurations` CHANGE  `key`  `key` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;


-- ----------------------------------------------------------
-- ---------------------- 02.04.2012 ------------------------
-- ----------------------------------------------------------

CREATE TABLE  `modules` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`source` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`version` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`installed` TINYINT( 1 ) UNSIGNED NOT NULL ,
`activated` TINYINT( 1 ) UNSIGNED NOT NULL ,
`position` INT UNSIGNED NULL
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE  `configurations` CHANGE  `id`  `id` INT( 10 ) NOT NULL AUTO_INCREMENT;


-- ----------------------------------------------------------
-- ---------------------- 28.04.2012 ------------------------
-- ----------------------------------------------------------

RENAME TABLE  `configurations` TO  `configuration` ;
RENAME TABLE  `modules` TO  `module` ;


-- ----------------------------------------------------------
-- ---------------------- 25.05.2012 ------------------------
-- ----------------------------------------------------------

CREATE TABLE IF NOT EXISTS `theme` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `source` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `installed` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `theme` (`id`, `source`, `name`, `version`, `installed`) VALUES (NULL, 'ilch', 'pluto', '1.0', '1');


-- ----------------------------------------------------------
-- ---------------------- 27.05.2012 ------------------------
-- ----------------------------------------------------------

INSERT INTO `configuration` (`id`, `group`, `key`, `type`, `value`) VALUES
(1, 'ilch_system', 'index_controller', 'a:2:{i:0;s:23:"Config_Field_Controller";i:1;s:4:"init";}', 's:5:"index";'),
(2, 'ilch_system', 'theme_frontend', 'a:2:{i:0;s:18:"Config_Field_Theme";i:1;s:4:"init";}', 'i:1;');


-- ----------------------------------------------------------
-- ---------------------- 19.06.2012 ------------------------
-- ----------------------------------------------------------

ALTER TABLE `theme` DROP `source`;
ALTER TABLE `module` DROP `source`;


-- ----------------------------------------------------------
-- ---------------------- 24.06.2012 ------------------------
-- ----------------------------------------------------------

ALTER TABLE  `configuration` CHANGE  `type`  `type` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
UPDATE  `configuration` SET  `group` =  'system' WHERE  `configuration`.`group` = 'ilch_system';

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `root` int(1) unsigned NOT NULL,
  `translate` int(1) unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

INSERT INTO `group` (`id`, `root`, `translate`, `name`, `description`) VALUES
(1, 1, 1, 'Administrator', ''),
(2, 0, 1, 'Members', ''),
(3, 0, 1, 'Guests', '');

ALTER TABLE  `group` CHANGE  `root`  `root` TINYINT( 1 ) UNSIGNED NOT NULL ,
CHANGE  `translate`  `translate` TINYINT( 1 ) UNSIGNED NOT NULL;

ALTER TABLE  `module` CHANGE  `id`  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE  `position`  `position` INT( 11 ) UNSIGNED NULL DEFAULT NULL;

ALTER TABLE  `theme` CHANGE  `id`  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT;

CREATE TABLE IF NOT EXISTS `group_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `group` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_id` (`group_id`,`group`,`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

RENAME TABLE  `ilch2`.`configuration` TO  `ilch2`.`config` ;