<?php
/**
 * Created by PhpStorm.
 * User: zehongl
 * Date: 2016/11/7
 * Time: 21:35
 */

class classDbiL2snrDoorlock
{

    private function dbi_hcu_event_log_process($keyid, $statCode, $eventtype)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //确认要操作的设备在 HCU Inventory表中是否存在
        $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`keyid` = '$keyid')";
        $result = $mysqli->query($query_str);
        if (($result != false) && ($result->num_rows)>0)
        {
            $row = $result->fetch_array();
            $keyname = $row['keyname'];
            $keyuserid = $row['keyuserid'];
            $keyusername = $row['keyusername'];

            $timestamp = time();
            $eventdate = date("Y-m-d", $timestamp);
            $eventtime = date("H:m:s", $timestamp);
            $query_str = "INSERT INTO `t_l3fxprcm_fhys_locklog` (keyid,keyname,keyuserid,keyusername,eventtype,statcode,eventdate,eventtime)
                              VALUES ('$keyid','$keyname','$keyuserid', '$keyusername', '$eventtype', '$statCode', '$eventdate', '$eventtime')";
            $result = $mysqli->query($query_str);
        }

        $mysqli->close();
        return $result;
    }

    public function dbi_hcu_lock_status_update($devCode, $statCode, $data)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if ($data == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $status = MFUN_HCU_FHYS_LOCK_CLOSE;
        elseif ($data == MFUN_HCU_DATA_FHYS_STATUS_NOK)
            $status = MFUN_HCU_FHYS_LOCK_OPEN;
        elseif ($data == MFUN_HCU_DATA_FHYS_STATUS_ALARM)
            $status = MFUN_HCU_FHYS_LOCK_ALARM;
        else
            $status =MFUN_HCU_FHYS_STATUS_UNKNOWN;

        $timestamp = time();
        $date = intval(date("ymd", $timestamp));
        $temp = getdate($timestamp);
        $hourminindex = intval(($temp["hours"] * 60 + floor($temp["minutes"]/MFUN_HCU_FHYS_TIME_GRID_SIZE)));

        //更新分钟报告表
        $result = $mysqli->query("SELECT * FROM `t_l2snr_fhys_minreport` WHERE (( `devcode` = '$devCode' AND `statcode` = '$statCode')
                        AND (`reportdate` = '$date' AND `hourminindex` = '$hourminindex'))");
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $query_str = "UPDATE `t_l2snr_fhys_minreport` SET `lock_1` = '$status' WHERE (`devcode` = '$devCode' AND `statcode` = '$statCode' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')";
            $result = $mysqli->query($query_str);
        }
        else
        {
            $query_str = "INSERT INTO `t_l2snr_fhys_minreport` (devcode,statcode,lock_1,reportdate,hourminindex) VALUES ('$devCode','$statCode','$status', '$date', '$hourminindex')";
            $result = $mysqli->query($query_str);
        }

        //更新当前聚合表
        $currenttime = date("Y-m-d H:i:s",$timestamp);
        $result = $mysqli->query("SELECT * FROM `t_l3f3dm_fhys_currentreport` WHERE (`devcode` = '$devCode') ");
        if (($result->num_rows)>0) {
            $query_str = "UPDATE `t_l3f3dm_fhys_currentreport` SET  `lockstat` = '$status', `createtime` = '$currenttime' WHERE (`devcode` = '$devCode')";
            $result = $mysqli->query($query_str);
        }
        else {
            $query_str = "INSERT INTO `t_l3f3dm_fhys_currentreport` (devcode,statcode,createtime,lockstat) VALUES ('$devCode','$statCode','$currenttime','$status')";
            $result = $mysqli->query($query_str);
        }

        //返回Response
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE (`statcode` = '$statCode' AND `devcode` = '$devCode')";
        $result = $mysqli->query($query_str);

        if (($result != false) && ($result->num_rows)>0)
        {
            //生成控制命令的控制字
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_FHYS_LOCK);
            $opt_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_OPT_FHYS_LOCKSTAT_RESP);
            $para = $apiL2snrCommonServiceObj->byte2string($data);

            $len = $apiL2snrCommonServiceObj->byte2string(strlen($opt_key.$para)/2);
            $respCmd = $ctrl_key . $len . $opt_key . $para;

            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($devCode, $respCmd);
            $client->connect();
            $resp = "Lock status response send success";
        }
        else
            $resp = "Lock status response send failure";

        $mysqli->close();
        return $resp;
    }

    //HCU_Lock_Open
    public function dbi_hcu_userid_lock_open($devCode, $statCode,$funcFlag)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //确认要操作的设备在 HCU Inventory表中是否存在
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE (`statcode` = '$statCode' AND `devcode` = '$devCode')";
        $result = $mysqli->query($query_str);

        if (($result != false) && ($result->num_rows)>0)
        {
            //生成控制命令的控制字
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_FHYS_LOCK);
            $opt_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_OPT_FHYS_USERID_LOCKOPEN_RESP);

            $query_str = "SELECT * FROM `t_l3f3dm_fhys_currentreport` WHERE (`statcode` = '$statCode' AND `devcode` = '$devCode')";
            $resp = $mysqli->query($query_str);
            $resp_row = $resp->fetch_array();
            $status = $resp_row["lockstat"];

            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`hwcode` = '$funcFlag')"; //暂时只判断是否有
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows)>0){
                $funcFlag = true;
            }
            else{
                $anthtype = MFUN_L3APL_F2CM_AUTH_TYPE_NUMBER;
                $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyauth` WHERE (`authobjcode` = '$statCode' AND `authtype` = '$anthtype' AND `validnum` > 0)";
                $resp = $mysqli->query($query_str);
                if (($resp != false) && ($resp->num_rows)>0){
                    $funcFlag = true;
                    $resp_row = $resp->fetch_array();
                    $keyid = $resp_row["keyid"];
                    $event = MFUN_L3APL_F2CM_EVENT_TYPE_USER;
                    $this->dbi_hcu_event_log_process($keyid, $statCode, $event); //保存开锁记录

                    $remain_validnum = $resp_row["validnum"] -1;
                    if($remain_validnum == 0) //有效次数为0后删除该条授权记录
                    {
                        $query_str = "DELETE FROM `t_l3f2cm_fhys_keyauth` WHERE (`authobjcode` = '$statCode' AND `authtype` = '$anthtype' ) ";
                        $result = $mysqli->query($query_str);
                    }
                    else{
                        $query_str = "UPDATE `t_l3f2cm_fhys_keyauth` SET  `validnum` = '$remain_validnum' WHERE (`authobjcode` = '$statCode' AND `authtype` = '$anthtype')";
                        $result = $mysqli->query($query_str);
                    }
                }
                else
                    $funcFlag = false;
            }


            //暂时只判断flag不为空且在闭锁状态才发送命令，将来要进行权限判断
            if($funcFlag && $status == MFUN_HCU_FHYS_LOCK_CLOSE)
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_OPEN);
            else
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_CLOSE);

            $len = $apiL2snrCommonServiceObj->byte2string(strlen($opt_key.$para)/2);
            $respCmd = $ctrl_key . $len . $opt_key . $para;

            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($devCode, $respCmd);
            $client->connect();
            $resp = "Lock open with USERID send success: " . $respCmd;
        }
        else
            $resp = "Lock open with USERID send failure";

        $mysqli->close();
        return $resp;
    }

    public function dbi_hcu_rfid_lock_open($devCode, $statCode,$funcFlag)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //确认要操作的设备在 HCU Inventory表中是否存在
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE (`statcode` = '$statCode' AND `devcode` = '$devCode')";
        $result = $mysqli->query($query_str);

        if (($result != false) && ($result->num_rows)>0)
        {
            //生成控制命令的控制字
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_FHYS_LOCK);
            $opt_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_OPT_FHYS_RFID_LOCKOPEN_RESP);

            $query_str = "SELECT * FROM `t_l3f3dm_fhys_currentreport` WHERE (`statcode` = '$statCode' AND `devcode` = '$devCode')";
            $resp = $mysqli->query($query_str);
            $resp_row = $resp->fetch_array();
            $status = $resp_row["lockstat"];

            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`hwcode` = '$funcFlag')"; //暂时只判断是否有
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows)>0){
                $funcFlag = true;
            }
            else
                $funcFlag = false;
            //暂时只判断flag不为空且在闭锁状态才发送命令，将来要进行权限判断
            if($funcFlag && $status == MFUN_HCU_FHYS_LOCK_CLOSE)
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_OPEN);
            else
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_CLOSE);

            $len = $apiL2snrCommonServiceObj->byte2string(strlen($opt_key.$para)/2);
            $respCmd = $ctrl_key . $len . $opt_key . $para;

            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($devCode, $respCmd);
            $client->connect();
            $resp = "Lock open with RFID send success: ". $respCmd;
        }
        else
            $resp = "Lock open with RFID send failure";

        $mysqli->close();
        return $resp;
    }

    public function dbi_hcu_ble_lock_open($devCode, $statCode,$funcFlag)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //确认要操作的设备在 HCU Inventory表中是否存在
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE (`statcode` = '$statCode' AND `devcode` = '$devCode')";
        $result = $mysqli->query($query_str);

        if (($result != false) && ($result->num_rows)>0)
        {
            //生成控制命令的控制字
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_FHYS_LOCK);
            $opt_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_OPT_FHYS_BLE_LOCKOPEN_RESP);

            $query_str = "SELECT * FROM `t_l3f3dm_fhys_currentreport` WHERE (`statcode` = '$statCode' AND `devcode` = '$devCode')";
            $resp = $mysqli->query($query_str);
            $resp_row = $resp->fetch_array();
            $status = $resp_row["lockstat"];

            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`hwcode` = '$funcFlag')"; //暂时只判断是否有
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows)>0){
                $funcFlag = true;
            }
            else
                $funcFlag = false;
            //暂时只判断flag不为空且在闭锁状态才发送命令，将来要进行权限判断
            if($funcFlag && $status == MFUN_HCU_FHYS_LOCK_CLOSE)
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_OPEN);
            else
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_CLOSE);

            $len = $apiL2snrCommonServiceObj->byte2string(strlen($opt_key.$para)/2);
            $respCmd = $ctrl_key . $len . $opt_key . $para;

            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($devCode, $respCmd);
            $client->connect();
            $resp = "Lock open with BLE send success: ". $respCmd;
        }
        else
            $resp = "Lock open with BLE send failure";

        $mysqli->close();
        return $resp;
    }

    public function dbi_hcu_wechat_lock_open($devCode, $statCode,$funcFlag)
    {
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //确认要操作的设备在 HCU Inventory表中是否存在
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE (`statcode` = '$statCode' AND `devcode` = '$devCode')";
        $result = $mysqli->query($query_str);

        if (($result != false) && ($result->num_rows)>0)
        {
            //生成控制命令的控制字
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_FHYS_LOCK);
            $opt_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_OPT_FHYS_WECHAT_LOCKOPEN_RESP);

            $query_str = "SELECT * FROM `t_l3f3dm_fhys_currentreport` WHERE (`statcode` = '$statCode' AND `devcode` = '$devCode')";
            $resp = $mysqli->query($query_str);
            $resp_row = $resp->fetch_array();
            $status = $resp_row["lockstat"];

            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`hwcode` = '$funcFlag')"; //暂时只判断是否有
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows)>0){
                $funcFlag = true;
            }
            else
                $funcFlag = false;
            //暂时只判断flag不为空且在闭锁状态才发送命令，将来要进行权限判断
            if($funcFlag && $status == MFUN_HCU_FHYS_LOCK_CLOSE)
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_OPEN);
            else
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_CLOSE);

            $len = $apiL2snrCommonServiceObj->byte2string(strlen($opt_key.$para)/2);
            $respCmd = $ctrl_key . $len . $opt_key . $para;

            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($devCode, $respCmd);
            $client->connect();
            $resp = "Lock open with WECHAT send success: ". $respCmd;
        }
        else
            $resp = "Lock open with WECHAT send failure";

        $mysqli->close();
        return $resp;
    }

    public function dbi_hcu_idcard_lock_open($devCode, $statCode,$funcFlag)
    {
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        //确认要操作的设备在 HCU Inventory表中是否存在
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE (`statcode` = '$statCode' AND `devcode` = '$devCode')";
        $result = $mysqli->query($query_str);

        if (($result != false) && ($result->num_rows)>0)
        {
            //生成控制命令的控制字
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_FHYS_LOCK);
            $opt_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_OPT_FHYS_IDCARD_LOCKOPEN_RESP);

            $query_str = "SELECT * FROM `t_l3f3dm_fhys_currentreport` WHERE (`statcode` = '$statCode' AND `devcode` = '$devCode')";
            $resp = $mysqli->query($query_str);
            $resp_row = $resp->fetch_array();
            $status = $resp_row["lockstat"];

            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`hwcode` = '$funcFlag')"; //暂时只判断是否有
            $result = $mysqli->query($query_str);
            if (($result != false) && ($result->num_rows)>0){
                $funcFlag = true;
            }
            else
                $funcFlag = false;
            //暂时只判断flag不为空且在闭锁状态才发送命令，将来要进行权限判断
            if($funcFlag && $status == MFUN_HCU_FHYS_LOCK_CLOSE)
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_OPEN);
            else
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_CLOSE);

            $len = $apiL2snrCommonServiceObj->byte2string(strlen($opt_key.$para)/2);
            $respCmd = $ctrl_key . $len . $opt_key . $para;

            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($devCode, $respCmd);
            $client->connect();
            $resp = "Lock open with ID_CARD send success: ". $respCmd;
        }
        else
            $resp = "Lock open with ID_CARD send failure";

        $mysqli->close();
        return $resp;
    }

    public function dbi_hcu_door_status_update($devCode, $statCode, $data)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        if ($data == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $status = MFUN_HCU_FHYS_DOOR_CLOSE;
        elseif ($data == MFUN_HCU_DATA_FHYS_STATUS_NOK)
            $status = MFUN_HCU_FHYS_DOOR_OPEN;
        elseif ($data == MFUN_HCU_DATA_FHYS_STATUS_ALARM)
            $status = MFUN_HCU_FHYS_DOOR_ALARM;
        else
            $status =MFUN_HCU_FHYS_STATUS_UNKNOWN;
        $timestamp = time();
        $date = intval(date("ymd", $timestamp));
        $temp = getdate($timestamp);
        $hourminindex = intval(($temp["hours"] * 60 + floor($temp["minutes"]/MFUN_HCU_FHYS_TIME_GRID_SIZE)));

        //更新分钟报告表
        $result = $mysqli->query("SELECT * FROM `t_l2snr_fhys_minreport` WHERE (( `devcode` = '$devCode' AND `statcode` = '$statCode')
                        AND (`reportdate` = '$date' AND `hourminindex` = '$hourminindex'))");
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {

            $query_str = "UPDATE `t_l2snr_fhys_minreport` SET `door_1` = '$status' WHERE (`devcode` = '$devCode' AND `statcode` = '$statCode' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')";
            $result = $mysqli->query($query_str);
        }
        else
        {
            $query_str = "INSERT INTO `t_l2snr_fhys_minreport` (devcode,statcode,door_1,reportdate,hourminindex) VALUES ('$devCode','$statCode','$status', '$date', '$hourminindex')";
            $result = $mysqli->query($query_str);
        }

        //更新当前聚合表
        $currenttime = date("Y-m-d H:i:s",$timestamp);
        $result = $mysqli->query("SELECT * FROM `t_l3f3dm_fhys_currentreport` WHERE (`devcode` = '$devCode') ");
        if (($result->num_rows)>0) {
            $result = $mysqli->query("UPDATE `t_l3f3dm_fhys_currentreport` SET  `doorstat` = '$status', `createtime` = '$currenttime' WHERE (`devcode` = '$devCode')");
        }
        else {
            $result = $mysqli->query("INSERT INTO `t_l3f3dm_fhys_currentreport` (devcode,statcode,createtime,doorstat) VALUES ('$devCode','$statCode','$currenttime','$status')");
        }

        //返回Response
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE (`statcode` = '$statCode' AND `devcode` = '$devCode')";
        $result = $mysqli->query($query_str);

        if (($result != false) && ($result->num_rows)>0)
        {
            //生成控制命令的控制字
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_FHYS_LOCK);
            $opt_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_OPT_FHYS_DOORSTAT_RESP);
            $para = $apiL2snrCommonServiceObj->byte2string($data);

            $len = $apiL2snrCommonServiceObj->byte2string(strlen($opt_key.$para)/2);
            $respCmd = $ctrl_key . $len . $opt_key . $para;

            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($devCode, $respCmd);
            $client->connect();
            $resp = "Door status response send success";
        }
        else
            $resp = "Door status response send failure";

        $mysqli->close();
        return $resp;
    }

    public function dbi_hcu_doorlock_statreport_process($devCode, $statCode, $data)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $format = "A2lock1/A2lock2/A2door1/A2door2/A2rfid/A2ble/A2gprs/A2batt/A4temp/A4humi/A2vibr/A2smok/A2water/A2tilt";
        $msg= unpack($format, $data);

        if ($msg['lock1'] == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $lock1 = MFUN_HCU_FHYS_LOCK_CLOSE;
        elseif ($msg['lock1'] == MFUN_HCU_DATA_FHYS_STATUS_NOK)
            $lock1 = MFUN_HCU_FHYS_LOCK_OPEN;
        elseif ($msg['lock1'] == MFUN_HCU_DATA_FHYS_STATUS_ALARM)
            $lock1 = MFUN_HCU_FHYS_LOCK_ALARM;
        else
            $lock1 =MFUN_HCU_FHYS_STATUS_UNKNOWN;

        if ($msg['lock2'] == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $lock2 = MFUN_HCU_FHYS_LOCK_CLOSE;
        elseif ($msg['lock2'] == MFUN_HCU_DATA_FHYS_STATUS_NOK)
            $lock2 = MFUN_HCU_FHYS_LOCK_OPEN;
        elseif ($msg['lock2'] == MFUN_HCU_DATA_FHYS_STATUS_ALARM)
            $lock2 = MFUN_HCU_FHYS_LOCK_ALARM;
        else
            $lock2 =MFUN_HCU_FHYS_STATUS_UNKNOWN;

        if ($msg['door1'] == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $door1 = MFUN_HCU_FHYS_DOOR_CLOSE;
        elseif ($msg['door1'] == MFUN_HCU_DATA_FHYS_STATUS_NOK)
            $door1 = MFUN_HCU_FHYS_DOOR_OPEN;
        elseif ($msg['door1'] == MFUN_HCU_DATA_FHYS_STATUS_ALARM)
            $door1 = MFUN_HCU_FHYS_DOOR_ALARM;
        else
            $door1 =MFUN_HCU_FHYS_STATUS_UNKNOWN;

        if ($msg['door2'] == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $door2 = MFUN_HCU_FHYS_DOOR_CLOSE;
        elseif ($msg['door2'] == MFUN_HCU_DATA_FHYS_STATUS_NOK)
            $door2 = MFUN_HCU_FHYS_DOOR_OPEN;
        elseif ($msg['door2'] == MFUN_HCU_DATA_FHYS_STATUS_ALARM)
            $door2 = MFUN_HCU_FHYS_DOOR_ALARM;
        else
            $door2 =MFUN_HCU_FHYS_STATUS_UNKNOWN;

        if ($msg['rfid'] == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $rfid = MFUN_HCU_FHYS_STATUS_OK;
        elseif ($msg['rfid'] == MFUN_HCU_DATA_FHYS_STATUS_NOK)
            $rfid = MFUN_HCU_FHYS_STATUS_NOK;
        else
            $rfid = MFUN_HCU_FHYS_STATUS_UNKNOWN;

        if ($msg['ble'] == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $ble = MFUN_HCU_FHYS_STATUS_OK;
        elseif ($msg['ble'] == MFUN_HCU_DATA_FHYS_STATUS_NOK)
            $ble = MFUN_HCU_FHYS_STATUS_NOK;
        else
            $ble = MFUN_HCU_FHYS_STATUS_UNKNOWN;

        $gprs =hexdec($msg['gprs']) & 0xFF;
        $batt = hexdec($msg['batt']) & 0xFF;
        $temperature = $msg['temp'];
        $humi = $msg['humi'];

        if ($msg['vibr'] == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $vibr = MFUN_HCU_FHYS_STATUS_OK;
        elseif ($msg['vibr'] == MFUN_HCU_DATA_FHYS_STATUS_NOK)
            $vibr = MFUN_HCU_FHYS_STATUS_NOK;
        else
            $vibr = MFUN_HCU_FHYS_STATUS_UNKNOWN;

        if ($msg['smok'] == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $smok = MFUN_HCU_FHYS_STATUS_OK;
        elseif ($msg['smok'] == MFUN_HCU_DATA_FHYS_STATUS_NOK)
            $smok = MFUN_HCU_FHYS_STATUS_NOK;
        else
            $smok = MFUN_HCU_FHYS_STATUS_UNKNOWN;

        if ($msg['water'] == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $water = MFUN_HCU_FHYS_STATUS_OK;
        elseif ($msg['water'] == MFUN_HCU_DATA_FHYS_STATUS_NOK)
            $water = MFUN_HCU_FHYS_STATUS_NOK;
        else
            $water = MFUN_HCU_FHYS_STATUS_UNKNOWN;

        if ($msg['tilt'] == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $tilt = MFUN_HCU_FHYS_STATUS_OK;
        elseif ($msg['tilt'] == MFUN_HCU_DATA_FHYS_STATUS_NOK)
            $tilt = MFUN_HCU_FHYS_STATUS_NOK;
        else
            $tilt = MFUN_HCU_FHYS_STATUS_UNKNOWN;

        $timestamp = time();
        $date = intval(date("ymd", $timestamp));
        $temp = getdate($timestamp);
        $hourminindex = intval(($temp["hours"] * 60 + floor($temp["minutes"]/MFUN_HCU_FHYS_TIME_GRID_SIZE)));
        //更新分钟报告表
        $result = $mysqli->query("SELECT * FROM `t_l2snr_fhys_minreport` WHERE (( `devcode` = '$devCode' AND `statcode` = '$statCode')
                        AND (`reportdate` = '$date' AND `hourminindex` = '$hourminindex'))");
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $query_str = "UPDATE `t_l2snr_fhys_minreport` SET `door_1` = '$door1',`door_2` = '$door2',`lock_1` = '$lock1',`lock_2` = '$lock2',`blestat` = '$ble',`rfidstat` = '$rfid',`siglevel` = '$gprs',
                            `battlevel` = '$batt',`temperature` = '$temperature',`humidity` = '$humi',`smokalarm` = '$smok',`wateralarm` = '$water',`vibralarm` = '$vibr'
                            WHERE (`devcode` = '$devCode' AND `statcode` = '$statCode' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')";
            $result = $mysqli->query($query_str);
        }
        else
        {
            $query_str = "INSERT INTO `t_l2snr_fhys_minreport` (devcode,statcode,reportdate,hourminindex,door_1,door_2,lock_1,lock_2,blestat,rfidstat,siglevel,battlevel,temperature,humidity,smokalarm, wateralarm,vibralarm)
                            VALUES ('$devCode','$statCode','$date','$hourminindex','$door1','$door2','$lock1','$lock2','$ble','$rfid','$gprs','$batt','$temperature','$humi','$smok','$water','$vibr')";
            $result = $mysqli->query($query_str);
        }

        //更新当前聚合表
        $currenttime = date("Y-m-d H:i:s",$timestamp);
        $result = $mysqli->query("SELECT * FROM `t_l3f3dm_fhys_currentreport` WHERE (`devcode` = '$devCode') ");
        if (($result->num_rows)>0) {
            $query_str = "UPDATE `t_l3f3dm_fhys_currentreport` SET  `door_1` = '$door1',`door_2` = '$door2',`lock_1` = '$lock1',`lock_2` = '$lock2',`blestat` = '$ble',`rfidstat` = '$rfid',`siglevel` = '$gprs',
                            `battlevel` = '$batt',`temperature` = '$temperature',`humidity` = '$humi',`smokalarm` = '$smok',`wateralarm` = '$water',`vibralarm` = '$vibr',`createtime` = '$currenttime'
                            WHERE (`devcode` = '$devCode')";
            $result = $mysqli->query($query_str);
        }
        else {
            $query_str = "INSERT INTO `t_l3f3dm_fhys_currentreport` (devcode,statcode,createtime,door_1,door_2,lock_1,lock_2,blestat,rfidstat,siglevel,battlevel,temperature,humidity,smokalarm, wateralarm,vibralarm)
                            VALUES ('$devCode','$statCode','$currenttime','$door1','$door2','$lock1','$lock2','$ble','$rfid','$gprs','$batt','$temperature','$humi','$smok','$water','$vibr')";
            $result = $mysqli->query($query_str);
        }

        if ($result == true)
            $resp_data = MFUN_HCU_DATA_FHYS_STATUS_OK;
        else
            $resp_data = MFUN_HCU_DATA_FHYS_STATUS_NOK;

        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE (`statcode` = '$statCode' AND `devcode` = '$devCode')";
        $result = $mysqli->query($query_str);

        if (($result != false) && ($result->num_rows)>0) {
            //生成控制命令的控制字
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_FHYS_BOX);
            $para = $apiL2snrCommonServiceObj->byte2string($resp_data);

            $len = $apiL2snrCommonServiceObj->byte2string(strlen($para) / 2);
            $respCmd = $ctrl_key . $len . $para;

            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($devCode, $respCmd);
            $client->connect();
            $resp = "Box status response send success";
        }
        else
            $resp = "Box status response send failure";

        $mysqli->close();
        return $resp;//返回Response
    }


}

?>