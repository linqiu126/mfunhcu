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

    public function Hex2String($hex){
        $string='';
        for ($i=0; $i < strlen($hex)-1; $i+=2){
            $string .= chr(hexdec($hex[$i].$hex[$i+1]));
        }
        return $string;
    }

    //BYTE转换到字符串
    public function byte2string($n)
    {
        $out = "00";
        $a1 = strtoupper(dechex($n & 0xFF));
        return substr_replace($out, $a1, strlen($out)-strlen($a1), strlen($a1));
    }

    //2*BYTE转换到字符串
    public function ushort2string($n)
    {
        $out = "0000";
        $a1 = strtoupper(dechex($n & 0xFFFF));
        return substr_replace($out, $a1, strlen($out)-strlen($a1), strlen($a1));
    }

    //4*BYTE转换到字符串
    public function int2string($n)
    {
        $out = "00000000";
        $a1 = strtoupper(dechex($n & 0xFFFFFFFF));
        return substr_replace($out, $a1, strlen($out)-strlen($a1), strlen($a1));
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
        $query_str = "INSERT INTO `t_l1vm_loginfo` (sysprog,sysver, project,fromuser,createtime, logtime,logdata) VALUES ('$sysprog', '$sysver', '$project', '$fromuser', '$createtime', '$logtime','$log_content')";
        $result = $mysqli->query($query_str);

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
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE `devcode` = '$devcode'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0)
        {
            $query_str = "UPDATE `t_l2sdk_iothcu_inventory` SET `hw_type` = '$hw_type',`hw_ver` = '$hw_ver',`sw_rel` = '$sw_rel',`sw_drop` = '$sw_drop', `hcu_db_ver` = '$db_ver' WHERE `devcode` = '$devcode'";
            $result=$mysqli->query($query_str);
        }
        else
        {
            $query_str = "INSERT INTO `t_l2sdk_iothcu_inventory` (devcode, hw_type, hw_ver, sw_rel,sw_drop,hcu_db_ver) VALUES ('$devcode', '$hw_type', '$hw_ver','$sw_rel','$sw_drop','$db_ver')";
            $result=$mysqli->query($query_str);
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
        $query_str = "INSERT INTO `t_l1vm_cmdbuf` (deviceid, cmd, cmdtime) VALUES ('$deviceid', '$cmd', '$cmdtime')";
        $result=$mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    //HCU alarm Data数据存储
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

        $query_str = "INSERT INTO `t_l3f5fm_aqyc_alarmdata` (`devcode`, `equipmentid`, `alarmtype`, `alarmdesc`, `alarmseverity`, `alarmclearflag`, `timestamp`, `picturename`) VALUES ('$deviceId', '$EquipmentId', '$AlarmType', '$AlarmDescription', '$AlarmServerity', '$AlarmClearFlag', '$AlarmTime', '$PictureName')";
        $result=$mysqli->query($query_str);

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