-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2018-04-25 08:58:08
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
-- 表的结构 `t_l1vm_engpar`
--

CREATE TABLE IF NOT EXISTS `t_l1vm_engpar` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `project` char(50) NOT NULL,
  `cloudhttp` char(50) NOT NULL,
  `customername` char(50) NOT NULL,
  `maxusers` int(4) NOT NULL,
  `maxadmin` int(4) NOT NULL,
  `filenamebg` char(50) NOT NULL,
  `filetypebg` char(10) NOT NULL,
  `filedatabg` mediumblob NOT NULL,
  `filenamelog` char(50) NOT NULL,
  `filetypelog` char(10) NOT NULL,
  `filedatalog` mediumblob NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l1vm_hcuswdb`
--

CREATE TABLE IF NOT EXISTS `t_l1vm_hcuswdb` (
  `date` date NOT NULL,
  `hcu_sw_ver` varchar(20) NOT NULL,
  `hcu_db_ver` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2sdk_iothcu_inventory`
--

CREATE TABLE IF NOT EXISTS `t_l2sdk_iothcu_inventory` (
  `devcode` char(20) NOT NULL,
  `statcode` char(20) NOT NULL,
  `opendate` date DEFAULT NULL,
  `macaddr_wlan0` varchar(20) DEFAULT NULL,
  `ip_wlan0` varchar(20) DEFAULT NULL,
  `macaddr_eth0` char(20) DEFAULT NULL,
  `socketid` int(2) DEFAULT '0',
  `status` char(1) NOT NULL DEFAULT 'Y',
  `simcard` char(20) DEFAULT NULL,
  `hw_type` int(1) DEFAULT NULL,
  `hw_ver` int(2) DEFAULT NULL,
  `sw_rel` int(1) DEFAULT NULL,
  `sw_drop` int(2) DEFAULT NULL,
  `ver_base` char(1) NOT NULL DEFAULT '1',
  `hcu_db_ver` int(4) NOT NULL DEFAULT '1',
  `videourl` char(100) DEFAULT NULL,
  `camctrl` char(100) DEFAULT NULL,
  `boxpic` mediumblob,
  `hcu_sw_autoupdate` tinyint(1) NOT NULL DEFAULT '0',
  `hcu_db_autoupdate` tinyint(1) NOT NULL DEFAULT '0',
  `http_ui` varchar(100) DEFAULT NULL,
  `video_port` int(4) DEFAULT NULL,
  `rtsp_port` int(4) DEFAULT NULL,
  `service_port` int(4) DEFAULT NULL,
  `ssh_port` int(4) DEFAULT NULL,
  `vnc_port` int(4) DEFAULT NULL,
  `image_version` varchar(20) DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `desc` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`devcode`),
  UNIQUE KEY `statcode` (`statcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2sdk_nbiot_std_cj188_context`
--

CREATE TABLE IF NOT EXISTS `t_l2sdk_nbiot_std_cj188_context` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `cj188address` char(14) NOT NULL,
  `cntser` int(1) NOT NULL,
  `deviceflag` int(1) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2sdk_nbiot_std_qg376_context`
--

CREATE TABLE IF NOT EXISTS `t_l2sdk_nbiot_std_qg376_context` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `ipmaddress` int(4) NOT NULL,
  `cntpfc` int(1) NOT NULL,
  `deviceflag` int(1) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

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

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_airprsdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_airprsdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `airprs` int(4) NOT NULL,
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

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_alcoholdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_alcoholdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `alcohol` int(4) NOT NULL,
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

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_aqyc_minreport`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_aqyc_minreport` (
  `sid` int(6) NOT NULL AUTO_INCREMENT,
  `devcode` char(20) NOT NULL,
  `statcode` char(20) NOT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `dataflag` char(1) DEFAULT 'Y',
  `pm01` float DEFAULT NULL,
  `pm25` float DEFAULT NULL,
  `pm10` float DEFAULT NULL,
  `noise` float DEFAULT NULL,
  `windspeed` float DEFAULT NULL,
  `winddirection` float DEFAULT NULL,
  `temperature` float DEFAULT NULL,
  `humidity` float DEFAULT NULL,
  `airpressure` float DEFAULT NULL,
  `rain` float DEFAULT NULL,
  `emcvalue` float DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2813 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_bfsc_minreport`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_bfsc_minreport` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `devcode` char(20) NOT NULL,
  `statcode` char(20) NOT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `weight_01` int(4) NOT NULL DEFAULT '0',
  `weight_02` int(4) NOT NULL DEFAULT '0',
  `weight_03` int(4) NOT NULL DEFAULT '0',
  `weight_04` int(4) NOT NULL DEFAULT '0',
  `weight_05` int(4) NOT NULL DEFAULT '0',
  `weight_06` int(4) NOT NULL DEFAULT '0',
  `weight_07` int(4) NOT NULL DEFAULT '0',
  `weight_08` int(4) NOT NULL DEFAULT '0',
  `weight_09` int(4) NOT NULL DEFAULT '0',
  `weight_10` int(4) NOT NULL DEFAULT '0',
  `weight_11` int(4) NOT NULL DEFAULT '0',
  `weight_12` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_co1data`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_co1data` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `co1` int(4) NOT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_emcdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_emcdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) DEFAULT NULL,
  `emcvalue` int(4) NOT NULL DEFAULT '0',
  `dataflag` char(1) DEFAULT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `altitude` int(4) DEFAULT NULL,
  `flag_la` char(1) DEFAULT NULL,
  `latitude` int(4) DEFAULT NULL,
  `flag_lo` char(1) DEFAULT NULL,
  `longitude` int(4) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=304393 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_fdwq_wrist`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_fdwq_wrist` (
  `sid` int(6) NOT NULL AUTO_INCREMENT,
  `devcode` varchar(20) NOT NULL,
  `rfid` varchar(16) NOT NULL,
  `reporttime` datetime NOT NULL,
  `sampletime` datetime NOT NULL,
  `temp` int(4) NOT NULL DEFAULT '0',
  `miles` int(4) NOT NULL DEFAULT '0',
  `curhbrate` int(2) NOT NULL DEFAULT '0',
  `hbratemax` int(2) NOT NULL DEFAULT '0',
  `hbratemin` int(2) NOT NULL DEFAULT '0',
  `hbrateavg` int(2) NOT NULL DEFAULT '0',
  `bloodpress` int(4) NOT NULL DEFAULT '0',
  `sleeplvl` int(4) NOT NULL DEFAULT '0',
  `airpress` int(4) NOT NULL DEFAULT '0',
  `energylvl` int(4) NOT NULL DEFAULT '0',
  `waterdrink` int(4) NOT NULL DEFAULT '0',
  `skinatttached` int(1) NOT NULL DEFAULT '0',
  `latitude` int(4) NOT NULL,
  `longitude` int(4) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_fhys_minreport`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_fhys_minreport` (
  `sid` int(2) NOT NULL AUTO_INCREMENT,
  `devcode` char(20) NOT NULL,
  `statcode` char(20) NOT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `reporttype` int(1) NOT NULL DEFAULT '0',
  `door_1` int(1) NOT NULL DEFAULT '0',
  `door_2` int(1) NOT NULL DEFAULT '0',
  `door_3` int(1) NOT NULL DEFAULT '0',
  `door_4` int(1) NOT NULL DEFAULT '0',
  `lock_1` int(1) NOT NULL DEFAULT '0',
  `lock_2` int(1) NOT NULL DEFAULT '0',
  `lock_3` int(1) NOT NULL DEFAULT '0',
  `lock_4` int(1) NOT NULL DEFAULT '0',
  `battstate` int(1) NOT NULL DEFAULT '0',
  `waterstate` int(1) NOT NULL DEFAULT '0',
  `shakestate` int(1) NOT NULL DEFAULT '0',
  `fallstate` int(1) NOT NULL DEFAULT '0',
  `smokestate` int(1) NOT NULL DEFAULT '0',
  `battvalue` float NOT NULL DEFAULT '0',
  `fallvalue` float NOT NULL DEFAULT '0',
  `tempvalue` float NOT NULL DEFAULT '0',
  `humidvalue` float NOT NULL DEFAULT '0',
  `rssivalue` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8506 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_hchodata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_hchodata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `hcho` int(4) NOT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45103 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_hsmmpdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_hsmmpdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `statcode` varchar(20) NOT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `videostart` int(4) NOT NULL DEFAULT '0',
  `videoend` int(4) NOT NULL DEFAULT '0',
  `filesize` int(4) NOT NULL DEFAULT '0',
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56014 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_humiddata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_humiddata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) DEFAULT NULL,
  `humidity` int(4) NOT NULL,
  `dataflag` char(1) DEFAULT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `altitude` int(4) DEFAULT NULL,
  `flag_la` char(1) DEFAULT NULL,
  `latitude` int(4) DEFAULT NULL,
  `flag_lo` char(1) DEFAULT NULL,
  `longitude` int(4) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55049 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_igmdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_igmdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `cj188address` char(14) NOT NULL,
  `equtype` int(1) NOT NULL,
  `flowvolume` float(8,2) NOT NULL,
  `flowvolumeuint` int(1) NOT NULL,
  `currentaccuvolume` float(8,2) NOT NULL,
  `currentaccuvolumeuint` int(1) NOT NULL,
  `todayaccuvolume` float(8,2) NOT NULL,
  `todayaccuvolumeuint` int(1) NOT NULL,
  `lastmonth` int(1) NOT NULL,
  `accumuworktime` int(3) NOT NULL,
  `supplywatertemp` float(6,2) NOT NULL,
  `backwatertemp` float(6,2) NOT NULL,
  `realtime` char(14) NOT NULL,
  `st` char(4) NOT NULL,
  `billdate` int(1) NOT NULL,
  `readdate` int(1) NOT NULL,
  `key` int(8) NOT NULL,
  `price1` float(6,2) NOT NULL,
  `volume1` int(3) NOT NULL,
  `price2` float(6,2) NOT NULL,
  `volume2` int(3) NOT NULL,
  `price3` float(6,2) NOT NULL,
  `buycode` int(1) NOT NULL,
  `thisamount` float(8,2) NOT NULL,
  `accuamount` float(8,2) NOT NULL,
  `remainamount` float(8,2) NOT NULL,
  `keyver` int(1) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=99 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_ihmdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_ihmdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `cj188address` char(14) NOT NULL,
  `equtype` int(1) NOT NULL,
  `heatpower` float(8,2) NOT NULL,
  `heatpoweruint` int(1) NOT NULL,
  `currentheat` float(8,2) NOT NULL,
  `currentheatuint` int(1) NOT NULL,
  `todayheat` float(8,2) NOT NULL,
  `todayheatuint` int(1) NOT NULL,
  `flowvolume` float(8,2) NOT NULL,
  `flowvolumeuint` int(1) NOT NULL,
  `currentaccuvolume` float(8,2) NOT NULL,
  `currentaccuvolumeuint` int(1) NOT NULL,
  `lastmonth` int(1) NOT NULL,
  `accumuworktime` int(3) NOT NULL,
  `supplywatertemp` float(6,2) NOT NULL,
  `backwatertemp` float(6,2) NOT NULL,
  `realtime` char(14) NOT NULL,
  `st` char(4) NOT NULL,
  `billdate` int(1) NOT NULL,
  `readdate` int(1) NOT NULL,
  `key` int(8) NOT NULL,
  `price1` float(6,2) NOT NULL,
  `volume1` int(3) NOT NULL,
  `price2` float(6,2) NOT NULL,
  `volume2` int(3) NOT NULL,
  `price3` float(6,2) NOT NULL,
  `buycode` int(1) NOT NULL,
  `thisamount` float(8,2) NOT NULL,
  `accuamount` float(8,2) NOT NULL,
  `remainamount` float(8,2) NOT NULL,
  `keyver` int(1) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=107 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_ipmdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_ipmdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `cj188address` char(14) NOT NULL,
  `equtype` int(1) NOT NULL,
  `flowvolume` float(8,2) NOT NULL,
  `flowvolumeuint` int(1) NOT NULL,
  `currentaccuvolume` float(8,2) NOT NULL,
  `currentaccuvolumeuint` int(1) NOT NULL,
  `todayaccuvolume` float(8,2) NOT NULL,
  `todayaccuvolumeuint` int(1) NOT NULL,
  `lastmonth` int(1) NOT NULL,
  `accumuworktime` int(3) NOT NULL,
  `supplywatertemp` float(6,2) NOT NULL,
  `backwatertemp` float(6,2) NOT NULL,
  `realtime` char(14) NOT NULL,
  `st` char(4) NOT NULL,
  `billdate` int(1) NOT NULL,
  `readdate` int(1) NOT NULL,
  `key` int(8) NOT NULL,
  `price1` float(6,2) NOT NULL,
  `volume1` int(3) NOT NULL,
  `price2` float(6,2) NOT NULL,
  `volume2` int(3) NOT NULL,
  `price3` float(6,2) NOT NULL,
  `buycode` int(1) NOT NULL,
  `thisamount` float(8,2) NOT NULL,
  `accuamount` float(8,2) NOT NULL,
  `remainamount` float(8,2) NOT NULL,
  `keyver` int(1) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_ipm_afndata1_f25`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_ipm_afndata1_f25` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` int(4) NOT NULL,
  `cur_terminaltime` char(20) NOT NULL,
  `cur_sumusepower` int(3) NOT NULL,
  `cur_phaseausepwr` int(3) NOT NULL,
  `cur_phasebusepwr` int(3) NOT NULL,
  `cur_phasecusepwr` int(3) NOT NULL,
  `cur_sumnupower` int(3) NOT NULL,
  `cur_phaseanupwr` int(3) NOT NULL,
  `cur_phasebnupwr` int(3) NOT NULL,
  `cur_sumphasecnupwr` int(3) NOT NULL,
  `cur_powerfactor` int(2) NOT NULL,
  `cur_phaseapwrfac` int(2) NOT NULL,
  `cur_phasebpwrfac` int(2) NOT NULL,
  `cur_phasecpwrfac` int(2) NOT NULL,
  `cur_phaseavoltage` int(2) NOT NULL,
  `cur_phasebvoltage` int(2) NOT NULL,
  `cur_phasecvoltage` int(2) NOT NULL,
  `cur_phaseacurrent` int(3) NOT NULL,
  `cur_phasebcurrent` int(3) NOT NULL,
  `cur_phaseccurrent` int(3) NOT NULL,
  `cur_zeroordercurrent` int(3) NOT NULL,
  `cur_sumvisualpower` int(3) NOT NULL,
  `cur_phaseavisualpower` int(3) NOT NULL,
  `cur_phasebvisualpower` int(3) NOT NULL,
  `cur_phasecvisualpower` int(3) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_iwmdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_iwmdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `cj188address` char(14) NOT NULL,
  `equtype` int(1) NOT NULL,
  `flowvolume` float(8,2) NOT NULL,
  `flowvolumeuint` int(1) NOT NULL,
  `currentaccuvolume` float(8,2) NOT NULL,
  `currentaccuvolumeuint` int(1) NOT NULL,
  `todayaccuvolume` float(8,2) NOT NULL,
  `todayaccuvolumeuint` int(1) NOT NULL,
  `lastmonth` int(1) NOT NULL,
  `accumuworktime` int(3) NOT NULL,
  `supplywatertemp` float(6,2) NOT NULL,
  `backwatertemp` float(6,2) NOT NULL,
  `realtime` char(14) NOT NULL,
  `st` char(4) NOT NULL,
  `billdate` int(1) NOT NULL,
  `readdate` int(1) NOT NULL,
  `key` int(8) NOT NULL,
  `price1` float(6,2) NOT NULL,
  `volume1` int(3) NOT NULL,
  `price2` float(6,2) NOT NULL,
  `volume2` int(3) NOT NULL,
  `price3` float(6,2) NOT NULL,
  `buycode` int(1) NOT NULL,
  `thisamount` float(8,2) NOT NULL,
  `accuamount` float(8,2) NOT NULL,
  `remainamount` float(8,2) NOT NULL,
  `keyver` int(1) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=107 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_lightstrdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_lightstrdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `lightstr` int(4) NOT NULL,
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

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_noisedata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_noisedata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) DEFAULT NULL,
  `noise` int(4) NOT NULL,
  `dataflag` char(1) DEFAULT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `altitude` int(4) DEFAULT NULL,
  `flag_la` char(1) DEFAULT NULL,
  `latitude` int(4) DEFAULT NULL,
  `flag_lo` char(1) DEFAULT NULL,
  `longitude` int(4) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19961 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_picturedata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_picturedata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `statcode` varchar(20) NOT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `filesize` varchar(10) NOT NULL DEFAULT '0',
  `filedescription` char(50) DEFAULT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28322 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_pm25data`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_pm25data` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `pm01` float NOT NULL,
  `pm25` float NOT NULL,
  `pm10` float NOT NULL,
  `dataflag` char(1) DEFAULT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19900 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_sensortype`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_sensortype` (
  `typeid` char(10) NOT NULL,
  `name` varchar(10) NOT NULL,
  `value_min` float NOT NULL DEFAULT '0',
  `value_max` float NOT NULL,
  `model` varchar(20) DEFAULT NULL,
  `vendor` varchar(20) DEFAULT NULL,
  `dataformat` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`typeid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_tempdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_tempdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `temperature` float NOT NULL DEFAULT '0',
  `dataflag` char(1) DEFAULT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54545 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_toxicgasdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_toxicgasdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `toxicgas` int(4) NOT NULL,
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

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_winddir`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_winddir` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) DEFAULT NULL,
  `winddirection` int(4) NOT NULL,
  `dataflag` char(1) DEFAULT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `altitude` int(4) DEFAULT NULL,
  `flag_la` char(1) DEFAULT NULL,
  `latitude` int(4) DEFAULT NULL,
  `flag_lo` char(1) DEFAULT NULL,
  `longitude` int(4) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=62158 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_windspd`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_windspd` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) DEFAULT NULL,
  `windspeed` int(4) NOT NULL,
  `dataflag` char(1) DEFAULT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `altitude` int(4) DEFAULT NULL,
  `flag_la` char(1) DEFAULT NULL,
  `latitude` int(4) DEFAULT NULL,
  `flag_lo` char(1) DEFAULT NULL,
  `longitude` int(4) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57773 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f1sym_account`
--

CREATE TABLE IF NOT EXISTS `t_l3f1sym_account` (
  `uid` char(10) NOT NULL,
  `user` char(20) NOT NULL,
  `nick` char(20) DEFAULT NULL,
  `pwd` char(100) NOT NULL,
  `authcode` char(6) DEFAULT NULL,
  `admin` char(5) DEFAULT NULL,
  `grade` char(1) NOT NULL DEFAULT '0',
  `phone` char(20) DEFAULT NULL,
  `email` char(50) DEFAULT NULL,
  `regdate` date DEFAULT NULL,
  `city` char(10) DEFAULT NULL,
  `maponline` char(1) NOT NULL DEFAULT 'Y',
  `maplatitude` int(4) NOT NULL DEFAULT '0',
  `maplongitude` int(4) NOT NULL DEFAULT '0',
  `backup` text,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f1sym_authlist`
--

CREATE TABLE IF NOT EXISTS `t_l3f1sym_authlist` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `uid` char(10) NOT NULL,
  `auth_code` char(20) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=695 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f1sym_session`
--

CREATE TABLE IF NOT EXISTS `t_l3f1sym_session` (
  `uid` char(20) NOT NULL,
  `sessionid` char(10) NOT NULL,
  `lastupdate` int(4) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `sessionid` (`sessionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f1sym_sysinfo`
--

CREATE TABLE IF NOT EXISTS `t_l3f1sym_sysinfo` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `keyid` char(50) NOT NULL,
  `vendorinfo` char(200) NOT NULL,
  `customerinfo` char(200) NOT NULL,
  `licenseinfo` char(200) NOT NULL,
  `maxadmin` int(4) NOT NULL DEFAULT '10',
  `maxsubscribers` int(4) NOT NULL DEFAULT '1000',
  `maxservers` int(4) NOT NULL DEFAULT '5',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=101 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f1sym_userprofile`
--

CREATE TABLE IF NOT EXISTS `t_l3f1sym_userprofile` (
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

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f2cm_favourlist`
--

CREATE TABLE IF NOT EXISTS `t_l3f2cm_favourlist` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `uid` varchar(10) NOT NULL,
  `statcode` varchar(20) NOT NULL,
  `createtime` datetime NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f2cm_fdwq_soldierinfo`
--

CREATE TABLE IF NOT EXISTS `t_l3f2cm_fdwq_soldierinfo` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `soldiername` varchar(20) NOT NULL,
  `soldierid` varchar(20) NOT NULL DEFAULT 'NULL',
  `department` varchar(100) NOT NULL DEFAULT 'NULL',
  `title` varchar(20) NOT NULL DEFAULT 'NULL',
  `gender` int(1) NOT NULL DEFAULT '0',
  `birthday` date NOT NULL,
  `idcard` char(18) NOT NULL DEFAULT 'NULL',
  `rfid` varchar(16) NOT NULL DEFAULT 'NULL',
  `hight` int(4) NOT NULL DEFAULT '0',
  `weight` int(4) NOT NULL DEFAULT '0',
  `bloodtype` int(1) NOT NULL DEFAULT '0',
  `group` varchar(20) NOT NULL DEFAULT 'NULL',
  `telephone` varchar(20) NOT NULL DEFAULT 'NULL',
  `email` varchar(50) NOT NULL DEFAULT 'NULL',
  `soldierpic` varchar(100) NOT NULL DEFAULT 'NULL',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f2cm_fhys_keyauth`
--

CREATE TABLE IF NOT EXISTS `t_l3f2cm_fhys_keyauth` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `keyid` char(10) NOT NULL,
  `authlevel` char(1) NOT NULL DEFAULT 'D',
  `authobjcode` char(20) NOT NULL,
  `authtype` char(1) NOT NULL DEFAULT 'T',
  `validnum` int(2) DEFAULT '0',
  `validstart` date DEFAULT NULL,
  `validend` date DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f2cm_fhys_keyinfo`
--

CREATE TABLE IF NOT EXISTS `t_l3f2cm_fhys_keyinfo` (
  `keyid` char(10) NOT NULL,
  `keyname` char(20) NOT NULL DEFAULT 'NULL',
  `p_code` char(20) NOT NULL,
  `keyuserid` char(10) DEFAULT 'none',
  `keyusername` char(10) DEFAULT 'none',
  `keystatus` char(1) NOT NULL DEFAULT 'Y',
  `keytype` char(1) NOT NULL,
  `hwcode` char(50) DEFAULT NULL,
  `memo` text,
  PRIMARY KEY (`keyid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f2cm_fhys_otdr`
--

CREATE TABLE IF NOT EXISTS `t_l3f2cm_fhys_otdr` (
  `otdrcode` varchar(10) NOT NULL,
  `otdrname` varchar(15) NOT NULL,
  `ipaddr` varchar(20) NOT NULL,
  `port` varchar(10) NOT NULL,
  `rtucode` varchar(10) NOT NULL,
  `rtuslot` varchar(10) NOT NULL,
  `cmdformat` varchar(20) NOT NULL,
  `collector` varchar(10) NOT NULL,
  `backup` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f2cm_fhys_rtu`
--

CREATE TABLE IF NOT EXISTS `t_l3f2cm_fhys_rtu` (
  `rtucode` varchar(10) NOT NULL,
  `rtuname` varchar(10) NOT NULL,
  `ipaddr` varchar(20) NOT NULL,
  `port` varchar(10) NOT NULL,
  `timeout` varchar(10) NOT NULL,
  `slot` varchar(10) NOT NULL,
  `roomcode` varchar(10) NOT NULL,
  `collector` varchar(10) NOT NULL,
  `backup` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f2cm_projgroup`
--

CREATE TABLE IF NOT EXISTS `t_l3f2cm_projgroup` (
  `pg_code` char(20) NOT NULL,
  `pg_name` char(50) NOT NULL,
  `owner` char(20) DEFAULT NULL,
  `phone` char(20) DEFAULT NULL,
  `department` char(50) DEFAULT NULL,
  `addr` char(100) DEFAULT NULL,
  `backup` text,
  PRIMARY KEY (`pg_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f2cm_projinfo`
--

CREATE TABLE IF NOT EXISTS `t_l3f2cm_projinfo` (
  `p_code` char(20) NOT NULL,
  `p_name` char(50) NOT NULL,
  `pg_code` char(20) DEFAULT NULL,
  `chargeman` char(20) DEFAULT NULL,
  `telephone` char(20) DEFAULT NULL,
  `department` char(30) DEFAULT NULL,
  `address` char(30) DEFAULT NULL,
  `starttime` date DEFAULT NULL,
  `pre_endtime` date DEFAULT NULL,
  `true_endtime` date DEFAULT NULL,
  `stage` text,
  PRIMARY KEY (`p_code`),
  KEY `statCode` (`p_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f3dm_aqyc_currentreport`
--

CREATE TABLE IF NOT EXISTS `t_l3f3dm_aqyc_currentreport` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `statcode` char(20) NOT NULL,
  `createtime` char(20) NOT NULL,
  `emcvalue` float DEFAULT NULL,
  `pm01` float DEFAULT NULL,
  `pm25` float DEFAULT NULL,
  `pm10` float DEFAULT NULL,
  `noise` float DEFAULT NULL,
  `windspeed` float DEFAULT NULL,
  `winddirection` float DEFAULT NULL,
  `temperature` float DEFAULT NULL,
  `humidity` float DEFAULT NULL,
  `rain` float DEFAULT NULL,
  `airpressure` float DEFAULT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `deviceid` (`deviceid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f3dm_bfsc_currentreport`
--

CREATE TABLE IF NOT EXISTS `t_l3f3dm_bfsc_currentreport` (
  `devcode` char(20) NOT NULL,
  `statcode` char(20) NOT NULL,
  `createtime` datetime NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'Y',
  `weight_01` int(4) NOT NULL DEFAULT '0',
  `weight_02` int(4) NOT NULL DEFAULT '0',
  `weight_03` int(4) NOT NULL DEFAULT '0',
  `weight_04` int(4) NOT NULL DEFAULT '0',
  `weight_05` int(4) NOT NULL DEFAULT '0',
  `weight_06` int(4) NOT NULL DEFAULT '0',
  `weight_07` int(4) NOT NULL DEFAULT '0',
  `weight_08` int(4) NOT NULL DEFAULT '0',
  `weight_09` int(4) NOT NULL DEFAULT '0',
  `weight_10` int(4) NOT NULL DEFAULT '0',
  `weight_11` int(4) NOT NULL DEFAULT '0',
  `weight_12` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`devcode`),
  UNIQUE KEY `statcode` (`statcode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f3dm_fhys_currentreport`
--

CREATE TABLE IF NOT EXISTS `t_l3f3dm_fhys_currentreport` (
  `devcode` char(20) NOT NULL,
  `statcode` char(20) NOT NULL,
  `createtime` char(20) NOT NULL,
  `reporttype` int(1) NOT NULL DEFAULT '0',
  `door_1` int(1) NOT NULL DEFAULT '0',
  `door_2` int(1) NOT NULL DEFAULT '0',
  `door_3` int(1) NOT NULL DEFAULT '0',
  `door_4` int(1) NOT NULL DEFAULT '0',
  `lock_1` int(1) NOT NULL DEFAULT '0',
  `lock_2` int(1) NOT NULL DEFAULT '0',
  `lock_3` int(1) NOT NULL DEFAULT '0',
  `lock_4` int(1) NOT NULL DEFAULT '0',
  `battstate` int(1) NOT NULL DEFAULT '0',
  `waterstate` int(1) NOT NULL DEFAULT '0',
  `shakestate` int(1) NOT NULL DEFAULT '0',
  `fallstate` int(1) NOT NULL DEFAULT '0',
  `smokestate` int(1) NOT NULL DEFAULT '0',
  `battvalue` float NOT NULL DEFAULT '0',
  `fallvalue` float NOT NULL DEFAULT '0',
  `tempvalue` float NOT NULL DEFAULT '0',
  `humidvalue` float NOT NULL DEFAULT '0',
  `rssivalue` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`devcode`),
  UNIQUE KEY `statcode` (`statcode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='云控锁项目光交箱状态监控表';

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f3dm_gtjy_currentreport`
--

CREATE TABLE IF NOT EXISTS `t_l3f3dm_gtjy_currentreport` (
  `devcode` varchar(20) NOT NULL,
  `statcode` varchar(20) DEFAULT NULL,
  `createtime` datetime DEFAULT NULL,
  `remainvol` int(4) DEFAULT NULL,
  `accgprsvol` int(4) DEFAULT NULL,
  `valvestate` varchar(10) DEFAULT NULL,
  `unitprice` varchar(10) DEFAULT NULL,
  `accvol` int(4) DEFAULT NULL,
  `minusnum` int(4) DEFAULT NULL,
  `rtn` varchar(10) DEFAULT NULL,
  `lastrecharge` int(4) DEFAULT NULL,
  `startdate` date DEFAULT NULL,
  `siglevel` int(4) DEFAULT NULL,
  `metertype` varchar(10) DEFAULT NULL,
  `accmoney` int(4) DEFAULT NULL,
  `meterstate` varchar(10) DEFAULT NULL,
  `metertime` datetime DEFAULT NULL,
  `lasticrecharge` int(4) DEFAULT NULL,
  PRIMARY KEY (`devcode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f3dm_siteinfo`
--

CREATE TABLE IF NOT EXISTS `t_l3f3dm_siteinfo` (
  `statcode` char(20) NOT NULL,
  `statname` char(50) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'I',
  `p_code` char(20) DEFAULT NULL,
  `chargeman` char(20) DEFAULT NULL,
  `telephone` char(15) DEFAULT NULL,
  `department` char(30) DEFAULT NULL,
  `country` char(20) DEFAULT NULL,
  `street` char(20) DEFAULT NULL,
  `address` char(50) DEFAULT NULL,
  `starttime` date DEFAULT NULL,
  `square` char(10) NOT NULL DEFAULT '0',
  `altitude` int(4) DEFAULT '0',
  `flag_la` char(1) DEFAULT 'N',
  `latitude` int(4) DEFAULT NULL,
  `flag_lo` char(1) DEFAULT 'E',
  `longitude` int(4) DEFAULT NULL,
  `memo` text,
  PRIMARY KEY (`statcode`),
  KEY `statCode` (`statcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f4icm_sensorctrl`
--

CREATE TABLE IF NOT EXISTS `t_l3f4icm_sensorctrl` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(20) NOT NULL,
  `sensorid` char(20) NOT NULL,
  `modbus_addr` int(1) DEFAULT NULL,
  `sensortype` char(10) NOT NULL,
  `meas_period` int(2) DEFAULT NULL,
  `onoffstatus` char(5) NOT NULL DEFAULT 'off',
  `sample_interval` int(2) DEFAULT NULL,
  `meas_times` int(2) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f5fm_aqyc_alarmdata`
--

CREATE TABLE IF NOT EXISTS `t_l3f5fm_aqyc_alarmdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `devcode` varchar(20) NOT NULL,
  `statcode` varchar(20) NOT NULL,
  `alarmflag` char(1) NOT NULL DEFAULT 'N',
  `alarmseverity` int(1) NOT NULL DEFAULT '0',
  `alarmcontent` int(4) NOT NULL DEFAULT '0',
  `alarmtype` int(2) DEFAULT '0',
  `clearflag` int(1) NOT NULL DEFAULT '0',
  `causeid` int(4) DEFAULT NULL,
  `tsgen` datetime NOT NULL,
  `tsclose` datetime DEFAULT NULL,
  `alarmpic` varchar(100) DEFAULT NULL,
  `alarmproc` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=101 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f5fm_fhys_alarmdata`
--

CREATE TABLE IF NOT EXISTS `t_l3f5fm_fhys_alarmdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `devcode` varchar(20) NOT NULL,
  `statcode` varchar(20) NOT NULL,
  `alarmflag` char(1) NOT NULL DEFAULT 'N',
  `alarmseverity` char(1) DEFAULT '0',
  `alarmcode` int(2) NOT NULL,
  `tsgen` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tsclose` datetime DEFAULT NULL,
  `alarmproc` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f6pm_perfdata`
--

CREATE TABLE IF NOT EXISTS `t_l3f6pm_perfdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `devcode` char(20) NOT NULL,
  `statcode` char(20) NOT NULL,
  `createtime` datetime NOT NULL,
  `restartCnt` int(4) NOT NULL DEFAULT '0',
  `networkConnCnt` int(4) NOT NULL DEFAULT '0',
  `networkConnFailCnt` int(4) NOT NULL DEFAULT '0',
  `networkDiscCnt` int(4) NOT NULL DEFAULT '0',
  `socketDiscCnt` int(4) NOT NULL DEFAULT '0',
  `cpuOccupy` int(4) NOT NULL DEFAULT '0',
  `memOccupy` int(4) NOT NULL DEFAULT '0',
  `diskOccupy` int(4) NOT NULL DEFAULT '0',
  `cpuTemp` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f7ads_adsdata`
--

CREATE TABLE IF NOT EXISTS `t_l3f7ads_adsdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `termid` int(4) NOT NULL,
  `termip` char(50) NOT NULL,
  `adstitle` char(50) NOT NULL,
  `adscontent` char(200) NOT NULL,
  `hightlights` char(100) NOT NULL,
  `activestart` int(4) NOT NULL,
  `activeend` int(4) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f8psm_portaldata`
--

CREATE TABLE IF NOT EXISTS `t_l3f8psm_portaldata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `content1` char(50) NOT NULL,
  `content2` char(50) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f9gism_accidencedirection`
--

CREATE TABLE IF NOT EXISTS `t_l3f9gism_accidencedirection` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `title` char(50) NOT NULL,
  `content1` char(50) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f9gism_scheduledirection`
--

CREATE TABLE IF NOT EXISTS `t_l3f9gism_scheduledirection` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `title` char(50) NOT NULL,
  `perf1` int(4) NOT NULL,
  `perf2` int(4) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f10oam_qrcodeinfo`
--

CREATE TABLE IF NOT EXISTS `t_l3f10oam_qrcodeinfo` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `pdtype` char(3) NOT NULL,
  `pdcode` char(5) NOT NULL,
  `pjcode` char(5) NOT NULL,
  `devcode` varchar(20) NOT NULL,
  `validflag` char(1) NOT NULL DEFAULT 'N',
  `validate` date DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f10oam_regqrcode`
--

CREATE TABLE IF NOT EXISTS `t_l3f10oam_regqrcode` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `applytime` datetime NOT NULL,
  `applyuser` varchar(20) NOT NULL,
  `faccode` varchar(20) NOT NULL,
  `pdtype` char(3) NOT NULL,
  `pdcode` char(5) NOT NULL,
  `pjcode` char(5) NOT NULL,
  `usercode` char(3) NOT NULL,
  `formalflag` char(1) NOT NULL,
  `applynum` int(2) NOT NULL,
  `approvenum` int(2) NOT NULL,
  `digstart` int(2) NOT NULL,
  `digstop` int(2) NOT NULL,
  `zipfile` varchar(30) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f10oam_suhistory`
--

CREATE TABLE IF NOT EXISTS `t_l3f10oam_suhistory` (
  `devcode` varchar(20) NOT NULL,
  `sutimes` int(2) NOT NULL DEFAULT '0',
  `lastsu` date NOT NULL,
  `lastrel` int(2) NOT NULL,
  `lastver` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f10oam_swloadinfo`
--

CREATE TABLE IF NOT EXISTS `t_l3f10oam_swloadinfo` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `equentry` int(1) NOT NULL DEFAULT '0',
  `validflag` int(1) NOT NULL DEFAULT '0',
  `upgradeflag` int(1) NOT NULL DEFAULT '0',
  `hwtype` int(2) NOT NULL DEFAULT '0',
  `hwid` int(2) NOT NULL DEFAULT '0',
  `swrel` int(2) NOT NULL DEFAULT '0',
  `swver` int(2) NOT NULL DEFAULT '0',
  `dbver` int(2) NOT NULL DEFAULT '0',
  `filelink` varchar(100) NOT NULL DEFAULT 'NULL',
  `filesize` int(4) NOT NULL DEFAULT '0',
  `checksum` int(2) NOT NULL DEFAULT '0',
  `note` text,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=134 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f11faam_appleproduction`
--

CREATE TABLE IF NOT EXISTS `t_l3f11faam_appleproduction` (
  `sid` int(6) NOT NULL AUTO_INCREMENT,
  `pjcode` char(5) NOT NULL,
  `qrcode` char(20) NOT NULL,
  `owner` varchar(20) NOT NULL,
  `typecode` varchar(10) NOT NULL,
  `applyweek` int(1) NOT NULL,
  `applytime` datetime NOT NULL,
  `activetime` datetime DEFAULT NULL,
  `lastactivetime` datetime DEFAULT NULL,
  `activeman` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=450 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f11faam_consumables_type`
--

CREATE TABLE IF NOT EXISTS `t_l3f11faam_consumables_type` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `conname` char(50) NOT NULL,
  `contype` char(50) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f11faam_dailysheet`
--

CREATE TABLE IF NOT EXISTS `t_l3f11faam_dailysheet` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `pjcode` char(5) NOT NULL,
  `employee` varchar(20) NOT NULL,
  `workday` date NOT NULL,
  `arrivetime` time NOT NULL,
  `leavetime` time DEFAULT NULL,
  `offwork` float NOT NULL DEFAULT '0',
  `worktime` float NOT NULL DEFAULT '0',
  `unitprice` float NOT NULL DEFAULT '12',
  `lateworkflag` int(1) NOT NULL DEFAULT '0',
  `earlyleaveflag` int(1) NOT NULL DEFAULT '0',
  `daystandardnum` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=84 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f11faam_factorysheet`
--

CREATE TABLE IF NOT EXISTS `t_l3f11faam_factorysheet` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `pjcode` char(5) NOT NULL,
  `workstart` time NOT NULL DEFAULT '07:30:00',
  `workend` time NOT NULL DEFAULT '16:00:00',
  `reststart` time NOT NULL DEFAULT '11:30:00',
  `restend` time NOT NULL DEFAULT '12:00:00',
  `fullwork` int(2) NOT NULL DEFAULT '360',
  `address` varchar(100) NOT NULL,
  `latitude` int(4) NOT NULL,
  `longitude` int(4) NOT NULL,
  `memo` text,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `pjcode` (`pjcode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f11faam_material_stocksheet`
--

CREATE TABLE IF NOT EXISTS `t_l3f11faam_material_stocksheet` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `stockname` char(50) NOT NULL,
  `stockaddress` char(50) NOT NULL,
  `stockheader` char(50) NOT NULL,
  `stocktime` datetime NOT NULL,
  `isself` char(20) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f11faam_material_table`
--

CREATE TABLE IF NOT EXISTS `t_l3f11faam_material_table` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `stockname` char(50) NOT NULL,
  `bucketnum` int(8) NOT NULL,
  `totalprice` int(20) NOT NULL,
  `operatime` datetime NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f11faam_membersheet`
--

CREATE TABLE IF NOT EXISTS `t_l3f11faam_membersheet` (
  `mid` char(10) NOT NULL,
  `pjcode` char(5) NOT NULL,
  `employee` varchar(20) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `phone` char(11) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL,
  `regdate` date NOT NULL,
  `position` varchar(10) DEFAULT NULL,
  `zone` varchar(20) DEFAULT NULL,
  `idcard` char(18) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `bank` varchar(30) DEFAULT NULL,
  `account` varchar(20) DEFAULT NULL,
  `photo` varchar(15) DEFAULT NULL,
  `unitprice` float NOT NULL DEFAULT '12',
  `standardnum` int(2) NOT NULL DEFAULT '700',
  `onjob` int(1) NOT NULL DEFAULT '1',
  `memo` text,
  PRIMARY KEY (`mid`),
  UNIQUE KEY `employee` (`employee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f11faam_products_stocksheet`
--

CREATE TABLE IF NOT EXISTS `t_l3f11faam_products_stocksheet` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `stockname` char(50) NOT NULL,
  `stockaddress` char(50) NOT NULL,
  `stockheader` char(50) NOT NULL,
  `stocktime` datetime NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f11faam_typesheet`
--

CREATE TABLE IF NOT EXISTS `t_l3f11faam_typesheet` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `pjcode` char(5) NOT NULL,
  `typecode` varchar(10) NOT NULL,
  `applenum` int(2) NOT NULL,
  `appleweight` float NOT NULL,
  `applegrade` char(1) NOT NULL,
  `memo` text,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=421 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f11faam_vendor_list`
--

CREATE TABLE IF NOT EXISTS `t_l3f11faam_vendor_list` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `vendor` char(50) NOT NULL,
  `address` char(50) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f11faam_weight_product_sheet`
--

CREATE TABLE IF NOT EXISTS `t_l3f11faam_weight_product_sheet` (
  `sid` int(8) NOT NULL AUTO_INCREMENT,
  `tousr` char(50) DEFAULT NULL,
  `fruser` char(50) NOT NULL,
  `crtim` int(10) DEFAULT NULL,
  `rfiduser` char(50) NOT NULL,
  `spsvalue` double NOT NULL,
  `stocktime` datetime NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=167 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3fxprcm_fhys_locklog`
--

CREATE TABLE IF NOT EXISTS `t_l3fxprcm_fhys_locklog` (
  `sid` int(2) NOT NULL AUTO_INCREMENT,
  `woid` char(10) DEFAULT '0',
  `keyid` char(10) NOT NULL,
  `keyname` char(20) NOT NULL,
  `keyuserid` char(10) NOT NULL,
  `keyusername` varchar(20) NOT NULL,
  `eventtype` char(1) NOT NULL,
  `statcode` varchar(20) NOT NULL,
  `createtime` char(20) NOT NULL,
  `picname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=511 ;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3fxprcm_workerbill`
--

CREATE TABLE IF NOT EXISTS `t_l3fxprcm_workerbill` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `task1` char(50) NOT NULL,
  `approval1` char(50) NOT NULL,
  `state` char(50) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
