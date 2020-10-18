-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 16, 2020 at 11:25 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jobboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `background` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `logo`, `background`) VALUES
(1, 'SCALEWAY', 'SCALEWAY.png', 'SCALEWAY_BACKGROUND.jpg'),
(2, 'MATERA', 'MATERA.png', 'MATERA_BACKGROUND.jpg'),
(3, 'CONSEILS-PLUS', 'CONSEILS-PLUS.png', 'CONSEILS-PLUS_BACKGROUND.jpg'),
(4, 'KAVALRY', 'KAVALRY.png', 'KAVALRY_BACKGROUND.jpg'),
(5, 'IBANFIRST', 'IBANFIRST.png', 'IBANFIRST_BACKGROUND.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `advertisement`
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
  PRIMARY KEY (`id`)
  -- FOREIGN KEY (company_id) REFERENCES company(id)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `advertisement`
--

INSERT INTO `advertisement` (`id`, `title`, `description`, `contract_type`, `starting_date`, `min_salary`, `max_salary`, `localisation`, `study_level`, `experience_years`, `company_id`) VALUES
(1, 'SEO Manager (Cloud Technology)', 'Create a robust SEO content strategy for Scaleway’s three product universes, including a roadmap of initiatives to drive testing and growth.\nWork closely with the Front End, Dedibox and API teams to make sure the company’s infrastructure, architecture, and site features support and enhance the effectiveness of our SEO.\nAudit and analyze Scaleway SEO performance, identify issues, find root-causes, and experiment with solutions to improve performance at scale.\nCommunicate SEO performance and initiative status to stakeholders in monthly business reviews.\nRedefine and evolve key SEO performance metrics, identifying changes and problems as they arise.\nLead efforts to solve complex SEO problems, moving quickly to implement ideas and deliver results.\nDive into issues and incidents as they occur, perform ad hoc analyses as needed, and/or help escalate them to drive to resolution.\nOwn content management globally, contributing to company-wide knowledge sharing and engaging with stakeholders to determine optimal SEO improvements globally.\nDevelop relationships with external third-parties to license technology where it makes sense to buy rather than build.\nStay on top of key trends and best practices in search engine algorithms, competitive landscape and the industry to develop winning strategies.', 'CDD', NULL, 35, 50, 'Paris', '', NULL, 1),
(2, 'Business Developer (Cloud Technology)', 'Afin d’accélérer sa croissance en fort développement en France et international, Scaleway renforce son département commercial.\nLa Team Sales a dans son ensemble pour but de faire croitre et de développer notre portefeuille de grands clients sur l’ensemble des offres proposées (Collocation, Serveurs dédiés et Cloud).\nLa Team développe les références, construit avec nos clients des projets adaptés à leurs attentes, niveaux de service et exigences. Il apporte une réponse professionnelle aux enjeux de production et niveaux de services des revendeurs, hébergeurs, éditeurs de logiciels et autres grands comptes.\nEn tant que Business Developper Cloud, tu dois te créer un Parc Client principalement sur la marque Scaleway Elements (Cloud) et Dedibox (serveurs dédiés haut de Gamme).\nLe cœur de l’activité actuelle est focalisé sur le développement des entreprises en France mais aussi à l’International.', 'CDI', NULL, 80, 100, 'Paris', 'Bac +2', 3, 1),
(3, 'Customer Onboarding Manager', 'Ta mission : accompagner nos clients lors de leurs premiers mois chez Matera et les rendre autonomes et satisfaits\r\n\r\nAider les nouveaux clients à paramétrer leur interface Matera, notamment sur la partie comptable (tu seras pour cela formé à la comptabilité lors de ton arrivée)\r\nEchanger régulièrement avec ton client pour s’assurer que tout se passe bien\r\nFormer le client à l’utilisation de l’app Matera et le métier de syndic coopératif\r\nAssurer la transition la plus smooth possible entre le Sales et le CSM\r\nEn lien avec les équipes Produit et Tech, être force de proposition pour améliorer encore et toujours notre produit\r\n', 'CDI', NULL, 38, 42, 'Paris', NULL, NULL, 2),
(4, 'Business Developer - Copropriétés neuves', 'Ta mission : faire croître le nombre de copropriétés neuves clientes chez Matera !\r\nNous ne traitons que des leads entrants, donc aucune prospection chez nous :)\r\nEvolution rapide prévue sur la première année :\r\n\r\nSur les 2 à 4 premiers mois, poste de SDR spécial neuf :\r\n\r\nPitch (à construire !) de Matera aux prospects, évangélisation sur le modèle de syndic coopératif, qualification du prospect, accompagnement pour la mise en route de sa copro le lendemain de son assemblée générale\r\nMontée en compétence sur les techniques de vente, et familiarisation avec le monde de la copro (droit et compta)\r\nAdapter et dérouler le process de vente Matera classique aux problématiques du neuf. Sur chaque opération, visite de chantier, organisation d’une pré-AG, relations avec le promoteur, audit de charges\r\nEnsuite :\r\n\r\nSignature des contrats, organisation des AG et présentation le jour J (pitch devant une cinquantaine de personnes par exemple), gestion de la relation client\r\nEnjeux : augmenter le taux de conversion dans le neuf, participer à améliorer le NPS client et promoteur immo !\r\nEn parallèle :\r\n\r\nAnalyse des leviers pour améliorer la conversion\r\nFaire remonter les retours des prospects / clients pour participer à l’amélioration du produit\r\nOrganisation d’évènements pour prêcher la bonne parole', 'CDI', NULL, NULL, NULL, 'Paris', NULL, NULL, 2),
(13, 'CDI : CONSULTANT SAP ADMINISTRATEUR F/H', 'Intégré au sein d’une de notre équipe, vous intervenez pour nos clients européens et africains afin de réaliser les installations, montées de version, ainsi que le monitoring et la maintenance avec Solution Manager.\r\n\r\nVous travaillerez en étroite collaboration avec les équipes projet et support métier pour assurer la mise en place de SAP connecté à nos outils Solution Manager.\r\n\r\nVous mettrez en place le monitoring centralisé des indicateurs clés de fonctionnement (disponibilité, dumps, backups…) pour alerter les clients de manière pro-active, et assurez une revue régulière avec les clients en maintenance via la revue des rapports Early Watch.\r\n\r\nVous devrez aussi assurer un maintien opérationnel du système Solution Manager conformément aux exigences de la certification partenaire PCOE SAP (détenue depuis 2010).\r\n\r\nEn synthèse, vous accompagnez nos clients depuis le projet d’implémentation jusqu’au support, sur des environnements SAP ERP classiques, S/4 Hana et même les solutions Cloud telles que SCP ou ByDesign, tout en développant l’usage des fonctionnalités Solution Manager.', 'CDI', NULL, NULL, NULL, 'Tours', 'Bac +5 / Master', 3, 3),
(14, 'Financial and HR Manager /Kavalier.e (H/F)', 'Chez Kavalry, chaque Kavalier.e opère un portefeuille de 5 à 10 clients, dont il renforce l’équipe avec des missions sur place et à distance (jusqu’à 3 créneaux/jour).\r\n\r\nLes principales missions qui te seront confiées sont :\r\n\r\nAdministratif : facturation clients & recouvrement, collecte des factures fournisseurs & paiement, suivi RH, lien avec les prestataires (expert-comptable, cabinet social, autres)\r\nLa prise en charge des demandes liées à la vie de bureau\r\nLa gestion des relations avec les fournisseurs de vie de bureau (café, fruits, repas, eau, ménage, etc)\r\nL’onboarding des nouveaux entrants de A à Z (création des comptes d’accès aux principaux outils, accueil, mise à disposition du matériel, etc)', 'CDI', '2020-08-03', NULL, NULL, 'Paris 2e Arrondissement', 'Bac +5 / Master', 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `profile` varchar(20) NOT NULL DEFAULT 'applicant',
  `cv` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `phone`, `password`, `profile`, `cv`) VALUES
(1, 'apino', 'alexandre.pinon@epitech.eu', NULL, 'password', 'admin', NULL),
(8, 'fez fez', 'fez@fez.fez', '', 'fezfez', 'applicant', ''),
(9, 'fezf zefze', 'htrsh@hstrh.hte', '', 'fezfez', 'applicant', ''),
(10, 'zrgreg jrdj', 'greger@erger.erg', '', '123456', 'applicant', ''),
(11, 'Alexandre Pinon', 'alexandre@pinon.fr', '0651663327', '', 'applicant', ''),
(12, 'Kevin Pinon', 'kevin@sengsay.com', '0123456789', '$2y$10$qqOOxRncsIdmsSjui6oWm.iLazySg79dQ1K5nmVwxXDGAO4Hn1eui', 'admin', 'jobboard.txt'),
(15, 'Kevin Sengsay', 'kevin@sengsay.fr', '0123456789', '1234567', 'applicant', ''),
(17, 'Kevin Seychelles', 'bryan@seychelles.com', '0123456789', '$2y$10$CnUG5owlGnxrRRK/u3fLpuisNEzrwcLPX847VAk5EJwOwx5uOy6a.', 'applicant', '');

-- --------------------------------------------------------

--
-- Table structure for table `job_application`
--

DROP TABLE IF EXISTS `job_application`;
CREATE TABLE IF NOT EXISTS `job_application` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(6) DEFAULT NULL,
  `advertisement_id` int(6) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `cv` varchar(200) DEFAULT NULL,
  `message` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
  -- FOREIGN KEY (`user_id`) REFERENCES user(`id`),
  -- FOREIGN KEY (`advertisement_id`) REFERENCES advertisement(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_application`
--

INSERT INTO `job_application` (`id`, `user_id`, `advertisement_id`, `name`, `email`, `phone`, `cv`, `message`) VALUES
(28, 0, 1, 'fez fez', 'fez@fez.fez', '', '', 'fez'),
(29, 0, 1, 'erg greg', 'rgeg@erg.gre', '0123456893', '', 'gre'),
(30, 0, 1, 'Alexandre Pinon', 'zruihkezru@zfzef.gre', '', '', 'f'),
(31, 0, 1, 'Kev Sengsay', 'kevin@sengsay.com', '0123456789', 'jobboard.txt', 'f'),
(32, 0, 1, 'Kevin Seychelles', 'bryan@seychelles.com', '0123456789', '', 'YES'),
(33, 0, 2, 'Kevin Pinon', 'kevin@sengsay.com', '0123456789', 'jobboard.txt', 'r');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
