# Gegevenssprint

een php project waar het doel op de site is zoveel mogelijk clicks verzamelen
je kunt een gebruiker aanmaken met een uniek inlog systeem  naam + leeftijd 
je kunt je accounts naam veranderen verwijderen en clicks reseten
export mogelijkheden zijn excel en pdf je kunt ook je database downloaden
php versie: php 8.1.0
Dit project maakt gebruik van **Composer** 

## 🚀 Installatie

1. Clone dit project:
   ```bash
   git clone https://github.com/okwastaken/gegevenssprint
   cd gegevenssprint

2. cmd 
Installeer dependencies met Composer
Open CMD of Terminal in de projectmap en voer uit:
 ```
composer install 

3. Maak een .env-bestand aan
Kopieer het voorbeeldbestand: 
```
cp .env.example .env

# Database

1. **Maak een nieuwe database aan in phpMyAdmin**  
   - Ga naar: http://localhost/phpmyadmin
   - Klik op **Nieuwe database**  
   - Geef een naam, bijvoorbeeld `example_db`
 ```
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
DROP TABLE IF EXISTS `gebruikers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gebruikers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(20) NOT NULL,
  `leeftijd` int(2) NOT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `clicks` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `gebruikers` WRITE;
/*!40000 ALTER TABLE `gebruikers` DISABLE KEYS */;
INSERT INTO `gebruikers` VALUES (1,'tyrone22',18,0)
/*!40000 ALTER TABLE `gebruikers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


   ![kolommen](image.png)

3. **Pas de databasegegevens aan in je `.env`-bestand**  
   ```dotenv
    vul dit in met je mamp wachtwoord en gebruikersnaam host en db naam
    DB_HOST=example_host
    DB_USER=example_user
    DB_PASS=example_pass
    DB_NAME=example_db