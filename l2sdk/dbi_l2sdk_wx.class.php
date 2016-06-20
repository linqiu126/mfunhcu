<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2015/12/13
 * Time: 20:14
 */
include_once "../l1comvm/vmlayer.php";
include_once "../l2sdk/dbi_l2sdk_wx.class.php";

class class_wx_db
{
    //验证微信蓝牙设备条码信息表中DeviceID对应的MAC地址的合法性
    public function db_deviceqrcode_valid_mac($deviceId, $mac)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_deviceqrcode` WHERE (`deviceid` = '$deviceId' AND `macaddr` = '$mac')");
        if ($result->num_rows>0)
            $result = true;
        else
            $result = false;

        $mysqli->close();
        return $result;
    }

    //存储BLE绑定数据
    public function db_blebound_save($fromUserName, $deviceID, $openID, $deviceType)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        //存储新记录
        $result=$mysqli->query("INSERT INTO `t_blebound` (fromuser, deviceid, openid, devicetype)
                    VALUES ('$fromUserName', '$deviceID','$openID','$deviceType')");
        $mysqli->close();
        return $result;
    }

    //查询绑定数据
    public function db_blebound_query($fromUserName)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //找到数据库中已有序号最大的，也许会出现序号(6 BYTE)用满的情况，这时应该考虑更新该算法，短期内不需要考虑这么复杂的情况
        $result = $mysqli->query("SELECT * FROM `t_blebound` WHERE `fromuser` = '$fromUserName'");
        $i=0;
        while($row = $result->fetch_array())
        {
            $res[$i]["sid"] = $row['sid'];
            $res[$i]["fromUserName"] = $row['fromuser'];
            $res[$i]["deviceID"] = $row['deviceid'];
            $res[$i]["openID"] = $row['openid'];
            $res[$i]['deviceType'] = $row['devicetype'];
            $i++;
        }
        if ($i == 0) $res = false;

        $mysqli->close();
        return $res;
    }

    //查询绑定数据是否已经有了相同的记录，否则就不应该重新绑定并增加一条记录
    //测试的过程中还有些问题，需要再行测试！！！
    public function db_blebound_duplicate($fromUserName, $deviceID, $openID, $deviceType)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT `sid` FROM `t_blebound` WHERE ((`fromuser` = '$fromUserName' AND `deviceid` =
          '$deviceID') AND (`openid` = '$openID' AND `devicetype` = '$deviceType'))");
        if (($result->num_rows)>0) $result = true;
        else $result = false;
        $mysqli->close();
        return $result;
    }

    //删除绑定数据
    public function db_blebound_delete($fromUserName)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //删除表单
        $result = $mysqli->query("DELETE FROM `t_blebound` WHERE `fromuser` = '$fromUserName'");
        $mysqli->close();
        return $result;
    }

    //存储更新Token信息
    public function db_accesstoken_save($appid, $appsecret, $lasttime, $access_token, $js_ticket)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //先检查是否存在，如果存在，就更新，否则创建
        $result = $mysqli->query("SELECT * FROM `t_accesstoken` WHERE `appid` = '$appid' AND `appsecret` = '$appsecret'");
        if (($result->num_rows)>0)
        {
            $result=$mysqli->query("UPDATE `t_accesstoken` SET `lasttime` = '$lasttime',`access_token` = '$access_token', `js_ticket` = '$js_ticket'
              WHERE `appid` = '$appid' AND `appsecret` = '$appsecret'");
        }
        else
        {
            $result=$mysqli->query("INSERT INTO `t_accesstoken` (appid, appsecret, lasttime, access_token,js_ticket)
              VALUES ('$appid', '$appsecret', '$lasttime','$access_token','$js_ticket')");
        }
        $mysqli->close();
        return $result;
    }

    //判断是否有已经存在的Token
    public function db_accesstoken_inqury($appid, $appsecret)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //先检查是否存在，如果存在，就更新，否则创建
        $result = $mysqli->query("SELECT * FROM `t_accesstoken` WHERE `appid` = '$appid' AND `appsecret` = '$appsecret'");
        if (($result->num_rows)>0)  {
            $result = $result->fetch_array();
        }else{
            $result = "NOTEXIST";
        }
        $mysqli->close();
        return $result;
    }

    //寻找一个空的DEVICE_ID
    public function db_deviceqrcode_query_mac()
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //先检查是否存在，如果存在，就更新，否则创建
        $result = $mysqli->query("SELECT * FROM `t_deviceqrcode` WHERE `macaddr` = ' '");
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
    public function db_deviceqrcode_update_mac($deviceid, $mac)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //先检查是否存在，如果存在，就更新，否则创建
        $result=$mysqli->query("UPDATE `t_deviceqrcode` SET `macaddr` = '$mac' WHERE `deviceid` = '$deviceid'");
        $mysqli->close();
        return $result;
    }

    //查询device ID， 二维码和MAC地址的绑定状态
    public function db_deviceqrcode_query($deviceid, $devicetype)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_deviceqrcode` WHERE `deviceid` = '$deviceid' AND `devicetype` = '$devicetype'");

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

    public function db_deviceqrcode_save($deviceid, $qrcode, $devicetype, $mac)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //先检查是否存在，如果不存在，就创建
        $result = $mysqli->query("SELECT * FROM `t_deviceqrcode` WHERE `deviceid` = '$deviceid' AND `qrcode` = '$qrcode' AND `macaddr` = '$mac' ");
        if (($result->num_rows) == 0)
        {
            $result=$mysqli->query("INSERT INTO `t_deviceqrcode` (deviceid, qrcode, devicetype, macaddr)
                  VALUES ('$deviceid', '$qrcode', '$devicetype','$mac')");
        }
        else
        {
            $result = "Duplicated, no action";
        }
        $mysqli->close();

        return $result;
    }

    public function db_deviceqrcode_delete($deviceid,$qrcode,$mac)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //删除表单
        $result = $mysqli->query("DELETE FROM `t_deviceqrcode` WHERE `deviceid` = '$deviceid' AND `qrcode` = '$qrcode' AND `macaddr` = '$mac'");
        $mysqli->close();
        return $result;
    }

    public function db_emcdata_save_gps($deviceid,$timestamp,$latitude,$longitude)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        //计算时间网格
        $date = intval(date("ymd", $timestamp));
        $stamp = getdate($timestamp);
        $hourminindex = intval(($stamp["hours"] * 60 + floor($stamp["minutes"]/TIME_GRID_SIZE)));

        //查询是否有相同时间网格的记录
        $result = $mysqli->query("SELECT * FROM `t_emcdata` WHERE (`deviceid` = '$deviceid' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        if (($result->num_rows)>0)   //存在则更新对应记录的GPS信息
        {
            $result=$mysqli->query("UPDATE `t_emcdata` SET `latitude` = $latitude,`longitude` = $longitude
                        WHERE (`deviceid` = '$deviceid' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')");
        }
        else   //不存在，新增一条时间网格记录并保存GPS信息
        {
            $result=$mysqli->query("INSERT INTO `t_emcdata` (deviceid, reportdate, hourminindex, latitude, longitude)
                      VALUES ('$deviceid', '$date', '$hourminindex', '$latitude', '$longitude')");
        }

        $mysqli->close();
        return $result;
    }

    //Shanchun Start 通过FromUserName查询DeviceID
    public function db_deviceid_inqury($user)
    {
        $DeviceID = 0;
        $mysqli = new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $result = $mysqli->query("SELECT * FROM `t_blebound` WHERE `fromuser` = '$user'");

        if ($result->num_rows>0)
        {
            $row = $result->fetch_array();
            $DeviceID = $row['deviceid'];
        }

        $mysqli->close();
        return $DeviceID;
    }

    /*  to be checked with Shanchun how to modify this function
    public function db_wxuser_inqury($sid)
    {
        //$wxuser = 0;
        $mysqli = new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $result = $mysqli->query("SELECT * FROM `emcdatainfo` WHERE `sid` = '$sid'");

        if ($result->num_rows>0)
        {
            $row = $result->fetch_array();
            $wxuser = $row['wxuser'];
        }
        $mysqli->close();
        return $wxuser;
    }
    */

    //Shanchun End


}//End of class_wx_db

?>