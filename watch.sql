
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `watch`
--

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(40) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Message` varchar(255) NOT NULL,
  `CreationTimestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`Id`, `Nom`, `Email`, `Message`, `CreationTimestamp`) VALUES
(1, 'Salim', 'salim@salim.com', 'Bonjour', '2019-10-25 19:48:03');

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `User_Id` int(11) NOT NULL,
  `TotalAmount` double DEFAULT NULL,
  `CreationTimestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `User_Id` (`User_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `order`
--

INSERT INTO `order` (`Id`, `User_Id`, `TotalAmount`, `CreationTimestamp`) VALUES
(1, 1, 500, '2019-10-15 17:05:26');


-- --------------------------------------------------------

--
-- Structure de la table `orderline`
--

DROP TABLE IF EXISTS `orderline`;
CREATE TABLE IF NOT EXISTS `orderline` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `QuantityOrdered` int(4) NOT NULL,
  `Watch_Id` int(11) NOT NULL,
  `Order_Id` int(11) NOT NULL,
  `PriceEach` double NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Watch_Id` (`Watch_Id`),
  KEY `Order_Id` (`Order_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `orderline`
--

INSERT INTO `orderline` (`Id`, `QuantityOrdered`, `Watch_Id`, `Order_Id`, `PriceEach`) VALUES
(1, 1, 1, 1, 500);


-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(40) NOT NULL,
  `LastName` varchar(20) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `BirthDate` date NOT NULL,
  `Address` varchar(250) NOT NULL,
  `City` varchar(40) NOT NULL,
  `ZipCode` char(5) NOT NULL,
  `Country` varchar(20) DEFAULT NULL,
  `Phone` char(10) NOT NULL,
  `CreationTimestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`Id`, `FirstName`, `LastName`, `Email`, `Password`, `BirthDate`, `Address`, `City`, `ZipCode`, `Country`, `Phone`, `CreationTimestamp`) VALUES
(1, 'salim', 'salim', 'salim@salim.fr', '06780c50a7375a99a1f0a84faabcb36a9e2d5b8e7b9f2a9de1eede41b0231fb15a70d660cc0c1c22aa1c586565a2d7f902450eeec817cbca1f490fb62933c45b', '2019-10-09', '8 rue', 'Villeurbanne', '69100', 'France', '0606060606', '2019-10-29 20:31:18');


-- --------------------------------------------------------

--
-- Structure de la table `watch`
--

DROP TABLE IF EXISTS `watch`;
CREATE TABLE IF NOT EXISTS `watch` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) NOT NULL,
  `Photo` varchar(30) NOT NULL,
  `Description` varchar(250) NOT NULL,
  `Price` double NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `watch`
--

INSERT INTO `watch` (`Id`, `Name`, `Photo`, `Description`, `Price`) VALUES
(1, 'Tissot', 'tissot.jpg', 'Cette montre Tissot se compose d\'un boitier rond de 43mm en acier, d\'un cadran doré et d\'un bracelet en cuir.', 500),
(2, 'Festina', 'festina.jpg', 'Cette montre Festina se compose d\'un boitier rond de 43mm en acier, d\'un cadran bleu et d\'un bracelet en métal.', 350),
(3, 'Fossil', 'fossil.jpg', 'Cette montre Fossil se compose d\'un boitier rond de 40mm, d\'un cadran noir et d\'un bracelet en cuir marron.', 280),
(4, 'Armani Exchange', 'armani.jpg', 'Cette montre Armani Exchange se compose d\'un boitier rond de 46mm en acier, d\'un cadran noir et d\'un bracelet en acier.', 849),
(5, 'Seiko', 'seiko.jpg', 'Cette montre Seiko se compose d\'un boitier rond de 38mm en acier, d\'un cadran noir et d\'un bracelet en cuir noir.', 4000),
(6, 'Rolex', 'rolex.jpg', 'Cette montre Rolex se compose d\'un boitier rond de 46mm en acier, d\'un cadran noir et d\'un bracelet en acier noir.', 4000),
(8, 'Audemars Piguet', 'audemars.jpg', 'Cette montre Audemars Piguet se compose d\'un boitier boîtier octogonal de 40mm en argent, d\'un cadran blanc et d\'un bracelet en acier argent.', 20000),
(9, 'Cartier', 'cartier.jpg', 'Cette montre Cartier se compose d\'un boitier rond de 46mm en or, d\'un cadran blanc et d\'un bracelet en cuir marron.', 8000),
(11, 'IWC', 'iwc.jpg', 'Cette montre IWC se compose d\'un boitier rond de 46mm en argent, d\'un cadran bleu et d\'un bracelet en acier.', 5600),
(12, 'IWC', 'iwc2.jpg', 'Cette montre IWC se compose d\'un boitier rond de 46mm en argent, d\'un cadran noir et d\'un bracelet en acier.', 12000),
(15, 'Rolex', 'rolex2.jpg', 'Cette montre Rolex se compose d\'un boitier de 46mm en argent, d\'un cadran en argent et d\'un bracelet en acier.', 8600),
(17, 'Rolex', 'rolex3.jpg', 'Cette montre Rolex se compose d\'un boitier de 46mm en argent, d\'un cadran vert et d\'un bracelet en argent.', 12400),
(18, 'Rolex', 'rolex4.jpg', 'Cette montre Rolex se compose d\'un boitier de 46mm en argent, d\'un cadran noir et d\'un bracelet en argent.', 16800),
(19, 'Patek Phillipe', 'patek.jpg', 'Cette montre Patek Phillipe se compose d\'un boitier de 46mm en argent, d\'un cadran noir et d\'un bracelet en argent.', 90000),
(20, 'Patek Phillipe', 'patek2.jpg', 'Cette montre Patek Phillipe se compose d\'un boitier de 46mm en or, d\'un cadran noir et d\'un bracelet en or.', 100000);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
