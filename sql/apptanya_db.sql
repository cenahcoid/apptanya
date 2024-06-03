-- MariaDB dump 10.19-11.3.2-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: apptanya_db
-- ------------------------------------------------------
-- Server version	11.3.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `b_user`
--

DROP TABLE IF EXISTS `b_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `b_user` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(78) NOT NULL DEFAULT '',
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `jk` enum('L','P') DEFAULT NULL,
  `api_web_token` varchar(64) DEFAULT NULL,
  `is_active` int(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `b_user`
--

LOCK TABLES `b_user` WRITE;
/*!40000 ALTER TABLE `b_user` DISABLE KEYS */;
INSERT INTO `b_user` VALUES
(1,'Katherine','drosanda@outlook.co.id','e10adc3949ba59abbe56e057f20f883e','Soreang','L',NULL,1),
(2,'Didin Jamaludin','didin@cenah.co.id','424b03fda56d63195b1c4944d6117ab5','Kp. Tegalkembang No 26 Rt 04 Rw 08 Kec. Kutawaringin Kab. Bandung Jawa Barat Indonesia (depan TK NURI)','L',NULL,1),
(3,'Ruli Royana Widuran','RuliRoyanaWidura@gmail.com','424b03fda56d63195b1c4944d6117ab5','Kp. Tegalkembang No 26 Rt 04 Rw 08 Kec. Kutawaringin Kab. Bandung Jawa Barat Indonesia (depan TK NURI)','L',NULL,1),
(4,'Daeng GMAIL','daengrosanda@gmail.com','defe12aad396f90e6b179c239de260d4','Kp. Tegalkembang RT 02/08','L','92MJGX53F60HMEEIGLX',1),
(5,'Daeng Rosanda','daeng@cenah.co.id','ac2ab7be519637438577960d036b1adc','Jl. Rumah Sakit No. 113','L',NULL,1),
(6,'Ozan Vrokovich','ozan@cenah.co.id','ac2ab7be519637438577960d036b1adc','Kp. Tegalkembang RT 02/08','L',NULL,1),
(7,'Kimi Maro','kimi@cenah.co.id','ac2ab7be519637438577960d036b1adc','Jl Sulanjana','L',NULL,1),
(8,'Karmila','karmila@cenah.co.id','ac2ab7be519637438577960d036b1adc','Jl. Rumah Sakit No. 113','L',NULL,1),
(9,'marco','marco@cenah.co.id','ac2ab7be519637438577960d036b1adc','Marcopolo','L',NULL,1);
/*!40000 ALTER TABLE `b_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `c_tanya`
--

DROP TABLE IF EXISTS `c_tanya`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `c_tanya` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `b_user_id_tanya` int(3) unsigned DEFAULT NULL,
  `b_user_id_jawab` int(3) unsigned DEFAULT NULL,
  `tanya` varchar(255) NOT NULL DEFAULT '',
  `tgl_tanya` datetime DEFAULT NULL,
  `jawab` varchar(255) NOT NULL,
  `tgl_jawab` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_b_user_id_tanya` (`b_user_id_tanya`),
  KEY `fk_b_user_id_jawab` (`b_user_id_jawab`),
  KEY `idx_tanya` (`tanya`),
  CONSTRAINT `fk_b_user_id_jawab` FOREIGN KEY (`b_user_id_jawab`) REFERENCES `b_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `fk_b_user_id_tanya` FOREIGN KEY (`b_user_id_tanya`) REFERENCES `b_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `c_tanya`
--

LOCK TABLES `c_tanya` WRITE;
/*!40000 ALTER TABLE `c_tanya` DISABLE KEYS */;
INSERT INTO `c_tanya` VALUES
(1,1,NULL,'Dimanakah beli Lele?','2021-06-12 12:25:31','hade euy',NULL),
(2,1,3,'Dimana kah beli Lele dumbo?','2021-06-12 12:25:29','Coba cari tempat penangkaran ikan disekitar daerah kamu. Biasanya ada yang suka ternak ikan. Tapi kemungkinan besar menjual juga Lele Dumbo','2021-06-12 23:34:11'),
(3,1,NULL,'Siapakah Daeng Rosanda?','2021-06-12 22:47:05','',NULL),
(4,1,NULL,'test','2021-06-12 22:48:20','',NULL),
(5,1,NULL,'Siapakah Daeng Rosanda?','2021-06-12 22:48:37','',NULL),
(6,1,NULL,'test','2021-06-12 22:49:09','',NULL),
(7,1,1,'testing','2021-06-12 22:49:50','testong','2021-06-12 22:50:29'),
(8,1,1,'Apakah kamu suka mencopet?','2021-06-12 22:51:15','tidak suka, takut sama Allah SWT','2021-06-12 22:52:05'),
(9,1,NULL,'Siapakah nama asli Sule?','2021-06-12 23:06:40','',NULL),
(10,1,NULL,'Siapakah Tatang Sutarman?','2021-06-12 23:10:36','',NULL),
(11,1,1,'Sule lahir dimana?','2021-06-12 23:18:33','Saya tidak tahu pasti, tapi kalau tgl lahir yaitu pada 15 November 1976 di Cimahi','2021-06-12 23:19:37');
/*!40000 ALTER TABLE `c_tanya` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `d_jawab`
--

DROP TABLE IF EXISTS `d_jawab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `d_jawab` (
  `id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `c_tanya_id` int(6) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `b_user_id_jawab` int(3) unsigned DEFAULT NULL,
  `jawaban` varchar(255) NOT NULL,
  `rating` decimal(5,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `fk_c_tanya_id` (`c_tanya_id`),
  KEY `fk_b_user_id_jawab` (`b_user_id_jawab`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `d_jawab`
--

LOCK TABLES `d_jawab` WRITE;
/*!40000 ALTER TABLE `d_jawab` DISABLE KEYS */;
INSERT INTO `d_jawab` VALUES
(1,9,'2024-06-03 17:55:47',NULL,2,'Menurut buku Tatang Sutarman, nama asli Sule adalah Entis Sutisna',0.00),
(2,9,'2024-06-03 23:12:43',NULL,7,'Jakarta',0.00),
(3,8,'2024-06-04 00:09:58',NULL,7,'ga tau, mingkin bawah ane tau',0.00),
(4,8,'2024-06-04 00:10:14',NULL,7,'wololololo',0.00),
(5,1,'2024-06-04 00:12:46',NULL,7,'Coba dimarketplace kesayangan anda',0.00),
(6,1,'2024-06-04 00:13:57',NULL,9,'Ada di Bah Eden',0.00);
/*!40000 ALTER TABLE `d_jawab` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `d_notifikasi`
--

DROP TABLE IF EXISTS `d_notifikasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `d_notifikasi` (
  `id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `b_user_id` int(3) unsigned DEFAULT NULL,
  `c_tanya_id` int(6) unsigned DEFAULT NULL,
  `isi` varchar(255) NOT NULL DEFAULT '',
  `is_read` int(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_b_user_id` (`b_user_id`),
  KEY `c_tanya_id` (`c_tanya_id`),
  CONSTRAINT `fk_b_user_id` FOREIGN KEY (`b_user_id`) REFERENCES `b_user` (`id`) ON DELETE CASCADE ON UPDATE SET NULL,
  CONSTRAINT `fk_c_tanya_id` FOREIGN KEY (`c_tanya_id`) REFERENCES `c_tanya` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=34578 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `d_notifikasi`
--

LOCK TABLES `d_notifikasi` WRITE;
/*!40000 ALTER TABLE `d_notifikasi` DISABLE KEYS */;
INSERT INTO `d_notifikasi` VALUES
(34568,1,8,'Telah dijawab! Pertanyaan ->Apakah kamu suka mencopet?',0),
(34569,1,9,'Telah dijawab! Pertanyaan ->Siapakah nama asli Sule?',0),
(34570,1,10,'Telah dijawab! Pertanyaan ->Siapakah Tatang Sutarman?',1),
(34571,1,11,'Telah dijawab! \"Sule lahir dimana?\"',1),
(34572,3,2,'Telah dijawab! \"Dimana kah beli Lele dumbo?\"',0),
(34573,7,9,'Telah dijawab! \"Siapakah nama asli Sule?\"',0),
(34574,7,8,'Telah dijawab! \"Apakah kamu suka mencopet?\"',0),
(34575,7,8,'Telah dijawab! \"Apakah kamu suka mencopet?\"',0),
(34576,7,1,'Telah dijawab! \"Dimanakah beli Lele?\"',0),
(34577,9,1,'Telah dijawab! \"Dimanakah beli Lele?\"',0);
/*!40000 ALTER TABLE `d_notifikasi` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-04  0:14:50
