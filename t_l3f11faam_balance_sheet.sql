-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2018-04-17 09:48:49
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
-- 表的结构 `t_l3f11faam_balance_sheet`
--

CREATE TABLE IF NOT EXISTS `t_l3f11faam_balance_sheet` (
  `sid` int(8) NOT NULL AUTO_INCREMENT,
  `balancecode` char(50) NOT NULL,
  `fishtype` char(50) NOT NULL,
  `fishgrade` char(50) NOT NULL,
  `fishnote` char(50) DEFAULT NULL,
  `stocktime` datetime NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `t_l3f11faam_balance_sheet`
--

INSERT INTO `t_l3f11faam_balance_sheet` (`sid`, `balancecode`, `fishtype`, `fishgrade`, `fishnote`, `stocktime`) VALUES
(1, 'HCU_G201_AQYC_SH001', '黄鱼', '1', '黄鱼；一级', '2018-04-17 10:36:20');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
