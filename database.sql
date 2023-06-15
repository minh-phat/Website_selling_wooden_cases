create database selling_woods_web;
use selling_woods_web;
CREATE TABLE `account` (
  `AccountID` int(50) NOT NULL AUTO_INCREMENT,
  `User_Name` varchar(50) NOT NULL,
  `Account_Password` text NOT NULL,
  `Account_Name` varchar(50) NOT NULL,
  `Account_Role` varchar(50) NOT NULL,
  `Phone` int(50) NOT NULL,
  `Account_Address` text NOT NULL,
  `Date_Of_Birth` date NOT NULL,
  `Gender` varchar(50) NOT NULL,
  PRIMARY KEY (`AccountID`)
) ;

--
-- Table structure for table `categories`
--
CREATE TABLE `categories` (
  `Category_ID` int(5) NOT NULL AUTO_INCREMENT,
  `Category_Name` varchar(50) NOT NULL,
  `Category_Image` text NOT NULL,
  PRIMARY KEY (`Category_ID`)
) ;

--
-- Table structure for table `products`
--
CREATE TABLE `products` (
  `Product_ID` int(5) NOT NULL AUTO_INCREMENT,
  `Product_Name` varchar(50) NOT NULL,
  `Category_ID` int(5) NOT NULL,
  `Price` int(4) NOT NULL,
  `Details` text DEFAULT NULL,
  `Images` text NOT NULL,
  `Thickness` int(10) NOT NULL,
  `Width` int(10) NOT NULL,
  `Longs` int(1) NOT NULL,
  PRIMARY KEY (`Product_ID`),
  KEY `Category_ID` (`Category_ID`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`Category_ID`) REFERENCES `categories` (`Category_ID`)
) ;

--
-- Table structure for table `orders`
--
CREATE TABLE `orders` (
  `Order_ID` int(5) NOT NULL AUTO_INCREMENT,
  `Account_ID` int(50) NOT NULL,
  `Receive_Phone` varchar(10) NOT NULL,
  `Receive_Address` varchar(100) NOT NULL,
  `Date` date NOT NULL,
  `Note` text NOT NULL,
  PRIMARY KEY (`Order_ID`),
  KEY `Account_ID` (`Account_ID`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`Account_ID`) REFERENCES `account` (`AccountID`) ON DELETE CASCADE ON UPDATE CASCADE
) ;

--
-- Table structure for table `order_details`
--
CREATE TABLE `order_details` (
  `Order_ID` int(5) NOT NULL,
  `Product_ID` int(5) NOT NULL,
  `Quantity` int(4) NOT NULL,
  PRIMARY KEY (`Order_ID`,`Product_ID`),
  KEY `Product_ID` (`Product_ID`),
  CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`Order_ID`) REFERENCES `orders` (`Order_ID`),
  CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`Product_ID`) REFERENCES `products` (`Product_ID`)
) ;

--
-- Dumping data for table `account`
--
INSERT INTO `account` VALUES (5,'minhphat2','$2y$10$i6rGeOH6AgbW4yzdYrDsWuu4osKmsH1UYcI2TE6rSfZWeUQTuijxu','phat','customer',1234567890,'1212321','2022-08-22','male'),(6,'adminadmin','$2y$10$k9cj4FkG1mSL3F4iHRzRauZjgLNqnHWCj1CK3D2CoHc5jbfcq.C/.','admin','admin',2147483647,'123','2022-08-24','female'),(7,'tienthanh','$2y$10$isIb6mkHNPGHrRfzhGQTs.Jhn1X9Y4vjMSHAuvqGITMuUlHctyet.','thanh','customer',1234545,'23123','2022-08-25','female'),(8,'minhphat','$2y$10$L0Sb3jiF7ZefdI4uub5nOekUlLX.K/bueYdezby8YBnFHbk0IWKUC','phat','customer',1234546635,'123123','2022-08-18','male');

--
-- Dumping data for table `categories`
--
INSERT INTO `categories` VALUES (116,'Nike','nike2.jpg'),(117,'Jordans','th (3).jpg');

--
-- Dumping data for table `products`
--
INSERT INTO `products` VALUES (18,'Tree Wooden Cases',116,30,'nature','New-Brand-Thin-Luxury-Bamboo-Wood-Phone-Case-For-Samsung-Galaxy-S8-S8-Plus-Cover-Wooden.jpg_640x640.jpg',1,5,15),(19,'Wolf',117,50,'animal','3b63e4d1d6abc54ad5f32348c57329d3.jpg',1,5,10),(20,'pineapple',116,20,'fruit','img_introduct3.png',1,5,10),(21,'Skull',117,50,'horrified','11478a3d079cc69fcf4a7a9d0ae3b7fa.jpg',1,5,15),(22,'Dragon',116,50,'animate','Natural-U-I-Brand-New-Wood-Phone-Case-For-iPhone-5-5S-6-6S-6Plus-7.jpg_640x640.jpg',1,5,15);

--
-- Dumping data for table `orders`
--
INSERT INTO `orders` VALUES (2,5,'2','2','2029-08-22','2'),(3,5,'','','2029-08-22',''),(4,5,'','','2029-08-22',''),(5,5,'','','2029-08-22',''),(6,5,'','','2029-08-22',''),(7,5,'2','2','2029-08-22','2'),(8,5,'3','3','2029-08-22','3'),(9,5,'3','3','2029-08-22','3');

--
-- Dumping data for table `order_details`
--
INSERT INTO `order_details` VALUES (9,22,2);

-- Dump completed on 2022-09-01 10:42:07
