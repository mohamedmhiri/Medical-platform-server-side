-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 24, 2016 at 04:07 PM
-- Server version: 10.1.14-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `doctors`
--

-- --------------------------------------------------------

--
-- Table structure for table `antecedent`
--

CREATE TABLE IF NOT EXISTS `antecedent` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `allergies` longtext COLLATE utf8_unicode_ci,
  `autres` longtext COLLATE utf8_unicode_ci,
  `traitement` longtext COLLATE utf8_unicode_ci,
  `chirurgicaux` longtext COLLATE utf8_unicode_ci,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `antecedent`
--

INSERT INTO `antecedent` (`id`, `person_id`, `allergies`, `autres`, `traitement`, `chirurgicaux`, `type`) VALUES
(1, 1, 'ALLERGIE À LA PÉNICILLINE', 'Hypertension artérielle depuis 4 ans, traitée, valeur habituelle 140/85\r\nPas d’hypercholestérolémie, pas de diabète, pas d’autres antécédents, pas \r\nd’opérations.', NULL, NULL, 'Antecedents personnels'),
(2, 2, 'Intolérance au gluten\r\nHypertension artérielle (1975) \r\nHypercholestérolémie (1983) \r\nDiabète de type 2', NULL, NULL, 'Appendicectomie (1946)', 'Antecedents personnels'),
(3, 3, NULL, 'Parents encore en vie, 85 ans, en bonne santé\r\nSœur de 50 ans en bonne santé\r\nOncle décédé d’une mort subite à l’âge de 58 ans\r\nEnfants en bonne santé', NULL, NULL, 'Antecedents familiaux'),
(4, 5, 'allergies', '123 aazasas', NULL, NULL, 'Antecedents personnels'),
(5, 9, 'aza', 'az', NULL, NULL, 'Antecedents familiaux');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `validUntil` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `isValid` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL,
  `the_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `the_value` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `the_key`, `the_value`) VALUES
(1, 'app_logo', 'uploads/img/af28c5cce7fd0c1de575c139fedf7ccda7e8bad6.png'),
(2, 'app_name', 'ONOUSC'),
(3, 'app_description', 'description :)'),
(4, 'app_address', 'lot charaf salé'),
(5, 'app_cp', '11060'),
(6, 'app_city', 'RABAT'),
(7, 'app_tel', '0644435561'),
(8, 'app_gsm', '056515214'),
(9, 'app_email', 'onousc@gmail.com'),
(10, 'app_website', 'http://onousc.com'),
(11, 'app_map_lat', '33'),
(12, 'app_map_lng', '33'),
(13, 'app_lang', 'en_US'),
(14, 'rows_per_page', '10'),
(15, 'app_css', '/* css */'),
(16, 'allow_registration', 'on'),
(17, 'defaut_logement', '1');

-- --------------------------------------------------------

--
-- Table structure for table `consultation`
--

CREATE TABLE IF NOT EXISTS `consultation` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `doc_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `infrastructure` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` date NOT NULL,
  `diagnosis` longtext COLLATE utf8_unicode_ci,
  `treatment` longtext COLLATE utf8_unicode_ci,
  `motiftype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `decision` longtext COLLATE utf8_unicode_ci,
  `chronic` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `consultation`
--

INSERT INTO `consultation` (`id`, `person_id`, `doc_id`, `name`, `type`, `infrastructure`, `created`, `diagnosis`, `treatment`, `motiftype`, `decision`, `chronic`) VALUES
(1, 1, 1, 'visite medicale', 'Consultation generale', NULL, '2014-08-25', 'Jaundice', 'Traitement préscrit', 'EXAMEN MEDICAL SYSTEMATIQUE', 'Décision prise', 1),
(2, 1, 1, 'Dermato', 'Consultation spécialisé', 'CHU', '2014-08-25', 'Alopecia', 'ODRIK 2 mg : une gélule par jour - Q.S.P. 1 mois \r\nDIAMICRON 30 mg : 1 comp. le matin - Q.S.P. 1 mois', 'EXAMEN MEDICAL SYSTEMATIQUE', NULL, 0),
(3, 2, 1, 'Examen medical', 'Consultation generale', NULL, '2014-08-26', 'Jaundice', 'pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'EXAMEN MEDICAL SYSTEMATIQUE', NULL, 0),
(4, 1, 4, 'consultation #13', 'Consultation generale', NULL, '2014-08-27', 'Bronchitis,Allergy', 'I''ve got the program to write to and save a .txt file however I''m having some trouble reading from .txt files.', 'CONSULTATION MEDICALE A LA DEMANDE', 'decision prise', 1),
(5, 3, 4, 'Examen medical', 'Consultation generale', NULL, '2014-08-28', 'Amblyopia', 'Traitement préscrit', 'EXAMEN MEDICAL SYSTEMATIQUE', NULL, 0),
(6, 1, 1, 'Examen medical', 'Consultation generale', NULL, '2014-08-28', 'Alzheimer''s disease', NULL, 'EXAMEN MEDICAL SYSTEMATIQUE', NULL, 0),
(7, 5, 1, 'motif 3', 'Consultation generale', NULL, '2014-09-12', 'Angines,Stress', 'aeaea', 'EXAMEN MEDICAL SYSTEMATIQUE', NULL, 0),
(8, 6, 4, 'consultation #1', 'Consultation generale', NULL, '2014-09-14', 'Allergy,Breast cancer', 'Traitement préscrit', 'CONSULTATION MEDICALE A LA DEMANDE', 'la Décision prise', 1),
(10, 8, 1, 'Specialité #1', 'Consultation spécialisé', 'Centre de diagnostic', '2014-09-18', 'Caries dentaires', 'Traitement préscrit #1\r\nTraitement préscrit #2', NULL, NULL, NULL),
(11, 9, 1, 'Certificat de bonne santé', 'Consultation generale', NULL, '2014-09-18', 'Angines,Caries dentaires', 'Traitement préscrit', 'EXAMEN MEDICAL SYSTEMATIQUE', 'Décision prise', 1);

-- --------------------------------------------------------

--
-- Table structure for table `consultation_meds`
--

CREATE TABLE IF NOT EXISTS `consultation_meds` (
  `id` int(11) NOT NULL,
  `consultation_id` int(11) NOT NULL,
  `meds_id` int(11) NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `consultation_meds`
--

INSERT INTO `consultation_meds` (`id`, `consultation_id`, `meds_id`, `count`) VALUES
(1, 1, 5, 2),
(3, 10, 1, 2),
(4, 11, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `validuntil` datetime DEFAULT NULL,
  `isvalid` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `password`, `validuntil`, `isvalid`) VALUES
(112, 'admin', '??H?t\Z"??ZE?C??v?2???yu???R?\Z???E0??hD??j?0?^??U', '2016-08-23 10:35:04', 0),
(113, 'admin', '?_\Z?LgD?!?l?	????er?A.z???&?b?<?????s6??%?????fm', '2016-08-23 10:39:46', 0),
(114, 'admin', '''m?#b^/7??V4??L?\n(???]C9I???r??@???.?????z?''k1]?U???', '2016-08-23 10:42:54', 0),
(115, 'admin', '&?q?V"??H9??K4??b7L;??\0???/??yp<???4b?2m?Q9wT???c??', '2016-08-23 10:49:54', 0),
(116, 'admin', '? ????V??^???G~L??&Z?#d?''?b?&??_j???|;)?C*?W???Q?Q??', '2016-08-23 10:59:36', 0),
(117, 'admin', '{?m?q?w??:?%??ul?Z????_?:}?_hl??V?.!{6?t?5?C>n?Q?W??B', '2016-08-23 11:20:31', 0),
(118, 'admin', '9??86~?b8}1?T??~%?!??\n??%??p??S??6X??=T??&?3??m??[', '2016-08-23 11:22:42', 0),
(119, 'admin', '?^]i|:??Q?3????(1\\+Tm]?v??6????8??x?y-?Q?L)r??x', '2016-08-23 12:38:13', 0),
(120, 'admin', '?P??mQ?[????L??????rt?E??t???????X??h?=k??v"jWv???i', '2016-08-23 12:44:48', 0),
(121, 'admin', '?Z8y????"?M?O???KdB????}?=?8??N?8??7h''?h?Daig?L?*?T?j?', '2016-08-23 12:57:27', 0),
(122, 'admin', '?Y?v?w??!P????S??M4????p?#??F???7{??lT????@?k?!?', '2016-08-23 13:00:27', 0),
(123, 'admin', '0j??\Z?~^??^$/?K??q??b-~????bV???f???*7D?$n3?', '2016-08-23 13:28:53', 0),
(124, 'admin', '[#?T$?XY???>?`??????.OAA?N8&??????u?K???r??@?!???', '2016-08-23 21:27:43', 0),
(125, 'admin', '???nS?t>??~\r??d???+H2N\r;?6?fM?$?^H???z?O??a"????D', '2016-08-24 09:14:38', 0),
(126, 'admin', '\rK$?u??T?V@y<0?q0z?Lc?V,|U}Q#?\0?Oj,S?=\\??C?Y??V)?L?|?K?', '2016-08-24 10:28:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `path`) VALUES
(2, 'anonymous.png'),
(4, 'anonymous.png'),
(5, 'anonymous.png');

-- --------------------------------------------------------

--
-- Table structure for table `meds`
--

CREATE TABLE IF NOT EXISTS `meds` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `count` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `about` longtext COLLATE utf8_unicode_ci,
  `created` datetime NOT NULL,
  `expdate` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `meds`
--

INSERT INTO `meds` (`id`, `name`, `count`, `type`, `about`, `created`, `expdate`) VALUES
(1, 'lisinopril oral', 5, 'Hypertension Drugs', 'High Blood Pressure Hypertension', '2014-09-01 12:36:49', '2015-09-01'),
(2, 'hydrochlorothiazide oral', 15, 'Hypertension Drugs', 'Uses\r\nThis medication is used to treat high blood pressure. Lowering high blood pressure helps prevent strokes, heart attacks, and kidney problems. Hydrochlorothiazide is a "water pill" (diuretic) that causes you to make more urine. This helps your body get rid of extra salt and water.', '2014-09-01 12:36:49', '2015-09-01'),
(3, 'OxyContin', 28, 'breathing problems', 'Uses\r\nThis medication is used to help relieve moderate to severe ongoing pain (such as due to cancer). Oxycodone belongs to a class of drugs known as narcotic (opiate) analgesics. It works in the brain to change how your body feels and responds to pain.', '2014-09-01 12:36:49', '2015-09-01'),
(4, 'Anti-inflammatoires', 0, 'Dermatologie', 'les traitements anti-douleurs.', '2014-09-01 12:36:49', '2015-09-01'),
(5, 'Doliprane', 25, 'Traitement', 'AUTRES ANALGESIQUES et ANTIPYRETIQUES-ANILIDES, Code ATC: N02BE01. N: Syst├¿me nerveux central.', '2014-09-01 12:36:49', '2015-09-01'),
(6, 'meds#1', 10, 'Dermatologie', 'nop', '2014-09-01 12:36:49', '2015-09-01'),
(7, 'aspirine', 50, 'Traitement', 'a', '2014-09-01 12:36:49', '2014-09-01');

-- --------------------------------------------------------

--
-- Table structure for table `metadata`
--

CREATE TABLE IF NOT EXISTS `metadata` (
  `id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `thekey` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thevalue` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `id` int(11) NOT NULL,
  `cin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cne` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `familyname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oldemail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` date NOT NULL,
  `birthcity` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contry` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gsm` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cnsstype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_gsm` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_fixe` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resident` tinyint(1) NOT NULL,
  `handicap` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `needs` longtext COLLATE utf8_unicode_ci,
  `ishandicap` tinyint(1) DEFAULT NULL,
  `created` datetime NOT NULL,
  `isnp` tinyint(1) DEFAULT '0',
  `npid` int(11) DEFAULT '-5'
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id`, `cin`, `cne`, `firstname`, `familyname`, `email`, `oldemail`, `birthday`, `birthcity`, `gender`, `contry`, `city`, `address`, `gsm`, `cnsstype`, `parent_name`, `parent_address`, `parent_gsm`, `parent_fixe`, `resident`, `handicap`, `needs`, `ishandicap`, `created`, `isnp`, `npid`) VALUES
(1, 'ae60550', '1028605605', 'adil', 'harbouj', 'Mohamed@gmail.com', NULL, '1992-08-25', 'rabat', 'Masculin', 'maroc', 'salé', 'rue 12, ain chok n52 casablanca', '0644432821', 'Cnss', 'omar Mhiri', 'rue 12, ain chok n52 casablanca', '0666343755', '0534521568', 1, 'handicap', 'besoin 1\r\nbesoin 2', 1, '2014-08-28 00:00:00', 0, -5),
(2, 'ae60561', '10284605605', 'adnan', 'yassir', 'Mohamed@gmail.com', NULL, '1992-03-04', 'rabat', 'Masculin', 'maroc', 'Rabat', 'lot charaf n42 salé', '0644432821', 'Ramed', 'inssaf chahid', 'lot charaf n42 salé', '0666343755', '0534521568', 1, NULL, NULL, 0, '2014-08-28 00:00:00', 0, -5),
(3, 'ae60786', '1028605615', 'basma', 'nahal', 's.nahal@gmail.com', NULL, '1993-08-25', 'taza', 'Féminin', 'maroc', 'casablanca', 'lot charaf n42 salé', '0644432821', 'Cnss', 'rfikh najad', 'rue 12, ain chok n52 casablanca', '0666343755', '0534521568', 1, NULL, NULL, NULL, '2014-08-28 00:00:00', 0, -5),
(4, 'EZ4562', '1028605611', 'nacer', 'chahid', 's.nahal@gmail.com', NULL, '1993-08-25', 'rabat', 'Masculin', 'maroc', 'salé', 'rue 12, ain chok n52 casablanca', '0644432821', 'Cnss', 'inssaf chahid', 'rue 12, ain chok n52 casablanca', '06452215452', '0534521568', 1, NULL, NULL, NULL, '2014-08-28 00:00:00', 0, -5),
(5, 'Z4520', '1028456512', 'azziz', 'amrabet', 'azziz-amrabet@gmail.com', NULL, '1990-09-12', 'salé', 'Masculin', 'maroc', 'Rabat', 'rabat hay riad block 45 rue araar', '0666343745', 'Cnss', 'omar amrabet', 'lot charaf n42 salé', '0666645946', '0537546512', 1, NULL, NULL, NULL, '2014-08-28 00:00:00', 0, -5),
(6, 'ae605500', '10286205605', 'ahlame', 'isnaki', 'ahlame@gmail.com', NULL, '1993-09-14', 'rabat', 'Féminin', 'maroc', 'Rabat', 'rue 12, ain chok n52 casablanca', '0644432821', 'Assurance privé', 'nasiiri falah', 'rue 12, ain chok n52 casablanca', '0666343755', '0534521568', 0, NULL, NULL, 0, '2014-09-14 21:08:46', 0, -5),
(8, 'ae60542', '1228605605', 'fadwa', 'mrabet', 'fadwa95@gmail.com', NULL, '1995-09-18', 'Taza', 'Féminin', 'maroc', 'Rabat', 'rue 12, ain chok n52 casablanca', '0644432821', 'Cnss', 'hassan mrabet', 'rue 12, ain chok n52 casablanca', '0666343755', '0537521568', 1, NULL, NULL, 0, '2014-09-18 12:33:52', 0, -5),
(9, 'ae60552', '1028605625', 'adil', 'harbouj', 'Mohamed@gmail.com', NULL, '1992-09-18', 'rabat', 'Masculin', 'maroc', 'salé', 'rue 12, ain chok n52 casablanca', '0644432821', 'Cnss', 'omar Mhiri', 'rue 12, ain chok n52 casablanca', '0666343755', '0534521568', 1, NULL, NULL, 0, '2014-09-18 15:33:47', 0, -5),
(10, ' ', ' ', 'Todd', 'Megatron', 'transformers@eye.io', 'transformers@eye.io', '2016-08-08', NULL, ' ', NULL, NULL, NULL, '5555555555', ' ', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2016-08-08 10:03:01', 1, 2),
(11, '14758245', '', 'mohamed', 'mhiri', NULL, NULL, '1994-04-19', 'tunis', 'Masculin', 'tunisienne', NULL, 'tunis', '1111111111', 'Cnam', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, '2016-08-08 16:56:14', NULL, NULL),
(12, ' ', '', 'mhiri', 'omar', 'omar@gmail.com', 'lightmoon@gmail.com', '2016-08-09', NULL, ' ', NULL, NULL, NULL, '52154875', ' ', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2016-08-09 17:30:17', 1, 3),
(13, ' ', '', 'feki', 'maryem', 'maryem@gmail.com', 'maryem@gmail.com', '2016-08-10', NULL, ' ', NULL, NULL, NULL, '6546165464', ' ', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2016-08-10 12:45:28', 1, 4),
(14, ' ', '', 'Joe', 'Danger', 'koubaa@gmail.com', 'koubaa@gmail.com', '2016-08-11', NULL, ' ', NULL, NULL, NULL, '6666666666', ' ', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2016-08-11 12:15:51', 1, 1),
(15, ' ', '', 'light', 'moon', 'lightmoon@gmail.com', 'lightmoon@gmail.com', '2016-08-19', NULL, ' ', NULL, NULL, NULL, '54548585', ' ', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2016-08-19 06:24:43', 1, 3),
(16, '1457866524', '', 'louati', 'awatef', NULL, NULL, '2016-08-23', 'tunis', 'Masculin', 'tunisienne', NULL, NULL, '215485852', 'Cnam', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, '2016-08-23 08:17:07', NULL, NULL),
(17, ' ', '', 'seif', 'mahmoud', 'seif@gmail.com', 'seif@gmail.com', '2016-08-23', NULL, ' ', NULL, NULL, NULL, '5555555555', ' ', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2016-08-23 12:44:47', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL,
  `consultation_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `taille` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `poids` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ta` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `od` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `og` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `request` longtext COLLATE utf8_unicode_ci,
  `result` longtext COLLATE utf8_unicode_ci,
  `hasvisualissue` tinyint(1) DEFAULT NULL,
  `fixedvisualissue` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `consultation_id`, `type`, `taille`, `poids`, `ta`, `od`, `og`, `request`, `result`, `hasvisualissue`, `fixedvisualissue`) VALUES
(1, 1, 'Examen Générale', '1.75', '65', '13', '9', '10', NULL, NULL, 0, '0'),
(2, 1, 'Examens biologiques', NULL, NULL, NULL, NULL, NULL, 'Glycémie, Créatinine, Calcémie', 'Glycémie	1.10	(g/l : 0,70-1,10)	\r\nCréatinine	9.5	(mg/l : 5,6-11,3)	\r\nNatrémie	143	(mEq/l : 135-145)	\r\nKaliémie	4.2	(mEq/l : 3,5-5,1)	\r\nCalcémie	99	(mg/l : 90-105)	\r\nPhosphorémie	(mg/l : 25-50)	\r\nAc. urique	65	(mg/l : 25-60)	\r\nHb A1c 7,65	(%: 4,5-6,3)	\r\n\r\nCLAIRANCE DE LA CRÉATININE = 56 ml/mn (INSUFFISANCE RÉNALE MODÉRÉE) \r\n\r\nEstimation de la glycémie moyenne sur 120 jours : 1,69 g/l (9,37 mmol/l)', 0, '0'),
(4, 5, 'Examens biologiques', NULL, NULL, NULL, NULL, NULL, 'Demande Demande', 'Resultat', 0, '0'),
(5, 6, 'Examen Générale', '1.75', '65', '13', '9', '10', NULL, NULL, 0, '0'),
(6, 6, 'Examens radioloqiue', NULL, NULL, NULL, NULL, NULL, 'az', 'az', 0, '0'),
(7, 4, 'Examen Générale', '1.75', '65', '13', '9', '10', NULL, NULL, 1, 'Corrigé'),
(8, 4, 'Examens radioloqiue', NULL, NULL, NULL, NULL, NULL, 'demande1\r\ndemande2\r\ndemande3', 'Resultat 1\r\nResultat 2', NULL, NULL),
(9, 3, 'Examens biologiques', NULL, NULL, NULL, NULL, NULL, 'Demande 1\r\nDemande 2\r\nDemande 3', 'Resultat1\r\nResultat2\r\nResultat3', NULL, NULL),
(10, 8, 'Examen Générale', '1.75', '65', '13', '9', '8', NULL, NULL, 1, 'Non corrigé');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `familyName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `lastActivity` datetime NOT NULL,
  `isActivated` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `image_id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `familyName`, `firstName`, `tel`, `created`, `lastActivity`, `isActivated`) VALUES
(1, 2, 'admin', 'admin', 'Mohamed@gmail.com', 'mohamed@gmail.com', 1, 'cjooq91lu5kokookkowwowgkcow08g0', 'QvKJ2JNFZ4WIlUbtZgu5NpBue/SZ8M4ozqg2x/xfRV5U3BUahUGu42AP6u3/WPQBowH/w8uFyVgKFtoGTH7NWg==', '2016-08-24 10:26:39', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:10:"ROLE_ADMIN";}', 0, NULL, 'Mhiri', 'Mohamed', '0644342821', '2014-05-03 21:13:54', '2016-08-24 10:26:39', 1),
(4, 4, 'user', 'user', 'souad@gmail.com', 'souad@gmail.com', 1, '1ubba1pb58m8k8c84oggkgg0w8k8k4k', 'HkNUbNRxHqNXOLOt0vz5A+HaGa/ZACk+Kr9lfA/M5onG1Z0nBod+uZAkRIS0MWXVmBm5mGfkPMXEluuyjvzGyw==', '2014-09-21 12:57:46', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, 'fadil', 'souad', '0666343755', '2014-05-10 17:59:17', '2014-09-21 13:03:02', 0),
(5, 5, 'manager', 'manager', 'vincent.jev@gmail.com', 'vincent.jev@gmail.com', 1, 'l904llzwz9ws8cc8sow84sogko48ksw', 'yLv9u+3FRIrxIS+X4lqHQb/SiC1CyKYk/REsG76GGa+zpOmpCa4YhkPdBIilNTViXnJr4HIFQW3YDdY8Me2tTw==', '2014-09-21 12:53:17', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:12:"ROLE_MANAGER";}', 0, NULL, 'fadil', 'adil', '+21266345886', '2014-09-01 14:15:56', '2014-09-21 12:56:48', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `antecedent`
--
ALTER TABLE `antecedent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3166BE7C217BBB47` (`person_id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consultation`
--
ALTER TABLE `consultation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_964685A6217BBB47` (`person_id`),
  ADD KEY `IDX_964685A6895648BC` (`doc_id`);

--
-- Indexes for table `consultation_meds`
--
ALTER TABLE `consultation_meds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4540F7E662FF6CDF` (`consultation_id`),
  ADD KEY `IDX_4540F7E6A30CAE6F` (`meds_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meds`
--
ALTER TABLE `meds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `metadata`
--
ALTER TABLE `metadata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4F1434141E5D0459` (`test_id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D87F7E0C62FF6CDF` (`consultation_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_5DBD36CC92FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_5DBD36CCA0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_5DBD36CC3DA5256D` (`image_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `antecedent`
--
ALTER TABLE `antecedent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `consultation`
--
ALTER TABLE `consultation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `consultation_meds`
--
ALTER TABLE `consultation_meds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=127;
--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `meds`
--
ALTER TABLE `meds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `metadata`
--
ALTER TABLE `metadata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `antecedent`
--
ALTER TABLE `antecedent`
  ADD CONSTRAINT `FK_3166BE7C217BBB47` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`);

--
-- Constraints for table `consultation`
--
ALTER TABLE `consultation`
  ADD CONSTRAINT `FK_964685A6217BBB47` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `FK_964685A6895648BC` FOREIGN KEY (`doc_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `consultation_meds`
--
ALTER TABLE `consultation_meds`
  ADD CONSTRAINT `FK_4540F7E662FF6CDF` FOREIGN KEY (`consultation_id`) REFERENCES `consultation` (`id`),
  ADD CONSTRAINT `FK_4540F7E6A30CAE6F` FOREIGN KEY (`meds_id`) REFERENCES `meds` (`id`);

--
-- Constraints for table `metadata`
--
ALTER TABLE `metadata`
  ADD CONSTRAINT `FK_4F1434141E5D0459` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`);

--
-- Constraints for table `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `FK_D87F7E0C62FF6CDF` FOREIGN KEY (`consultation_id`) REFERENCES `consultation` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_5DBD36CC3DA5256D` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
