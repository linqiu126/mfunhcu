-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2018-04-25 08:31:18
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
-- 表的结构 `t_l3f11faam_material_history`
--

CREATE TABLE IF NOT EXISTS `t_l3f11faam_material_history` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `stockid` char(50) NOT NULL,
  `stockname` char(50) NOT NULL,
  `into` char(2) NOT NULL,
  `bucketnum` int(8) NOT NULL,
  `price` int(20) NOT NULL,
  `mode` char(2) DEFAULT NULL,
  `vendor` char(50) DEFAULT NULL,
  `charge` char(50) NOT NULL,
  `mobile` char(50) NOT NULL,
  `trunk` char(50) DEFAULT NULL,
  `target` char(50) DEFAULT NULL,
  `logistics` char(50) DEFAULT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `t_l3f11faam_material_history`
--

INSERT INTO `t_l3f11faam_material_history` (`sid`, `stockid`, `stockname`, `into`, `bucketnum`, `price`, `mode`, `vendor`, `charge`, `mobile`, `trunk`, `target`, `logistics`, `time`) VALUES
(1, '1', '上海一仓', '1', 2000, 200000, '1', '南京', '青龙', '11111111111', NULL, NULL, NULL, '2018-04-24 11:36:17'),
(2, '4', '上海四仓', '1', 300, 20000, '0', '沈阳', '玄武', '11111111111', NULL, NULL, NULL, '2018-04-24 11:32:37'),
(3, '1', '上海一仓', '0', 200, 2000, '0', NULL, '青龙', '11111111111', '浙A1111111', '南京', '顺丰', '2018-04-24 11:36:52'),
(4, '4', '上海四仓', '1', 20, 2000, '0', '供应商A', '采购员A', '123456787910', NULL, NULL, NULL, '2018-04-25 14:27:37'),
(5, '1', '上海一仓', '1', 200, 2020, '1', '供应商B', '采购员B', '11111111111', NULL, NULL, NULL, '2018-04-25 14:28:22'),
(6, '1', '上海一仓', '0', 2000, 20000, '1', NULL, '司机A', '11111111111', '浙A11111', '南京市', '顺丰', '2018-04-25 14:30:01');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
