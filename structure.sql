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