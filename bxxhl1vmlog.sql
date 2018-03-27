-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2018-03-28 06:45:22
-- 服务器版本： 5.6.37
-- PHP Version: 7.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bxxhl1vmlog`
--

-- --------------------------------------------------------

--
-- 表的结构 `t_l1vm_loginfo`
--

CREATE TABLE IF NOT EXISTS `t_l1vm_loginfo` (
  `sid` int(6) NOT NULL,
  `sysver` char(20) NOT NULL,
  `sysprog` char(20) NOT NULL,
  `project` varchar(50) DEFAULT NULL,
  `fromuser` varchar(50) DEFAULT NULL,
  `srcname` varchar(50) DEFAULT NULL,
  `destname` varchar(50) DEFAULT NULL,
  `msgid` varchar(50) DEFAULT NULL,
  `logtime` datetime NOT NULL,
  `logdata` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l1vm_logtracemodule`
--

CREATE TABLE IF NOT EXISTS `t_l1vm_logtracemodule` (
  `sid` int(6) NOT NULL,
  `moduleid` int(2) NOT NULL,
  `allowflag` tinyint(1) NOT NULL,
  `restrictflag` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l1vm_logtracemsg`
--

CREATE TABLE IF NOT EXISTS `t_l1vm_logtracemsg` (
  `sid` int(6) NOT NULL,
  `msgid` int(2) NOT NULL,
  `allowflag` tinyint(1) NOT NULL,
  `restrictflag` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l1vm_logwechatswitch`
--

CREATE TABLE IF NOT EXISTS `t_l1vm_logwechatswitch` (
  `user` char(50) NOT NULL,
  `switch` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l1vm_loginfo`
--
ALTER TABLE `t_l1vm_loginfo`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l1vm_logtracemodule`
--
ALTER TABLE `t_l1vm_logtracemodule`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l1vm_logtracemsg`
--
ALTER TABLE `t_l1vm_logtracemsg`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l1vm_logwechatswitch`
--
ALTER TABLE `t_l1vm_logwechatswitch`
  ADD PRIMARY KEY (`user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_l1vm_loginfo`
--
ALTER TABLE `t_l1vm_loginfo`
  MODIFY `sid` int(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l1vm_logtracemodule`
--
ALTER TABLE `t_l1vm_logtracemodule`
  MODIFY `sid` int(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l1vm_logtracemsg`
--
ALTER TABLE `t_l1vm_logtracemsg`
  MODIFY `sid` int(6) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
