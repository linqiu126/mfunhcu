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
            $temp = getdate($timestamp);
            $eventdate = $temp['year']."-".$temp['mon']."-".$temp['mday'];
            $eventtime = $temp['hours'].":".$temp['minutes'].":".$temp['seconds'];
            $query_str = "INSERT INTO `t_l3fxprcm_fhys_locklog` (keyid,keyname,keyuserid,keyusername,eventtype,statcode,eventdate,eventtime)
                              VALUES ('$keyid','$keyname','$keyuserid', '$keyusername', '$eventtype', '$statCode', '$eventdate', '$eventtime')";
            $result = $mysqli->query($query_str);
        }
        else{
            $keyid = "Unknown";
            $keyname = "Unknown";
            $keyuserid = "Unknown";
            $keyusername = "Unknown";

            $eventdate = date("Y-m-d");
            $eventtime = date("H:m:s");
            $query_str = "INSERT INTO `t_l3fxprcm_fhys_locklog` (keyid,keyname,keyuserid,keyusername,eventtype,statcode,eventdate,eventtime)
                              VALUES ('$keyid','$keyname','$keyuserid', '$keyusername', '$eventtype', '$statCode', '$eventdate', '$eventtime')";
            $result = $mysqli->query($query_str);
        }

        $mysqli->close();
        return $result;
    }

    private function dbi_hcu_lock_keyauth_check($keyid, $statcode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $authckeck = false;
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
                        $remain_validnum = $validnum - 1;
                        if ($remain_validnum == 0){
                            $query_str = "DELETE FROM `t_l3f2cm_fhys_keyauth` WHERE (`sid` = '$sid') ";
                            $resp = $mysqli->query($query_str);
                            $authckeck = true;
                        }
                        else{
                            $query_str = "UPDATE `t_l3f2cm_fhys_keyauth` SET  `validnum` = '$remain_validnum' WHERE (`sid` = '$sid')";
                            $resp = $mysqli->query($query_str);
                            $authckeck = true;
                        }
                        break;
                    case MFUN_L3APL_F2CM_AUTH_TYPE_TIME:
                        $timestamp = time();
                        $current_date = intval(date("Ymd", $timestamp));
                        $validend = intval(date('Ymd',strtotime($validend)));
                        if ($current_date > $validend){
                            $query_str = "DELETE FROM `t_l3f2cm_fhys_keyauth` WHERE (`sid` = '$sid') ";
                            $resp = $mysqli->query($query_str);
                            $authckeck = false;
                        }
                        else
                            $authckeck = true;
                        break;
                    case MFUN_L3APL_F2CM_AUTH_TYPE_FOREVER:
                        $authckeck = true;
                        break;
                    default:
                        $authckeck = false;
                        break;
                }
            }
            else
                $authckeck = false;

            if ($authckeck == true) //如何验证授权通过就直接返回，否则继续遍历
                return $authckeck;
        }
        return $authckeck;
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

            //暂时只判断是否有针对该站点的有效次数授权
            $auth_check = false;
            $auth_type = MFUN_L3APL_F2CM_AUTH_TYPE_NUMBER;
            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyauth` WHERE (`authobjcode` = '$statCode' AND `authtype` = '$auth_type')";
            $resp = $mysqli->query($query_str);
            if (($resp != false) && ($resp->num_rows)>0){
                $row = $resp->fetch_array();
                $sid = $row['sid'];
                $keyid = $row['keyid'];
                $remain_validnum = $row['validnum'] - 1;
                if ($remain_validnum == 0){
                    $query_str = "DELETE FROM `t_l3f2cm_fhys_keyauth` WHERE (`sid` = '$sid') ";
                    $resp = $mysqli->query($query_str);
                    $auth_check = true;
                }
                else{
                    $query_str = "UPDATE `t_l3f2cm_fhys_keyauth` SET  `validnum` = '$remain_validnum' WHERE (`sid` = '$sid')";
                    $resp = $mysqli->query($query_str);
                    $auth_check = true;
                }
            }

            if($auth_check == true){
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_OPEN);
                $event = MFUN_L3APL_F2CM_EVENT_TYPE_USER;
                $this->dbi_hcu_event_log_process($keyid, $statCode, $event); //保存开锁记录
            }
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

            $auth_check = false;
            $key_type = MFUN_L3APL_F2CM_KEY_TYPE_RFID;
            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`hwcode` = '$funcFlag' AND `keytype` = '$key_type')"; //暂时只判断是否有
            $resp = $mysqli->query($query_str);
            if (($resp != false) && ($resp->num_rows)>0){
                $row = $resp->fetch_array();
                $keyid = $row['keyid'];
                $auth_check = $this->dbi_hcu_lock_keyauth_check($keyid, $statCode);
            }

            if($auth_check == true){
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_OPEN);
                $event = MFUN_L3APL_F2CM_EVENT_TYPE_RFID;
                $this->dbi_hcu_event_log_process($keyid, $statCode, $event); //保存开锁记录
            }
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

            $auth_check = false;
            $key_type = MFUN_L3APL_F2CM_KEY_TYPE_BLE;
            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`hwcode` = '$funcFlag' AND `keytype` = '$key_type')"; //暂时只判断是否有
            $resp = $mysqli->query($query_str);
            if (($resp != false) && ($resp->num_rows)>0){
                $row = $resp->fetch_array();
                $keyid = $row['keyid'];
                $auth_check = $this->dbi_hcu_lock_keyauth_check($keyid, $statCode);
            }
            else{ //为该MAC地址生成一把蓝牙虚拟钥匙
                $keyid = MFUN_L3APL_F2CM_KEY_PREFIX.$this->getRandomKeyid(MFUN_L3APL_F2CM_KEY_ID_LEN);  //KEYID的分配机制将来要重新考虑，避免重复
                $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statCode' ";
                $resp = $mysqli->query($query_str);
                if (($resp->num_rows) > 0) {
                    $resp_row = $resp->fetch_array();
                    $pcode = $resp_row['p_code'];
                }
                $keyname = "蓝牙钥匙-".$funcFlag;
                $keytype = MFUN_L3APL_F2CM_KEY_TYPE_BLE;
                $keystatus = MFUN_HCU_FHYS_KEY_INVALID;
                $memo = "系统自动生成的蓝牙虚拟钥匙，暂未授权";
                $query_str = "INSERT INTO `t_l3f2cm_fhys_keyinfo` (keyid,keyname,p_code,keystatus,keytype,hwcode,memo)
                                      VALUES ('$keyid','$keyname','$pcode','$keystatus','$keytype','$funcFlag','$memo')";
                $result = $mysqli->query($query_str);
            }

            if($auth_check == true){
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_OPEN);
                $event = MFUN_L3APL_F2CM_EVENT_TYPE_BLE;
                $this->dbi_hcu_event_log_process($keyid, $statCode, $event); //保存开锁记录
            }
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

            $auth_check = false;
            $key_type = MFUN_L3APL_F2CM_KEY_TYPE_WECHAT;
            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`hwcode` = '$funcFlag' AND `keytype` = '$key_type')"; //暂时只判断是否有
            $resp = $mysqli->query($query_str);
            if (($resp != false) && ($resp->num_rows)>0){
                $row = $resp->fetch_array();
                $keyid = $row['keyid'];
                $auth_check = $this->dbi_hcu_lock_keyauth_check($keyid, $statCode);
            }

            if($auth_check == true){
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_OPEN);
                $event = MFUN_L3APL_F2CM_EVENT_TYPE_WECHAT;
                $this->dbi_hcu_event_log_process($keyid, $statCode, $event); //保存开锁记录
            }
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

            $auth_check = false;
            $key_type = MFUN_L3APL_F2CM_KEY_TYPE_IDCARD;
            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`hwcode` = '$funcFlag' AND `keytype` = '$key_type')"; //暂时只判断是否有
            $resp = $mysqli->query($query_str);
            if (($resp != false) && ($resp->num_rows)>0){
                $row = $resp->fetch_array();
                $keyid = $row['keyid'];
                $auth_check = $this->dbi_hcu_lock_keyauth_check($keyid, $statCode);
            }

            if($auth_check == true){
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_OPEN);
                $event = MFUN_L3APL_F2CM_EVENT_TYPE_IDCARD;
                $this->dbi_hcu_event_log_process($keyid, $statCode, $event); //保存开锁记录
            }
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
        elseif ($data == MFUN_HCU_DATA_FHYS_STATUS_NULL)
            $status = MFUN_HCU_FHYS_LOCK_NULL;
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
        elseif ($data == MFUN_HCU_DATA_FHYS_STATUS_NULL)
            $status = MFUN_HCU_FHYS_DOOR_NULL;
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

    public function dbi_hcu_doorlock_boxstatus_process($devCode, $statCode, $data)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $format = "A2lock1/A2lock2/A2door1/A2door2/A2rfid/A2ble/A2gprs/A2batt/A4temp/A4humi/A2vibr/A2smok/A2water/A2tilt";
        $msg= unpack($format, $data);

        /*对于有源锁可以分别判断锁状态和门状态，这个处理有意义。但对于无源锁，锁的状态无法主动检测，这样判断就没有意义了，程序暂时保留

        if (($msg['lock1'] == MFUN_HCU_DATA_FHYS_STATUS_OK) AND ($msg['door1'] == MFUN_HCU_DATA_FHYS_STATUS_OK)){
            $lock1 = MFUN_HCU_FHYS_LOCK_CLOSE;
            $door1 = MFUN_HCU_FHYS_DOOR_CLOSE;
        }
        elseif (($msg['lock1'] == MFUN_HCU_DATA_FHYS_STATUS_NOK) AND ($msg['door1'] == MFUN_HCU_DATA_FHYS_STATUS_NOK)){
            $lock1 = MFUN_HCU_FHYS_LOCK_OPEN;
            $door1 = MFUN_HCU_FHYS_DOOR_OPEN;
        }
        elseif(($msg['lock1'] == MFUN_HCU_DATA_FHYS_STATUS_OK) AND ($msg['door1'] == MFUN_HCU_DATA_FHYS_STATUS_NOK)){
            $lock1 = MFUN_HCU_FHYS_LOCK_CLOSE;
            $door1 = MFUN_HCU_FHYS_DOOR_ALARM;
        }
        elseif(($msg['lock1'] == MFUN_HCU_DATA_FHYS_STATUS_NOK) AND ($msg['door1'] == MFUN_HCU_DATA_FHYS_STATUS_OK)){
            $lock1 = MFUN_HCU_FHYS_LOCK_ALARM;
            $door1 = MFUN_HCU_FHYS_DOOR_CLOSE;
        }
        elseif(($msg['lock1'] == MFUN_HCU_DATA_FHYS_STATUS_NULL) OR ($msg['door1'] == MFUN_HCU_DATA_FHYS_STATUS_NULL)){
            $lock1 = MFUN_HCU_FHYS_LOCK_NULL;
            $door1 = MFUN_HCU_FHYS_DOOR_NULL;
        }
        else{
            $lock1 =MFUN_HCU_FHYS_STATUS_UNKNOWN;
            $door1 =MFUN_HCU_FHYS_STATUS_UNKNOWN;
        }

        if (($msg['lock2'] == MFUN_HCU_DATA_FHYS_STATUS_OK) AND ($msg['door2'] == MFUN_HCU_DATA_FHYS_STATUS_OK)){
            $lock2 = MFUN_HCU_FHYS_LOCK_CLOSE;
            $door2 = MFUN_HCU_FHYS_DOOR_CLOSE;
        }
        elseif (($msg['lock2'] == MFUN_HCU_DATA_FHYS_STATUS_NOK) AND ($msg['door2'] == MFUN_HCU_DATA_FHYS_STATUS_NOK)){
            $lock2 = MFUN_HCU_FHYS_LOCK_OPEN;
            $door2 = MFUN_HCU_FHYS_DOOR_OPEN;
        }
        elseif(($msg['lock2'] == MFUN_HCU_DATA_FHYS_STATUS_OK) AND ($msg['door2'] == MFUN_HCU_DATA_FHYS_STATUS_NOK)){
            $lock2 = MFUN_HCU_FHYS_LOCK_CLOSE;
            $door2 = MFUN_HCU_FHYS_DOOR_ALARM;
        }
        elseif(($msg['lock2'] == MFUN_HCU_DATA_FHYS_STATUS_NOK) AND ($msg['door2'] == MFUN_HCU_DATA_FHYS_STATUS_OK)){
            $lock2 = MFUN_HCU_FHYS_LOCK_ALARM;
            $door2 = MFUN_HCU_FHYS_DOOR_CLOSE;
        }
        elseif(($msg['lock2'] == MFUN_HCU_DATA_FHYS_STATUS_NULL) OR ($msg['door2'] == MFUN_HCU_DATA_FHYS_STATUS_NULL)){
            $lock2 = MFUN_HCU_FHYS_LOCK_NULL;
            $door2 = MFUN_HCU_FHYS_DOOR_NULL;
        }
        else{
            $lock2 =MFUN_HCU_FHYS_STATUS_UNKNOWN;
            $door2 =MFUN_HCU_FHYS_STATUS_UNKNOWN;
        }
        */

        if ($msg['door1'] == MFUN_HCU_DATA_FHYS_STATUS_OK){
            $lock1 = MFUN_HCU_FHYS_LOCK_CLOSE;
            $door1 = MFUN_HCU_FHYS_DOOR_CLOSE;
        }
        elseif ($msg['door1'] == MFUN_HCU_DATA_FHYS_STATUS_NOK){
            $lock1 = MFUN_HCU_FHYS_LOCK_OPEN;
            $door1 = MFUN_HCU_FHYS_DOOR_OPEN;
        }
        elseif($msg['door1'] == MFUN_HCU_DATA_FHYS_STATUS_NULL){
            $lock1 = MFUN_HCU_FHYS_LOCK_NULL;
            $door1 = MFUN_HCU_FHYS_DOOR_NULL;
        }
        elseif($msg['door1'] == MFUN_HCU_DATA_FHYS_STATUS_ALARM){
            $lock1 = MFUN_HCU_FHYS_LOCK_ALARM;
            $door1 = MFUN_HCU_FHYS_DOOR_ALARM;
        }
        else{
            $lock1 =MFUN_HCU_FHYS_STATUS_UNKNOWN;
            $door1 =MFUN_HCU_FHYS_STATUS_UNKNOWN;
        }

        if ($msg['door2'] == MFUN_HCU_DATA_FHYS_STATUS_OK){
            $lock2 = MFUN_HCU_FHYS_LOCK_CLOSE;
            $door2 = MFUN_HCU_FHYS_DOOR_CLOSE;
        }
        elseif ($msg['door2'] == MFUN_HCU_DATA_FHYS_STATUS_NOK){
            $lock2 = MFUN_HCU_FHYS_LOCK_OPEN;
            $door2 = MFUN_HCU_FHYS_DOOR_OPEN;
        }
        elseif($msg['door2'] == MFUN_HCU_DATA_FHYS_STATUS_NULL){
            $lock2 = MFUN_HCU_FHYS_LOCK_NULL;
            $door2 = MFUN_HCU_FHYS_DOOR_NULL;
        }
        elseif($msg['door2'] == MFUN_HCU_DATA_FHYS_STATUS_ALARM){
            $lock2 = MFUN_HCU_FHYS_LOCK_ALARM;
            $door2 = MFUN_HCU_FHYS_DOOR_ALARM;
        }
        else{
            $lock2 =MFUN_HCU_FHYS_STATUS_UNKNOWN;
            $door2 =MFUN_HCU_FHYS_STATUS_UNKNOWN;
        }

        //任何一个锁出现非授权打开，即生成一条开锁记录，便于对应开门抓拍的照片与之关联
        if(($lock1 == MFUN_HCU_FHYS_LOCK_ALARM) OR ($lock2 == MFUN_HCU_FHYS_LOCK_ALARM))
        {
            $keyid = "";  //未授权开门锁，所以钥匙ID为空
            $event = MFUN_L3APL_F2CM_EVENT_TYPE_ALARM;
            $this->dbi_hcu_event_log_process($keyid, $statCode, $event); //保存开门事件记录
        }

        if ($msg['rfid'] == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $rfid = MFUN_HCU_FHYS_ALARM_NO;
        elseif ($msg['rfid'] == MFUN_HCU_DATA_FHYS_STATUS_NOK)
            $rfid = MFUN_HCU_FHYS_ALARM_YES;
        else
            $rfid = MFUN_HCU_FHYS_STATUS_UNKNOWN;

        if ($msg['ble'] == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $ble = MFUN_HCU_FHYS_ALARM_NO;
        elseif ($msg['ble'] == MFUN_HCU_DATA_FHYS_STATUS_NOK)
            $ble = MFUN_HCU_FHYS_ALARM_YES;
        else
            $ble = MFUN_HCU_FHYS_STATUS_UNKNOWN;

        $gprs =hexdec($msg['gprs']) & 0xFF;
        $batt = hexdec($msg['batt']) & 0xFF;
        $temperature = $msg['temp'];
        $humi = $msg['humi'];

        if ($msg['vibr'] == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $vibr = MFUN_HCU_FHYS_ALARM_NO;
        elseif ($msg['vibr'] == MFUN_HCU_DATA_FHYS_STATUS_NOK)
            $vibr = MFUN_HCU_FHYS_ALARM_YES;
        else
            $vibr = MFUN_HCU_FHYS_STATUS_UNKNOWN;

        if ($msg['smok'] == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $smok = MFUN_HCU_FHYS_ALARM_NO;
        elseif ($msg['smok'] == MFUN_HCU_DATA_FHYS_STATUS_NOK)
            $smok = MFUN_HCU_FHYS_ALARM_YES;
        else
            $smok = MFUN_HCU_FHYS_STATUS_UNKNOWN;

        if ($msg['water'] == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $water = MFUN_HCU_FHYS_ALARM_NO;
        elseif ($msg['water'] == MFUN_HCU_DATA_FHYS_STATUS_NOK)
            $water = MFUN_HCU_FHYS_ALARM_YES;
        else
            $water = MFUN_HCU_FHYS_STATUS_UNKNOWN;

        if ($msg['tilt'] == MFUN_HCU_DATA_FHYS_STATUS_OK)
            $tilt = MFUN_HCU_FHYS_ALARM_NO;
        elseif ($msg['tilt'] == MFUN_HCU_DATA_FHYS_STATUS_NOK)
            $tilt = MFUN_HCU_FHYS_ALARM_YES;
        else
            $tilt = MFUN_HCU_FHYS_STATUS_UNKNOWN;

        //告警处理, 根据客户要求为简化告警处理,告警记录以站点为单位,每次只记录最高等级的告警,同一等级的告警只记录一项,人工处理关闭的告警记录将保存.
        if ($lock1==MFUN_HCU_FHYS_LOCK_OPEN AND $door1 == MFUN_HCU_FHYS_DOOR_CLOSE){
            $alarm_code = MFUN_HCU_FHYS_ALARM_LOCK1_OPEN;
            $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_H;
        }
        elseif ($lock1==MFUN_HCU_FHYS_LOCK_CLOSE AND $door1 == MFUN_HCU_FHYS_DOOR_OPEN){
            $alarm_code = MFUN_HCU_FHYS_ALARM_DOOR1_OPEN;
            $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_H;
        }
        elseif ($lock2==MFUN_HCU_FHYS_LOCK_OPEN AND $door2 == MFUN_HCU_FHYS_DOOR_CLOSE){
            $alarm_code = MFUN_HCU_FHYS_ALARM_LOCK2_OPEN;
            $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_H;
        }
        elseif ($lock2==MFUN_HCU_FHYS_LOCK_CLOSE AND $door2 == MFUN_HCU_FHYS_DOOR_OPEN){
            $alarm_code = MFUN_HCU_FHYS_ALARM_DOOR2_OPEN;
            $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_H;
        }
        elseif ($water == MFUN_HCU_FHYS_ALARM_YES){
            $alarm_code = MFUN_HCU_FHYS_ALARM_WATER;
            $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_H;
        }
        elseif ($smok == MFUN_HCU_FHYS_ALARM_YES){
            $alarm_code = MFUN_HCU_FHYS_ALARM_SMOK;
            $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_H;
        }
        elseif ($tilt == MFUN_HCU_FHYS_ALARM_YES){
            $alarm_code = MFUN_HCU_FHYS_ALARM_SMOK;
            $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_M;
        }
        elseif ($vibr == MFUN_HCU_FHYS_ALARM_YES){
            $alarm_code = MFUN_HCU_FHYS_ALARM_VIBR;
            $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_M;
        }
        elseif ($batt < MFUN_L3APL_F3DM_TH_ALARM_BATT){
            $alarm_code = MFUN_HCU_FHYS_ALARM_LOW_BATT;
            $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_M;
        }
        elseif ($gprs < MFUN_L3APL_F3DM_TH_ALARM_GPRS_LOW){
            $alarm_code = MFUN_HCU_FHYS_ALARM_LOW_SIG;
            $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_L;
        }
        else{
            $alarm_code = MFUN_HCU_FHYS_ALARM_NONE;
            $alarm_severity = MFUN_HCU_FHYS_ALARM_LEVEL_0;
        }

        $timestamp = time();
        $date = intval(date("ymd", $timestamp));
        $temp = getdate($timestamp);
        $hourminindex = intval(($temp["hours"] * 60 + floor($temp["minutes"]/MFUN_HCU_FHYS_TIME_GRID_SIZE)));
        //更新分钟报告表
        $query_str ="SELECT * FROM `t_l2snr_fhys_minreport` WHERE (( `devcode` = '$devCode' AND `statcode` = '$statCode')
                        AND (`reportdate` = '$date' AND `hourminindex` = '$hourminindex'))";
        $result = $mysqli->query($query_str);
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
        $result = $mysqli->query("SELECT * FROM `t_l3f3dm_fhys_currentreport` WHERE (`devcode` = '$devCode' AND `statcode` = '$statCode') ");
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

        //更新告警记录表
        $update_flag = false;
        $query_str = "SELECT * FROM `t_l3f5fm_fhys_alarmdata` WHERE (`devcode` = '$devCode' AND `statcode` = '$statCode') ";
        $result = $mysqli->query($query_str);
        while($row = $result->fetch_array()){
            $alarm_flag = $row['alarmflag'];
            $old_severity = hexdec($row['alarmseverity']) & 0xFF;
            $new_severity = hexdec($alarm_severity) & 0xFF;
            if ($alarm_flag == "MFUN_HCU_FHYS_ALARM_PROC_FLAG_N" AND $old_severity <= $new_severity) { //如果该站点有未处理告警且新告警级别更为严重则更新这条记录
                $query_str = "UPDATE `t_l3f5fm_fhys_alarmdata` SET  `alarmseverity` = '$alarm_severity',`alarmcode` = '$alarm_code',`tsgen` = '$currenttime' WHERE (`devcode` = '$devCode')";
                $result = $mysqli->query($query_str);
                $update_flag = true;
            }
        }
        if ($update_flag == false) //没有可更新的告警记录则新插入一条
        {
            $alarm_flag = MFUN_HCU_FHYS_ALARM_PROC_FLAG_N;
            $alarm_proc = "新增告警，等待处理中";
            $query_str = "INSERT INTO `t_l3f5fm_fhys_alarmdata` (devcode,statcode,alarmflag,alarmseverity,alarmcode,tsgen,alarmproc)
                            VALUES ('$devCode','$statCode','$alarm_flag','$alarm_severity','$alarm_code','$currenttime','$alarm_proc')";
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
            $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_FHYS_BOXSTATUS);
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

    public function dbi_hcu_doorlock_boxopen_process($devCode, $statCode, $data)
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
        if ($result == false){
            $resp = "Look open rejected as device invaild";
            return $resp;
        }

        $auth_check = false; //初始化
        $format = "A8rfid/A12blemac";
        $msg= unpack($format, $data);
        if ($msg['rfid'] != MFUN_HCU_FHYS_RFID_NULL)//判断是否检测到RFID开锁请求
        {
            $rfid = $msg['rfid'];
            //生成控制命令的控制字
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_FHYS_BOXOPEN);
            $opt_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_OPT_FHYS_RFID_LOCKOPEN_RESP);

            $keyid = "";
            $key_type = MFUN_L3APL_F2CM_KEY_TYPE_RFID;
            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`hwcode` = '$rfid' AND `keytype` = '$key_type')"; //暂时只判断是否有
            $resp = $mysqli->query($query_str);
            if (($resp != false) && ($resp->num_rows)>0){
                $row = $resp->fetch_array();
                $keyid = $row['keyid'];
                $auth_check = $this->dbi_hcu_lock_keyauth_check($keyid, $statCode);
            }

            if($auth_check == true){
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_OPEN);
                $event = MFUN_L3APL_F2CM_EVENT_TYPE_RFID;
                $this->dbi_hcu_event_log_process($keyid, $statCode, $event); //保存开锁记录
                $resp_msg = "Lock open with RFID success: ";
            }
            else{
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_CLOSE);
                $resp_msg = "Lock open with RFID failure: ";
            }

            $len = $apiL2snrCommonServiceObj->byte2string(strlen($opt_key.$para)/2);
            $respCmd = $ctrl_key . $len . $opt_key . $para;

            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($devCode, $respCmd);
            $client->connect();
            $resp = $resp_msg . $respCmd;
        }

        if (($msg['blemac'] != MFUN_HCU_FHYS_BLEMAC_NULL) AND ($auth_check == false))//判断是否检测到BLE开锁请求且RFID开锁没有授权
        {
            $blemac = $msg['blemac'];
            //生成控制命令的控制字
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_FHYS_BOXOPEN);
            $opt_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_OPT_FHYS_BLE_LOCKOPEN_RESP);

            $auth_check = false;
            $key_type = MFUN_L3APL_F2CM_KEY_TYPE_BLE;
            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyinfo` WHERE (`hwcode` = '$blemac' AND `keytype` = '$key_type')"; //暂时只判断是否有
            $resp = $mysqli->query($query_str);
            if (($resp != false) && ($resp->num_rows)>0){
                $row = $resp->fetch_array();
                $keyid = $row['keyid'];
                $auth_check = $this->dbi_hcu_lock_keyauth_check($keyid, $statCode);
            }
            else{ //为该MAC地址生成一把蓝牙虚拟钥匙
                $keyid = MFUN_L3APL_F2CM_KEY_PREFIX.$this->getRandomKeyid(MFUN_L3APL_F2CM_KEY_ID_LEN);  //KEYID的分配机制将来要重新考虑，避免重复
                $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$statCode' ";
                $resp = $mysqli->query($query_str);
                if (($resp->num_rows) > 0) {
                    $resp_row = $resp->fetch_array();
                    $pcode = $resp_row['p_code'];
                }
                $keyname = "蓝牙钥匙-".$blemac;
                $keytype = MFUN_L3APL_F2CM_KEY_TYPE_BLE;
                $keystatus = MFUN_HCU_FHYS_KEY_INVALID;
                $memo = "系统自动生成的蓝牙虚拟钥匙，暂未授权";
                $query_str = "INSERT INTO `t_l3f2cm_fhys_keyinfo` (keyid,keyname,p_code,keystatus,keytype,hwcode,memo)
                                      VALUES ('$keyid','$keyname','$pcode','$keystatus','$keytype','$blemac','$memo')";
                $result = $mysqli->query($query_str);
            }

            if($auth_check == true){
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_OPEN);
                $event = MFUN_L3APL_F2CM_EVENT_TYPE_BLE;
                $this->dbi_hcu_event_log_process($keyid, $statCode, $event); //保存开锁记录
                $resp_msg = "Lock open with BLE success: ";
            }
            else{
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_CLOSE);
                $resp_msg = "Lock open with BLE failure: ";
            }


            $len = $apiL2snrCommonServiceObj->byte2string(strlen($opt_key.$para)/2);
            $respCmd = $ctrl_key . $len . $opt_key . $para;

            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($devCode, $respCmd);
            $client->connect();
            $resp = $resp_msg. $respCmd;
        }

        if ($auth_check == false)//如果RFID和BLE开锁认证都不通过，看看是否有有用户名开锁授权
        {
            //生成控制命令的控制字
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_FHYS_BOXOPEN);
            $opt_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_OPT_FHYS_USERID_LOCKOPEN_RESP);

            //暂时只判断是否有针对该站点的有效次数授权
            $auth_check = false;
            $keyid = "";
            $auth_type = MFUN_L3APL_F2CM_AUTH_TYPE_NUMBER;
            $query_str = "SELECT * FROM `t_l3f2cm_fhys_keyauth` WHERE (`authobjcode` = '$statCode' AND `authtype` = '$auth_type')";
            $resp = $mysqli->query($query_str);
            if (($resp != false) && ($resp->num_rows)>0){
                $row = $resp->fetch_array();
                $sid = $row['sid'];
                $keyid = $row['keyid'];
                $remain_validnum = $row['validnum'] - 1;
                if ($remain_validnum == 0){
                    $query_str = "DELETE FROM `t_l3f2cm_fhys_keyauth` WHERE (`sid` = '$sid') ";
                    $resp = $mysqli->query($query_str);
                    $auth_check = true;
                }
                else{
                    $query_str = "UPDATE `t_l3f2cm_fhys_keyauth` SET  `validnum` = '$remain_validnum' WHERE (`sid` = '$sid')";
                    $resp = $mysqli->query($query_str);
                    $auth_check = true;
                }
            }

            if($auth_check == true){
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_OPEN);
                $event = MFUN_L3APL_F2CM_EVENT_TYPE_USER;
                $this->dbi_hcu_event_log_process($keyid, $statCode, $event); //保存开锁记录
                $resp_msg = "Lock open with USERID success: ";
            }
            else{
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_CLOSE);
                $resp_msg = "Lock open with USERID failure: ";
            }

            $len = $apiL2snrCommonServiceObj->byte2string(strlen($opt_key.$para)/2);
            $respCmd = $ctrl_key . $len . $opt_key . $para;

            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($devCode, $respCmd);
            $client->connect();
            $resp = $resp_msg . $respCmd;
        }

        $mysqli->close();
        return $resp;//返回Response
    }

    public function dbi_huitp_msg_uni_ccl_state_report($devCode, $statCode, $data)
    {
        return true;
    }


}

?>