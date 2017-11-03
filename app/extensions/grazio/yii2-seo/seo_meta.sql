# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.19)
# Database: com_zuche9886_www
# Generation Time: 2017-05-20 13:44:18 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table seo_meta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `seo_meta`;

CREATE TABLE `seo_meta` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `entity` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据ID',
  `model` varchar(255) NOT NULL DEFAULT '' COMMENT '数据模型类',
  `route` varchar(255) NOT NULL DEFAULT '' COMMENT '路由',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `keywords` text NOT NULL COMMENT '关键字',
  `description` text NOT NULL COMMENT '描述',
  `robots` varchar(100) NOT NULL DEFAULT '' COMMENT '蜘蛛授权',
  PRIMARY KEY (`id`),
  UNIQUE KEY `entity_model_route` (`entity`,`model`,`route`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
