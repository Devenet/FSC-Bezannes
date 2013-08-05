-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 05 Août 2013 à 01:03
-- Version du serveur: 5.5.9
-- Version de PHP: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `fsc`
--

-- --------------------------------------------------------

--
-- Structure de la table `fsc_activities`
--

DROP TABLE IF EXISTS `fsc_activities`;
CREATE TABLE IF NOT EXISTS `fsc_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `place` text NOT NULL,
  `website` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `aggregate` int(1) NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `price_young` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `fsc_history_admin`
--

DROP TABLE IF EXISTS `fsc_history_admin`;
CREATE TABLE IF NOT EXISTS `fsc_history_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user_admin` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `fsc_members`
--

DROP TABLE IF EXISTS `fsc_members`;
CREATE TABLE IF NOT EXISTS `fsc_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gender` int(1) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `date_birthday` date NOT NULL,
  `address_number` int(8) NOT NULL,
  `address_street` varchar(255) NOT NULL,
  `address_further` varchar(255) NOT NULL,
  `address_zip_code` varchar(5) NOT NULL,
  `address_town` varchar(255) NOT NULL,
  `bezannais` int(1) NOT NULL,
  `address_different` int(1) NOT NULL,
  `minor` int(1) NOT NULL,
  `responsible` int(11) DEFAULT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `adherent` int(1) NOT NULL,
  `date_registration` date DEFAULT NULL,
  `date_creation` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `minor` (`minor`),
  KEY `adherent` (`adherent`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `fsc_members_inscription`
--

DROP TABLE IF EXISTS `fsc_members_inscription`;
CREATE TABLE IF NOT EXISTS `fsc_members_inscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gender` int(1) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `date_birthday` date NOT NULL,
  `address_number` int(8) NOT NULL,
  `address_street` varchar(255) NOT NULL,
  `address_further` varchar(255) NOT NULL,
  `address_zip_code` varchar(5) NOT NULL,
  `address_town` varchar(255) NOT NULL,
  `bezannais` int(1) NOT NULL,
  `address_different` int(1) NOT NULL,
  `minor` int(1) NOT NULL,
  `responsible` int(11) DEFAULT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `adherent` int(1) NOT NULL,
  `date_creation` date NOT NULL,
  `id_user_inscription` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `id_member` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `minor` (`minor`),
  KEY `adherent` (`adherent`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `fsc_participants`
--

DROP TABLE IF EXISTS `fsc_participants`;
CREATE TABLE IF NOT EXISTS `fsc_participants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity` int(11) NOT NULL,
  `adherent` int(11) NOT NULL,
  `schedule` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `fsc_participants_inscription`
--

DROP TABLE IF EXISTS `fsc_participants_inscription`;
CREATE TABLE IF NOT EXISTS `fsc_participants_inscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity` int(11) NOT NULL,
  `adherent` int(11) NOT NULL,
  `schedule` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `fsc_payments_advantages`
--

DROP TABLE IF EXISTS `fsc_payments_advantages`;
CREATE TABLE IF NOT EXISTS `fsc_payments_advantages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adherent` int(11) NOT NULL,
  `amount` double NOT NULL,
  `date` date NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `fsc_payments_transactions`
--

DROP TABLE IF EXISTS `fsc_payments_transactions`;
CREATE TABLE IF NOT EXISTS `fsc_payments_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adherent` int(11) NOT NULL,
  `amount` double NOT NULL,
  `date` date NOT NULL,
  `type` int(1) NOT NULL,
  `note` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `fsc_referents`
--

DROP TABLE IF EXISTS `fsc_referents`;
CREATE TABLE IF NOT EXISTS `fsc_referents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity` int(11) NOT NULL,
  `member` int(11) NOT NULL,
  `type` int(1) NOT NULL,
  `display_phone` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `fsc_schedules`
--

DROP TABLE IF EXISTS `fsc_schedules`;
CREATE TABLE IF NOT EXISTS `fsc_schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity` int(11) NOT NULL,
  `more` varchar(255) DEFAULT NULL,
  `type` int(1) NOT NULL,
  `day` int(1) DEFAULT NULL,
  `time_begin` time DEFAULT NULL,
  `time_end` time DEFAULT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `fsc_users_admin`
--

DROP TABLE IF EXISTS `fsc_users_admin`;
CREATE TABLE IF NOT EXISTS `fsc_users_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `privilege` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `fsc_users_admin` (
  `id` ,
  `login` ,
  `password` ,
  `name` ,
  `privilege`
)
VALUES (
NULL ,  'admin', '68196d44350ba7a579fa43b08309a166217432e5b29067b8d1012ccecb0c96963466da7386f86fd272f6bed9ba36ed6679c0ff222305eff7fc813959ebc9b590',  'Admin',  '8'
);

-- --------------------------------------------------------

--
-- Structure de la table `fsc_users_inscription`
--

DROP TABLE IF EXISTS `fsc_users_inscription`;
CREATE TABLE IF NOT EXISTS `fsc_users_inscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `fsc_users_recover_passwords`
--

DROP TABLE IF EXISTS `fsc_users_recover_passwords`;
CREATE TABLE IF NOT EXISTS `fsc_users_recover_passwords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) NOT NULL,
  `id_user` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `date` int(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
