<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2015/12/13
 * Time: 20:21
 */
include_once "../l1comvm/sysconfig.php";

/*

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
-- 表的结构 `t_l1vm_cmdbuf`
--

CREATE TABLE IF NOT EXISTS `t_l1vm_cmdbuf` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(50) NOT NULL,
  `cmd` char(50) NOT NULL,
  `cmdtime` datetime NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=552 ;

 */


class classDbiL1vmCommon
{
    //更新设备软,硬件版本
    public function dbi_deviceVersion_update($deviceid, $hw_type, $hw_ver, $sw_rel, $sw_drop)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //先检查是否存在，如果存在，就更新，否则创建
        $result = $mysqli->query("SELECT * FROM `t_l1vm_deviceversion` WHERE `deviceid` = '$deviceid'");
        if (($result->num_rows)>0)
        {
            $result=$mysqli->query("UPDATE `t_l1vm_deviceversion` SET `hw_type` = '$hw_type',`hw_ver` = '$hw_ver',`sw_rel` = '$sw_rel',`sw_drop` = '$sw_drop'
                            WHERE `deviceid` = '$deviceid'");
        }
        else
        {
            $result=$mysqli->query("INSERT INTO `t_l1vm_deviceversion` (deviceid, hw_type, hw_ver, sw_rel,sw_drop)
                          VALUES ('$deviceid', '$hw_type', '$hw_ver','$sw_rel','$sw_drop')");
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

        $timestamp = time();
        $cmdtime = date("Y-m-d H:m:s",$timestamp);
        $result=$mysqli->query("INSERT INTO `t_l1vm_cmdbuf` (deviceid, cmd, cmdtime) VALUES ('$deviceid', '$cmd', '$cmdtime')");

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
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $result = $mysqli->query("SELECT * FROM `t_l1vm_logswitch` WHERE `user` = '$user'");

        if ($result->num_rows>0) //如果该用户存在则更新该用户微信log开关状态
        {
            $result=$mysqli->query("UPDATE `t_l1vm_logswitch` SET `switch` = '$switch_set' WHERE (`user` = '$user')");
        }
        else    //否则插入一条新记录
        {
            $result=$mysqli->query("INSERT INTO `t_l1vm_logswitch` (user, switch) VALUES ('$user', '$switch_set')");
        }

        $mysqli->close();
        return $result;
    }

    //查询数据库中该用户微信log开关状态
    public function dbi_LogSwitchInfo_inqury($user)
    {
        $switch_info = 0;
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $result = $mysqli->query("SELECT * FROM `t_l1vm_logswitch` WHERE `user` = '$user'");

        if ($result->num_rows>0)
        {
            $row = $result->fetch_array();
            $switch_info = $row['switch'];
        }

        $mysqli->close();
        return $switch_info;
    }

    public function dbi_log_process($project,$fromuser,$createtime,$log_content)
    {
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        //存储新记录
        $result = $mysqli->query("INSERT INTO `t_l1vm_loginfo` (project,fromuser,createtime, logdata) VALUES ('$project','$fromuser','$createtime','$log_content')");

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
        if (($sid_max - $sid_min) > MFUN_MAX_LOG_NUM)
        {
            $count = $sid_max - MFUN_MAX_LOG_NUM;
            $result = $mysqli->query("DELETE FROM `t_l1vm_loginfo` WHERE (`sid` >0 AND `sid`< $count) ");
        }

        $mysqli->close();
        return $result;
    }

}//End of class_common_db

?>