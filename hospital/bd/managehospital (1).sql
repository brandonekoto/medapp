-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 01 mai 2019 à 15:21
-- Version du serveur :  5.7.17
-- Version de PHP :  7.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `managehospital`
--
CREATE DATABASE IF NOT EXISTS `managehospital` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `managehospital`;

-- --------------------------------------------------------

--
-- Structure de la table `acte`
--

DROP TABLE IF EXISTS `acte`;
CREATE TABLE `acte` (
  `id` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `lib` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `prix_prive` double NOT NULL,
  `prix_conventionne` double NOT NULL,
  `prix_affilier` double NOT NULL,
  `prix` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Déchargement des données de la table `acte`
--

INSERT INTO `acte` (`id`, `id_category`, `lib`, `description`, `prix_prive`, `prix_conventionne`, `prix_affilier`, `prix`) VALUES
(1, 1, 'Premier soins', '', 20, 50, 0, 0),
(6, 4, 'appendicite', '', 20, 20, 20, 20),
(7, 4, 'césarienne', '', 20, 20, 20, 20),
(8, 4, 'Hernie', '', 20, 20, 20, 20),
(9, 4, 'chirurgie intestinale', '', 20, 20, 20, 20),
(12, 6, 'Globules rouges', '', 50, 50, 50, 50),
(13, 2, 'visite médicale', '', 12, 12, 23, 23);

-- --------------------------------------------------------

--
-- Structure de la table `acte_pose`
--

DROP TABLE IF EXISTS `acte_pose`;
CREATE TABLE `acte_pose` (
  `id` int(11) NOT NULL,
  `id_acte` int(11) NOT NULL,
  `id_patient` int(11) NOT NULL,
  `id_agent` int(11) NOT NULL,
  `etape` int(1) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Déchargement des données de la table `acte_pose`
--

INSERT INTO `acte_pose` (`id`, `id_acte`, `id_patient`, `id_agent`, `etape`, `date`, `end`) VALUES
(1, 6, 11, 15, 0, '2019-04-24 16:01:11', '0'),
(2, 6, 11, 15, 0, '2019-04-24 16:01:11', '0'),
(4, 7, 1, 15, 1, '2019-04-24 16:10:45', '0'),
(5, 7, 5, 15, 1, '2019-04-25 08:27:26', '0'),
(6, 13, 4, 15, 1, '2019-04-29 15:52:12', '0'),
(7, 1, 1, 15, 1, '2019-04-25 17:07:35', '0'),
(8, 7, 1, 15, 1, '2019-04-27 00:11:55', '0'),
(9, 1, 1, 15, 1, '2019-04-27 00:41:09', '0'),
(10, 9, 11, 15, 1, '2019-04-29 00:43:25', '0'),
(11, 1, 1, 15, 1, '2019-04-28 20:19:58', '0');

-- --------------------------------------------------------

--
-- Structure de la table `agent`
--

DROP TABLE IF EXISTS `agent`;
CREATE TABLE `agent` (
  `id` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `postnom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `genre` char(2) NOT NULL,
  `dateNaiss` date NOT NULL,
  `lieuNaiss` varchar(30) NOT NULL,
  `etatCivil` text NOT NULL,
  `nbreEnfant` int(11) DEFAULT '0',
  `adresse` text NOT NULL,
  `contact` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `statut` varchar(1) NOT NULL DEFAULT '0',
  `nivEtude` enum('doc','dip','lic','grad') NOT NULL,
  `dateEng` date NOT NULL,
  `dateSortir` date NOT NULL,
  `fonction` int(11) NOT NULL,
  `nationality` varchar(60) NOT NULL DEFAULT 'RDC',
  `id_avatar` int(11) NOT NULL DEFAULT '1',
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `agent`
--

INSERT INTO `agent` (`id`, `nom`, `postnom`, `prenom`, `genre`, `dateNaiss`, `lieuNaiss`, `etatCivil`, `nbreEnfant`, `adresse`, `contact`, `email`, `statut`, `nivEtude`, `dateEng`, `dateSortir`, `fonction`, `nationality`, `id_avatar`, `id_user`) VALUES
(15, 'Brandon', 'Ekoto', 'Brandon', 'M', '2019-04-05', 'Kinshasa', 'c', 1, 'ezretry', '+243822385571', 'djbrandon.ekoto@gmail.com', '0', 'lic', '2019-04-07', '2019-04-14', 2, 'RDC', 22, 15),
(22, 'Kibala', 'Marlene', 'Marlene', 'F', '2019-04-26', 'Kinshasa', 'm', 2, 'Gjdklmf', '+243822385571', 'djbrandon.ekoto@gmail.com', '0', 'grad', '2019-04-26', '2019-04-26', 2, 'RDC', 22, NULL),
(23, 'Kibala', 'Marlene', 'Marlene', 'F', '2019-04-26', 'Kinshasa', 'm', 2, 'Gjdklmf', '+243822385571', 'djbrandon.ekoto@gmail.com', '0', 'grad', '2019-04-26', '2019-04-26', 2, 'RDC', 24, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `agent_family`
--

DROP TABLE IF EXISTS `agent_family`;
CREATE TABLE `agent_family` (
  `id` int(11) NOT NULL,
  `idAgent` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `postnom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `age` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `agent_horaire`
--

DROP TABLE IF EXISTS `agent_horaire`;
CREATE TABLE `agent_horaire` (
  `idAgent` int(11) NOT NULL,
  `idHoraire` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `category_acte`
--

DROP TABLE IF EXISTS `category_acte`;
CREATE TABLE `category_acte` (
  `id` int(11) NOT NULL,
  `lib` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `category_acte`
--

INSERT INTO `category_acte` (`id`, `lib`, `description`) VALUES
(1, 'consultation', ''),
(2, 'hospitalisation', ''),
(3, 'Accouchement', ''),
(4, 'Acte chirurgical', ''),
(5, 'Actes gynécologiques', ''),
(6, 'HERMATOLOGIE', ''),
(7, 'SEROLOGIE', ''),
(8, 'BIOCHIMIE', ''),
(9, 'HORMONOLOGIE ', ''),
(10, 'DIVERS', ''),
(11, 'PARASITO, URINES ET CULTURE', '');

-- --------------------------------------------------------

--
-- Structure de la table `chambre`
--

DROP TABLE IF EXISTS `chambre`;
CREATE TABLE `chambre` (
  `id` int(11) NOT NULL,
  `lib` varchar(50) NOT NULL,
  `prix` double NOT NULL,
  `category` enum('ordinaire','vip') NOT NULL,
  `nblit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `chambre`
--

INSERT INTO `chambre` (`id`, `lib`, `prix`, `category`, `nblit`) VALUES
(1, 'Salle Hospitalisation 1', 20, 'ordinaire', 3),
(2, 'Salle Hospitalisation 2', 20, 'ordinaire', 3),
(3, 'Salle Hospitalisation 3', 20, 'ordinaire', 3),
(6, 'Salle VIP 1', 50, 'vip', 1),
(7, 'Salle VIP 2', 50, 'vip', 1);

-- --------------------------------------------------------

--
-- Structure de la table `consultation`
--

DROP TABLE IF EXISTS `consultation`;
CREATE TABLE `consultation` (
  `id` int(11) NOT NULL,
  `id_acte` int(11) NOT NULL,
  `anamnese` text NOT NULL,
  `taille` double NOT NULL,
  `poids` double NOT NULL,
  `temp` double NOT NULL,
  `obs` text CHARACTER SET utf8,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tension` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `consultation`
--

INSERT INTO `consultation` (`id`, `id_acte`, `anamnese`, `taille`, `poids`, `temp`, `obs`, `date`, `tension`) VALUES
(17, 1, 'qrtr', 4, 3, 5, NULL, '2019-04-26 20:23:55', '7'),
(18, 1, 'qrtr', 4, 3, 5, NULL, '2019-04-25 00:06:56', '7'),
(19, 8, 'fgjhkjmlkljkhjghfgjhkjlkmmklkjvhg', 66, 445, 25, NULL, '2019-04-26 21:08:34', '23'),
(20, 10, 'fgjhkjmlkljkhjghfgjhkjlkmmklkjvhg', 66, 445, 25, NULL, '2019-04-26 21:18:57', '23');

-- --------------------------------------------------------

--
-- Structure de la table `diagnostic`
--

DROP TABLE IF EXISTS `diagnostic`;
CREATE TABLE `diagnostic` (
  `id` int(11) NOT NULL,
  `id_acte` int(11) NOT NULL,
  `obs_diagnostic` text NOT NULL,
  `id_agent` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `diagnostic`
--

INSERT INTO `diagnostic` (`id`, `id_acte`, `obs_diagnostic`, `id_agent`, `date`) VALUES
(1, 9, 'fdjghkjlfdghfhkjlkjmjljhkhgfgfhj', 15, '2019-04-26 07:13:06'),
(2, 8, 'fhgfjhrtr', 22, '2019-04-29 07:13:06'),
(3, 8, 'xtuycuvibuniopùljkhjghfg', 22, '2019-04-27 07:42:52'),
(4, 9, 'tryuilfgbn,;fghjkhj;k:bgn,;hgjk;jhk', 15, '2019-04-27 13:58:19'),
(5, 5, 'gfhghjklmkjhgfdghjklmkjhgfdghjklkjhgfdf', 15, '2019-04-29 13:25:15'),
(6, 7, 'kgthjlkmhkgljfkhjghkvjbknl!,l!nk:bjv;h,cgnxgc,v;b,:;n!:,n;!b:,;vn,b', 15, '2019-04-30 08:10:59');

-- --------------------------------------------------------

--
-- Structure de la table `download`
--

DROP TABLE IF EXISTS `download`;
CREATE TABLE `download` (
  `id_download` int(11) NOT NULL,
  `filename` varchar(80) NOT NULL,
  `id_user` int(11) UNSIGNED NOT NULL,
  `type` varchar(40) NOT NULL,
  `size` double NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `download`
--

INSERT INTO `download` (`id_download`, `filename`, `id_user`, `type`, `size`, `date`) VALUES
(1, 'avatar', 1, 'jpg', 21, '2019-04-24 17:47:36'),
(2, 'zF37.265', 1, 'jpeg', 84699, '2019-04-26 01:50:28'),
(3, 'zF89.476', 1, 'jpeg', 27726, '2019-04-26 01:51:16'),
(4, 'zF144.809', 1, 'jpeg', 1241599, '2019-04-26 01:52:04'),
(5, 'zF266.094', 1, 'jpeg', 1241599, '2019-04-26 01:52:32'),
(6, 'zF887.39', 1, 'jpeg', 1241599, '2019-04-26 01:57:00'),
(7, 'zF92.628', 1, 'jpeg', 1241599, '2019-04-26 01:57:16'),
(8, 'zF784.306', 1, 'jpeg', 1241599, '2019-04-26 01:58:26'),
(9, 'zF866.455', 1, 'jpeg', 1241599, '2019-04-26 01:59:25'),
(10, 'zF334.665', 1, 'jpeg', 1241599, '2019-04-26 01:59:55'),
(11, 'zF155.433', 1, 'jpeg', 1241599, '2019-04-26 02:02:11'),
(12, 'zF124.32', 1, 'jpeg', 1241599, '2019-04-26 02:03:41'),
(13, 'zF250.013', 1, 'jpeg', 1241599, '2019-04-26 02:05:05'),
(14, 'zF232.476', 1, 'jpeg', 1241599, '2019-04-26 02:07:24'),
(15, 'zF568.767', 1, 'jpeg', 5495, '2019-04-26 02:08:43'),
(16, 'zF205.27', 1, 'jpeg', 5495, '2019-04-26 02:09:57'),
(17, 'zF213.964', 1, 'jpeg', 5495, '2019-04-26 02:12:52'),
(18, 'zF795.131', 1, 'jpeg', 5495, '2019-04-26 02:20:52'),
(19, 'zF139.92', 1, 'jpeg', 5495, '2019-04-26 02:21:45'),
(20, 'zF87.578', 1, 'jpeg', 5495, '2019-04-26 02:22:39'),
(21, 'zF751.277', 1, 'jpeg', 5495, '2019-04-26 02:23:05'),
(22, 'zF500.172', 1, 'jpeg', 5495, '2019-04-26 02:23:49'),
(23, 'zF613.481', 1, 'jpeg', 5495, '2019-04-26 02:25:51'),
(24, 'zF659.027', 1, 'jpeg', 5495, '2019-04-26 02:28:33'),
(25, 'zF612.271', 1, 'jpeg', 31638, '2019-04-26 02:44:48'),
(26, 'zF650.721', 1, 'jpeg', 31638, '2019-04-26 02:45:00');

-- --------------------------------------------------------

--
-- Structure de la table `echproduit`
--

DROP TABLE IF EXISTS `echproduit`;
CREATE TABLE `echproduit` (
  `idEchProduit` int(11) NOT NULL,
  `designation` varchar(30) NOT NULL,
  `modeConservation` varchar(30) NOT NULL,
  `uniteConsommation` varchar(30) NOT NULL,
  `quantiteAlerte` int(11) NOT NULL,
  `idCategorie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `echproduit`
--

INSERT INTO `echproduit` (`idEchProduit`, `designation`, `modeConservation`, `uniteConsommation`, `quantiteAlerte`, `idCategorie`) VALUES
(2, 'sulfatrim/forte', 'capsule', 'gramme', 10, 1),
(6, 'quinine', 'gh', 'gramme', 10, 1),
(7, 'aspirine', 'hhh', 'gramme', 10, 1),
(8, 'combatrin', 'hhh', 'gramme', 7, 1);

-- --------------------------------------------------------

--
-- Structure de la table `element_prescrit`
--

DROP TABLE IF EXISTS `element_prescrit`;
CREATE TABLE `element_prescrit` (
  `id` int(11) NOT NULL,
  `id_prescription` int(11) NOT NULL,
  `element` varchar(100) NOT NULL,
  `mode_emploi` varchar(100) NOT NULL,
  `observation` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `element_prescrit`
--

INSERT INTO `element_prescrit` (`id`, `id_prescription`, `element`, `mode_emploi`, `observation`) VALUES
(1, 1, 'aspirine', 'zfge', ''),
(2, 1, 'quinin', '', ''),
(3, 2, 'Dicrofinade', '', ''),
(4, 1, 'gghgjh', '', 'fdgfjhgkjl'),
(5, 1, 'fgjhgkjh', '', 'sdtfyguhijklk'),
(6, 1, 'gghgjh', '', 'xcgfcyuhih'),
(7, 1, 'gghgjh', '', 'xcgfcyuhih'),
(8, 1, 'gghgjh', '', 'xcgfcyuhih'),
(9, 1, 'gghgjh', '', 'xcgfcyuhih'),
(10, 1, 'gghgjh', 'hgjghkjlk', 'xcgfcyuhih'),
(11, 1, 'gghgjh', 'hgjghkjlk', 'xcgfcyuhih'),
(12, 1, 'gghgjh', 'hgjghkjlk', 'xcgfcyuhih'),
(13, 3, 'gghgjh', 'cgfhgkjhlkj', 'tdyfgkjhlkjkghjfghdfghjgkhlgkjfghdfgshdjfgkhl');

-- --------------------------------------------------------

--
-- Structure de la table `examens`
--

DROP TABLE IF EXISTS `examens`;
CREATE TABLE `examens` (
  `id` int(11) NOT NULL,
  `lib` varchar(90) NOT NULL,
  `idcategory` int(11) NOT NULL,
  `prixprive` int(11) NOT NULL,
  `prixconventionne` int(11) NOT NULL,
  `prixaffilier` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `examens`
--

INSERT INTO `examens` (`id`, `lib`, `idcategory`, `prixprive`, `prixconventionne`, `prixaffilier`, `description`) VALUES
(1, 'VIH', 20, 20, 20, 20, ''),
(2, 'Malaria', 25, 23, 23, 23, ''),
(3, 'Thyfoide', 2, 23, 20, 20, ''),
(4, 'Sang', 25, 3, 3, 23, '');

-- --------------------------------------------------------

--
-- Structure de la table `examen_recommand`
--

DROP TABLE IF EXISTS `examen_recommand`;
CREATE TABLE `examen_recommand` (
  `id` int(11) NOT NULL,
  `id_acte` int(11) DEFAULT NULL,
  `id_diagnostic` int(11) NOT NULL,
  `id_examen` int(11) NOT NULL,
  `observation` text NOT NULL,
  `resultat` text,
  `id_agent_labo` int(11) DEFAULT NULL,
  `fait` varchar(1) NOT NULL DEFAULT '0',
  `daterecommande` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datefait` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `examen_recommand`
--

INSERT INTO `examen_recommand` (`id`, `id_acte`, `id_diagnostic`, `id_examen`, `observation`, `resultat`, `id_agent_labo`, `fait`, `daterecommande`, `datefait`) VALUES
(2, NULL, 4, 3, 'fhgfjkhlmksrstdyfguhijokpldtfyghjk', 'retyuiopiuytr', 23, '1', '2019-04-29 16:42:46', NULL),
(3, NULL, 3, 2, 'dfgh', 'fdghjgfdfghjkl', 23, '1', '2019-04-29 16:40:45', NULL),
(4, NULL, 4, 1, '', 'gjhkjkhjghfgdfsdgfhgjkjgdfhgjhkjlhkgj', 15, '1', '2019-04-30 08:15:10', NULL),
(5, NULL, 3, 1, 'yigygthfrfrkmhfjo&ugrave;jgmoj^phphjfkhfjhjkfh', 'gjhkjkhjghfgdfsdgfhgjkjgdfhgjhkjlhkgj', NULL, '1', '2019-04-30 08:15:10', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

DROP TABLE IF EXISTS `facture`;
CREATE TABLE `facture` (
  `numRef` int(11) NOT NULL,
  `montant` double NOT NULL,
  `dateVente` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `facture`
--

INSERT INTO `facture` (`numRef`, `montant`, `dateVente`) VALUES
(3, 6000, '2019-04-10'),
(4, 5000, '2019-04-10');

-- --------------------------------------------------------

--
-- Structure de la table `facture_produit`
--

DROP TABLE IF EXISTS `facture_produit`;
CREATE TABLE `facture_produit` (
  `idProduit` int(11) NOT NULL,
  `idFacture` int(11) NOT NULL,
  `quantite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `facture_produit`
--

INSERT INTO `facture_produit` (`idProduit`, `idFacture`, `quantite`) VALUES
(9, 3, 7),
(9, 4, 7),
(21, 3, 5),
(21, 4, 3);

-- --------------------------------------------------------

--
-- Structure de la table `fonction`
--

DROP TABLE IF EXISTS `fonction`;
CREATE TABLE `fonction` (
  `idFonction` int(11) NOT NULL,
  `libelle` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `fonction`
--

INSERT INTO `fonction` (`idFonction`, `libelle`) VALUES
(1, 'Médecin Directeur'),
(2, 'Médecin'),
(3, 'Infirmier'),
(4, 'Labo'),
(5, 'Réceptionniste'),
(6, 'Comptable'),
(7, 'Pharmacien');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

DROP TABLE IF EXISTS `fournisseur`;
CREATE TABLE `fournisseur` (
  `idFournisseur` int(11) NOT NULL,
  `fournisseur` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `fournisseur`
--

INSERT INTO `fournisseur` (`idFournisseur`, `fournisseur`) VALUES
(1, 'shalina'),
(2, 'pharmaKin'),
(3, 'kinph'),
(4, 'etldrug'),
(5, 'etldrug'),
(6, 'kinkink'),
(7, 'eternel');

-- --------------------------------------------------------

--
-- Structure de la table `horaire`
--

DROP TABLE IF EXISTS `horaire`;
CREATE TABLE `horaire` (
  `idHoraire` int(11) NOT NULL,
  `lundi` varchar(30) NOT NULL,
  `mardi` varchar(30) NOT NULL,
  `mercredi` varchar(30) NOT NULL,
  `jeudi` varchar(30) NOT NULL,
  `vendredi` varchar(30) NOT NULL,
  `samedi` varchar(30) NOT NULL,
  `dimanche` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `hospitalisation`
--

DROP TABLE IF EXISTS `hospitalisation`;
CREATE TABLE `hospitalisation` (
  `id` int(11) NOT NULL,
  `id_acte` int(11) NOT NULL,
  `date_entree` datetime NOT NULL,
  `id_agent` int(11) NOT NULL,
  `id_lit` int(11) NOT NULL,
  `etat` enum('0','1','2','') NOT NULL,
  `sorti` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `lit`
--

DROP TABLE IF EXISTS `lit`;
CREATE TABLE `lit` (
  `id` int(11) NOT NULL,
  `id_chambre` int(11) NOT NULL,
  `lib` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `lit`
--

INSERT INTO `lit` (`id`, `id_chambre`, `lib`) VALUES
(1, 1, '1A'),
(2, 1, '1B'),
(3, 1, '1C'),
(4, 2, '2A'),
(5, 2, '2B'),
(6, 2, '2C'),
(7, 3, '3A'),
(8, 3, '3B'),
(9, 3, '3C'),
(10, 6, 'A1'),
(11, 7, 'A1');

-- --------------------------------------------------------

--
-- Structure de la table `lot`
--

DROP TABLE IF EXISTS `lot`;
CREATE TABLE `lot` (
  `idLot` int(11) NOT NULL,
  `designation` varchar(30) NOT NULL,
  `dateLot` date NOT NULL,
  `heure` time NOT NULL,
  `document` text NOT NULL,
  `etat` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `lot`
--

INSERT INTO `lot` (`idLot`, `designation`, `dateLot`, `heure`, `document`, `etat`) VALUES
(1, 'lot17', '2019-03-07', '10:14:35', '15-regles-de-conjugaison.pdf', 'non active'),
(2, 'etl7', '2019-03-07', '10:14:54', '15-regles-de-conjugaison_2.pdf', 'non active'),
(3, 'bb', '2019-03-07', '10:53:33', '15-regles-de-conjugaison_2.pdf', 'non active'),
(4, 'LotDebut', '2019-03-07', '06:59:20', '15-regles-de-conjugaison_2.pdf', 'non active');

-- --------------------------------------------------------

--
-- Structure de la table `lot_produit`
--

DROP TABLE IF EXISTS `lot_produit`;
CREATE TABLE `lot_produit` (
  `idLot_produit` int(11) NOT NULL,
  `idProduit` int(11) NOT NULL,
  `idLot` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `lot_produit`
--

INSERT INTO `lot_produit` (`idLot_produit`, `idProduit`, `idLot`) VALUES
(8, 9, 1),
(27, 21, 1);

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE `patient` (
  `idPatient` int(11) NOT NULL,
  `nom` varchar(30) CHARACTER SET latin1 NOT NULL,
  `postnom` varchar(30) CHARACTER SET latin1 NOT NULL,
  `prenom` varchar(30) CHARACTER SET latin1 NOT NULL,
  `sexe` varchar(2) CHARACTER SET latin1 NOT NULL,
  `age` varchar(12) CHARACTER SET latin1 NOT NULL,
  `etatcivil` varchar(1) NOT NULL,
  `lieuNaiss` varchar(90) NOT NULL,
  `contact` varchar(20) CHARACTER SET latin1 NOT NULL,
  `email` varchar(90) CHARACTER SET latin1 DEFAULT NULL,
  `adresse` text CHARACTER SET latin1 NOT NULL,
  `typePatient` varchar(30) CHARACTER SET latin1 NOT NULL,
  `numAffiation` int(11) NOT NULL DEFAULT '0',
  `dateEnregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nationality` varchar(50) NOT NULL DEFAULT 'CD',
  `id_avatar` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`idPatient`, `nom`, `postnom`, `prenom`, `sexe`, `age`, `etatcivil`, `lieuNaiss`, `contact`, `email`, `adresse`, `typePatient`, `numAffiation`, `dateEnregistrement`, `nationality`, `id_avatar`) VALUES
(1, 'munia', 'makonda', 'deborah', 'F', '16', '', '0000-00-00', '5656', NULL, 'kinshasa', '1', 1, '2019-04-24 17:57:35', 'CD', 1),
(2, 'lutumba', 'makonda', 'adan', 'M', '12', '', '0000-00-00', '78787', NULL, '                                                        adresse\n                                                    ', '0', 2, '2019-04-24 17:57:32', 'CD', 1),
(3, 'mukwamasela', 'Lutumba', 'beni', 'M', '19', '', '0000-00-00', '8877', NULL, '                                                        adresse\n                                                    ', '0', 1, '2019-04-24 17:57:29', 'CD', 1),
(4, 'munia', 'makonda', 'deborah', 'F', '16', '', '0000-00-00', '8787', NULL, '                                                        adresse\n                                                    ', '1', 1, '2019-04-24 17:57:24', 'CD', 1),
(5, 'lutumba', 'wa lutumba', 'Henoc', 'M', '22', '', '0000-00-00', '878778', NULL, 'kinshasa', '1', 2, '2019-04-24 17:57:21', 'CD', 1),
(11, 'Brandon', 'Ekoto', 'Brandon', 'F', '2019-04-20', 'm', 'Kinshasa', '+243822385571', 'djbrandon.ekoto@gmail.com', 'hGkeukf', '0', 0, '2019-04-27 16:33:56', 'CD', 23),
(12, 'Nzola', 'Marielouis', 'Melissa', 'F', '2015-06-17', 'c', 'Kinshasa', '+243822385571', 'djbrandon.ekoto@gmail.com', 'ALkjfgjm', '0', 0, '2019-04-26 02:45:00', 'CD', 26);

-- --------------------------------------------------------

--
-- Structure de la table `personne_affilie`
--

DROP TABLE IF EXISTS `personne_affilie`;
CREATE TABLE `personne_affilie` (
  `id` int(11) NOT NULL,
  `id_patient` int(11) NOT NULL,
  `id_structure` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Déchargement des données de la table `personne_affilie`
--

INSERT INTO `personne_affilie` (`id`, `id_patient`, `id_structure`) VALUES
(1, 0, 0),
(2, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `prescription`
--

DROP TABLE IF EXISTS `prescription`;
CREATE TABLE `prescription` (
  `id` int(11) NOT NULL,
  `datePrescrit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `idActe` int(11) NOT NULL,
  `observation` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `prescription`
--

INSERT INTO `prescription` (`id`, `datePrescrit`, `idActe`, `observation`) VALUES
(1, '2019-04-30 23:12:27', 9, ''),
(2, '2019-04-30 23:12:27', 11, ''),
(3, '2019-05-01 09:04:48', 9, 'dsfghgjkhljsdfyugihoujpfgfyuihojpdfhghiojkpo');

-- --------------------------------------------------------

--
-- Structure de la table `presence`
--

DROP TABLE IF EXISTS `presence`;
CREATE TABLE `presence` (
  `idPresence` int(11) NOT NULL,
  `statutPresence` varchar(30) NOT NULL,
  `datePresence` date NOT NULL,
  `heureEntree` time NOT NULL,
  `heureSorti` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE `produit` (
  `idProduit` int(11) NOT NULL,
  `idEchProduit` int(11) NOT NULL,
  `idFournisseur` int(11) NOT NULL,
  `prixUnitaire` double NOT NULL,
  `quantite` int(11) NOT NULL,
  `dateFab` date NOT NULL,
  `dateExp` date NOT NULL,
  `codebar` bigint(20) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`idProduit`, `idEchProduit`, `idFournisseur`, `prixUnitaire`, `quantite`, `dateFab`, `dateExp`, `codebar`) VALUES
(9, 8, 2, 500, 10, '2019-04-06', '2019-04-12', 8791920021009),
(21, 2, 1, 500, 5, '2019-04-11', '2019-04-13', 6001087370431);

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

DROP TABLE IF EXISTS `service`;
CREATE TABLE `service` (
  `idService` int(11) NOT NULL,
  `libelle` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `structureaffilier`
--

DROP TABLE IF EXISTS `structureaffilier`;
CREATE TABLE `structureaffilier` (
  `id` int(11) NOT NULL,
  `raisonsociale` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `responsable` varchar(90) NOT NULL,
  `adresse` text NOT NULL,
  `contact` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `structureaffilier`
--

INSERT INTO `structureaffilier` (`id`, `raisonsociale`, `responsable`, `adresse`, `contact`) VALUES
(1, 'MDE SERVICES COMPUTER', '', 'Boulevard du 30 juin N°505527', ''),
(2, 'Cartel Computing', '', 'Middle technology N°77', ''),
(3, 'MDE Services', 'Mde services', 'eret', '+243822385571');

-- --------------------------------------------------------

--
-- Structure de la table `traitement_administre`
--

DROP TABLE IF EXISTS `traitement_administre`;
CREATE TABLE `traitement_administre` (
  `id` int(11) NOT NULL,
  `id_acte_pose` int(11) NOT NULL,
  `id_infirmier` int(11) NOT NULL,
  `observation` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `used_element_for_treatement`
--

DROP TABLE IF EXISTS `used_element_for_treatement`;
CREATE TABLE `used_element_for_treatement` (
  `id` int(11) NOT NULL,
  `id_ttm_admin` int(11) NOT NULL,
  `inside` varchar(1) NOT NULL DEFAULT '1',
  `produit` varchar(90) NOT NULL,
  `id_article` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `pwd` varchar(150) NOT NULL,
  `category` enum('agent','user','admin','') NOT NULL DEFAULT 'agent',
  `sous_category` enum('0','1','2','3','4') NOT NULL,
  `allowed` int(1) NOT NULL DEFAULT '0',
  `code` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `pwd`, `category`, `sous_category`, `allowed`, `code`) VALUES
(15, 'brandon.ekoto', '$2y$10$REgDo2ywPXIJFq/Ta5Y3r.sn8pCdVcnsl59TeXG6k8XBhX39gmfKa', 'agent', '2', 0, '0GPyF2SWACofYbcRzpQDJl57VVPvxDOAGJLgrmhLWK7IlnNfqw5rsI86QnSb9B3pZgzYiqoj1wmKNiBajxTtc4CyZMRvHk4dE6XsOXFahH1MT08e3dtk2Ee9');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `acte`
--
ALTER TABLE `acte`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_acte_parent` (`id_category`);

--
-- Index pour la table `acte_pose`
--
ALTER TABLE `acte_pose`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_acte` (`id_acte`),
  ADD KEY `id_patient` (`id_patient`),
  ADD KEY `id_agent` (`id_agent`);

--
-- Index pour la table `agent`
--
ALTER TABLE `agent`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_user_2` (`id_user`),
  ADD KEY `id_avatar` (`id_avatar`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `fonction` (`fonction`);

--
-- Index pour la table `agent_family`
--
ALTER TABLE `agent_family`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idAgent` (`idAgent`);

--
-- Index pour la table `agent_horaire`
--
ALTER TABLE `agent_horaire`
  ADD PRIMARY KEY (`idAgent`,`idHoraire`),
  ADD KEY `idHoraire` (`idHoraire`);

--
-- Index pour la table `category_acte`
--
ALTER TABLE `category_acte`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `chambre`
--
ALTER TABLE `chambre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `consultation`
--
ALTER TABLE `consultation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idActe` (`id_acte`);

--
-- Index pour la table `diagnostic`
--
ALTER TABLE `diagnostic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_acte` (`id_acte`),
  ADD KEY `id_agent` (`id_agent`);

--
-- Index pour la table `download`
--
ALTER TABLE `download`
  ADD PRIMARY KEY (`id_download`),
  ADD UNIQUE KEY `filename` (`filename`);

--
-- Index pour la table `echproduit`
--
ALTER TABLE `echproduit`
  ADD PRIMARY KEY (`idEchProduit`),
  ADD KEY `idCategorie` (`idCategorie`);

--
-- Index pour la table `element_prescrit`
--
ALTER TABLE `element_prescrit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_prescription` (`id_prescription`);

--
-- Index pour la table `examens`
--
ALTER TABLE `examens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcategory` (`idcategory`);

--
-- Index pour la table `examen_recommand`
--
ALTER TABLE `examen_recommand`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_examen` (`id_examen`),
  ADD KEY `id_acte` (`id_diagnostic`),
  ADD KEY `id_agent_labo` (`id_agent_labo`),
  ADD KEY `id_acte_2` (`id_acte`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`numRef`);

--
-- Index pour la table `facture_produit`
--
ALTER TABLE `facture_produit`
  ADD PRIMARY KEY (`idProduit`,`idFacture`),
  ADD KEY `idFacture` (`idFacture`);

--
-- Index pour la table `fonction`
--
ALTER TABLE `fonction`
  ADD PRIMARY KEY (`idFonction`);

--
-- Index pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  ADD PRIMARY KEY (`idFournisseur`);

--
-- Index pour la table `horaire`
--
ALTER TABLE `horaire`
  ADD KEY `idHoraire` (`idHoraire`);

--
-- Index pour la table `hospitalisation`
--
ALTER TABLE `hospitalisation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_acte` (`id_acte`),
  ADD KEY `id_agent` (`id_agent`),
  ADD KEY `id_local` (`id_lit`);

--
-- Index pour la table `lit`
--
ALTER TABLE `lit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_chambre` (`id_chambre`);

--
-- Index pour la table `lot`
--
ALTER TABLE `lot`
  ADD PRIMARY KEY (`idLot`);

--
-- Index pour la table `lot_produit`
--
ALTER TABLE `lot_produit`
  ADD PRIMARY KEY (`idLot_produit`),
  ADD KEY `fk_idLot` (`idLot`),
  ADD KEY `fk_idProduit` (`idProduit`);

--
-- Index pour la table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`idPatient`),
  ADD KEY `email` (`email`),
  ADD KEY `idAvatar` (`id_avatar`);

--
-- Index pour la table `personne_affilie`
--
ALTER TABLE `personne_affilie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idPatient` (`id_patient`),
  ADD KEY `id_structure` (`id_structure`);

--
-- Index pour la table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idActe` (`idActe`);

--
-- Index pour la table `presence`
--
ALTER TABLE `presence`
  ADD PRIMARY KEY (`idPresence`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`idProduit`),
  ADD KEY `fk_idEchProduit` (`idEchProduit`),
  ADD KEY `fk_idFournisseur` (`idFournisseur`),
  ADD KEY `codebar` (`codebar`);

--
-- Index pour la table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`idService`);

--
-- Index pour la table `structureaffilier`
--
ALTER TABLE `structureaffilier`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `traitement_administre`
--
ALTER TABLE `traitement_administre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_infirmier` (`id_infirmier`),
  ADD KEY `id_acte_pose` (`id_acte_pose`);

--
-- Index pour la table `used_element_for_treatement`
--
ALTER TABLE `used_element_for_treatement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ttm_admin` (`id_ttm_admin`),
  ADD KEY `id_article` (`id_article`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `acte`
--
ALTER TABLE `acte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `acte_pose`
--
ALTER TABLE `acte_pose`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `agent`
--
ALTER TABLE `agent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT pour la table `agent_family`
--
ALTER TABLE `agent_family`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `category_acte`
--
ALTER TABLE `category_acte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `chambre`
--
ALTER TABLE `chambre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `consultation`
--
ALTER TABLE `consultation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pour la table `diagnostic`
--
ALTER TABLE `diagnostic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `download`
--
ALTER TABLE `download`
  MODIFY `id_download` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT pour la table `echproduit`
--
ALTER TABLE `echproduit`
  MODIFY `idEchProduit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `element_prescrit`
--
ALTER TABLE `element_prescrit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `examens`
--
ALTER TABLE `examens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `examen_recommand`
--
ALTER TABLE `examen_recommand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
  MODIFY `numRef` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `fonction`
--
ALTER TABLE `fonction`
  MODIFY `idFonction` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  MODIFY `idFournisseur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `horaire`
--
ALTER TABLE `horaire`
  MODIFY `idHoraire` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `lit`
--
ALTER TABLE `lit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `lot`
--
ALTER TABLE `lot`
  MODIFY `idLot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `lot_produit`
--
ALTER TABLE `lot_produit`
  MODIFY `idLot_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT pour la table `patient`
--
ALTER TABLE `patient`
  MODIFY `idPatient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `personne_affilie`
--
ALTER TABLE `personne_affilie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `presence`
--
ALTER TABLE `presence`
  MODIFY `idPresence` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `idProduit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT pour la table `service`
--
ALTER TABLE `service`
  MODIFY `idService` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `structureaffilier`
--
ALTER TABLE `structureaffilier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `traitement_administre`
--
ALTER TABLE `traitement_administre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `used_element_for_treatement`
--
ALTER TABLE `used_element_for_treatement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `acte`
--
ALTER TABLE `acte`
  ADD CONSTRAINT `acte_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category_acte` (`id`);

--
-- Contraintes pour la table `acte_pose`
--
ALTER TABLE `acte_pose`
  ADD CONSTRAINT `acte_pose_ibfk_1` FOREIGN KEY (`id_acte`) REFERENCES `acte` (`id`),
  ADD CONSTRAINT `acte_pose_ibfk_2` FOREIGN KEY (`id_agent`) REFERENCES `agent` (`id`),
  ADD CONSTRAINT `acte_pose_ibfk_3` FOREIGN KEY (`id_patient`) REFERENCES `patient` (`idPatient`);

--
-- Contraintes pour la table `agent`
--
ALTER TABLE `agent`
  ADD CONSTRAINT `agent_ibfk_1` FOREIGN KEY (`fonction`) REFERENCES `fonction` (`idFonction`);

--
-- Contraintes pour la table `agent_horaire`
--
ALTER TABLE `agent_horaire`
  ADD CONSTRAINT `agent_horaire_ibfk_1` FOREIGN KEY (`idAgent`) REFERENCES `agent` (`id`),
  ADD CONSTRAINT `agent_horaire_ibfk_2` FOREIGN KEY (`idHoraire`) REFERENCES `horaire` (`idHoraire`);

--
-- Contraintes pour la table `consultation`
--
ALTER TABLE `consultation`
  ADD CONSTRAINT `consultation_ibfk_1` FOREIGN KEY (`id_acte`) REFERENCES `acte_pose` (`id`);

--
-- Contraintes pour la table `diagnostic`
--
ALTER TABLE `diagnostic`
  ADD CONSTRAINT `diagnostic_ibfk_1` FOREIGN KEY (`id_acte`) REFERENCES `acte_pose` (`id`),
  ADD CONSTRAINT `diagnostic_ibfk_2` FOREIGN KEY (`id_agent`) REFERENCES `agent` (`id`);

--
-- Contraintes pour la table `echproduit`
--
ALTER TABLE `echproduit`
  ADD CONSTRAINT `echproduit_ibfk_1` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`idCategorie`);

--
-- Contraintes pour la table `element_prescrit`
--
ALTER TABLE `element_prescrit`
  ADD CONSTRAINT `element_prescrit_ibfk_1` FOREIGN KEY (`id_prescription`) REFERENCES `prescription` (`id`);

--
-- Contraintes pour la table `examen_recommand`
--
ALTER TABLE `examen_recommand`
  ADD CONSTRAINT `examen_recommand_ibfk_1` FOREIGN KEY (`id_examen`) REFERENCES `examens` (`id`),
  ADD CONSTRAINT `examen_recommand_ibfk_2` FOREIGN KEY (`id_agent_labo`) REFERENCES `agent` (`id`),
  ADD CONSTRAINT `examen_recommand_ibfk_3` FOREIGN KEY (`id_diagnostic`) REFERENCES `diagnostic` (`id`);

--
-- Contraintes pour la table `facture_produit`
--
ALTER TABLE `facture_produit`
  ADD CONSTRAINT `facture_produit_ibfk_1` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`idProduit`),
  ADD CONSTRAINT `facture_produit_ibfk_2` FOREIGN KEY (`idFacture`) REFERENCES `facture` (`numRef`);

--
-- Contraintes pour la table `hospitalisation`
--
ALTER TABLE `hospitalisation`
  ADD CONSTRAINT `hospitalisation_ibfk_1` FOREIGN KEY (`id_lit`) REFERENCES `lit` (`id`);

--
-- Contraintes pour la table `lit`
--
ALTER TABLE `lit`
  ADD CONSTRAINT `lit_ibfk_1` FOREIGN KEY (`id_chambre`) REFERENCES `chambre` (`id`);

--
-- Contraintes pour la table `lot_produit`
--
ALTER TABLE `lot_produit`
  ADD CONSTRAINT `fk_idLot` FOREIGN KEY (`idLot`) REFERENCES `lot` (`idLot`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idProduit` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`idProduit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`id_avatar`) REFERENCES `download` (`id_download`);

--
-- Contraintes pour la table `prescription`
--
ALTER TABLE `prescription`
  ADD CONSTRAINT `prescription_ibfk_1` FOREIGN KEY (`idActe`) REFERENCES `acte_pose` (`id`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `fk_idEchProduit` FOREIGN KEY (`idEchProduit`) REFERENCES `echproduit` (`idEchProduit`),
  ADD CONSTRAINT `fk_idFournisseur` FOREIGN KEY (`idFournisseur`) REFERENCES `fournisseur` (`idFournisseur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
