-- MySQL dump 10.13  Distrib 8.0.22, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: proiect
-- ------------------------------------------------------
-- Server version	5.7.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `angajat`
--

DROP TABLE IF EXISTS `angajat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `angajat` (
  `coda` int(11) NOT NULL AUTO_INCREMENT,
  `numea` varchar(20) DEFAULT NULL,
  `prenumea` varchar(45) DEFAULT NULL,
  `cnp` bigint(13) DEFAULT NULL,
  `adresaa` varchar(80) DEFAULT NULL,
  `telefona` varchar(14) DEFAULT NULL,
  `emaila` varchar(25) DEFAULT NULL,
  `localitate` varchar(25) DEFAULT NULL,
  `judet` varchar(25) DEFAULT NULL,
  `tara` varchar(3) DEFAULT NULL,
  `codf` int(10) DEFAULT NULL,
  PRIMARY KEY (`coda`),
  KEY `codf` (`codf`),
  CONSTRAINT `angajat_ibfk_1` FOREIGN KEY (`codf`) REFERENCES `functie` (`codf`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `angajat`
--

LOCK TABLES `angajat` WRITE;
/*!40000 ALTER TABLE `angajat` DISABLE KEYS */;
INSERT INTO `angajat` VALUES (1,'Vasiliu','Vasile',1290302410061,'Cosbuc','0772347777','test@gmail.com','Insuratei','BR','RO',1),(3,'Tudorache','Leonard',1290302410061,'Alba Iulia, Galati','0722222222','valileo2000@gmail.com','braila','BR','RO',1),(4,'Testu','Testare',1290302410061,'o strada','0798654321','testu@gmail.com','Galati','GL','RO',1),(5,'Novi','Novice',5061111010068,'somewhere','0798564222','novi@ugal.ro','braila','BR','RO',1),(6,'nou','noutate',1950121340019,'loc','0758642391','noutate@gmail.com','bucuresti','B','RO',1),(9,'te rog','merge',6130923430020,'revelion waa','0719577672','lmapls@gmail.com','Galati','GL','RO',3),(10,'pls','da',1430910440083,'starda','0758742844','pppppp@gmail.com','Galati','GL','RO',2),(12,'Popescu','Andrei',5130817400029,'Domneasca','0789457698','andreipop@gmail.com','Galati','GL','RO',4),(13,'Anton','George',2841105290078,'Brailei','0769875314','anton@gmai.com','Galati','GL','RO',6),(15,'Marinescu','Marian',2820812040035,'strada','0748975148','marian@gmail.com','Galati','GL','RO',1),(16,'Popa','Alin',2830425430051,'ceva','0795478214','alin@gmail.com','Galati','GL','RO',1),(17,'Pralea','Geani',1810107230013,'udne','0754879654','test@gmail.com','Galti','GL','RO',1),(18,'Php','Phpescu',1911015344534,'strada php','0755555555','phpescu@php.com','Galati','GL','RO',1),(19,'phpww','phpqqq',2960727309938,'str qwww','0712345678','woo@gmail.com','Cuca','GL','RO',1),(21,'Phplsss','Phpescuuu',2960727309938,'str css','0741526398','mail@mail.com','Galati','GL','RO',3),(22,'Numescu','Prenumescu',2930225430931,'adresescu','0745678923','testulll@test.com','Braila','BR','RO',2);
/*!40000 ALTER TABLE `angajat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autoturism`
--

DROP TABLE IF EXISTS `autoturism`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `autoturism` (
  `vin` char(17) NOT NULL,
  `model` varchar(20) DEFAULT NULL,
  `versiune` varchar(20) DEFAULT NULL,
  `culoare` varchar(18) DEFAULT NULL,
  `jante` varchar(18) DEFAULT NULL,
  `interior` varchar(18) DEFAULT NULL,
  `autopilot` tinyint(1) DEFAULT NULL,
  `data_fab` date DEFAULT NULL,
  `nr_usi` tinyint(1) DEFAULT NULL,
  `tractiune` varchar(10) DEFAULT NULL,
  `baterie` int(3) DEFAULT NULL,
  `preta` double(8,2) DEFAULT NULL,
  `pretatva` double(8,2) DEFAULT NULL,
  `stoc` int(2) DEFAULT NULL,
  PRIMARY KEY (`vin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autoturism`
--

LOCK TABLES `autoturism` WRITE;
/*!40000 ALTER TABLE `autoturism` DISABLE KEYS */;
INSERT INTO `autoturism` VALUES ('5YJ3E7EA4LF673789','Model 3','Performance','Negru','20\'\' Black','Alb',1,'2021-05-06',4,'Integrala',82,47000.00,55930.00,1),('5YJSA2DP1DFP26966','Model S','Long Range','Alb','19\'\' Silver','Alb',1,'2014-05-13',5,'Integrala',100,27000.00,32130.00,1),('5YJSA3H14EFP37120','Model S','Long Range','Negru','19\'\' Silver','Negru',1,'2014-06-24',5,'Integrala',100,28000.00,33320.00,2),('5YJSA7E20FF113854','Model S','Long Range','Alb','19\'\' Silver','Crem',0,'2021-05-01',5,'Integrala',100,39000.00,46410.00,2),('5YJSA7E21HF206868','Model S','Plaid','Negru','21\'\' Carbon','Crem',1,'2020-08-28',5,'Integrala',100,80000.00,95200.00,2),('5YJXCCE26GF018452','Model X','Long Range','Alb','20\'\' Silver','Crem',0,'2017-06-14',5,'Integrala',100,58000.00,69020.00,1),('5YJXCCE26HF071010','Model X','Long Range','Negru','22\'\' Black','Alb',1,'2017-12-27',5,'Integrala',100,73000.00,86870.00,1);
/*!40000 ALTER TABLE `autoturism` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `client` (
  `codc` int(11) NOT NULL AUTO_INCREMENT,
  `numec` varchar(20) DEFAULT NULL,
  `prenumec` varchar(45) DEFAULT NULL,
  `cnp` bigint(13) DEFAULT NULL,
  `telefonc` varchar(14) DEFAULT NULL,
  `emailc` varchar(25) DEFAULT NULL,
  `adresac` varchar(80) DEFAULT NULL,
  `localitate` varchar(25) DEFAULT NULL,
  `judet` varchar(25) DEFAULT NULL,
  `tara` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`codc`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` VALUES (1,'Stan','Numescu',1400724290069,'0723111489','numescu@yahoo.com','undeva in TECUCI','Tecuci','GL','RO'),(2,'Stanciulescu','Marian',2400705020038,'0724671953','marian@gmail.com','braileiiii','Galati','GL','RO'),(3,'Ionescu','Pop',1880604337405,'0742568596','ionescuuu@gmail.com','Unirii 48','Brasov','BV','RO');
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `functie`
--

DROP TABLE IF EXISTS `functie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `functie` (
  `codf` int(11) NOT NULL AUTO_INCREMENT,
  `denf` varchar(15) DEFAULT NULL,
  `salariubrut` double(7,2) DEFAULT NULL,
  `salariunet` double(7,2) DEFAULT NULL,
  PRIMARY KEY (`codf`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `functie`
--

LOCK TABLES `functie` WRITE;
/*!40000 ALTER TABLE `functie` DISABLE KEYS */;
INSERT INTO `functie` VALUES (1,'Mecanic',2950.00,1725.75),(2,'Paznic',2500.00,1462.50),(3,'Vopsitor',2541.00,1486.49),(4,'Manager',6500.00,3802.50),(5,'Contabil',3800.00,2223.00),(6,'Consilier',3600.00,2106.00),(7,'Casier',2800.00,1638.00);
/*!40000 ALTER TABLE `functie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `logs` (
  `codl` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `actiune` varchar(20) DEFAULT NULL,
  `comanda` text,
  `datal` date DEFAULT NULL,
  `oral` time DEFAULT NULL,
  `codf` int(11) DEFAULT NULL,
  PRIMARY KEY (`codl`),
  KEY `codf` (`codf`),
  CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`codf`) REFERENCES `functie` (`codf`)
) ENGINE=InnoDB AUTO_INCREMENT=341 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (212,'manager','inserare Excel','60a6c9afd13196.06948199.xlsx','2021-05-20','23:42:24',4),(213,'manager','stergere','delete from piese where codp = \'6007071-00-A\';','2021-05-20','23:42:44',4),(214,'manager','stergere','delete from piese where codp = \'105506600B\';','2021-05-20','23:43:01',4),(215,'manager','stergere','delete from piese where codp = \'6007071-00-A\';','2021-05-20','23:56:31',4),(216,'manager','inserare Excel','60a6cddd67d802.73281708.xlsx','2021-05-21','00:00:13',4),(217,'manager','stergere','delete from piese where codp = \'6007071-00-A\';','2021-05-21','00:00:23',4),(218,'manager','stergere','delete from piese where codp = \'105506600B\';','2021-05-21','00:00:33',4),(219,'manager','stergere','delete from piese where codp = \'105506600B\';','2021-05-21','00:01:00',4),(220,'manager','inserare Excel','60a6ce51bcad10.29007984.xlsx','2021-05-21','00:02:09',4),(221,'manager','stergere','delete from piese where codp = \'6007071-00-A\';','2021-05-21','00:02:39',4),(222,'manager','stergere','delete from piese where codp = \'105506600B\';','2021-05-21','00:02:42',4),(223,'manager','inserare Excel piese','60a6d2956d8567.68155463.xlsx','2021-05-21','00:20:21',4),(224,'manager','editare','UPDATE angajat SET numea = :numea, prenumea = :prenumea, cnp = :cnp, \r\n                                  adresaa = :adresaa, telefona = :telefona, emaila = :emaila, localitate = :localitate, \r\n                   judet = :judet, tara = :tara, codf = :codf WHERE coda = :coda','2021-05-21','01:02:25',4),(225,'manager','editare','UPDATE angajat SET numea = \'pls\', prenumea = \'da\', cnp = \'1430910440083\', \r\n                                  adresaa = \'starda\', telefona = \'0758742844\', emaila = \'pppppp@gmail.com\', localitate = \'Galati\', \r\n                   judet = \'GL\', tara = \'RO\', codf = \'2\' WHERE coda = \'10\'','2021-05-21','01:07:27',4),(226,'manager','editare','UPDATE piese SET denp = \'Senzor ABS\', pretp = \'280\', pretptva = \'333.2\' \r\n                                   WHERE codp = \'06-S726\'','2021-05-21','01:43:05',4),(227,'manager','editare','UPDATE client SET numec = \'Stan\', prenumec = \'Numescu\', cnp = \'1400724290069\', \r\n                                   telefonc = \'0723111489\', emailc = \'numescu@yahoo.com\', adresac = \'undeva in TECUCI\', localitate = \'Tecuci\', \r\n                   judet = \'GL\', tara = \'RO\' WHERE codc = \'1\'','2021-05-21','01:45:56',4),(228,'manager','editare','UPDATE utilizatori SET username = \'consilier\', password = \'cons\', codf = \'6\' \r\n                                   WHERE userid = \'2\'','2021-05-21','01:47:30',4),(229,'manager','editare','UPDATE service SET codc = \'2\', numec = \'Stanciulescu\', prenumec = \'Marian\', \r\n                   vin = \'5YJ3E7EA4LF673789\', model = \'Model 3\', codp = \'FC-C2100GER\', denp = \'Filtru polen\', stare = \'Finalizata\', garantie = 1 WHERE cods = \'3\'','2021-05-21','01:49:29',4),(230,'manager','editare','UPDATE vanzare SET tipprod = \'Autoturisme\', prod = \'Model S\', codp = null, vin = \'5YJSA7E20FF113854\', \r\n                   pret = \'39000.00\', prettva = \'46410.00\', codc = \'2\', numec = \'Stanciulescu\', prenumec = \'Marian\' WHERE codv = \'1\'','2021-05-21','01:51:01',4),(231,'manager','editare','UPDATE autoturism SET model = \'Model 3\', versiune = \'Performance\', culoare = \'Negru\', \r\n                                  jante = \'20\\\'\\\' Black\', interior = \'Alb\', autopilot = 1, data_fab = \'2021-05-06\', \r\n                      nr_usi = \'4\', tractiune = \'Integrala\', baterie = \'82\', preta = \'47000.00\', pretatva = \'55930.00\', \r\n                      stoc = \'1\' WHERE vin = \'5YJ3E7EA4LF673789\'','2021-05-21','01:55:45',4),(232,'manager','editare','UPDATE autoturism SET model = \'Model S\', versiune = \'Long Range\', culoare = \'Alb\', \r\n                                  jante = \'19\\\'\\\' Silver\', interior = \'Crem\', autopilot = 0, data_fab = \'2021-05-01\', \r\n                      nr_usi = \'5\', tractiune = \'Integrala\', baterie = \'100\', preta = \'39000.00\', pretatva = \'46410.00\', \r\n                      stoc = \'2\' WHERE vin = \'5YJSA7E20FF113854\'','2021-05-21','01:56:54',4),(233,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','09:38:16',4),(234,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64 ::1','2021-05-21','09:39:42',4),(235,'Popescu','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','09:41:32',4),(236,'casier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','09:43:31',7),(237,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','09:43:52',4),(238,'manager','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','09:53:02',4),(239,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','10:04:57',4),(240,'manager','adaugare','INSERT INTO angajat(numea, prenumea, cnp, adresaa, telefona, emaila, localitate, \r\n                     judet, tara, codf) VALUES (\'Numescu\', \'Prenumescu\', \'2930225430931\', \'adresescu\', \'0745678923\', \'testulll@test.com\', \'Braila\', \'BR\', \'RO\', \'2\')','2021-05-21','10:13:54',4),(241,'manager','adaugare','INSERT INTO autoturism (vin, model, versiune, culoare, jante, interior, \r\n                    autopilot, data_fab, nr_usi, tractiune, baterie, preta, pretatva, stoc) VALUES (\'5YJXCCE26GF018452\', \'Model X\', \'Long Range\', \r\n                    \'Alb\', \'20\', \'Crem\', 0, \'2017-06-14\', \'5\', \'Integrala\', \'100\', \'58000\', \'69020\', \'1\')','2021-05-21','10:20:58',4),(242,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','11:47:57',4),(243,'manager','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','11:49:20',4),(244,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','11:49:31',4),(245,'manager','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','11:53:55',4),(246,'casier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','11:54:15',7),(247,'consilier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','11:54:55',6),(248,'consilier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','11:59:37',6),(249,'consilier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:04:35',6),(250,'consilier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:09:11',6),(251,'consilier','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:09:17',6),(252,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:09:24',4),(253,'manager','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:09:27',4),(254,'consilier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:09:33',6),(255,'consilier','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:24:50',6),(256,'mecanic','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:24:56',1),(257,'mecanic','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:32:15',1),(258,'consilier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:32:23',6),(259,'consilier','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:39:23',6),(260,'casier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:39:28',7),(261,'casier','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:39:53',7),(262,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:39:59',4),(263,'manager','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:40:05',4),(264,'consilier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:40:12',6),(265,'consilier','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:40:15',6),(266,'casier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:40:22',7),(267,'casier','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:44:09',7),(268,'consilier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:44:21',6),(269,'consilier','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:44:24',6),(270,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:44:37',4),(271,'manager','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:44:40',4),(272,'casier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:44:48',7),(273,'casier','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:45:42',7),(274,'consilier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:45:49',6),(275,'consilier','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:47:15',6),(276,'casier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:47:19',7),(277,'casier','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:54:08',7),(278,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:54:14',4),(279,'manager','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:54:58',4),(280,'consilier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:55:07',6),(281,'consilier','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:56:24',6),(282,'casier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:56:27',7),(283,'casier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:57:46',7),(284,'casier','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:59:42',7),(285,'mecanic','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','12:59:50',1),(286,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','14:15:50',4),(287,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','14:22:59',4),(288,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','14:28:26',4),(289,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','14:57:30',4),(290,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','15:48:12',4),(291,'manager','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','21:13:53',4),(292,'casier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','21:13:58',7),(293,'casier','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','21:14:10',7),(294,'consilier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','21:14:15',6),(295,'consilier','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','21:18:12',6),(296,'mecanic','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','21:18:19',1),(297,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-21','21:22:49',4),(298,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-22','11:09:37',4),(299,'manager','adaugare','INSERT INTO client(numec, prenumec, cnp, adresac, telefonc, emailc, localitate, \r\n                     judet, tara) VALUES (\'Ionescu\', \'Pop\', \'1880604337405\', \'Unirii 48\', \'0742568596\', \'ionescuuu@gmail.com\', \'Brasov\', \'BV\', \'RO\')','2021-05-22','11:54:02',4),(300,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-23','22:30:35',4),(301,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-23','22:32:58',4),(302,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','12:59:15',4),(303,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','13:01:16',4),(304,'manager','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','13:10:57',4),(305,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','13:14:47',4),(306,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','13:15:14',4),(307,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','13:15:32',4),(308,'manager','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','13:17:00',4),(309,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','13:20:43',4),(310,'manager','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','14:46:14',4),(311,'consilier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','14:46:27',6),(312,'consilier','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','14:48:32',6),(313,'casier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','14:48:37',7),(314,'casier','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','14:52:15',7),(315,'consilier','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','14:52:26',6),(316,'consilier','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','14:52:47',6),(317,'mecanic','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','14:52:54',1),(318,'mecanic','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','14:57:43',1),(319,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','14:57:48',4),(320,'manager','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','14:58:13',4),(321,'mecanic','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','14:58:19',1),(322,'mecanic','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','14:58:24',1),(323,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','15:00:43',4),(324,'manager','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','15:22:02',4),(325,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','15:22:09',4),(326,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','17:27:13',4),(327,'manager','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','17:32:54',4),(328,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','17:33:08',4),(329,'manager','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','17:33:11',4),(330,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','17:33:26',4),(331,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','17:33:39',4),(332,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','18:27:40',4),(333,'manager','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','18:27:51',4),(334,'manager','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','19:00:32',4),(335,'manager','adaugare','INSERT INTO angajat(numea, prenumea, cnp, adresaa, telefona, emaila, localitate, \r\n                     judet, tara, codf) VALUES (\'Vrabie\', \'Cezar\', \'1970803272040\', \'braili\', \'0722222222\', \'test@gmail.com\', \'Galati\', \'GL\', \'RO\', \'1\')','2021-05-24','19:02:46',4),(336,'manager','editare','UPDATE angajat SET numea = \'Vrabie\', prenumea = \'Cezar\', cnp = \'1970803272040\', \r\n                                  adresaa = \'alta strada\', telefona = \'0722222222\', emaila = \'test@gmail.com\', localitate = \'Galati\', \r\n                   judet = \'GL\', tara = \'RO\', codf = \'1\' WHERE coda = \'23\'','2021-05-24','19:03:10',4),(337,'manager','stergere','delete from angajat where coda = 23;','2021-05-24','19:03:14',4),(338,'manager','inserare Excel piese','60abce676a8d81.82931191.xlsx','2021-05-24','19:03:53',4),(339,'manager','logout','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','19:07:43',4),(340,'mecanic','login','Windows NT BESTIA 10.0 build 19043 (Windows 10) AMD64','2021-05-24','19:07:49',1);
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `piese`
--

DROP TABLE IF EXISTS `piese`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `piese` (
  `codp` varchar(15) NOT NULL,
  `denp` varchar(35) DEFAULT NULL,
  `pretp` double(7,2) DEFAULT NULL,
  `pretptva` double(7,2) DEFAULT NULL,
  PRIMARY KEY (`codp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piese`
--

LOCK TABLES `piese` WRITE;
/*!40000 ALTER TABLE `piese` DISABLE KEYS */;
INSERT INTO `piese` VALUES ('06-S726','Senzor ABS',280.00,333.20),('105506600B','Placute fata',270.00,321.30),('1070801-00-E','Bieleta directie',104.00,123.76),('28672VA1','Arc punte fata',371.00,441.49),('6007071-00-A','Cap de bara Lemforder',181.00,215.39),('99-14 620 0001','Burduf bieleta',40.00,47.60),('9XW 053-181','Lamela stergator',32.00,38.08),('BS-9248HC','Disc fata',500.00,595.00),('FC-C2100GER','Filtru polen',180.00,214.20);
/*!40000 ALTER TABLE `piese` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service` (
  `cods` int(3) NOT NULL AUTO_INCREMENT,
  `codc` int(5) DEFAULT NULL,
  `numec` varchar(20) DEFAULT NULL,
  `prenumec` varchar(20) DEFAULT NULL,
  `vin` char(17) DEFAULT NULL,
  `model` varchar(20) DEFAULT NULL,
  `codp` varchar(15) DEFAULT NULL,
  `denp` varchar(35) DEFAULT NULL,
  `angajat` varchar(20) DEFAULT NULL,
  `stare` varchar(25) DEFAULT NULL,
  `garantie` tinyint(1) DEFAULT NULL,
  `datas` date DEFAULT NULL,
  `oras` time DEFAULT NULL,
  PRIMARY KEY (`cods`),
  KEY `service_client_codc_fk` (`codc`),
  KEY `service_piese_codp_fk` (`codp`),
  KEY `service_autoturism_vin_fk` (`vin`),
  CONSTRAINT `service_client_codc_fk` FOREIGN KEY (`codc`) REFERENCES `client` (`codc`),
  CONSTRAINT `service_ibfk_1` FOREIGN KEY (`codc`) REFERENCES `client` (`codc`),
  CONSTRAINT `service_piese_codp_fk` FOREIGN KEY (`codp`) REFERENCES `piese` (`codp`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` VALUES (2,1,'Stan','Numescu','5YJSA7E23GF155047','Model S','FC-C2100GER','Filtru polen','Marinescu','Ridicata',0,'2021-01-10','19:49:31'),(3,2,'Stanciulescu','Marian','5YJ3E7EA4LF673789','Model 3','FC-C2100GER','Filtru polen','manager','Finalizata',1,'2021-05-03','12:05:14');
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilizatori`
--

DROP TABLE IF EXISTS `utilizatori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utilizatori` (
  `userid` int(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  `codf` int(11) DEFAULT NULL,
  PRIMARY KEY (`userid`),
  KEY `codf_fk_util` (`codf`),
  CONSTRAINT `codf_fk_util` FOREIGN KEY (`codf`) REFERENCES `functie` (`codf`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilizatori`
--

LOCK TABLES `utilizatori` WRITE;
/*!40000 ALTER TABLE `utilizatori` DISABLE KEYS */;
INSERT INTO `utilizatori` VALUES (1,'manager','manager',4),(2,'consilier','cons',6),(3,'casier','casier',7),(4,'mecanic','mecanic',1),(7,'Popescu','Andrei',4),(8,'Anton','George',6),(9,'Georgescu','George',2),(10,'Marinescu','Marian',1),(11,'Popa','Alin',1),(12,'Pralea','Geani',1);
/*!40000 ALTER TABLE `utilizatori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vanzare`
--

DROP TABLE IF EXISTS `vanzare`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vanzare` (
  `codv` int(4) NOT NULL AUTO_INCREMENT,
  `tipprod` varchar(30) DEFAULT NULL,
  `prod` varchar(20) DEFAULT NULL,
  `codp` varchar(20) DEFAULT NULL,
  `vin` char(17) DEFAULT NULL,
  `pret` double(8,2) DEFAULT NULL,
  `prettva` double(8,2) DEFAULT NULL,
  `codc` int(11) DEFAULT NULL,
  `numec` varchar(20) DEFAULT NULL,
  `prenumec` varchar(45) DEFAULT NULL,
  `angajat` varchar(20) DEFAULT NULL,
  `datav` date DEFAULT NULL,
  `orav` time DEFAULT NULL,
  PRIMARY KEY (`codv`),
  KEY `vanzare_autoturism_vin_fk` (`vin`),
  KEY `vanzare_client_codc_fk` (`codc`),
  KEY `vanzare_piese_codp_fk` (`codp`),
  CONSTRAINT `vanzare_autoturism_vin_fk` FOREIGN KEY (`vin`) REFERENCES `autoturism` (`vin`),
  CONSTRAINT `vanzare_client_codc_fk` FOREIGN KEY (`codc`) REFERENCES `client` (`codc`),
  CONSTRAINT `vanzare_piese_codp_fk` FOREIGN KEY (`codp`) REFERENCES `piese` (`codp`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vanzare`
--

LOCK TABLES `vanzare` WRITE;
/*!40000 ALTER TABLE `vanzare` DISABLE KEYS */;
INSERT INTO `vanzare` VALUES (1,'Autoturisme','Model S',NULL,'5YJSA7E20FF113854',39000.00,46410.00,2,'Stanciulescu','Marian','manager','2021-01-10','15:10:52'),(2,'Piese','Filtru polen','FC-C2100GER',NULL,180.00,214.20,1,'Stan','Numescu','manager','2021-05-02','17:18:11'),(4,'Piese','Disc fata','BS-9248HC',NULL,500.00,595.00,2,'Stanciulescu','Marian','manager','2021-05-03','02:08:16');
/*!40000 ALTER TABLE `vanzare` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-05-25 10:49:58
