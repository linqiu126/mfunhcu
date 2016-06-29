-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-06-29 14:47:41
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bxxhl1l2`
--

-- --------------------------------------------------------

--
-- 表的结构 `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `public_email` varchar(255) DEFAULT NULL,
  `gravatar_email` varchar(255) DEFAULT NULL,
  `gravatar_id` varchar(32) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `bio` text,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `profile`
--

INSERT INTO `profile` (`user_id`, `name`, `public_email`, `gravatar_email`, `gravatar_id`, `location`, `website`, `bio`) VALUES
(51, NULL, NULL, 'liuzehong@hotmail.com', '0038795ab795a52fd00280f97b57e5f6', NULL, NULL, NULL),
(49, NULL, NULL, 'linqiu126@sina.cn', '4760e2e3aafca2f4a603d51e52deb272', NULL, NULL, NULL),
(50, NULL, NULL, 'bxxh2015@sina.cn', 'c282e45fd6baf771929e3da07baa46d1', NULL, NULL, NULL),
(52, NULL, NULL, 'smdzjl@sina.cn', 'bb810bea5271778acb0970138798cb66', NULL, NULL, NULL),
(53, NULL, NULL, 'zsc0905@sina.com', 'c8ce578315b2942d07515e00bce18abe', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `token`
--

CREATE TABLE IF NOT EXISTS `token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  UNIQUE KEY `token_unique` (`user_id`,`code`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `token`
--

INSERT INTO `token` (`user_id`, `code`, `created_at`, `type`) VALUES
(51, 'TYBmCj5stq2EmG48q2AJ4FgqN7_-f_Dc', 1444047832, 0);

-- --------------------------------------------------------

--
-- 表的结构 `t_accesstoken`
--

CREATE TABLE IF NOT EXISTS `t_accesstoken` (
  `appid` char(20) NOT NULL,
  `appsecret` char(50) NOT NULL,
  `lasttime` int(6) NOT NULL,
  `access_token` text NOT NULL,
  `js_ticket` text NOT NULL,
  PRIMARY KEY (`appid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_accesstoken`
--

INSERT INTO `t_accesstoken` (`appid`, `appsecret`, `lasttime`, `access_token`, `js_ticket`) VALUES
('wx1183be5c8f6a24b4', 'd52a63064ed543c5eecae6c3df35be55', 1463366782, 'Lsj037a0ESUaboFyI2zfs4RreFVPcdzhK6bfl3e88c8hRWudxRmVnxGazA8tl7irqB6amZocY3-HzG9q3Or8QAlkzSmA7IM3GkIDaD4KdgxPje9NqJpEQPqRIMV8KrswHKEgAGADGA', 'kgt8ON7yVITDhtdwci0qebz_ZoAuborwySZXCjkJSWTLLNSUoMqZWGAntmgJ8dWryV6YAK_F6sAkPJCjrFpBiA');

-- --------------------------------------------------------

--
-- 表的结构 `t_account`
--

CREATE TABLE IF NOT EXISTS `t_account` (
  `uid` char(10) NOT NULL,
  `user` char(20) DEFAULT NULL,
  `nick` char(20) DEFAULT NULL,
  `pwd` char(20) DEFAULT NULL,
  `attribute` char(10) DEFAULT NULL,
  `phone` char(20) DEFAULT NULL,
  `email` char(50) DEFAULT NULL,
  `regdate` date DEFAULT NULL,
  `city` char(10) DEFAULT NULL,
  `backup` text,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_account`
--

INSERT INTO `t_account` (`uid`, `user`, `nick`, `pwd`, `attribute`, `phone`, `email`, `regdate`, `city`, `backup`) VALUES
('UID001', 'admin', '爱启用户', 'admin', '管理员', '13912341234', '13912341234@cmcc.com', '2016-05-28', '上海', ''),
('UID002', '李四', '老李', 'li_4', '管理员', '13912341234', '13912341234@cmcc.com', '2016-06-17', '上海', ''),
('UID003', 'user_01', '用户01', 'user01', '管理员', '13912349901', '13912349901@qq.com', '2016-04-01', '上海', NULL),
('UID004', 'user_02', '用户2', 'user02', '用户', '13912349902', '13912349902@qq.com', '2016-05-28', '上海', ''),
('UID005', 'user_03', '用户三', 'user03', '用户', '13912349903', '13912349902@qq.com', '2016-05-28', '上海', '');

-- --------------------------------------------------------

--
-- 表的结构 `t_airpressure`
--

CREATE TABLE IF NOT EXISTS `t_airpressure` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `airpressure` int(4) NOT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `altitude` int(4) NOT NULL,
  `flag_la` char(1) NOT NULL,
  `latitude` int(4) NOT NULL,
  `flag_lo` char(1) NOT NULL,
  `longitude` int(4) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_authlist`
--

CREATE TABLE IF NOT EXISTS `t_authlist` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `uid` char(10) NOT NULL,
  `auth_code` char(20) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

--
-- 转存表中的数据 `t_authlist`
--

INSERT INTO `t_authlist` (`sid`, `uid`, `auth_code`) VALUES
(1, 'UID001', 'P_0001'),
(2, 'UID001', 'P_0002'),
(3, 'UID003', 'PG_1111'),
(64, 'UID005', 'P_0002'),
(65, 'UID005', 'P_0004'),
(66, 'UID005', 'P_0012'),
(67, 'UID004', 'P_0008'),
(68, 'UID004', 'P_0009'),
(69, 'UID004', 'P_0010'),
(70, 'UID001', 'P_0003'),
(72, 'UID002', 'P_0004'),
(73, 'UID002', 'P_0010'),
(74, 'UID002', 'P_0012');

-- --------------------------------------------------------

--
-- 表的结构 `t_blebound`
--

CREATE TABLE IF NOT EXISTS `t_blebound` (
  `sid` int(6) NOT NULL AUTO_INCREMENT,
  `fromuser` char(50) NOT NULL,
  `deviceid` char(50) NOT NULL,
  `openid` char(50) NOT NULL,
  `devicetype` char(30) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `t_blebound`
--

INSERT INTO `t_blebound` (`sid`, `fromuser`, `deviceid`, `openid`, `devicetype`) VALUES
(6, 'oS0Chv3Uum1TZqHaCEb06AoBfCvY', 'gh_70c714952b02_8cd47e1f6141e49a4e45f4b807cf41fe', 'oS0Chv3Uum1TZqHaCEb06AoBfCvY', 'gh_70c714952b02'),
(7, 'oS0Chv-avCH7W4ubqOQAFXojYODY', 'gh_70c714952b02_8248307502397542f48a3775bcb234d4', 'oS0Chv-avCH7W4ubqOQAFXojYODY', 'gh_70c714952b02');

-- --------------------------------------------------------

--
-- 表的结构 `t_cmdbuf`
--

CREATE TABLE IF NOT EXISTS `t_cmdbuf` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `cmd` char(50) NOT NULL,
  `cmdtime` datetime NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=552 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_currentreport`
--

CREATE TABLE IF NOT EXISTS `t_currentreport` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `statcode` char(20) NOT NULL,
  `createtime` char(20) NOT NULL,
  `emcvalue` int(4) DEFAULT NULL,
  `pm01` int(4) DEFAULT NULL,
  `pm25` int(4) DEFAULT NULL,
  `pm10` int(4) DEFAULT NULL,
  `noise` int(4) DEFAULT NULL,
  `windspeed` int(4) DEFAULT NULL,
  `winddirection` int(4) DEFAULT NULL,
  `temperature` int(4) DEFAULT NULL,
  `humidity` int(4) DEFAULT NULL,
  `rain` int(4) DEFAULT NULL,
  `airpressure` int(4) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `t_currentreport`
--

INSERT INTO `t_currentreport` (`sid`, `deviceid`, `statcode`, `createtime`, `emcvalue`, `pm01`, `pm25`, `pm10`, `noise`, `windspeed`, `winddirection`, `temperature`, `humidity`, `rain`, `airpressure`) VALUES
(2, 'HCU_SH_0301', '120101001', '2016-04-27 19:48:03', 5219, 231, 231, 637, 641, 0, 106, 188, 205, 0, 0),
(15, 'HCU_SH_0302', '120101002', '2016-06-19 12:56:19', 5050, NULL, NULL, NULL, NULL, NULL, NULL, 451, 350, NULL, NULL),
(6, 'HCU_SH_0305', '120101005', '2016-05-10 15:27:44', 4867, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'HCU_SH_0309', '120101009', '2016-06-18 23:30:39', 5151, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'HCU_SH_0304', '120101004', '2016-06-16 17:41:00', 4767, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'HCU_SH_0303', '120101003', '2016-06-12 15:29:50', 5620, 136, 136, 237, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `t_dataformat`
--

CREATE TABLE IF NOT EXISTS `t_dataformat` (
  `deviceid` char(50) NOT NULL,
  `f_airpressure` int(1) DEFAULT NULL,
  `f_emcdata` int(1) DEFAULT NULL,
  `f_humidity` int(1) DEFAULT NULL,
  `f_noise` int(1) DEFAULT NULL,
  `f_pmdata` int(1) DEFAULT NULL,
  `f_rain` int(1) DEFAULT NULL,
  `f_temperature` int(1) DEFAULT NULL,
  `f_winddirection` int(1) DEFAULT NULL,
  `f_windspeed` int(1) DEFAULT NULL,
  PRIMARY KEY (`deviceid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_dataformat`
--

INSERT INTO `t_dataformat` (`deviceid`, `f_airpressure`, `f_emcdata`, `f_humidity`, `f_noise`, `f_pmdata`, `f_rain`, `f_temperature`, `f_winddirection`, `f_windspeed`) VALUES
('HCU_SH_0301', 0, 1, 1, 2, 1, 0, 1, 1, 1),
('HCU_SH_0303', NULL, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL),
('HCU_SH_0302', NULL, 1, 1, NULL, NULL, NULL, 1, NULL, NULL),
('HCU_SH_0305', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('HCU_SH_0304', NULL, 1, 1, NULL, NULL, NULL, 1, NULL, NULL),
('HCU_SH_0309', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `t_deviceqrcode`
--

CREATE TABLE IF NOT EXISTS `t_deviceqrcode` (
  `deviceid` char(50) NOT NULL,
  `qrcode` char(100) NOT NULL,
  `devicetype` char(30) NOT NULL,
  `macaddr` char(20) NOT NULL,
  PRIMARY KEY (`deviceid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_deviceqrcode`
--

INSERT INTO `t_deviceqrcode` (`deviceid`, `qrcode`, `devicetype`, `macaddr`) VALUES
('gh_70c714952b02_8cd47e1f6141e49a4e45f4b807cf41fe', 'http://we.qq.com/d/AQBLQKG-27gIDCKf03DmiwAXh27qptK_scSJJRAn', 'gh_70c714952b02', 'D03972A5EF28'),
('gh_70c714952b02_8248307502397542f48a3775bcb234d4', 'http://we.qq.com/d/AQBLQKG-cFODzg6aCE5C92D1SKGHOirRJtBGwCmd', 'gh_70c714952b02', 'D03972A5EF27');

-- --------------------------------------------------------

--
-- 表的结构 `t_deviceversion`
--

CREATE TABLE IF NOT EXISTS `t_deviceversion` (
  `deviceid` char(50) NOT NULL,
  `hw_type` int(1) DEFAULT NULL,
  `hw_ver` int(2) DEFAULT NULL,
  `sw_rel` int(1) DEFAULT NULL,
  `sw_drop` int(2) DEFAULT NULL,
  PRIMARY KEY (`deviceid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_deviceversion`
--

INSERT INTO `t_deviceversion` (`deviceid`, `hw_type`, `hw_ver`, `sw_rel`, `sw_drop`) VALUES
('HCU_SH_0304', 2, 3, 1, 90),
('HCU_SH_0302', 2, 3, 1, 92);

-- --------------------------------------------------------

--
-- 表的结构 `t_emcaccumulation`
--

CREATE TABLE IF NOT EXISTS `t_emcaccumulation` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `lastupdatedate` date NOT NULL,
  `avg30days` char(192) NOT NULL,
  `avg3month` char(192) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `t_emcaccumulation`
--

INSERT INTO `t_emcaccumulation` (`sid`, `deviceid`, `lastupdatedate`, `avg30days`, `avg3month`) VALUES
(1, 'HCU_SH_0301', '2016-04-27', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0'),
(2, 'gh_70c714952b02_8248307502397542f48a3775bcb234d4', '2016-04-23', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0'),
(3, 'HCU_SH_0302', '2016-06-19', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0'),
(4, 'HCU_SH_0303', '2016-06-12', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0'),
(5, 'HCU_SH_0305', '2016-06-29', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0'),
(6, 'HCU_SH_0304', '2016-06-16', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0'),
(7, 'HCU_SH_0309', '2016-06-18', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0');

-- --------------------------------------------------------

--
-- 表的结构 `t_emcdata`
--

CREATE TABLE IF NOT EXISTS `t_emcdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `emcvalue` int(4) NOT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `altitude` int(4) NOT NULL,
  `flag_la` char(1) NOT NULL,
  `latitude` int(4) NOT NULL,
  `flag_lo` char(1) NOT NULL,
  `longitude` int(4) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63696 ;

--
-- 转存表中的数据 `t_emcdata`
--

INSERT INTO `t_emcdata` (`sid`, `deviceid`, `sensorid`, `emcvalue`, `dataflag`, `reportdate`, `hourminindex`, `altitude`, `flag_la`, `latitude`, `flag_lo`, `longitude`) VALUES
(63695, 'HCU_SH_0305', 5, 4867, 'N', '2016-05-10', 927, 0, 'N', 0, 'E', 0);

-- --------------------------------------------------------

--
-- 表的结构 `t_hcudevice`
--

CREATE TABLE IF NOT EXISTS `t_hcudevice` (
  `devcode` char(20) NOT NULL,
  `statcode` char(20) DEFAULT NULL,
  `macaddr` char(20) DEFAULT NULL,
  `ipaddr` char(15) DEFAULT NULL,
  `switch` char(3) NOT NULL DEFAULT '0',
  `videourl` text,
  `sensorlist` char(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`devcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_hcudevice`
--

INSERT INTO `t_hcudevice` (`devcode`, `statcode`, `macaddr`, `ipaddr`, `switch`, `videourl`, `sensorlist`) VALUES
('HCU_SH_0301', '120101001', '', '', 'on', '', 'S_0001;S_0002;S_0003;S_0005;S_0006;S_0007;S_000A;'),
('HCU_SH_0302', '120101015', '', '', 'off', 'http://192.168.31.232:8000/avorion/avorion201606061346.h264', 'S_0001;S_0002;S_0003;S_0005;S_0006;S_0007;S_000A;'),
('HCU_SH_0305', '120101005', '', '', 'off', '', 'S_0002;S_0003;S_0005;S_0006;S_0007;'),
('HCU_SH_0304', '120101004', '', '', 'off', '', 'S_0005;'),
('HCU_SH_0303', '120101003', '', '', 'on', 'http://192.168.1.232:8000/avorion/avorion201606041614.h264', 'S_0001;S_0005;'),
('HCU_SH_0309', '120101009', '', '', 'off', '', 'S_0005;S_006;');

-- --------------------------------------------------------

--
-- 表的结构 `t_hourreport`
--

CREATE TABLE IF NOT EXISTS `t_hourreport` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `devcode` char(20) NOT NULL,
  `statcode` char(20) DEFAULT NULL,
  `reportdate` date NOT NULL,
  `hourindex` int(1) NOT NULL,
  `emcvalue` int(4) DEFAULT NULL,
  `pm01` int(4) DEFAULT NULL,
  `pm25` int(4) DEFAULT NULL,
  `pm10` int(4) DEFAULT NULL,
  `noise` int(4) DEFAULT NULL,
  `windspeed` int(4) DEFAULT NULL,
  `winddirection` int(4) DEFAULT NULL,
  `rain` int(4) DEFAULT NULL,
  `temperature` int(4) DEFAULT NULL,
  `humidity` int(4) DEFAULT NULL,
  `airpressure` int(4) DEFAULT NULL,
  `datastatus` char(10) DEFAULT NULL,
  `validdatanum` int(1) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- 转存表中的数据 `t_hourreport`
--

INSERT INTO `t_hourreport` (`sid`, `devcode`, `statcode`, `reportdate`, `hourindex`, `emcvalue`, `pm01`, `pm25`, `pm10`, `noise`, `windspeed`, `winddirection`, `rain`, `temperature`, `humidity`, `airpressure`, `datastatus`, `validdatanum`) VALUES
(1, '', NULL, '0000-00-00', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '', NULL, '0000-00-00', 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '', NULL, '0000-00-00', 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '', NULL, '0000-00-00', 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, '', NULL, '0000-00-00', 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, '', NULL, '0000-00-00', 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, '', NULL, '0000-00-00', 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, '', NULL, '0000-00-00', 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, '', NULL, '0000-00-00', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '', NULL, '0000-00-00', 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, '', NULL, '0000-00-00', 0, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, '', NULL, '0000-00-00', 0, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, '', NULL, '0000-00-00', 0, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, '', NULL, '0000-00-00', 0, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, '', NULL, '0000-00-00', 0, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, '', NULL, '0000-00-00', 0, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '', NULL, '0000-00-00', 0, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, '', NULL, '0000-00-00', 0, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, '', NULL, '0000-00-00', 0, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, '', NULL, '0000-00-00', 0, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, '', NULL, '0000-00-00', 0, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, '', NULL, '0000-00-00', 0, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, '', NULL, '0000-00-00', 0, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `t_humidity`
--

CREATE TABLE IF NOT EXISTS `t_humidity` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `humidity` int(4) NOT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `altitude` int(4) NOT NULL,
  `flag_la` char(1) NOT NULL,
  `latitude` int(4) NOT NULL,
  `flag_lo` char(1) NOT NULL,
  `longitude` int(4) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19899 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_loginfo`
--

CREATE TABLE IF NOT EXISTS `t_loginfo` (
  `sid` int(6) NOT NULL AUTO_INCREMENT,
  `project` char(5) NOT NULL,
  `fromuser` char(50) NOT NULL,
  `createtime` char(20) NOT NULL,
  `logdata` text NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=581091 ;

--
-- 转存表中的数据 `t_loginfo`
--

INSERT INTO `t_loginfo` (`sid`, `project`, `fromuser`, `createtime`, `logdata`) VALUES
(581026, 'HCU', 'HCU_SH_0305', '2016-05-12 23:23:06', 'R:<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0305]]></FromUserName><CreateTime>1463066586</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201130345000000004E000000000000000057318D70]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581027, 'HCU', 'HCU_SH_0305', '2016-05-12 23:23:06', 'R:<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0305]]></FromUserName><CreateTime>1463066586</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201130345000000004E000000000000000057318D70]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581028, 'HCU', 'HCU_SH_0302', '2016-04-07 22:25:52', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201124945000000004E000000000000000057066DF0]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581029, 'HCU', 'AQ_HCU', '2016-06-29 20:25:06', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581030, 'HCU', 'HCU_SH_0301', '2016-03-13 20:33:24', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872404</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[252281010201000001120000011200000492000000000000000000000000000056E55E14]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581031, 'HCU', 'AQ_HCU', '2016-06-29 20:25:06', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581032, 'HCU', 'HCU_SH_0301', '2016-04-07 07:36:48', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1459985808</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[261881020201000045000000004E000000000000000057059D90]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581033, 'HCU', 'AQ_HCU', '2016-06-29 20:25:06', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581034, 'HCU', 'HCU_SH_0301', '2016-04-06 07:32:06', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1459899126</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[271881030201008D45000000004E000000000000000057044AF5]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581035, 'HCU', 'AQ_HCU', '2016-06-29 20:25:06', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581036, 'HCU', 'HCU_SH_0301', '2016-03-13 20:33:42', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872422</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[2818810602010223000000000000000000000000000056E55E26]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581037, 'HCU', 'AQ_HCU', '2016-06-29 20:25:06', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581038, 'HCU', 'HCU_SH_0301', '2016-03-13 20:35:25', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872525</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[29188106020100AC000000000000000000000000000056E55E8D]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581039, 'HCU', 'AQ_HCU', '2016-06-29 20:25:06', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581040, 'HCU', 'HCU_SH_0301', '2016-03-13 20:38:51', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872731</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[2B1A810A02020000028B000000000000000000000000000056E55F5B]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581041, 'HCU', 'AQ_HCU', '2016-06-29 20:25:06', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581042, 'HCU', 'HCU_SH_0301', '2016-03-13 20:33:29', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872409</CreateTime><MsgType><![CDATA[hcu_heart_beat]]></MsgType><Content><![CDATA[FE00]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581043, 'HCU', 'AQ_HCU', '2016-06-29 20:25:06', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581044, 'HCU', 'HCU_SH_0301', '2016-03-13 20:35:59', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872559</CreateTime><MsgType><![CDATA[hcu_command]]></MsgType><Content><![CDATA[FD00]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581045, 'HCU', 'AQ_HCU', '2016-06-29 20:25:06', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581046, 'HCU', 'HCU_SH_0305', '2016-05-12 23:23:06', 'R:<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0305]]></FromUserName><CreateTime>1463066586</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201130345000000004E000000000000000057318D70]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581047, 'HCU', 'ZHBMSG', '2016-06-29 20:25:06', 'R:##007020160619033803000___11111ZHB_NOMHCU_SH_0304_44444405556666a01000=139A,68BE'),
(581048, 'HCU', 'AQ_HCU', '2016-06-29 20:25:06', 'T:'),
(581049, 'HCU', 'HCU_SH_0302', '2016-04-07 22:25:52', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201124945000000004E000000000000000057066DF0]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581050, 'HCU', 'AQ_HCU', '2016-06-29 20:27:34', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581051, 'HCU', 'HCU_SH_0301', '2016-03-13 20:33:24', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872404</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[252281010201000001120000011200000492000000000000000000000000000056E55E14]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581052, 'HCU', 'AQ_HCU', '2016-06-29 20:27:34', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581053, 'HCU', 'HCU_SH_0301', '2016-04-07 07:36:48', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1459985808</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[261881020201000045000000004E000000000000000057059D90]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581054, 'HCU', 'AQ_HCU', '2016-06-29 20:27:34', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581055, 'HCU', 'HCU_SH_0301', '2016-04-06 07:32:06', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1459899126</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[271881030201008D45000000004E000000000000000057044AF5]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581056, 'HCU', 'AQ_HCU', '2016-06-29 20:27:34', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581057, 'HCU', 'HCU_SH_0301', '2016-03-13 20:33:42', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872422</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[2818810602010223000000000000000000000000000056E55E26]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581058, 'HCU', 'AQ_HCU', '2016-06-29 20:27:34', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581059, 'HCU', 'HCU_SH_0301', '2016-03-13 20:35:25', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872525</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[29188106020100AC000000000000000000000000000056E55E8D]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581060, 'HCU', 'AQ_HCU', '2016-06-29 20:27:34', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581061, 'HCU', 'HCU_SH_0301', '2016-03-13 20:38:51', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872731</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[2B1A810A02020000028B000000000000000000000000000056E55F5B]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581062, 'HCU', 'AQ_HCU', '2016-06-29 20:27:34', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581063, 'HCU', 'HCU_SH_0301', '2016-03-13 20:33:29', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872409</CreateTime><MsgType><![CDATA[hcu_heart_beat]]></MsgType><Content><![CDATA[FE00]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581064, 'HCU', 'AQ_HCU', '2016-06-29 20:27:34', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581065, 'HCU', 'HCU_SH_0301', '2016-03-13 20:35:59', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872559</CreateTime><MsgType><![CDATA[hcu_command]]></MsgType><Content><![CDATA[FD00]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581066, 'HCU', 'AQ_HCU', '2016-06-29 20:27:34', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581067, 'HCU', 'HCU_SH_0305', '2016-05-12 23:23:06', 'R:<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0305]]></FromUserName><CreateTime>1463066586</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201130345000000004E000000000000000057318D70]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581068, 'HCU', 'ZHBMSG', '2016-06-29 20:27:34', 'R:##007020160619033803000___11111ZHB_NOMHCU_SH_0304_44444405556666a01000=139A,68BE'),
(581069, 'HCU', 'AQ_HCU', '2016-06-29 20:27:34', 'T:'),
(581070, 'HCU', 'HCU_SH_0302', '2016-04-07 22:25:52', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201124945000000004E000000000000000057066DF0]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581071, 'HCU', 'AQ_HCU', '2016-06-29 20:27:47', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581072, 'HCU', 'HCU_SH_0301', '2016-03-13 20:33:24', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872404</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[252281010201000001120000011200000492000000000000000000000000000056E55E14]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581073, 'HCU', 'AQ_HCU', '2016-06-29 20:27:47', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581074, 'HCU', 'HCU_SH_0301', '2016-04-07 07:36:48', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1459985808</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[261881020201000045000000004E000000000000000057059D90]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581075, 'HCU', 'AQ_HCU', '2016-06-29 20:27:47', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581076, 'HCU', 'HCU_SH_0301', '2016-04-06 07:32:06', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1459899126</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[271881030201008D45000000004E000000000000000057044AF5]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581077, 'HCU', 'AQ_HCU', '2016-06-29 20:27:47', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581078, 'HCU', 'HCU_SH_0301', '2016-03-13 20:33:42', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872422</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[2818810602010223000000000000000000000000000056E55E26]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581079, 'HCU', 'AQ_HCU', '2016-06-29 20:27:47', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581080, 'HCU', 'HCU_SH_0301', '2016-03-13 20:35:25', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872525</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[29188106020100AC000000000000000000000000000056E55E8D]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581081, 'HCU', 'AQ_HCU', '2016-06-29 20:27:47', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581082, 'HCU', 'HCU_SH_0301', '2016-03-13 20:38:51', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872731</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[2B1A810A02020000028B000000000000000000000000000056E55F5B]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581083, 'HCU', 'AQ_HCU', '2016-06-29 20:27:47', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581084, 'HCU', 'HCU_SH_0301', '2016-03-13 20:33:29', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872409</CreateTime><MsgType><![CDATA[hcu_heart_beat]]></MsgType><Content><![CDATA[FE00]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581085, 'HCU', 'AQ_HCU', '2016-06-29 20:27:47', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581086, 'HCU', 'HCU_SH_0301', '2016-03-13 20:35:59', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872559</CreateTime><MsgType><![CDATA[hcu_command]]></MsgType><Content><![CDATA[FD00]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581087, 'HCU', 'AQ_HCU', '2016-06-29 20:27:47', 'T:"HCU_IOT: XML message invalid ToUserName"'),
(581088, 'HCU', 'HCU_SH_0305', '2016-05-12 23:23:06', 'R:<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0305]]></FromUserName><CreateTime>1463066586</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201130345000000004E000000000000000057318D70]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581089, 'HCU', 'ZHBMSG', '2016-06-29 20:27:47', 'R:##007020160619033803000___11111ZHB_NOMHCU_SH_0304_44444405556666a01000=139A,68BE'),
(581090, 'HCU', 'AQ_HCU', '2016-06-29 20:27:47', 'T:');

-- --------------------------------------------------------

--
-- 表的结构 `t_logswitch`
--

CREATE TABLE IF NOT EXISTS `t_logswitch` (
  `user` char(50) NOT NULL,
  `switch` char(1) NOT NULL,
  PRIMARY KEY (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_logswitch`
--

INSERT INTO `t_logswitch` (`user`, `switch`) VALUES
('oS0Chv3Uum1TZqHaCEb06AoBfCvY', '1'),
('oS0Chv-avCH7W4ubqOQAFXojYODY', '1');

-- --------------------------------------------------------

--
-- 表的结构 `t_minreport`
--

CREATE TABLE IF NOT EXISTS `t_minreport` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `devcode` char(20) NOT NULL,
  `statcode` char(20) NOT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `emcvalue` int(4) DEFAULT NULL,
  `pm01` int(4) DEFAULT NULL,
  `pm25` int(4) DEFAULT NULL,
  `pm10` int(4) DEFAULT NULL,
  `noise` int(4) DEFAULT NULL,
  `windspeed` int(4) DEFAULT NULL,
  `winddirection` int(4) DEFAULT NULL,
  `rain` int(4) DEFAULT NULL,
  `temperature` int(4) DEFAULT NULL,
  `humidity` int(4) DEFAULT NULL,
  `airpressure` int(4) DEFAULT NULL,
  `pmdataflag` char(10) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55778 ;

--
-- 转存表中的数据 `t_minreport`
--

INSERT INTO `t_minreport` (`sid`, `devcode`, `statcode`, `reportdate`, `hourminindex`, `emcvalue`, `pm01`, `pm25`, `pm10`, `noise`, `windspeed`, `winddirection`, `rain`, `temperature`, `humidity`, `airpressure`, `pmdataflag`) VALUES
(614, 'HCU_SH_0302', '120101002', '2016-04-21', 1387, 5655, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 228, NULL, NULL),
(615, 'HCU_SH_0302', '120101002', '2016-04-21', 1388, 4795, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 228, NULL, NULL),
(616, 'HCU_SH_0302', '120101002', '2016-04-21', 1389, 5247, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 702, 228, NULL, NULL),
(617, 'HCU_SH_0302', '120101002', '2016-04-21', 1390, 4706, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 702, 228, NULL, NULL),
(618, 'HCU_SH_0302', '120101002', '2016-04-21', 1391, 5166, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 702, 228, NULL, NULL),
(619, 'HCU_SH_0302', '120101002', '2016-04-21', 1392, 5461, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 702, 228, NULL, NULL),
(620, 'HCU_SH_0302', '120101002', '2016-04-21', 1393, 5593, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, NULL, NULL, NULL),
(621, 'HCU_SH_0302', '120101002', '2016-04-21', 1394, 5328, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 228, NULL, NULL),
(622, 'HCU_SH_0302', '120101002', '2016-04-21', 1395, 5034, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 228, NULL, NULL),
(623, 'HCU_SH_0302', '120101002', '2016-04-21', 1396, 5348, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 228, NULL, NULL),
(624, 'HCU_SH_0302', '120101002', '2016-04-21', 1397, 5623, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 227, NULL, NULL),
(625, 'HCU_SH_0302', '120101002', '2016-04-21', 1398, 5239, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 227, NULL, NULL),
(626, 'HCU_SH_0302', '120101002', '2016-04-21', 1399, 5251, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 227, NULL, NULL),
(627, 'HCU_SH_0302', '120101002', '2016-04-21', 1400, 5201, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 227, NULL, NULL),
(628, 'HCU_SH_0302', '120101002', '2016-04-21', 1401, 5542, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 699, 227, NULL, NULL),
(629, 'HCU_SH_0302', '120101002', '2016-04-21', 1402, 4939, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 699, 227, NULL, NULL),
(630, 'HCU_SH_0302', '120101002', '2016-04-21', 1403, 5280, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 698, 227, NULL, NULL),
(631, 'HCU_SH_0302', '120101002', '2016-04-21', 1404, 5481, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 698, 227, NULL, NULL),
(632, 'HCU_SH_0302', '120101002', '2016-04-21', 1405, 4966, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 698, 227, NULL, NULL),
(633, 'HCU_SH_0302', '120101002', '2016-04-21', 1406, 5447, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 697, 227, NULL, NULL),
(634, 'HCU_SH_0302', '120101002', '2016-04-21', 1407, 5469, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 696, 227, NULL, NULL),
(635, 'HCU_SH_0302', '120101002', '2016-04-21', 1408, 4858, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 696, 227, NULL, NULL),
(636, 'HCU_SH_0302', '120101002', '2016-04-21', 1409, 5177, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 227, NULL, NULL),
(637, 'HCU_SH_0302', '120101002', '2016-04-21', 1410, 4908, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 696, 227, NULL, NULL),
(55777, 'HCU_SH_0305', '120101005', '2016-05-10', 927, 4867, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `t_noisedata`
--

CREATE TABLE IF NOT EXISTS `t_noisedata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `noise` int(4) NOT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `altitude` int(4) NOT NULL,
  `flag_la` char(1) NOT NULL,
  `latitude` int(4) NOT NULL,
  `flag_lo` char(1) NOT NULL,
  `longitude` int(4) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9319 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_pmdata`
--

CREATE TABLE IF NOT EXISTS `t_pmdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `pm01` int(4) NOT NULL,
  `pm25` int(4) NOT NULL,
  `pm10` int(4) NOT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `altitude` int(4) NOT NULL,
  `flag_la` char(1) NOT NULL,
  `latitude` int(4) NOT NULL,
  `flag_lo` char(1) NOT NULL,
  `longitude` int(4) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4058 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_projgroup`
--

CREATE TABLE IF NOT EXISTS `t_projgroup` (
  `pg_code` char(20) NOT NULL,
  `pg_name` char(50) DEFAULT NULL,
  `owner` char(20) DEFAULT NULL,
  `phone` char(20) DEFAULT NULL,
  `department` char(50) DEFAULT NULL,
  `addr` char(100) DEFAULT NULL,
  `backup` text,
  PRIMARY KEY (`pg_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_projgroup`
--

INSERT INTO `t_projgroup` (`pg_code`, `pg_name`, `owner`, `phone`, `department`, `addr`, `backup`) VALUES
('PG_1111', '扬尘项目组', '张三', '13912341234', '扬尘项目组单位', '扬尘项目组单位地址', '该项目组管理所有扬尘项目的用户，项目以及相关权限'),
('PG_2222', '污水处理项目组', '李四', '13912349999', '污水项目组单位', '污水项目组单位地址', '该项目组管理所有污水处理项目的用户，项目以及相关权限');

-- --------------------------------------------------------

--
-- 表的结构 `t_projinfo`
--

CREATE TABLE IF NOT EXISTS `t_projinfo` (
  `p_code` char(20) NOT NULL,
  `p_name` char(50) NOT NULL,
  `chargeman` char(20) NOT NULL,
  `telephone` char(20) NOT NULL,
  `department` char(30) NOT NULL,
  `address` char(30) NOT NULL,
  `country` char(20) NOT NULL,
  `street` char(20) NOT NULL,
  `square` int(4) NOT NULL,
  `starttime` date NOT NULL,
  `pre_endtime` date NOT NULL,
  `true_endtime` date NOT NULL,
  `stage` text NOT NULL,
  PRIMARY KEY (`p_code`),
  KEY `statCode` (`p_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_projinfo`
--

INSERT INTO `t_projinfo` (`p_code`, `p_name`, `chargeman`, `telephone`, `department`, `address`, `country`, `street`, `square`, `starttime`, `pre_endtime`, `true_endtime`, `stage`) VALUES
('P_0014', '万宝国际广场', '张三', '13912345678', '上海建筑', '延安西路500号', '长宁区', '', 10000, '2015-04-01', '2016-05-01', '2016-05-31', '项目延期1月'),
('P_0019', '港运大厦', '张三', '13912345678', '', '杨树浦路1963弄24号', '虹口区', '', 0, '2016-04-01', '0000-00-00', '0000-00-00', ''),
('P_0002', '浦东环球金融中心工程', '张三', '13912345678', '浦东建筑', '世纪大道100号', '浦东新区', '', 40000, '2015-01-01', '0000-00-00', '0000-00-00', '项目延期'),
('P_0004', '金桥创科园', '李四', '13912345678', '', '桂桥路255号', '浦东新区', '', 0, '2016-04-01', '0000-00-00', '0000-00-00', ''),
('P_0005', '江湾体育场', '李四', '13912345678', '上海建筑', '国和路346号', '杨浦区', '', 0, '2016-04-13', '0000-00-00', '0000-00-00', ''),
('P_0006', '滨海新村', '李四', '13912345678', '', '同泰北路100号', '宝山区', '', 0, '2016-02-01', '0000-00-00', '0000-00-00', ''),
('P_0007', '银都苑', '李四', '13912345678', '', '银都路3118弄', '闵行区', '', 0, '2016-02-01', '0000-00-00', '0000-00-00', ''),
('P_0008', '万科花园小城', '王五', '13912345678', '', '龙吴路5710号', '闵行区', '', 0, '2016-02-18', '0000-00-00', '0000-00-00', ''),
('P_0009', '合生国际花园', '王五', '13912345678', '', '长兴东路1290', '松江区', '', 0, '2016-02-18', '0000-00-00', '0000-00-00', ''),
('P_0010', '江南国际会议中心', '王五', '13912345678', '', '青浦区Y095(阁游路)', '青浦区', '', 0, '2016-02-18', '0000-00-00', '0000-00-00', ''),
('P_0011', '佳邸别墅', '王五', '13912345678', '', '盈港路1555弄', '青浦区', '', 0, '2016-02-18', '0000-00-00', '0000-00-00', ''),
('P_0012', '西郊河畔家园', '王五', '13912345678', '', '繁兴路469弄', '闵行区', '华漕镇', 0, '2016-02-18', '0000-00-00', '0000-00-00', ''),
('P_0013', '东视大厦', '赵六', '13912345678', '', '东方路2000号', '浦东新区', '南码头', 0, '2016-02-18', '0000-00-00', '0000-00-00', ''),
('P_0001', '曙光大厦', '赵六', '13912345678', '', '普安路189号', '黄埔区', '淮海中路街道', 0, '2016-02-29', '0000-00-00', '0000-00-00', ''),
('P_0015', '上海贝尔', '赵六', '13912345678', '', '西藏北路525号', '闸北区', '芷江西路街道', 0, '2016-03-15', '0000-00-00', '0000-00-00', ''),
('P_0016', '嘉宝大厦', '赵六', '13912345678', '', '洪德路1009号', '嘉定区', '马陆镇', 0, '2015-03-19', '0000-00-00', '0000-00-00', ''),
('P_0017', '金山豪庭', '赵六', '13912345678', '', '卫清东路2988', '金山区', '', 0, '2015-08-25', '0000-00-00', '0000-00-00', ''),
('P_0018', '临港城投大厦', '赵六', '13912345678', '', '环湖西一路333号', '浦东新区', '', 0, '2015-11-30', '0000-00-00', '0000-00-00', ''),
('P_0003', '金鹰大厦', '张三', '13912345678', '上海爱启', '含笑路80号', '浦东新区', '联洋街道', 10000, '2015-04-30', '2016-05-01', '2016-05-31', '项目进行中');

-- --------------------------------------------------------

--
-- 表的结构 `t_projmapping`
--

CREATE TABLE IF NOT EXISTS `t_projmapping` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `p_code` char(20) NOT NULL,
  `pg_code` char(20) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- 转存表中的数据 `t_projmapping`
--

INSERT INTO `t_projmapping` (`sid`, `p_code`, `pg_code`) VALUES
(1, 'P_0001', 'PG_1111'),
(2, 'P_0002', 'PG_2222'),
(5, 'P_0004', 'PG_1111'),
(6, 'P_0006', 'PG_2222'),
(7, 'P_0005', 'PG_1111'),
(8, 'P_0007', 'PG_2222'),
(9, 'P_0008', 'PG_2222'),
(10, 'P_0009', 'PG_1111'),
(11, 'P_0010', 'PG_2222'),
(12, 'P_0003', 'PG_1111'),
(13, 'P_0011', 'PG_1111'),
(14, 'P_0012', 'PG_1111'),
(15, 'P_0013', 'PG_1111'),
(16, 'P_0014', 'PG_1111'),
(17, 'P_0015', 'PG_1111'),
(18, 'P_0018', 'PG_2222'),
(19, 'P_0017', 'PG_2222'),
(20, 'P_0016', 'PG_2222'),
(36, 'P_0015', 'PG_3333'),
(37, 'P_0017', 'PG_3333'),
(38, 'P_0018', 'PG_3333');

-- --------------------------------------------------------

--
-- 表的结构 `t_rain`
--

CREATE TABLE IF NOT EXISTS `t_rain` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `rain` int(4) NOT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `altitude` int(4) NOT NULL,
  `flag_la` char(1) NOT NULL,
  `latitude` int(4) NOT NULL,
  `flag_lo` char(1) NOT NULL,
  `longitude` int(4) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_sensorinfo`
--

CREATE TABLE IF NOT EXISTS `t_sensorinfo` (
  `id` char(6) NOT NULL,
  `name` char(10) NOT NULL,
  `model` char(20) NOT NULL,
  `vendor` char(20) NOT NULL,
  `modbus` int(1) DEFAULT NULL COMMENT 'MODBUS地址',
  `period` int(2) DEFAULT NULL COMMENT '测量周期，单位秒',
  `samples` int(2) DEFAULT NULL COMMENT '采样间隔，单位秒',
  `times` int(2) DEFAULT NULL COMMENT '测量次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_sensorinfo`
--

INSERT INTO `t_sensorinfo` (`id`, `name`, `model`, `vendor`, `modbus`, `period`, `samples`, `times`) VALUES
('S_0001', '细颗粒物', 'PM-100', '爱启公司', 1, 100, 500, 200),
('S_0002', '风速', 'WS-100', '爱启公司', 2, NULL, NULL, NULL),
('S_0003', '风向', 'WD-100', '爱启公司', 3, NULL, NULL, NULL),
('S_0005', '电磁辐射', 'EMC-100', '小慧智能科技', 5, NULL, NULL, NULL),
('S_0006', '温度', 'TE-100', '小慧智能科技', 6, NULL, NULL, NULL),
('S_0007', '湿度', 'TH-100', '小慧智能科技', 6, NULL, NULL, NULL),
('S_000A', '噪声', 'NO-100', '小慧智能科技', 10, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `t_sensortype`
--

CREATE TABLE IF NOT EXISTS `t_sensortype` (
  `id` char(6) NOT NULL,
  `name` char(10) NOT NULL,
  `model` char(20) NOT NULL,
  `vendor` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_session`
--

CREATE TABLE IF NOT EXISTS `t_session` (
  `sessionid` char(8) NOT NULL,
  `uid` char(20) NOT NULL,
  `lastupdate` int(4) NOT NULL,
  PRIMARY KEY (`sessionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_session`
--

INSERT INTO `t_session` (`sessionid`, `uid`, `lastupdate`) VALUES
('KpjEAyCZ', 'UID001', 1466300141);

-- --------------------------------------------------------

--
-- 表的结构 `t_temperature`
--

CREATE TABLE IF NOT EXISTS `t_temperature` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `temperature` int(4) NOT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `altitude` int(4) NOT NULL,
  `flag_la` char(1) NOT NULL,
  `latitude` int(4) NOT NULL,
  `flag_lo` char(1) NOT NULL,
  `longitude` int(4) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21027 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_videodata`
--

CREATE TABLE IF NOT EXISTS `t_videodata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `videourl` text NOT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `altitude` int(4) NOT NULL,
  `flag_la` char(1) NOT NULL,
  `latitude` int(4) NOT NULL,
  `flag_lo` char(1) NOT NULL,
  `longitude` int(4) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28070 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_winddirection`
--

CREATE TABLE IF NOT EXISTS `t_winddirection` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `winddirection` int(4) NOT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `altitude` int(4) NOT NULL,
  `flag_la` char(1) NOT NULL,
  `latitude` int(4) NOT NULL,
  `flag_lo` char(1) NOT NULL,
  `longitude` int(4) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9992 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_windspeed`
--

CREATE TABLE IF NOT EXISTS `t_windspeed` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `windspeed` int(4) NOT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `altitude` int(4) NOT NULL,
  `flag_la` char(1) NOT NULL,
  `latitude` int(4) NOT NULL,
  `flag_lo` char(1) NOT NULL,
  `longitude` int(4) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9968 ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(60) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_unique_username` (`username`),
  UNIQUE KEY `user_unique_email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password_hash`, `auth_key`, `confirmed_at`, `unconfirmed_email`, `blocked_at`, `registration_ip`, `created_at`, `updated_at`, `flags`) VALUES
(50, 'bxxh2015', 'bxxh2015@sina.cn', '$2y$12$3vo17XiHR8tzfmAsXOK8BeDJsd38ONOSTjbv0C19qbpr2C7IfDggK', '3au2TiBE1NjaP0D0iy9-e9MzFLJ5I7ws', 1442896173, NULL, NULL, '183.193.36.164', 1442896107, 1442896173, 0),
(49, 'linqiu12611', 'linqiu126@sina.cn', '$2y$12$9zRpK4xehj5s/npanxz6O.P1njI5MUsDBB9wskUYJ12cuTWZdrcJq', 'bqjflR9mJOyioXiYhQUGfWjMDPIg-GSJ', 1442894217, NULL, NULL, '183.193.36.164', 1442894194, 1442894217, 0),
(51, 'mfuncloud', 'liuzehong@hotmail.com', '$2y$12$/zjcwitKWqk.hfa.ligqFOtmiHMwProHj.QugIuvYFvFxY7MbY7om', 'k05QvRL9FCgxSv13BcB363dcPOFF2hJA', NULL, NULL, NULL, '101.226.125.122', 1444047832, 1444047832, 0),
(52, 'zjl', 'smdzjl@sina.cn', '$2y$12$pCBD9e0/B0bvwKs6crXA2.pzy606Bn4o19Bzx1r8jdjr1t1nN/jc.', 'GPJwlaHeV0JaMswrLuai0JsW7H8aUjPh', 1444091551, NULL, NULL, '117.135.149.14', 1444091501, 1444091551, 0),
(53, 'shanchuz', 'zsc0905@sina.com', '$2y$12$mlslUwrYelb5nV6DfYot9ORgYGI9YB5.bN/HCMYru6QRn6UrfJsP6', '7VMvRAprvPsYU-Fqt6jDYeLvUzfLzdjF', 1444527288, NULL, NULL, '101.226.125.108', 1444527242, 1444527288, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
