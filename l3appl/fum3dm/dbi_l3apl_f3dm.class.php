<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/20
 * Time: 23:00
 */
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
-- 表的结构 `t_l3f3dm_sitemapping`
--

CREATE TABLE IF NOT EXISTS `t_l3f3dm_sitemapping` (
`sid` int(4) NOT NULL AUTO_INCREMENT,
  `statcode` char(20) NOT NULL,
  `p_code` char(20) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `t_l3f3dm_sitemapping`
--

INSERT INTO `t_l3f3dm_sitemapping` (`sid`, `statcode`, `p_code`) VALUES
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

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f3dm_sum_currentreport`
--

CREATE TABLE IF NOT EXISTS `t_l3f3dm_sum_currentreport` (
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
-- 转存表中的数据 `t_l3f3dm_sum_currentreport`
--

INSERT INTO `t_l3f3dm_sum_currentreport` (`sid`, `deviceid`, `statcode`, `createtime`, `emcvalue`, `pm01`, `pm25`, `pm10`, `noise`, `windspeed`, `winddirection`, `temperature`, `humidity`, `rain`, `airpressure`) VALUES
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
        $result = $mysqli->query("SELECT * FROM `t_l3f3dm_siteinfo` WHERE `devcode` = '$deviceid'");
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
                $result = $mysqli->query("SELECT * FROM `t_l3f3dm_sum_currentreport` WHERE (`deviceid` = '$deviceid' ");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_l3f3dm_sum_currentreport` SET  `airpressure` = '$airpressure', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_l3f3dm_sum_currentreport` (deviceid,statcode,createtime,airpressure) VALUES ('$deviceid','$statcode','$currenttime','$airpressure')");
                }
                break;
            case "T_emcdata":
                $emc = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_l3f3dm_sum_currentreport` WHERE (`deviceid` = '$deviceid')");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_l3f3dm_sum_currentreport` SET  `emcvalue` = '$emc', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_l3f3dm_sum_currentreport` (deviceid,statcode,createtime,emcvalue) VALUES ('$deviceid','$statcode','$currenttime','$emc')");
                }
                break;
            case "T_humidity":
                $humidity = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_l3f3dm_sum_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_l3f3dm_sum_currentreport` SET  `humidity` = '$humidity', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_l3f3dm_sum_currentreport` (deviceid,statcode,createtime,humidity) VALUES ('$deviceid','$statcode','$currenttime','$humidity')");
                }
                break;
            case "T_noise":
                $noise = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_l3f3dm_sum_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_l3f3dm_sum_currentreport` SET  `noise` = '$noise', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_l3f3dm_sum_currentreport` (deviceid,statcode,createtime,noise) VALUES ('$deviceid','$statcode','$currenttime','$noise')");
                }
                break;
            case "t_l2snr_pm25data";
                $pm01 = $data["pm01"];
                $pm25 = $data["pm25"];
                $pm10 = $data["pm10"];

                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_l3f3dm_sum_currentreport` WHERE (`deviceid` = '$deviceid')");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_l3f3dm_sum_currentreport` SET   `pm01` = '$pm01',`pm25` = '$pm25',`pm10` = '$pm10',`createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_l3f3dm_sum_currentreport` (deviceid,statcode,createtime,pm01,pm25,pm10) VALUES ('$deviceid','$statcode','$currenttime','$pm01','$pm25','$pm10')");
                }
                break;
            case "T_rain":
                $rain = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_l3f3dm_sum_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_l3f3dm_sum_currentreport` SET  `rain` = '$rain', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_l3f3dm_sum_currentreport` (deviceid,statcode,createtime,rain) VALUES ('$deviceid','$statcode','$currenttime','$rain')");
                }
                break;
            case "T_temperature":
                $temperature = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_l3f3dm_sum_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_l3f3dm_sum_currentreport` SET  `temperature` = '$temperature', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_l3f3dm_sum_currentreport` (deviceid,statcode,createtime,temperature) VALUES ('$deviceid','$statcode','$currenttime','$temperature')");
                }
                break;
            case "T_winddirection":
                $winddirection = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_l3f3dm_sum_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_l3f3dm_sum_currentreport` SET  `winddirection` = '$winddirection', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_l3f3dm_sum_currentreport` (deviceid,statcode,createtime,winddirection) VALUES ('$deviceid','$statcode','$currenttime','$winddirection')");
                }
                break;
            case "t_l2snr_windspd":
                $windspeed = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_l3f3dm_sum_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_l3f3dm_sum_currentreport` SET  `windspeed` = '$windspeed', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_l3f3dm_sum_currentreport` (deviceid,statcode,createtime,windspeed) VALUES ('$deviceid','$statcode','$currenttime','$windspeed')");
                }
                break;
            default:
                $result = "COMMON_DB: invaild data type";
                break;
        }

        $mysqli->close();
        return $result;
    }

    //UI ProjDel request，项目信息删除
    public function dbi_projinfo_delete($pcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "DELETE FROM `t_l3f2cm_projinfo` WHERE `p_code` = '$pcode'";  //删除项目信息表
        $result1 = $mysqli->query($query_str);

        $query_str = "DELETE FROM `t_l3f2cm_sitemapping` WHERE `p_code` = '$pcode'";  //删除项目和监测点的映射关系
        $result2 = $mysqli->query($query_str);

        $query_str = "UPDATE `t_l3f3dm_siteinfo` SET `p_code` = '' WHERE (`p_code` = '$pcode' )"; //删除监测点表中的对应项目号
        $result3 = $mysqli->query($query_str);

        $result = $result1 and $result2 and $result3;

        $mysqli->close();
        return $result;
    }

    /**********************************************************************************************************************
     *                                          监测点及HCU设备相关操作DB API                                               *
     *********************************************************************************************************************/
    //查询用户授权的stat_code和proj_code list
    private function dbi_user_statproj_inqury($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        //查询该用户授权的项目和项目组列表
        $query_str = "SELECT `auth_code` FROM `t_l3f1sym_authlist` WHERE `uid` = '$uid'";
        $result = $mysqli->query($query_str);
        $p_list = array();
        $pg_list = array();
        while($row = $result->fetch_array())
        {
            $temp = $row["auth_code"];
            $fromat = substr($temp, 0, MFUN_CODE_FORMAT_LEN);
            if($fromat == MFUN_PROJ_CODE_PREFIX)
                array_push($p_list,$temp);
            elseif ($fromat == MFUN_PG_CODE_PREFIX)
                array_push($pg_list,$temp);
        }

        //把授权的项目组列表里对应的项目号也取出来追加到项目列表，获得该用户授权的完整项目列表
        for($i=0; $i<count($pg_list); $i++)
        {
            $query_str = "SELECT `p_code` FROM `t_l3f3dm_sitemapping` WHERE `pg_code` = '$pg_list[$i]'";
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
            $query_str = "SELECT `statcode` FROM `t_l3f3dm_sitemapping` WHERE `p_code` = '$p_list[$i]'";
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



    //查询监控点表中记录总数
    public function dbi_all_sitenum_inqury()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE 1";
        $result = $mysqli->query($query_str);
        $total = $result->num_rows;

        $mysqli->close();
        return $total;
    }

    //UI ProjPoint request,查询所有项目监测点列表
    public function dbi_all_sitelist_req()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE 1 ";
        $result = $mysqli->query($query_str);

        $sitelist = array();
        while($row = $result->fetch_array())
        {
            $temp = array(
                'id' => $row['statcode'],
                'name' => $row['name'],
                'ProjCode' => $row['p_code']
            );
            array_push($sitelist, $temp);
        }

        $mysqli->close();
        return $sitelist;
    }

    //UI ProjPoint request,查询项目下面包含的监测点列表
    public function dbi_proj_sitelist_req($p_code)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `p_code` = '$p_code' ";
        $result = $mysqli->query($query_str);

        $sitelist = array();
        while($row = $result->fetch_array())
        {
            $temp = array(
                'id' => $row['statcode'],
                'name' => $row['name'],
                'ProjCode' => $p_code
            );
            array_push($sitelist, $temp);
        }

        $mysqli->close();
        return $sitelist;
    }

    //UI ProjTable request, 获取全部监测点列表信息
    public function dbi_all_sitetable_req($start, $total)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` limit $start, $total";
        $result = $mysqli->query($query_str);

        $sitetable = array();
        while($row = $result->fetch_array())
        {
            $pcode = $row['p_code'];
            $statcode = $row['statcode'];
            $statname = $row['name'];
            $longitude = $row['longitude'];
            $latitude = $row['latitude'];

            $query_str = "SELECT * FROM `t_l3f2cm_projinfo` WHERE `p_code` = '$pcode'";      //查询监测点对应的项目号
            $resp = $mysqli->query($query_str);
            if (($resp->num_rows)>0) {
                $info = $resp->fetch_array();
                $temp = array(
                    'StatCode' => $statcode,
                    'StatName' => $statname,
                    'ProjCode' => $info['p_code'],
                    'ChargeMan' => $info['chargeman'],
                    'Telephone' => $info['telephone'],
                    'Longitude' => $longitude,
                    'Latitude' => $latitude,
                    'Department' => $info['department'],
                    'Address' => $info['address'],
                    'Country' => $info['country'],
                    'Street' => $info['street'],
                    'Square' => $info['square'],
                    'ProStartTime' => $info['starttime'],
                    'Stage' => $info['stage']
                );
                array_push($sitetable, $temp);
            }
        }

        $mysqli->close();
        return $sitetable;
    }


    //UI PointNew & PointMod request,添加监测点信息或者修改监测点信息
    public function dbi_siteinfo_update($siteinfo)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");
        $mysqli->query("SET NAMES utf8");

        $statcode = $siteinfo["StatCode"];
        $statname = $siteinfo["StatName"];
        $pcode = $siteinfo["ProjCode"];
        $chargeman = $siteinfo["ChargeMan"];
        $telephone = $siteinfo["Telephone"];
        $longitude = $siteinfo["Longitude"];
        $latitude = $siteinfo["Latitude"];
        $department = $siteinfo["Department"];
        $addr = $siteinfo["Address"];
        $country = $siteinfo["Country"];
        $street = $siteinfo["Street"];
        $square = $siteinfo["Square"];
        $starttime = $siteinfo["ProStartTime"];
        $stage = $siteinfo["Stage"];

        $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statcode'";
        $result = $mysqli->query($query_str);

        if (($result->num_rows)>0) //重复，则覆盖
        {
            $query_str = "UPDATE `t_l3f3dm_siteinfo` SET `name` = '$statname',`p_code` = '$pcode',`starttime` = '$starttime',
                          `latitude` = '$latitude',`longitude` = '$longitude' WHERE (`statcode` = '$statcode' )";
            $result1 = $mysqli->query($query_str);
        }
        else //不存在，新增
        {
            $query_str = "INSERT INTO `t_l3f3dm_siteinfo` (statcode,name,p_code,starttime,latitude,longitude)
                                  VALUES ('$statcode','$statname','$pcode','$starttime','$latitude', '$longitude')";

            $result1 = $mysqli->query($query_str);
        }

        $query_str = "UPDATE `t_l3f2cm_projinfo` SET `country` = '$country',`street` = '$street',`square` = '$square' WHERE (`p_code` = '$pcode' )";
        $result2 = $mysqli->query($query_str);

        $result = $result1 AND $result2;
        $mysqli->close();
        return $result;
    }

    //UI DevTable request, 获取全部HCU设备列表信息
    public function dbi_all_hcutable_req($start, $total)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_l2sdk_iothcu_hcudevice` limit $start, $total";
        $result = $mysqli->query($query_str);

        $hcutable = array();
        while($row = $result->fetch_array())
        {
            $devcode = $row['devcode'];
            $statcode = $row['statcode'];
            $macaddr = $row['macaddr'];
            $ipaddr = $row['ipaddr'];
            $devstatus = $row['switch'];
            $url = $row['videourl'];
            if ($devstatus == "1")
                $devstatus = "true";
            elseif($devstatus == "0")
                $devstatus = "false";

            $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statcode'";      //查询HCU设备对应监测点号
            $resp = $mysqli->query($query_str);
            if (($resp->num_rows)>0) {
                $info = $resp->fetch_array();
                $temp = array(
                    'DevCode' => $devcode,
                    'StatCode' => $statcode,
                    'ProjCode' => $info['p_code'],
                    'StartTime' => $info['starttime'],
                    'PreEndTime' => "",  //需要确认
                    'EndTime' => "",
                    'DevStatus' => $devstatus,
                    'VideoURL' => $url,
                    'MAC' => $macaddr,
                    'IP' => $ipaddr
                );
                array_push($hcutable, $temp);
            }
        }

        $mysqli->close();
        return $hcutable;
    }

    //UI PointDev Request，查询监测点下面HCU列表
    public function dbi_site_devlist_req($statcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statcode' ";
        $result = $mysqli->query($query_str);

        $devlist = array();
        while($row = $result->fetch_array())
        {
            $temp = array(
                'id' => $row['statcode'],
                'name' => $row['devcode']
            );
            array_push($devlist, $temp);
        }

        $mysqli->close();
        return $devlist;
    }




    //UI PointDel request，删除一个监测点
    public function dbi_siteinfo_delete($statcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "DELETE FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statcode'";  //删除监测点信息表
        $result1 = $mysqli->query($query_str);

        $query_str = "DELETE FROM `t_l3f3dm_sitemapping` WHERE `statcode` = '$statcode'";  //删除项目和监测点的映射关系
        $result2 = $mysqli->query($query_str);

        $query_str = "UPDATE `t_l2sdk_iothcu_hcudevice` SET `statcode` = '' WHERE (`statcode` = '$statcode' )"; //删除HCU设备表中的对应监测点号
        $result3 = $mysqli->query($query_str);

        $result = $result1 and $result2 and $result3;

        $mysqli->close();
        return $result;
    }

    //ZJL: 这个东西同时连接两个数据库，需要分开
    //UI DevDel request，删除一个监测点
    public function dbi_deviceinfo_delete($devcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        $query_str = "DELETE FROM `t_l2sdk_iothcu_hcudevice` WHERE `devcode` = '$devcode'";  //删除HCU device信息表
        $result1 = $mysqli->query($query_str);

        $query_str = "UPDATE `t_l3f3dm_siteinfo` SET `devcode` = '' WHERE (`devcode` = '$devcode' )"; //删除监测点信息表中的HCU信息
        $result2 = $mysqli->query($query_str);

        $result = $result1 and $result2;

        $mysqli->close();
        return $result;
    }

    /**********************************************************************************************************************
     *                                                 地图显示相关操作DB API                                               *
     *********************************************************************************************************************/
    //UI MonitorList request, 获取该用户地图显示的所有监测点信息
    public function dbi_map_sitetinfo_req($uid)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_l3f2cm_projinfo` WHERE 1";
        $result = $mysqli->query($query_str);

        $sitelist = array();
        while($row = $result->fetch_array())
        {
            $pcode = $row['p_code'];
            $chargeman = $row['chargeman'];
            $phone = $row['telephone'];
            $department = $row['department'];
            $addr = $row['address'];
            $country = $row['country'];
            $street = $row['street'];
            $square = $row['square'];
            $stage = $row['stage'];

            $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `p_code` = '$pcode'";      //查询监测点对应的项目号
            $resp = $mysqli->query($query_str);
            if (($resp->num_rows)>0) {
                $info = $resp->fetch_array();

                $latitude = ($info['latitude'])/1000000;  //百度地图经纬度转换
                $longitude =  ($info['longitude'])/1000000;

                $temp = array(
                    'StatCode' => $info['statcode'],
                    'StatName' => $info['name'],
                    'ChargeMan' => $chargeman,
                    'Telephone' => $phone,
                    'Department' => $department,
                    'Address' => $addr,
                    'Country' => $country,
                    'Street' => $street,
                    'Square' => $square,
                    'Flag_la' => $info['flag_la'],
                    'Latitude' => $latitude,
                    'Flag_lo' =>  $info['flag_lo'],
                    'Longitude' => $longitude,
                    'ProStartTime' => $info['starttime'],
                    'Stage' => $stage
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
    public function dbi_dev_currentvalue_req($statcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_l3f3dm_currentreport` WHERE `statcode` = '$statcode'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0)
        {
            $row = $result->fetch_array();  //暂时先这样处理，此处测量值计算要根据上报精度进行修改。。。。。
            $noise = $row['noise']/100;
            $winddir = $row['winddirection']/10;
            $humidity = $row['humidity']/10;
            $temperature = $row['temperature']/10;
            $pm25 = $row['pm25']/10;
            $windspeed = $row['windspeed']/10;

            $currentvalue = array();
            if ($noise != NULL){
                if ($noise > MFUN_TH_ALARM_NOISE)
                    $alarm = "true";
                else
                    $alarm = "false";

                $temp = array(
                    'AlarmName'=>"噪声",
                    'AlarmEName'=> "Noise",
                    'AlarmValue'=>(string)$noise,
                    'AlarmUnit'=>" 分贝",
                    'WarningTarget'=>$alarm
                );
                array_push($currentvalue,$temp);
            }

            if ($winddir != NULL){
                $temp = array(
                    'AlarmName'=>"风向",
                    'AlarmEName'=> "WD",
                    'AlarmValue'=>(string)$winddir,
                    'AlarmUnit'=>" 度",
                    'WarningTarget'=>"false"
                );
                array_push($currentvalue,$temp);
            }

            if ($humidity != NULL){
                if ($humidity > MFUN_TH_ALARM_HUMIDITY)
                    $alarm = "true";
                else
                    $alarm = "false";
                $temp = array(
                    'AlarmName'=>"湿度",
                    'AlarmEName'=> "Wet",
                    'AlarmValue'=>(string)$humidity,
                    'AlarmUnit'=>" %",
                    'WarningTarget'=>$alarm
                );
                array_push($currentvalue,$temp);
            }

            if ($temperature != NULL){
                if ($temperature > MFUN_TH_ALARM_TEMPERATURE)
                    $alarm = "true";
                else
                    $alarm = "false";
                $temp = array(
                    'AlarmName'=>"温度",
                    'AlarmEName'=> "Temperature",
                    'AlarmValue'=>(string)$temperature,
                    'AlarmUnit'=>" 摄氏度",
                    'WarningTarget'=>$alarm
                );
                array_push($currentvalue,$temp);
            }

            if ($pm25 != NULL){
                if ($pm25 > MFUN_TH_ALARM_PM25)
                    $alarm = "true";
                else
                    $alarm = "false";
                $temp = array(
                    'AlarmName'=>"细颗粒物",
                    'AlarmEName'=> "PM",
                    'AlarmValue'=>(string)$pm25,
                    'AlarmUnit'=>" 毫克/立方米",
                    'WarningTarget'=>$alarm
                );
                array_push($currentvalue,$temp);
            }

            if ($windspeed != NULL){
                if ($windspeed > MFUN_TH_ALARM_WINDSPEED)
                    $alarm = "true";
                else
                    $alarm = "false";
                $temp = array(
                    'AlarmName'=>"风速",
                    'AlarmEName'=> "WS",
                    'AlarmValue'=>(string)$windspeed,
                    'AlarmUnit'=>" 公里/小时",
                    'WarningTarget'=>$alarm
                );
                array_push($currentvalue,$temp);
            }
        }
        else
            $currentvalue = "";

        $mysqli->close();
        return $currentvalue;
    }

    //UI AlarmQuery Request, 获取告警历史数据
    public function dbi_dev_alarmhistory_req($statcode, $date, $alarm_type)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        //根据监测点号查找对应的设备号
        $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statcode'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows) > 0) {
            $row = $result->fetch_array();
            $devcode = $row['devcode'];
        }

        switch($alarm_type) {
            case MFUN_S_TYPE_PM:
                $resp["alarm_name"] = "细颗粒物";
                $resp["alarm_unit"] = "毫克/立方米";
                $resp["warning"] = MFUN_TH_ALARM_PM25;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                $query_str = "SELECT * FROM `t_l2snr_pm25data` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date'";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["pm25"]/10;
                        $huorminindex = $row["hourminindex"];
                        $hour = floor($huorminindex/60) ;
                        $min = $huorminindex - $hour*60;
                        $head = $hour.":".$min;
                        array_push($resp["minute_alarm"],$data);
                        array_push($resp["minute_head"],$head);
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

            case MFUN_S_TYPE_WINDSPEED:
                $resp["alarm_name"] = "风速";
                $resp["alarm_unit"] = "千米/小时";
                $resp["warning"] = MFUN_TH_ALARM_WINDSPEED;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                $query_str = "SELECT * FROM `t_l2snr_windspd` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date'";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["windspeed"]/10;
                        $huorminindex = $row["hourminindex"];
                        $hour = floor($huorminindex/60) ;
                        $min = $huorminindex - $hour*60;
                        $head = $hour.":".$min;
                        array_push($resp["minute_alarm"],$data);
                        array_push($resp["minute_head"],$head);
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

            case MFUN_S_TYPE_WINDDIR:
                $resp["alarm_name"] = "风向";
                $resp["alarm_unit"] = "度";
                $resp["warning"] = MFUN_TH_ALARM_WINDDIR;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                $query_str = "SELECT * FROM `t_l2snr_winddir` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date'";
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

            case MFUN_S_TYPE_EMC:
                $resp["alarm_name"] = "电磁辐射";
                $resp["alarm_unit"] = "毫瓦/平方毫米";
                $resp["warning"] = MFUN_TH_ALARM_EMC;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                $query_str = "SELECT * FROM `t_l2snr_emcdata` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date'";
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

            case MFUN_S_TYPE_TEMPERATURE:
                $resp["alarm_name"] = "温度";
                $resp["alarm_unit"] = "摄氏度";
                $resp["warning"] = MFUN_TH_ALARM_TEMPERATURE;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                $query_str = "SELECT * FROM `t_l2snr_tempdata` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date'";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["temperature"]/10;
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

            case MFUN_S_TYPE_HUMIDITY:
                $resp["alarm_name"] = "湿度";
                $resp["alarm_unit"] = "%";
                $resp["warning"] = MFUN_TH_ALARM_HUMIDITY;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                $query_str = "SELECT * FROM `t_l2snr_humiddata` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date'";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["humidity"]/10;
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

            case MFUN_S_TYPE_NOISE:
                $resp["alarm_name"] = "噪声";
                $resp["alarm_unit"] = "分贝";
                $resp["warning"] = MFUN_TH_ALARM_NOISE;

                $resp["minute_alarm"] = array();
                $resp["minute_head"] = array();
                $resp["hour_alarm"] = array();
                $resp["hour_head"] = array();
                $resp["day_alarm"] = array();
                $resp["day_head"] = array();

                $query_str = "SELECT * FROM `t_l2snr_noisedata` WHERE `deviceid` = '$devcode' AND `reportdate` = '$date'";
                $result = $mysqli->query($query_str);
                if ($result->num_rows > 0)
                {
                    for($i=0; $i<$result->num_rows; $i++)
                    {
                        $row = $result->fetch_array();
                        $data = $row["noise"]/100;
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

            default:
                $resp = "";
                break;
        }

        $mysqli->close();
        return $resp;

    }

//UI GetStaticMonitorTable Request, 获取用户聚合数据
    public function dbi_user_dataaggregate_req($uid)
    {
        //初始化返回值
        $resp["column"] = array();
        $resp['data'] = array();

        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $auth_list["stat_code"] = array();
        $auth_list["p_code"] = array();
        $auth_list = $this->dbi_user_statproj_inqury($uid);

        array_push($resp["column"], "监测点编号");
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
            $query_str = "SELECT * FROM `t_l3f2cm_projinfo` WHERE `p_code` = '$pcode'";
            $result = $mysqli->query($query_str);
            if (($result->num_rows) > 0)
            {
                $row = $result->fetch_array();
                array_push($one_row, $statcode);
                array_push($one_row, $row["p_name"]);
                array_push($one_row, $row["country"]);
                array_push($one_row, $row["address"]);
                array_push($one_row, $row["chargeman"]);
                array_push($one_row, $row["telephone"]);
            }
            $query_str = "SELECT * FROM `t_l3f3dm_currentreport` WHERE `statcode` = '$statcode'";
            $result = $mysqli->query($query_str);
            if (($result->num_rows) > 0)
            {
                $row = $result->fetch_array();
                array_push($one_row, $row["pm25"]/10);
                array_push($one_row, $row["temperature"]/10);
                array_push($one_row, $row["humidity"]/10);
                array_push($one_row, $row["noise"]/100);
                array_push($one_row, $row["windspeed"]/10);
                array_push($one_row, $row["winddirection"]);

                $timestamp = strtotime($row["createtime"]);
                $currenttime = time();
                if ($currenttime > ($timestamp+180))  //如果最后一次测量报告距离现在已经超过3分钟
                    array_push($one_row, "停止");
                else
                    array_push($one_row, "运行");

            }

            /*
                        $query_str = "SELECT * FROM `t_hcudevice` WHERE `statcode` = '$statcode'";
                        $result = $mysqli->query($query_str);
                        if (($result->num_rows) > 0) {
                            $row = $result->fetch_array();
                            if ($row["switch"] == "on")
                                array_push($one_row, "运行");
                            elseif ($row["switch"] == "off")
                                array_push($one_row, "停止");
                        }
            */

            array_push($resp['data'], $one_row);
        }

        $mysqli->close();
        return $resp;
    }


}

?>