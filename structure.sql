------------------------------------------------------------
------------------------ 28.03.2012 ------------------------
------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `configurations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group` (`group`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


------------------------------------------------------------
------------------------ 01.04.2012 ------------------------
------------------------------------------------------------

ALTER TABLE  `configurations` DROP INDEX  `group`;
ALTER TABLE  `configurations` CHANGE  `key`  `key` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;


------------------------------------------------------------
------------------------ 02.04.2012 ------------------------
------------------------------------------------------------

CREATE TABLE  `modules` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`source` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`version` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`installed` TINYINT( 1 ) UNSIGNED NOT NULL ,
`activated` TINYINT( 1 ) UNSIGNED NOT NULL ,
`position` INT UNSIGNED NULL
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE  `configurations` CHANGE  `id`  `id` INT( 10 ) NOT NULL AUTO_INCREMENT