<?php
/**
 * Created by PhpStorm.
 * User: zehongl
 * Date: 2016/11/7
 * Time: 21:35
 */

class classDbiL2snrDoorlock
{
    private function getRandomKeyid($strlen)
    {

        $str = "";
        $str_pol = "0123456789";
        $max = strlen($str_pol) - 1;
        for ($i = 0; $i < $strlen; $i++) {
            $str .= $str_pol[mt_rand(0, $max)];
        }
        return $str;
    }

    private function dbi_hcu_event_log_process($mysqli, $keyid, $statcode, $eventtype,$picname)
    {
        //确认钥匙是否存在
        $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`keyid` = '$keyid')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $keyname = $row['keyname'];
            $keyuserid = $row['keyuserid'];
            $keyusername = $row['keyusername'];
        }
        else{
            $keyid = "NA";
            $keyname = "NA";
            $keyuserid = "NA";
            $keyusername = "NA";
        }

        $lasttime = 0;
        //查询该站点的最后一次开锁事件记录
        $query_str = "SELECT * FROM `t_l3fxprcm_fhys_locklog` WHERE `sid`= (SELECT MAX(sid) FROM `t_l3fxprcm_fhys_locklog` WHERE `statcode`= '$statcode' )";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0) {
            $row = $row = $result->fetch_array();
            $last_event = $row['createtime'];
            $lasttime = strtotime($last_event);
            $event_id = $row['sid'];
        }
        $timestamp = time();
        $currenttime = date("Y-m-d H:i:s",$timestamp);

        if ($timestamp < ($lasttime + MFUN_HCU_FHYS_SLEEP_DURATION)) {
            $query_str = "UPDATE `t_l3fxprcm_fhys_locklog` SET `keyid` = '$keyid',`keyname` = '$keyname',`keyuserid` = '$keyuserid',`keyusername` = '$keyusername'
                                 `eventtype` = '$eventtype',`createtime` = '$currenttime',`picname` = '$picname'  WHERE (`sid` = '$event_id')";
            $result = $mysqli->query($query_str);
        }
        else{
            $query_str = "INSERT INTO `t_l3fxprcm_fhys_locklog` (keyid,keyname,keyuserid,keyusername,eventtype,statcode,createtime,picname)
                              VALUES ('$keyid','$keyname','$keyuserid', '$keyusername', '$eventtype', '$statcode', '$currenttime', '$picname')";
            $result = $mysqli->query($query_str);
        }

        return $result;
    }

    private function dbi_hcu_lock_keyauth_check($mysqli, $keyid, $statcode)
    {
        $auth_check = false;
        $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyauth` WHERE (`keyid` = '$keyid')";
        $result = $mysqli->query($query_str);
        while ($row = $result->fetch_array())
        {
            $sid = $row['sid'];
            $authlevel = $row['authlevel'];
            $authobjcode = $row['authobjcode'];
            $authtype = $row['authtype'];
            $validnum = $row['validnum'];
            $validend = $row['validend'];

            //如果该钥匙授权是项目级授权，查询该站点是否属于授权项目
            if ($authlevel == MFUN_L3APL_F2CM_AUTH_LEVEL_PROJ)
            {
                $query_str = " SELECT * FROM `t_l3f3dm_siteinfo` WHERE (`statcode` = '$statcode' AND `p_code` = '$authobjcode' ) ";
                $resp = $mysqli->query($query_str);
                if (($resp != false) && ($resp->num_rows)>0)
                    $authobjcode = $statcode;
            }

            if ($authobjcode == $statcode)
            {
                switch ($authtype)
                {
                    case MFUN_L3APL_F2CM_AUTH_TYPE_NUMBER:
                        //防止用户重复点击，对于用户名开锁，只保留一次开锁
                        if($validnum > 0){
                            $query_str = "DELETE FROM `t_l3f2cm_fhys_keyauth` WHERE (`sid` = '$sid') ";
                            $resp = $mysqli->query($query_str);
                            $auth_check = true;
                        }
                        /*
                        $remain_validnum = $validnum - 1;
                        if ($remain_validnum == 0){
                            $query_str = "DELETE FROM `t_l3f2cm_fhys_keyauth` WHERE (`sid` = '$sid') ";
                            $resp = $mysqli->query($query_str);
                            $auth_check = true;
                        }
                        else{
                            $query_str = "UPDATE `t_l3f2cm_fhys_keyauth` SET  `validnum` = '$remain_validnum' WHERE (`sid` = '$sid')";
                            $resp = $mysqli->query($query_str);
                            $auth_check = true;
                        }*/
                        break;
                    case MFUN_L3APL_F2CM_AUTH_TYPE_TIME:
                        $timestamp = time();
                        $current_date = intval(date("Ymd", $timestamp));
                        $validend = intval(date('Ymd',strtotime($validend)));
                        if ($current_date > $validend){
                            $query_str = "DELETE FROM `t_l3f2cm_fhys_keyauth` WHERE (`sid` = '$sid') ";
                            $resp = $mysqli->query($query_str);
                            $auth_check = false;
                        }
                        else
                            $auth_check = true;
                        break;
                    case MFUN_L3APL_F2CM_AUTH_TYPE_FOREVER:
                        $auth_check = true;
                        break;
                    default:
                        $auth_check = false;
                        break;
                }
            }
            else
                $auth_check = false;

            if ($auth_check == true) //如何验证授权通过就直接返回，否则继续遍历
                return $auth_check;
        }
        return $auth_check;
    }

    public function dbi_fhys_doorlock_status_process($devCode, $statcode, $data)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //初始化告警信息
        $alarm_code = MFUN_HCU_FHYS_ALARM_NONE;
        $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_0;
        //消息解码
        $format = "A2lock1/A2lock2/A2door1/A2door2/A2rfid/A2ble/A2rssi/A2batt/A4temp/A4humid/A2shake/A2smoke/A2water/A2fall";
        $msg= unpack($format, $data);

        //为了控制单站点的告警数量，根据客户要求，如果某个站点同时出多个告警只报告最高优先限级的告警
        //烟雾
        if ($msg['smoke'] == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $smokeState = HUITP_IEID_UNI_SMOKE_STATE_DEACTIVE;
        elseif ($msg['smoke'] == MFUN_HCU_DATA_FHYS_STATUS_NOK){
            $smokeState = HUITP_IEID_UNI_SMOKE_STATE_ACTIVE;
            $alarm_code = MFUN_HCU_FHYS_ALARM_SMOK;
            $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_L;
        }
        else
            $smokeState = HUITP_IEID_UNI_SMOKE_STATE_INVALID;
        //倾斜
        if ($msg['fall'] == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $fallState = HUITP_IEID_UNI_FALL_STATE_DEACTIVE;
        elseif ($msg['fall'] == MFUN_HCU_DATA_FHYS_STATUS_NOK){
            $fallState = HUITP_IEID_UNI_FALL_STATE_ACTIVE;
            $alarm_code = MFUN_HCU_FHYS_ALARM_TILT;
            $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_L;
        }
        else
            $fallState = HUITP_IEID_UNI_FALL_STATE_INVALID;
        //震动
        if ($msg['shake'] == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $shakeState = HUITP_IEID_UNI_SHAKE_STATE_DEACTIVE;
        elseif ($msg['shake'] == MFUN_HCU_DATA_FHYS_STATUS_NOK){
            $shakeState = HUITP_IEID_UNI_SHAKE_STATE_ACTIVE;
            $alarm_code = MFUN_HCU_FHYS_ALARM_VIBR;
            $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_M;
        }
        else
            $shakeState = HUITP_IEID_UNI_SHAKE_STATE_INVALID;
        //水浸
        if ($msg['water'] == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $waterState = HUITP_IEID_UNI_WATER_STATE_DEACTIVE;
        elseif ($msg['water'] == MFUN_HCU_DATA_FHYS_STATUS_NOK){
            $waterState = HUITP_IEID_UNI_WATER_STATE_ACTIVE;
            $alarm_code = MFUN_HCU_FHYS_ALARM_WATER;
            $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_M;
        }
        else
            $waterState = HUITP_IEID_UNI_WATER_STATE_INVALID;

        //GPRS信号强度
        $rssiValue =hexdec($msg['rssi']) & 0xFF;
        //电量
        $battValue = hexdec($msg['batt']);
        if ($battValue > MFUN_L3APL_F3DM_TH_ALARM_BATT)
            $battState = HUITP_IEID_UNI_BAT_STATE_NORMAL;
        else{
            $battState = HUITP_IEID_UNI_BAT_STATE_WARNING;
            $alarm_code = MFUN_HCU_FHYS_ALARM_LOW_BATT;
            $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_H;
        }

        //温度,16进制的字符，高2位为整数部分，低2位为小数部分
        $temp_h = hexdec(substr($msg['temp'], 0, 2)) & 0xFF;
        $temp_l = hexdec(substr($msg['temp'], 2, 2)) & 0xFF;
        $tempValue = $temp_h + $temp_l/100;
        //湿度,16进制的字符，高2位为整数部分，低2位为小数部分
        $humid_h = hexdec(substr($msg['humid'], 0, 2)) & 0xFF;
        $humid_l = hexdec(substr($msg['humid'], 2, 2)) & 0xFF;
        $humidValue = $humid_h + $humid_l/100;

        if ($msg['door1'] == MFUN_HCU_DATA_FHYS_STATUS_OK){
            $lock_1 = HUITP_IEID_UNI_LOCK_STATE_CLOSE;
            $door_1 = HUITP_IEID_UNI_DOOR_STATE_CLOSE;
            $reportType = HUITP_IEID_UNI_CCL_REPORT_TYPE_CLOSE_EVENT;
        }
        elseif ($msg['door1'] == MFUN_HCU_DATA_FHYS_STATUS_NOK){
            $lock_1 = HUITP_IEID_UNI_LOCK_STATE_OPEN;
            $door_1 = HUITP_IEID_UNI_DOOR_STATE_OPEN;
            $reportType = HUITP_IEID_UNI_CCL_REPORT_TYPE_PERIOD_EVENT;
        }
        elseif($msg['door1'] == MFUN_HCU_DATA_FHYS_STATUS_NULL){
            $lock_1 = HUITP_IEID_UNI_LOCK_STATE_NULL;
            $door_1 = HUITP_IEID_UNI_DOOR_STATE_NULL;
            $reportType = HUITP_IEID_UNI_CCL_REPORT_TYPE_PERIOD_EVENT;
        }
        elseif($msg['door1'] == MFUN_HCU_DATA_FHYS_STATUS_ALARM){
            $lock_1 = HUITP_IEID_UNI_LOCK_STATE_OPEN;
            $door_1 = HUITP_IEID_UNI_DOOR_STATE_OPEN;
            $reportType = HUITP_IEID_UNI_CCL_REPORT_TYPE_FAULT_EVENT;
            $alarm_code = MFUN_HCU_FHYS_ALARM_DOOR1_OPEN;
            $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_H;
        }
        else{
            $lock_1 =HUITP_IEID_UNI_LOCK_STATE_INVALID;
            $door_1 =HUITP_IEID_UNI_DOOR_STATE_INVALID;
            $reportType = HUITP_IEID_UNI_CCL_REPORT_TYPE_PERIOD_EVENT;
        }

        if ($msg['door2'] == MFUN_HCU_DATA_FHYS_STATUS_OK){
            $lock_2 = HUITP_IEID_UNI_LOCK_STATE_CLOSE;
            $door_2 = HUITP_IEID_UNI_DOOR_STATE_CLOSE;
            $reportType = HUITP_IEID_UNI_CCL_REPORT_TYPE_CLOSE_EVENT;
        }
        elseif ($msg['door2'] == MFUN_HCU_DATA_FHYS_STATUS_NOK){
            $lock_2 = HUITP_IEID_UNI_LOCK_STATE_OPEN;
            $door_2 = HUITP_IEID_UNI_DOOR_STATE_OPEN;
            $reportType = HUITP_IEID_UNI_CCL_REPORT_TYPE_PERIOD_EVENT;
        }
        elseif($msg['door2'] == MFUN_HCU_DATA_FHYS_STATUS_NULL){
            $lock_2 = HUITP_IEID_UNI_LOCK_STATE_NULL;
            $door_2 = HUITP_IEID_UNI_DOOR_STATE_NULL;
            $reportType = HUITP_IEID_UNI_CCL_REPORT_TYPE_PERIOD_EVENT;
        }
        elseif($msg['door2'] == MFUN_HCU_DATA_FHYS_STATUS_ALARM){
            $lock_2 = HUITP_IEID_UNI_LOCK_STATE_OPEN;
            $door_2 = HUITP_IEID_UNI_DOOR_STATE_OPEN;
            $reportType = HUITP_IEID_UNI_CCL_REPORT_TYPE_FAULT_EVENT;
            $alarm_code = MFUN_HCU_FHYS_ALARM_DOOR2_OPEN;
            $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_H;
        }
        else{
            $lock_2 =HUITP_IEID_UNI_LOCK_STATE_INVALID;
            $door_2 =HUITP_IEID_UNI_DOOR_STATE_INVALID;
            $reportType = HUITP_IEID_UNI_CCL_REPORT_TYPE_PERIOD_EVENT;
        }

        $timestamp = time();
        $reportdate = date("Y-m-d", $timestamp);
        $temp = getdate($timestamp);
        $hourminindex = intval(($temp["hours"] * 60 + floor($temp["minutes"]/MFUN_HCU_FHYS_TIME_GRID_SIZE)));
        //更新分钟报告表
        $query_str ="SELECT * FROM `t_l2snr_fhys_minreport` WHERE (( `devcode` = '$devCode' AND `statcode` = '$statcode') AND (`reportdate` = '$reportdate' AND `hourminindex` = '$hourminindex'))";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $query_str = "UPDATE `t_l2snr_fhys_minreport` SET `reporttype` = '$reportType',`door_1` = '$door_1',`door_2` = '$door_2',`lock_1` = '$lock_1',`lock_2` = '$lock_2',`battstate` = '$battState',`waterstate` = '$waterState',
                          `shakestate` = '$shakeState',`fallstate` = '$fallState',`smokestate` = '$smokeState',`battvalue` = '$battValue',`tempvalue` = '$tempValue',`humidvalue` = '$humidValue',`rssivalue` = '$rssiValue'
                            WHERE (`devcode` = '$devCode' AND `statcode` = '$statcode' AND `reportdate` = '$reportdate' AND `hourminindex` = '$hourminindex')";
            $result = $mysqli->query($query_str);
        }
        else
        {
            $query_str = "INSERT INTO `t_l2snr_fhys_minreport` (devcode,statcode,reportdate,hourminindex,reporttype,door_1,door_2,lock_1,lock_2,battstate,waterstate,shakestate,fallstate,smokestate,battvalue,tempvalue,humidvalue,rssivalue)
                            VALUES ('$devCode','$statcode','$reportdate','$hourminindex','$reportType','$door_1','$door_2','$lock_1','$lock_2','$battState','$waterState','$shakeState','$fallState','$smokeState','$battValue','$tempValue','$humidValue','$rssiValue')";
            $result = $mysqli->query($query_str);
        }

        //更新当前聚合表
        $currenttime = date("Y-m-d H:i:s",$timestamp);
        $result = $mysqli->query("SELECT * FROM `t_l3f3dm_fhys_currentreport` WHERE (`devcode` = '$devCode') ");
        if (($result->num_rows)>0) {
            //集中器传感器问题的workaround，有时候温湿度传感器会偶尔读数不正常，同时为0，这时候保持温湿度值不更新。
            if($tempValue == 0 AND $humidValue == 0){
                $query_str = "UPDATE `t_l3f3dm_fhys_currentreport` SET `statcode` = '$statcode',`createtime` = '$currenttime',`reporttype` = '$reportType',`door_1` = '$door_1',`door_2` = '$door_2',`lock_1` = '$lock_1',`lock_2` = '$lock_2',`battstate` = '$battState',
                          `waterstate` = '$waterState',`shakestate` = '$shakeState',`fallstate` = '$fallState',`smokestate` = '$smokeState',`battvalue` = '$battValue',`rssivalue` = '$rssiValue'
                            WHERE (`devcode` = '$devCode')";
                $result = $mysqli->query($query_str);
            }
            else{
                $query_str = "UPDATE `t_l3f3dm_fhys_currentreport` SET `statcode` = '$statcode',`createtime` = '$currenttime',`reporttype` = '$reportType',`door_1` = '$door_1',`door_2` = '$door_2',`lock_1` = '$lock_1',`lock_2` = '$lock_2',`battstate` = '$battState',
                          `waterstate` = '$waterState',`shakestate` = '$shakeState',`fallstate` = '$fallState',`smokestate` = '$smokeState',`battvalue` = '$battValue',`tempvalue` = '$tempValue',`humidvalue` = '$humidValue',`rssivalue` = '$rssiValue'
                            WHERE (`devcode` = '$devCode')";
                $result = $mysqli->query($query_str);
            }
        }
        else {
            $query_str = "INSERT INTO `t_l3f3dm_fhys_currentreport` (devcode,statcode,createtime,reporttype,door_1,door_2,lock_1,lock_2,battstate,waterstate,shakestate,fallstate,smokestate,battvalue,tempvalue,humidvalue,rssivalue)
                            VALUES ('$devCode','$statcode','$currenttime','$reportType','$door_1','$door_2','$lock_1','$lock_2','$battState','$waterState','$shakeState','$fallState','$smokeState','$battValue','$tempValue','$humidValue','$rssiValue')";
            $result = $mysqli->query($query_str);
        }

        //告警等级大于0，则新插入一条新纪录
        if (($alarm_code != MFUN_HCU_FHYS_ALARM_NONE) AND ($alarm_severity != MFUN_HCU_FHYS_ALARM_LEVEL_0))
        {
            $alarm_flag = MFUN_HCU_ALARM_PROC_FLAG_N;
            $alarm_proc = "新增告警，等待处理中";
            $query_str = "INSERT INTO `t_l3f5fm_fhys_alarmdata` (devcode,statcode,alarmflag,alarmseverity,alarmcode,tsgen,alarmproc)
                            VALUES ('$devCode','$statcode','$alarm_flag','$alarm_severity','$alarm_code','$currenttime','$alarm_proc')";
            $result = $mysqli->query($query_str);
        }

        //生成控制命令的控制字
        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        $ctrl_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_FHYS_DOORLOCK_STATUS);
        $para = $dbiL1vmCommonObj->byte2string(MFUN_HCU_DATA_FHYS_STATUS_OK);

        $len = $dbiL1vmCommonObj->byte2string(strlen($para) / 2);
        $respCmd = $ctrl_key . $len . $para;

        //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
        $socketid = $dbiL1vmCommonObj->dbi_huitp_huc_socketid_inqery($devCode);
        if ($socketid != 0){
            $client = new socket_client_sync($socketid, $devCode, $respCmd);
            $client->connect();
            $resp = "Box status response send success";
        }
        else{
            $resp = "E: Socket closed or not connected!";
        }

        $mysqli->close();
        return $resp;//返回Response
    }

    //FHYS开锁请求消息处理
    public function dbi_fhys_doorlock_open_process($devCode, $statcode, $data)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        $resp_msg = "";
        $keyid = "";
        $opt_key = "";
        $auth_check = false; //初始化
        $event = "NULL";
        $format = "A8rfid/A12blemac";
        $msg= unpack($format, $data);
        if (($msg['rfid'] != MFUN_HCU_FHYS_RFID_NULL) AND ($auth_check == false))//判断是否检测到RFID开锁请求
        {
            $opt_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_OPT_FHYS_RFID_LOCKOPEN_RESP);
            $rfid = $msg['rfid'];
            $key_type = MFUN_L3APL_F2CM_KEY_TYPE_RFID;
            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`hwcode` = '$rfid' AND `keytype` = '$key_type')"; //暂时只判断是否有
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows)>0){
                $row = $result->fetch_array();
                $keyid = $row['keyid'];
                $auth_check = $this->dbi_hcu_lock_keyauth_check($mysqli, $keyid, $statcode);
            }
            if($auth_check == true){
                $event = MFUN_L3APL_F2CM_EVENT_TYPE_RFID;
                $resp_msg = "Lock open with RFID success: ";
            }
            else{
                $resp_msg = "Lock open with RFID failure: ";
            }
        }
        //判断是否检测到BLE开锁请求且RFID开锁没有授权
        if (($msg['blemac'] != MFUN_HCU_FHYS_BLEMAC_NULL) AND ($auth_check == false))
        {
            $opt_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_OPT_FHYS_BLE_LOCKOPEN_RESP);
            $blemac = $msg['blemac'];
            $key_type = MFUN_L3APL_F2CM_KEY_TYPE_BLE;
            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`hwcode` = '$blemac' AND `keytype` = '$key_type')"; //暂时只判断是否有
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows)>0){
                $row = $result->fetch_array();
                $keyid = $row['keyid'];
                $auth_check = $this->dbi_hcu_lock_keyauth_check($mysqli, $keyid, $statcode);
            }
            else{ //为该MAC地址生成一把蓝牙虚拟钥匙
                $keyid = MFUN_L3APL_F2CM_KEY_PREFIX.$this->getRandomKeyid(MFUN_L3APL_F2CM_KEY_ID_LEN);  //KEYID的分配机制将来要重新考虑，避免重复
                $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statcode' ";
                $result = $mysqli->query($query_str);
                if (($result->num_rows) > 0) {
                    $resp_row = $result->fetch_array();
                    $pcode = $resp_row['p_code'];
                }
                $keyname = "蓝牙钥匙-".$blemac;
                $keytype = MFUN_L3APL_F2CM_KEY_TYPE_BLE;
                $keystatus = MFUN_HCU_FHYS_KEY_INVALID;
                $memo = "系统自动生成的蓝牙虚拟钥匙";
                $query_str = "INSERT INTO `t_l3f2cm_fhys_keyinfo` (keyid,keyname,p_code,keystatus,keytype,hwcode,memo)
                                      VALUES ('$keyid','$keyname','$pcode','$keystatus','$keytype','$blemac','$memo')";
                $result = $mysqli->query($query_str);
            }
            if($auth_check == true){
                $event = MFUN_L3APL_F2CM_EVENT_TYPE_BLE;
                $resp_msg = "Lock open with BLE success: ";
            }
            else{
                $resp_msg = "Lock open with BLE failure: ";
            }
        }
        //如果RFID和BLE开锁认证都不通过，看看是否有有用户名开锁授权
        if($auth_check == false)
        {
            $opt_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_OPT_FHYS_USERID_LOCKOPEN_RESP);
            //暂时只判断是否有针对该站点的有效次数授权
            $auth_type = MFUN_L3APL_F2CM_AUTH_TYPE_NUMBER;
            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyauth` WHERE (`authobjcode` = '$statcode' AND `authtype` = '$auth_type')";
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows)>0){
                $row = $result->fetch_array();
                $sid = $row['sid'];
                $keyid = $row['keyid'];
                $validnum = $row['validnum'];
                //防止用户重复点击，对于用户名次数开锁授权，只保留一次开锁
                if($validnum > 0){
                    $query_str = "DELETE FROM `t_l3f2cm_fhys_keyauth` WHERE (`sid` = '$sid') ";
                    $mysqli->query($query_str);
                    $auth_check = true;
                    $event = MFUN_L3APL_F2CM_EVENT_TYPE_USER;
                    $resp_msg = "Lock open with USER ID success: ";
                }
                else{
                    $auth_check = false;
                    $resp_msg = "Lock open with USER ID failure: ";
                }
                /*
                $remain_validnum = $validnum - 1;
                if ($remain_validnum == 0){
                    $query_str = "DELETE FROM `t_l3f2cm_fhys_keyauth` WHERE (`sid` = '$sid') ";
                    $resp = $mysqli->query($query_str);
                    $event = MFUN_L3APL_F2CM_EVENT_TYPE_USER;
                    $auth_check = true;
                }
                else{
                    $query_str = "UPDATE `t_l3f2cm_fhys_keyauth` SET  `validnum` = '$remain_validnum' WHERE (`sid` = '$sid')";
                    $resp = $mysqli->query($query_str);
                    $auth_check = true;
                }*/
            }
            else{
                $auth_check = false;
                $resp_msg = "Lock open with USER ID failure: ";
            }
        }

        if($auth_check == true){
            $timestamp = time();
            $filename = $statcode . "_" . $timestamp; //生成jpg文件名
            $picname = $filename . MFUN_HCU_SITE_PIC_FILE_TYPE;
            $result = $this->dbi_hcu_event_log_process($mysqli, $keyid, $statcode, $event, $picname); //保存开锁记录，预存开锁照片名

            //生成控制命令
            $para = $dbiL1vmCommonObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_OPEN);
        }
        else{
            $para = $dbiL1vmCommonObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_CLOSE);
            $filename = "";
        }

        //处理照片文件名，将其补足固定长度
        $filename = $dbiL1vmCommonObj->str_padding($filename, "_", HUITP_IEID_UNI_CCL_GEN_PIC_ID_LEN_MAX);
        $filename = bin2hex($filename);
        $ctrl_key = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_FHYS_DOORLOCK_OPEN);
        //这里为了保持与老版本的兼容，控制命令部分不变，增加独立的照片文件名长度+照片文件名
        $len_1 = $dbiL1vmCommonObj->byte2string(strlen($opt_key.$para)/2);
        $len_2 = $dbiL1vmCommonObj->byte2string(strlen($filename)/2);

        $respCmd = $ctrl_key . $len_1 . $opt_key . $para . $len_2 . $filename;

        //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
        $socketid = $dbiL1vmCommonObj->dbi_huitp_huc_socketid_inqery($devCode);
        if ($socketid != 0){
            $client = new socket_client_sync($socketid, $devCode, $respCmd);
            $client->connect();
            $resp = "T: " . $resp_msg . $respCmd;
        }
        else{
            $resp = "E: Socket closed or not connected!";
        }

        $mysqli->close();
        return $resp;//返回Response
    }

}

?>