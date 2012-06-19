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