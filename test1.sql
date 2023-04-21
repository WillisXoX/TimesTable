-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2022 at 08:22 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test1`
--

-- --------------------------------------------------------

--
-- Table structure for table `cours`
--

CREATE TABLE `cours` (
  `codeFiliere` varchar(10) NOT NULL,
  `codeNiveau` varchar(20) NOT NULL,
  `codeCours` varchar(10) NOT NULL,
  `nomCours` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cours`
--

INSERT INTO `cours` (`codeFiliere`, `codeNiveau`, `codeCours`, `nomCours`) VALUES
('BIO', 'L2', 'BIO2054', 'BIO2054'),
('BIO', 'L2', 'BIO2064', 'BIO2064'),
('BIO', 'L2', 'BIO2074', 'BIO2074'),
('BIO', 'L2', 'PPE2004', 'PPE2004'),
('BIO', 'L3', 'BCH3056', 'BCH3056'),
('BIO', 'L3', 'BCH3066', 'BCH3066'),
('BIO', 'L3', 'BCH3076', 'BCH3076'),
('BIO', 'L3', 'BCH3086', 'BCH3086'),
('BIO', 'L3', 'BCH3096', 'BCH3096'),
('BIO', 'L3', 'BCH3106', 'BCH3106'),
('BIO', 'L3', 'BCH3116', 'BCH3116'),
('BIO', 'L3', 'BIO3056', 'BIO3056'),
('BIO', 'L3', 'BIO3066', 'BIO3066'),
('BIO', 'L3', 'BIO3076', 'BIO3076'),
('BIO', 'L3', 'BIO3086', 'BIO3086'),
('BIO', 'L3', 'BIO3096', 'BIO3096'),
('CHM', 'L2', 'CHM2083', 'CHM2083');

-- --------------------------------------------------------

--
-- Table structure for table `enseignant`
--

CREATE TABLE `enseignant` (
  `codeEnseignant` varchar(10) NOT NULL,
  `nomEnseignant` varchar(20) NOT NULL,
  `prenomEnseignant` varchar(20) NOT NULL,
  `adresseEnseignant` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enseignant`
--

INSERT INTO `enseignant` (`codeEnseignant`, `nomEnseignant`, `prenomEnseignant`, `adresseEnseignant`) VALUES
('ATOCHO', 'ATOCHO', 'DJUIDJE', 'CAMEROUN-YAOUNDE'),
('BOUDJEKO', 'BOUDJEKO', 'ACHU', 'CAMEROUN-YAOUNDE'),
('DJIETO', 'DJIETO', 'TADU YEDE', 'CAMEROUN-YAOUNDE'),
('DJIGOUE', 'DJIGOUE', 'MEGNEKOU', 'CAMEROUN-YAOUNDE'),
('DJOCGOUE', 'DJOCGOUE', 'NGONKEU', 'CAMEROUN-YAOUNDE'),
('DZEUFIET', 'DZEUFIET', 'TAN', 'CAMEROUN-YAOUNDE'),
('FOKOU', 'FOKOU', 'ACHU', 'CAMEROUN-YAOUNDE'),
('KANSCI', 'KANSCI', 'KANSCI', 'CAMEROUN-YAOUNDE'),
('MEGNEKOU', 'MEGNEKOU', 'NGOUATEU', 'CAMEROUN-YAOUNDE'),
('MONY', 'MONY', 'TADU MVEYO', 'CAMEROUN-YAOUNDE'),
('NDOYE', 'NDOYE', 'NDOYE', 'CAMEROUN-YAOUNDE'),
('NGO', 'NGO', 'MBING', 'CAMEROUN-YAOUNDE'),
('NGOUNOUE', 'NGOUNOUE', 'NGUEGUIM BILANDA', 'CAMEROUN-YAOUNDE'),
('NGUEMBOCK', 'NGUEMBOCK', 'TADU', 'CAMEROUN-YAOUNDE'),
('NJAYOU', 'NJAYOU', 'NJAYOU', 'CAMEROUN-YAOUNDE');

-- --------------------------------------------------------

--
-- Table structure for table `filiere`
--

CREATE TABLE `filiere` (
  `codeFiliere` varchar(10) NOT NULL,
  `nomFiliere` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `filiere`
--

INSERT INTO `filiere` (`codeFiliere`, `nomFiliere`) VALUES
('BIO', 'Biologie'),
('CHM', ' Chemie');

-- --------------------------------------------------------

--
-- Table structure for table `niveau`
--

CREATE TABLE `niveau` (
  `codeFiliere` varchar(10) NOT NULL,
  `codeNiveau` varchar(10) NOT NULL,
  `nomNiveau` varchar(20) NOT NULL,
  `effectif` int(10) NOT NULL,
  `specialite` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `niveau`
--

INSERT INTO `niveau` (`codeFiliere`, `codeNiveau`, `nomNiveau`, `effectif`, `specialite`) VALUES
('BIO', 'L2', 'LICENSE 2', 1000, 0),
('BIO', 'L3', 'LICENSE 3', 1000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `plage`
--

CREATE TABLE `plage` (
  `codeFiliere` varchar(10) NOT NULL,
  `codeNiveau` varchar(20) NOT NULL,
  `codeSpecialite` varchar(10) DEFAULT NULL,
  `codeSalle` varchar(10) NOT NULL,
  `jour` varchar(10) NOT NULL,
  `heureDebut` time NOT NULL,
  `heureFin` time NOT NULL,
  `codeCours` varchar(10) NOT NULL,
  `codeEnseignant` varchar(10) NOT NULL,
  `nomGroupe` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plage`
--

INSERT INTO `plage` (`codeFiliere`, `codeNiveau`, `codeSpecialite`, `codeSalle`, `jour`, `heureDebut`, `heureFin`, `codeCours`, `codeEnseignant`, `nomGroupe`) VALUES
('BIO', 'L2', NULL, 'A1001', 'Lundi', '13:05:00', '15:55:00', 'BIO2054', 'DZEUFIET', 'GA'),
('BIO', 'L2', NULL, 'A1001', 'Lundi', '16:05:00', '18:55:00', 'BIO2064', 'DJOCGOUE', 'GA'),
('BIO', 'L2', NULL, 'A1001', 'Mardi', '13:05:00', '15:55:00', 'BIO2074', 'BOUDJEKO', 'GA'),
('BIO', 'L2', NULL, 'A1001', 'Mardi', '16:05:00', '18:55:00', 'CHM2083', 'NGO', 'GA'),
('BIO', 'L2', NULL, 'A1002', 'Lundi', '13:05:00', '15:55:00', 'BIO2054', 'DZEUFIET', 'GB'),
('BIO', 'L2', NULL, 'A1002', 'Lundi', '16:05:00', '18:55:00', 'BIO2064', 'DJOCGOUE', 'GB'),
('BIO', 'L2', NULL, 'A1002', 'Mardi', '13:05:00', '15:55:00', 'CHM2083', 'NGO', 'GB'),
('BIO', 'L2', NULL, 'A1002', 'Mardi', '16:05:00', '18:55:00', 'BIO2074', 'BOUDJEKO', 'GB'),
('BIO', 'L3', 'BCH', 'A1001', 'Jeudi', '10:56:00', '12:55:00', 'BCH3066', 'FOKOU', NULL),
('BIO', 'L3', 'BCH', 'A1001', 'Jeudi', '16:05:00', '20:55:00', 'BCH3056', 'ATOCHO', NULL),
('BIO', 'L3', 'BCH', 'A1001', 'Mercredi', '16:05:00', '18:55:00', 'BCH3056', 'ATOCHO', NULL),
('BIO', 'L3', 'BCH', 'A113', 'Vendredi', '10:05:00', '12:55:00', 'BCH3116', 'NJAYOU', NULL),
('BIO', 'L3', 'BCH', 'A250', 'Vendredi', '10:05:00', '12:55:00', 'BCH3106', 'BOUDJEKO', NULL),
('BIO', 'L3', 'BOA', 'A350', 'Lundi', '07:05:00', '09:55:00', 'BIO3076', 'DJIETO', NULL),
('BIO', 'L3', 'BOA', 'A350', 'Lundi', '10:05:00', '12:55:00', 'BIO3066', 'NGOUNOUE', NULL),
('BIO', 'L3', 'BOA', 'A350', 'Mardi', '13:05:00', '15:55:00', 'BIO3086', 'MONY', NULL),
('BIO', 'L3', 'BOA', 'A350', 'Mardi', '16:05:00', '18:55:00', 'BIO3056', 'NGUEMBOCK', NULL),
('BIO', 'L3', 'BOA', 'A350', 'Vendredi', '10:05:00', '12:55:00', 'BIO3096', 'MEGNEKOU', NULL),
('BIO', 'L3', 'BCH', 'A350', 'Vendredi', '13:05:00', '15:55:00', 'BCH3096', 'NDOYE', NULL),
('BIO', 'L3', 'BCH', 'R108', 'Jeudi', '07:05:00', '10:55:00', 'BCH3086', 'KANSCI', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `salle`
--

CREATE TABLE `salle` (
  `codeSalle` varchar(10) NOT NULL,
  `capacite` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `salle`
--

INSERT INTO `salle` (`codeSalle`, `capacite`) VALUES
('A1001', 1000),
('A1002', 1000),
('A113', 1000),
('A250', 1000),
('A350', 1000),
('POLY II', 1000),
('R108', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `specialite`
--

CREATE TABLE `specialite` (
  `codeFiliere` varchar(10) NOT NULL,
  `codeNiveau` varchar(10) NOT NULL,
  `codeSpecialite` varchar(10) NOT NULL,
  `nomSpecialite` varchar(20) NOT NULL,
  `effectif` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `specialite`
--

INSERT INTO `specialite` (`codeFiliere`, `codeNiveau`, `codeSpecialite`, `nomSpecialite`, `effectif`) VALUES
('BIO', 'L3', 'BCH', 'BIOCHIMIE', 1000),
('BIO', 'L3', 'BOA', 'BIOLOGIEANIMALE', 1000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`codeFiliere`,`codeNiveau`,`codeCours`);

--
-- Indexes for table `enseignant`
--
ALTER TABLE `enseignant`
  ADD PRIMARY KEY (`codeEnseignant`);

--
-- Indexes for table `filiere`
--
ALTER TABLE `filiere`
  ADD PRIMARY KEY (`codeFiliere`);

--
-- Indexes for table `niveau`
--
ALTER TABLE `niveau`
  ADD PRIMARY KEY (`codeFiliere`,`codeNiveau`);

--
-- Indexes for table `plage`
--
ALTER TABLE `plage`
  ADD PRIMARY KEY (`codeFiliere`,`codeNiveau`,`codeSalle`,`jour`,`heureDebut`,`heureFin`) USING BTREE;

--
-- Indexes for table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`codeSalle`);

--
-- Indexes for table `specialite`
--
ALTER TABLE `specialite`
  ADD PRIMARY KEY (`codeFiliere`,`codeNiveau`,`codeSpecialite`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
