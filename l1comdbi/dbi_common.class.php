<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2015/12/13
 * Time: 20:21
 */
include_once "../l1comvm/sysconfig.php";

class class_common_db
{
    //更新设备软,硬件版本
    public function db_deviceVersion_update($deviceid, $hw_type, $hw_ver, $sw_rel, $sw_drop)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //先检查是否存在，如果存在，就更新，否则创建
        $result = $mysqli->query("SELECT * FROM `t_deviceversion` WHERE `deviceid` = '$deviceid'");
        if (($result->num_rows)>0)
        {
            $result=$mysqli->query("UPDATE `t_deviceversion` SET `hw_type` = '$hw_type',`hw_ver` = '$hw_ver',`sw_rel` = '$sw_rel',`sw_drop` = '$sw_drop'
                            WHERE `deviceid` = '$deviceid'");
        }
        else
        {
            $result=$mysqli->query("INSERT INTO `t_deviceversion` (deviceid, hw_type, hw_ver, sw_rel,sw_drop)
                          VALUES ('$deviceid', '$hw_type', '$hw_ver','$sw_rel','$sw_drop')");
        }
        $mysqli->close();
        return $result;
    }

    //验证设备的合法性，输入的设备编号是否在HCU设备信息表（t_hcudevice）中有记录
    public function db_hcuDevice_valid_device($devcode)
    {
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $result = $mysqli->query("SELECT `statcode` FROM `t_hcudevice` WHERE (`devcode` = '$devcode')");

        if ($result->num_rows>0){
            $row = $result->fetch_array();
            $result = $row['statcode'];
        }
        else
            $result = "";

        $mysqli->close();
        return $result;
    }

    //验证HCU设备信息表中设备编号对应的MAC地址的合法性
    public function db_hcuDevice_valid_mac($deviceid, $mac)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_hcudevice` WHERE (`devcode` = '$deviceid'AND `macaddr` = '$mac') ");
        if ($result->num_rows>0)
            $result = true;
        else
            $result = false;

        $mysqli->close();
        return $result;
    }

    public function db_hcuDevice_update_status($deviceid, $statcode, $status)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        //因为devcode和statcode已经检查存在,所以直接更新状态
        $result = $mysqli->query("UPDATE `t_hcudevice` SET `status` = '$status' WHERE `devcode` = '$deviceid' AND `statcode` = '$statcode'");

        $mysqli->close();
        return $result;
    }

    //查询该HCU设备的视频地址link
    public function db_siteinfo_inquiry_url($deviceid)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_siteinfo` WHERE `devcode` = '$deviceid'");
        if ($result->num_rows>0)
        {
            $row = $result->fetch_array();
            $resp = trim($row['videourl']); //返回该设备的视频地址
        }
        else{
            $resp = false;
        }

        $mysqli->close();
        return $resp;
    }

    //查询所有HCU list
    public function db_hcuDevice_inquiry_device()
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT `devcode` FROM `t_hcudevice` WHERE 1");

        $i=0;
        while($row = $result->fetch_array())
        {
            $resp[$i]["devcode"] = $row['devcode'];
            $i++;
        }
        if ($i == 0) $resp = false;

        $mysqli->close();
        return $resp;
    }


    //更新各测量数据对应的精度信息
    public function db_dataformat_update_format($deviceid, $type, $format)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        switch($type)
        {
            case "T_airpressure":
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_dataformat` WHERE (`deviceid` = '$deviceid')");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_dataformat` SET  `f_airpressure` = '$format' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_dataformat` (deviceid,f_airpressure) VALUES ('$deviceid','$format')");
                }
                break;
            case "T_emcdata":
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_dataformat` WHERE (`deviceid` = '$deviceid')");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_dataformat` SET  `f_emcdata` = '$format' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_dataformat` (deviceid,f_emcdata) VALUES ('$deviceid','$format')");
                }
                break;
            case "T_humidity":
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_dataformat` WHERE (`deviceid` = '$deviceid')");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_dataformat` SET  `f_humidity` = '$format' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_dataformat` (deviceid,f_humidity) VALUES ('$deviceid','$format')");
                }
                break;
            case "T_noise":
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_dataformat` WHERE (`deviceid` = '$deviceid')");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_dataformat` SET  `f_noise` = '$format' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_dataformat` (deviceid,f_noise) VALUES ('$deviceid','$format')");
                }
                break;
            case "T_pmdata";
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_dataformat` WHERE (`deviceid` = '$deviceid')");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_dataformat` SET  `f_pmdata` = '$format' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_dataformat` (deviceid,f_pmdata) VALUES ('$deviceid','$format')");
                }
                break;
            case "T_rain":
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_dataformat` WHERE (`deviceid` = '$deviceid')");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_dataformat` SET  `f_rain` = '$format' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_dataformat` (deviceid,f_rain) VALUES ('$deviceid','$format')");
                }
                break;
            case "T_temperature":
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_dataformat` WHERE (`deviceid` = '$deviceid')");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_dataformat` SET  `f_temperature` = '$format' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_dataformat` (deviceid,f_temperature) VALUES ('$deviceid','$format')");
                }
                break;
            case "T_winddirection":
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_dataformat` WHERE (`deviceid` = '$deviceid')");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_dataformat` SET  `f_winddirection` = '$format' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_dataformat` (deviceid,f_winddirection) VALUES ('$deviceid','$format')");
                }
                break;
            case "T_windspeed":
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_dataformat` WHERE (`deviceid` = '$deviceid')");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_dataformat` SET  `f_windspeed` = '$format' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_dataformat` (deviceid,f_windspeed) VALUES ('$deviceid','$format')");
                }
                break;
            default:
                $result = "COMMON_DB: invaild data format type";
                break;
        }

        $mysqli->close();
        return $result;
    }

    //更新测量数据当前瞬时值聚合表
    public function db_currentreport_update_value($deviceid, $statcode, $timestamp, $type, $data)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $currenttime = date("Y-m-d H:i:s",$timestamp);

        switch($type)
        {
            case "T_airpressure":
                $airpressure = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_currentreport` WHERE (`deviceid` = '$deviceid' ");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_currentreport` SET  `airpressure` = '$airpressure', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_currentreport` (deviceid,statcode,createtime,airpressure) VALUES ('$deviceid','$statcode','$currenttime','$airpressure')");
                }
                break;
            case "T_emcdata":
                $emc = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_currentreport` WHERE (`deviceid` = '$deviceid')");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_currentreport` SET  `emcvalue` = '$emc', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_currentreport` (deviceid,statcode,createtime,emcvalue) VALUES ('$deviceid','$statcode','$currenttime','$emc')");
                }
                break;
            case "T_humidity":
                $humidity = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_currentreport` SET  `humidity` = '$humidity', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_currentreport` (deviceid,statcode,createtime,humidity) VALUES ('$deviceid','$statcode','$currenttime','$humidity')");
                }
                break;
            case "T_noise":
                $noise = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_currentreport` SET  `noise` = '$noise', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_currentreport` (deviceid,statcode,createtime,noise) VALUES ('$deviceid','$statcode','$currenttime','$noise')");
                }
                break;
            case "T_pmdata";
                $pm01 = $data["pm01"];
                $pm25 = $data["pm25"];
                $pm10 = $data["pm10"];

                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_currentreport` WHERE (`deviceid` = '$deviceid')");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_currentreport` SET   `pm01` = '$pm01',`pm25` = '$pm25',`pm10` = '$pm10',`createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_currentreport` (deviceid,statcode,createtime,pm01,pm25,pm10) VALUES ('$deviceid','$statcode','$currenttime','$pm01','$pm25','$pm10')");
                }
                break;
            case "T_rain":
                $rain = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_currentreport` SET  `rain` = '$rain', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_currentreport` (deviceid,statcode,createtime,rain) VALUES ('$deviceid','$statcode','$currenttime','$rain')");
                }
                break;
            case "T_temperature":
                $temperature = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_currentreport` SET  `temperature` = '$temperature', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_currentreport` (deviceid,statcode,createtime,temperature) VALUES ('$deviceid','$statcode','$currenttime','$temperature')");
                }
                break;
            case "T_winddirection":
                $winddirection = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_currentreport` SET  `winddirection` = '$winddirection', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_currentreport` (deviceid,statcode,createtime,winddirection) VALUES ('$deviceid','$statcode','$currenttime','$winddirection')");
                }
                break;
            case "T_windspeed":
                $windspeed = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_currentreport` SET  `windspeed` = '$windspeed', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_currentreport` (deviceid,statcode,createtime,windspeed) VALUES ('$deviceid','$statcode','$currenttime','$windspeed')");
                }
                break;
            default:
                $result = "COMMON_DB: invaild data type";
                break;
        }

        $mysqli->close();
        return $result;
    }

    //HCU控制命令缓存
    public function db_cmdbuf_save_cmd($deviceid, $cmd)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $timestamp = time();
        $cmdtime = date("Y-m-d H:m:s",$timestamp);
        $result=$mysqli->query("INSERT INTO `t_cmdbuf` (deviceid, cmd, cmdtime) VALUES ('$deviceid', '$cmd', '$cmdtime')");

        $mysqli->close();
        return $result;
    }

    //HCU控制命令查询
    public function db_cmdbuf_inquiry_cmd($deviceid)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_cmdbuf` WHERE `deviceid` = '$deviceid'");
        if ($result->num_rows>0)
        {
            $row = $result->fetch_array();
            $resp = trim($row['cmd']); //返回待发送的命令

            $sid = intval($row['sid']);
            $mysqli->query("DELETE FROM `t_cmdbuf` WHERE (`sid` = $sid) "); //从数据库中删除该命令
        }
        else{
            $resp = "";
        }

        $mysqli->close();
        return $resp;

    }

    //HCU历史视频查询
    public function db_videodata_inquiry_url($deviceid)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_videodata` WHERE `deviceid` = '$deviceid'");

        $i=0;
        while($row = $result->fetch_array())
        {
            $resp[$i]["reportdate"] = $row['reportdate'];
            $resp[$i]["videourl"] = $row['videourl'];
            $i++;
        }
        if ($i == 0) $resp = false;

        $mysqli->close();
        return $resp;
    }

    //设置数据库中该用户微信log开关状态
    public function db_LogSwitchInfo_set($user,$switch_set)
    {
        $mysqli = new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $result = $mysqli->query("SELECT * FROM `t_logswitch` WHERE `user` = '$user'");

        if ($result->num_rows>0) //如果该用户存在则更新该用户微信log开关状态
        {
            $result=$mysqli->query("UPDATE `t_logswitch` SET `switch` = '$switch_set' WHERE (`user` = '$user')");
        }
        else    //否则插入一条新记录
        {
            $result=$mysqli->query("INSERT INTO `t_logswitch` (user, switch) VALUES ('$user', '$switch_set')");
        }

        $mysqli->close();
        return $result;
    }

    //查询数据库中该用户微信log开关状态
    public function db_LogSwitchInfo_inqury($user)
    {
        $switch_info = 0;
        $mysqli = new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $result = $mysqli->query("SELECT * FROM `t_logswitch` WHERE `user` = '$user'");

        if ($result->num_rows>0)
        {
            $row = $result->fetch_array();
            $switch_info = $row['switch'];
        }

        $mysqli->close();
        return $switch_info;
    }

    public function db_log_process($project,$fromuser,$createtime,$log_content)
    {
        $mysqli=new mysqli(MFUN_DBHOST, MFUN_DBUSER, MFUN_DBPSW, MFUN_DBNAME, MFUN_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        //存储新记录
        $result = $mysqli->query("INSERT INTO `t_loginfo` (project,fromuser,createtime, logdata) VALUES ('$project','$fromuser','$createtime','$log_content')");

        //查找最大SID
        $result = $mysqli->query("SELECT  MAX(`sid`)  FROM `t_loginfo` WHERE 1 ");
        if ($result->num_rows>0){
            $row_max =  $result->fetch_array();
            $sid_max = $row_max['MAX(`sid`)'];
        }
        //查找最小SID
        $result = $mysqli->query("SELECT  MIN(`sid`)  FROM `t_loginfo` WHERE 1 ");
        if ($result->num_rows>0) {
            $row_min =  $result->fetch_array();
            $sid_min = $row_min['MIN(`sid`)'] ;
        }

        //检查记录数如果超过MAX_LOG_NUM，则删除老的记录
        if (($sid_max - $sid_min) > MAX_LOG_NUM)
        {
            $count = $sid_max - MAX_LOG_NUM;
            $result = $mysqli->query("DELETE FROM `t_loginfo` WHERE (`sid` >0 AND `sid`< $count) ");
        }

        $mysqli->close();
        return $result;
    }

}//End of class_common_db

?>