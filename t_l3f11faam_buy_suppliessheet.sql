-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2018-03-13 10:54:35
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
-- 表的结构 `t_l3f11faam_buy_suppliessheet`
--

CREATE TABLE IF NOT EXISTS `t_l3f11faam_buy_suppliessheet` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `supplier` char(50) NOT NULL,
  `reason` char(50) NOT NULL,
  `datatype` char(50) NOT NULL,
  `amount` int(10) NOT NULL,
  `unitprice` double NOT NULL,
  `storagetime` datetime NOT NULL,
  `totalprice` int(20) NOT NULL,
  `datype` char(50) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `t_l3f11faam_buy_suppliessheet`
--

INSERT INTO `t_l3f11faam_buy_suppliessheet` (`sid`, `supplier`, `reason`, `datatype`, `amount`, `unitprice`, `storagetime`, `totalprice`, `datype`) VALUES
(1, '上海陆家嘴李家工坊', '正常入库', '纸箱', 17, 5, '2018-03-13 16:02:59', 85, '标准规格'),
(2, '上海', '正常入库', '网套', 10, 5, '2018-03-13 16:03:28', 50, '标准规格'),
(3, '南京', '正常入库', '托盘', 10, 20, '2018-03-13 16:03:47', 200, '标准规格'),
(4, '南京', '正常入库', '胶带', 5, 20, '2018-03-13 16:04:08', 100, '标准规格'),
(9, '上海', '正常入库', '垫片', 100, 0.5, '2018-03-13 16:06:25', 50, '标准规格'),
(10, '上海', '正常入库', '标签', 5, 20, '2018-03-13 16:06:47', 100, '标准规格'),
(11, '上海', '正常入库', '标签', 15, 20, '2018-03-13 16:07:29', 300, '标准规格'),
(12, '上海', '正常入库', '保鲜袋', 50, 5, '2018-03-13 16:07:55', 250, '标准规格');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
