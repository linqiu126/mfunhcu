-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2018-04-02 03:41:40
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
-- 表的结构 `t_l3f11faam_products_out`
--

CREATE TABLE IF NOT EXISTS `t_l3f11faam_products_out` (
  `sid` int(8) NOT NULL AUTO_INCREMENT,
  `stockname` char(50) NOT NULL,
  `productweight` double NOT NULL,
  `productsize` char(50) NOT NULL,
  `productnum` int(10) NOT NULL,
  `number` int(10) NOT NULL,
  `containernumber` char(50) NOT NULL,
  `platenumber` char(50) NOT NULL,
  `drivername` char(50) NOT NULL,
  `driverpho` char(50) NOT NULL,
  `receivingunit` char(50) NOT NULL,
  `logisticsunit` char(50) NOT NULL,
  `outtime` datetime NOT NULL,
  `message` char(50) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `t_l3f11faam_products_out`
--

INSERT INTO `t_l3f11faam_products_out` (`sid`, `stockname`, `productweight`, `productsize`, `productnum`, `number`, `containernumber`, `platenumber`, `drivername`, `driverpho`, `receivingunit`, `logisticsunit`, `outtime`, `message`) VALUES
(1, '上海一仓', 8, 'A', 28, 50, '123456', '苏A123456', '司机A', '12345678910', '南京', '顺丰', '2018-04-01 09:19:47', '正常入库'),
(3, '上海一仓', 8, 'A', 28, 50, '123456', '苏A123456', '司机A', '12345678910', '南京', '顺丰', '2018-03-29 09:19:47', '转库入库'),
(4, '上海一仓', 8, 'A', 28, 1, '----', '----', '----', '----', '----', '----', '2018-04-02 09:29:05', '转库出库'),
(5, '上海四仓', 8, 'A', 28, 1, 'A1111111', '浙A111111', '獬豸', '11111111111', '南京市', '顺丰', '2018-04-02 09:36:02', '正常出库');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
