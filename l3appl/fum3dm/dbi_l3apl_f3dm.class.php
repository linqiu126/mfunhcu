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
-- 表的结构 `t_f3dm_siteinfo`
--

CREATE TABLE IF NOT EXISTS `t_f3dm_siteinfo` (
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
-- 转存表中的数据 `t_f3dm_siteinfo`
--

INSERT INTO `t_f3dm_siteinfo` (`statcode`, `name`, `devcode`, `p_code`, `starttime`, `altitude`, `flag_la`, `latitude`, `flag_lo`, `longitude`) VALUES
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
-- 表的结构 `t_f3dm_sitemapping`
--

CREATE TABLE IF NOT EXISTS `t_f3dm_sitemapping` (
`sid` int(4) NOT NULL AUTO_INCREMENT,
  `statcode` char(20) NOT NULL,
  `p_code` char(20) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `t_f3dm_sitemapping`
--

INSERT INTO `t_f3dm_sitemapping` (`sid`, `statcode`, `p_code`) VALUES
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
-- 表的结构 `t_f3dm_sum_currentreport`
--

CREATE TABLE IF NOT EXISTS `t_f3dm_sum_currentreport` (
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
-- 转存表中的数据 `t_f3dm_sum_currentreport`
--

INSERT INTO `t_f3dm_sum_currentreport` (`sid`, `deviceid`, `statcode`, `createtime`, `emcvalue`, `pm01`, `pm25`, `pm10`, `noise`, `windspeed`, `winddirection`, `temperature`, `humidity`, `rain`, `airpressure`) VALUES
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
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L3APP, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_f3dm_siteinfo` WHERE `devcode` = '$deviceid'");
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
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L4AQYC, MFUN_CLOUD_DBPORT);
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
                $result = $mysqli->query("SELECT * FROM `t_f3dm_sum_currentreport` WHERE (`deviceid` = '$deviceid' ");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_f3dm_sum_currentreport` SET  `airpressure` = '$airpressure', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_f3dm_sum_currentreport` (deviceid,statcode,createtime,airpressure) VALUES ('$deviceid','$statcode','$currenttime','$airpressure')");
                }
                break;
            case "T_emcdata":
                $emc = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_f3dm_sum_currentreport` WHERE (`deviceid` = '$deviceid')");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_f3dm_sum_currentreport` SET  `emcvalue` = '$emc', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_f3dm_sum_currentreport` (deviceid,statcode,createtime,emcvalue) VALUES ('$deviceid','$statcode','$currenttime','$emc')");
                }
                break;
            case "T_humidity":
                $humidity = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_f3dm_sum_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_f3dm_sum_currentreport` SET  `humidity` = '$humidity', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_f3dm_sum_currentreport` (deviceid,statcode,createtime,humidity) VALUES ('$deviceid','$statcode','$currenttime','$humidity')");
                }
                break;
            case "T_noise":
                $noise = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_f3dm_sum_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_f3dm_sum_currentreport` SET  `noise` = '$noise', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_f3dm_sum_currentreport` (deviceid,statcode,createtime,noise) VALUES ('$deviceid','$statcode','$currenttime','$noise')");
                }
                break;
            case "T_pmdata";
                $pm01 = $data["pm01"];
                $pm25 = $data["pm25"];
                $pm10 = $data["pm10"];

                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_f3dm_sum_currentreport` WHERE (`deviceid` = '$deviceid')");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_f3dm_sum_currentreport` SET   `pm01` = '$pm01',`pm25` = '$pm25',`pm10` = '$pm10',`createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_f3dm_sum_currentreport` (deviceid,statcode,createtime,pm01,pm25,pm10) VALUES ('$deviceid','$statcode','$currenttime','$pm01','$pm25','$pm10')");
                }
                break;
            case "T_rain":
                $rain = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_f3dm_sum_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_f3dm_sum_currentreport` SET  `rain` = '$rain', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_f3dm_sum_currentreport` (deviceid,statcode,createtime,rain) VALUES ('$deviceid','$statcode','$currenttime','$rain')");
                }
                break;
            case "T_temperature":
                $temperature = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_f3dm_sum_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_f3dm_sum_currentreport` SET  `temperature` = '$temperature', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_f3dm_sum_currentreport` (deviceid,statcode,createtime,temperature) VALUES ('$deviceid','$statcode','$currenttime','$temperature')");
                }
                break;
            case "T_winddirection":
                $winddirection = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_f3dm_sum_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_f3dm_sum_currentreport` SET  `winddirection` = '$winddirection', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_f3dm_sum_currentreport` (deviceid,statcode,createtime,winddirection) VALUES ('$deviceid','$statcode','$currenttime','$winddirection')");
                }
                break;
            case "T_windspeed":
                $windspeed = $data["value"];
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $result = $mysqli->query("SELECT * FROM `t_f3dm_sum_currentreport` WHERE (`deviceid` = '$deviceid' )");
                if (($result->num_rows)>0) {
                    $result = $mysqli->query("UPDATE `t_f3dm_sum_currentreport` SET  `windspeed` = '$windspeed', `createtime` = '$currenttime' WHERE (`deviceid` = '$deviceid')");
                }
                else {
                    $result = $mysqli->query("INSERT INTO `t_f3dm_sum_currentreport` (deviceid,statcode,createtime,windspeed) VALUES ('$deviceid','$statcode','$currenttime','$windspeed')");
                }
                break;
            default:
                $result = "COMMON_DB: invaild data type";
                break;
        }

        $mysqli->close();
        return $result;
    }
    
}

?>