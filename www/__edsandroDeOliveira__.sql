CREATE DATABASE  IF NOT EXISTS `bitter-edsandro` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `bitter-edsandro`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: bitter-edsandro
-- ------------------------------------------------------
-- Server version	5.7.26

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
-- Table structure for table `follows`
--

DROP TABLE IF EXISTS `follows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `follows` (
  `follow_id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  PRIMARY KEY (`follow_id`),
  KEY `FK_follows` (`from_id`),
  KEY `FK_follows2` (`to_id`),
  CONSTRAINT `FK_follows` FOREIGN KEY (`from_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `FK_follows2` FOREIGN KEY (`to_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follows`
--

LOCK TABLES `follows` WRITE;
/*!40000 ALTER TABLE `follows` DISABLE KEYS */;
INSERT INTO `follows` VALUES (1,8,33),(2,8,37),(3,8,34),(4,8,35),(5,8,36),(7,33,38),(8,33,8),(9,33,36),(11,8,58),(12,8,59),(13,8,61),(14,8,39),(15,58,61),(16,58,62),(18,58,59),(20,8,62),(21,8,56),(22,53,8),(23,58,33),(25,58,53),(27,58,34),(28,58,35),(29,58,36),(31,58,8),(32,52,8),(33,52,59),(34,52,58),(35,8,52);
/*!40000 ALTER TABLE `follows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL AUTO_INCREMENT,
  `tweet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`like_id`),
  KEY `FK_tweet_id_idx` (`tweet_id`),
  KEY `FK_user_id_idx` (`user_id`),
  CONSTRAINT `FK_tweet_id` FOREIGN KEY (`tweet_id`) REFERENCES `tweets` (`tweet_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=169 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (159,89,58,'2019-12-04 19:04:42'),(160,97,58,'2019-12-04 19:04:46'),(161,4,58,'2019-12-04 19:04:59'),(162,7,58,'2019-12-04 19:05:00'),(164,85,8,'2019-12-04 19:05:17'),(165,60,8,'2019-12-04 19:06:20'),(166,11,8,'2019-12-04 19:06:21'),(167,75,58,'2019-12-06 14:16:54'),(168,85,52,'2019-12-06 16:28:48');
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `message_text` varchar(255) NOT NULL,
  `date_sent` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_toid_idx` (`id`,`from_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,58,8,'Testing, Ed!','2019-11-29 09:33:24'),(8,8,58,'Testing, Nick!','2019-11-29 09:59:03'),(9,8,8,'Testing me!','2019-11-29 10:03:46'),(10,8,58,'','2019-12-06 14:20:07'),(11,8,8,'123\r\n','2019-12-06 15:08:36');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tweets`
--

DROP TABLE IF EXISTS `tweets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tweets` (
  `tweet_id` int(11) NOT NULL AUTO_INCREMENT,
  `tweet_text` varchar(280) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `original_tweet_id` int(11) NOT NULL DEFAULT '0',
  `reply_to_tweet_id` int(11) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tweet_id`),
  KEY `FK_tweets` (`user_id`),
  CONSTRAINT `FK_tweets` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tweets`
--

LOCK TABLES `tweets` WRITE;
/*!40000 ALTER TABLE `tweets` DISABLE KEYS */;
INSERT INTO `tweets` VALUES (1,'Testing',8,0,0,'2019-10-25 02:09:58'),(2,'PHP!!',8,0,0,'2019-10-25 02:17:26'),(3,'Hello!',8,0,0,'2019-10-25 02:18:41'),(4,'I\'m Batman!',61,0,0,'2019-10-25 02:20:34'),(5,'I\'m not Batman...',59,0,0,'2019-10-25 02:23:30'),(6,'I\'m richer than Tony Stark',59,0,0,'2019-10-25 02:23:39'),(7,'Who\'s this \"Joker\"?',61,0,0,'2019-10-25 02:21:56'),(9,'Is this the last?',58,0,0,'2019-10-25 03:53:14'),(11,'Good job, Ed!',58,0,0,'2019-10-25 04:42:02'),(14,'The last one...',8,0,0,'2019-10-25 06:03:28'),(15,'Tweeting using classes...',8,0,0,'2019-11-08 01:43:26'),(55,'Testing Retweeting reply',8,0,54,'2019-11-08 15:24:31'),(56,'Thanks, Nick!',8,0,11,'2019-11-08 15:41:38'),(58,'You\'re Welcome!',58,0,11,'2019-11-08 15:50:11'),(59,'ðŸ‘€ðŸ‘€',8,0,11,'2019-11-08 16:02:35'),(60,'Tweeting using classes...',58,15,0,'2019-11-08 16:15:30'),(62,'I retweeted your post and now I\'m replying myself to check if I can reply a retweet.\r\nðŸ‘',58,0,60,'2019-11-08 16:17:42'),(63,'Hahaha... Great!\r\n',8,0,60,'2019-11-08 16:25:28'),(67,'Again',8,0,64,'2019-11-21 00:37:30'),(74,'Again',8,67,0,'2019-11-21 01:09:11'),(75,'New Tweet Test',8,0,0,'2019-11-21 01:12:08'),(78,'dsdas',8,0,75,'2019-11-21 15:13:50'),(79,'Replying test',8,0,74,'2019-11-21 15:22:48'),(80,'PHP!!',8,2,0,'2019-11-21 15:28:04'),(81,'It\'s a reply',8,0,80,'2019-11-21 15:53:32'),(82,'This is a reply! It shouldn\'t be shown on my profile. Only on my index.php page.',8,0,80,'2019-11-21 15:56:42'),(85,'I am Nick!',58,0,0,'2019-11-22 04:02:10'),(86,'Testing again!!!!!\r\n',53,0,0,'2019-11-22 04:13:30'),(87,'Again',8,74,0,'2019-11-28 16:52:20'),(88,'I know!',8,0,85,'2019-11-28 18:46:32'),(89,'Testing',8,84,0,'2019-11-28 18:46:37'),(92,'Again',52,87,0,'2019-12-04 17:47:47'),(93,'Alright!',52,0,80,'2019-12-04 17:47:56'),(94,'Okay!',52,0,80,'2019-12-04 17:49:36'),(96,'Yes.',8,0,85,'2019-12-04 18:15:15'),(97,'Okay...',52,0,85,'2019-12-04 18:32:46'),(98,'Yup',8,0,85,'2019-12-04 19:09:40'),(99,'Yes again',8,0,85,'2019-12-04 19:20:40'),(100,'ok',58,0,75,'2019-12-06 13:45:11'),(101,'testing time',8,0,85,'2019-12-06 13:51:54'),(102,'testing more moremroe',58,0,75,'2019-12-06 14:16:18'),(103,'okokokok',52,0,85,'2019-12-06 16:28:58');
/*!40000 ALTER TABLE `tweets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `screen_name` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `address` varchar(200) NOT NULL,
  `province` varchar(50) NOT NULL,
  `postal_code` varchar(7) NOT NULL,
  `contact_number` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `url` varchar(50) NOT NULL,
  `description` varchar(160) NOT NULL,
  `location` varchar(50) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_pic` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (8,'Edsandro','de Oliveira','Ed','$2y$10$zWhI35TljlWHKy0Qr2X4XeEVDSlq9b6k.kp.AVg9zKohnLT7xC68y','458 Priestman Street','New Brunswick','E3B 3B4','(506) 260 9674','edsandrom@gmail.com','linkedin/edsandrom','My Profile','Fredericton','2019-09-23 05:06:21','8.jpg'),(33,'John','June','JoJu','$2y$10$HJj3F906cHmR0LwAy8l4kOazlhnYsbUHc6Ap8oHKPGMPg9wqTd7cC','123 Testing Street','New Brunswick','E3B 3H4','(506) 123 4785','jj@hotmail.com','www.google.com','testing profile','Test City','2019-09-23 17:33:24','default.jfif'),(34,'John','McClane','McClane','$2y$10$G.4lzSi5TZSOtcBc2t.1jeN8ldy..X78LIYwHcXupoDdKvC0OCpNW','123 Die Hard Street','New Brunswick','E3B 3B4','(123) 456 7890','diehard@yahoo.com','www.diehard.com','Detective','Fredericton','2019-10-09 00:50:15','default.jfif'),(35,'Tend','Grif','Grif','$2y$10$b3RDq/mUAMCuu0gC5sPYf.BZAD5hIsdBcA8qMdcPkzXqpEVwyDi3K','123 Grif Street','New Brunswick','E3B 4H5','(123) 456 7890','tgrif@hotmail.com','www.tgrif.ca','Grif','New Brunswick','2019-10-09 00:51:57','default.jfif'),(36,'Jack','Sparrow','Jack','$2y$10$ZZFjuQrwtTL5DJ.kcMMynOiaATsQI90exTy915/ab6SjRV4si.6Qq','123 Caribbean Street','New Brunswick','E3B 4H6','(123) 456 7890','jsparrow@gmail.com','www.jsparrow.com','Pirate','New B','2019-10-09 00:53:06','default.jfif'),(37,'Lenny','Denker','Lenny','$2y$10$kQQGB3AafiXCFlI2cdYV9uEdJiSsT5HN1HbOVxGCm3pIT3Uw0XbBa','123 fic street','New Brunswick','E3B 4H6','(123) 456 7890','ldnkr@gmail.com','www.ldnkr.com','Just Lenny','New Brunswick','2019-10-09 00:53:06','default.jfif'),(38,'Testing','Characters','Testing1','$2y$10$HioURQknoVEe/4XiAp74peZR47aYmpPlZQ2z3XWAn5P72AoJwvKgK','1123 Test Street','New Brunswick','E3B 4H3','(123) 456 7890','testing123@gmail.com','www.test.ca','Testing profile','New Brunswick','2019-10-09 00:53:06','default.jfif'),(39,'Johnny','Kent','JKentB','$2y$10$yEZ2YsfbaAoauPXlDrrrc.h21c.Ul8Z4wnIcw9VrfzE.d8GjadkK2','123 Testing Address Rd','New Brunswick','E3B 3B5','(506) 123 4567','jkentb@gmail.com','www.jkentb.ca','Johnny Kent\'s Profile','New Brunswick','2019-10-12 15:36:32','default.jfif'),(52,'Phone','Tester','Phone Tester','$2y$10$EPNoQC31WgmbjaIe.Wk83eGwMfHNCQ4E6nCWw6fPOXJbLF5s4hpti','213 testing phone','New Brunswick','E3B 3B5','(123) 123 1111','pt@hotmail.com','www.phonetester.com','Testing phone','Fredericton','2019-10-12 17:10:19','default.jfif'),(53,'Testing','Phone Again','TPA','$2y$10$fQwgWe0nlkRuomdkhOPTzOFk85TRZzBXhhhQDU2iGbsZyD0pyIK0y','123 tpa street','New Brunswick','E3B 5H4','(000) 987 1122','tpa@gmail.com','www.google.com','Testing','Again','2019-10-12 17:11:49','53.png'),(56,'sad','dasda','Testing Screen Name','$2y$10$nr.MJrsB5GWJwpdgOUJxteTTc2RqI9nmSczkXj.lkAV/yOQbxkuDy','123 pries dsa','New Brunswick','E3B 3B4','(123) 131 2321','dasda@dmsad.com','www.dsda.com','dasd','dasd','2019-10-12 17:41:32','default.jfif'),(57,'Ed','Tester','EdTester','$2y$10$MXeGZIPfOZxuEdcL2ygfv.axxZ6IAFqI3R7ppRp1RaPBij6ua.xzy','123 Ette Street','New Brunswick','E5B 4B5','(123) 123 1231','edtester@gmail.com','www.google.com','Tester','Profile','2019-10-12 17:59:03','default.jfif'),(58,'Nick','Taggart','Nick','$2y$10$t9WrfTk6ussM6ddV1M1r/.iBACJFLoMefPy.TspGJmU6mz.b/MH1y','26 Duffie Drive','New Brunswick','E3B 2X9','(000) 111 2222','nick.taggart@nbcc.ca','www.nbcc.ca','Nick Taggart\'s Profile','Fredericton','2019-10-12 18:50:21','58.jpg'),(59,'Bruce','Wayne','BWayne','$2y$10$b8T3t6TyTr1o0WUnAPRYR.ToTk90TgvwTw0CYY8AA3CCb35FHJgIu','123 Nowhere Road','New Brunswick','E3B 3B4','(506) 123 4566','bwayne@gmail.com','www.wayne.com','Bruce Wayne\'s Profile','Gotham','2019-10-25 00:34:29','59.jpg'),(61,'Batman','None','Batman','$2y$10$4Pb8E7VC0/5xZL3EoiU6yufqbb0yjUZ0tuIj/9RVTORRTzptfjaai','Bat Cave','New Brunswick','E3B 4N5','(111) 111 1111','bman@gmail.com','www.batman.com','Batman','TBD','2019-10-25 00:40:06','61.jpg'),(62,'Test','pic','tpic','$2y$10$OfjHI6iR89ri9DwzMhHSl.Jz.qyQ9tdiArvVIvT8Fgtl90SUg3PBq','pic address','New Brunswick','E3B 3B4','(123) 123 1232','tp@gmail.com','www.gogog.com','dasdas','dada','2019-10-25 01:33:24','62.jpg'),(63,'Testing','Last','lastAgain','$2y$10$DSeHW/wBCc8OM9XpR9LbLeiIVNpHwhkzbEZHAdg2YxkHm/8KnxW1O','other address','New Brunswick','E3B 3B4','(123) 123 1312','tl@gmail.com','www.gggg.com','dsda','dasda','2019-10-25 05:50:42','default.jfif'),(64,'John','Bitter','jbitter','$2y$10$nDSP.w/5Oprkokdzn5w9Lu3/jd6RoMdeM4fW8xRTooagv8TUf9feu','123 street','New Brunswick','E3B 4B5','(111) 111 1111','jbitter@gmail.com','www.bitter.ca','John\'s Profile','Fredericton','2019-11-08 04:11:46','default.jfif'),(76,'Sprint5FinalTest','Final','sprint5','$2y$10$Ot2WKOftVz0FnxcbMN7xkOU9sMz0BLuzeMdwuCmjliZO.MaT8amGC','street st','Manitoba','R0K 1J0','(121) 111 1111','sp5@gmail.com','www.sprint5.ca','sprint 5 profile','Maragaret, MB','2019-11-22 18:12:43','default.jfif');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-12-06 15:14:39
