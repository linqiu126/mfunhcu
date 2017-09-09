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
-- 表的结构 `t_l2snr_sensortype`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_sensortype` (
  `typeid` char(10) NOT NULL,
  `name` char(10) NOT NULL,
  `value_min` int(2) NOT NULL DEFAULT '0',
  `value_max` int(2) NOT NULL,
  `model` char(20) DEFAULT NULL,
  `vendor` char(20) DEFAULT NULL,
  `dataformat` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l2snr_sensortype`
--
ALTER TABLE `t_l2snr_sensortype`
  ADD PRIMARY KEY (`typeid`);


-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_aqyc_minreport`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_aqyc_minreport` (
  `sid` int(4) NOT NULL,
  `devcode` char(20) NOT NULL,
  `statcode` char(20) NOT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `dataflag` char(10) NOT NULL DEFAULT 'Y',
  `pm01` float DEFAULT NULL,
  `pm25` float DEFAULT NULL,
  `pm10` float DEFAULT NULL,
  `noise` float DEFAULT NULL,
  `windspeed` float DEFAULT NULL,
  `winddirection` float DEFAULT NULL,
  `temperature` float DEFAULT NULL,
  `humidity` float DEFAULT NULL,
  `airpressure` float DEFAULT NULL,
  `rain` float DEFAULT NULL,
  `emcvalue` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l2snr_aqyc_minreport`
--
ALTER TABLE `t_l2snr_aqyc_minreport`
  ADD PRIMARY KEY (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_l2snr_aqyc_minreport`
--
ALTER TABLE `t_l2snr_aqyc_minreport`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_hourreport`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_hourreport` (
  `sid` int(4) NOT NULL,
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
  `validdatanum` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l2snr_hourreport`
--
ALTER TABLE `t_l2snr_hourreport`
  ADD PRIMARY KEY (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_l2snr_hourreport`
--
ALTER TABLE `t_l2snr_hourreport`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- 表的结构 `t_l2snr_fhys_minreport`
--

CREATE TABLE IF NOT EXISTS `t_l2snr_fhys_minreport` (
  `sid` int(2) NOT NULL,
  `devcode` char(20) NOT NULL,
  `statcode` char(20) NOT NULL,
  `reportdate` date NOT NULL,
  `hourminindex` int(2) NOT NULL,
  `reporttype` int(1) NOT NULL DEFAULT '0',
  `door_1` int(1) NOT NULL DEFAULT '0',
  `door_2` int(1) NOT NULL DEFAULT '0',
  `door_3` int(1) NOT NULL DEFAULT '0',
  `door_4` int(1) NOT NULL DEFAULT '0',
  `lock_1` int(1) NOT NULL DEFAULT '0',
  `lock_2` int(1) NOT NULL DEFAULT '0',
  `lock_3` int(1) NOT NULL DEFAULT '0',
  `lock_4` int(1) NOT NULL DEFAULT '0',
  `battstate` int(1) NOT NULL DEFAULT '0',
  `waterstate` int(1) NOT NULL DEFAULT '0',
  `shakestate` int(1) NOT NULL DEFAULT '0',
  `fallstate` int(1) NOT NULL DEFAULT '0',
  `smokestate` int(1) NOT NULL DEFAULT '0',
  `battvalue` float NOT NULL DEFAULT '0',
  `fallValue` float NOT NULL DEFAULT '0',
  `tempvalue` float NOT NULL DEFAULT '0',
  `humidvalue` float NOT NULL DEFAULT '0',
  `rssivalue` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l2snr_fhys_minreport`
--
ALTER TABLE `t_l2snr_fhys_minreport`
  ADD PRIMARY KEY (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_l2snr_fhys_minreport`
--
ALTER TABLE `t_l2snr_fhys_minreport`
  MODIFY `sid` int(2) NOT NULL AUTO_INCREMENT;




 */

class classDbiL2snrCommon
{
    //构造函数
    public function __construct()
    {

    }

    //用于HUITP汇报数值根据format进行转换
    public function dbi_datavalue_convert($format, $data)
    {
        switch($format)
        {
            case HUITP_IEID_UNI_COM_FORMAT_TYPE_NULL:
                $value = false;
                break;
            case HUITP_IEID_UNI_COM_FORMAT_TYPE_INT_ONLY:
                $value = intval($data);
                break;
            case HUITP_IEID_UNI_COM_FORMAT_TYPE_FLOAT_WITH_NF1:
                $value = intval($data)/10;
                break;
            case HUITP_IEID_UNI_COM_FORMAT_TYPE_FLOAT_WITH_NF2:
                $value = intval($data)/100;
                break;
            case HUITP_IEID_UNI_COM_FORMAT_TYPE_FLOAT_WITH_NF3:
                $value = intval($data)/1000;
                break;
            case HUITP_IEID_UNI_COM_FORMAT_TYPE_FLOAT_WITH_NF4:
                $value = intval($data)/10000;
                break;
            case HUITP_IEID_UNI_COM_FORMAT_TYPE_INVALID:
                $value = false;
                break;
            default:
                $value = false;
                break;
        }
        return $value;
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

    }

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

    public function dbi_huitp_xmlmsg_heart_beat_report($devCode, $statCode, $data)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //$data[0] = HUITP_IEID_uni_com_report，暂时没有使用

        //$data[1] = HUITP_IEID_uni_heart_beat_ping
        $pingval = hexdec($data[1]['HUITP_IEID_uni_heart_beat_ping']['randval']) & 0xFFFF;

        //生成 HUITP_MSGID_uni_heart_beat_confirm 消息的内容
        $respMsgContent = array();
        $baseConfirmIE = array();
        $pongIE = array();

        $l2codecHuitpIeDictObj = new classL2codecHuitpIeDict;

        //组装IE HUITP_IEID_uni_com_confirm
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_com_confirm);
        $huitpIeLen = intval($huitpIe['len']);
        $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_YES;
        array_push($baseConfirmIE, HUITP_IEID_uni_com_confirm);
        array_push($baseConfirmIE, $huitpIeLen);
        array_push($baseConfirmIE, $comConfirm);

        //组装IE HUITP_IEID_uni_heart_beat_pong
        $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat(HUITP_IEID_uni_heart_beat_pong);
        $huitpIeLen = intval($huitpIe['len']);
        $pongval = $pingval;
        array_push($pongIE, HUITP_IEID_uni_heart_beat_pong);
        array_push($pongIE, $huitpIeLen);
        array_push($pongIE, $pongval);

        array_push($respMsgContent, $baseConfirmIE);
        array_push($respMsgContent, $pongIE);

        $mysqli->close();
        return $respMsgContent;
    }

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
        $timeStamp = hexdec($data[1]['HUITP_IEID_uni_alarm_info_element']['timeStamp']) & 0xFFFFFFFF;

        $alarmDesc = "";

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
        $timeStamp = hexdec($data[1]['HUITP_IEID_uni_performance_info_element']['timeStamp']) & 0xFFFFFFFF;

        $createtime = date("Y-m-d H:m:s", $timeStamp);

        $query_str = "INSERT INTO `t_l3f6pm_perfdata`(`devcode`, `statcode`, `createtime`,`restartCnt`, `networkConnCnt`, `networkConnFailCnt`, `networkDiscCnt`, `socketDiscCnt`, `cpuOccupy`, `memOccupy`, `diskOccupy`, `cpuTemp`)
                      VALUES ('$devCode', '$statCode', '$createtime','$restartCnt', '$networkConnCnt', '$networkConnFailCnt', '$networkDiscCnt', '$socketDiscCnt', '$cpuOccupy', '$memOccupy', '$diskOccupy', '$cpuTemp')";
        $result=$mysqli->query($query_str);

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

        $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_NO; //初始化
        $validflag = MFUN_HCU_SW_LOAD_FLAG_VALID;
        $relver_index = $swRel*65535 + $swVer;

        //查找硬件类型hwtype相同，设备entry（HCU，IHU）相同，软件更新标识（稳定版，补丁版，测试版）相同的load
        $query_str = "SELECT * FROM `t_l3f10oam_swloadinfo` WHERE (`hwtype` = '$hwType' AND `upgradeFlag` = '$upgradeFlag' AND `equEntry` = '$equEntry' AND `validflag` = '$validflag')";
        $result=$mysqli->query($query_str);
        //选取符合上述更新条件中最新的版本
        while (($result != false) && (($row = $result->fetch_array()) > 0))
        {
            $newHwId = intval($row['hwid']);
            if ($newHwId < $hwId) continue;  //HwID要大于等于输入

            $newSwRel = intval($row['swrel']);
            $newSwVer = intval($row['swver']);
            $new_index = $newSwRel*65535 + $newSwVer;
            if ($new_index >= $relver_index){
                $relver_index = $new_index;
                $hwId = $newHwId;
                $swRel = $newSwRel;
                $swVer = $newSwVer;
                $dbVer = intval($row['dbver']);
                $swCheckSum = intval($row['checksum']);
                $swTotalLen = intval($row['filesize']);
                $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_YES;
            }
        }

        //如果entry是HCU_SW,需要查找新load对应的database版本
        if($equEntry == HUITP_IEID_UNI_EQU_ENTRY_HCU_SW){
            $dbEntry = HUITP_IEID_UNI_EQU_ENTRY_HCU_DB;
            $query_str = "SELECT * FROM `t_l3f10oam_swloadinfo` WHERE (`hwtype` = '$hwType' AND `equEntry` = '$dbEntry' AND `validflag` = '$validflag' AND `swrel` = '$swRel' AND `dbver` = '$dbVer')";
            $result=$mysqli->query($query_str);
            if (($result != false) && ($result->num_rows)>0){
                $row = $result->fetch_array();
                $dbCheckSum = $row['checksum'];
                $dbTotalLen = $row['filesize'];
            }
            else{
                $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_NO;
            }
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
        //HCU或IHU软件下载请求
        if ($equEntry == HUITP_IEID_UNI_EQU_ENTRY_HCU_SW OR $equEntry == HUITP_IEID_UNI_EQU_ENTRY_IHU) {
            $query_str = "SELECT * FROM `t_l3f10oam_swloadinfo` WHERE (`hwtype` = '$hwType' AND `upgradeFlag` = '$upgradeFlag' AND `equEntry` = '$equEntry' AND `validflag` = '$validflag' AND `swrel` = '$swRel' AND `swver` = '$swVer')";
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows) > 0) {
                $row = $result->fetch_array();
                $filelink = $row['filelink'];
                $filesize = intval($row['filesize']);
                $file_checksum = intval($row['checksum']);
            }
        }
        //数据库下载请求
        elseif ($equEntry == HUITP_IEID_UNI_EQU_ENTRY_HCU_DB) {
            $query_str = "SELECT * FROM `t_l3f10oam_swloadinfo` WHERE (`hwtype` = '$hwType' AND `equEntry` = '$equEntry' AND `validflag` = '$validflag' AND `swrel` = '$swRel' AND `dbver` = '$swVer')";
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows) > 0) {
                $row = $result->fetch_array();
                $filelink = $row['filelink'];
                $filesize = intval($row['filesize']);
                $file_checksum = intval($row['checksum']);
            }
        }
        else{
            $filelink = "";
            $filesize = 0;
        }

        if($segSplitLen != 0)
            $segTotal_calc = ceil($filesize/$segSplitLen);
        else
            $segTotal_calc = 0;

        $seg_checksum = 0;
        $segContent = "";
        $validLen = 0;
        $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_NO;
        $include_path = 0; //可选。如果也想在 include_path 中搜寻文件的话，可以将该参数设为 "1"。
        $context = null;  //可选。规定文件句柄的环境。
        if (!empty($filelink) AND $segTotal == $segTotal_calc) {
            if ($segIndex < $segTotal) {
                $start = ($segIndex -1)*$segSplitLen;
                $validLen = $segSplitLen;
                $segContent = file_get_contents($filelink,$include_path,$context,$start,$validLen);
                if($segContent){
                    $dbiL1vmCommonObj = new classDbiL1vmCommon();
                    $seg_checksum = $dbiL1vmCommonObj->seg_checksum($segContent);
                    $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_YES;
                }
                else{
                    $seg_checksum = 0;
                    $segTotal = $segTotal_calc;
                    $comConfirm = HUITP_IEID_UNI_COM_CONFIRM_NO;
                }
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
        //填充SW_body,不够规定长度的补充0
        $temp = array();
        for ( $i=0; $i<HUITP_IEID_UNI_SW_PACKAGE_BODY_MAX_LEN; $i++ ){
            if($i < $validLen)
                array_push($temp, intval(bin2hex($segContent[$i]),16));
            else
                array_push($temp, 0);
        }

        array_push($swPkgBodyIE, $temp);

        array_push($respMsgContent, $baseConfirmIE);
        array_push($respMsgContent, $confirmValueIE);
        array_push($respMsgContent, $swPkgBodyIE);

        $mysqli->close();
        return $respMsgContent;
    }

}

?>