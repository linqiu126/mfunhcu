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


//该数据表单的逻辑是试图将所有的不同参数组成一个大表，通过SENSOR_ID来记录不同SENSOR的仪表操控状态
//由于不同仪表的潜在操控参数不完全一样，这里是讲所有可能的仪表参数组合成为一个大表，而不再为不同仪表进行区分
//如果涉及到区分，则需要通过具体的dbi函数来完成
//这个表格是否与设备中SENSOR列表相互冲突，待完善

-- --------------------------------------------------------

--
-- 表的结构 `t_l3f4icm_sensorctrl`
--

CREATE TABLE IF NOT EXISTS `t_l3f4icm_sensorctrl` (
  `sid` int(4) NOT NULL,
  `deviceid` char(20) NOT NULL,
  `sensorid` char(20) NOT NULL,
  `modbus_addr` int(1) DEFAULT NULL,
  `sensortype` char(10) NOT NULL,
  `meas_period` int(2) DEFAULT NULL,
  `onoffstatus` char(5) NOT NULL DEFAULT 'off',
  `sample_interval` int(2) DEFAULT NULL,
  `meas_times` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_l3f4icm_sensorctrl`
--
ALTER TABLE `t_l3f4icm_sensorctrl`
  ADD PRIMARY KEY (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_l3f4icm_sensorctrl`
--
ALTER TABLE `t_l3f4icm_sensorctrl`
  MODIFY `sid` int(4) NOT NULL AUTO_INCREMENT;


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
            $dbiL1vmCommonObj = new classDbiL1vmCommon();
            while ($row = $result->fetch_array()) {
                $sw_rel = $dbiL1vmCommonObj->byte2string($row["sw_rel"]);
                $sw_drop = $dbiL1vmCommonObj->ushort2string($row["sw_drop"]);
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
            $dbiL1vmCommonObj = new classDbiL1vmCommon();
            $row = $result->fetch_array();
            $sw_rel = $dbiL1vmCommonObj->byte2string($row["sw_rel"]);
            $sw_drop = $dbiL1vmCommonObj->ushort2string($row["sw_drop"]);
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
        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        $ctrl_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_SW_UPDATE);
        $opt_key =  $dbiL1vmCommonObj->byte2string(MFUN_HCU_OPT_SWUPDATE_REQ);
        $len = $dbiL1vmCommonObj->byte2string(strlen($opt_key)/2 + strlen($version));

        $i = 0;
        while($i < count($devlist)){
            $DevCode = $devlist[$i];
            $respCmd = $ctrl_key . $len . $opt_key . $version;
            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($DevCode, $respCmd);
            $client->connect();
            $i++;
        }
        return $respCmd;
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

    //查询所有可用SW版本
    public function dbi_swver_info_process()
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3f4icm_swfactory` WHERE (`issuedate` = (SELECT MAX(`issuedate`) FROM `t_l3f4icm_swfactory` where `sw_base` = '1' )) AND (`sw_base` = '1')";
        $result = $mysqli->query($query_str);
        $verlist = array();
        if(($result != false) && ($result->num_rows)>0) {
            $row = $result->fetch_array();
            $version = $row['swverdescription']."; 发布日期：".$row['issuedate'];
            array_push($verlist, $version);
        }

        $query_str = "SELECT * FROM `t_l3f4icm_swfactory` WHERE (`issuedate` = (SELECT MAX(`issuedate`) FROM `t_l3f4icm_swfactory` where `sw_base` = '2' )) AND (`sw_base` = '2')";
        $result = $mysqli->query($query_str);
        if(($result != false) && ($result->num_rows)>0) {
            $row = $result->fetch_array();
            $version = $row['swverdescription']."; 发布日期：".$row['issuedate'];
            array_push($verlist, $version);
        }

        $query_str = "SELECT * FROM `t_l3f4icm_swfactory` WHERE (`issuedate` = (SELECT MAX(`issuedate`) FROM `t_l3f4icm_swfactory` where `sw_base` = '3' )) AND (`sw_base` = '3')";
        $result = $mysqli->query($query_str);
        if(($result != false) && ($result->num_rows)>0){
            $row = $result->fetch_array();
            $version = $row['swverdescription']."; 发布日期：".$row['issuedate'];
            array_push($verlist, $version);
        }

        $mysqli->close();
        return $verlist;
    }

    public function dbi_proj_su_strategy_list_process($pcode)
    {
        //初始化返回值
        $strategy_list['ColumnName'] = array();
        $strategy_list['TableData'] = array();

        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        array_push($strategy_list["ColumnName"], "设备编号");
        array_push($strategy_list["ColumnName"], "自动更新");
        array_push($strategy_list["ColumnName"], "硬件版本");
        array_push($strategy_list["ColumnName"], "数据库版本");
        array_push($strategy_list["ColumnName"], "软件版本");
        array_push($strategy_list["ColumnName"], "版本基线");

        $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `p_code` = '$pcode'";
        $result = $mysqli->query($query_str);
        while ($row = $result->fetch_array()) {
            $statcode = $row["statcode"];
            $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE (`statcode` = '$statcode')";
            $resp = $mysqli->query($query_str);
            $one_row = array();
            while($resp_row = $resp->fetch_array()){
                $devcode = $resp_row["devcode"];
                $hw_type = $resp_row["hw_type"];
                $hw_ver = $resp_row["hw_ver"];
                $sw_rel = $resp_row["sw_rel"];
                $hw_drop = $resp_row["sw_drop"];
                $ver_base = $resp_row["ver_base"];
                $db_ver = $resp_row["hcu_db_ver"];
                $auto_update = $resp_row["hcu_sw_autoupdate"];

                array_push($one_row, $devcode);
                if ($auto_update == 1)
                    array_push($one_row, "Y");
                else
                    array_push($one_row, "N");
                array_push($one_row, "HW_"."T".$hw_type.".V".$hw_ver);
                array_push($one_row, "DB_"."V".$db_ver);
                array_push($one_row, "SW_"."R".$sw_rel.".D".$hw_drop);
                if ($ver_base == 1)
                    array_push($one_row, "稳定版");
                elseif($ver_base == 2)
                    array_push($one_row, "测试版");
                else
                    array_push($one_row, "补丁版");
            }
            array_push($strategy_list['TableData'] , $one_row);
        }

        $mysqli->close();
        return $strategy_list;
    }

    public function dbi_proj_swbase_change_process($pcode, $sw_base)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "UPDATE `t_l3f2cm_projinfo` SET `sw_base` = '$sw_base' WHERE (`p_code` = '$pcode')";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    public function dbi_dev_su_strategy_change_process($statCode, $autoUpdate)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if ($autoUpdate == true)
            $autoUpdate = 1;
        else
            $autoUpdate = 0;

        $query_str = "UPDATE `t_l2sdk_iothcu_inventory` SET `hcu_sw_autoupdate` = '$autoUpdate', `hcu_db_autoupdate` = '$autoUpdate' WHERE (`statcode` = '$statCode')";
        $result = $mysqli->query($query_str);

        $mysqli->close();
        return $result;
    }

    public function dbi_proj_su_strategy_change_process($projCode, $autoUpdate)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if ($autoUpdate == true)
            $autoUpdate = 1;
        else
            $autoUpdate = 0;

        $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE (`p_code` = '$projCode')";
        $result = $mysqli->query($query_str);
        while ($row = $result->fetch_array()){
            $statCode = $row['statcode'];
            $query_str = "UPDATE `t_l2sdk_iothcu_inventory` SET `hcu_sw_autoupdate` = '$autoUpdate', `hcu_db_autoupdate` = '$autoUpdate' WHERE (`statcode` = '$statCode')";
            $resp = $mysqli->query($query_str);
        }

        $mysqli->close();
        return $result;
    }

    public function dbi_proj_su_strategy_get_process($projCode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $sw_base = "";
        $query_str = "SELECT * FROM `t_l3f2cm_projinfo` WHERE (`p_code` = '$projCode')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0){
            $row = $result->fetch_array();
            $sw_base = $row['sw_base'];
        }

        $mysqli->close();
        return $sw_base;
    }

    //仪表控制，更新传感器信息,发送传感器参数修改命令
    public function dbi_sensor_info_update($input)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if (isset($input["DevCode"])) $DevCode = trim($input["DevCode"]); else  $DevCode = "";
        if (isset($input["SensorCode"])) $SensorCode = trim($input["SensorCode"]); else  $SensorCode = "";
        if (isset($input["status"])) $status = trim($input["status"]); else  $status = "";
        if (isset($input["ParaList"])) $ParaList = $input["ParaList"]; else  $ParaList = array();

        $query_str = "SELECT * FROM `t_l3f4icm_sensorctrl` WHERE `deviceid` = '$DevCode' AND `sensortype` = '$SensorCode' ";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0)
        {
            //生成控制命令的控制字
            $dbiL1vmCommonObj = new classDbiL1vmCommon();
            if ($SensorCode == MFUN_L3APL_F3DM_AQYC_STYPE_PM) {
                $ctrl_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_PM25_DATA);
                $equip_id = $dbiL1vmCommonObj->byte2string(MFUN_L3APL_F4ICM_ID_EQUIP_PM);
            }
            elseif ($SensorCode == MFUN_L3APL_F3DM_AQYC_STYPE_WINDSPD){
                $ctrl_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_WINDSPD_DATA);
                $equip_id = $dbiL1vmCommonObj->byte2string(MFUN_L3APL_F4ICM_ID_EQUIP_WINDSPD);
            }
            elseif ($SensorCode == MFUN_L3APL_F3DM_AQYC_STYPE_WINDDIR){
                $ctrl_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_WINDDIR_DATA);
                $equip_id = $dbiL1vmCommonObj->byte2string(MFUN_L3APL_F4ICM_ID_EQUIP_WINDDIR);
            }
            elseif ($SensorCode == MFUN_L3APL_F3DM_AQYC_STYPE_EMC){
                $ctrl_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_EMC_DATA);
                $equip_id = $dbiL1vmCommonObj->byte2string(MFUN_L3APL_F4ICM_ID_EQUIP_EMC);
            }
            elseif ($SensorCode == MFUN_L3APL_F3DM_AQYC_STYPE_TEMP){
                $ctrl_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_TEMP_DATA);
                $equip_id = $dbiL1vmCommonObj->byte2string(MFUN_L3APL_F4ICM_ID_EQUIP_TEMP);
            }
            elseif ($SensorCode == MFUN_L3APL_F3DM_AQYC_STYPE_HUMID){
                $ctrl_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_HUMID_DATA);
                $equip_id = $dbiL1vmCommonObj->byte2string(MFUN_L3APL_F4ICM_ID_EQUIP_HUMID);
            }
            elseif ($SensorCode == MFUN_L3APL_F3DM_AQYC_STYPE_NOISE){
                $ctrl_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_NOISE_DATA);
                $equip_id = $dbiL1vmCommonObj->byte2string(MFUN_L3APL_F4ICM_ID_EQUIP_NOISE);
            }
            else{
                $ctrl_key = "";
                $equip_id = "";
            }

            $row = $result->fetch_array();  //这里暂时假定每个设备一种类型的传感器只有一个
            if(!empty($status) AND ($status != $row['onoffstatus']))  //更新传感器开关状态
            {
                $optkey_switch_set = $dbiL1vmCommonObj->byte2string(MFUN_HCU_MODBUS_SWITCH_SET);
                $resp = $mysqli->query("UPDATE `t_l3f4icm_sensorctrl` SET `onoffstatus` = '$status' WHERE (`deviceid` = '$DevCode' AND `sensortype` = '$SensorCode')");
            }

            $i = 0;
            while($i < count($ParaList))
            {
                $value = $ParaList[$i]['value'];
                if($ParaList[$i]['name'] == "MODBUS_Addr" AND $value != $row['modbus_addr']){
                    $modebus_addr = $value;
                    $optkey_modbus_set = $dbiL1vmCommonObj->byte2string(MFUN_HCU_MODBUS_ADDR_SET);
                    $query_str = "UPDATE `t_l3f4icm_sensorctrl` SET `modbus_addr` = '$value' WHERE (`deviceid` = '$DevCode' AND `sensortype` = '$SensorCode')";
                    $resp = $mysqli->query($query_str);
                }
                elseif($ParaList[$i]['name'] == "Measurement_Period" AND ($value != $row['meas_period'])){
                    $meas_period = $value;
                    $optkey_period_set = $dbiL1vmCommonObj->byte2string(MFUN_HCU_MODBUS_PERIOD_SET);
                    $query_str = "UPDATE `t_l3f4icm_sensorctrl` SET `meas_period` = '$value' WHERE (`deviceid` = '$DevCode' AND `sensortype` = '$SensorCode')";
                    $resp = $mysqli->query($query_str);
                }
                elseif($ParaList[$i]['name'] == "Samples_Interval" AND ($value != $row['sample_interval'])){
                    $sample_interval = $value;
                    $optkey_samples_set = $dbiL1vmCommonObj->byte2string(MFUN_HCU_MODBUS_SAMPLES_SET);
                    $query_str = "UPDATE `t_l3f4icm_sensorctrl` SET `sample_interval` = '$value' WHERE (`deviceid` = '$DevCode' AND `sensortype` = '$SensorCode')";
                    $resp = $mysqli->query($query_str);
                }
                elseif($ParaList[$i]['name'] == "Measurement_Times" AND ($value != $row['meas_times'])){
                    $meas_times = $value;
                    $optkey_times_set = $dbiL1vmCommonObj->byte2string(MFUN_HCU_MODBUS_TIMES_SET);
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
                $len = $dbiL1vmCommonObj->byte2string(strlen( $optkey_switch_set . $equip_id . $switch)/2);
                $respCmd = $ctrl_key . $len . $optkey_switch_set . $equip_id . $switch;

                //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
                $client = new socket_client_sync($DevCode, $respCmd);
                $client->connect();

            }
            if(!empty($ctrl_key)AND !empty($optkey_modbus_set)){
                $modebus_addr = $dbiL1vmCommonObj->ushort2string($modebus_addr & 0xFFFF);
                $len = $dbiL1vmCommonObj->byte2string(strlen( $optkey_modbus_set . $equip_id . $modebus_addr)/2);
                $respCmd = $ctrl_key . $len . $optkey_modbus_set . $equip_id . $modebus_addr;
                //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
                $client = new socket_client_sync($DevCode, $respCmd);
                $client->connect();
            }
            if(!empty($ctrl_key)AND !empty($optkey_period_set)){
                $meas_period = $dbiL1vmCommonObj->ushort2string($meas_period & 0xFFFF);
                $len = $dbiL1vmCommonObj->byte2string(strlen( $optkey_period_set . $equip_id . $meas_period)/2);
                $respCmd = $ctrl_key . $len . $optkey_period_set . $equip_id . $meas_period;
                //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
                $client = new socket_client_sync($DevCode, $respCmd);
                $client->connect();
            }
            if(!empty($ctrl_key) AND !empty($optkey_samples_set)){
                $sample_interval = $dbiL1vmCommonObj->ushort2string($sample_interval & 0xFFFF);
                $len = $dbiL1vmCommonObj->byte2string(strlen( $optkey_samples_set . $equip_id . $sample_interval)/2);
                $respCmd = $ctrl_key . $len . $optkey_samples_set . $equip_id . $sample_interval;
                //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
                $client = new socket_client_sync($DevCode, $respCmd);
                $client->connect();
            }
            if(!empty($ctrl_key) AND !empty($optkey_times_set)){
                $meas_times = $dbiL1vmCommonObj->ushort2string($meas_times & 0xFFFF);
                $len = $dbiL1vmCommonObj->byte2string(strlen( $optkey_times_set . $equip_id . $meas_times)/2);
                $respCmd = $ctrl_key . $len . $optkey_times_set . $equip_id . $meas_times;
                //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
                $client = new socket_client_sync($DevCode, $respCmd);
                $client->connect();
            }

            $resp = "Success";
        }
        else
            $resp = "";
        $mysqli->close();
        return $resp;
    }

    public function dbi_get_hcu_camweb_link($statcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $port = "";
        $camweb = array();
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE `statcode` = '$statcode'";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            $port = $row['rtsp_port'];
            $cam_ctrl = $row['camctrl'];

            //$rtsp = $row['videourl'];  //老的直接调用rtsp link的方法，在http上OK，换成https后用下面的方法
            $rtsp = "./video/video_jump.php?rtsp_port=".$port;

            $camweb = array('video'=>$rtsp, 'camera'=>$cam_ctrl);
        }

        $mysqli->close();
        return $camweb;
    }

    public function dbi_hcu_picturelist_inqury($statcode, $date, $hour)
    {
        //查询监测点下的设备列表
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $start = $hour * 60;
        $end = $hour * 60 + 59;
        $picturelist = array();
        $query_str = "SELECT * FROM `t_l2snr_picturedata` WHERE (`statcode` = '$statcode' AND `reportdate` = '$date' AND `hourminindex` >= '$start' AND `hourminindex` < '$end')";
        $result = $mysqli->query($query_str);
        while(($result != false) AND ($row = $result->fetch_array())){
            //提取照片名中的时间戳
            $pic_name = $row['filename'];
            $str_temp = strstr($pic_name,MFUN_HCU_SITE_PIC_FILE_TYPE,true);
            $str_pos = strripos($str_temp,"_");
            $timeStamp = intval(substr($str_temp, $str_pos+1));
            $stamp = getdate($timeStamp);

            $pictureUrl = MFUN_HCU_SITE_PIC_WWW_FOLDER.$statcode.'/'.$pic_name;
            $attr = '照片_'.$date.'_'.$stamp['hours'].":".$stamp["minutes"].":".$stamp["seconds"];
            $temp = array('id'=> $pictureUrl,'attr'=> $attr);
            array_push($picturelist, $temp);
        }

        $mysqli->close();
        return $picturelist;
    }

    public function dbi_hcu_vedioplay_request($videoid)
    {
        //查询该视频文件当前状态，是否已经下载，是否正在下载
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l2snr_hsmmpdata` WHERE `videourl` = '$videoid' ";
        $result = $mysqli->query($query_str);
        if (($result->num_rows)>0) {
            $row = $result->fetch_array();
            $dataflag = $row["dataflag"];
            $devCode = $row["deviceid"];
            $dbiL1vmCommonObj = new classDbiL1vmCommon();
            if ($dataflag == MFUN_HCU_VIDEO_DATA_STATUS_NORMAL OR $dataflag == MFUN_HCU_VIDEO_DATA_STATUS_FAIL){
                $ctrl_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_HSMMP_DATA);
                $opt_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_OPT_VEDIOFILE_REQ);
                $len = $dbiL1vmCommonObj->byte2string(strlen( $opt_key)/2 + strlen($videoid));
                $cmdStr = $ctrl_key . $len . $opt_key . $videoid;

                //更新视频文件的状态
                $dataflag = MFUN_HCU_VIDEO_DATA_STATUS_DOWNLOAD;
                $query_str = "UPDATE `t_l2snr_hsmmpdata` SET `dataflag` = '$dataflag' WHERE (`deviceid` = '$devCode' AND `videourl` = '$videoid')";
                $result = $mysqli->query($query_str);

                //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
                $client = new socket_client_sync($devCode, $cmdStr);
                $client->connect();

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

    //Camera状态更新，取回当前照片
    public function dbi_get_camera_status($statCode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
        die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //根据StatCode查找特定HCU
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE `statcode` = '$statCode' ";
        $result = $mysqli->query($query_str);

        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $result->fetch_array();  //statcode和devcode一一对应
            $url = $row['camctrl'];

            $filename = ""; //初始化
            $username = MFUN_HCU_AQYC_CAM_USERNAME;
            $password = MFUN_HCU_AQYC_CAM_PASSWORD;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
            curl_setopt($curl, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
            $picdata = curl_exec($curl);
            $filesize = curl_getinfo($curl, CURLINFO_SIZE_DOWNLOAD);
            curl_close($curl);

            if ($filesize != 0){
                if(!file_exists(MFUN_HCU_SITE_PIC_BASE_DIR.$statCode))
                    $result = mkdir(MFUN_HCU_SITE_PIC_BASE_DIR.$statCode,0777,true);
                $timestamp = time();
                $filename = $statCode . "_" . $timestamp; //生成jpg文件名
                $picname = $filename . MFUN_HCU_SITE_PIC_FILE_TYPE;

                $filelink = MFUN_HCU_SITE_PIC_BASE_DIR.$statCode.'/'.$picname;
                $newfile = fopen($filelink, "wb+") or die("Unable to open file!");
                fwrite($newfile, $picdata);
                fclose($newfile);

                //保存照片信息
                $date = date("Y-m-d", $timestamp);
                $stamp = getdate($timestamp);
                $hourminindex = intval(($stamp["hours"] * 60 + floor($stamp["minutes"]/MFUN_TIME_GRID_SIZE)));
                $filetype = MFUN_HCU_SITE_PIC_FILE_TYPE;
                $filesize = (int)$filesize;
                $description = "站点".$statCode."上传的照片";
                $dataflag = "Y";
                $query_str = "INSERT INTO `t_l2snr_picturedata` (statcode,filename,filetype,filesize,filedescription,reportdate,hourminindex,dataflag) VALUES ('$statCode','$filename','$filetype','$filesize','$description','$date','$hourminindex','$dataflag')";
                $result=$mysqli->query($query_str);
            }

            $resp = array("v"=>"120~","h"=>"120~","zoom"=>"5","url"=>MFUN_HCU_SITE_PIC_WWW_FOLDER.$filename);
        }
        else
            $resp = array();

        $mysqli->close();
        return $resp;
    }

    //TBSWR gettempstatus
    public function dbi_tbswr_gettempstatus($uid, $statCode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //根据StatCode查找特定HCU
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE `statcode` = '$statCode' ";
        $result = $mysqli->query($query_str);

        if (($result != false) && ($result->num_rows)>0)
        {
            //生成控制命令的控制字
            $dbiL1vmCommonObj = new classDbiL1vmCommon();
            $ctrl_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_TEMP_DATA);
            $opt_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_OPT_STATUS_REQ);

            $row = $result->fetch_array();  //statcode和devcode一一对应
            $DevCode = $row['devcode'];

            $len = $dbiL1vmCommonObj->byte2string(strlen($opt_key)/2);
            $respCmd = $ctrl_key . $len . $opt_key;

            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($DevCode, $respCmd);
            $client->connect();

            $resp = "Success";
        }
        else
            $resp = "";
        $mysqli->close();
        return $resp;
    }

    /*********************************智能云锁新增处理 Start*********************************************/
    public function dbi_hcu_lock_compel_open($sessionid, $statCode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3f1sym_session` WHERE (`sessionid` = '$sessionid')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0){
            $row = $result->fetch_array();
            $uid = $row["uid"];
        }

        $keyid = "";
        $key_type = MFUN_L3APL_F2CM_KEY_TYPE_USER;
        $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`hwcode` = '$uid' AND `keytype` = '$key_type')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0){
            $row = $result->fetch_array();
            $keyid = $row["keyid"];
        }


        //插入一条开锁授权
        $authlevel = MFUN_L3APL_F2CM_AUTH_LEVEL_DEVICE;
        $authtype = MFUN_L3APL_F2CM_AUTH_TYPE_NUMBER;
        $validnum = 1; //单次授权

        $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyauth` WHERE (`keyid` = '$keyid' AND `authobjcode` = '$statCode' AND `authtype` = '$authtype')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0){
            $row = $result->fetch_array();
            $validnum = $row['validnum'] + 1;
            $query_str = "UPDATE `t_l3f2cm_fhys_keyauth` SET `validnum` = '$validnum' WHERE (`keyid` = '$keyid' AND `authobjcode` = '$statCode' AND `authtype` = '$authtype')";
            $result = $mysqli->query($query_str);
        }
        else
        {
            $query_str = "INSERT INTO `t_l3f2cm_fhys_keyauth` (keyid, authlevel, authobjcode, authtype, validnum)
                                  VALUES ('$keyid','$authlevel','$statCode','$authtype','$validnum')";
            $result = $mysqli->query($query_str);
        }


        //确认要操作的设备在 HCU Inventory表中是否存在
        /*
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE (`statcode` = '$statCode')";
        $result = $mysqli->query($query_str);

        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $devCode = $row["devcode"];
            //生成控制命令的控制字
            $dbiL1vmCommonObj = new classDbiL1vmCommon();
            $ctrl_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_FHYS_LOCK);
            $opt_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_OPT_FHYS_FORCE_LOCKOPEN_CMD);
            $para = $dbiL1vmCommonObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_OPEN);

            $len = $dbiL1vmCommonObj->byte2string(strlen($opt_key.$para)/2);
            $respCmd = $ctrl_key . $len . $opt_key . $para;

            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($devCode, $respCmd);
            $client->connect();
            $resp = "Lock open with UI command send success";
        }
        else
            $resp = "Lock open with UI command send failure";
        */

        $mysqli->close();
        return $result;
    }

    /*********************************BFSC组合秤新增处理 Start*********************************************/
    public function dbi_hcu_weight_compel_open($sessionid, $statCode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3f1sym_session` WHERE (`sessionid` = '$sessionid')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0){
            $row = $result->fetch_array();
            $uid = $row["uid"];
        }


        //确认要操作的设备在 HCU Inventory表中是否存在

        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE (`statcode` = '$statCode')";
        $result = $mysqli->query($query_str);

        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $devCode = $row["devcode"];
            //生成控制命令的控制字
            $respCmd = "3B020200";

            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($devCode, $respCmd);
            $client->connect();
            $resp = "BFSC weight open success";
        }
        else
            $resp = "BFSC weight open failure";


        $mysqli->close();
        return $resp;
    }

    public function dbi_hcu_weight_compel_close($sessionid, $statCode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $query_str = "SELECT * FROM `t_l3f1sym_session` WHERE (`sessionid` = '$sessionid')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0){
            $row = $result->fetch_array();
            $uid = $row["uid"];
        }


        //确认要操作的设备在 HCU Inventory表中是否存在

        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE (`statcode` = '$statCode')";
        $result = $mysqli->query($query_str);

        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $devCode = $row["devcode"];
            //生成控制命令的控制字
            $respCmd = "3B020300";

            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($devCode, $respCmd);
            $client->connect();
            $resp = "BFSC weight close success";
        }
        else
            $resp = "BFSC weight close failure";


        $mysqli->close();
        return $resp;
    }

}

?>
