-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 05 oct. 2020 à 08:55
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `jobboard`
--

-- --------------------------------------------------------

--
-- Structure de la table `advertisement`
--

DROP TABLE IF EXISTS `advertisement`;
CREATE TABLE IF NOT EXISTS `advertisement` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `contract_type` varchar(30) NOT NULL,
  `starting_date` date DEFAULT NULL,
  `min_salary` int(6) DEFAULT NULL,
  `max_salary` int(6) DEFAULT NULL,
  `localisation` varchar(100) NOT NULL,
  `study_level` varchar(100) DEFAULT NULL,
  `experience_years` int(2) DEFAULT NULL,
  `company_id` int(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `advertisement`
--

INSERT INTO `advertisement` (`id`, `title`, `description`, `contract_type`, `starting_date`, `min_salary`, `max_salary`, `localisation`, `study_level`, `experience_years`, `company_id`) VALUES
(1, 'SEO Manager (Cloud Technology)', 'Create a robust SEO content strategy for Scaleway’s three product universes, including a roadmap of initiatives to drive testing and growth.\r\nWork closely with the Front End, Dedibox and API teams to make sure the company’s infrastructure, architecture, and site features support and enhance the effectiveness of our SEO.\r\nAudit and analyze Scaleway SEO performance, identify issues, find root-causes, and experiment with solutions to improve performance at scale.\r\nCommunicate SEO performance and initiative status to stakeholders in monthly business reviews.\r\nRedefine and evolve key SEO performance metrics, identifying changes and problems as they arise.\r\nLead efforts to solve complex SEO problems, moving quickly to implement ideas and deliver results.\r\nDive into issues and incidents as they occur, perform ad hoc analyses as needed, and/or help escalate them to drive to resolution.\r\nOwn content management globally, contributing to company-wide knowledge sharing and engaging with stakeholders to determine optimal SEO improvements globally.\r\nDevelop relationships with external third-parties to license technology where it makes sense to buy rather than build.\r\nStay on top of key trends and best practices in search engine algorithms, competitive landscape and the industry to develop winning strategies.', 'CDI', NULL, NULL, NULL, 'Paris', NULL, NULL, 1),
(2, 'Business Developer (Cloud Technology)', 'Afin d’accélérer sa croissance en fort développement en France et international, Scaleway renforce son département commercial.\r\nLa Team Sales a dans son ensemble pour but de faire croitre et de développer notre portefeuille de grands clients sur l’ensemble des offres proposées (Collocation, Serveurs dédiés et Cloud).\r\nLa Team développe les références, construit avec nos clients des projets adaptés à leurs attentes, niveaux de service et exigences. Il apporte une réponse professionnelle aux enjeux de production et niveaux de services des revendeurs, hébergeurs, éditeurs de logiciels et autres grands comptes.\r\nEn tant que Business Developper Cloud, tu dois te créer un Parc Client principalement sur la marque Scaleway Elements (Cloud) et Dedibox (serveurs dédiés haut de Gamme).\r\nLe cœur de l’activité actuelle est focalisé sur le développement des entreprises en France mais aussi à l’International.', 'CDI', NULL, NULL, NULL, 'Paris', NULL, NULL, 1),
(3, 'Customer Onboarding Manager', 'Ta mission : accompagner nos clients lors de leurs premiers mois chez Matera et les rendre autonomes et satisfaits\r\n\r\nAider les nouveaux clients à paramétrer leur interface Matera, notamment sur la partie comptable (tu seras pour cela formé à la comptabilité lors de ton arrivée)\r\nEchanger régulièrement avec ton client pour s’assurer que tout se passe bien\r\nFormer le client à l’utilisation de l’app Matera et le métier de syndic coopératif\r\nAssurer la transition la plus smooth possible entre le Sales et le CSM\r\nEn lien avec les équipes Produit et Tech, être force de proposition pour améliorer encore et toujours notre produit\r\n', 'CDI', NULL, 38, 42, 'Paris', NULL, NULL, 2),
(4, 'Business Developer - Copropriétés neuves', 'Ta mission : faire croître le nombre de copropriétés neuves clientes chez Matera !\r\nNous ne traitons que des leads entrants, donc aucune prospection chez nous :)\r\nEvolution rapide prévue sur la première année :\r\n\r\nSur les 2 à 4 premiers mois, poste de SDR spécial neuf :\r\n\r\nPitch (à construire !) de Matera aux prospects, évangélisation sur le modèle de syndic coopératif, qualification du prospect, accompagnement pour la mise en route de sa copro le lendemain de son assemblée générale\r\nMontée en compétence sur les techniques de vente, et familiarisation avec le monde de la copro (droit et compta)\r\nAdapter et dérouler le process de vente Matera classique aux problématiques du neuf. Sur chaque opération, visite de chantier, organisation d’une pré-AG, relations avec le promoteur, audit de charges\r\nEnsuite :\r\n\r\nSignature des contrats, organisation des AG et présentation le jour J (pitch devant une cinquantaine de personnes par exemple), gestion de la relation client\r\nEnjeux : augmenter le taux de conversion dans le neuf, participer à améliorer le NPS client et promoteur immo !\r\nEn parallèle :\r\n\r\nAnalyse des leviers pour améliorer la conversion\r\nFaire remonter les retours des prospects / clients pour participer à l’amélioration du produit\r\nOrganisation d’évènements pour prêcher la bonne parole', 'CDI', NULL, NULL, NULL, 'Paris', NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Structure de la table `company`
--

DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `background` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `company`
--

INSERT INTO `company` (`id`, `name`, `logo`, `background`) VALUES
(1, 'SCALEWAY', 'SCALEWAY.png', 'SCALEWAY_BACKGROUND.jpg'),
(2, 'MATERA', 'MATERA.png', 'MATERA_BACKGROUND.jpg'),
(3, 'CONSEILS-PLUS', 'CONSEILS-PLUS.png', 'CONSEILS-PLUS_BACKGROUND.jpg'),
(4, 'KAVALRY', 'KAVALRY.png', 'KAVALRY_BACKGROUND.jpg'),
(5, 'IBANFIRST', 'IBANFIRST.png', 'IBANFIRST_BACKGROUND.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `job_application`
--

DROP TABLE IF EXISTS `job_application`;
CREATE TABLE IF NOT EXISTS `job_application` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(6) DEFAULT NULL,
  `advertisement_id` int(6) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `cv` varchar(200) DEFAULT NULL,
  `message` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `advertisement_id` (`advertisement_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `profile` varchar(20) NOT NULL,
  `cv` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `phone`, `password`, `profile`, `cv`) VALUES
(1, 'apino', 'alexandre.pinon@epitech.eu', NULL, 'password', 'admin', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
