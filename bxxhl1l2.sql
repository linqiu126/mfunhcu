-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-07-01 10:46:49
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
-- 表的结构 `t_l1vm_cmdbuf`
--

CREATE TABLE IF NOT EXISTS `t_l1vm_cmdbuf` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `cmd` char(50) NOT NULL,
  `cmdtime` datetime NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=552 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l1vm_deviceversion`
--

CREATE TABLE IF NOT EXISTS `t_l1vm_deviceversion` (
  `deviceid` char(50) NOT NULL,
  `hw_type` int(1) DEFAULT NULL,
  `hw_ver` int(2) DEFAULT NULL,
  `sw_rel` int(1) DEFAULT NULL,
  `sw_drop` int(2) DEFAULT NULL,
  PRIMARY KEY (`deviceid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_l1vm_deviceversion`
--

INSERT INTO `t_l1vm_deviceversion` (`deviceid`, `hw_type`, `hw_ver`, `sw_rel`, `sw_drop`) VALUES
('HCU_SH_0304', 2, 3, 1, 90),
('HCU_SH_0302', 2, 3, 1, 92);

-- --------------------------------------------------------

--
-- 表的结构 `t_l1vm_loginfo`
--

CREATE TABLE IF NOT EXISTS `t_l1vm_loginfo` (
  `sid` int(6) NOT NULL AUTO_INCREMENT,
  `project` char(5) NOT NULL,
  `fromuser` char(50) NOT NULL,
  `createtime` char(20) NOT NULL,
  `logdata` text NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=581174 ;

--
-- 转存表中的数据 `t_l1vm_loginfo`
--

INSERT INTO `t_l1vm_loginfo` (`sid`, `project`, `fromuser`, `createtime`, `logdata`) VALUES
(581026, 'HCU', 'HCU_SH_0302', '2016-04-07 22:25:52', 'R:<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201124945000000004E000000000000000057066DF0]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581171, 'HCU', 'HCU_SH_0305', '2016-05-12 23:23:06', 'R:<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0305]]></FromUserName><CreateTime>1463066586</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201130345000000004E000000000000000057318D70]]></Content><FuncFlag>0</FuncFlag></xml>'),
(581172, 'HCU', 'ZHBMSG', '2016-06-30 15:02:51', 'R:##007020160619033803000___11111ZHB_NOMHCU_SH_0304_44444405556666a01000=139A,68BE'),
(581173, 'HCU', 'AQ_HCU', '2016-06-30 15:02:51', 'T:');

-- --------------------------------------------------------

--
-- 表的结构 `t_l1vm_logswitch`
--

CREATE TABLE IF NOT EXISTS `t_l1vm_logswitch` (
  `user` char(50) NOT NULL,
  `switch` char(1) NOT NULL,
  PRIMARY KEY (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_l1vm_logswitch`
--

INSERT INTO `t_l1vm_logswitch` (`user`, `switch`) VALUES
('oS0Chv3Uum1TZqHaCEb06AoBfCvY', '1'),
('oS0Chv-avCH7W4ubqOQAFXojYODY', '1');

-- --------------------------------------------------------

--
-- 表的结构 `t_l2sdk_iothcu_hcudevice`
--

CREATE TABLE IF NOT EXISTS `t_l2sdk_iothcu_hcudevice` (
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
-- 转存表中的数据 `t_l2sdk_iothcu_hcudevice`
--

INSERT INTO `t_l2sdk_iothcu_hcudevice` (`devcode`, `statcode`, `macaddr`, `ipaddr`, `switch`, `videourl`, `sensorlist`) VALUES
('HCU_SH_0301', '120101001', '', '', 'on', '', 'S_0001;S_0002;S_0003;S_0005;S_0006;S_0007;S_000A;'),
('HCU_SH_0302', '120101015', '', '', 'off', 'http://192.168.31.232:8000/avorion/avorion201606061346.h264', 'S_0001;S_0002;S_0003;S_0005;S_0006;S_0007;S_000A;'),
('HCU_SH_0305', '120101005', '', '', 'off', '', 'S_0002;S_0003;S_0005;S_0006;S_0007;'),
('HCU_SH_0304', '120101004', '', '', 'off', '', 'S_0005;'),
('HCU_SH_0303', '120101003', '', '', 'on', 'http://192.168.1.232:8000/avorion/avorion201606041614.h264', 'S_0001;S_0005;'),
('HCU_SH_0309', '120101009', '', '', 'off', '', 'S_0005;S_006;');

-- --------------------------------------------------------

--
-- 表的结构 `t_l2sdk_wechat_accesstoken`
--

CREATE TABLE IF NOT EXISTS `t_l2sdk_wechat_accesstoken` (
  `appid` char(20) NOT NULL,
  `appsecret` char(50) NOT NULL,
  `lasttime` int(6) NOT NULL,
  `access_token` text NOT NULL,
  `js_ticket` text NOT NULL,
  PRIMARY KEY (`appid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_l2sdk_wechat_accesstoken`
--

INSERT INTO `t_l2sdk_wechat_accesstoken` (`appid`, `appsecret`, `lasttime`, `access_token`, `js_ticket`) VALUES
('wx1183be5c8f6a24b4', 'd52a63064ed543c5eecae6c3df35be55', 1463366782, 'Lsj037a0ESUaboFyI2zfs4RreFVPcdzhK6bfl3e88c8hRWudxRmVnxGazA8tl7irqB6amZocY3-HzG9q3Or8QAlkzSmA7IM3GkIDaD4KdgxPje9NqJpEQPqRIMV8KrswHKEgAGADGA', 'kgt8ON7yVITDhtdwci0qebz_ZoAuborwySZXCjkJSWTLLNSUoMqZWGAntmgJ8dWryV6YAK_F6sAkPJCjrFpBiA');

-- --------------------------------------------------------

--
-- 表的结构 `t_l2sdk_wechat_blebound`
--

CREATE TABLE IF NOT EXISTS `t_l2sdk_wechat_blebound` (
  `sid` int(6) NOT NULL AUTO_INCREMENT,
  `fromuser` char(50) NOT NULL,
  `deviceid` char(50) NOT NULL,
  `openid` char(50) NOT NULL,
  `devicetype` char(30) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `t_l2sdk_wechat_blebound`
--

INSERT INTO `t_l2sdk_wechat_blebound` (`sid`, `fromuser`, `deviceid`, `openid`, `devicetype`) VALUES
(6, 'oS0Chv3Uum1TZqHaCEb06AoBfCvY', 'gh_70c714952b02_8cd47e1f6141e49a4e45f4b807cf41fe', 'oS0Chv3Uum1TZqHaCEb06AoBfCvY', 'gh_70c714952b02'),
(7, 'oS0Chv-avCH7W4ubqOQAFXojYODY', 'gh_70c714952b02_8248307502397542f48a3775bcb234d4', 'oS0Chv-avCH7W4ubqOQAFXojYODY', 'gh_70c714952b02');

-- --------------------------------------------------------

--
-- 表的结构 `t_l2sdk_wechat_deviceqrcode`
--

CREATE TABLE IF NOT EXISTS `t_l2sdk_wechat_deviceqrcode` (
  `deviceid` char(50) NOT NULL,
  `qrcode` char(100) NOT NULL,
  `devicetype` char(30) NOT NULL,
  `macaddr` char(20) NOT NULL,
  PRIMARY KEY (`deviceid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_l2sdk_wechat_deviceqrcode`
--

INSERT INTO `t_l2sdk_wechat_deviceqrcode` (`deviceid`, `qrcode`, `devicetype`, `macaddr`) VALUES
('gh_70c714952b02_8cd47e1f6141e49a4e45f4b807cf41fe', 'http://we.qq.com/d/AQBLQKG-27gIDCKf03DmiwAXh27qptK_scSJJRAn', 'gh_70c714952b02', 'D03972A5EF28'),
('gh_70c714952b02_8248307502397542f48a3775bcb234d4', 'http://we.qq.com/d/AQBLQKG-cFODzg6aCE5C92D1SKGHOirRJtBGwCmd', 'gh_70c714952b02', 'D03972A5EF27');

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_airpressure`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_airpressure` (
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
-- 表的结构 `t_l2snr_dataformat`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_dataformat` (
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
-- 转存表中的数据 `t_l2snr_dataformat`
--

INSERT INTO `t_l2snr_dataformat` (`deviceid`, `f_airpressure`, `f_emcdata`, `f_humidity`, `f_noise`, `f_pmdata`, `f_rain`, `f_temperature`, `f_winddirection`, `f_windspeed`) VALUES
('HCU_SH_0301', 0, 1, 1, 2, 1, 0, 1, 1, 1),
('HCU_SH_0303', NULL, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL),
('HCU_SH_0302', NULL, 1, 1, NULL, NULL, NULL, 1, NULL, NULL),
('HCU_SH_0305', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('HCU_SH_0304', NULL, 1, 1, NULL, NULL, NULL, 1, NULL, NULL),
('HCU_SH_0309', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_emcaccumulation`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_emcaccumulation` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `lastupdatedate` date NOT NULL,
  `avg30days` char(192) NOT NULL,
  `avg3month` char(192) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `t_l2snr_emcaccumulation`
--

INSERT INTO `t_l2snr_emcaccumulation` (`sid`, `deviceid`, `lastupdatedate`, `avg30days`, `avg3month`) VALUES
(1, 'HCU_SH_0301', '2016-04-27', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0'),
(2, 'gh_70c714952b02_8248307502397542f48a3775bcb234d4', '2016-04-23', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0'),
(3, 'HCU_SH_0302', '2016-06-30', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0'),
(4, 'HCU_SH_0303', '2016-06-12', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0'),
(5, 'HCU_SH_0305', '2016-06-30', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0'),
(6, 'HCU_SH_0304', '2016-06-16', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0'),
(7, 'HCU_SH_0309', '2016-06-18', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0');

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_emcdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_emcdata` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63697 ;

--
-- 转存表中的数据 `t_l2snr_emcdata`
--

INSERT INTO `t_l2snr_emcdata` (`sid`, `deviceid`, `sensorid`, `emcvalue`, `dataflag`, `reportdate`, `hourminindex`, `altitude`, `flag_la`, `latitude`, `flag_lo`, `longitude`) VALUES
(63695, 'HCU_SH_0305', 5, 4867, 'N', '2016-05-10', 927, 0, 'N', 0, 'E', 0),
(63696, 'HCU_SH_0302', 5, 4681, 'N', '2016-04-07', 1345, 0, 'N', 0, 'E', 0);

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_hourreport`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_hourreport` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `t_l2snr_hourreport`
--

INSERT INTO `t_l2snr_hourreport` (`sid`, `devcode`, `statcode`, `reportdate`, `hourindex`, `emcvalue`, `pm01`, `pm25`, `pm10`, `noise`, `windspeed`, `winddirection`, `rain`, `temperature`, `humidity`, `airpressure`, `datastatus`, `validdatanum`) VALUES
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
(18, '', NULL, '0000-00-00', 0, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_hsmmpdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_hsmmpdata` (
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
-- 表的结构 `t_l2snr_humiddata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_humiddata` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19900 ;

--
-- 转存表中的数据 `t_l2snr_humiddata`
--

INSERT INTO `t_l2snr_humiddata` (`sid`, `deviceid`, `sensorid`, `humidity`, `dataflag`, `reportdate`, `hourminindex`, `altitude`, `flag_la`, `latitude`, `flag_lo`, `longitude`) VALUES
(19899, 'HCU_SH_0301', 6, 172, 'N', '2016-03-13', 1235, 0, '\0', 0, '\0', 0);

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_minreport`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_minreport` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55777 ;

--
-- 转存表中的数据 `t_l2snr_minreport`
--

INSERT INTO `t_l2snr_minreport` (`sid`, `devcode`, `statcode`, `reportdate`, `hourminindex`, `emcvalue`, `pm01`, `pm25`, `pm10`, `noise`, `windspeed`, `winddirection`, `rain`, `temperature`, `humidity`, `airpressure`, `pmdataflag`) VALUES
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
(637, 'HCU_SH_0302', '120101002', '2016-04-21', 1410, 4908, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 696, 227, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_noisedata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_noisedata` (
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
-- 表的结构 `t_l2snr_picturedata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_picturedata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `filedescription` char(50) NOT NULL,
  `filename` char(50) NOT NULL,
  `filesize` char(50) NOT NULL,
  `filetype` char(50) NOT NULL,
  `bindata` mediumblob NOT NULL,
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
-- 表的结构 `t_l2snr_pm25data`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_pm25data` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4059 ;

--
-- 转存表中的数据 `t_l2snr_pm25data`
--

INSERT INTO `t_l2snr_pm25data` (`sid`, `deviceid`, `sensorid`, `pm01`, `pm25`, `pm10`, `dataflag`, `reportdate`, `hourminindex`, `altitude`, `flag_la`, `latitude`, `flag_lo`, `longitude`) VALUES
(4058, 'HCU_SH_0301', 1, 274, 274, 1170, 'N', '2016-03-13', 1233, 0, '\0', 0, '\0', 0);

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_raindata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_raindata` (
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
-- 表的结构 `t_l2snr_sensorinfo`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_sensorinfo` (
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
-- 转存表中的数据 `t_l2snr_sensorinfo`
--

INSERT INTO `t_l2snr_sensorinfo` (`id`, `name`, `model`, `vendor`, `modbus`, `period`, `samples`, `times`) VALUES
('S_0001', '细颗粒物', 'PM-100', '爱启公司', 1, 100, 500, 200),
('S_0002', '风速', 'WS-100', '爱启公司', 2, NULL, NULL, NULL),
('S_0003', '风向', 'WD-100', '爱启公司', 3, NULL, NULL, NULL),
('S_0005', '电磁辐射', 'EMC-100', '小慧智能科技', 5, NULL, NULL, NULL),
('S_0006', '温度', 'TE-100', '小慧智能科技', 6, NULL, NULL, NULL),
('S_0007', '湿度', 'TH-100', '小慧智能科技', 6, NULL, NULL, NULL),
('S_000A', '噪声', 'NO-100', '小慧智能科技', 10, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_sensortype`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_sensortype` (
  `id` char(6) NOT NULL,
  `name` char(10) NOT NULL,
  `model` char(20) NOT NULL,
  `vendor` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_tempdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_tempdata` (
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
-- 表的结构 `t_l2snr_winddir`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_winddir` (
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
-- 表的结构 `t_l2snr_windspd`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_windspd` (
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
