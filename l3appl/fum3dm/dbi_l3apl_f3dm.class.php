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
--
-- 表的结构 `t_l3f3dm_siteinfo`
--

CREATE TABLE IF NOT EXISTS `t_l3f3dm_siteinfo` (
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
-- 转存表中的数据 `t_l3f3dm_siteinfo`
--

INSERT INTO `t_l3f3dm_siteinfo` (`statcode`, `name`, `devcode`, `p_code`, `starttime`, `altitude`, `flag_la`, `latitude`, `flag_lo`, `longitude`) VALUES
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
-- 表的结构 `t_l3f3dm_aqyc_currentreport`
--

CREATE TABLE IF NOT EXISTS `t_l3f3dm_aqyc_currentreport` (
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
-- 转存表中的数据 `t_l3f3dm_aqyc_currentreport`
--

INSERT INTO `t_l3f3dm_aqyc_currentreport` (`sid`, `deviceid`, `statcode`, `createtime`, `emcvalue`, `pm01`, `pm25`, `pm10`, `noise`, `windspeed`, `winddirection`, `temperature`, `humidity`, `rain`, `airpressure`) VALUES
(2, 'HCU_SH_0301', '120101001', '2016-04-27 19:48:03', 5219, 231, 231, 637, 641, 0, 106, 188, 205, 0, 0),
(15, 'HCU_SH_0302', '120101002', '2016-06-19 12:56:19', 5050, NULL, NULL, NULL, NULL, NULL, NULL, 451, 350, NULL, NULL),
(6, 'HCU_SH_0305', '120101005', '2016-05-10 15:27:44', 4867, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'HCU_SH_0309', '120101009', '2016-06-18 23:30:39', 5151, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'HCU_SH_0304', '120101004', '2016-06-16 17:41:00', 4767, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'HCU_SH_0303', '120101003', '2016-06-12 15:29:50', 5620, 136, 136, 237, NULL, NULL, NULL, NULL, NULL, NULL, NULL);



*/


class classDbiL3apF3dm
{
    //构造函数
    public function __construct()
    {

    }

    //查询该HCU设备的视频地址link
    public function dbi_siteinfo_inquiry_url($deviceid)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE `devcode` = '$deviceid'");
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

    //更新测量数据当前瞬时值聚合表
    public function dbi_currentreport_update_value($deviceid, $statcode, $timestamp, $type, $data)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
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
                $result = $mysqli->query("SELECT * FROM `t_l3f3dm_aqyc_currentreport` WHERE (`deviceid` = '$deviceid' ");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_l3f3dm_aqyc_currentreport` SET  `airpressure` = '$airpressure', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_l3f3dm_aqyc_currentreport` (deviceid,statcode,createtime,airpressure) VALUES ('$deviceid','$statcode','$currenttime','$airpressure')");
                }
                break;
            case "T_emcdata":
                $emc = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_l3f3dm_aqyc_currentreport` WHERE (`deviceid` = '$deviceid')");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_l3f3dm_aqyc_currentreport` SET  `emcvalue` = '$emc', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_l3f3dm_aqyc_currentreport` (deviceid,statcode,createtime,emcvalue) VALUES ('$deviceid','$statcode','$currenttime','$emc')");
                }
                break;
            case "T_humidity":
                $humidity = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_l3f3dm_aqyc_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_l3f3dm_aqyc_currentreport` SET  `humidity` = '$humidity', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_l3f3dm_aqyc_currentreport` (deviceid,statcode,createtime,humidity) VALUES ('$deviceid','$statcode','$currenttime','$humidity')");
                }
                break;
            case "T_noise":
                $noise = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_l3f3dm_aqyc_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_l3f3dm_aqyc_currentreport` SET  `noise` = '$noise', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_l3f3dm_aqyc_currentreport` (deviceid,statcode,createtime,noise) VALUES ('$deviceid','$statcode','$currenttime','$noise')");
                }
                break;
            case "T_pmdata";
                $pm01 = $data["pm01"];
                $pm25 = $data["pm25"];
                $pm10 = $data["pm10"];

                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_l3f3dm_aqyc_currentreport` WHERE (`deviceid` = '$deviceid')");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_l3f3dm_aqyc_currentreport` SET   `pm01` = '$pm01',`pm25` = '$pm25',`pm10` = '$pm10',`createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_l3f3dm_aqyc_currentreport` (deviceid,statcode,createtime,pm01,pm25,pm10) VALUES ('$deviceid','$statcode','$currenttime','$pm01','$pm25','$pm10')");
                }
                break;
            case "T_rain":
                $rain = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_l3f3dm_aqyc_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_l3f3dm_aqyc_currentreport` SET  `rain` = '$rain', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_l3f3dm_aqyc_currentreport` (deviceid,statcode,createtime,rain) VALUES ('$deviceid','$statcode','$currenttime','$rain')");
                }
                break;
            case "T_temperature":
                $temperature = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $query_str = "SELECT * FROM `t_l3f3dm_aqyc_currentreport` WHERE (`deviceid` = '$deviceid' )";
                $result = $mysqli->query($query_str);
                if (($result->num_rows)>0) {
                    $query_str = "UPDATE `t_l3f3dm_aqyc_currentreport` SET  `temperature` = '$temperature', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')";
                    $result = $mysqli->query($query_str);
                }
                else {
                    $query_str = "INSERT INTO `t_l3f3dm_aqyc_currentreport` (deviceid,statcode,createtime,temperature) VALUES ('$deviceid','$statcode','$currenttime','$temperature')";
                    $result = $mysqli->query($query_str);
                }
                break;
            case "T_winddirection":
                $winddirection = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_l3f3dm_aqyc_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_l3f3dm_aqyc_currentreport` SET  `winddirection` = '$winddirection', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_l3f3dm_aqyc_currentreport` (deviceid,statcode,createtime,winddirection) VALUES ('$deviceid','$statcode','$currenttime','$winddirection')");
                }
                break;
            case "T_windspeed":
                $windspeed = $data['value'];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_l3f3dm_aqyc_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_l3f3dm_aqyc_currentreport` SET  `windspeed` = '$windspeed', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_l3f3dm_aqyc_currentreport` (deviceid,statcode,createtime,windspeed) VALUES ('$deviceid','$statcode','$currenttime','$windspeed')");
                }
                break;
            default:
                $result = "COMMON_DB: invaild data type";
                break;
        }

        $mysqli->close();
        return $result;
    }




    /**********************************************************************************************************************
     *                                                 地图显示相关操作DB API                                               *
     *********************************************************************************************************************/
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


    //UI MonitorList request, 获取该用户地图显示的所有监测点信息
    public function dbi_map_sitetinfo_req($uid)
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
                $info = $resp->fetch_array();

                $latitude = (string)(($info['latitude'])/1000000);  //百度地图经纬度转换
                $longitude = (string)(($info['longitude'])/1000000);

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

        $mysqli->close();
        return $sitelist;
    }

    public function dbi_favourite_count_process($uid, $statCode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $timestamp = time();
        $currenttime = date("Y-m-d H:i:s",$timestamp);
        $query_str = "SELECT * FROM `t_l3f2cm_favourlist` WHERE `uid` = '$uid'";
        $result = $mysqli->query($query_str);
        $total = $result->num_rows;
        if($total < MFUN_L3APL_F2CM_FAVOURSITE_MAX_NUM){ //新增一个站点
            $query_str = "SELECT * FROM `t_l3f2cm_favourlist` WHERE (`uid` = '$uid' AND `statcode` = '$statCode')";
            $resp = $mysqli->query($query_str);
            if (($resp->num_rows)>0){//如果有重复，则更新这个站点的点击日期
                $row = $resp->fetch_array();
                $sid = $row['sid'];
                $query_str = "UPDATE `t_l3f2cm_favourlist` SET `createtime` = '$currenttime' WHERE (`sid` = '$sid' )";
                $result = $mysqli->query($query_str);
            }
            else{
                $query_str = "INSERT INTO `t_l3f2cm_favourlist` (uid,statcode,createtime) VALUES ('$uid','$statCode','$currenttime')";
                $result = $mysqli->query($query_str);
            }
        }
        else{//替换一个时间最早的站点
            $query_str = "SELECT * FROM `t_l3f2cm_favourlist` WHERE (`createtime` = (SELECT MIN(`createtime`) FROM `t_l3f2cm_favourlist` where `uid` = '$uid' )) AND (`uid` = '$uid')";
            $result = $mysqli->query($query_str);
            if (($result->num_rows)>0) {
                $row = $result->fetch_array();
                $sid = $row['sid'];
                $query_str = "UPDATE `t_l3f2cm_favourlist` SET `uid` = '$uid',`statcode` = '$statCode', `createtime` = '$currenttime' WHERE (`sid` = '$sid' )";
                $result = $mysqli->query($query_str);
            }
        }
        $mysqli->close();
        return $result;
    }

    public function dbi_favourite_list_process($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $sitelist = array();
        $query_str = "SELECT * FROM `t_l3f2cm_favourlist` WHERE `uid` = '$uid'";
        $result = $mysqli->query($query_str);
        while ($row = $result->fetch_array()){
            $statcode = $row['statcode'];

            $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statcode'";      //查询监测点对应的项目号
            $resp = $mysqli->query($query_str);
            if (($resp->num_rows)>0) {
                $info = $resp->fetch_array();

                $latitude = (string)(($info['latitude'])/1000000);  //百度地图经纬度转换
                $longitude = (string)(($info['longitude'])/1000000);

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
        $mysqli->close();
        return $sitelist;
    }

    /**********************************************************************************************************************
     *                                                 传感器相关操作DB API                                                 *
     *********************************************************************************************************************/
    //UI DevAlarm Request, 获取当前的测量值，如果测量值超出范围，提示告警
    public function dbi_aqyc_dev_currentvalue_req($statcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $vcrname = array();
        $vcrlink = array();
        $vcrlist = array();
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE `statcode` = '$statcode'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            array_push($vcrname,"RTSP");
            array_push($vcrname,"CAMCTRL");
            $rtsp = $row['videourl'];
            $cam_ctrl = $row['camctrl'];
            array_push($vcrlink,$rtsp);
            array_push($vcrlink,$cam_ctrl);
            $vcrlist = array('vcrname'=>$vcrname, 'vcraddress'=>$vcrlink);
        }

        $currentvalue = array(); //初始化
        $query_str = "SELECT * FROM `t_l3f3dm_aqyc_currentreport` WHERE `statcode` = '$statcode'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0)
        {
            $row = $result->fetch_array();  //暂时先这样处理，此处测量值计算要根据上报精度进行修改。。。。。
            $noise = $row['noise']/1;
            $winddir = $row['winddirection']/1;
            $humidity = $row['humidity']/1;
            $temperature = $row['temperature']/1;
            $pm25 = $row['pm25']/1;
            $windspeed = $row['windspeed']/1;

            //更新设备运行状态
            $last_report = $row["createtime"];
            $timestamp = strtotime($last_report);
            $currenttime = time();
            if ($currenttime > ($timestamp + MFUN_HCU_AQYC_SLEEP_DURATION)) { //如果最后一次测量报告距离现在已经超过休眠间隔门限
                $dev_status = "休眠中";
                $alarm = "false";
            }
            else{
                $dev_status = "运行中";
                $alarm = "false";
            }
            $temp = array(
                'AlarmName'=>"设备状态 ",
                'AlarmEName'=> "AQYC_status",
                'AlarmValue'=>(string)$dev_status,
                'AlarmUnit'=>" ",
                'WarningTarget'=>$alarm
            );
            //将设备运行状态注销，只显示其他6种环境参量
            //array_push($currentvalue,$temp);

            if ($pm25 !== NULL){
                if ($pm25 > MFUN_L3APL_F3DM_TH_ALARM_PM25)
                    $alarm = "true";
                else
                    $alarm = "false";
                $temp = array(
                    'AlarmName'=>"颗粒物 ",
                    'AlarmEName'=> "AQYC_pm2.5",
                    'AlarmValue'=>(string)$pm25,
                    'AlarmUnit'=>" μg/m3",
                    'WarningTarget'=>$alarm
                );
                array_push($currentvalue,$temp);
            }
            else{
                $temp = array(
                    'AlarmName'=>"颗粒物 ",
                    'AlarmEName'=> "AQYC_pm2.5",
                    'AlarmValue'=>"NULL",
                    'AlarmUnit'=>" ",
                    'WarningTarget'=>"true"
                );
                array_push($currentvalue,$temp);
            }


            if ($noise !== NULL){
                if ($noise > MFUN_L3APL_F3DM_TH_ALARM_NOISE)
                    $alarm = "true";
                else
                    $alarm = "false";

                $temp = array(
                    'AlarmName'=>"噪声 ",
                    'AlarmEName'=> "AQYC_noise",
                    'AlarmValue'=>(string)$noise,
                    'AlarmUnit'=>" dB",
                    'WarningTarget'=>$alarm
                );
                array_push($currentvalue,$temp);
            }
            else{
                $temp = array(
                    'AlarmName'=>"噪声 ",
                    'AlarmEName'=> "AQYC_noise",
                    'AlarmValue'=> "NULL",
                    'AlarmUnit'=>" ",
                    'WarningTarget'=> "true"
                );
                array_push($currentvalue,$temp);
            }

            if ($windspeed !== NULL){
                if ($windspeed > MFUN_L3APL_F3DM_TH_ALARM_WINDSPD)
                    $alarm = "true";
                else
                    $alarm = "false";
                $temp = array(
                    'AlarmName'=>"风速 ",
                    'AlarmEName'=> "AQYC_windspeed",
                    'AlarmValue'=>(string)$windspeed,
                    'AlarmUnit'=>" m/s",
                    'WarningTarget'=>$alarm
                );
                array_push($currentvalue,$temp);
            }
            else{
                $temp = array(
                    'AlarmName'=>"风速 ",
                    'AlarmEName'=> "AQYC_windspeed",
                    'AlarmValue'=> "NULL",
                    'AlarmUnit'=>" ",
                    'WarningTarget'=> "true"
                );
                array_push($currentvalue,$temp);
            }


            if ($winddir !== NULL){
                $temp = array(
                    'AlarmName'=>"风向 ",
                    'AlarmEName'=> "AQYC_winddir",
                    'AlarmValue'=>(string)$winddir,
                    'AlarmUnit'=>" ",
                    'WarningTarget'=>"false"
                );
                array_push($currentvalue,$temp);
            }
            else{
                $temp = array(
                    'AlarmName'=>"风向 ",
                    'AlarmEName'=> "AQYC_winddir",
                    'AlarmValue'=> "NULL",
                    'AlarmUnit'=>" ",
                    'WarningTarget'=> "true"
                );
                array_push($currentvalue,$temp);
            }

            if ($humidity !== NULL){
                if ($humidity > MFUN_L3APL_F3DM_TH_ALARM_HUMID)
                    $alarm = "true";
                else
                    $alarm = "false";
                $temp = array(
                    'AlarmName'=>"湿度 ",
                    'AlarmEName'=> "AQYC_humi",
                    'AlarmValue'=>(string)$humidity,
                    'AlarmUnit'=>" %",
                    'WarningTarget'=>$alarm
                );
                array_push($currentvalue,$temp);
            }
            else{
                $temp = array(
                    'AlarmName'=>"湿度 ",
                    'AlarmEName'=> "AQYC_humi",
                    'AlarmValue'=> "NULL",
                    'AlarmUnit'=>" ",
                    'WarningTarget'=> "true"
                );
                array_push($currentvalue,$temp);
            }

            if ($temperature !== NULL){
                if ($temperature > MFUN_L3APL_F3DM_TH_ALARM_TEMP)
                    $alarm = "true";
                else
                    $alarm = "false";
                $temp = array(
                    'AlarmName'=>"温度 ",
                    'AlarmEName'=> "AQYC_temp",
                    'AlarmValue'=>(string)$temperature,
                    'AlarmUnit'=>" °C",
                    'WarningTarget'=>$alarm
                );
                array_push($currentvalue,$temp);
            }
            else{
                $temp = array(
                    'AlarmName'=>"温度 ",
                    'AlarmEName'=> "AQYC_temp",
                    'AlarmValue'=> "NULL",
                    'AlarmUnit'=>" ",
                    'WarningTarget'=> "true"
                );
                array_push($currentvalue,$temp);
            }
        }
        else
            $currentvalue = "";

        $resp = array('StatCode'=>$statcode, 'alarmlist'=>$currentvalue, 'vcr'=>$vcrlist);

        $mysqli->close();
        return $resp;
    }

    //UI AlarmQuery Request, 获取告警历史数据
    public function dbi_aqyc_dev_alarmhistory_req($statcode, $date, $alarm_type)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //根据监测点号查找对应的设备号
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE `statcode` = '$statcode'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows) > 0) {
            $row = $result->fetch_array();
            $devcode = $row['devcode'];
        }

        //查询highchart坐标轴的最大和最小值
        $query_str = "SELECT * FROM `t_l2snr_sensortype` WHERE `typeid` = '$alarm_type'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows) > 0) {
            $row = $result->fetch_array();
            $value_min = $row['value_min']/1;
            $value_max = $row['value_max']/1;
            $dataformat = $row['dataformat']/1;
            $resp["value_min"] = $value_min;
            $resp["value_max"] = $value_max;
        }



        switch($alarm_type) {
            case MFUN_L3APL_F3DM_AQYC_STYPE_PM:
                $resp["alarm_name"] = "细颗粒物";
                $resp["alarm_unit"] = "微克/立方米";
                $resp["warning"] = MFUN_L3APL_F3DM_TH_ALARM_PM25;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                //24小时的分钟图表
                $query_str = "SELECT * FROM `t_l2snr_pm25data` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["pm25"];
                        $hourminindex = $row["hourminindex"];
                        $hour = floor($hourminindex/60) ;
                        $min = $hourminindex - $hour*60;
                        $head = $hour.":".$min;
                        $data=intval($data);
                        array_push($resp["minute_alarm"], $data);
                        array_push($resp["minute_head"], $head);
                    }
                    //临时填的随机数
                    /*for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }*/
                }
                else
                {
                    //临时填的随机数
                    for ($i=0; $i<(60*24); $i++){
                        array_push($resp["minute_alarm"],0);
                        array_push($resp["minute_head"],(string)$i);
                    }
                    /*for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }*/
                }

                //一周小时图表
                //$date = $date." 00:00:00";
                $start_date = date('Y-m-d',strtotime($date)-6*24*60*60); //找到一周前的起始日期
                $date_temp = $start_date;
                $query_str = "SELECT * FROM `t_l2snr_pm25data` WHERE `deviceid` = '$devcode' AND `reportdate` between '$start_date' AND '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    //将一周内的数值，按小时归组，先按小时清零
                    for ($day_index=0;$day_index<8;$day_index++)
                    {
                        for ($hour_index=0;$hour_index<24;$hour_index++)
                        {
                            $pm25[$day_index][$hour_index]["sum"]=0;
                            $pm25[$day_index][$hour_index]["counter"]=0;
                            $pm25[$day_index][$hour_index]["average"]=0;
                        }
                    }

                    //将查询到的数值扔进去
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["pm25"];
                        $hourminindex = $row["hourminindex"];
                        $hour_index = floor($hourminindex/60) ;

                        // 取值这一周内的第几天
                        $day_index = date("d",strtotime($row["reportdate"])-strtotime($start_date));
                        $day_index = intval($day_index);

                        $pm25[$day_index][$hour_index]["sum"] = $pm25[$day_index][$hour_index]["sum"] + $data;
                        $pm25[$day_index][$hour_index]["counter"] ++;

                    }

                    //将一周内的数值，按小时求算术平均值
                    for ($day_index=0;$day_index<7;$day_index++)
                    {
                        for ($hour_index=0;$hour_index<24;$hour_index++)
                        {
                            if ($pm25[$day_index][$hour_index]["counter"]!=0)
                            {
                                $pm25[$day_index][$hour_index]["average"]=$pm25[$day_index][$hour_index]["sum"]/$pm25[$day_index][$hour_index]["counter"];
                            }
                            else
                            {
                                $pm25[$day_index][$hour_index]["average"]=0; //或者跳过这个值？
                            }

                            $date_value = date("Y-m-d",strtotime($start_date) + $day_index*24*60*60);
                            $head = $date_value." ".$hour_index.":00";
                            $average = round($pm25[$day_index][$hour_index]["average"],$dataformat);
                            array_push($resp["hour_alarm"], $average);
                            array_push($resp["hour_head"], $head);
                        }
                    }

                }
                else
                {
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                }


                //30天按天的图表
                $start_date = date('Y-m-d',strtotime($date)-29*24*60*60); //找到起始日期
                $query_str = "SELECT * FROM `t_l2snr_pm25data` WHERE `deviceid` = '$devcode' AND `reportdate` between '$start_date' AND '$date'  ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    //将30天内的数值，按天归组，先按天清零
                    for ($day_index=0;$day_index<31;$day_index++)
                    {
                        $pm25[$day_index]["sum"]=0;
                        $pm25[$day_index]["counter"]=0;
                        $pm25[$day_index]["average"]=0;
                    }

                    //将查询到的数值扔进去
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["pm25"];

                        // 取值这30天内的第几天
                        $day_index = date("d",strtotime($row["reportdate"])-strtotime($start_date));
                        $day_index = intval($day_index);

                        $pm25[$day_index]["sum"] = $pm25[$day_index]["sum"] + $data;
                        $pm25[$day_index]["counter"] ++;

                    }

                    //将30天内的数值，按天求算术平均值
                    for ($day_index=0;$day_index<30;$day_index++)
                    {
                        if ($pm25[$day_index]["counter"]!=0)
                        {
                            $pm25[$day_index]["average"]=$pm25[$day_index]["sum"]/$pm25[$day_index]["counter"];
                        }
                        else
                        {
                            $pm25[$day_index]["average"]=0; //或者跳过这个值？
                        }

                        $date_value = date("Y-m-d",strtotime($start_date) + $day_index*24*60*60);
                        $head = $date_value;
                        $average = round($pm25[$day_index]["average"],$dataformat);
                        array_push($resp["day_alarm"], $average);
                        array_push($resp["day_head"], $head);
                    }

                }
                else
                {
                    for ($i=0; $i<30; $i++) {
                        array_push($resp["day_alarm"], 0);
                        array_push($resp["day_head"], (string)$i);
                    }
                }

                break;

            case MFUN_L3APL_F3DM_AQYC_STYPE_WINDSPD:
                $resp["alarm_name"] = "风速";
                $resp["alarm_unit"] = "米/秒";
                $resp["warning"] = MFUN_L3APL_F3DM_TH_ALARM_WINDSPD;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                //24小时的分钟图表
                $query_str = "SELECT * FROM `t_l2snr_windspd` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["windspeed"];
                        $hourminindex = $row["hourminindex"];
                        $hour = floor($hourminindex/60) ;
                        $min = $hourminindex - $hour*60;
                        $head = $hour.":".$min;
                        $data=intval($data);
                        array_push($resp["minute_alarm"], $data);
                        array_push($resp["minute_head"], $head);
                    }
                    //临时填的随机数
                    /*for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }*/
                }
                else
                {
                    //临时填的随机数
                    for ($i=0; $i<(60*24); $i++){
                        array_push($resp["minute_alarm"],0);
                        array_push($resp["minute_head"],(string)$i);
                    }
                    /*for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }*/
                }

                //一周小时图表
                //$date = $date." 00:00:00";
                $start_date = date('Y-m-d',strtotime($date)-6*24*60*60); //找到一周前的起始日期
                $date_temp = $start_date;
                $query_str = "SELECT * FROM `t_l2snr_windspd` WHERE `deviceid` = '$devcode' AND `reportdate` between '$start_date' AND '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    //将一周内的数值，按小时归组，先按小时清零
                    for ($day_index=0;$day_index<8;$day_index++)
                    {
                        for ($hour_index=0;$hour_index<24;$hour_index++)
                        {
                            $windspeed[$day_index][$hour_index]["sum"]=0;
                            $windspeed[$day_index][$hour_index]["counter"]=0;
                            $windspeed[$day_index][$hour_index]["average"]=0;
                        }
                    }

                    //将查询到的数值扔进去
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["windspeed"];
                        $hourminindex = $row["hourminindex"];
                        $hour_index = floor($hourminindex/60) ;

                        // 取值这一周内的第几天
                        $day_index = date("d",strtotime($row["reportdate"])-strtotime($start_date));
                        $day_index = intval($day_index);

                        $windspeed[$day_index][$hour_index]["sum"] = $windspeed[$day_index][$hour_index]["sum"] + $data;
                        $windspeed[$day_index][$hour_index]["counter"] ++;

                    }

                    //将一周内的数值，按小时求算术平均值
                    for ($day_index=0;$day_index<7;$day_index++)
                    {
                        for ($hour_index=0;$hour_index<24;$hour_index++)
                        {
                            if ($windspeed[$day_index][$hour_index]["counter"]!=0)
                            {
                                $windspeed[$day_index][$hour_index]["average"]=$windspeed[$day_index][$hour_index]["sum"]/$windspeed[$day_index][$hour_index]["counter"];
                            }
                            else
                            {
                                $windspeed[$day_index][$hour_index]["average"]=0; //或者跳过这个值？
                            }

                            $date_value = date("Y-m-d",strtotime($start_date) + $day_index*24*60*60);
                            $head = $date_value." ".$hour_index.":00";
                            $average = round($windspeed[$day_index][$hour_index]["average"],$dataformat);
                            array_push($resp["hour_alarm"], $average);
                            array_push($resp["hour_head"], $head);
                        }
                    }

                }
                else
                {
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                }


                //30天按天的图表
                $start_date = date('Y-m-d',strtotime($date)-29*24*60*60); //找到起始日期
                $query_str = "SELECT * FROM `t_l2snr_windspd` WHERE `deviceid` = '$devcode' AND `reportdate` between '$start_date' AND '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    //将30天内的数值，按天归组，先按天清零
                    for ($day_index=0;$day_index<31;$day_index++)
                    {
                        $windspeed[$day_index]["sum"]=0;
                        $windspeed[$day_index]["counter"]=0;
                        $windspeed[$day_index]["average"]=0;
                    }

                    //将查询到的数值扔进去
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["windspeed"];

                        // 取值这30天内的第几天
                        $day_index = date("d",strtotime($row["reportdate"])-strtotime($start_date));
                        $day_index = intval($day_index);

                        $windspeed[$day_index]["sum"] = $windspeed[$day_index]["sum"] + $data;
                        $windspeed[$day_index]["counter"] ++;

                    }

                    //将30天内的数值，按天求算术平均值
                    for ($day_index=0;$day_index<30;$day_index++)
                    {
                        if ($windspeed[$day_index]["counter"]!=0)
                        {
                            $windspeed[$day_index]["average"]=$windspeed[$day_index]["sum"]/$windspeed[$day_index]["counter"];
                        }
                        else
                        {
                            $windspeed[$day_index]["average"]=0; //或者跳过这个值？
                        }

                        $date_value = date("Y-m-d",strtotime($start_date) + $day_index*24*60*60);
                        $head = $date_value;
                        $average = round($windspeed[$day_index]["average"],$dataformat);
                        array_push($resp["day_alarm"], $average);
                        array_push($resp["day_head"], $head);
                    }

                }
                else
                {
                    for ($i=0; $i<30; $i++) {
                        array_push($resp["day_alarm"], 0);
                        array_push($resp["day_head"], (string)$i);
                    }
                }

                break;

            case MFUN_L3APL_F3DM_AQYC_STYPE_WINDDIR:
                $resp["alarm_name"] = "风向";
                $resp["alarm_unit"] = "度";
                $resp["warning"] = MFUN_L3APL_F3DM_TH_ALARM_WINDDIR;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                $query_str = "SELECT * FROM `t_l2snr_winddir` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["winddirection"];
                        $huorminindex = $row["hourminindex"];
                        $hour = floor($huorminindex/60) ;
                        $min = $huorminindex - $hour*60;
                        $head = $hour.":".$min;
                        array_push($resp["minute_alarm"], $data);
                        array_push($resp["minute_head"], $head);
                    }
                    //临时填的随机数
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                else
                {
                    //临时填的随机数
                    for ($i=0; $i<(60*24); $i++){
                        array_push($resp["minute_alarm"],0);
                        array_push($resp["minute_head"],(string)$i);
                    }
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                break;

            case MFUN_L3APL_F3DM_AQYC_STYPE_EMC:
                $resp["alarm_name"] = "电磁辐射";
                $resp["alarm_unit"] = "毫瓦/平方毫米";
                $resp["warning"] = MFUN_L3APL_F3DM_TH_ALARM_EMC;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                $query_str = "SELECT * FROM `t_l2snr_emcdata` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["emcvalue"]/100;
                        $huorminindex = $row["hourminindex"];
                        $hour = floor($huorminindex/60) ;
                        $min = $huorminindex - $hour*60;
                        $head = $hour.":".$min;
                        array_push($resp["minute_alarm"], $data);
                        array_push($resp["minute_head"], $head);
                    }
                    //临时填的随机数
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                else
                {
                    //临时填的随机数
                    for ($i=0; $i<(60*24); $i++){
                        array_push($resp["minute_alarm"],0);
                        array_push($resp["minute_head"],(string)$i);
                    }
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }
                }
                break;

            case MFUN_L3APL_F3DM_AQYC_STYPE_TEMP:
                $resp["alarm_name"] = "温度";
                $resp["alarm_unit"] = "摄氏度";
                $resp["warning"] = MFUN_L3APL_F3DM_TH_ALARM_TEMP;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                //24小时的分钟图表
                $query_str = "SELECT * FROM `t_l2snr_tempdata` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["temperature"];
                        $hourminindex = $row["hourminindex"];
                        $hour = floor($hourminindex/60) ;
                        $min = $hourminindex - $hour*60;
                        $head = $hour.":".$min;
                        $data=intval($data);
                        array_push($resp["minute_alarm"], $data);
                        array_push($resp["minute_head"], $head);
                    }
                    //临时填的随机数
                    /*for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }*/
                }
                else
                {
                    //临时填的随机数
                    for ($i=0; $i<(60*24); $i++){
                        array_push($resp["minute_alarm"],0);
                        array_push($resp["minute_head"],(string)$i);
                    }
                    /*for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }*/
                }

                //一周小时图表
                //$date = $date." 00:00:00";
                $start_date = date('Y-m-d',strtotime($date)-6*24*60*60); //找到一周前的起始日期
                $date_temp = $start_date;
                $query_str = "SELECT * FROM `t_l2snr_tempdata` WHERE `deviceid` = '$devcode' AND `reportdate` between '$start_date' AND '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    //将一周内的数值，按小时归组，先按小时清零
                    for ($day_index=0;$day_index<8;$day_index++)
                    {
                        for ($hour_index=0;$hour_index<24;$hour_index++)
                        {
                            $temperature[$day_index][$hour_index]["sum"]=0;
                            $temperature[$day_index][$hour_index]["counter"]=0;
                            $temperature[$day_index][$hour_index]["average"]=0;
                        }
                    }

                    //将查询到的数值扔进去
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["temperature"];
                        $hourminindex = $row["hourminindex"];
                        $hour_index = floor($hourminindex/60) ;

                        // 取值这一周内的第几天
                        $day_index = date("d",strtotime($row["reportdate"])-strtotime($start_date));
                        $day_index = intval($day_index);

                        $temperature[$day_index][$hour_index]["sum"] = $temperature[$day_index][$hour_index]["sum"] + $data;
                        $temperature[$day_index][$hour_index]["counter"] ++;

                    }

                    //将一周内的数值，按小时求算术平均值
                    for ($day_index=0;$day_index<7;$day_index++)
                    {
                        for ($hour_index=0;$hour_index<24;$hour_index++)
                        {
                            if ($temperature[$day_index][$hour_index]["counter"]!=0)
                            {
                                $temperature[$day_index][$hour_index]["average"]=$temperature[$day_index][$hour_index]["sum"]/$temperature[$day_index][$hour_index]["counter"];
                            }
                            else
                            {
                                $temperature[$day_index][$hour_index]["average"]=0; //或者跳过这个值？
                            }

                            $date_value = date("Y-m-d",strtotime($start_date) + $day_index*24*60*60);
                            $head = $date_value." ".$hour_index.":00";
                            $average = round($temperature[$day_index][$hour_index]["average"],$dataformat);
                            array_push($resp["hour_alarm"], $average);
                            array_push($resp["hour_head"], $head);
                        }
                    }

                }
                else
                {
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                }


                //30天按天的图表
                $start_date = date('Y-m-d',strtotime($date)-29*24*60*60); //找到起始日期
                $query_str = "SELECT * FROM `t_l2snr_tempdata` WHERE `deviceid` = '$devcode' AND `reportdate` between '$start_date' AND '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    //将30天内的数值，按天归组，先按天清零
                    for ($day_index=0;$day_index<31;$day_index++)
                    {
                        $noise[$day_index]["sum"]=0;
                        $noise[$day_index]["counter"]=0;
                        $noise[$day_index]["average"]=0;
                    }

                    //将查询到的数值扔进去
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["temperature"];

                        // 取值这30天内的第几天
                        $day_index = date("d",strtotime($row["reportdate"])-strtotime($start_date));
                        $day_index = intval($day_index);

                        $temperature[$day_index]["sum"] = $temperature[$day_index]["sum"] + $data;
                        $temperature[$day_index]["counter"] ++;

                    }

                    //将30天内的数值，按天求算术平均值
                    for ($day_index=0;$day_index<30;$day_index++)
                    {
                        if ($temperature[$day_index]["counter"]!=0)
                        {
                            $temperature[$day_index]["average"]=$temperature[$day_index]["sum"]/$temperature[$day_index]["counter"];
                        }
                        else
                        {
                            $temperature[$day_index]["average"]=0; //或者跳过这个值？
                        }

                        $date_value = date("Y-m-d",strtotime($start_date) + $day_index*24*60*60);
                        $head = $date_value;
                        $average = round($temperature[$day_index]["average"],$dataformat);
                        array_push($resp["day_alarm"], $average);
                        array_push($resp["day_head"], $head);
                    }

                }
                else
                {
                    for ($i=0; $i<30; $i++) {
                        array_push($resp["day_alarm"], 0);
                        array_push($resp["day_head"], (string)$i);
                    }
                }

                break;

            case MFUN_L3APL_F3DM_AQYC_STYPE_HUMID:
                $resp["alarm_name"] = "湿度";
                $resp["alarm_unit"] = "%";
                $resp["warning"] = MFUN_L3APL_F3DM_TH_ALARM_HUMID;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                //24小时的分钟图表
                $query_str = "SELECT * FROM `t_l2snr_humiddata` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["humidity"];
                        $hourminindex = $row["hourminindex"];
                        $hour = floor($hourminindex/60) ;
                        $min = $hourminindex - $hour*60;
                        $head = $hour.":".$min;
                        $data=intval($data);
                        array_push($resp["minute_alarm"], $data);
                        array_push($resp["minute_head"], $head);
                    }
                    //临时填的随机数
                    /*for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }*/
                }
                else
                {
                    //临时填的随机数
                    for ($i=0; $i<(60*24); $i++){
                        array_push($resp["minute_alarm"],0);
                        array_push($resp["minute_head"],(string)$i);
                    }
                    /*for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }*/
                }

                //一周小时图表
                //$date = $date." 00:00:00";
                $start_date = date('Y-m-d',strtotime($date)-6*24*60*60); //找到一周前的起始日期
                $date_temp = $start_date;
                $query_str = "SELECT * FROM `t_l2snr_humiddata` WHERE `deviceid` = '$devcode' AND `reportdate` between '$start_date' AND '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    //将一周内的数值，按小时归组，先按小时清零
                    for ($day_index=0;$day_index<8;$day_index++)
                    {
                        for ($hour_index=0;$hour_index<24;$hour_index++)
                        {
                            $humidity[$day_index][$hour_index]["sum"]=0;
                            $humidity[$day_index][$hour_index]["counter"]=0;
                            $humidity[$day_index][$hour_index]["average"]=0;
                        }
                    }

                    //将查询到的数值扔进去
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["humidity"];
                        $hourminindex = $row["hourminindex"];
                        $hour_index = floor($hourminindex/60) ;

                        // 取值这一周内的第几天
                        $day_index = date("d",strtotime($row["reportdate"])-strtotime($start_date));
                        $day_index = intval($day_index);

                        $humidity[$day_index][$hour_index]["sum"] = $humidity[$day_index][$hour_index]["sum"] + $data;
                        $humidity[$day_index][$hour_index]["counter"] ++;

                    }

                    //将一周内的数值，按小时求算术平均值
                    for ($day_index=0;$day_index<7;$day_index++)
                    {
                        for ($hour_index=0;$hour_index<24;$hour_index++)
                        {
                            if ($humidity[$day_index][$hour_index]["counter"]!=0)
                            {
                                $humidity[$day_index][$hour_index]["average"]=$humidity[$day_index][$hour_index]["sum"]/$humidity[$day_index][$hour_index]["counter"];
                            }
                            else
                            {
                                $humidity[$day_index][$hour_index]["average"]=0; //或者跳过这个值？
                            }

                            $date_value = date("Y-m-d",strtotime($start_date) + $day_index*24*60*60);
                            $head = $date_value." ".$hour_index.":00";
                            $average = round($humidity[$day_index][$hour_index]["average"],$dataformat);
                            array_push($resp["hour_alarm"], $average);
                            array_push($resp["hour_head"], $head);
                        }
                    }

                }
                else
                {
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                }


                //30天按天的图表
                $start_date = date('Y-m-d',strtotime($date)-29*24*60*60); //找到起始日期
                $query_str = "SELECT * FROM `t_l2snr_humiddata` WHERE `deviceid` = '$devcode' AND `reportdate` between '$start_date' AND '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    //将30天内的数值，按天归组，先按天清零
                    for ($day_index=0;$day_index<31;$day_index++)
                    {
                        $noise[$day_index]["sum"]=0;
                        $noise[$day_index]["counter"]=0;
                        $noise[$day_index]["average"]=0;
                    }

                    //将查询到的数值扔进去
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["humidity"];

                        // 取值这30天内的第几天
                        $day_index = date("d",strtotime($row["reportdate"])-strtotime($start_date));
                        $day_index = intval($day_index);

                        $humidity[$day_index]["sum"] = $humidity[$day_index]["sum"] + $data;
                        $humidity[$day_index]["counter"] ++;

                    }

                    //将30天内的数值，按天求算术平均值
                    for ($day_index=0;$day_index<30;$day_index++)
                    {
                        if ($humidity[$day_index]["counter"]!=0)
                        {
                            $humidity[$day_index]["average"]=$humidity[$day_index]["sum"]/$humidity[$day_index]["counter"];
                        }
                        else
                        {
                            $humidity[$day_index]["average"]=0; //或者跳过这个值？
                        }

                        $date_value = date("Y-m-d",strtotime($start_date) + $day_index*24*60*60);
                        $head = $date_value;
                        $average = round($humidity[$day_index]["average"],$dataformat);
                        array_push($resp["day_alarm"], $average);
                        array_push($resp["day_head"], $head);
                    }

                }
                else
                {
                    for ($i=0; $i<30; $i++) {
                        array_push($resp["day_alarm"], 0);
                        array_push($resp["day_head"], (string)$i);
                    }
                }

                break;

            case MFUN_L3APL_F3DM_AQYC_STYPE_NOISE:
                $resp["alarm_name"] = "噪声";
                $resp["alarm_unit"] = "分贝";
                $resp["warning"] = MFUN_L3APL_F3DM_TH_ALARM_NOISE;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                //24小时的分钟图表
                $query_str = "SELECT * FROM `t_l2snr_noisedata` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["noise"];
                        $hourminindex = $row["hourminindex"];
                        $hour = floor($hourminindex/60) ;
                        $min = $hourminindex - $hour*60;
                        $head = $hour.":".$min;
                        $data=intval($data);
                        array_push($resp["minute_alarm"], $data);
                        array_push($resp["minute_head"], $head);
                    }
                    //临时填的随机数
                    /*for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }*/
                }
                else
                {
                    //临时填的随机数
                    for ($i=0; $i<(60*24); $i++){
                        array_push($resp["minute_alarm"],0);
                        array_push($resp["minute_head"],(string)$i);
                    }
                    /*for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                    for ($i=0; $i<30; $i++){
                        array_push($resp["day_alarm"],0);
                        array_push($resp["day_head"],(string)$i);
                    }*/
                }

                //一周小时图表
                //$date = $date." 00:00:00";
                $start_date = date('Y-m-d',strtotime($date)-6*24*60*60); //找到一周前的起始日期
                $date_temp = $start_date;
                $query_str = "SELECT * FROM `t_l2snr_noisedata` WHERE `deviceid` = '$devcode' AND `reportdate` between '$start_date' AND '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    //将一周内的数值，按小时归组，先按小时清零
                    for ($day_index=0;$day_index<8;$day_index++)
                    {
                        for ($hour_index=0;$hour_index<24;$hour_index++)
                        {
                            $noise[$day_index][$hour_index]["sum"]=0;
                            $noise[$day_index][$hour_index]["counter"]=0;
                            $noise[$day_index][$hour_index]["average"]=0;
                        }
                    }

                    //将查询到的数值扔进去
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["noise"];
                        $hourminindex = $row["hourminindex"];
                        $hour_index = floor($hourminindex/60) ;

                        // 取值这一周内的第几天
                        $day_index = date("d",strtotime($row["reportdate"])-strtotime($start_date));
                        $day_index = intval($day_index);

                        $noise[$day_index][$hour_index]["sum"] = $noise[$day_index][$hour_index]["sum"] + $data;
                        $noise[$day_index][$hour_index]["counter"] ++;

                    }

                    //将一周内的数值，按小时求算术平均值
                    for ($day_index=0;$day_index<7;$day_index++)
                    {
                        for ($hour_index=0;$hour_index<24;$hour_index++)
                        {
                            if ($noise[$day_index][$hour_index]["counter"]!=0)
                            {
                                $noise[$day_index][$hour_index]["average"]=$noise[$day_index][$hour_index]["sum"]/$noise[$day_index][$hour_index]["counter"];
                            }
                            else
                            {
                                $noise[$day_index][$hour_index]["average"]=0; //或者跳过这个值？
                            }

                            $date_value = date("Y-m-d",strtotime($start_date) + $day_index*24*60*60);
                            $head = $date_value." ".$hour_index.":00";
                            $average = round($noise[$day_index][$hour_index]["average"],$dataformat);
                            array_push($resp["hour_alarm"], $average);
                            array_push($resp["hour_head"], $head);
                        }
                    }

                }
                else
                {
                    for ($i=0; $i<(7*24); $i++){
                        array_push($resp["hour_alarm"],0);
                        array_push($resp["hour_head"],(string)$i);
                    }
                }


                //30天按天的图表
                $start_date = date('Y-m-d',strtotime($date)-29*24*60*60); //找到起始日期
                $query_str = "SELECT * FROM `t_l2snr_noisedata` WHERE `deviceid` = '$devcode' AND `reportdate` between '$start_date' AND '$date' ORDER BY `sid` ASC";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    //将30天内的数值，按天归组，先按天清零
                    for ($day_index=0;$day_index<31;$day_index++)
                    {
                        $noise[$day_index]["sum"]=0;
                        $noise[$day_index]["counter"]=0;
                        $noise[$day_index]["average"]=0;
                    }

                    //将查询到的数值扔进去
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["noise"];

                        // 取值这30天内的第几天
                        $day_index = date("d",strtotime($row["reportdate"])-strtotime($start_date));
                        $day_index = intval($day_index);

                        $noise[$day_index]["sum"] = $noise[$day_index]["sum"] + $data;
                        $noise[$day_index]["counter"] ++;

                    }

                    //将30天内的数值，按天求算术平均值
                    for ($day_index=0;$day_index<30;$day_index++)
                    {
                        if ($noise[$day_index]["counter"]!=0)
                        {
                            $noise[$day_index]["average"]=$noise[$day_index]["sum"]/$noise[$day_index]["counter"];
                        }
                        else
                        {
                            $noise[$day_index]["average"]=0; //或者跳过这个值？
                        }

                        $date_value = date("Y-m-d",strtotime($start_date) + $day_index*24*60*60);
                        $head = $date_value;
                        $average = round($noise[$day_index]["average"],$dataformat);
                        array_push($resp["day_alarm"], $average);
                        array_push($resp["day_head"], $head);
                    }

                }
                else
                {
                    for ($i=0; $i<30; $i++) {
                        array_push($resp["day_alarm"], 0);
                        array_push($resp["day_head"], (string)$i);
                    }
                }

                break;

            default:
                $resp = "";
                break;
        }

        $mysqli->close();
        return $resp;

    }

//UI GetStaticMonitorTable Request, 获取用户聚合数据
    public function dbi_aqyc_user_dataaggregate_req($uid)
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
                $pm25 =  $row["pm25"]/1;
                $temperature = $row["temperature"]/1;
                $humidity = $row["humidity"]/1;
                $noise = $row["noise"]/1;
                $windspeed = $row["windspeed"]/1;
                $winddir = $row["winddirection"]/1;

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

    public function dbi_aqyc_alarm_handle_table_req($uid)
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

    /*********************************波峰组合秤新增处理************************************************/
    //UI GetStaticMonitorTable Request, 获取用户聚合数据
    public function dbi_bfsc_user_dataaggregate_req($uid)
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
        array_push($resp["column"], "设备编号");
        array_push($resp["column"], "设备状态");
        array_push($resp["column"], "秤_01");
        array_push($resp["column"], "秤_02");
        array_push($resp["column"], "秤_03");
        array_push($resp["column"], "秤_04");
        array_push($resp["column"], "秤_05");
        array_push($resp["column"], "秤_06");
        array_push($resp["column"], "秤_07");
        array_push($resp["column"], "秤_08");
        array_push($resp["column"], "秤_09");
        array_push($resp["column"], "秤_10");
        array_push($resp["column"], "秤_11");
        array_push($resp["column"], "秤_12");

        for($i=0; $i<count($auth_list["stat_code"]); $i++)
        {
            $one_row = array();
            $statcode = $auth_list["stat_code"][$i];

            $query_str = "SELECT * FROM `t_l3f3dm_bfsc_currentreport` WHERE `statcode` = '$statcode'";
            $result = $mysqli->query($query_str);
            //初始化返回值，确保数据库没有测试报告的情况下界面返回数据长度不报错
            $status = "休眠中";
            $w01 = 0;
            $w02 = 0;
            $w03 = 0;
            $w04 = 0;
            $w05 = 0;
            $w06 = 0;
            $w07 = 0;
            $w08 = 0;
            $w09 = 0;
            $w10 = 0;
            $w11 = 0;
            $w12 = 0;
            if (($result->num_rows) > 0)
            {
                $row = $result->fetch_array();
                $devcode = $row["devcode"];
                array_push($one_row, $statcode);
                array_push($one_row, $devcode);
                //更新设备运行状态
                $timestamp = strtotime($row["createtime"]);
                $currenttime = time();
                if ($currenttime > ($timestamp+180))  //如果最后一次测量报告距离现在已经超过3分钟
                    $status = "休眠中";
                else
                    $status = "运行中";

                $w01 = $row["weight_01"];
                $w02 = $row["weight_02"];
                $w03 = $row["weight_03"];
                $w04 = $row["weight_04"];
                $w05 = $row["weight_05"];
                $w06 = $row["weight_06"];
                $w07 = $row["weight_07"];
                $w08 = $row["weight_08"];
                $w09 = $row["weight_09"];
                $w10 = $row["weight_10"];
                $w11 = $row["weight_11"];
                $w12 = $row["weight_12"];
            }
            array_push($one_row, $status);
            array_push($one_row, $w01);
            array_push($one_row, $w02);
            array_push($one_row, $w03);
            array_push($one_row, $w04);
            array_push($one_row, $w05);
            array_push($one_row, $w06);
            array_push($one_row, $w07);
            array_push($one_row, $w08);
            array_push($one_row, $w09);
            array_push($one_row, $w10);
            array_push($one_row, $w11);
            array_push($one_row, $w12);
            array_push($resp['data'], $one_row);
        }

        $mysqli->close();
        return $resp;
    }

    /*********************************智能云锁新增处理************************************************/

    //UI GetStaticMonitorTable Request, 获取用户聚合数据
    public function dbi_fhys_user_dataaggregate_req($uid)
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
        array_push($resp["column"], "设备状态");
        array_push($resp["column"], "上次报告时间");
        array_push($resp["column"], "门锁-1状态");
        array_push($resp["column"], "门锁-2状态");
        array_push($resp["column"], "门锁-3状态");
        array_push($resp["column"], "门锁-4状态");
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
            $dev_status = "状态未知";
            $doorlock_1 = "状态未知";
            $doorlock_2 = "状态未知";
            $doorlock_3 = "状态未知";
            $doorlock_4 = "状态未知";
            $sig_level = "0";
            $batt_level = "0%";
            $vibr_alarm = "未知";
            $water_alarm = "未知";
            $smok_alarm = "未知";
            $temperature = "0";
            $humidity = "0%";

            if (($result->num_rows) > 0)
            {
                $row = $result->fetch_array();
                //更新设备运行状态
                $last_report = $row["createtime"];
                $timestamp = strtotime($last_report);
                $currenttime = time();
                if ($currenttime > ($timestamp + MFUN_HCU_FHYS_SLEEP_DURATION))  //如果最后一次测量报告距离现在已经超过休眠间隔门限
                    $dev_status = "休眠中";
                else
                    $dev_status = "运行中";

                //门锁-1运行状态
                if($row["door_1"] == HUITP_IEID_UNI_DOOR_STATE_OPEN)
                    $doorlock_1 = "正常打开";
                elseif($row["door_1"] == HUITP_IEID_UNI_DOOR_STATE_CLOSE)
                    $doorlock_1 = "正常关闭";
                elseif($row["door_1"] == HUITP_IEID_UNI_DOOR_STATE_NULL)
                    $doorlock_1 = "未安装";

                if(($row["door_1"] == HUITP_IEID_UNI_DOOR_STATE_OPEN) AND ($row["reporttype"] == HUITP_IEID_UNI_CCL_REPORT_TYPE_FAULT_EVENT))
                    $doorlock_1 = "异常打开";

                //门锁-2运行状态
                if($row["door_2"] == HUITP_IEID_UNI_DOOR_STATE_OPEN)
                    $doorlock_2 = "正常打开";
                elseif($row["door_2"] == HUITP_IEID_UNI_DOOR_STATE_CLOSE)
                    $doorlock_2 = "正常关闭";
                elseif($row["door_2"] == HUITP_IEID_UNI_DOOR_STATE_NULL)
                    $doorlock_2 = "未安装";

                if(($row["door_2"] == HUITP_IEID_UNI_DOOR_STATE_OPEN) AND ($row["reporttype"] == HUITP_IEID_UNI_CCL_REPORT_TYPE_FAULT_EVENT))
                    $doorlock_2 = "异常打开";

                //门锁-3运行状态
                if($row["door_3"] == HUITP_IEID_UNI_DOOR_STATE_OPEN)
                    $doorlock_3 = "正常打开";
                elseif($row["door_3"] == HUITP_IEID_UNI_DOOR_STATE_CLOSE)
                    $doorlock_3 = "正常关闭";
                elseif($row["door_3"] == HUITP_IEID_UNI_DOOR_STATE_NULL)
                    $doorlock_3 = "未安装";

                if(($row["door_3"] == HUITP_IEID_UNI_DOOR_STATE_OPEN) AND ($row["reporttype"] == HUITP_IEID_UNI_CCL_REPORT_TYPE_FAULT_EVENT))
                    $doorlock_3 = "异常打开";

                //门锁-4运行状态
                if($row["door_4"] == HUITP_IEID_UNI_DOOR_STATE_OPEN)
                    $doorlock_4 = "正常打开";
                elseif($row["door_4"] == HUITP_IEID_UNI_DOOR_STATE_CLOSE)
                    $doorlock_4 = "正常关闭";
                elseif($row["door_4"] == HUITP_IEID_UNI_DOOR_STATE_NULL)
                    $doorlock_4 = "未安装";

                if(($row["door_4"] == HUITP_IEID_UNI_DOOR_STATE_OPEN) AND ($row["reporttype"] == HUITP_IEID_UNI_CCL_REPORT_TYPE_FAULT_EVENT))
                    $doorlock_4 = "异常打开";


                //更新GPRS信号强度
                $sig_level = (string)$row["rssivalue"];
                if ($sig_level < MFUN_L3APL_F3DM_TH_ALARM_GPRS_LOW)
                    $gprs = "较差";
                elseif (($sig_level >= MFUN_L3APL_F3DM_TH_ALARM_GPRS_LOW) AND ($sig_level <= MFUN_L3APL_F3DM_TH_ALARM_GPRS_HIGH))
                    $gprs = "一般";
                else
                    $gprs = "良好";

                //更新电池剩余电量
                $batt_level = (string)($row["battvalue"])."%";
                //更新温度,
                $temperature = (string)($row["tempvalue"]);
                //更新湿度
                $humidity = (string)($row["humidvalue"]). "%";
                //更新震动告警状态
                if($row["shakestate"] == HUITP_IEID_UNI_SHAKE_STATE_ACTIVE)
                    $vibr_alarm = "有";
                elseif($row["shakestate"] == HUITP_IEID_UNI_SHAKE_STATE_DEACTIVE)
                    $vibr_alarm = "无";
                //更新水浸告警状态
                if($row["waterstate"] == HUITP_IEID_UNI_WATER_STATE_ACTIVE)
                    $water_alarm = "有";
                elseif($row["waterstate"] == HUITP_IEID_UNI_WATER_STATE_DEACTIVE)
                    $water_alarm = "无";
                //更新烟雾告警状态
                if($row["smokestate"] == HUITP_IEID_UNI_SMOKE_STATE_ACTIVE)
                    $smok_alarm = "有";
                elseif($row["smokestate"] == HUITP_IEID_UNI_SMOKE_STATE_DEACTIVE)
                    $smok_alarm = "无";
            }
            array_push($one_row, $dev_status);
            array_push($one_row, $last_report);
            array_push($one_row, $doorlock_1);
            array_push($one_row, $doorlock_2);
            array_push($one_row, $doorlock_3);
            array_push($one_row, $doorlock_4);
            array_push($one_row, $gprs);
            array_push($one_row, $batt_level);
            array_push($one_row, $temperature);
            array_push($one_row, $humidity);
            array_push($one_row, $vibr_alarm);
            array_push($one_row, $water_alarm);
            array_push($one_row, $smok_alarm);

            array_push($resp['data'], $one_row);
        }

        $mysqli->close();
        return $resp;
    }

    //UI DevAlarm Request, 获取当前的测量值，如果测量值超出范围，提示告警
    public function dbi_fhys_dev_currentvalue_req($statcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $vcrname = array();
        $vcrlink = array();
        $vcrlist = array();
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE `statcode` = '$statcode'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            array_push($vcrname,"RTSP");
            array_push($vcrname,"CAMCTRL");
            $rtsp = $row['videourl'];
            $cam_ctrl = $row['camctrl'];
            array_push($vcrlink,$rtsp);
            array_push($vcrlink,$cam_ctrl);
            $vcrlist = array('vcrname'=>$vcrname, 'vcraddress'=>$vcrlink);
        }

        $query_str = "SELECT * FROM `t_l3f3dm_fhys_currentreport` WHERE `statcode` = '$statcode'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            //更新温度
            $temperature = $row["tempvalue"];
            //更新湿度
            $humidity = $row["humidvalue"];
            //剩余电量
            $battlevel = $row['battvalue'];
            //RSSI
            $siglevel = $row['rssivalue'];

            $currentvalue = array();
            //更新集中器设备运行状态
            $timestamp = strtotime($row["createtime"]);
            $currenttime = time();
            if ($currenttime > ($timestamp+180))  //如果最后一次测量报告距离现在已经超过3分钟
            {
                $devstat = "休眠中";
                $alarm = "true";
            } else {
                $devstat = "运行中";
                $alarm = "false";
            }
            $temp = array(
                        'AlarmName'=> "设备状态：",
                        'AlarmEName'=> "FHYS_fibbox",
                        'AlarmValue'=> $devstat,
                        'AlarmUnit'=> "",
                        'WarningTarget'=>$alarm);
            array_push($currentvalue,$temp);

            //更新门锁-1运行状态
            if($row["door_1"] == HUITP_IEID_UNI_DOOR_STATE_OPEN){
                $doorlock_1_status = "正常打开";
                $doorlock_1_alarm = "true";
                $doorlock_1_picname = "FHYS_locko";
            }
            elseif($row["door_1"] == HUITP_IEID_UNI_DOOR_STATE_CLOSE){
                $doorlock_1_status = "正常关闭";
                $doorlock_1_alarm = "false";
                $doorlock_1_picname = "FHYS_lockc";
            }
            elseif($row["door_1"] == HUITP_IEID_UNI_DOOR_STATE_NULL){
                $doorlock_1_status = "未安装";
                $doorlock_1_alarm = "false";
                $doorlock_1_picname = "FHYS_lockc";
            }
            else{
                $doorlock_1_status = "状态未知";
                $doorlock_1_alarm = "false";
                $doorlock_1_picname = "FHYS_lockc";
            }

            if($row["door_1"] == HUITP_IEID_UNI_DOOR_STATE_OPEN AND $row["reporttype"] == HUITP_IEID_UNI_CCL_REPORT_TYPE_FAULT_EVENT){
                $doorlock_1_status = "异常打开";
                $doorlock_1_alarm = "true";
                $doorlock_1_picname = "FHYS_locko";
            }

            $temp = array(
                        'AlarmName'=> "门锁-1 状态：",
                        'AlarmEName'=> (string)$doorlock_1_picname,
                        'AlarmValue'=> (string)$doorlock_1_status,
                        'AlarmUnit'=> "",
                        'WarningTarget'=>$doorlock_1_alarm);
            array_push($currentvalue,$temp);

            //更新门锁-2运行状态
            if($row["door_2"] == HUITP_IEID_UNI_DOOR_STATE_OPEN){
                $doorlock_2_status = "正常打开";
                $doorlock_2_alarm = "true";
                $doorlock_2_picname = "FHYS_locko";
            }
            elseif($row["door_2"] == HUITP_IEID_UNI_DOOR_STATE_CLOSE){
                $doorlock_2_status = "正常关闭";
                $doorlock_2_alarm = "false";
                $doorlock_2_picname = "FHYS_lockc";
            }
            elseif($row["door_2"] == HUITP_IEID_UNI_DOOR_STATE_NULL){
                $doorlock_2_status = "未安装";
                $doorlock_2_alarm = "false";
                $doorlock_2_picname = "FHYS_lockc";
            }
            else{
                $doorlock_2_status = "状态未知";
                $doorlock_2_alarm = "false";
                $doorlock_2_picname = "FHYS_lockc";
            }

            if($row["door_2"] == HUITP_IEID_UNI_DOOR_STATE_OPEN AND $row["reporttype"] == HUITP_IEID_UNI_CCL_REPORT_TYPE_FAULT_EVENT){
                $doorlock_2_status = "异常打开";
                $doorlock_2_alarm = "true";
                $doorlock_2_picname = "FHYS_locko";
            }

            $temp = array(
                'AlarmName'=> "门锁-2 状态：",
                'AlarmEName'=> (string)$doorlock_2_picname,
                'AlarmValue'=> (string)$doorlock_2_status,
                'AlarmUnit'=> "",
                'WarningTarget'=>$doorlock_2_alarm);
            array_push($currentvalue,$temp);

            //更新GPRS信号强度
            if ($siglevel != NULL){
                if ($siglevel < MFUN_L3APL_F3DM_TH_ALARM_GPRS_LOW){
                    $gprs = "较差";
                    $alarm = "true";
                }
                elseif (($siglevel >= MFUN_L3APL_F3DM_TH_ALARM_GPRS_LOW) AND ($siglevel <= MFUN_L3APL_F3DM_TH_ALARM_GPRS_HIGH)){
                    $gprs = "一般";
                    $alarm = "false";
                }
                else{
                    $gprs = "良好";
                    $alarm = "false";
                }

                $temp = array(
                            'AlarmName'=>"GPRS信号强度：",
                            'AlarmEName'=> "FHYS_sig",
                            'AlarmValue'=>(string)$gprs,
                            'AlarmUnit'=>"",
                            'WarningTarget'=>$alarm);
            }
            else{ //防止数据缺失，保持界面显示完整性
                $temp = array(
                    'AlarmName'=>"GPRS信号强度：",
                    'AlarmEName'=> "FHYS_sig",
                    'AlarmValue'=>"NULL",
                    'AlarmUnit'=>"",
                    'WarningTarget'=>"false");
            }
            array_push($currentvalue,$temp);

            //更新电池剩余电量
            if ($battlevel != NULL){
                if ($battlevel < MFUN_L3APL_F3DM_TH_ALARM_BATT)
                    $alarm = "true";
                else
                    $alarm = "false";
                $temp = array(
                            'AlarmName'=>"剩余电量：",
                            'AlarmEName'=> "FHYS_batt",
                            'AlarmValue'=>(string)($battlevel),
                            'AlarmUnit'=>" %",
                            'WarningTarget'=>$alarm);
            }
            else{ //防止数据缺失，保持界面显示完整性
                $temp = array(
                    'AlarmName'=>"剩余电量：",
                    'AlarmEName'=> "FHYS_batt",
                    'AlarmValue'=> "NULL",
                    'AlarmUnit'=>"",
                    'WarningTarget'=>"false");
            }
            array_push($currentvalue,$temp);

            //更新温度
            if ($temperature != NULL) {
                if ($temperature > MFUN_L3APL_F3DM_TH_ALARM_TEMP)
                    $alarm = "true";
                else
                    $alarm = "false";
                $temp = array(
                    'AlarmName' => "温度：",
                    'AlarmEName' => "FHYS_temp",
                    'AlarmValue' => (string)$temperature,
                    'AlarmUnit' => " 摄氏度",
                    'WarningTarget' => $alarm );
            }
            else{ //防止数据缺失，保持界面显示完整性
                $temp = array(
                    'AlarmName' => "温度：",
                    'AlarmEName' => "FHYS_temp",
                    'AlarmValue' => "NULL",
                    'AlarmUnit' => "",
                    'WarningTarget' => "false" );
            }
            array_push($currentvalue, $temp);

            //更新湿度
            if ($humidity != NULL){
                if ($humidity > MFUN_L3APL_F3DM_TH_ALARM_HUMID)
                    $alarm = "true";
                else
                    $alarm = "false";
                $temp = array(
                    'AlarmName'=>"湿度：",
                    'AlarmEName'=> "FHYS_humi",
                    'AlarmValue'=>(string)$humidity,
                    'AlarmUnit'=>" %",
                    'WarningTarget'=>$alarm);
            }
            else{ //防止数据缺失，保持界面显示完整性
                $temp = array(
                    'AlarmName'=>"湿度：",
                    'AlarmEName'=> "FHYS_humi",
                    'AlarmValue'=>"NULL",
                    'AlarmUnit'=>"",
                    'WarningTarget'=>"false");
            }
            array_push($currentvalue,$temp);

            //更新震动告警状态
            if($row["shakestate"] == HUITP_IEID_UNI_SHAKE_STATE_ACTIVE){
                $vibralarm = "有";
                $alarm = "true";
            }
            elseif($row["shakestate"] == HUITP_IEID_UNI_SHAKE_STATE_DEACTIVE){
                $vibralarm = "无";
                $alarm = "false";
            }
            else{
                $vibralarm = "状态未知";
                $alarm = "true";
            }
            $temp = array(
                        'AlarmName'=>"震动告警：",
                        'AlarmEName'=> "FHYS_vibr",
                        'AlarmValue'=>(string)$vibralarm,
                        'AlarmUnit'=>"",
                        'WarningTarget'=>$alarm );
            array_push($currentvalue,$temp);

            //更新水浸告警状态
            if($row["waterstate"] == HUITP_IEID_UNI_WATER_STATE_ACTIVE){
                $wateralarm = "有";
                $alarm = "true";
            }
            elseif($row["waterstate"] == HUITP_IEID_UNI_WATER_STATE_DEACTIVE){
                $wateralarm = "无";
                $alarm = "false";
            }
            else{
                $wateralarm = "未知";
                $alarm = "true";
            }
            $temp = array(
                'AlarmName'=>"水浸告警：",
                'AlarmEName'=> "FHYS_water",
                'AlarmValue'=>(string)$wateralarm,
                'AlarmUnit'=>"",
                'WarningTarget'=>$alarm );
            array_push($currentvalue,$temp);

            //更新烟雾告警状态
            if($row["smokestate"] == HUITP_IEID_UNI_SMOKE_STATE_ACTIVE){
                $smokalarm = "有";
                $alarm = "true";
            }
            elseif($row["smokestate"] == HUITP_IEID_UNI_SMOKE_STATE_DEACTIVE){
                $smokalarm = "无";
                $alarm = "false";
            }
            else{
                $smokalarm = "未知";
                $alarm = "true";
            }
            $temp = array(
                'AlarmName'=>"烟雾告警：",
                'AlarmEName'=> "FHYS_smok",
                'AlarmValue'=>(string)$smokalarm,
                'AlarmUnit'=>"",
                'WarningTarget'=>$alarm );
            array_push($currentvalue,$temp);
        }
        else
            $currentvalue = "";

        $resp = array('StatCode'=>$statcode, 'alarmlist'=>$currentvalue, 'vcr'=>$vcrlist);

        $mysqli->close();
        return $resp;
    }

    public function dbi_key_event_history_process($condition)
    {
        //初始化返回值
        $history["ColumnName"] = array();
        $history['TableData'] = array();

        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if (isset($condition["ProjCode"])) $projCode = trim($condition["ProjCode"]); else  $projCode = "";
        if (isset($condition["Time"])) $duration = trim($condition["Time"]); else  $duration = "";

        array_push($history["ColumnName"], "序号");
        //array_push($history["ColumnName"], "工单号");
        array_push($history["ColumnName"], "站点名称");
        array_push($history["ColumnName"], "事件时间");
        array_push($history["ColumnName"], "事件类型");
        array_push($history["ColumnName"], "钥匙编号");
        array_push($history["ColumnName"], "钥匙名称");
        array_push($history["ColumnName"], "使用者工号");
        array_push($history["ColumnName"], "使用者姓名");



        $timestamp = time();
        $end = intval(date("Ymd", $timestamp));
        $start = $end;
        if($duration == MFUN_L3APL_F2CM_EVENT_DURATION_DAY)
            $start = intval(date("Ymd",strtotime('-1 day')));
        elseif($duration == MFUN_L3APL_F2CM_EVENT_DURATION_WEEK)
            $start = intval(date("Ymd",strtotime('-7 day')));
        elseif($duration == MFUN_L3APL_F2CM_EVENT_DURATION_MONTH)
            $start = intval(date("Ymd",strtotime('-30 day')));

        $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `p_code` = '$projCode'";
        $result = $mysqli->query($query_str);

        while ($row = $result->fetch_array()){
            $statcode = $row['statcode'];
            $statname = $row['statname'];
            $query_str = "SELECT * FROM `t_l3fxprcm_fhys_locklog` WHERE (`statcode` = '$statcode')";
            $resp = $mysqli->query($query_str);
            while($resp_row = $resp->fetch_array()){
                $sid = $resp_row['sid'];
                $woid = $resp_row['woid'];
                $keyid = $resp_row['keyid'];
                $keyname = $resp_row['keyname'];
                $keyuserid = $resp_row['keyuserid'];
                $keyusername = $resp_row['keyusername'];
                $eventtype = $resp_row['eventtype'];
                if ($eventtype == MFUN_L3APL_F2CM_EVENT_TYPE_RFID)
                    $eventtype = "RFID开锁";
                elseif ($eventtype == MFUN_L3APL_F2CM_EVENT_TYPE_BLE)
                    $eventtype = "蓝牙开锁";
                elseif ($eventtype == MFUN_L3APL_F2CM_EVENT_TYPE_USER)
                    $eventtype = "用户账号开锁";
                elseif ($eventtype == MFUN_L3APL_F2CM_EVENT_TYPE_IDCARD)
                    $eventtype = "身份证开锁";
                elseif ($eventtype == MFUN_L3APL_F2CM_EVENT_TYPE_WECHAT)
                    $eventtype = "微信开锁";
                elseif ($eventtype == MFUN_L3APL_F2CM_EVENT_TYPE_PHONE)
                    $eventtype = "电话号码开锁";
                elseif ($eventtype == MFUN_L3APL_F2CM_EVENT_TYPE_XJ)
                    $eventtype = "巡检事件";
                elseif ($eventtype == MFUN_L3APL_F2CM_EVENT_TYPE_ALARM)
                    $eventtype = "未授权开锁";
                else
                    $eventtype = "未知事件";

                $eventtime = $resp_row['createtime'];
                $dateintval = intval(date('Ymd',strtotime($eventtime)));
                $temp = array();
                if($dateintval >= $start AND $dateintval <= $end){
                    array_push($temp, $sid);
                    array_push($temp, $statname);
                    array_push($temp, $eventtime);
                    array_push($temp, $eventtype);
                    //array_push($temp, $woid);
                    array_push($temp, $keyid);
                    array_push($temp, $keyname);
                    array_push($temp, $keyuserid);
                    array_push($temp, $keyusername);

                    array_push($history['TableData'], $temp);
                }
            }
        }

        $mysqli->close();
        return $history;
    }

    public function dbi_door_open_picture_process($enventid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3fxprcm_fhys_locklog` WHERE `sid` = '$enventid' ";
        $result = $mysqli->query($query_str);

        $pic_result = array();
        if (($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $file_name = $row['picname'];
            $statcode = $row['statcode'];
            if(!empty($file_name)){
                $file_url = MFUN_HCU_SITE_PIC_FOLDER_NAME.$statcode.'/upload/'.$file_name;
                $pic_result = array(
                    'ifpicture' => 'true',
                    'picture' => $file_url
                );
            }
            else{
                $pic_result = array(
                    'ifpicture' => 'false',
                    'picture' => ''
                );
            }
        }

        $mysqli->close();
        return $pic_result;
    }

    public function dbi_point_install_picture_process($statcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l2snr_picturedata` WHERE `statcode` = '$statcode' ";
        $result = $mysqli->query($query_str);

        $pic_list = array();
        while($row = $result->fetch_array())
        {
            $file_name = $row['filename'];
            $file_url = MFUN_HCU_SITE_PIC_FOLDER_NAME.$statcode.'/install/'.$file_name;
            $temp = array(
                'name' => $file_name,
                'url' => $file_url
            );
            array_push($pic_list, $temp);
        }

        $mysqli->close();
        return $pic_list;
    }

}

?>