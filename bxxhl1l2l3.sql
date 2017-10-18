-- phpMyAdmin SQL Dump
-- version 4.4.15.8
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017-09-05 07:45:10
-- 服务器版本： 5.6.32
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bxxhl1l2l3`
--

-- --------------------------------------------------------

--
-- 表的结构 `t_l1vm_engpar`
--

CREATE TABLE IF NOT EXISTS `t_l1vm_engpar` (
  `sid` int(4) NOT NULL,
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
  `filedatalog` mediumblob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
  `desc` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2sdk_nbiot_std_cj188_context`
--

CREATE TABLE IF NOT EXISTS `t_l2sdk_nbiot_std_cj188_context` (
  `sid` int(4) NOT NULL,
  `cj188address` char(14) NOT NULL,
  `cntser` int(1) NOT NULL,
  `deviceflag` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2sdk_nbiot_std_qg376_context`
--

CREATE TABLE IF NOT EXISTS `t_l2sdk_nbiot_std_qg376_context` (
  `sid` int(4) NOT NULL,
  `ipmaddress` int(4) NOT NULL,
  `cntpfc` int(1) NOT NULL,
  `deviceflag` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2sdk_wechat_accesstoken`
--

CREATE TABLE IF NOT EXISTS `t_l2sdk_wechat_accesstoken` (
  `appid` char(20) NOT NULL,
  `appsecret` char(50) NOT NULL,
  `lasttime` int(6) NOT NULL,
  `access_token` text NOT NULL,
  `js_ticket` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2sdk_wechat_blebound`
--

CREATE TABLE IF NOT EXISTS `t_l2sdk_wechat_blebound` (
  `sid` int(6) NOT NULL,
  `fromuser` char(50) NOT NULL,
  `deviceid` char(50) NOT NULL,
  `openid` char(50) NOT NULL,
  `devicetype` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2sdk_wechat_deviceqrcode`
--

CREATE TABLE IF NOT EXISTS `t_l2sdk_wechat_deviceqrcode` (
  `deviceid` char(50) NOT NULL,
  `qrcode` char(100) NOT NULL,
  `devicetype` char(30) NOT NULL,
  `macaddr` char(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_airprsdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_airprsdata` (
  `sid` int(4) NOT NULL,
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
  `longitude` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_alcoholdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_alcoholdata` (
  `sid` int(4) NOT NULL,
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
  `longitude` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_aqyc_minreport`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_aqyc_minreport` (
  `sid` int(4) NOT NULL,
  `devcode` char(20) NOT NULL,
  `statcode` char(20) NOT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `dataflag` char(10) NOT NULL DEFAULT 'Y',
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
  `emcvalue` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_bfsc_minreport`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_bfsc_minreport` (
  `sid` int(4) NOT NULL,
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
  `weight_12` int(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_co1data`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_co1data` (
  `sid` int(4) NOT NULL,
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
  `longitude` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_emcaccumulation`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_emcaccumulation` (
  `sid` int(4) NOT NULL,
  `deviceid` char(50) NOT NULL,
  `lastupdatedate` date NOT NULL,
  `avg30days` char(192) NOT NULL,
  `avg3month` char(192) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_emcdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_emcdata` (
  `sid` int(4) NOT NULL,
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
  `longitude` int(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_fhys_minreport`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_fhys_minreport` (
  `sid` int(2) NOT NULL,
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
  `fallValue` float NOT NULL DEFAULT '0',
  `tempvalue` float NOT NULL DEFAULT '0',
  `humidvalue` float NOT NULL DEFAULT '0',
  `rssivalue` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_hchodata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_hchodata` (
  `sid` int(4) NOT NULL,
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
  `longitude` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_hourreport`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_hourreport` (
  `sid` int(4) NOT NULL,
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
  `validdatanum` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_hsmmpdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_hsmmpdata` (
  `sid` int(4) NOT NULL,
  `deviceid` char(50) NOT NULL,
  `videourl` text NOT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_humiddata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_humiddata` (
  `sid` int(4) NOT NULL,
  `deviceid` char(50) NOT NULL,
  `humidity` float NOT NULL,
  `dataflag` char(1) DEFAULT 'N',
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_igmdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_igmdata` (
  `sid` int(4) NOT NULL,
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
  `keyver` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_ihmdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_ihmdata` (
  `sid` int(4) NOT NULL,
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
  `keyver` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_ipmdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_ipmdata` (
  `sid` int(4) NOT NULL,
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
  `keyver` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_ipm_afndata1_f25`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_ipm_afndata1_f25` (
  `sid` int(4) NOT NULL,
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
  `cur_phasecvisualpower` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_iwmdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_iwmdata` (
  `sid` int(4) NOT NULL,
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
  `keyver` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_lightstrdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_lightstrdata` (
  `sid` int(4) NOT NULL,
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
  `longitude` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_noisedata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_noisedata` (
  `sid` int(4) NOT NULL,
  `deviceid` char(50) NOT NULL,
  `noise` float NOT NULL,
  `dataflag` char(1) DEFAULT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_picturedata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_picturedata` (
  `sid` int(4) NOT NULL,
  `statcode` varchar(20) NOT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `filetype` varchar(10) DEFAULT NULL,
  `filesize` varchar(10) NOT NULL DEFAULT '0',
  `filedescription` char(50) DEFAULT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_pm25data`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_pm25data` (
  `sid` int(4) NOT NULL,
  `deviceid` char(50) NOT NULL,
  `pm01` float NOT NULL,
  `pm25` float NOT NULL,
  `pm10` float NOT NULL,
  `dataflag` char(1) DEFAULT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_raindata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_raindata` (
  `sid` int(4) NOT NULL,
  `deviceid` char(50) NOT NULL,
  `sensorid` int(1) NOT NULL,
  `rain` float NOT NULL,
  `dataflag` char(1) NOT NULL DEFAULT 'N',
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_sensortype`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_sensortype` (
  `typeid` char(10) NOT NULL,
  `name` char(10) NOT NULL,
  `value_min` int(2) NOT NULL DEFAULT '0',
  `value_max` int(2) NOT NULL,
  `model` char(20) DEFAULT NULL,
  `vendor` char(20) DEFAULT NULL,
  `dataformat` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_tempdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_tempdata` (
  `sid` int(4) NOT NULL,
  `deviceid` char(50) NOT NULL,
  `temperature` float DEFAULT NULL,
  `dataflag` char(1) DEFAULT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_toxicgasdata`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_toxicgasdata` (
  `sid` int(4) NOT NULL,
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
  `longitude` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_winddir`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_winddir` (
  `sid` int(4) NOT NULL,
  `deviceid` char(50) NOT NULL,
  `winddirection` float DEFAULT NULL,
  `dataflag` char(1) DEFAULT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_windspd`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_windspd` (
  `sid` int(4) NOT NULL,
  `deviceid` char(50) NOT NULL,
  `windspeed` float DEFAULT NULL,
  `dataflag` char(1) DEFAULT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f1sym_account`
--

CREATE TABLE IF NOT EXISTS `t_l3f1sym_account` (
  `uid` char(10) NOT NULL,
  `user` char(20) NOT NULL,
  `nick` char(20) DEFAULT NULL,
  `pwd` char(100) NOT NULL,
  `admin` char(5) DEFAULT NULL,
  `grade` char(1) NOT NULL DEFAULT '0',
  `phone` char(20) DEFAULT NULL,
  `email` char(50) DEFAULT NULL,
  `regdate` date DEFAULT NULL,
  `city` char(10) DEFAULT NULL,
  `backup` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f1sym_authlist`
--

CREATE TABLE IF NOT EXISTS `t_l3f1sym_authlist` (
  `sid` int(4) NOT NULL,
  `uid` char(10) NOT NULL,
  `auth_code` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f1sym_session`
--

CREATE TABLE IF NOT EXISTS `t_l3f1sym_session` (
  `uid` char(20) NOT NULL,
  `sessionid` char(10) NOT NULL,
  `lastupdate` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f1sym_sysinfo`
--

CREATE TABLE IF NOT EXISTS `t_l3f1sym_sysinfo` (
  `sid` int(4) NOT NULL,
  `keyid` char(50) NOT NULL,
  `vendorinfo` char(200) NOT NULL,
  `customerinfo` char(200) NOT NULL,
  `licenseinfo` char(200) NOT NULL,
  `maxadmin` int(4) NOT NULL DEFAULT '10',
  `maxsubscribers` int(4) NOT NULL DEFAULT '1000',
  `maxservers` int(4) NOT NULL DEFAULT '5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f1sym_userprofile`
--

CREATE TABLE IF NOT EXISTS `t_l3f1sym_userprofile` (
  `id` int(11) NOT NULL,
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
  `flags` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f2cm_favourlist`
--

CREATE TABLE IF NOT EXISTS `t_l3f2cm_favourlist` (
  `sid` int(4) NOT NULL,
  `uid` varchar(10) NOT NULL,
  `statcode` varchar(20) NOT NULL,
  `createtime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f2cm_fhys_keyauth`
--

CREATE TABLE IF NOT EXISTS `t_l3f2cm_fhys_keyauth` (
  `sid` int(4) NOT NULL,
  `keyid` char(10) NOT NULL,
  `authlevel` char(1) NOT NULL DEFAULT 'D',
  `authobjcode` char(20) NOT NULL,
  `authtype` char(1) NOT NULL DEFAULT 'T',
  `validnum` int(2) DEFAULT '0',
  `validstart` date DEFAULT NULL,
  `validend` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `memo` text
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
  `backup` text
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
  `sw_base` char(1) NOT NULL DEFAULT '0',
  `starttime` date DEFAULT NULL,
  `pre_endtime` date DEFAULT NULL,
  `true_endtime` date DEFAULT NULL,
  `stage` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f3dm_aqyc_currentreport`
--

CREATE TABLE IF NOT EXISTS `t_l3f3dm_aqyc_currentreport` (
  `sid` int(4) NOT NULL,
  `deviceid` char(50) NOT NULL,
  `statcode` char(20) NOT NULL,
  `createtime` char(20) NOT NULL,
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
  `emcvalue` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
  `weight_12` int(4) NOT NULL DEFAULT '0'
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
  `rssivalue` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='云控锁项目光交箱状态监控表';

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f3dm_siteinfo`
--

CREATE TABLE IF NOT EXISTS `t_l3f3dm_siteinfo` (
  `statcode` char(20) NOT NULL,
  `statname` char(50) NOT NULL,
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
  `latitude` int(4) DEFAULT '0',
  `flag_lo` char(1) DEFAULT 'E',
  `longitude` int(4) DEFAULT '0',
  `memo` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f4icm_sensorctrl`
--

CREATE TABLE IF NOT EXISTS `t_l3f4icm_sensorctrl` (
  `sid` int(4) NOT NULL,
  `deviceid` char(20) NOT NULL,
  `sensorid` char(20) NOT NULL,
  `modbus_addr` int(1) DEFAULT NULL,
  `sensortype` char(10) NOT NULL,
  `meas_period` int(2) DEFAULT NULL,
  `onoffstatus` char(5) NOT NULL DEFAULT 'off',
  `sample_interval` int(2) DEFAULT NULL,
  `meas_times` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f10oam_swloadinfo`
--

CREATE TABLE IF NOT EXISTS `t_l3f10oam_swloadinfo` (
  `sid` int(4) NOT NULL,
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
  `checksum` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f4icm_swfactory`
--

CREATE TABLE IF NOT EXISTS `t_l3f4icm_swfactory` (
  `sid` int(4) NOT NULL,
  `sw_rel` char(2) NOT NULL,
  `sw_drop` char(2) NOT NULL,
  `sw_base` char(1) NOT NULL,
  `swverdescription` char(50) NOT NULL,
  `issuedate` date NOT NULL,
  `swbin` mediumblob NOT NULL,
  `dbbin` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- 表的结构 `t_l3f5fm_aqyc_alarmdata`
--

CREATE TABLE IF NOT EXISTS `t_l3f5fm_aqyc_alarmdata` (
  `sid` int(4) NOT NULL,
  `devcode` varchar(20) NOT NULL,
  `equipmentid` int(4) NOT NULL,
  `alarmtype` int(4) DEFAULT NULL,
  `alarmdesc` int(4) DEFAULT NULL,
  `alarmseverity` int(4) DEFAULT '0',
  `alarmclearflag` int(4) NOT NULL,
  `timestamp` datetime NOT NULL,
  `picturename` varchar(100) DEFAULT NULL,
  `causeid` int(4) DEFAULT NULL,
  `alarmcontent` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f5fm_fhys_alarmdata`
--

CREATE TABLE IF NOT EXISTS `t_l3f5fm_fhys_alarmdata` (
  `sid` int(4) NOT NULL,
  `devcode` varchar(20) NOT NULL,
  `statcode` varchar(20) NOT NULL,
  `alarmflag` char(1) NOT NULL DEFAULT 'N',
  `alarmseverity` char(1) DEFAULT '0',
  `alarmcode` int(2) NOT NULL,
  `tsgen` datetime NOT NULL,
  `tsclose` datetime DEFAULT NULL,
  `alarmproc` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f6pm_perfdata`
--

CREATE TABLE IF NOT EXISTS `t_l3f6pm_perfdata` (
  `sid` int(4) NOT NULL,
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
  `cpuTemp` int(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f7ads_adsdata`
--

CREATE TABLE IF NOT EXISTS `t_l3f7ads_adsdata` (
  `sid` int(4) NOT NULL,
  `termid` int(4) NOT NULL,
  `termip` char(50) NOT NULL,
  `adstitle` char(50) NOT NULL,
  `adscontent` char(200) NOT NULL,
  `hightlights` char(100) NOT NULL,
  `activestart` int(4) NOT NULL,
  `activeend` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f8psm_portaldata`
--

CREATE TABLE IF NOT EXISTS `t_l3f8psm_portaldata` (
  `sid` int(4) NOT NULL,
  `content1` char(50) NOT NULL,
  `content2` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f9gism_accidencedirection`
--

CREATE TABLE IF NOT EXISTS `t_l3f9gism_accidencedirection` (
  `sid` int(4) NOT NULL,
  `title` char(50) NOT NULL,
  `content1` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f9gism_scheduledirection`
--

CREATE TABLE IF NOT EXISTS `t_l3f9gism_scheduledirection` (
  `sid` int(4) NOT NULL,
  `title` char(50) NOT NULL,
  `perf1` int(4) NOT NULL,
  `perf2` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3fxprcm_fhys_locklog`
--

CREATE TABLE IF NOT EXISTS `t_l3fxprcm_fhys_locklog` (
  `sid` int(2) NOT NULL,
  `woid` char(10) DEFAULT '0',
  `keyid` char(10) NOT NULL,
  `keyname` char(20) NOT NULL,
  `keyuserid` char(10) NOT NULL,
  `keyusername` varchar(20) NOT NULL,
  `eventtype` char(1) NOT NULL,
  `statcode` varchar(20) NOT NULL,
  `createtime` char(20) NOT NULL,
  `picname` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l3fxprcm_workerbill`
--

CREATE TABLE IF NOT EXISTS `t_l3fxprcm_workerbill` (
  `sid` int(4) NOT NULL,
  `task1` char(50) NOT NULL,
  `approval1` char(50) NOT NULL,
  `state` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l1vm_engpar`
--
ALTER TABLE `t_l1vm_engpar`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2sdk_iothcu_inventory`
--
ALTER TABLE `t_l2sdk_iothcu_inventory`
  ADD PRIMARY KEY (`devcode`),
  ADD UNIQUE KEY `statcode` (`statcode`);

--
-- Indexes for table `t_l2sdk_nbiot_std_cj188_context`
--
ALTER TABLE `t_l2sdk_nbiot_std_cj188_context`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2sdk_nbiot_std_qg376_context`
--
ALTER TABLE `t_l2sdk_nbiot_std_qg376_context`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2sdk_wechat_accesstoken`
--
ALTER TABLE `t_l2sdk_wechat_accesstoken`
  ADD PRIMARY KEY (`appid`);

--
-- Indexes for table `t_l2sdk_wechat_blebound`
--
ALTER TABLE `t_l2sdk_wechat_blebound`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2sdk_wechat_deviceqrcode`
--
ALTER TABLE `t_l2sdk_wechat_deviceqrcode`
  ADD PRIMARY KEY (`deviceid`);

--
-- Indexes for table `t_l2snr_airprsdata`
--
ALTER TABLE `t_l2snr_airprsdata`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_alcoholdata`
--
ALTER TABLE `t_l2snr_alcoholdata`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_aqyc_minreport`
--
ALTER TABLE `t_l2snr_aqyc_minreport`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_bfsc_minreport`
--
ALTER TABLE `t_l2snr_bfsc_minreport`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_co1data`
--
ALTER TABLE `t_l2snr_co1data`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_emcaccumulation`
--
ALTER TABLE `t_l2snr_emcaccumulation`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_emcdata`
--
ALTER TABLE `t_l2snr_emcdata`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_fhys_minreport`
--
ALTER TABLE `t_l2snr_fhys_minreport`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_hchodata`
--
ALTER TABLE `t_l2snr_hchodata`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_hourreport`
--
ALTER TABLE `t_l2snr_hourreport`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_hsmmpdata`
--
ALTER TABLE `t_l2snr_hsmmpdata`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_humiddata`
--
ALTER TABLE `t_l2snr_humiddata`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_igmdata`
--
ALTER TABLE `t_l2snr_igmdata`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_ihmdata`
--
ALTER TABLE `t_l2snr_ihmdata`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_ipmdata`
--
ALTER TABLE `t_l2snr_ipmdata`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_ipm_afndata1_f25`
--
ALTER TABLE `t_l2snr_ipm_afndata1_f25`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_iwmdata`
--
ALTER TABLE `t_l2snr_iwmdata`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_lightstrdata`
--
ALTER TABLE `t_l2snr_lightstrdata`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_noisedata`
--
ALTER TABLE `t_l2snr_noisedata`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_picturedata`
--
ALTER TABLE `t_l2snr_picturedata`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_pm25data`
--
ALTER TABLE `t_l2snr_pm25data`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_raindata`
--
ALTER TABLE `t_l2snr_raindata`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_sensortype`
--
ALTER TABLE `t_l2snr_sensortype`
  ADD PRIMARY KEY (`typeid`);

--
-- Indexes for table `t_l2snr_tempdata`
--
ALTER TABLE `t_l2snr_tempdata`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_toxicgasdata`
--
ALTER TABLE `t_l2snr_toxicgasdata`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_winddir`
--
ALTER TABLE `t_l2snr_winddir`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l2snr_windspd`
--
ALTER TABLE `t_l2snr_windspd`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l3f1sym_account`
--
ALTER TABLE `t_l3f1sym_account`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `t_l3f1sym_authlist`
--
ALTER TABLE `t_l3f1sym_authlist`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l3f1sym_session`
--
ALTER TABLE `t_l3f1sym_session`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `sessionid` (`sessionid`);

--
-- Indexes for table `t_l3f1sym_sysinfo`
--
ALTER TABLE `t_l3f1sym_sysinfo`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l3f1sym_userprofile`
--
ALTER TABLE `t_l3f1sym_userprofile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_unique_username` (`username`),
  ADD UNIQUE KEY `user_unique_email` (`email`);

--
-- Indexes for table `t_l3f2cm_favourlist`
--
ALTER TABLE `t_l3f2cm_favourlist`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l3f2cm_fhys_keyauth`
--
ALTER TABLE `t_l3f2cm_fhys_keyauth`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l3f2cm_fhys_keyinfo`
--
ALTER TABLE `t_l3f2cm_fhys_keyinfo`
  ADD PRIMARY KEY (`keyid`);

--
-- Indexes for table `t_l3f2cm_projgroup`
--
ALTER TABLE `t_l3f2cm_projgroup`
  ADD PRIMARY KEY (`pg_code`);

--
-- Indexes for table `t_l3f2cm_projinfo`
--
ALTER TABLE `t_l3f2cm_projinfo`
  ADD PRIMARY KEY (`p_code`),
  ADD KEY `statCode` (`p_code`);

--
-- Indexes for table `t_l3f3dm_aqyc_currentreport`
--
ALTER TABLE `t_l3f3dm_aqyc_currentreport`
  ADD PRIMARY KEY (`sid`),
  ADD UNIQUE KEY `deviceid` (`deviceid`);

--
-- Indexes for table `t_l3f3dm_bfsc_currentreport`
--
ALTER TABLE `t_l3f3dm_bfsc_currentreport`
  ADD PRIMARY KEY (`devcode`),
  ADD UNIQUE KEY `statcode` (`statcode`);

--
-- Indexes for table `t_l3f3dm_fhys_currentreport`
--
ALTER TABLE `t_l3f3dm_fhys_currentreport`
  ADD PRIMARY KEY (`devcode`),
  ADD UNIQUE KEY `statcode` (`statcode`);

--
-- Indexes for table `t_l3f3dm_siteinfo`
--
ALTER TABLE `t_l3f3dm_siteinfo`
  ADD PRIMARY KEY (`statcode`),
  ADD KEY `statCode` (`statcode`);

--
-- Indexes for table `t_l3f4icm_sensorctrl`
--
ALTER TABLE `t_l3f4icm_sensorctrl`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l3f10oam_swloadinfo`
--
ALTER TABLE `t_l3f10oam_swloadinfo`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l3f5fm_aqyc_alarmdata`
--
ALTER TABLE `t_l3f5fm_aqyc_alarmdata`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l3f5fm_fhys_alarmdata`
--
ALTER TABLE `t_l3f5fm_fhys_alarmdata`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l3f6pm_perfdata`
--
ALTER TABLE `t_l3f6pm_perfdata`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l3f7ads_adsdata`
--
ALTER TABLE `t_l3f7ads_adsdata`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l3f8psm_portaldata`
--
ALTER TABLE `t_l3f8psm_portaldata`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l3f9gism_accidencedirection`
--
ALTER TABLE `t_l3f9gism_accidencedirection`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l3f9gism_scheduledirection`
--
ALTER TABLE `t_l3f9gism_scheduledirection`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l3fxprcm_fhys_locklog`
--
ALTER TABLE `t_l3fxprcm_fhys_locklog`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `t_l3fxprcm_workerbill`
--
ALTER TABLE `t_l3fxprcm_workerbill`
  ADD PRIMARY KEY (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_l1vm_engpar`
--
ALTER TABLE `t_l1vm_engpar`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2sdk_nbiot_std_cj188_context`
--
ALTER TABLE `t_l2sdk_nbiot_std_cj188_context`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2sdk_nbiot_std_qg376_context`
--
ALTER TABLE `t_l2sdk_nbiot_std_qg376_context`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2sdk_wechat_blebound`
--
ALTER TABLE `t_l2sdk_wechat_blebound`
  MODIFY `sid` int(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_airprsdata`
--
ALTER TABLE `t_l2snr_airprsdata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_alcoholdata`
--
ALTER TABLE `t_l2snr_alcoholdata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_aqyc_minreport`
--
ALTER TABLE `t_l2snr_aqyc_minreport`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_bfsc_minreport`
--
ALTER TABLE `t_l2snr_bfsc_minreport`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_co1data`
--
ALTER TABLE `t_l2snr_co1data`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_emcaccumulation`
--
ALTER TABLE `t_l2snr_emcaccumulation`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_emcdata`
--
ALTER TABLE `t_l2snr_emcdata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_fhys_minreport`
--
ALTER TABLE `t_l2snr_fhys_minreport`
  MODIFY `sid` int(2) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_hchodata`
--
ALTER TABLE `t_l2snr_hchodata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_hourreport`
--
ALTER TABLE `t_l2snr_hourreport`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_hsmmpdata`
--
ALTER TABLE `t_l2snr_hsmmpdata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_humiddata`
--
ALTER TABLE `t_l2snr_humiddata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_igmdata`
--
ALTER TABLE `t_l2snr_igmdata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_ihmdata`
--
ALTER TABLE `t_l2snr_ihmdata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_ipmdata`
--
ALTER TABLE `t_l2snr_ipmdata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_ipm_afndata1_f25`
--
ALTER TABLE `t_l2snr_ipm_afndata1_f25`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_iwmdata`
--
ALTER TABLE `t_l2snr_iwmdata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_lightstrdata`
--
ALTER TABLE `t_l2snr_lightstrdata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_noisedata`
--
ALTER TABLE `t_l2snr_noisedata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_picturedata`
--
ALTER TABLE `t_l2snr_picturedata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_pm25data`
--
ALTER TABLE `t_l2snr_pm25data`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_raindata`
--
ALTER TABLE `t_l2snr_raindata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_tempdata`
--
ALTER TABLE `t_l2snr_tempdata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_toxicgasdata`
--
ALTER TABLE `t_l2snr_toxicgasdata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_winddir`
--
ALTER TABLE `t_l2snr_winddir`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l2snr_windspd`
--
ALTER TABLE `t_l2snr_windspd`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l3f1sym_authlist`
--
ALTER TABLE `t_l3f1sym_authlist`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l3f1sym_sysinfo`
--
ALTER TABLE `t_l3f1sym_sysinfo`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l3f1sym_userprofile`
--
ALTER TABLE `t_l3f1sym_userprofile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l3f2cm_favourlist`
--
ALTER TABLE `t_l3f2cm_favourlist`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l3f2cm_fhys_keyauth`
--
ALTER TABLE `t_l3f2cm_fhys_keyauth`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l3f3dm_aqyc_currentreport`
--
ALTER TABLE `t_l3f3dm_aqyc_currentreport`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l3f4icm_sensorctrl`
--
ALTER TABLE `t_l3f4icm_sensorctrl`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l3f10oam_swloadinfo`
--
ALTER TABLE `t_l3f10oam_swloadinfo`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l3f4icm_swfactory`
--
ALTER TABLE `t_l3f4icm_swfactory`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l3f5fm_aqyc_alarmdata`
--
ALTER TABLE `t_l3f5fm_aqyc_alarmdata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l3f5fm_fhys_alarmdata`
--
ALTER TABLE `t_l3f5fm_fhys_alarmdata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l3f6pm_perfdata`
--
ALTER TABLE `t_l3f6pm_perfdata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l3f7ads_adsdata`
--
ALTER TABLE `t_l3f7ads_adsdata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l3f8psm_portaldata`
--
ALTER TABLE `t_l3f8psm_portaldata`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l3f9gism_accidencedirection`
--
ALTER TABLE `t_l3f9gism_accidencedirection`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l3f9gism_scheduledirection`
--
ALTER TABLE `t_l3f9gism_scheduledirection`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l3fxprcm_fhys_locklog`
--
ALTER TABLE `t_l3fxprcm_fhys_locklog`
  MODIFY `sid` int(2) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_l3fxprcm_workerbill`
--
ALTER TABLE `t_l3fxprcm_workerbill`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
