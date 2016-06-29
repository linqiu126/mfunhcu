-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-06-29 10:39:04
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63695 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=581026 ;

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
