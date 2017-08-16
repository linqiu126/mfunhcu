<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/7/1
 * Time: 13:41
 */
//include_once "../../l1comvm/vmlayer.php";

/*
-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_dataformat`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_dataformat` (
  `deviceid` char(50) NOT NULL,
  `f_airpressure` int(1) DEFAULT NULL,
  `f_emcdata` int(1) DEFAULT NULL,
  `f_humidity` int(1) DEFAULT NULL,
  `f_noise` int(1) DEFAULT NULL,
  `f_pmdata` int(1) DEFAULT NULL,
  `f_rain` int(1) DEFAULT NULL,
  `f_temperature` int(1) DEFAULT NULL,
  `f_winddirection` int(1) DEFAULT NULL,
  `f_windspeed` int(1) DEFAULT NULL,
  PRIMARY KEY (`deviceid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_l2snr_dataformat`
--

INSERT INTO `t_l2snr_dataformat` (`deviceid`, `f_airpressure`, `f_emcdata`, `f_humidity`, `f_noise`, `f_pmdata`, `f_rain`, `f_temperature`, `f_winddirection`, `f_windspeed`) VALUES
('HCU_SH_0301', 0, 1, 1, 2, 1, 0, 1, 1, 1),
('HCU_SH_0303', NULL, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL),
('HCU_SH_0302', NULL, 1, 1, NULL, NULL, NULL, 1, NULL, NULL),
('HCU_SH_0305', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('HCU_SH_0304', NULL, 1, 1, NULL, NULL, NULL, 1, NULL, NULL),
('HCU_SH_0309', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);


-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_sensortype`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_sensortype` (
  `id` char(6) NOT NULL,
  `name` char(10) NOT NULL,
  `model` char(20) NOT NULL,
  `vendor` char(20) NOT NULL,
  `modbus` int(1) DEFAULT NULL COMMENT 'MODBUS地址',
  `period` int(2) DEFAULT NULL COMMENT '测量周期，单位秒',
  `samples` int(2) DEFAULT NULL COMMENT '采样间隔，单位秒',
  `times` int(2) DEFAULT NULL COMMENT '测量次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_l2snr_sensortype`
--

INSERT INTO `t_l2snr_sensortype` (`id`, `name`, `model`, `vendor`, `modbus`, `period`, `samples`, `times`) VALUES
('S_0001', '细颗粒物', 'PM-100', '爱启公司', 1, 100, 500, 200),
('S_0002', '风速', 'WS-100', '爱启公司', 2, NULL, NULL, NULL),
('S_0003', '风向', 'WD-100', '爱启公司', 3, NULL, NULL, NULL),
('S_0005', '电磁辐射', 'EMC-100', '小慧智能科技', 5, NULL, NULL, NULL),
('S_0006', '温度', 'TE-100', '小慧智能科技', 6, NULL, NULL, NULL),
('S_0007', '湿度', 'TH-100', '小慧智能科技', 6, NULL, NULL, NULL),
('S_000A', '噪声', 'NO-100', '小慧智能科技', 10, NULL, NULL, NULL);


-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_sensortype`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_sensortype` (
  `id` char(6) NOT NULL,
  `name` char(10) NOT NULL,
  `model` char(20) NOT NULL,
  `vendor` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_hourreport`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_hourreport` (
`sid` int(4) NOT NULL AUTO_INCREMENT,
  `devcode` char(20) NOT NULL,
  `statcode` char(20) DEFAULT NULL,
  `reportdate` date NOT NULL,
  `hourindex` int(1) NOT NULL,
  `emcvalue` int(4) DEFAULT NULL,
  `pm01` int(4) DEFAULT NULL,
  `pm25` int(4) DEFAULT NULL,
  `pm10` int(4) DEFAULT NULL,
  `noise` int(4) DEFAULT NULL,
  `windspeed` int(4) DEFAULT NULL,
  `winddirection` int(4) DEFAULT NULL,
  `rain` int(4) DEFAULT NULL,
  `temperature` int(4) DEFAULT NULL,
  `humidity` int(4) DEFAULT NULL,
  `airpressure` int(4) DEFAULT NULL,
  `datastatus` char(10) DEFAULT NULL,
  `validdatanum` int(1) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `t_l2snr_hourreport`
--

INSERT INTO `t_l2snr_hourreport` (`sid`, `devcode`, `statcode`, `reportdate`, `hourindex`, `emcvalue`, `pm01`, `pm25`, `pm10`, `noise`, `windspeed`, `winddirection`, `rain`, `temperature`, `humidity`, `airpressure`, `datastatus`, `validdatanum`) VALUES
(1, '', NULL, '0000-00-00', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '', NULL, '0000-00-00', 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '', NULL, '0000-00-00', 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '', NULL, '0000-00-00', 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, '', NULL, '0000-00-00', 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, '', NULL, '0000-00-00', 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, '', NULL, '0000-00-00', 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, '', NULL, '0000-00-00', 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, '', NULL, '0000-00-00', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '', NULL, '0000-00-00', 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, '', NULL, '0000-00-00', 0, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, '', NULL, '0000-00-00', 0, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, '', NULL, '0000-00-00', 0, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, '', NULL, '0000-00-00', 0, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, '', NULL, '0000-00-00', 0, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, '', NULL, '0000-00-00', 0, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '', NULL, '0000-00-00', 0, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, '', NULL, '0000-00-00', 0, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_aqyc_minreport`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_aqyc_minreport` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `devcode` char(20) NOT NULL,
  `statcode` char(20) NOT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `emcvalue` int(4) DEFAULT NULL,
  `pm01` int(4) DEFAULT NULL,
  `pm25` int(4) DEFAULT NULL,
  `pm10` int(4) DEFAULT NULL,
  `noise` int(4) DEFAULT NULL,
  `windspeed` int(4) DEFAULT NULL,
  `winddirection` int(4) DEFAULT NULL,
  `rain` int(4) DEFAULT NULL,
  `temperature` int(4) DEFAULT NULL,
  `humidity` int(4) DEFAULT NULL,
  `airpressure` int(4) DEFAULT NULL,
  `pmdataflag` char(10) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55777 ;

--
-- 转存表中的数据 `t_l2snr_aqyc_minreport`
--

INSERT INTO `t_l2snr_aqyc_minreport` (`sid`, `devcode`, `statcode`, `reportdate`, `hourminindex`, `emcvalue`, `pm01`, `pm25`, `pm10`, `noise`, `windspeed`, `winddirection`, `rain`, `temperature`, `humidity`, `airpressure`, `pmdataflag`) VALUES
(614, 'HCU_SH_0302', '120101002', '2016-04-21', 1387, 5655, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 228, NULL, NULL),
(615, 'HCU_SH_0302', '120101002', '2016-04-21', 1388, 4795, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 228, NULL, NULL),
(616, 'HCU_SH_0302', '120101002', '2016-04-21', 1389, 5247, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 702, 228, NULL, NULL),
(617, 'HCU_SH_0302', '120101002', '2016-04-21', 1390, 4706, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 702, 228, NULL, NULL),
(618, 'HCU_SH_0302', '120101002', '2016-04-21', 1391, 5166, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 702, 228, NULL, NULL),
(619, 'HCU_SH_0302', '120101002', '2016-04-21', 1392, 5461, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 702, 228, NULL, NULL),
(620, 'HCU_SH_0302', '120101002', '2016-04-21', 1393, 5593, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, NULL, NULL, NULL),
(621, 'HCU_SH_0302', '120101002', '2016-04-21', 1394, 5328, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 228, NULL, NULL),
(622, 'HCU_SH_0302', '120101002', '2016-04-21', 1395, 5034, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 228, NULL, NULL),
(623, 'HCU_SH_0302', '120101002', '2016-04-21', 1396, 5348, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 228, NULL, NULL),
(624, 'HCU_SH_0302', '120101002', '2016-04-21', 1397, 5623, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 227, NULL, NULL),
(625, 'HCU_SH_0302', '120101002', '2016-04-21', 1398, 5239, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 227, NULL, NULL),
(626, 'HCU_SH_0302', '120101002', '2016-04-21', 1399, 5251, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 227, NULL, NULL),
(627, 'HCU_SH_0302', '120101002', '2016-04-21', 1400, 5201, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 700, 227, NULL, NULL),
(628, 'HCU_SH_0302', '120101002', '2016-04-21', 1401, 5542, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 699, 227, NULL, NULL),
(629, 'HCU_SH_0302', '120101002', '2016-04-21', 1402, 4939, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 699, 227, NULL, NULL),
(630, 'HCU_SH_0302', '120101002', '2016-04-21', 1403, 5280, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 698, 227, NULL, NULL),
(631, 'HCU_SH_0302', '120101002', '2016-04-21', 1404, 5481, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 698, 227, NULL, NULL),
(632, 'HCU_SH_0302', '120101002', '2016-04-21', 1405, 4966, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 698, 227, NULL, NULL),
(633, 'HCU_SH_0302', '120101002', '2016-04-21', 1406, 5447, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 697, 227, NULL, NULL),
(634, 'HCU_SH_0302', '120101002', '2016-04-21', 1407, 5469, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 696, 227, NULL, NULL),
(635, 'HCU_SH_0302', '120101002', '2016-04-21', 1408, 4858, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 696, 227, NULL, NULL),
(636, 'HCU_SH_0302', '120101002', '2016-04-21', 1409, 5177, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 227, NULL, NULL),
(637, 'HCU_SH_0302', '120101002', '2016-04-21', 1410, 4908, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 696, 227, NULL, NULL);


 */

class classDbiL2snrCommon
{
    //构造函数
    public function __construct()
    {

    }

    //更新各测量数据对应的精度信息
    public function dbi_dataformat_update_format($deviceid, $type, $format)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        switch($type)
        {
            case "T_airpressure":
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $query_str = "SELECT * FROM `t_l2snr_dataformat` WHERE (`deviceid` = '$deviceid')";
                $result = $mysqli->query($query_str);
                if (($result->num_rows)>0) {
                    $query_str = "UPDATE `t_l2snr_dataformat` SET  `f_airpressure` = '$format' WHERE (`deviceid` = '$deviceid')";
                    $result = $mysqli->query($query_str);
                }
                else {
                    $query_str = "INSERT INTO `t_l2snr_dataformat` (deviceid,f_airpressure) VALUES ('$deviceid','$format')";
                    $result = $mysqli->query($query_str);
                }
                break;
            case "T_emcdata":
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $query_str = "SELECT * FROM `t_l2snr_dataformat` WHERE (`deviceid` = '$deviceid')";
                $result = $mysqli->query($query_str);
                if (($result->num_rows)>0) {
                    $query_str = "UPDATE `t_l2snr_dataformat` SET  `f_emcdata` = '$format' WHERE (`deviceid` = '$deviceid')";
                    $result = $mysqli->query($query_str);
                }
                else {
                    $query_str = "INSERT INTO `t_l2snr_dataformat` (deviceid,f_emcdata) VALUES ('$deviceid','$format')";
                    $result = $mysqli->query($query_str);
                }
                break;
            case "T_humidity":
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $query_str = "SELECT * FROM `t_l2snr_dataformat` WHERE (`deviceid` = '$deviceid')";
                $result = $mysqli->query($query_str);
                if (($result->num_rows)>0) {
                    $query_str = "UPDATE `t_l2snr_dataformat` SET  `f_humidity` = '$format' WHERE (`deviceid` = '$deviceid')";
                    $result = $mysqli->query($query_str);
                }
                else {
                    $query_str = "INSERT INTO `t_l2snr_dataformat` (deviceid,f_humidity) VALUES ('$deviceid','$format')";
                    $result = $mysqli->query($query_str);
                }
                break;
            case "T_noise":
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $query_str = "SELECT * FROM `t_l2snr_dataformat` WHERE (`deviceid` = '$deviceid')";
                $result = $mysqli->query($query_str);
                if (($result->num_rows)>0) {
                    $query_str = "UPDATE `t_l2snr_dataformat` SET  `f_noise` = '$format' WHERE (`deviceid` = '$deviceid')";
                    $result = $mysqli->query($query_str);
                }
                else {
                    $query_str = "INSERT INTO `t_l2snr_dataformat` (deviceid,f_noise) VALUES ('$deviceid','$format')";
                    $result = $mysqli->query($query_str);
                }
                break;
            case "T_pmdata";
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $query_str = "SELECT * FROM `t_l2snr_dataformat` WHERE (`deviceid` = '$deviceid')";
                $result = $mysqli->query($query_str);
                if (($result->num_rows)>0) {
                    $query_str = "UPDATE `t_l2snr_dataformat` SET  `f_pmdata` = '$format' WHERE (`deviceid` = '$deviceid')";
                    $result = $mysqli->query($query_str);
                }
                else {
                    $query_str = "INSERT INTO `t_l2snr_dataformat` (deviceid,f_pmdata) VALUES ('$deviceid','$format')";
                    $result = $mysqli->query($query_str);
                }
                break;
            case "T_rain":
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $query_str = "SELECT * FROM `t_l2snr_dataformat` WHERE (`deviceid` = '$deviceid')";
                $result = $mysqli->query($query_str);
                if (($result->num_rows)>0) {
                    $query_str = "UPDATE `t_l2snr_dataformat` SET  `f_rain` = '$format' WHERE (`deviceid` = '$deviceid')";
                    $result = $mysqli->query($query_str);
                }
                else {
                    $query_str = "INSERT INTO `t_l2snr_dataformat` (deviceid,f_rain) VALUES ('$deviceid','$format')";
                    $result = $mysqli->query($query_str);
                }
                break;
            case "T_temperature":
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $query_str = "SELECT * FROM `t_l2snr_dataformat` WHERE (`deviceid` = '$deviceid')";
                $result = $mysqli->query($query_str);
                if (($result->num_rows)>0) {
                    $query_str = "UPDATE `t_l2snr_dataformat` SET  `f_temperature` = '$format' WHERE (`deviceid` = '$deviceid')";
                    $result = $mysqli->query($query_str);
                }
                else {
                    $query_str = "INSERT INTO `t_l2snr_dataformat` (deviceid,f_temperature) VALUES ('$deviceid','$format')";
                    $result = $mysqli->query($query_str);
                }
                break;
            case "T_winddirection":
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $query_str = "SELECT * FROM `t_l2snr_dataformat` WHERE (`deviceid` = '$deviceid')";
                $result = $mysqli->query($query_str);
                if (($result->num_rows)>0) {
                    $query_str = "UPDATE `t_l2snr_dataformat` SET  `f_winddirection` = '$format' WHERE (`deviceid` = '$deviceid')";
                    $result = $mysqli->query($query_str);
                }
                else {
                    $query_str = "INSERT INTO `t_l2snr_dataformat` (deviceid,f_winddirection) VALUES ('$deviceid','$format')";
                    $result = $mysqli->query($query_str);
                }
                break;
            case "T_windspeed":
                //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
                $query_str = "SELECT * FROM `t_l2snr_dataformat` WHERE (`deviceid` = '$deviceid')";
                $result = $mysqli->query($query_str);
                if (($result->num_rows)>0) {
                    $query_str = "UPDATE `t_l2snr_dataformat` SET  `f_windspeed` = '$format' WHERE (`deviceid` = '$deviceid')";
                    $result = $mysqli->query($query_str);
                }
                else {
                    $query_str = "INSERT INTO `t_l2snr_dataformat` (deviceid,f_windspeed) VALUES ('$deviceid','$format')";
                    $result = $mysqli->query($query_str);
                }
                break;
            default:
                $result = "COMMON_DB: invaild data format type";
                break;
        }

        $mysqli->close();
        return $result;
    }

    //UI SensorList request, 获取所有传感器类型信息
    public function dbi_all_sensorlist_req($type)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l2snr_sensortype` WHERE 1";
        $result = $mysqli->query($query_str);

        $sensor_list = array();
        while($row = $result->fetch_array())
        {
            $type_check = $row['typeid'];
            $tye_prefix =  substr($type_check, 0, MFUN_L3APL_F3DM_SENSOR_TYPE_PREFIX_LEN);
            if ($tye_prefix == $type){
                $temp = array(
                    'id' => $row['typeid'],
                    'name' => $row['model'],
                    'nickname' => $row['name'],  //to be update
                    'memo' => $row['vendor'],
                    'code' => ""
                );
                array_push($sensor_list, $temp);
            }
        }

        $mysqli->close();
        return $sensor_list;
    }

    //UI DevSensor request, 获取所有传感器类型信息
    public function dbi_aqyc_dev_sensorinfo_req($devcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3f4icm_sensorctrl` WHERE `deviceid` = '$devcode'";
        $result = $mysqli->query($query_str);

        $sensorinfo = array();
        while($row = $result->fetch_array())
        {
            $typeid = $row['sensortype'];
            $onoff = $row['onoffstatus'];
            $modbus = $row['modbus_addr'];
            $period = $row['meas_period'];
            $samples = $row['sample_interval'];
            $times = $row['meas_times'];

            $paralist = array();
            /*
            if (!empty($onoff)){
                $temp = array(
                    'name'=>"Status",
                    'memo'=>"传感器当前工作状态",
                    'value'=>$onoff
                );
                array_push($paralist,$temp);
            }
            */
            if(!empty($modbus)){
                $temp = array(
                    'name'=>"MODBUS_Addr",
                    'memo'=>"MODBUS地址",
                    'value'=>$modbus
                );
                array_push($paralist,$temp);
            }
            if(!empty($period)){
                $temp = array(
                    'name'=>"Measurement_Period",
                    'memo'=>"测量周期",
                    'value'=>$period
                );
                array_push($paralist,$temp);
            }
            if(!empty($samples)){
                $temp = array(
                    'name'=>"Samples_Interval",
                    'memo'=>"采样间隔",
                    'value'=>$samples
                );
                array_push($paralist,$temp);
            }
            if(!empty($times)){
                $temp = array(
                    'name'=>"Measurement_Times",
                    'memo'=>"测量次数",
                    'value'=>$times
                );
                array_push($paralist,$temp);
            }
            if((!empty($typeid)) AND (!empty($onoff))){
                $temp = array(
                    'id' => $typeid,
                    'status' => $onoff,
                    'para'=>$paralist
                );
            }
            array_push($sensorinfo, $temp);
        }

        $mysqli->close();
        return $sensorinfo;
    }

    public function dbi_hourreport_process($devcode,$statcode,$date,$hour)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        //找到数据库中已有序号最大的，也许会出现序号(6 BYTE)用满的情况，这时应该考虑更新该算法，短期内不需要考虑这么复杂的情况
        //数据库SID=0的记录保留作为特殊用途，对应的emcvalue字段保存当前最大可用sid
        $query_str = "SELECT * FROM `t_l2snr_hourreport` WHERE `sid` = '0'";
        $result = $mysqli->query($query_str);
        if ($result->num_rows>0)
        {
            $row = $result->fetch_array();
            $sid = intval($row['emcvalue']); //记录中存储着最大的SID
        }
        else //如果没有sid＝0记录项,找到当前最大sid并插入一条sid＝0记录项，其"longitude"字段存入sid＋1
        {
            $result = $mysqli->query("SELECT `sid` FROM `t_l2snr_hourreport` WHERE 1");
            $sid =0;
            while($row = $result->fetch_array())
            {
                if ($row['sid'] > $sid)
                {
                    $sid = $row['sid'];
                }
            }
            $sid = $sid+1;
            $mysqli->query("INSERT INTO `t_l2snr_hourreport` (sid,emcvalue) VALUES ('0', '$sid')");
        }
        //查找在给定日期给定小时内该设备的所有记录
        $start = $hour*60;
        $end = ($hour+1)*60;
        $query_str = "SELECT * FROM `t_l2snr_aqyc_minreport` WHERE `devcode` = '$devcode' AND `statcode` = '$statcode' AND
                          (`hourminindex` >= '$start' AND `hourminindex` < '$end')";
        $result = $mysqli->query($query_str);

        if ($result->num_rows < MFUN_L2SNR_COMAPI_HOUR_VALIDE_NUM )  //如果该日期指定的小时里分钟测量值小于最低要求值，则该小时平均值无效，直接返回
            return false;

        //初始化各测试参数的小时平均值
        $avg_emc = 0;
        $avg_noise = 0;
        $avg_pm01 = 0;
        $avg_pm25 = 0;
        $avg_pm10 = 0;
        $avg_windspeed = 0;
        $avg_temperature = 0;
        $avg_humidity = 0;

        //初始化各测试参数小时有效值的个数
        $count_emc = 0;
        $count_noise = 0;
        $count_pm01 = 0;
        $count_pm25 = 0;
        $count_pm10 = 0;
        $count_windspeed = 0;
        $count_temperature = 0;
        $count_humidity = 0;

        while($row = $result->fetch_array())
        {
            if (!empty($row['emcvalue']))
            {
                $avg_emc = $avg_emc + $row['emcvalue'];
                $count_emc++;
            }
            if (!empty($row['noise']))
            {
                $avg_noise = $avg_noise + $row['noise'];
                $count_noise++;
            }
            if (!empty($row['pm01']))
            {
                $avg_pm01 = $avg_pm01 + $row['pm01'];
                $count_pm01++;
            }
            if (!empty($row['pm25']))
            {
                $avg_pm25 = $avg_pm25 + $row['pm25'];
                $count_pm25++;
            }
            if (!empty($row['pm10']))
            {
                $avg_pm10 = $avg_pm10 + $row['pm10'];
                $count_pm10++;
            }
            if (!empty($row['windspeed']))
            {
                $avg_windspeed = $avg_windspeed + $row['windspeed'];
                $count_windspeed++;
            }
            if (!empty($row['temperature']))
            {
                $avg_temperature = $avg_temperature + $row['temperature'];
                $count_temperature++;
            }
            if (!empty($row['humidity']))
            {
                $avg_humidity = $avg_humidity + $row['humidity'];
                $count_humidity++;
            }
        }
        if ($count_emc >= MFUN_L2SNR_COMAPI_HOUR_VALIDE_NUM)
            $avg_emc = $avg_emc/$count_emc;
        if ($count_noise >= MFUN_L2SNR_COMAPI_HOUR_VALIDE_NUM)
            $avg_noise = $avg_noise/$count_noise;
        if ($count_pm01 >= MFUN_L2SNR_COMAPI_HOUR_VALIDE_NUM)
            $avg_pm01 = $avg_pm01/$count_pm01;
        if ($count_pm25 >= MFUN_L2SNR_COMAPI_HOUR_VALIDE_NUM)
            $avg_pm25 = $avg_pm25/$count_pm25;
        if ($count_pm10 >= MFUN_L2SNR_COMAPI_HOUR_VALIDE_NUM)
            $avg_pm10 = $avg_pm10/$count_pm10;
        if ($count_windspeed >= MFUN_L2SNR_COMAPI_HOUR_VALIDE_NUM)
            $avg_windspeed = $avg_windspeed/$count_windspeed;
        if ($count_temperature >= MFUN_L2SNR_COMAPI_HOUR_VALIDE_NUM)
            $avg_temperature = $avg_temperature/$count_temperature;
        if ($count_humidity >= MFUN_L2SNR_COMAPI_HOUR_VALIDE_NUM)
            $avg_humidity = $avg_humidity/$count_humidity;

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $query_str = "SELECT `sid` FROM `t_l2snr_hourreport` WHERE (`devcode` = '$devcode' AND `statcode` = '$statcode'
                              AND `reportdate` = '$date' AND `hourindex` = '$hour')";
        $result = $mysqli->query($query_str);
        if ($result == false){
            $mysqli->close();
            return $result;
        }
        if (($result->num_rows)>0)   //重复，则覆盖
        {
            $query_str = "UPDATE `t_l2snr_hourreport` SET `emcvalue` = '$avg_emc',`noise` = '$avg_noise',`pm01` = '$avg_pm01',`pm25` = '$avg_pm25',`pm10` = '$avg_pm10',`windspeed` = '$avg_windspeed',`temperature` = '$avg_temperature',`humidity` = '$avg_humidity'
                      WHERE (`devcode` = '$devcode' AND `statcode` = '$statcode' AND  `reportdate` = '$date' AND `hourindex` = '$hour')";
            $result=$mysqli->query($query_str);
        }
        else   //不存在，新增
        {
            $query_str = "INSERT INTO `t_l2snr_hourreport` (sid,devcode,statcode,reportdate,hourindex,emcvalue,pm01,pm25,pm10,noise,windspeed,temperature,humidity)
                              VALUES ('$sid','$devcode','$statcode','$date','$hour','$avg_emc','$avg_pm01','$avg_pm25','$avg_pm10','$avg_noise','$avg_windspeed','$avg_temperature','$avg_humidity')";
            $res1=$mysqli->query($query_str);
            //更新最大可用的sid到数据库SID=0的记录项
            $sid = $sid + 1;
            $res2=$mysqli->query("UPDATE `t_l2snr_hourreport` SET `emcvalue` = '$sid' WHERE (`sid` = '0')");
            $result = $res1 AND $res2;
        }
        $mysqli->close();
        return $result;

    }//End of function bi_hourreport_process

    /*********************************智能云锁新增处理************************************************/

    //UI DevSensor request, 获取所有传感器类型信息
    public function dbi_fhys_dev_sensorinfo_req($devcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3f4icm_sensorctrl` WHERE `deviceid` = '$devcode'";
        $result = $mysqli->query($query_str);

        $sensorinfo = array();
        while($row = $result->fetch_array())
        {
            $typeid = $row['sensortype'];
            $onoff = $row['onoffstatus'];

            $paralist = array();

            if((!empty($typeid)) AND (!empty($onoff))){
                $temp = array(
                    'id' => $typeid,
                    'status' => $onoff,
                    'para'=>$paralist
                );
            }
            array_push($sensorinfo, $temp);
        }

        $mysqli->close();
        return $sensorinfo;
    }

    /*********************************HUITP数据处理************************************************/

    public function dbi_huitp_xmlmsg_alarm_info_report($devCode, $statCode, $data)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //$data[0] = HUITP_IEID_uni_com_report，暂时没有使用

        //$data[1] = HUITP_IEID_uni_alarm_info_element
        $alarmType = hexdec($data[1]['HUITP_IEID_uni_alarm_info_element']['alarmType']) & 0xFFFF;
        $alarmServerity = hexdec($data[1]['HUITP_IEID_uni_alarm_info_element']['alarmServerity']) & 0xFF;
        $alarmClearFlag = hexdec($data[1]['HUITP_IEID_uni_alarm_info_element']['alarmClearFlag']) & 0xFF;
        $equID = hexdec($data[1]['HUITP_IEID_uni_alarm_info_element']['equID']) & 0xFFFFFFFF;
        $causeId = hexdec($data[1]['HUITP_IEID_uni_alarm_info_element']['causeId']) & 0xFFFFFFFF;
        $alarmContent = hexdec($data[1]['HUITP_IEID_uni_alarm_info_element']['alarmContent']) & 0xFFFFFFFF;
        $alarmDesc = $data[1]['HUITP_IEID_uni_alarm_info_element']['alarmDesc'];
        $timeStamp = hexdec($data[1]['HUITP_IEID_uni_alarm_info_element']['timeStamp']) & 0xFFFFFFFF;

        $createtime = date("Y-m-d H:m:s", $timeStamp);
        $query_str = "INSERT INTO `t_l3f5fm_aqyc_alarmdata` (`devcode`, `equipmentid`, `alarmtype`, `alarmdesc`, `alarmseverity`, `alarmclearflag`, `timestamp`, `causeid`, `alarmcontent`)
                      VALUES ('$devCode', '$equID', '$alarmType', '$alarmDesc', '$alarmServerity', '$alarmClearFlag', '$createtime', '$causeId', '$alarmContent')";
        $result=$mysqli->query($query_str);

        if ($result == true)
            $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_YES;
        else
            $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_NO;

        //生成 HUITP_MSGID_uni_alarm_info_confirm 消息的内容
        $respMsgContent = array();
        $baseConfirmIE = array();

        $l2codecHuitpIeDictObj = new classL2codecHuitpIeDict;

        //组装IE HUITP_IEID_uni_com_confirm
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_com_confirm);
        $huitpIeLen = intval($huitpIe['len']);
        array_push($baseConfirmIE, HUITP_IEID_uni_com_confirm);
        array_push($baseConfirmIE, $huitpIeLen);
        array_push($baseConfirmIE, $comConfirm);

        array_push($respMsgContent, $baseConfirmIE);

        $mysqli->close();
        return $respMsgContent;
    }

    public function dbi_huitp_xmlmsg_performance_info_report($devCode, $statCode, $data)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //$data[0] = HUITP_IEID_uni_com_report，暂时没有使用

        //$data[1] = HUITP_IEID_uni_performance_info_element
        $restartCnt = hexdec($data[1]['HUITP_IEID_uni_performance_info_element']['restartCnt']) & 0xFFFFFFFF;
        $networkConnCnt = hexdec($data[1]['HUITP_IEID_uni_performance_info_element']['networkConnCnt']) & 0xFFFFFFFF;
        $networkConnFailCnt = hexdec($data[1]['HUITP_IEID_uni_performance_info_element']['networkConnFailCnt']) & 0xFFFFFFFF;
        $networkDiscCnt = hexdec($data[1]['HUITP_IEID_uni_performance_info_element']['networkDiscCnt']) & 0xFFFFFFFF;
        $socketDiscCnt = hexdec($data[1]['HUITP_IEID_uni_performance_info_element']['socketDiscCnt']) & 0xFFFFFFFF;
        $cpuOccupy = hexdec($data[1]['HUITP_IEID_uni_performance_info_element']['cpuOccupy']) & 0xFFFFFFFF;
        $memOccupy = hexdec($data[1]['HUITP_IEID_uni_performance_info_element']['memOccupy']) & 0xFFFFFFFF;
        $diskOccupy = hexdec($data[1]['HUITP_IEID_uni_performance_info_element']['diskOccupy']) & 0xFFFFFFFF;
        $cpuTemp = hexdec($data[1]['HUITP_IEID_uni_performance_info_element']['cpuTemp']) & 0xFFFFFFFF;

        $timeStamp = time();
        $createtime = date("Y-m-d H:m:s", $timeStamp);

        //先检查是否存在，如果存在，就更新，否则创建
        $result = $mysqli->query("SELECT * FROM `t_l3f6pm_perfdata` WHERE (`devcode` = '$devCode' AND `statcode` = '$statCode')");
        if (($result->num_rows)>0)
        {
            $query_str = "UPDATE `t_l3f6pm_perfdata` SET `createtime` = '$createtime',`restartCnt` = '$restartCnt',`networkConnCnt` = '$networkConnCnt',`networkConnFailCnt` = '$networkConnFailCnt',`networkDiscCnt` = '$networkDiscCnt', `socketDiscCnt` = '$socketDiscCnt',
                          `cpuOccupy` = '$cpuOccupy', `memOccupy` = '$memOccupy', `diskOccupy` = '$diskOccupy',`cpuTemp` = '$cpuTemp' WHERE (`devcode` = '$devCode' AND `statcode` = '$statCode')";
            $result=$mysqli->query($query_str);
        }
        else
        {
            $query_str = "INSERT INTO `t_l3f6pm_perfdata`(`devcode`, `statcode`, `createtime`,`restartCnt`, `networkConnCnt`, `networkConnFailCnt`, `networkDiscCnt`, `socketDiscCnt`, `cpuOccupy`, `memOccupy`, `diskOccupy`, `cpuTemp`)
                          VALUES ('$devCode', '$statCode', '$createtime','$restartCnt', '$networkConnCnt', '$networkConnFailCnt', '$networkDiscCnt', '$socketDiscCnt', '$cpuOccupy', '$memOccupy', '$diskOccupy', '$cpuTemp')";
            $result=$mysqli->query($query_str);
        }

        if ($result == true)
            $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_YES;
        else
            $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_NO;

        //生成 HUITP_MSGID_uni_performance_info_confirm 消息的内容
        $respMsgContent = array();
        $baseConfirmIE = array();

        $l2codecHuitpIeDictObj = new classL2codecHuitpIeDict;

        //组装IE HUITP_IEID_uni_com_confirm
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_com_confirm);
        $huitpIeLen = intval($huitpIe['len']);
        array_push($baseConfirmIE, HUITP_IEID_uni_com_confirm);
        array_push($baseConfirmIE, $huitpIeLen);
        array_push($baseConfirmIE, $comConfirm);

        array_push($respMsgContent, $baseConfirmIE);

        $mysqli->close();
        return $respMsgContent;
    }

    public function dbi_huitp_xmlmsg_inventory_report($devCode, $statCode, $data)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //$data[0] = HUITP_IEID_uni_com_report，暂时没有使用
        //$data[1] = HUITP_IEID_uni_inventory_element
        $hwType = hexdec($data[1]['HUITP_IEID_uni_inventory_element']['hwType']) & 0xFFFF;
        $hwId = hexdec($data[1]['HUITP_IEID_uni_inventory_element']['hwId']) & 0xFFFF;
        $swRel = hexdec($data[1]['HUITP_IEID_uni_inventory_element']['swRel']) & 0xFFFF;
        $swVer = hexdec($data[1]['HUITP_IEID_uni_inventory_element']['swVer']) & 0xFFFF;
        $dbVer = hexdec($data[1]['HUITP_IEID_uni_inventory_element']['dbVer']) & 0xFFFF;
        $swCheckSum = hexdec($data[1]['HUITP_IEID_uni_inventory_element']['swCheckSum']) & 0xFFFF;
        $swTotalLen = hexdec($data[1]['HUITP_IEID_uni_inventory_element']['swTotalLen']) & 0xFFFFFFFF;
        $dbCheckSum = hexdec($data[1]['HUITP_IEID_uni_inventory_element']['dbCheckSum']) & 0xFFFF;
        $dbTotalLen = hexdec($data[1]['HUITP_IEID_uni_inventory_element']['dbTotalLen']) & 0xFFFFFFFF;
        $upgradeFlag = hexdec($data[1]['HUITP_IEID_uni_inventory_element']['upgradeFlag']) & 0xFF;
        $equEntry = hexdec($data[1]['HUITP_IEID_uni_inventory_element']['equEntry']) & 0xFF;
        $timeStamp = hexdec($data[1]['HUITP_IEID_uni_inventory_element']['timeStamp']) & 0xFFFFFFFF;

        $validflag = MFUN_HCU_SW_LOAD_FLAG_VALID;
        $relver_index = $swRel*65535 + $swVer;

        //查找硬件类型hwtype相同，设备entry（HCU，IHU）相同，软件更新标识（稳定版，补丁版，测试版）相同的load
        $query_str = "SELECT * FROM `t_l3f4icm_swctrl` WHERE `swrel` = (SELECT MAX(`swrel`) FROM `t_l3f4icm_swctrl` WHERE (`hwtype` = '$hwType' AND `upgradeFlag` = '$upgradeFlag' AND `equEntry` = '$equEntry' AND `validflag` = '$validflag'))";
        $result=$mysqli->query($query_str);
        //选取符合上述更新条件中最新的版本
        while (($result != false) && (($row = $result->fetch_array()) > 0))
        {
            $newHwId = intval($row['hwid']);
            if ($newHwId < $hwId) continue;  //HwID要大于等于输入

            $newSwRel = intval($row['swrel']);
            $newSwVer = intval($row['swver']);
            $new_index = $newSwRel*65535 + $newSwVer;
            if ($new_index > $relver_index){
                $relver_index = $new_index;
                $hwId = $newHwId;
                $swRel = $newSwRel;
                $swVer = $newSwVer;
                $dbVer = intval($row['dbver']);
                $swCheckSum = intval($row['checksum']);
                $swTotalLen = intval($row['filesize']);
            }
        }

        //查找新load对应的database版本
        $dbEntry = HUITP_IEID_UNI_EQU_ENTRY_HCU_DB;
        $query_str = "SELECT * FROM `t_l3f4icm_swctrl` WHERE (`hwtype` = '$hwType' AND `upgradeFlag` = '$upgradeFlag' AND `equEntry` = '$dbEntry' AND `validflag` = '$validflag' AND `swrel` = '$swRel' AND `dbver` = '$dbVer')";
        $result=$mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0){
            $row = $result->fetch_array();
            $dbCheckSum = $row['checksum'];
            $dbTotalLen = $row['filesize'];
            $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_YES;
        }
        else{
            $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_NO;
        }

        $timeStamp = time();
        //生成 HUITP_MSGID_uni_inventory_confirm 消息的内容
        $respMsgContent = array();
        $baseConfirmIE = array();
        $confirmValueIE = array();

        $l2codecHuitpIeDictObj = new classL2codecHuitpIeDict;

        //组装IE HUITP_IEID_uni_com_confirm
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_com_confirm);
        $huitpIeLen = intval($huitpIe['len']);
        array_push($baseConfirmIE, HUITP_IEID_uni_com_confirm);
        array_push($baseConfirmIE, $huitpIeLen);
        array_push($baseConfirmIE, $comConfirm);

        //组装IE HUITP_IEID_uni_inventory_element
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_inventory_element);
        $huitpIeLen = intval($huitpIe['len']);
        array_push($confirmValueIE, HUITP_IEID_uni_inventory_element);
        array_push($confirmValueIE, $huitpIeLen);
        array_push($confirmValueIE, $hwType);
        array_push($confirmValueIE, $hwId);
        array_push($confirmValueIE, $swRel);
        array_push($confirmValueIE, $swVer);
        array_push($confirmValueIE, $dbVer);
        array_push($confirmValueIE, $swCheckSum);
        array_push($confirmValueIE, $swTotalLen);
        array_push($confirmValueIE, $dbCheckSum);
        array_push($confirmValueIE, $dbTotalLen);
        array_push($confirmValueIE, $upgradeFlag);
        array_push($confirmValueIE, $equEntry);
        array_push($confirmValueIE, $timeStamp);

        array_push($respMsgContent, $baseConfirmIE);
        array_push($respMsgContent, $confirmValueIE);

        $mysqli->close();
        return $respMsgContent;
    }

    public function dbi_huitp_xmlmsg_inventory_resp($devCode, $statCode, $data)
    {
        return true;
    }

    public function dbi_huitp_xmlmsg_sw_package_resp($devCode, $statCode, $data)
    {
        return true;
    }

    public function dbi_huitp_xmlmsg_sw_package_report($devCode, $statCode, $data)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //$data[0] = HUITP_IEID_uni_com_report，暂时没有使用
        //$data[1] = HUITP_IEID_uni_com_segment
        $hwType = hexdec($data[1]['HUITP_IEID_uni_com_segment']['hwType']) & 0xFFFF;
        $hwPem = hexdec($data[1]['HUITP_IEID_uni_com_segment']['hwPem']) & 0xFFFF;
        $swRel = hexdec($data[1]['HUITP_IEID_uni_com_segment']['swRel']) & 0xFFFF;
        $swVer = hexdec($data[1]['HUITP_IEID_uni_com_segment']['swVer']) & 0xFFFF;
        $upgradeFlag = hexdec($data[1]['HUITP_IEID_uni_com_segment']['upgradeFlag']) & 0xFF;
        $equEntry = hexdec($data[1]['HUITP_IEID_uni_com_segment']['equEntry']) & 0xFF;
        $segIndex = hexdec($data[1]['HUITP_IEID_uni_com_segment']['segIndex']) & 0xFFFF;
        $segTotal = hexdec($data[1]['HUITP_IEID_uni_com_segment']['segTotal']) & 0xFFFF;
        $segSplitLen = hexdec($data[1]['HUITP_IEID_uni_com_segment']['segSplitLen']) & 0xFFFF;

        $filelink = "";
        $filesize = 0;
        $file_checksum = 0;
        $validflag = MFUN_HCU_SW_LOAD_FLAG_VALID;
        if ($equEntry == HUITP_IEID_UNI_EQU_ENTRY_HCU_SW) { //软件下载请求
            $query_str = "SELECT * FROM `t_l3f4icm_swctrl` WHERE (`hwtype` = '$hwType' AND `upgradeFlag` = '$upgradeFlag' AND `equEntry` = '$equEntry' AND `validflag` = '$validflag' AND `swrel` = '$swRel' AND `swver` = '$swVer')";
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows) > 0) {
                $row = $result->fetch_array();
                $filelink = intval($row['filelink']);
                $filesize = intval($row['filesize']);
                $file_checksum = intval($row['checksum']);
            }
        } elseif ($equEntry == HUITP_IEID_UNI_EQU_ENTRY_HCU_DB) {  //数据库下载请求
            $query_str = "SELECT * FROM `t_l3f4icm_swctrl` WHERE (`hwtype` = '$hwType' AND `upgradeFlag` = '$upgradeFlag' AND `equEntry` = '$equEntry' AND `validflag` = '$validflag' AND `swrel` = '$swRel' AND `dbver` = '$swVer')";
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows) > 0) {
                $row = $result->fetch_array();
                $filelink = intval($row['filelink']);
                $filesize = intval($row['filesize']);
                $file_checksum = intval($row['checksum']);
            }
        }

        if ($segTotal > 0)
            $len = $filesize / $segTotal;
        else
            $len = 0;

        $seg_checksum = 0;
        $segContent = "";
        $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_NO;
        $include_path = 0; //可选。如果也想在 include_path 中搜寻文件的话，可以将该参数设为 "1"。
        $context = null;  //可选。规定文件句柄的环境。
        if (!empty($filelink) AND $len == $segSplitLen) {
            if ($segIndex < $segTotal) {
                $start = ($segIndex -1)*$segSplitLen;
                $validLen = $segSplitLen;
                $segContent = file_get_contents($filelink,$include_path,$context,$start,$validLen);
                $dbiL1vmCommonObj = new classDbiL1vmCommon();
                $seg_checksum = $dbiL1vmCommonObj->seg_checksum($segContent);
                $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_YES;
            } elseif ($segIndex == $segTotal) {
                $start = ($segIndex -1)*$segSplitLen;
                $validLen = $filesize - $start;
                $segContent = file_get_contents($filelink,$include_path,$context,$start,$validLen);
                $dbiL1vmCommonObj = new classDbiL1vmCommon();
                $seg_checksum = $dbiL1vmCommonObj->seg_checksum($segContent);
                $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_YES;
            }
        }

        //生成 HUITP_MSGID_uni_sw_package_confirm 消息的内容
        $respMsgContent = array();
        $baseConfirmIE = array();
        $confirmValueIE = array();
        $swPkgBodyIE = array();

        $l2codecHuitpIeDictObj = new classL2codecHuitpIeDict;

        //组装IE HUITP_IEID_uni_com_confirm
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_com_confirm);
        $huitpIeLen = intval($huitpIe['len']);
        array_push($baseConfirmIE, HUITP_IEID_uni_com_confirm);
        array_push($baseConfirmIE, $huitpIeLen);
        array_push($baseConfirmIE, $comConfirm);

        //组装IE HUITP_IEID_uni_inventory_element
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_inventory_element);
        $huitpIeLen = intval($huitpIe['len']);
        array_push($confirmValueIE, HUITP_IEID_uni_inventory_element);
        array_push($confirmValueIE, $huitpIeLen);
        array_push($confirmValueIE, $hwType);
        array_push($confirmValueIE, $hwPem);
        array_push($confirmValueIE, $swRel);
        array_push($confirmValueIE, $swVer);
        array_push($confirmValueIE, $upgradeFlag);
        array_push($confirmValueIE, $equEntry);
        array_push($confirmValueIE, $segIndex);
        array_push($confirmValueIE, $segTotal);
        array_push($confirmValueIE, $segSplitLen);

        //组装IE HUITP_IEID_uni_sw_package_body
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_sw_package_body);
        $huitpIeLen = intval($huitpIe['len']);
        array_push($swPkgBodyIE, HUITP_IEID_uni_sw_package_body);
        array_push($swPkgBodyIE, $huitpIeLen);
        array_push($swPkgBodyIE, $validLen);
        array_push($swPkgBodyIE, $seg_checksum);
        $temp = array();
        for ( $i=0; $i<strlen($segContent); $i++ )
            array_push($temp, $segContent[$i]);
        array_push($swPkgBodyIE, $temp);

        array_push($respMsgContent, $baseConfirmIE);
        array_push($respMsgContent, $confirmValueIE);
        array_push($respMsgContent, $swPkgBodyIE);

        $mysqli->close();
        return $respMsgContent;
    }

}

?>