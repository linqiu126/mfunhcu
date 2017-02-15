<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/20
 * Time: 23:00
 */
header("Content-type:text/html;charset=utf-8");
//include_once "../../l1comvm/vmlayer.php";

/*

//告警数据的存储
//如果涉及到区分，则需要通过具体的dbi函数来完成
//DBI函数仅仅是样例

-- --------------------------------------------------------
--
-- 表的结构 `t_l3f5fm_alarmdata`
--

CREATE TABLE IF NOT EXISTS `t_l3f5fm_alarmdata` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `alarmsrc` int(4) NOT NULL,
  `alarmtype` char(20) NOT NULL,
  `alarmdesc` char(50) NOT NULL,
  `alarmimpact` char(50) NOT NULL,
  `alarmseverity` int(4) NOT NULL,
  `tsgen` int(4) NOT NULL,
  `tsclose` int(4) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_l3f5fm_alarmdata`
--

INSERT INTO `t_l3f5fm_alarmdata` (`sid`, `alarmdesc`) VALUES
(1, 'Cloud HCU inter-link failure.');

*/


class classDbiL3apF5fm
{
    //构造函数
    public function __construct()
    {

    }

    //查询用户授权的stat_code和proj_code list
    public function dbi_user_statproj_inqury($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //查询该用户授权的项目和项目组列表
        $query_str = "SELECT `auth_code` FROM `t_l3f1sym_authlist` WHERE `uid` = '$uid'";
        $result = $mysqli->query($query_str);
        $p_list = array();
        $pg_list = array();
        while($row = $result->fetch_array())
        {
            $temp = $row["auth_code"];
            $fromat = substr($temp, 0, MFUN_L3APL_F2CM_CODE_FORMAT_LEN);
            if($fromat == MFUN_L3APL_F2CM_PROJ_CODE_PREFIX)
                array_push($p_list,$temp);
            elseif ($fromat == MFUN_L3APL_F2CM_PG_CODE_PREFIX)
                array_push($pg_list,$temp);
        }

        //把授权的项目组列表里对应的项目号也取出来追加到项目列表，获得该用户授权的完整项目列表
        for($i=0; $i<count($pg_list); $i++)
        {
            $query_str = "SELECT `p_code` FROM `t_l3f2cm_projinfo` WHERE `pg_code` = '$pg_list[$i]'";
            $result = $mysqli->query($query_str);
            while($row = $result->fetch_array())
            {
                $temp = $row["p_code"];
                array_push($p_list,$temp);
            }
        }

        //查询授权项目号下对应的所有监测点code
        $auth_list["p_code"] = array();
        $auth_list["stat_code"] = array();
        for($i=0; $i<count($p_list); $i++)
        {
            $query_str = "SELECT `statcode` FROM `t_l3f3dm_siteinfo` WHERE `p_code` = '$p_list[$i]'";
            $result = $mysqli->query($query_str);
            while($row = $result->fetch_array())
            {
                $temp = $row["statcode"];
                array_push($auth_list["stat_code"] ,$temp);
                array_push($auth_list["p_code"] ,$p_list[$i]);
            }
        }

        $mysqli->close();
        return $auth_list;
    }

    //查询该站点是否正处于告警状态
    private function dbi_site_alarm_check($statcode)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $result = $mysqli->query("SELECT * FROM `t_l3f3dm_aqyc_currentreport` WHERE `statcode` = '$statcode'");
        if ($result->num_rows>0){
            $row = $result->fetch_array();
            $pm25 = $row['pm25']/1;
            $windspeed = $row['windspeed']/1;
            $noise = $row['noise']/1;
            $temperature = $row['temperature']/1;
            $humidity = $row['humidity']/1;
        }
        else{
            $pm25 = 0;
            $windspeed = 0;
            $noise = 0;
            $temperature = 0;
            $humidity = 0;
        }

        //PM2.5，噪声或温度任意一个超标，这显示该站点告警
        if(($pm25>MFUN_L3APL_F3DM_TH_ALARM_PM25) OR ($noise)>MFUN_L3APL_F3DM_TH_ALARM_NOISE OR ($temperature)>MFUN_L3APL_F3DM_TH_ALARM_TEMP )
            $resp = true;
        else
            $resp = false;

        $mysqli->close();
        return $resp;
    }


    //获取该用户授权站点中当前存在告警站点的地图显示信息
    public function dbi_map_alarm_sitetinfo_req($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $auth_list["stat_code"] = array();
        $auth_list["p_code"] = array();
        $auth_list = $this->dbi_user_statproj_inqury($uid);

        $sitelist = array();
        for($i=0; $i<count($auth_list["stat_code"]); $i++)
        {
            $statcode = $auth_list['stat_code'][$i];

            $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statcode'";      //查询监测点对应的项目号
            $resp = $mysqli->query($query_str);
            if (($resp->num_rows)>0) {
                $alarm_check = $this->dbi_site_alarm_check($statcode);
                if ($alarm_check){
                    $info = $resp->fetch_array();

                    $latitude = ($info['latitude'])/1000000;  //百度地图经纬度转换
                    $longitude =  ($info['longitude'])/1000000;

                    $temp = array(
                        'StatCode' => $info['statcode'],
                        'StatName' => $info['statname'],
                        'ChargeMan' => $info['chargeman'],
                        'Telephone' => $info['telephone'],
                        'Department' => $info['department'],
                        'Address' => $info['address'],
                        'Country' => $info['country'],
                        'Street' => $info['street'],
                        'Square' => $info['square'],
                        'Flag_la' => $info['flag_la'],
                        'Latitude' => $latitude,
                        'Flag_lo' =>  $info['flag_lo'],
                        'Longitude' => $longitude,
                        'ProStartTime' => $info['starttime'],
                        'Stage' => $info['memo'],
                    );
                    array_push($sitelist, $temp);
                }
            }
        }

        $mysqli->close();
        return $sitelist;
    }

    public function dbi_alarm_data_save($sid, $alarmdesc)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_l3f5fm_alarmdata` WHERE (`sid` = '$sid'");
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_l3f5fm_alarmdata` SET  `alarmdesc` = '$alarmdesc' WHERE (`sid` = '$sid')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l3f5fm_alarmdata` (sid, alarmdesc) VALUES ('$sid', '$alarmdesc')");
        }
        $mysqli->close();
        return $result;
    }

    //删除对应用户所有超过90天的数据
    //缺省做成90天，如果参数错误，导致90天以内的数据强行删除，则不被认可
    public function dbi_alarm_data_3mondel($sid, $days)
    {
        if ($days <90) $days = 90;  //不允许删除90天以内的数据
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("DELETE FROM `t_l3f5fm_alarmdata` WHERE ((`sid` = '$sid') AND (TO_DAYS(NOW()) - TO_DAYS(`date`) > '$days'))");
        $mysqli->close();
        return $result;
    }

    public function dbi_alarm_data_inqury($sid)
    {
        $LatestValue = "";
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l3f5fm_alarmdata` WHERE `sid` = '$sid'");
        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $LatestValue = $row['alarmdesc'];
        }
        $mysqli->close();
        return $LatestValue;
    }


    //UI AlarmType request, 获取所有需要生成告警数据表的传感器类型信息
    public function dbi_all_alarmtype_req($type)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l2snr_sensortype` WHERE 1";
        $result = $mysqli->query($query_str);

        $alarm_type = array();
        while(($result != false) && (($row = $result->fetch_array()) > 0))
        {
            $type_check = $row['typeid'];
            $tye_prefix =  substr($type_check, 0, MFUN_L3APL_F3DM_SENSOR_TYPE_PREFIX_LEN);
            if ($tye_prefix == $type) {
                $temp = array('id' => $row['typeid'],'name' => $row['name']);
                array_push($alarm_type, $temp);
            }
        }

        $mysqli->close();
        return $alarm_type;
    }

    public function dbi_aqyc_current_alarmtable_req($uid)
    {
        //初始化返回值
        $resp["column"] = array();
        $resp['data'] = array();

        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $auth_list["stat_code"] = array();
        $auth_list["p_code"] = array();
        $auth_list = $this->dbi_user_statproj_inqury($uid);

        array_push($resp["column"], "监测点编号");
        array_push($resp["column"], "监测点名称");
        array_push($resp["column"], "项目单位");
        array_push($resp["column"], "区县");
        array_push($resp["column"], "地址");
        array_push($resp["column"], "负责人");
        array_push($resp["column"], "联系电话");
        array_push($resp["column"], "PM2.5");
        array_push($resp["column"], "温度");
        array_push($resp["column"], "湿度");
        array_push($resp["column"], "噪音");
        array_push($resp["column"], "风速");
        array_push($resp["column"], "风向");
        array_push($resp["column"], "设备状态");

        for($i=0; $i<count($auth_list["stat_code"]); $i++)
        {
            $one_row = array();
            $pcode = $auth_list["p_code"][$i];
            $statcode = $auth_list["stat_code"][$i];
            $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statcode'";
            $result = $mysqli->query($query_str);
            if (($result->num_rows) > 0)
            {
                $row = $result->fetch_array();
                array_push($one_row, $statcode);
                array_push($one_row, $row["statname"]);
                array_push($one_row, $row["department"]);
                array_push($one_row, $row["country"]);
                array_push($one_row, $row["address"]);
                array_push($one_row, $row["chargeman"]);
                array_push($one_row, $row["telephone"]);
            }
            $query_str = "SELECT * FROM `t_l3f3dm_aqyc_currentreport` WHERE `statcode` = '$statcode'";
            $result = $mysqli->query($query_str);
            //初始化返回值，确保数据库没有测试报告的情况下界面返回数据长度不报错
            $pm25 = 0;
            $temperature = 0;
            $humidity = 0;
            $noise = 0;
            $windspeed = 0;
            $winddir = 0;
            $status = "停止";
            if (($result->num_rows) > 0)
            {
                $row = $result->fetch_array();
                $pm25 =  $row["pm25"]/10;
                $temperature = $row["temperature"]/10;
                $humidity = $row["humidity"]/10;
                $noise = $row["noise"]/100;
                $windspeed = $row["windspeed"]/10;
                $winddir = $row["winddirection"];

                $timestamp = strtotime($row["createtime"]);
                $currenttime = time();
                if ($currenttime > ($timestamp+180))  //如果最后一次测量报告距离现在已经超过3分钟
                    $status = "停止";
                else
                    $status = "运行";
            }
            array_push($one_row, $pm25);
            array_push($one_row, $temperature);
            array_push($one_row, $humidity);
            array_push($one_row, $noise);
            array_push($one_row, $windspeed);
            array_push($one_row, $winddir);
            array_push($one_row, $status);

            array_push($resp['data'], $one_row);
        }

        $mysqli->close();
        return $resp;
    }

    public function dbi_fhys_alarm_handle_table_req($uid)
    {
        //初始化返回值
        $resp["column"] = array();
        $resp['data'] = array();

        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $auth_list["stat_code"] = array();
        $auth_list["p_code"] = array();
        $auth_list = $this->dbi_user_statproj_inqury($uid);

        array_push($resp["column"], "站点编号");
        array_push($resp["column"], "站点名称");
        array_push($resp["column"], "区县");
        array_push($resp["column"], "地址");
        array_push($resp["column"], "负责人");
        array_push($resp["column"], "联系电话");
        array_push($resp["column"], "告警级别");
        array_push($resp["column"], "门-1状态");
        array_push($resp["column"], "门-2状态");
        array_push($resp["column"], "锁-1状态");
        array_push($resp["column"], "锁-2状态");
        array_push($resp["column"], "信号强度");
        array_push($resp["column"], "剩余电量");
        array_push($resp["column"], "温度");
        array_push($resp["column"], "湿度");
        array_push($resp["column"], "震动告警");
        array_push($resp["column"], "水浸告警");
        array_push($resp["column"], "烟雾告警");


        for($i=0; $i<count($auth_list["stat_code"]); $i++)
        {
            $one_row = array();
            $statcode = $auth_list["stat_code"][$i];
            $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statcode'";
            $result = $mysqli->query($query_str);
            if (($result->num_rows) > 0)
            {
                $row = $result->fetch_array();
                array_push($one_row, $statcode);
                array_push($one_row, $row["statname"]);
                array_push($one_row, $row["country"]);
                array_push($one_row, $row["address"]);
                array_push($one_row, $row["chargeman"]);
                array_push($one_row, $row["telephone"]);
            }
            $query_str = "SELECT * FROM `t_l3f3dm_fhys_currentreport` WHERE `statcode` = '$statcode'";
            $result = $mysqli->query($query_str);
            //初始化返回值，确保数据库没有测试报告的情况下界面返回数据长度不报错
            $alarm_level = MFUN_HCU_FHYS_ALARM_LEVEL_0;
            $alarm_text = "无告警";
            $door_1 = "状态未知";
            $door_2 = "状态未知";
            $lock_1 = "状态未知";
            $lock_2 = "状态未知";
            $sig_level = "0";
            $batt_level = "0"."%";
            $vibr_alarm = "未知";
            $water_alarm = "未知";
            $smok_alarm = "未知";
            $temperature = "0";
            $humidity = "0%";

            if (($result->num_rows) > 0)
            {
                $row = $result->fetch_array();
                //更新设备运行状态
                $alarm_level = $row["alarmlevel"];
                if($alarm_level == MFUN_HCU_FHYS_ALARM_LEVEL_H)
                    $alarm_text = "严重告警";
                elseif($alarm_level == MFUN_HCU_FHYS_ALARM_LEVEL_M)
                    $alarm_text = "中级告警";
                elseif($alarm_level == MFUN_HCU_FHYS_ALARM_LEVEL_L)
                    $alarm_text = "轻微告警";
                else
                    $alarm_text = "无告警";

                //更新门运行状态
                if($row["door_1"] == MFUN_HCU_FHYS_DOOR_OPEN)
                    $door_1 = "正常打开";
                elseif($row["door_1"] == MFUN_HCU_FHYS_DOOR_CLOSE)
                    $door_1 = "正常关闭";
                elseif($row["door_1"] == MFUN_HCU_FHYS_DOOR_ALARM)
                    $door_1 = "暴力打开";

                if($row["door_2"] == MFUN_HCU_FHYS_DOOR_OPEN)
                    $door_2 = "正常打开";
                elseif($row["door_2"] == MFUN_HCU_FHYS_DOOR_CLOSE)
                    $door_2 = "正常关闭";
                elseif($row["door_2"] == MFUN_HCU_FHYS_DOOR_ALARM)
                    $door_2 = "暴力打开";

                //更新锁运行状态
                if($row["lock_1"] == MFUN_HCU_FHYS_LOCK_OPEN)
                    $lock_1 = "正常打开";
                elseif($row["lock_1"] == MFUN_HCU_FHYS_LOCK_CLOSE)
                    $lock_1 = "正常关闭";
                elseif($row["lock_1"] == MFUN_HCU_FHYS_LOCK_ALARM)
                    $lock_1 = "暴力打开";

                if($row["lock_2"] == MFUN_HCU_FHYS_LOCK_OPEN)
                    $lock_2 = "正常打开";
                elseif($row["lock_2"] == MFUN_HCU_FHYS_LOCK_CLOSE)
                    $lock_2 = "正常关闭";
                elseif($row["lock_2"] == MFUN_HCU_FHYS_LOCK_ALARM)
                    $lock_2 = "暴力打开";

                //更新GPRS信号强度
                $sig_level = $row["siglevel"];

                //更新电池剩余电量
                $batt_level = $row["battlevel"]."%";

                //更新温度, 16进制的字符，高2位为整数部分，低2位为小数部分
                $temp = $row["temperature"];
                $temp_h = hexdec(substr($temp, 0, 2)) & 0xFF;
                $temp_l = hexdec(substr($temp, 2, 2)) & 0xFF;
                $temperature = (string)$temp_h . "." . (string)$temp_l;

                //更新湿度,16进制的字符，高2位为整数部分，低2位为小数部分
                $humi = $row["humidity"];
                $humi_h = hexdec(substr($humi, 0, 2)) & 0xFF;
                $humi_l = hexdec(substr($humi, 2, 2)) & 0xFF;
                $humidity = (string)$humi_h . "." . (string)$humi_l . "%";

                //更新震动告警状态
                if($row["vibralarm"] == MFUN_HCU_FHYS_ALARM_YES)
                    $vibr_alarm = "有";
                elseif($row["vibralarm"] == MFUN_HCU_FHYS_ALARM_NO)
                    $vibr_alarm = "无";

                //更新水浸告警状态
                if($row["wateralarm"] == MFUN_HCU_FHYS_ALARM_YES)
                    $water_alarm = "有";
                elseif($row["wateralarm"] == MFUN_HCU_FHYS_ALARM_NO)
                    $water_alarm = "无";

                //更新烟雾告警状态
                if($row["smokalarm"] == MFUN_HCU_FHYS_ALARM_YES)
                    $smok_alarm = "有";
                elseif($row["smokalarm"] == MFUN_HCU_FHYS_ALARM_NO)
                    $smok_alarm = "无";
            }
            array_push($one_row, $alarm_text);
            array_push($one_row, $door_1);
            array_push($one_row, $door_2);
            array_push($one_row, $lock_1);
            array_push($one_row, $lock_2);
            array_push($one_row, $sig_level);
            array_push($one_row, $batt_level);
            array_push($one_row, $temperature);
            array_push($one_row, $humidity);
            array_push($one_row, $vibr_alarm);
            array_push($one_row, $water_alarm);
            array_push($one_row, $smok_alarm);

            if($alarm_level != MFUN_HCU_FHYS_ALARM_LEVEL_0 )
                array_push($resp['data'], $one_row);
        }

        $mysqli->close();
        return $resp;
    }


}

?>