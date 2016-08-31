<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/20
 * Time: 23:00
 */
//include_once "../../l1comvm/vmlayer.php";

/*

//该数据表单的逻辑是试图将所有的不同参数组成一个大表，通过SENSOR_ID来记录不同SENSOR的仪表操控状态
//由于不同仪表的潜在操控参数不完全一样，这里是讲所有可能的仪表参数组合成为一个大表，而不再为不同仪表进行区分
//如果涉及到区分，则需要通过具体的dbi函数来完成
//这个表格是否与设备中SENSOR列表相互冲突，待完善

-- --------------------------------------------------------
--
-- 表的结构 `t_l3f4icm_sensorctrl`
--

CREATE TABLE IF NOT EXISTS `t_l3f4icm_sensorctrl` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `deviceid` char(20) NOT NULL,
  `sensorid` int(2) NOT NULL,
  `equid` int(2) NOT NULL,
  `sensortype` char(10) NOT NULL,
  `workingcycle` int(2) NOT NULL,
  `onoffstatus` tinyint(1) NOT NULL,
  `sampleduaration` int(2) NOT NULL,
  `paralpha` int(2) NOT NULL,
  `parbeta` int(2) NOT NULL,
  `pargama` int(2) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_l3f4icm_sensorctrl`
--

INSERT INTO `t_l3f4icm_sensorctrl` (`sid`, `deviceid`, `sensorid`, `equid`, `sensortype`, `workingcycle`, `onoffstatus`, `sampleduaration`, `paralpha`, `parbeta`, `pargama`) VALUES
(1, 'HCU301_22', 111, 6, '风速', 0, 0, 0, 0, 0, 0);


--
-- 表的结构 `t_l3f4icm_swfactory`
--

CREATE TABLE IF NOT EXISTS `t_l3f4icm_swfactory` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `swverid` char(50) NOT NULL,
  `swverdescripition` char(50) NOT NULL,
  `issuedate` date NOT NULL,
  `swbin` mediumblob NOT NULL,
  `dbbin` mediumblob NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `t_l3f4icm_swfactory`
--

INSERT INTO `t_l3f4icm_swfactory` (`sid`, `swverid`, `swverdescripition`, `issuedate`, `swbin`, `dbbin`) VALUES
(1, 'AQYC.R02.099', '飞凌335D Baseline, 基础功能完善，气象五参数，视频，支持基于树莓派的传感器', '2016-07-13', '', '');

*/

class classDbiL3apF4icm
{
    //构造函数
    public function __construct()
    {

    }

    public function dbi_sensor_control_table_save($deviceid, $sensorid, $equid, $sensortype)
    {
        //建立连接
        $mysqli=new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli)
        {
            die('Could not connect: ' . mysqli_error($mysqli));
        }

        //存储新记录，如果发现是已经存在的数据，则覆盖，否则新增
        $result = $mysqli->query("SELECT * FROM `t_l3f4icm_sensorctrl` WHERE (`deviceid` = '$deviceid' AND `sensor_sid` = '$sensorid'");
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $result=$mysqli->query("UPDATE `t_l3f4icm_sensorctrl` SET  `equid` = '$equid',`sensortype` = '$sensortype' WHERE (`deviceid` = '$deviceid' AND `sensor_sid` = '$sensorid')");
        }
        else   //不存在，新增
        {
            $result=$mysqli->query("INSERT INTO `t_l3f4icm_sensorctrl` (deviceid,sensor_sid,equid,sensortype)
                    VALUES ('$deviceid','$sensorid','$equid','$sensortype')");
        }
        $mysqli->close();
        return $result;
    }

    public function dbi_hcu_vediolist_inqury($statcode, $date, $hour)
    {
        //查询监测点下的设备列表
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
                'statcode' => $row['statcode'],
                'name' =>  $row['name'],
                'devcode' => $row['devcode']
            );
            array_push($devlist, $temp);
        }

        $videolist = array();
        if(!empty($devlist)){
            $i = 0;
            $format = "A11Hcuid/A1Conj/A2Key/A8Date/A2Hour/A2Min/A9Fix";  //HCU_SH_0304_av201607202130.h264.mp4
            while ($i < count($devlist)){
                $deviceid = $devlist[$i]['devcode'];
                $start = $hour * 60;
                $end = $hour * 60 + 59;
                $query_str = "SELECT * FROM `t_l2snr_hsmmpdata` WHERE `deviceid` = '$deviceid' AND `reportdate` = '$date'
                                  AND `hourminindex` >= '$start' AND `hourminindex` < '$end' ";
                $result = $mysqli->query($query_str);
                while($row = $result->fetch_array()){
                    $videourl = $row['videourl'];
                    //$videourl = strrchr($videourl, '/');
                    $data = unpack($format, $videourl);

                    $temp = array(
                        'id'=> $videourl,
                        'attr'=> $devlist[$i]['name']."_视频".$data["Date"]."_".$data["Hour"].":".$data["Min"]
                    );
                    array_push($videolist, $temp);
                }
                $i++;
            }
        }
        $mysqli->close();
        return $videolist;
    }

    public function dbi_hcu_vedioplay_request($videoid)
    {
        //查询该视频文件当前状态，是否已经下载，是否正在下载
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_l2snr_hsmmpdata` WHERE `videourl` = '$videoid' ";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            $dataflag = $row["dataflag"];
            $devCode = $row["deviceid"];
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            if ($dataflag == MFUN_HCU_VIDEO_DATA_STATUS_NORMAL OR $dataflag == MFUN_HCU_VIDEO_DATA_STATUS_FAIL){
                $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_HSMMP_DATA);
                $opt_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_OPT_VEDIOFILE_REQ);
                $len = $apiL2snrCommonServiceObj->byte2string(strlen( $opt_key)/2 + strlen($videoid));
                $cmdStr = $ctrl_key . $len . $opt_key . $videoid;
                //保存命令到CmdBuf
                $dbiL1VmCommonObj = new classDbiL1vmCommon();
                $dbiL1VmCommonObj->dbi_cmdbuf_save_cmd(trim($devCode), trim($cmdStr));
                //通过socket向HCU转发命令
                $_GET['DevCode'] = trim($devCode);
                $_GET['respCmd'] = trim($cmdStr);
                require dirname(__FILE__).'/UIClientsync.php';

                //更新视频文件的状态
                $dataflag = MFUN_HCU_VIDEO_DATA_STATUS_DOWNLOAD;
                $query_str = "UPDATE `t_l2snr_hsmmpdata` SET `dataflag` = '$dataflag' WHERE (`deviceid` = '$devCode' AND `videourl` = '$videoid')";
                $result = $mysqli->query($query_str);

                $resp = "downloading";
            }
            elseif ($dataflag == MFUN_HCU_VIDEO_DATA_STATUS_DOWNLOAD){
                //正在下载中又收到该视频文件的请求什么也不做，直接回复
                $resp = "downloading";
            }
            elseif ($dataflag == MFUN_HCU_VIDEO_DATA_STATUS_READY){
                $resp = "http://121.40.185.177/xhzn/avorion/" . $videoid;
            }
            else
                $resp = "";
        }
        else
            $resp = "";

        $mysqli->close();
        return $resp;
    }

    //查询所有可用SW版本
    public function dbi_hcu_allsw_inqury()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l3f4icm_swfactory` WHERE 1");
        $verlist = array();
        if ($result->num_rows > 0)
        {
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            while ($row = $result->fetch_array()) {
                $sw_rel = $apiL2snrCommonServiceObj->byte2string($row["sw_rel"]);
                $sw_drop = $apiL2snrCommonServiceObj->ushort2string($row["sw_drop"]);
                $version = "HCUSW_R" . $sw_rel . ".D" . $sw_drop;
                array_push($verlist, $version);
            }
        }
        $mysqli->close();
        return $verlist;

    }

    //查询指定HCU最新的SW Version
    public function dbi_latest_hcu_swver_inqury($devcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE `devcode` = '$devcode'";
        $result = $mysqli->query($query_str);

        if (($result != false) AND ($result->num_rows)>0) {
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            $row = $result->fetch_array();
            $sw_rel = $apiL2snrCommonServiceObj->byte2string($row["sw_rel"]);
            $sw_drop = $apiL2snrCommonServiceObj->ushort2string($row["sw_drop"]);
            $version = "SW_R" . $sw_rel . ".D" . $sw_drop;
        }
        else
            $version = "";

        $mysqli->close();
        return $version;
    }

    //更新指定设备到指定软件版本
    public function dbi_hcu_swver_update($devlist, $version)
    {
        //生成控制命令的控制字
        $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
        $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_SW_UPDATE);
        $opt_key =  $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_OPT_SWUPDATE_REQ);
        $len = $apiL2snrCommonServiceObj->byte2string(strlen($opt_key)/2 + strlen($version));

        $i = 0;
        while($i < count($devlist)){
            $DevCode = $devlist[$i];
            $respCmd = $ctrl_key . $len . $opt_key . $version;
            $dbiL1vmCommonObj = new classDbiL1vmCommon();
            $resp = $dbiL1vmCommonObj->dbi_cmdbuf_save_cmd(trim($DevCode), trim($respCmd));
            //通过socket向HCU转发命令
            $_GET['DevCode'] = trim($DevCode);
            $_GET['respCmd'] = trim($respCmd);
            require dirname(__FILE__).'/UIClientsync.php';
            $i++;
        }
        return $resp;
    }

    //获取HCU对应软件和数据库bin文件
    public function dbi_hcu_swdb_bin_get($sw_rel, $sw_drop)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $result = $mysqli->query("SELECT * FROM `t_l3f4icm_swfactory` WHERE (`sw_rel` = '$sw_rel' AND `sw_drop` = '$sw_drop')");

        $LatestSwValue = "";
        $LatestDbValue = "";
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $row = $result->fetch_array();
            $LatestSwValue = $row['swbin'];
            $LatestDbValue = $row['dbbin'];
        }

        $result = array("swbin" => $LatestSwValue, "dbbin" => $LatestDbValue);

        $mysqli->close();
        return $result;
    }

    //仪表控制，更新传感器信息,发送传感器参数修改命令
    public function dbi_sensor_info_update($DevCode, $SensorCode, $status,$ParaList)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        $query_str = "SELECT * FROM `t_l3f4icm_sensorctrl` WHERE `deviceid` = '$DevCode' AND `sensortype` = '$SensorCode' ";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0)
        {
            //生成控制命令的控制字
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            if ($SensorCode == MFUN_L3APL_F3DM_S_TYPE_PM) {
                $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_PM25_DATA);
                $equip_id = $apiL2snrCommonServiceObj->byte2string(MFUN_L3APL_F4ICM_ID_EQUIP_PM);
            }
            elseif ($SensorCode == MFUN_L3APL_F3DM_S_TYPE_WINDSPD){
                $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_WINDSPD_DATA);
                $equip_id = $apiL2snrCommonServiceObj->byte2string(MFUN_L3APL_F4ICM_ID_EQUIP_WINDSPD);
            }
            elseif ($SensorCode == MFUN_L3APL_F3DM_S_TYPE_WINDDIR){
                $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_WINDDIR_DATA);
                $equip_id = $apiL2snrCommonServiceObj->byte2string(MFUN_L3APL_F4ICM_ID_EQUIP_WINDDIR);
            }
            elseif ($SensorCode == MFUN_L3APL_F3DM_S_TYPE_EMC){
                $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_EMC_DATA);
                $equip_id = $apiL2snrCommonServiceObj->byte2string(MFUN_L3APL_F4ICM_ID_EQUIP_EMC);
            }
            elseif ($SensorCode == MFUN_L3APL_F3DM_S_TYPE_TEMP){
                $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_TEMP_DATA);
                $equip_id = $apiL2snrCommonServiceObj->byte2string(MFUN_L3APL_F4ICM_ID_EQUIP_TEMP);
            }
            elseif ($SensorCode == MFUN_L3APL_F3DM_S_TYPE_HUMID){
                $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_HUMID_DATA);
                $equip_id = $apiL2snrCommonServiceObj->byte2string(MFUN_L3APL_F4ICM_ID_EQUIP_HUMID);
            }
            elseif ($SensorCode == MFUN_L3APL_F3DM_S_TYPE_NOISE){
                $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_NOISE_DATA);
                $equip_id = $apiL2snrCommonServiceObj->byte2string(MFUN_L3APL_F4ICM_ID_EQUIP_NOISE);
            }
            else{
                $ctrl_key = "";
                $equip_id = "";
            }

            $row = $result->fetch_array();  //这里暂时假定每个设备一种类型的传感器只有一个
            if(!empty($status) AND ($status != $row['onoffstatus']))  //更新传感器开关状态
            {
                $optkey_switch_set = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_MODBUS_SWITCH_SET);
                $resp = $mysqli->query("UPDATE `t_l3f4icm_sensorctrl` SET `onoffstatus` = '$status' WHERE (`deviceid` = '$DevCode' AND `sensortype` = '$SensorCode')");
            }

            $i = 0;
            while($i < count($ParaList))
            {
                $value = $ParaList[$i]['value'];
                if($ParaList[$i]['name'] == "MODBUS_Addr" AND $value != $row['modbus_addr']){
                    $modebus_addr = $value;
                    $optkey_modbus_set = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_MODBUS_ADDR_SET);
                    $query_str = "UPDATE `t_l3f4icm_sensorctrl` SET `modbus_addr` = '$value' WHERE (`deviceid` = '$DevCode' AND `sensortype` = '$SensorCode')";
                    $resp = $mysqli->query($query_str);
                }
                elseif($ParaList[$i]['name'] == "Measurement_Period" AND ($value != $row['meas_period'])){
                    $meas_period = $value;
                    $optkey_period_set = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_MODBUS_PERIOD_SET);
                    $query_str = "UPDATE `t_l3f4icm_sensorctrl` SET `meas_period` = '$value' WHERE (`deviceid` = '$DevCode' AND `sensortype` = '$SensorCode')";
                    $resp = $mysqli->query($query_str);
                }
                elseif($ParaList[$i]['name'] == "Samples_Interval" AND ($value != $row['sample_interval'])){
                    $sample_interval = $value;
                    $optkey_samples_set = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_MODBUS_SAMPLES_SET);
                    $query_str = "UPDATE `t_l3f4icm_sensorctrl` SET `sample_interval` = '$value' WHERE (`deviceid` = '$DevCode' AND `sensortype` = '$SensorCode')";
                    $resp = $mysqli->query($query_str);
                }
                elseif($ParaList[$i]['name'] == "Measurement_Times" AND ($value != $row['meas_times'])){
                    $meas_times = $value;
                    $optkey_times_set = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_MODBUS_TIMES_SET);
                    $query_str = "UPDATE `t_l3f4icm_sensorctrl` SET `meas_times` = '$value' WHERE (`deviceid` = '$DevCode' AND `sensortype` = '$SensorCode')";
                    $resp = $mysqli->query($query_str);
                }
                $i++;
            }
            if(!empty($ctrl_key) AND !empty($optkey_switch_set)){
                if($status == "true")
                    $switch = "01";
                elseif($status == "false")
                    $switch = "00";
                $len = $apiL2snrCommonServiceObj->byte2string(strlen( $optkey_switch_set . $equip_id . $switch)/2);
                $respCmd = $ctrl_key . $len . $optkey_switch_set . $equip_id . $switch;
                $dbiL1vmCommonObj = new classDbiL1vmCommon();
                $resp = $dbiL1vmCommonObj->dbi_cmdbuf_save_cmd(trim($DevCode), trim($respCmd));
                //通过socket向HCU转发命令
                $_GET['DevCode'] = trim($DevCode);
                $_GET['respCmd'] = trim($respCmd);
                require dirname(__FILE__).'/UIClientsync.php';
            }
            if(!empty($ctrl_key)AND !empty($optkey_modbus_set)){
                $modebus_addr = $apiL2snrCommonServiceObj->ushort2string($modebus_addr & 0xFFFF);
                $len = $apiL2snrCommonServiceObj->byte2string(strlen( $optkey_modbus_set . $equip_id . $modebus_addr)/2);
                $respCmd = $ctrl_key . $len . $optkey_modbus_set . $equip_id . $modebus_addr;
                $dbiL1vmCommonObj = new classDbiL1vmCommon();
                $resp = $dbiL1vmCommonObj->dbi_cmdbuf_save_cmd(trim($DevCode), trim($respCmd));
                //通过socket向HCU转发命令
                $_GET['DevCode'] = trim($DevCode);
                $_GET['respCmd'] = trim($respCmd);
                require dirname(__FILE__).'/UIClientsync.php';
            }
            if(!empty($ctrl_key)AND !empty($optkey_period_set)){
                $meas_period = $apiL2snrCommonServiceObj->ushort2string($meas_period & 0xFFFF);
                $len = $apiL2snrCommonServiceObj->byte2string(strlen( $optkey_period_set . $equip_id . $meas_period)/2);
                $respCmd = $ctrl_key . $len . $optkey_period_set . $equip_id . $meas_period;
                $dbiL1vmCommonObj = new classDbiL1vmCommon();
                $resp = $dbiL1vmCommonObj->dbi_cmdbuf_save_cmd(trim($DevCode), trim($respCmd));
                //通过socket向HCU转发命令
                $_GET['DevCode'] = trim($DevCode);
                $_GET['respCmd'] = trim($respCmd);
                require dirname(__FILE__).'/UIClientsync.php';
            }
            if(!empty($ctrl_key) AND !empty($optkey_samples_set)){
                $sample_interval = $apiL2snrCommonServiceObj->ushort2string($sample_interval & 0xFFFF);
                $len = $apiL2snrCommonServiceObj->byte2string(strlen( $optkey_samples_set . $equip_id . $sample_interval)/2);
                $respCmd = $ctrl_key . $len . $optkey_samples_set . $equip_id . $sample_interval;
                $dbiL1vmCommonObj = new classDbiL1vmCommon();
                $resp = $dbiL1vmCommonObj->dbi_cmdbuf_save_cmd(trim($DevCode), trim($respCmd));
                //通过socket向HCU转发命令
                $_GET['DevCode'] = trim($DevCode);
                $_GET['respCmd'] = trim($respCmd);
                require dirname(__FILE__).'/UIClientsync.php';
            }
            if(!empty($ctrl_key) AND !empty($optkey_times_set)){
                $meas_times = $apiL2snrCommonServiceObj->ushort2string($meas_times & 0xFFFF);
                $len = $apiL2snrCommonServiceObj->byte2string(strlen( $optkey_times_set . $equip_id . $meas_times)/2);
                $respCmd = $ctrl_key . $len . $optkey_times_set . $equip_id . $meas_times;
                $dbiL1vmCommonObj = new classDbiL1vmCommon();
                $resp = $dbiL1vmCommonObj->dbi_cmdbuf_save_cmd(trim($DevCode), trim($respCmd));
                //通过socket向HCU转发命令
                $_GET['DevCode'] = trim($DevCode);
                $_GET['respCmd'] = trim($respCmd);
                require dirname(__FILE__).'/UIClientsync.php';
            }

            $resp = "Success";
        }
        else
            $resp = "";
        $mysqli->close();
        return $resp;
    }

}

?>