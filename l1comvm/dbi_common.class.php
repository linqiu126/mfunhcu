<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2015/12/13
 * Time: 20:21
 */
include_once "../l1comvm/sysconfig.php";
include_once "../l1comvm/sysversion.php";
/*

-- --------------------------------------------------------

--
-- 表的结构 `t_l1vm_loginfo`
--

CREATE TABLE IF NOT EXISTS `t_l1vm_loginfo` (
  `sid` int(6) NOT NULL AUTO_INCREMENT,
  `sysprog` char(20) NOT NULL,
  `sysver` char(20) NOT NULL,
  `project` char(50) NOT NULL,
  `fromuser` char(50) NOT NULL,
  `createtime` char(20) NOT NULL,
  `logtime` char(20) NOT NULL,
  `logdata` text NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_l1vm_loginfo`
--

INSERT INTO `t_l1vm_loginfo` (`sid`, `sysprog`, `sysver`, `project`, `fromuser`, `createtime`, `logtime`,`logdata`) VALUES
(1, 'MFUN_PRG_AQYC', 'R002.D20', 'VM_TRACE', 'MSG_ID_L2SDK_HCU_DATA_COMING', '2016-07-06 10:41:35', '2016-07-06 10:41:35', 'R: <xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201124945000000004E000000000000000057066DF0]]></Content><FuncFlag>0</FuncFlag></xml>'),
(2, 'MFUN_PRG_AQYC', 'R002.D20', 'L4AQYCUI', 'MFUN_TASK_ID_L3APPL_FUM1SYM', '2016-07-06 10:41:36', '2016-07-06 10:41:35', 'T:"{"status":"true","text":"login success","key":"gbsm6ote","admin":"true"}"'),
(3, 'MFUN_PRG_AQYC', 'R002.D20', 'VM_TRACE', 'MSG_ID_L2SDK_HCU_DATA_COMING', '2016-07-06 10:41:36', '2016-07-06 10:41:35', 'R: UserInfo'),
(4, 'MFUN_PRG_AQYC', 'R002.D20', 'L4AQYCUI', 'MFUN_TASK_ID_L3APPL_FUM1SYM', '2016-07-06 10:41:36', '2016-07-06 10:41:35', 'T:"{"status":"false","ret":null}"');


-- --------------------------------------------------------

--
-- 表的结构 `t_l1vm_logtracemodule`
--

CREATE TABLE IF NOT EXISTS `t_l1vm_logtracemodule` (
  `sid` int(6) NOT NULL AUTO_INCREMENT,
  `moduleid` int(2) NOT NULL,
  `allowflag` tinyint(1) NOT NULL,
  `restrictflag` tinyint(1) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_l1vm_logtracemodule`
--

INSERT INTO `t_l1vm_logtracemodule` (`sid`, `moduleid`, `allowflag`, `restrictflag`) VALUES
(1, 1, 1, 0),
(2, 2, 1, 0),
(3, 3, 1, 0),
(4, 4, 1, 0),
(5, 5, 1, 0),
(6, 6, 1, 0),
(7, 7, 1, 0),
(8, 8, 1, 0),
(9, 9, 1, 0),
(10, 10, 1, 0),
(11, 11, 1, 0),
(12, 12, 1, 0),
(13, 13, 1, 0),
(14, 14, 1, 0),
(15, 15, 1, 0),
(16, 16, 1, 0),
(17, 17, 1, 0),
(18, 18, 1, 0),
(19, 19, 1, 0),
(20, 20, 1, 0),
(21, 21, 1, 0),
(22, 22, 1, 0),
(23, 23, 1, 0),
(24, 24, 1, 0),
(25, 25, 1, 0),
(26, 26, 1, 0),
(27, 27, 1, 0),
(28, 28, 1, 0),
(29, 29, 1, 0),
(30, 30, 1, 0),
(31, 31, 1, 0),
(32, 32, 1, 0),
(33, 33, 1, 0),
(34, 34, 1, 0),
(35, 35, 1, 0),
(36, 36, 1, 0),
(37, 37, 1, 0),
(38, 38, 1, 0),
(39, 39, 1, 0),
(40, 40, 1, 0),
(41, 41, 1, 0),
(42, 42, 1, 0),
(43, 43, 1, 0),
(44, 44, 1, 0),
(45, 45, 1, 0),
(46, 46, 1, 0),
(47, 47, 1, 0),
(48, 48, 1, 0),
(49, 49, 1, 0),
(50, 50, 1, 0),
(51, 51, 1, 0),
(52, 52, 1, 0),
(53, 53, 1, 0),
(54, 54, 1, 0),
(55, 55, 1, 0),
(56, 56, 1, 0),
(57, 57, 1, 0),
(58, 58, 1, 0),
(59, 59, 1, 0),
(60, 60, 1, 0),
(61, 61, 1, 0),
(62, 62, 1, 0),
(63, 63, 1, 0),
(64, 64, 1, 0),
(65, 65, 1, 0),
(66, 66, 1, 0),
(67, 67, 1, 0),
(68, 68, 1, 0),
(69, 69, 1, 0),
(70, 70, 1, 0),
(71, 71, 1, 0),
(72, 72, 1, 0),
(73, 73, 1, 0),
(74, 74, 1, 0),
(75, 75, 1, 0),
(76, 76, 1, 0),
(77, 77, 1, 0),
(78, 78, 1, 0),
(79, 79, 1, 0),
(80, 80, 1, 0);


-- --------------------------------------------------------

--
-- 表的结构 `t_l1vm_logtracemsg`
--

CREATE TABLE IF NOT EXISTS `t_l1vm_logtracemsg` (
  `sid` int(6) NOT NULL AUTO_INCREMENT,
  `msgid` int(2) NOT NULL,
  `allowflag` tinyint(1) NOT NULL,
  `restrictflag` tinyint(1) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_l1vm_logtracemsg`
--

INSERT INTO `t_l1vm_logtracemsg` (`sid`, `msgid`, `allowflag`, `restrictflag`) VALUES
(1, 1, 1, 0),
(2, 2, 1, 0),
(3, 3, 1, 0),
(4, 4, 1, 0),
(5, 5, 1, 0),
(6, 6, 1, 0),
(7, 7, 1, 0),
(8, 8, 1, 0),
(9, 9, 1, 0),
(10, 10, 1, 0),
(11, 11, 1, 0),
(12, 12, 1, 0),
(13, 13, 1, 0),
(14, 14, 1, 0),
(15, 15, 1, 0),
(16, 16, 1, 0),
(17, 17, 1, 0),
(18, 18, 1, 0),
(19, 19, 1, 0),
(20, 20, 1, 0),
(21, 21, 1, 0),
(22, 22, 1, 0),
(23, 23, 1, 0),
(24, 24, 1, 0),
(25, 25, 1, 0),
(26, 26, 1, 0),
(27, 27, 1, 0),
(28, 28, 1, 0),
(29, 29, 1, 0),
(30, 30, 1, 0),
(31, 31, 1, 0),
(32, 32, 1, 0),
(33, 33, 1, 0),
(34, 34, 1, 0),
(35, 35, 1, 0),
(36, 36, 1, 0),
(37, 37, 1, 0),
(38, 38, 1, 0),
(39, 39, 1, 0),
(40, 40, 1, 0),
(41, 41, 1, 0),
(42, 42, 1, 0),
(43, 43, 1, 0),
(44, 44, 1, 0),
(45, 45, 1, 0),
(46, 46, 1, 0),
(47, 47, 1, 0),
(48, 48, 1, 0),
(49, 49, 1, 0),
(50, 50, 1, 0),
(51, 51, 1, 0),
(52, 52, 1, 0),
(53, 53, 1, 0),
(54, 54, 1, 0),
(55, 55, 1, 0),
(56, 56, 1, 0),
(57, 57, 1, 0),
(58, 58, 1, 0),
(59, 59, 1, 0),
(60, 60, 1, 0),
(61, 61, 1, 0),
(62, 62, 1, 0),
(63, 63, 1, 0),
(64, 64, 1, 0),
(65, 65, 1, 0),
(66, 66, 1, 0),
(67, 67, 1, 0),
(68, 68, 1, 0),
(69, 69, 1, 0),
(70, 70, 1, 0),
(71, 71, 1, 0),
(72, 72, 1, 0),
(73, 73, 1, 0),
(74, 74, 1, 0),
(75, 75, 1, 0),
(76, 76, 1, 0),
(77, 77, 1, 0),
(78, 78, 1, 0),
(79, 79, 1, 0),
(80, 80, 1, 0),
(81, 81, 1, 0),
(82, 82, 1, 0),
(83, 83, 1, 0),
(84, 84, 1, 0),
(85, 85, 1, 0),
(86, 86, 1, 0),
(87, 87, 1, 0),
(88, 88, 1, 0),
(89, 89, 1, 0),
(90, 90, 1, 0),
(91, 91, 1, 0),
(92, 92, 1, 0),
(93, 93, 1, 0),
(94, 94, 1, 0),
(95, 95, 1, 0),
(96, 96, 1, 0),
(97, 97, 1, 0),
(98, 98, 1, 0),
(99, 99, 1, 0),
(100, 100, 1, 0),
(101, 101, 1, 0),
(102, 102, 1, 0),
(103, 103, 1, 0),
(104, 104, 1, 0),
(105, 105, 1, 0),
(106, 106, 1, 0),
(107, 107, 1, 0),
(108, 108, 1, 0),
(109, 109, 1, 0),
(110, 110, 1, 0),
(111, 111, 1, 0),
(112, 112, 1, 0),
(113, 113, 1, 0),
(114, 114, 1, 0),
(115, 115, 1, 0),
(116, 116, 1, 0),
(117, 117, 1, 0),
(118, 118, 1, 0),
(119, 119, 1, 0),
(120, 120, 1, 0),
(121, 121, 1, 0),
(122, 122, 1, 0),
(123, 123, 1, 0),
(124, 124, 1, 0),
(125, 125, 1, 0),
(126, 126, 1, 0),
(127, 127, 1, 0),
(128, 128, 1, 0),
(129, 129, 1, 0),
(130, 130, 1, 0),
(131, 131, 1, 0),
(132, 132, 1, 0),
(133, 133, 1, 0),
(134, 134, 1, 0),
(135, 135, 1, 0),
(136, 136, 1, 0),
(137, 137, 1, 0),
(138, 138, 1, 0),
(139, 139, 1, 0),
(140, 140, 1, 0),
(141, 141, 1, 0),
(142, 142, 1, 0),
(143, 143, 1, 0),
(144, 144, 1, 0),
(145, 145, 1, 0),
(146, 146, 1, 0),
(147, 147, 1, 0),
(148, 148, 1, 0),
(149, 149, 1, 0),
(150, 150, 1, 0),
(151, 151, 1, 0),
(152, 152, 1, 0),
(153, 153, 1, 0),
(154, 154, 1, 0),
(155, 155, 1, 0),
(156, 156, 1, 0),
(157, 157, 1, 0),
(158, 158, 1, 0),
(159, 159, 1, 0),
(160, 160, 1, 0),
(161, 161, 1, 0),
(162, 162, 1, 0),
(163, 163, 1, 0),
(164, 164, 1, 0),
(165, 165, 1, 0),
(166, 166, 1, 0),
(167, 167, 1, 0),
(168, 168, 1, 0),
(169, 169, 1, 0),
(170, 170, 1, 0),
(171, 171, 1, 0),
(172, 172, 1, 0),
(173, 173, 1, 0),
(174, 174, 1, 0),
(175, 175, 1, 0),
(176, 176, 1, 0),
(177, 177, 1, 0),
(178, 178, 1, 0),
(179, 179, 1, 0),
(180, 180, 1, 0),
(181, 181, 1, 0),
(182, 182, 1, 0),
(183, 183, 1, 0),
(184, 184, 1, 0),
(185, 185, 1, 0),
(186, 186, 1, 0),
(187, 187, 1, 0),
(188, 188, 1, 0),
(189, 189, 1, 0),
(190, 190, 1, 0),
(191, 191, 1, 0),
(192, 192, 1, 0),
(193, 193, 1, 0),
(194, 194, 1, 0),
(195, 195, 1, 0),
(196, 196, 1, 0),
(197, 197, 1, 0),
(198, 198, 1, 0),
(199, 199, 1, 0),
(200, 200, 1, 0),
(201, 201, 1, 0),
(202, 202, 1, 0),
(203, 203, 1, 0),
(204, 204, 1, 0),
(205, 205, 1, 0),
(206, 206, 1, 0),
(207, 207, 1, 0),
(208, 208, 1, 0),
(209, 209, 1, 0);

--
-- 表的结构 `t_l1vm_logwechatswitch`
--

CREATE TABLE IF NOT EXISTS `t_l1vm_logwechatswitch` (
  `user` char(50) NOT NULL,
  `switch` char(1) NOT NULL,
  PRIMARY KEY (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_l1vm_logwechatswitch`
--

INSERT INTO `t_l1vm_logwechatswitch` (`user`, `switch`) VALUES
('oS0Chv3Uum1TZqHaCEb06AoBfCvY', '1'),
('oS0Chv-avCH7W4ubqOQAFXojYODY', '1');

-- --------------------------------------------------------

--
-- 表的结构 `t_l2sdk_iothcu_inventory`
--

CREATE TABLE IF NOT EXISTS `t_l2sdk_iothcu_inventory` (
  `deviceid` char(50) NOT NULL,
  `hw_type` int(1) DEFAULT NULL,
  `hw_ver` int(2) DEFAULT NULL,
  `sw_rel` int(1) DEFAULT NULL,
  `sw_drop` int(2) DEFAULT NULL,
  PRIMARY KEY (`deviceid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_l2sdk_iothcu_inventory`
--

INSERT INTO `t_l2sdk_iothcu_inventory` (`deviceid`, `hw_type`, `hw_ver`, `sw_rel`, `sw_drop`) VALUES
('HCU_SH_0304', 2, 3, 1, 90),
('HCU_SH_0302', 2, 3, 1, 92);


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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_l1vm_engpar`
--

INSERT INTO `t_l1vm_engpar` (`project`, `cloudhttp`, `customername`, `maxusers`, `maxadmin`) VALUES
('MFUN_PRJ_AQYC', "http://", "上海市环保局", 100000, 10);


 */


class classDbiL1vmCommon
{
    //构造函数
    public function __construct()
    {

    }

    //存储logger信息，以便用于调试任务
    public function dbi_log_process_save($project,$fromuser,$createtime,$log_content)
    {
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_DEBUG, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $sysver = MFUN_CURRENT_VERSION;
        $sysprog = MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE;
        $logtime = date("Y-m-d H:i:s", time());
        //存储新记录
        $result = $mysqli->query("INSERT INTO `t_l1vm_loginfo` (sysprog,sysver, project,fromuser,createtime, logtime,logdata) VALUES ('$sysprog', '$sysver', '$project', '$fromuser', '$createtime', '$logtime','$log_content')");

        //查找最大SID
        $result = $mysqli->query("SELECT  MAX(`sid`)  FROM `t_l1vm_loginfo` WHERE 1 ");
        if ($result->num_rows>0){
            $row_max =  $result->fetch_array();
            $sid_max = $row_max['MAX(`sid`)'];
        }
        //查找最小SID
        $result = $mysqli->query("SELECT  MIN(`sid`)  FROM `t_l1vm_loginfo` WHERE 1 ");
        if ($result->num_rows>0) {
            $row_min =  $result->fetch_array();
            $sid_min = $row_min['MIN(`sid`)'] ;
        }

        //检查记录数如果超过MAX_LOG_NUM，则删除老的记录
        if (($sid_max - $sid_min) > MFUN_L1VM_DBI_MAX_LOG_NUM)
        {
            $count = $sid_max - MFUN_L1VM_DBI_MAX_LOG_NUM;
            $result = $mysqli->query("DELETE FROM `t_l1vm_loginfo` WHERE (`sid` >0 AND `sid`< $count) ");
        }

        $mysqli->close();
        return $result;
    }

    //查询t_l1vm_logtracemodule中的允许及限制状态
    public function dbi_logtrace_module_inqury($moudleId)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_DEBUG, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l1vm_logtracemodule` WHERE `moduleid` = '$moudleId'");
        if ($result->num_rows>0)
        {
            $row = $result->fetch_array();
            $allow = intval($row['allowflag']);
            $restrict = intval($row['restrictflag']);
            $resp = array("allowflag" => $allow, "restrictflag" => $restrict);
        }
        else{
            $resp = "";
        }

        $mysqli->close();
        return $resp;
    }

    //查询t_l1vm_logtracemsg中的允许及限制状态
    public function dbi_logtrace_msg_inqury($msgId)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_DEBUG, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l1vm_logtracemsg` WHERE `msgid` = '$msgId'");
        if ($result->num_rows>0)
        {
            $row = $result->fetch_array();
            $allow = intval($row['allowflag']);
            $restrict = intval($row['restrictflag']);
            $resp = array("allowflag" => $allow, "restrictflag" => $restrict);
        }
        else{
            $resp = "";
        }

        $mysqli->close();
        return $resp;
    }

    //更新设备软,硬件版本
    public function dbi_deviceVersion_update($devcode, $mac, $hw_type, $hw_ver, $sw_rel, $sw_drop, $db_ver)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //先检查是否存在，如果存在，就更新，否则创建
        $result = $mysqli->query("SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE `devcode` = '$devcode'");
        if (($result->num_rows)>0)
        {
            $result=$mysqli->query("UPDATE `t_l2sdk_iothcu_inventory` SET `hw_type` = '$hw_type',`hw_ver` = '$hw_ver',`sw_rel` = '$sw_rel',`sw_drop` = '$sw_drop', `hcu_db_ver` = '$db_ver'
                            WHERE `devcode` = '$devcode'");
        }
        else
        {
            $result=$mysqli->query("INSERT INTO `t_l2sdk_iothcu_inventory` (devcode, hw_type, hw_ver, sw_rel,sw_drop,hcu_db_ver)
                          VALUES ('$devcode', '$hw_type', '$hw_ver','$sw_rel','$sw_drop','$db_ver')");
        }
        $mysqli->close();
        return $result;
    }

    //HCU控制命令缓存
    public function dbi_cmdbuf_save_cmd($deviceid, $cmd)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $timestamp = time();
        $cmdtime = date("Y-m-d H:m:s",$timestamp);
        $result=$mysqli->query("INSERT INTO `t_l1vm_cmdbuf` (deviceid, cmd, cmdtime) VALUES ('$deviceid', '$cmd', '$cmdtime')");

        $mysqli->close();
        return $result;
    }

    //HCU Performance数据存储
    public function dbi_hcu_performance_data_save($deviceId, $statcode, $CurlConnAttempt, $CurlConnFailCnt, $CurlDiscCnt, $SocketDiscCnt, $PmTaskRestartCnt, $CPUOccupyCnt, $MemOccupyCnt, $DiskOccupyCnt, $createtime)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $createtime = date("Y-m-d H:m:s",$createtime);
        $result=$mysqli->query("INSERT INTO `t_l3f6pm_perfdata`(`devcode`, `statcode`, `CurlConnAttempt`, `CurlConnFailCnt`, `CurlDiscCnt`, `SocketDiscCnt`, `PmTaskRestartCnt`, `CPUOccupyCnt`, `MemOccupyCnt`, `DiskOccupyCnt`, `createtime`) VALUES ('$deviceId', '$statcode', '$CurlConnAttempt', '$CurlConnFailCnt', '$CurlDiscCnt', '$SocketDiscCnt', '$PmTaskRestartCnt', '$CPUOccupyCnt', '$MemOccupyCnt', '$DiskOccupyCnt', '$createtime')");

        $mysqli->close();
        return $result;
    }

    //HCU Data数据存储
    public function dbi_hcu_alarm_data_save($deviceId, $statCode, $EquipmentId, $AlarmType, $AlarmDescription, $AlarmServerity, $AlarmClearFlag, $AlarmTime, $PictureName)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $AlarmTime = date("Y-m-d H:m:s",$AlarmTime);
        $result=$mysqli->query("INSERT INTO `bxxhl1l2l3`.`t_l3f5fm_alarmdata` (`devcode`, `equipmentid`, `alarmtype`, `alarmdesc`, `alarmseverity`, `alarmclearflag`, `timestamp`, `picturename`) VALUES ('$deviceId', '$EquipmentId', '$AlarmType', '$AlarmDescription', '$AlarmServerity', '$AlarmClearFlag', '$AlarmTime', '$PictureName')");

        $mysqli->close();
        return $result;
    }

    //HCU控制命令查询
    public function dbi_cmdbuf_inquiry_cmd($deviceid)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l1vm_cmdbuf` WHERE `deviceid` = '$deviceid'");
        if ($result->num_rows>0)
        {
            $row = $result->fetch_array();
            $resp = trim($row['cmd']); //返回待发送的命令

            $sid = intval($row['sid']);
            $mysqli->query("DELETE FROM `t_l1vm_cmdbuf` WHERE (`sid` = $sid) "); //从数据库中删除该命令
        }
        else{
            $resp = "";
        }

        $mysqli->close();
        return $resp;

    }

    //设置数据库中该用户微信log开关状态
    public function dbi_LogSwitchInfo_set($user,$switch_set)
    {
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_DEBUG, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $result = $mysqli->query("SELECT * FROM `t_l1vm_logwechatswitch` WHERE `user` = '$user'");

        if ($result->num_rows>0) //如果该用户存在则更新该用户微信log开关状态
        {
            $result=$mysqli->query("UPDATE `t_l1vm_logwechatswitch` SET `switch` = '$switch_set' WHERE (`user` = '$user')");
        }
        else    //否则插入一条新记录
        {
            $result=$mysqli->query("INSERT INTO `t_l1vm_logwechatswitch` (user, switch) VALUES ('$user', '$switch_set')");
        }

        $mysqli->close();
        return $result;
    }

    //查询数据库中该用户微信log开关状态
    public function dbi_LogSwitchInfo_inqury($user)
    {
        $switch_info = 0;
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_DEBUG, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $result = $mysqli->query("SELECT * FROM `t_l1vm_logwechatswitch` WHERE `user` = '$user'");

        if ($result->num_rows>0)
        {
            $row = $result->fetch_array();
            $switch_info = $row['switch'];
        }

        $mysqli->close();
        return $switch_info;
    }

    //查询t_l1vm_engpar中的允许及限制状态
    //该函数还不完整，待完善定义
    public function dbi_engineering_parameter_inqury($project)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l1vm_engpar` WHERE `project` = '$project'");
        if ($result->num_rows>0)
        {
            $row = $result->fetch_array();
            //$allow = intval($row['allowflag']);
            //$restrict = intval($row['restrictflag']);
            //$resp = array("allowflag" => $allow, "restrictflag" => $restrict);
            $resp = $result;
        }
        else{
            $resp = "";
        }

        $mysqli->close();
        return $resp;
    }

}//End of class_common_db

?>