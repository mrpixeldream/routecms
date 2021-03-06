-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 21. Feb 2015 um 20:55
-- Server Version: 5.5.34
-- PHP-Version: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `routecms`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `routecms_admin_menu`
--

CREATE TABLE IF NOT EXISTS `routecms_admin_menu` (
  `menuID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `permissions` varchar(255) NOT NULL DEFAULT '',
  `parent` varchar(255) NOT NULL DEFAULT '',
  `page` varchar(255) NOT NULL DEFAULT '',
  `position` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menuID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `routecms_admin_menu`
--

INSERT INTO `routecms_admin_menu` (`menuID`, `name`, `permissions`, `parent`, `page`, `position`) VALUES
(1, 'dashboard', '', '', 'Index', 1),
(2, 'members', '', '', 'MemberList', 2),
(3, 'groups', '', '', 'GroupList', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `routecms_event`
--

CREATE TABLE IF NOT EXISTS `routecms_event` (
  `eventID` int(10) NOT NULL AUTO_INCREMENT,
  `class` varchar(255) NOT NULL DEFAULT '',
  `event` varchar(255) NOT NULL DEFAULT '',
  `eventClass` varchar(255) NOT NULL DEFAULT '',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`eventID`),
  UNIQUE KEY `eventID` (`eventID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `routecms_event`
--

INSERT INTO `routecms_event` (`eventID`, `class`, `event`, `eventClass`, `admin`) VALUES
(1, 'AdminAddMenu', 'fetchTemplate', 'routecms\\Template', 1),
(2, 'AdminAddMenu', 'showTemplate', 'routecms\\Template', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `routecms_group`
--

CREATE TABLE IF NOT EXISTS `routecms_group` (
  `groupID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` longtext,
  PRIMARY KEY (`groupID`),
  UNIQUE KEY `groupID` (`groupID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `routecms_group`
--

INSERT INTO `routecms_group` (`groupID`, `name`, `description`) VALUES
(1, 'group.guest', NULL),
(2, 'group.user', NULL),
(3, 'group.admin', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `routecms_group_option`
--

CREATE TABLE IF NOT EXISTS `routecms_group_option` (
  `optionID` int(10) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(255) NOT NULL DEFAULT '',
  `additionalData` longtext NOT NULL,
  `permissions` varchar(255) NOT NULL DEFAULT '',
  `options` varchar(255) NOT NULL DEFAULT '',
  `position` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`optionID`),
  UNIQUE KEY `optionID` (`optionID`),
  UNIQUE KEY `category_4` (`category`,`position`),
  KEY `category` (`category`),
  KEY `category_2` (`category`),
  KEY `category_3` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `routecms_group_option`
--

INSERT INTO `routecms_group_option` (`optionID`, `category`, `name`, `type`, `additionalData`, `permissions`, `options`, `position`) VALUES
(1, 'admin.general', 'admin.can.use.admin', 'boolean', '', '', '', 1),
(2, 'admin.members', 'admin.can.delete.user', 'boolean', '', '', '', 1),
(3, 'admin.members', 'admin.can.edit.user', 'boolean', '', '', '', 2),
(4, 'admin.groups', 'admin.can.edit.group', 'boolean', '', '', '', 1),
(5, 'admin.groups', 'admin.can.delete.group', 'boolean', '', '', '', 2),
(6, 'admin.groupsMange', 'admin.can.mange.group', 'groupList', '', '', '', 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `routecms_group_option_category`
--

CREATE TABLE IF NOT EXISTS `routecms_group_option_category` (
  `categoryID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '',
  `parent` varchar(255) DEFAULT NULL,
  `position` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`categoryID`),
  UNIQUE KEY `categoryID` (`categoryID`),
  UNIQUE KEY `test` (`position`,`parent`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Daten für Tabelle `routecms_group_option_category`
--

INSERT INTO `routecms_group_option_category` (`categoryID`, `name`, `parent`, `position`) VALUES
(1, 'user', NULL, 1),
(2, 'admin', NULL, 2),
(3, 'user.general', 'user', 0),
(4, 'admin.general', 'admin', 0),
(5, 'admin.user', 'admin', 1),
(6, 'admin.members', 'admin.user', 0),
(8, 'admin.groups', 'admin.user', 1),
(10, 'admin.groupsMange', 'admin.user', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `routecms_group_option_value`
--

CREATE TABLE IF NOT EXISTS `routecms_group_option_value` (
  `optionID` int(10) NOT NULL AUTO_INCREMENT,
  `groupID` int(10) NOT NULL DEFAULT '0',
  `value` mediumtext NOT NULL,
  UNIQUE KEY `id` (`optionID`,`groupID`),
  KEY `groupID` (`groupID`),
  KEY `optionID_2` (`optionID`),
  KEY `groupID_2` (`groupID`),
  KEY `optionID` (`optionID`),
  KEY `groupID_3` (`groupID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `routecms_group_option_value`
--

INSERT INTO `routecms_group_option_value` (`optionID`, `groupID`, `value`) VALUES
(1, 1, '0'),
(1, 2, '0'),
(1, 3, '1'),
(2, 3, '1'),
(3, 3, '1'),
(4, 3, '1'),
(5, 3, '1'),
(6, 3, '1\n2\n3');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `routecms_languages`
--

CREATE TABLE IF NOT EXISTS `routecms_languages` (
  `languageID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `languageCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `isDefault` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`languageID`),
  KEY `languageID` (`languageID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `routecms_languages`
--

INSERT INTO `routecms_languages` (`languageID`, `name`, `country`, `languageCode`, `isDefault`) VALUES
(1, 'Deutsch', 'de', 'de', 1),
(2, 'English', 'en', 'gb', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `routecms_menu`
--

CREATE TABLE IF NOT EXISTS `routecms_menu` (
  `menuID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `parent` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `page` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `groupIDs` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `position` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menuID`),
  UNIQUE KEY `menuID` (`menuID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `routecms_options`
--

CREATE TABLE IF NOT EXISTS `routecms_options` (
  `optionID` int(10) NOT NULL AUTO_INCREMENT,
  `optionType` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `optionName` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `optionCategory` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`optionID`),
  UNIQUE KEY `optionID` (`optionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `routecms_options`
--

INSERT INTO `routecms_options` (`optionID`, `optionType`, `optionName`, `value`, `optionCategory`) VALUES
(1, 'integer', 'cookie_expire', '3600', 'system.setting'),
(2, 'string', 'page_title', 'Routecms', 'system.setting');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `routecms_plugin`
--

CREATE TABLE IF NOT EXISTS `routecms_plugin` (
  `pluginID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`pluginID`),
  UNIQUE KEY `pluginID` (`pluginID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `routecms_session`
--

CREATE TABLE IF NOT EXISTS `routecms_session` (
  `sessionID` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `userID` int(10) DEFAULT NULL,
  `pw` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lastTime` int(10) NOT NULL DEFAULT '0',
  `ipAddress` varchar(39) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  UNIQUE KEY `sessionID` (`sessionID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `routecms_session`
--

INSERT INTO `routecms_session` (`sessionID`, `userID`, `pw`, `lastTime`, `ipAddress`) VALUES
('91BJce907R7L9XjWRjY7bNZGU8Zndx7Ue1vM73t2owmX2aS5qu', 1, 'b9f550f0651aa3e6cc86cbf9e4cce96da5015fff', 1424548418, '::ffff:7f00:1'),
('cFSf1DW10eJ0dlLsBNAOjg6072k7k37ifdS01C2k5Q9sUAtClO', 1, '61b561884dd9212964834879ce730956bb71d2e4', 1424459581, '::ffff:7f00:1'),
('dT1VxNRQHWKGh7v6qerzeA0K6zAg2303m58GOt45l5oF96uxGI', 1, 'cecdb7add87be5c6762151976a03cd4becc00872', 1424440593, '::ffff:7f00:1'),
('u083oAJSrcVlA4vOkeC5pS0ysBfQ7RaM0rC42Q402pC3Pl39Af', 1, '5aaae2067c616a62893b06c99c2eb6e8777ce19c', 1424345578, '::ffff:7f00:1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `routecms_template_event`
--

CREATE TABLE IF NOT EXISTS `routecms_template_event` (
  `temaplteEventID` int(10) NOT NULL AUTO_INCREMENT,
  `templateName` varchar(255) NOT NULL DEFAULT '',
  `templateEvent` varchar(255) NOT NULL DEFAULT '',
  `templateInclude` varchar(255) NOT NULL DEFAULT '',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`temaplteEventID`),
  UNIQUE KEY `temaplteEventID` (`temaplteEventID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `routecms_user`
--

CREATE TABLE IF NOT EXISTS `routecms_user` (
  `userID` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`userID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `routecms_user`
--

INSERT INTO `routecms_user` (`userID`, `username`, `password`, `salt`, `email`) VALUES
(1, 'Admin', '1a2bcfa7c06b7ab33c54e4bda8f72dcdb38d2e55', 'rSeeKX83FxKLj2w531Fh', 'Admin@routecms.de');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `routecms_user_to_group`
--

CREATE TABLE IF NOT EXISTS `routecms_user_to_group` (
  `userID` int(10) NOT NULL DEFAULT '0',
  `groupID` int(10) NOT NULL DEFAULT '0',
  UNIQUE KEY `groupID_2` (`groupID`,`userID`),
  KEY `userID` (`userID`,`groupID`),
  KEY `groupID` (`groupID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `routecms_user_to_group`
--

INSERT INTO `routecms_user_to_group` (`userID`, `groupID`) VALUES
(1, 2),
(1, 3);

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `routecms_group_option_value`
--
ALTER TABLE `routecms_group_option_value`
  ADD CONSTRAINT `routecms_group_option_value_ibfk_1` FOREIGN KEY (`optionID`) REFERENCES `routecms_group_option` (`optionID`) ON DELETE CASCADE,
  ADD CONSTRAINT `routecms_group_option_value_ibfk_2` FOREIGN KEY (`groupID`) REFERENCES `routecms_group` (`groupID`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `routecms_session`
--
ALTER TABLE `routecms_session`
  ADD CONSTRAINT `session_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `routecms_user` (`userID`) ON DELETE SET NULL;

--
-- Constraints der Tabelle `routecms_user_to_group`
--
ALTER TABLE `routecms_user_to_group`
  ADD CONSTRAINT `routecms_user_to_group_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `routecms_user` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `routecms_user_to_group_ibfk_2` FOREIGN KEY (`groupID`) REFERENCES `routecms_group` (`groupID`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
