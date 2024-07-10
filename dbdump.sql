-- MySQL dump 10.13  Distrib 8.0.36, for macos14 (x86_64)
--
-- Host: 127.0.0.1    Database: call_logs_db
-- ------------------------------------------------------
-- Server version	8.0.33

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
-- Table structure for table `Available_Callid`
--

DROP TABLE IF EXISTS `Available_Callid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Available_Callid` (
  `Callid` int NOT NULL,
  PRIMARY KEY (`Callid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Call_Details`
--

DROP TABLE IF EXISTS `Call_Details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Call_Details` (
  `DetailID` int NOT NULL AUTO_INCREMENT,
  `Callid` int DEFAULT NULL,
  `Date` datetime DEFAULT NULL,
  `Details` text,
  `Hours` int DEFAULT NULL,
  `Minutes` int DEFAULT NULL,
  PRIMARY KEY (`DetailID`),
  KEY `Callid` (`Callid`),
  CONSTRAINT `call_details_ibfk_1` FOREIGN KEY (`Callid`) REFERENCES `Call_Header` (`Callid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Call_Header`
--

DROP TABLE IF EXISTS `Call_Header`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Call_Header` (
  `Callid` int NOT NULL AUTO_INCREMENT,
  `Date` datetime DEFAULT NULL,
  `ITPerson` varchar(32) DEFAULT NULL,
  `UserName` varchar(32) DEFAULT NULL,
  `Subject` varchar(64) DEFAULT NULL,
  `Details` text,
  `Total_Hours` int DEFAULT NULL,
  `Total_Minutes` int DEFAULT NULL,
  `Status` enum('New','In Progress','Completed') DEFAULT NULL,
  PRIMARY KEY (`Callid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping events for database 'call_logs_db'
--

--
-- Dumping routines for database 'call_logs_db'
--
/*!50003 DROP PROCEDURE IF EXISTS `Delete_Call` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `Delete_Call`(IN p_Callid INT)
BEGIN
    -- Delete the call record
    DELETE FROM Call_Header WHERE Callid = p_Callid;

    -- Add the Callid to the available Callid pool
    INSERT INTO Available_Callid (Callid) VALUES (p_Callid);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `Insert_Call` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `Insert_Call`(
    IN p_Date DATETIME,
    IN p_ITPerson VARCHAR(32),
    IN p_UserName VARCHAR(32),
    IN p_Subject VARCHAR(64),
    IN p_Details TEXT,
    IN p_Status ENUM('New', 'In Progress', 'Completed')
)
BEGIN
    DECLARE v_Callid INT;

    -- Check for available Callid
    SELECT Callid INTO v_Callid FROM Available_Callid LIMIT 1;

    IF v_Callid IS NOT NULL THEN
        -- Use available Callid
        DELETE FROM Available_Callid WHERE Callid = v_Callid;
    ELSE
        -- Generate new Callid
        SELECT IFNULL(MAX(Callid), 0) + 1 INTO v_Callid FROM Call_Header;
    END IF;

    -- Insert new call record
    INSERT INTO Call_Header (Callid, Date, ITPerson, UserName, Subject, Details, Status)
    VALUES (v_Callid, p_Date, p_ITPerson, p_UserName, p_Subject, p_Details, p_Status);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-11  0:38:36
