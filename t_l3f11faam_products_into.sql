-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2018-04-02 03:41:36
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bxxhl1l2l3`
--

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f11faam_products_into`
--

CREATE TABLE IF NOT EXISTS `t_l3f11faam_products_into` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `stockname` char(50) NOT NULL,
  `productweight` double DEFAULT NULL,
  `productsize` char(50) DEFAULT NULL,
  `productnum` int(10) DEFAULT NULL,
  `number` int(10) DEFAULT NULL,
  `productcharge` char(50) DEFAULT NULL,
  `message` char(50) DEFAULT NULL,
  `datime` datetime NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `t_l3f11faam_products_into`
--

INSERT INTO `t_l3f11faam_products_into` (`sid`, `stockname`, `productweight`, `productsize`, `productnum`, `number`, `productcharge`, `message`, `datime`) VALUES
(1, '上海一仓', 8, 'A', 28, 49, '李四', '正常入库', '2018-04-02 09:29:05'),
(2, '上海四仓', 8, 'A', 28, 0, '李四', '转库入库', '2018-04-02 09:36:02');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
