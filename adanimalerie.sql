-- MySQL dump 10.13  Distrib 5.1.72, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: adanimalerie-dev
-- ------------------------------------------------------
-- Server version	5.1.72-2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `actualite`
--

DROP TABLE IF EXISTS `actualite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actualite` (
  `num_actualite` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) NOT NULL,
  `resume` varchar(250) NOT NULL,
  `texte` text NOT NULL,
  `date_creation` date NOT NULL,
  PRIMARY KEY (`num_actualite`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actualite`
--

LOCK TABLES `actualite` WRITE;
/*!40000 ALTER TABLE `actualite` DISABLE KEYS */;
INSERT INTO `actualite` VALUES (2,'Notre nouveau site internet','une boutique en ligne pour un service de qualité','<p>D&eacute;sireux de nous inscrire dans une d&eacute;marche de qualit&eacute; aupr&egrave;s de nos client....</p>','2012-04-03'),(3,'Une deuxième actu','blablabla...','<p><span class=\"texte-gris\"><span class=\"texte-gris\"><strong>26, 27, 28, 29 ao&ucirc;t 2014 COLL&Egrave;GE ET LYC&Eacute;E LATRESNE</strong><br /><br /> 8 heures de stage pour d&eacute;velopper les comp&eacute;tences orales de l&rsquo;anglais et revoir les points essentiels des programmes :<br /><br /> Un test de niveau d&eacute;terminera le groupe dans lequel l&rsquo;&eacute;l&egrave;ve travaillera.<br /> <br /></span></span></p>\r\n<ul class=\"list1\">\r\n<li class=\"pucePicto\" style=\"text-align: center;\"><span class=\"description_normal\" style=\"color: #000000;\"><em>LA COMPREHENSION ORALE : podcasts &amp; vid&eacute;os.</em></span></li>\r\n<li class=\"pucePicto\" style=\"text-align: center;\"><span class=\"description_normal\" style=\"color: #000000;\"><em>GRAMMAIRE :</em></span></li>\r\n<li class=\"pucePicto\" style=\"text-align: center;\"><span class=\"description_normal\" style=\"color: #000000;\"><em> manipulations des temps&hellip;.</em></span></li>\r\n<li class=\"pucePicto\" style=\"text-align: center;\"><span class=\"description_normal\" style=\"color: #000000;\"><em>L&rsquo;EXPRESSION ORALE : jeux de r&ocirc;le, d&eacute;bats, animations.</em></span></li>\r\n</ul>\r\n<ul class=\"list1\">\r\n<li class=\"pucePicto\" style=\"text-align: center;\"><span class=\"description_normal\" style=\"color: #000000;\"><em>en contexte.</em></span></li>\r\n</ul>\r\n<p><span class=\"texte-gris\"><span class=\"texte-gris\"><strong>HORAIRES :</strong> <br /></span></span></p>\r\n<ul class=\"list1\">\r\n<li class=\"pucePicto\" style=\"text-align: center;\">Coll&egrave;ge 10h30/12h30</li>\r\n<li class=\"pucePicto\" style=\"text-align: center;\">Lyc&eacute;e 14h/16h</li>\r\n</ul>\r\n<p><span class=\"texte-gris\"><strong>INSCRIPTIONS ET <em><span style=\"text-decoration: underline;\">RENSEIGNEMENTS </span></em></strong>: au 06 75 57 72 77. (Avant 15/08) <br /> <strong>TARIF </strong>: 13&euro;/h par &eacute;tudiant<br /></span></p>','2012-04-19');
/*!40000 ALTER TABLE `actualite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `animal`
--

DROP TABLE IF EXISTS `animal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `animal` (
  `num_animal` int(11) NOT NULL AUTO_INCREMENT,
  `num_animal_categorie` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `resume` varchar(250) NOT NULL,
  `texte` text NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `promotion` enum('0','1') NOT NULL DEFAULT '0',
  `champ_1` varchar(100) NOT NULL,
  `champ_2` varchar(100) NOT NULL,
  PRIMARY KEY (`num_animal`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `animal`
--

LOCK TABLES `animal` WRITE;
/*!40000 ALTER TABLE `animal` DISABLE KEYS */;
INSERT INTO `animal` VALUES (6,1,'Rat','Le langage courant confond longtemps rat et souris5 comme l\\\'atteste par exemple','<p>Le nom de &laquo;&nbsp;rats&nbsp;&raquo; peut &eacute;galement d&eacute;signer de mani&egrave;re g&eacute;n&eacute;rale en zoologie le <a title=\\\"Genre (biologie)\\\" href=\\\"http://fr.wikipedia.org/wiki/Genre_%28biologie%29\\\">genre</a> <em><a title=\\\"Rattus\\\" href=\\\"http://fr.wikipedia.org/wiki/Rattus\\\">Rattus</a></em>. La plupart des esp&egrave;ces de ce genre portent en fran&ccedil;ais le nom de &laquo;&nbsp;rat&nbsp;&raquo;, suivi d&rsquo;un qualificatif. Par exemple le <a title=\\\"Rat polyn&eacute;sien\\\" href=\\\"http://fr.wikipedia.org/wiki/Rat_polyn%C3%A9sien\\\">rat polyn&eacute;sien</a> (<em>Rattus exulans</em>) qui est la troisi&egrave;me esp&egrave;ce de rat la plus r&eacute;pandue au monde apr&egrave;s le <a class=\\\"mw-redirect\\\" title=\\\"Rat brun\\\" href=\\\"http://fr.wikipedia.org/wiki/Rat_brun\\\">rat brun</a> et le <a title=\\\"Rat noir\\\" href=\\\"http://fr.wikipedia.org/wiki/Rat_noir\\\">rat noir</a>.</p>','0.00','0','','');
/*!40000 ALTER TABLE `animal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `animal_categorie`
--

DROP TABLE IF EXISTS `animal_categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `animal_categorie` (
  `num_animal_categorie` int(11) NOT NULL AUTO_INCREMENT,
  `num_parent` int(11) NOT NULL DEFAULT '0',
  `nom` varchar(100) NOT NULL,
  `niveau` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`num_animal_categorie`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `animal_categorie`
--

LOCK TABLES `animal_categorie` WRITE;
/*!40000 ALTER TABLE `animal_categorie` DISABLE KEYS */;
INSERT INTO `animal_categorie` VALUES (1,0,'rongeur',0),(2,0,'Reptiles',0),(3,0,'Insectes',0);
/*!40000 ALTER TABLE `animal_categorie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `animal_image`
--

DROP TABLE IF EXISTS `animal_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `animal_image` (
  `num_animal_image` int(11) NOT NULL AUTO_INCREMENT,
  `num_animal` int(11) NOT NULL,
  `fic_image` varchar(100) NOT NULL,
  PRIMARY KEY (`num_animal_image`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `animal_image`
--

LOCK TABLES `animal_image` WRITE;
/*!40000 ALTER TABLE `animal_image` DISABLE KEYS */;
INSERT INTO `animal_image` VALUES (1,5,'P2couleur.jpg'),(2,6,'220px-WildRat.jpg');
/*!40000 ALTER TABLE `animal_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client` (
  `num_client` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `adresse` varchar(250) NOT NULL,
  `cp` varchar(10) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `mdp` varchar(50) NOT NULL,
  `code` varchar(16) NOT NULL,
  `date_creation` date NOT NULL,
  `actif` int(11) NOT NULL DEFAULT '0' COMMENT 'Le client a validé son inscription',
  `supprime` int(11) NOT NULL DEFAULT '0' COMMENT 'Le compte client est supprimé',
  PRIMARY KEY (`num_client`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` VALUES (1,'Langl\'éron','Franck','24, rue colbert','33140','Villenave d\'Ornon','0556585452','franck_langleron@hotttmail.com','aaa','J6RPY7s85jPb3v6p','2012-01-20',1,0),(23,'Gonzalez','Javier','12, route de bordeaux','33360','Latresne','0681731870','fjvai.gonzalez@gmail.com','xavier','70Y6dA00FEbr1693','2012-08-27',0,0),(22,'Langleron','Franck','1, rue de l\\\'autre ','33000','Bordeaux','05 56 58 54 52','franck_langleron@hotmail.com','aaa','S3k8ZxPde8RMqt9L','2012-04-23',1,0),(24,'Gonzalez','Javier','12, route de bordeaux','33360','Latresne','0681731870','fjavi.gonzalez@gmail.com','xavier','DE6bg119Q2vw0G5Q','2012-08-27',1,0);
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commande`
--

DROP TABLE IF EXISTS `commande`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commande` (
  `num_commande` int(11) NOT NULL AUTO_INCREMENT,
  `num_client` int(11) NOT NULL,
  `num_etat` int(11) NOT NULL,
  `num_etat_paiement` enum('0','1','2') NOT NULL COMMENT '"0" : Annulé, "1" : En cours, "2" : Validé',
  `prix` decimal(10,2) NOT NULL,
  `transaction_id` varchar(20) NOT NULL,
  `date_creation` date NOT NULL,
  PRIMARY KEY (`num_commande`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commande`
--

LOCK TABLES `commande` WRITE;
/*!40000 ALTER TABLE `commande` DISABLE KEYS */;
INSERT INTO `commande` VALUES (1,22,1,'','3.00','','2012-10-23'),(2,22,2,'2','9.90','51A66663YL400922B','2012-10-23'),(3,24,2,'1','10.50','','2012-10-29'),(4,22,2,'1','9.90','','2013-11-27');
/*!40000 ALTER TABLE `commande` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commande_erreur`
--

DROP TABLE IF EXISTS `commande_erreur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commande_erreur` (
  `num_commande_erreur` int(11) NOT NULL AUTO_INCREMENT,
  `num_commande` int(11) NOT NULL,
  `texte` text NOT NULL,
  `date_creation` date NOT NULL,
  PRIMARY KEY (`num_commande_erreur`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commande_erreur`
--

LOCK TABLES `commande_erreur` WRITE;
/*!40000 ALTER TABLE `commande_erreur` DISABLE KEYS */;
/*!40000 ALTER TABLE `commande_erreur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commande_etat`
--

DROP TABLE IF EXISTS `commande_etat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commande_etat` (
  `num_etat` int(11) NOT NULL AUTO_INCREMENT,
  `texte` varchar(50) NOT NULL,
  `ordre_affichage` int(11) NOT NULL,
  PRIMARY KEY (`num_etat`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commande_etat`
--

LOCK TABLES `commande_etat` WRITE;
/*!40000 ALTER TABLE `commande_etat` DISABLE KEYS */;
INSERT INTO `commande_etat` VALUES (1,'Annulée',5),(2,'En cours de traitement',15),(3,'En attente',10),(4,'Remise',20);
/*!40000 ALTER TABLE `commande_etat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commande_paiement`
--

DROP TABLE IF EXISTS `commande_paiement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commande_paiement` (
  `num_paiement` int(11) NOT NULL AUTO_INCREMENT,
  `num_commande` int(11) NOT NULL,
  `transaction_id` varchar(20) NOT NULL,
  `payer_email` varchar(100) NOT NULL,
  `montant` float NOT NULL,
  `statut` varchar(50) NOT NULL,
  `date_creation` date NOT NULL,
  PRIMARY KEY (`num_paiement`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commande_paiement`
--

LOCK TABLES `commande_paiement` WRITE;
/*!40000 ALTER TABLE `commande_paiement` DISABLE KEYS */;
INSERT INTO `commande_paiement` VALUES (1,2,'51A66663YL400922B','buyer_1350932271_per@hotmail.com',9.9,'Completed','2012-10-23'),(2,3,'3ED16844WU9921453','buyer_1350923229_per@iconeo.fr',10.5,'Completed','2012-10-29');
/*!40000 ALTER TABLE `commande_paiement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commande_produit`
--

DROP TABLE IF EXISTS `commande_produit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commande_produit` (
  `num_commande` int(11) NOT NULL,
  `num_produit` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix_unitaire` float NOT NULL,
  PRIMARY KEY (`num_commande`,`num_produit`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commande_produit`
--

LOCK TABLES `commande_produit` WRITE;
/*!40000 ALTER TABLE `commande_produit` DISABLE KEYS */;
INSERT INTO `commande_produit` VALUES (1,5,'Croquettes Frolic 1,5 kG',1,3),(2,2,'Collier en cuir ',1,9.9),(3,3,'Graines Canari 100 Gr',1,10.5),(4,2,'Collier en cuir ',1,9.9);
/*!40000 ALTER TABLE `commande_produit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produit`
--

DROP TABLE IF EXISTS `produit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produit` (
  `num_produit` int(11) NOT NULL AUTO_INCREMENT,
  `num_produit_categorie` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `resume` varchar(250) NOT NULL,
  `texte` text NOT NULL,
  `info` text NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `prix_promo` decimal(10,2) NOT NULL,
  `coup_de_coeur` enum('0','1') NOT NULL,
  PRIMARY KEY (`num_produit`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit`
--

LOCK TABLES `produit` WRITE;
/*!40000 ALTER TABLE `produit` DISABLE KEYS */;
INSERT INTO `produit` VALUES (6,11,'Nourriture pour rouges-gorges 2 kg','Attirez les rouges-gorges dans votre jardin à l\\\'aide de ce mélange spécialement conçu pour eux, vendu en paquet de 2kg. Leur joli plumage rouge viendra animer votre extérieur.','<p>Avoine broyee, tourteau d\\\' extraction d\\\'arachides broy&eacute;es, tourteau d\\\' extraction de tournesoll, graisses animales agglomerees, insectes seches</p>','<p>a</p>','7.50','0.00','0'),(2,17,'Collier en cuir ','Collier noir en cuir pour gros chien','<p>asdasasd</p>','<p>dfsdfsf</p>','9.90','0.00','0'),(3,3,'Graines Canari 100 Gr','asasd','<p><span class=\\\"titre\\\" style=\\\"color: #8e8e7e;\\\">xxxx</span></p>\r\n<p><span class=\\\"titre\\\" style=\\\"color: #8e8e7e;\\\"><span class=\\\"normal\\\" style=\\\"color: #000000;\\\">zzzzzz</span><br /></span></p>','<p>ddd</p>','10.50','0.00','0'),(5,18,'Croquettes Frolic 1,5 kG','Idéal pour le chien adulte de petite taiile','<p>Id&eacute;al pour le chien adulte de petite taiile</p>','<p>na</p>','3.23','3.00','0'),(7,12,'balançoire','balancoire en metal','<p>description de la <strong>balancoire</strong></p>','<p>infosur la balancfoire</p>','12.00','11.00','1'),(8,19,'sdfgsg','fsfgsfgsfgsfgsfg','<p><span class=\"texte-gris\"><span class=\"texte-gris\"><strong>26, 27, 28, 29 ao&ucirc;t 2014 COLL&Egrave;GE ET LYC&Eacute;E LATRESNE</strong><br /><br /> 8 heures de stage pour d&eacute;velopper les comp&eacute;tences orales de l&rsquo;anglais et revoir les points essentiels des programmes :<br /><br /> Un test de niveau d&eacute;terminera le groupe dans lequel l&rsquo;&eacute;l&egrave;ve travaillera.<br /> <br /></span></span></p>\r\n<ul class=\"list1\">\r\n<li class=\"pucePicto\">L&rsquo;EXPRESSION ORALE : jeux de r&ocirc;le, d&eacute;bats, animations.</li>\r\n<li class=\"pucePicto\">LA COMPREHENSION ORALE : podcasts &amp; vid&eacute;os.</li>\r\n<li class=\"pucePicto\">GRAMMAIRE : manipulations des temps&hellip;.en contexte.</li>\r\n</ul>\r\n<p><span class=\"texte-gris\"><span class=\"texte-gris\"><strong>HORAIRES :</strong> <br /></span></span></p>\r\n<ul class=\"list1\">\r\n<li class=\"pucePicto\">Coll&egrave;ge 10h30/12h30</li>\r\n<li class=\"pucePicto\">Lyc&eacute;e 14h/16h</li>\r\n</ul>\r\n<p><span class=\"texte-gris\"><strong>INSCRIPTIONS ET RENSEIGNEMENTS </strong>: au 06 75 57 72 77. (Avant 15/08) <br /> <strong>TARIF </strong>: 13&euro;/h par &eacute;tudiant<br /></span></p>','<p><span class=\"texte-gris\"><span class=\"texte-gris\"><strong>26, 27, 28, 29 ao&ucirc;t 2014 COLL&Egrave;GE ET LYC&Eacute;E LATRESNE</strong><br /><br /> 8 heures de stage pour d&eacute;velopper les comp&eacute;tences orales de l&rsquo;anglais et revoir les points essentiels des programmes :<br /><br /> Un test de niveau d&eacute;terminera le groupe dans lequel l&rsquo;&eacute;l&egrave;ve travaillera.<br /> <br /></span></span></p>\r\n<ul class=\"list1\">\r\n<li class=\"pucePicto\">L&rsquo;EXPRESSION ORALE : jeux de r&ocirc;le, d&eacute;bats, animations.</li>\r\n<li class=\"pucePicto\">LA COMPREHENSION ORALE : podcasts &amp; vid&eacute;os.</li>\r\n<li class=\"pucePicto\">GRAMMAIRE : manipulations des temps&hellip;.en contexte.</li>\r\n</ul>\r\n<p><span class=\"texte-gris\"><span class=\"texte-gris\"><strong>HORAIRES :</strong> <br /></span></span></p>\r\n<ul class=\"list1\">\r\n<li class=\"pucePicto\">Coll&egrave;ge 10h30/12h30</li>\r\n<li class=\"pucePicto\">Lyc&eacute;e 14h/16h</li>\r\n</ul>\r\n<p><span class=\"texte-gris\"><strong>INSCRIPTIONS ET RENSEIGNEMENTS </strong>: au 06 75 57 72 77. (Avant 15/08) <br /> <strong>TARIF </strong>: 13&euro;/h par &eacute;tudiant<br /></span></p>','23.00','34.00','0');
/*!40000 ALTER TABLE `produit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produit_associe`
--

DROP TABLE IF EXISTS `produit_associe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produit_associe` (
  `num_produit_associe` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`num_produit_associe`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit_associe`
--

LOCK TABLES `produit_associe` WRITE;
/*!40000 ALTER TABLE `produit_associe` DISABLE KEYS */;
INSERT INTO `produit_associe` VALUES (1,'Crapaud'),(2,'Rainette'),(3,'Lézard'),(4,'Insectes d\'alimentation'),(8,'Mantes religieuses'),(7,'Phasmes'),(9,'Cochons d\'Inde'),(10,'Rats'),(12,'Eau Tropicale'),(13,'Eau Froide'),(14,'Reptiles Alimentations'),(15,'Lapins Nains'),(20,'oiseaux'),(19,'Chiens');
/*!40000 ALTER TABLE `produit_associe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produit_categorie`
--

DROP TABLE IF EXISTS `produit_categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produit_categorie` (
  `num_produit_categorie` int(11) NOT NULL AUTO_INCREMENT,
  `num_parent` int(11) NOT NULL DEFAULT '0',
  `nom` varchar(100) NOT NULL,
  `niveau` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`num_produit_categorie`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit_categorie`
--

LOCK TABLES `produit_categorie` WRITE;
/*!40000 ALTER TABLE `produit_categorie` DISABLE KEYS */;
INSERT INTO `produit_categorie` VALUES (1,0,'Aquariophilie',0),(2,0,'Chiens',0),(3,0,'Oiseaux',0),(4,0,'Terrariophilie',0),(20,1,'ksdjlfsdf',1),(19,1,'Accessoires',1),(11,3,'Nourriture',1),(12,3,'accessoires',1),(13,4,'Accessoires',1),(14,4,'Nourriture',1),(15,2,'Nourriture',1),(16,2,'Soins',1),(17,2,'Accessoires',1),(18,15,'Croquettes',2),(22,19,'dfsf ',2);
/*!40000 ALTER TABLE `produit_categorie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produit_image`
--

DROP TABLE IF EXISTS `produit_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produit_image` (
  `num_produit_image` int(11) NOT NULL AUTO_INCREMENT,
  `num_produit` int(11) NOT NULL,
  `fic_image` varchar(100) NOT NULL,
  PRIMARY KEY (`num_produit_image`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit_image`
--

LOCK TABLES `produit_image` WRITE;
/*!40000 ALTER TABLE `produit_image` DISABLE KEYS */;
INSERT INTO `produit_image` VALUES (11,3,'1232-large.jpg'),(10,6,'oiseau.jpg'),(8,5,'index.jpg'),(9,2,'34COLLIER-HOT-DOG.jpg-tbn.jpg'),(12,3,'alpiste-graines.jpg'),(13,3,'Canary_Conditioning_Seeds.jpg'),(14,7,'246559.jpg'),(15,8,'Screen Shot 2014-08-05 at 19.06.59.png');
/*!40000 ALTER TABLE `produit_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produit_produit_associe`
--

DROP TABLE IF EXISTS `produit_produit_associe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produit_produit_associe` (
  `num_produit` int(11) NOT NULL,
  `num_produit_associe` int(11) NOT NULL,
  `num_animal` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`num_produit`,`num_produit_associe`,`num_animal`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit_produit_associe`
--

LOCK TABLES `produit_produit_associe` WRITE;
/*!40000 ALTER TABLE `produit_produit_associe` DISABLE KEYS */;
INSERT INTO `produit_produit_associe` VALUES (2,19,0),(3,20,0),(5,19,0),(6,20,0);
/*!40000 ALTER TABLE `produit_produit_associe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotion`
--

DROP TABLE IF EXISTS `promotion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promotion` (
  `num_promotion` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) NOT NULL,
  `sous_titre` varchar(50) NOT NULL,
  `reduction` varchar(20) NOT NULL,
  `texte` varchar(100) NOT NULL,
  `online` enum('0','1') NOT NULL,
  PRIMARY KEY (`num_promotion`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotion`
--

LOCK TABLES `promotion` WRITE;
/*!40000 ALTER TABLE `promotion` DISABLE KEYS */;
INSERT INTO `promotion` VALUES (1,'Promotion','Exceptionnel!!!','-25%','sur toutes les tortues','1');
/*!40000 ALTER TABLE `promotion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utilisateur` (
  `num_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `civilite` varchar(5) NOT NULL,
  `nom_utilisateur` varchar(100) NOT NULL,
  `prenom_utilisateur` varchar(100) NOT NULL,
  `mail_utilisateur` varchar(100) NOT NULL,
  `login` varchar(50) NOT NULL,
  `mdp` varchar(50) NOT NULL,
  PRIMARY KEY (`num_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateur`
--

LOCK TABLES `utilisateur` WRITE;
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` VALUES (1,'','test','test','franck_langleron@hotmail.com','test','test');
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-07-06 11:34:43
