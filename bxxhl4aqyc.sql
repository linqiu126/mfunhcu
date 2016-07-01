-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-07-01 10:47:28
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bxxhl4aqyc`
--

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
(2, 'HCU_SH_0301', '120101001', '2016-03-13 20:35:25', 5219, 274, 274, 1170, 641, 0, 106, 188, 172, 0, 0),
(15, 'HCU_SH_0302', '120101002', '2016-04-07 22:25:52', 4681, NULL, NULL, NULL, NULL, NULL, NULL, 451, 350, NULL, NULL),
(6, 'HCU_SH_0305', '120101005', '2016-05-10 15:27:44', 4867, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'HCU_SH_0309', '120101009', '2016-06-18 23:30:39', 5151, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'HCU_SH_0304', '120101004', '2016-06-16 17:41:00', 4767, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'HCU_SH_0303', '120101003', '2016-06-12 15:29:50', 5620, 136, 136, 237, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
-- 表的结构 `t_siteinfo`
--

CREATE TABLE IF NOT EXISTS `t_siteinfo` (
  `statcode` char(20) NOT NULL,
  `name` char(50) NOT NULL,
  `devcode` char(20) NOT NULL,
  `p_code` char(20) NOT NULL,
  `starttime` date NOT NULL,
  `altitude` int(4) NOT NULL,
  `flag_la` char(1) NOT NULL,
  `latitude` int(4) NOT NULL,
  `flag_lo` char(1) NOT NULL,
  `longitude` int(4) NOT NULL,
  PRIMARY KEY (`statcode`),
  KEY `statCode` (`statcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_siteinfo`
--

INSERT INTO `t_siteinfo` (`statcode`, `name`, `devcode`, `p_code`, `starttime`, `altitude`, `flag_la`, `latitude`, `flag_lo`, `longitude`) VALUES
('120101014', '万宝国际广场西监测点', 'HCU_SH_0314', 'P_0014', '0000-00-00', 0, 'N', 31223441, 'E', 121442703),
('120101017', '港运大厦东监测点', 'HCU_SH_0317', 'P_0017', '0000-00-00', 0, 'N', 31255719, 'E', 121517700),
('120101002', '环球金融中心主监测点', 'HCU_SH_0302', 'P_0002', '0000-00-00', 0, 'N', 31240246, 'E', 121514168),
('120101004', '金桥创科园主入口监测点', 'HCU_SH_0304', 'P_0004', '0000-00-00', 0, 'N', 31248271, 'E', 121615476),
('120101005', '江湾体育场一号监测点', 'HCU_SH_0305', 'P_0005', '0000-00-00', 0, 'N', 31313004, 'E', 121525701),
('120101006', '滨海新村西监测点', 'HCU_SH_0306', 'P_0006', '0000-00-00', 0, 'N', 31382624, 'E', 121501387),
('120101008', '八号监测点', 'HCU_SH_0308', 'P_0008', '0000-00-00', 0, 'N', 31101605, 'E', 121404873),
('120101009', '九号监测点', 'HCU_SH_0309', 'P_0009', '0000-00-00', 0, 'N', 31043827, 'E', 121476450),
('120101010', '十号监测点', 'HCU_SH_0310', 'P_0010', '2016-06-08', 0, 'N', 31088973, 'E', 121295459),
('120101011', '十一号监测点', 'HCU_SH_0311', 'P_0011', '0000-00-00', 0, 'N', 31127234, 'E', 121062241),
('120101012', '十二号监测点', 'HCU_SH_0312', 'P_0012', '0000-00-00', 0, 'N', 31164430, 'E', 121102934),
('120101013', '十三号监测点', 'HCU_SH_0313', 'P_0013', '0000-00-00', 0, 'N', 31218057, 'E', 121297076),
('120101001', '曙光大厦主监测点', 'HCU_SH_0301', 'P_0001', '0000-00-00', 0, 'N', 31203650, 'E', 121526288),
('120101015', '十五号监测点', 'HCU_SH_0302', 'P_0015', '0000-00-00', 0, 'N', 31228283, 'E', 121485388),
('120101016', '十六号监测点', 'HCU_SH_0316', 'P_0016', '0000-00-00', 0, 'N', 31256691, 'E', 121475583),
('120101018', '十八号监测点', 'HCU_SH_0318', 'P_0018', '0000-00-00', 0, 'N', 31357885, 'E', 121256060),
('120101019', '十九号监测点', 'HCU_SH_0319', 'P_0019', '0000-00-00', 0, 'N', 30739094, 'E', 121360693),
('120101007', '七号监测点', 'HCU_SH_0307', 'P_0007', '0000-00-00', 0, 'N', 30900796, 'E', 121933166),
('120101003', '爱启工地主监测点', 'HCU_SH_0303', 'P_0003', '2016-06-01', 0, 'N', 31226542, 'E', 121556498);

-- --------------------------------------------------------

--
-- 表的结构 `t_sitemapping`
--

CREATE TABLE IF NOT EXISTS `t_sitemapping` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `statcode` char(20) NOT NULL,
  `p_code` char(20) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `t_sitemapping`
--

INSERT INTO `t_sitemapping` (`sid`, `statcode`, `p_code`) VALUES
(1, '120101001', 'P_0001'),
(2, '120101002', 'P_0002'),
(3, '120101003', 'P_0003'),
(4, '120101004', 'P_0004'),
(5, '120101005', 'P_0005'),
(6, '120101006', 'P_0006'),
(7, '120101007', 'P_0007'),
(8, '120101008', 'P_0008'),
(9, '120101009', 'P_0009'),
(10, '120101010', 'P_0010'),
(11, '120101011', 'P_0011'),
(12, '120101012', 'P_0012'),
(13, '120101013', 'P_0013'),
(14, '120101014', 'P_0014'),
(15, '120101015', 'P_0015'),
(16, '120101016', 'P_0016'),
(17, '120101017', 'P_0017'),
(18, '120101018', 'P_0018'),
(19, '120101019', 'P_0019');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
