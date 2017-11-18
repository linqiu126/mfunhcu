<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/7/1
 * Time: 13:51
 */

/*
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


 */

class classDbiL2sdkWechat
{

    //存储更新Token信息
    public function dbi_accesstoken_save($appid, $appsecret, $lasttime, $access_token, $js_ticket)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //先检查是否存在，如果存在，就更新，否则创建
        $result = $mysqli->query("SELECT * FROM `t_l2sdk_wechat_accesstoken` WHERE `appid` = '$appid' AND `appsecret` = '$appsecret'");
        if (($result->num_rows)>0)
        {
            $result=$mysqli->query("UPDATE `t_l2sdk_wechat_accesstoken` SET `lasttime` = '$lasttime',`access_token` = '$access_token', `js_ticket` = '$js_ticket'
              WHERE `appid` = '$appid' AND `appsecret` = '$appsecret'");
        }
        else
        {
            $result=$mysqli->query("INSERT INTO `t_l2sdk_wechat_accesstoken` (appid, appsecret, lasttime, access_token,js_ticket)
              VALUES ('$appid', '$appsecret', '$lasttime','$access_token','$js_ticket')");
        }
        $mysqli->close();
        return $result;
    }

    //判断是否有已经存在的Token
    public function dbi_accesstoken_inqury($appid, $appsecret)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //先检查是否存在，如果存在，就更新，否则创建
        $result = $mysqli->query("SELECT * FROM `t_l2sdk_wechat_accesstoken` WHERE `appid` = '$appid' AND `appsecret` = '$appsecret'");
        if (($result->num_rows)>0)  {
            $result = $result->fetch_array();
        }else{
            $result = "NOTEXIST";
        }
        $mysqli->close();
        return $result;
    }

    //存储BLE绑定数据
    public function dbi_blebound_save($fromUserName, $deviceID, $openID, $deviceType)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        //存储新记录
        $result=$mysqli->query("INSERT INTO `t_l2sdk_wechat_blebound` (fromuser, deviceid, openid, devicetype)
                    VALUES ('$fromUserName', '$deviceID','$openID','$deviceType')");
        $mysqli->close();
        return $result;
    }

    //查询绑定数据
    public function dbi_blebound_query($fromUserName)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //找到数据库中已有序号最大的，也许会出现序号(6 BYTE)用满的情况，这时应该考虑更新该算法，短期内不需要考虑这么复杂的情况
        $query_str = "SELECT * FROM `t_l2sdk_wechat_blebound` WHERE `fromuser` = '$fromUserName'";
        $result = $mysqli->query($query_str);

        $i=0;
        $resp = false; //初始化
        while($row = $result->fetch_array())
        {
            $resp[$i]["sid"] = $row['sid'];
            $resp[$i]["fromUserName"] = $row['fromuser'];
            $resp[$i]["deviceID"] = $row['deviceid'];
            $resp[$i]["openID"] = $row['openid'];
            $resp[$i]['deviceType'] = $row['devicetype'];
            $i++;
        }

        $mysqli->close();
        return $resp;
    }

    //查询绑定数据是否已经有了相同的记录，否则就不应该重新绑定并增加一条记录
    //测试的过程中还有些问题，需要再行测试！！！
    public function dbi_blebound_duplicate($fromUserName, $deviceID, $openID, $deviceType)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT `sid` FROM `t_l2sdk_wechat_blebound` WHERE ((`fromuser` = '$fromUserName' AND `deviceid` =
          '$deviceID') AND (`openid` = '$openID' AND `devicetype` = '$deviceType'))");
        if (($result->num_rows)>0) $result = true;
        else $result = false;
        $mysqli->close();
        return $result;
    }

    //删除绑定数据
    public function dbi_blebound_delete($fromUserName)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //删除表单
        $result = $mysqli->query("DELETE FROM `t_l2sdk_wechat_blebound` WHERE `fromuser` = '$fromUserName'");
        $mysqli->close();
        return $result;
    }

    //验证微信蓝牙设备条码信息表中DeviceID对应的MAC地址的合法性
    public function dbi_deviceqrcode_valid_mac($deviceId, $mac)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l2sdk_wechat_deviceqrcode` WHERE (`deviceid` = '$deviceId' AND `macaddr` = '$mac')");
        if ($result->num_rows>0)
            $result = true;
        else
            $result = false;

        $mysqli->close();
        return $result;
    }

    //验证微信蓝牙设备条码信息表中DeviceID对应的MAC地址的合法性
    public function dbi_deviceqrcode_valid_qrcode($qrcode)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l2sdk_wechat_deviceqrcode` WHERE (`qrcode` = '$qrcode'");
        if ($result->num_rows>0)
            $result = true;
        else
            $result = false;

        $mysqli->close();
        return $result;
    }

    //寻找一个空的DEVICE_ID
    public function dbi_deviceqrcode_query_mac()
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //先检查是否存在，如果存在，就更新，否则创建
        $result = $mysqli->query("SELECT * FROM `t_l2sdk_wechat_deviceqrcode` WHERE `macaddr` = ' '");
        //只返回一个
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            $res["deviceid"] = $row['deviceid'];
            $res["qrcode"] = $row['qrcode'];
            $res['devicetype'] = $row['devicetype'];
        }else{
            $res = null;
        }
        $mysqli->close();
        return $res;
    }

    //回写MAC属性
    public function dbi_deviceqrcode_update_mac($deviceid, $mac)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //先检查是否存在，如果存在，就更新，否则创建
        $result=$mysqli->query("UPDATE `t_l2sdk_wechat_deviceqrcode` SET `macaddr` = '$mac' WHERE `deviceid` = '$deviceid'");
        $mysqli->close();
        return $result;
    }

    //查询device ID， 二维码和MAC地址的绑定状态
    public function dbi_deviceqrcode_query($deviceid, $devicetype)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l2sdk_wechat_deviceqrcode` WHERE `deviceid` = '$deviceid' AND `devicetype` = '$devicetype'");

        if (($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $res["deviceid"] = $row['deviceid'];
            $res["qrcode"] = $row['qrcode'];
            $res['devicetype'] = $row['devicetype'];
            $res['mac'] = $row['macaddr'];
        }
        else
        {
            $res = false;
        }

        $mysqli->close();
        return $res;
    }

    public function dbi_deviceqrcode_save($deviceid, $qrcode, $devicetype, $mac)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //先检查是否存在，如果不存在，就创建
        $result = $mysqli->query("SELECT * FROM `t_l2sdk_wechat_deviceqrcode` WHERE `deviceid` = '$deviceid' AND `qrcode` = '$qrcode' AND `macaddr` = '$mac' ");
        if (($result->num_rows) == 0)
        {
            $result=$mysqli->query("INSERT INTO `t_l2sdk_wechat_deviceqrcode` (deviceid, qrcode, devicetype, macaddr)
                  VALUES ('$deviceid', '$qrcode', '$devicetype','$mac')");
        }
        else
        {
            $result = "Duplicated, no action";
        }
        $mysqli->close();

        return $result;
    }

    public function dbi_deviceqrcode_delete($deviceid,$qrcode,$mac)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //删除表单
        $result = $mysqli->query("DELETE FROM `t_l2sdk_wechat_deviceqrcode` WHERE `deviceid` = '$deviceid' AND `qrcode` = '$qrcode' AND `macaddr` = '$mac'");
        $mysqli->close();
        return $result;
    }

    public function dbi_site_location_inqury($statcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");
        $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statcode' ";
        $result = $mysqli->query($query_str);
        $location = array();
        if (($result->num_rows) > 0) {
            $row = $result->fetch_array();
            $statname = $row['statname'];
            $longitude = $row['longitude'];
            $latitude = $row['latitude'];
            $location = array('statname'=>$statname, 'longitude'=>$longitude, 'latitude'=>$latitude);
        }

        $mysqli->close();
        return $location;
    }
    
}

?>