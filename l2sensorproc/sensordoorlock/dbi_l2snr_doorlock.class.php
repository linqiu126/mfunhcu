<?php
/**
 * Created by PhpStorm.
 * User: zehongl
 * Date: 2016/11/7
 * Time: 21:35
 */

class classDbiL2snrDoorlock
{

    public function dbi_hcu_lock_status_update($devCode, $statCode, $data)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

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
            $query_str = "UPDATE `t_l2snr_fhys_minreport` SET `lockstat` = '$status' WHERE (`devcode` = '$devCode' AND `statcode` = '$statCode' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')";
            $result = $mysqli->query($query_str);
        }
        else
        {
            $query_str = "INSERT INTO `t_l2snr_fhys_minreport` (devcode,statcode,lockstat,reportdate,hourminindex) VALUES ('$devCode','$statCode','$status', '$date', '$hourminindex')";
            $result = $mysqli->query($query_str);
        }

        //更新当前聚合表
        $currenttime = date("Y-m-d H:i:s",$timestamp);
        $result = $mysqli->query("SELECT * FROM `t_l3f3dm_fhys_currentreport` WHERE (`devcode` = '$devCode' ");
        if (($result->num_rows)>0) {
            $result = $mysqli->query("UPDATE `t_l3f3dm_fhys_currentreport` SET  `lockstat` = '$status', `createtime` = '$currenttime' WHERE (`devcode` = '$devCode')");
        }
        else {
            $result = $mysqli->query("INSERT INTO `t_l3f3dm_fhys_currentreport` (devcode,statcode,createtime,lockstat) VALUES ('$devCode','$statCode','$currenttime','$status')");
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
        $mysqli->query("set character_set_results = utf8");

        //确认要操作的设备在 HCU Inventory表中是否存在
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE (`statcode` = '$statCode' AND `devcode` = '$devCode')";
        $result = $mysqli->query($query_str);

        if (($result != false) && ($result->num_rows)>0)
        {
            //生成控制命令的控制字
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_FHYS_LOCK);
            $opt_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_OPT_FHYS_USERID_LOCKOPEN_RESP);
            //暂时只判断是否为空，将来要进行权限判断
            if(empty($funcFlag))
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_CLOSE);
            else
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_OPEN);

            $len = $apiL2snrCommonServiceObj->byte2string(strlen($opt_key.$para)/2);
            $respCmd = $ctrl_key . $len . $opt_key . $para;

            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($devCode, $respCmd);
            $client->connect();
            $resp = "Lock open with USERID send success";
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
        $mysqli->query("set character_set_results = utf8");

        //确认要操作的设备在 HCU Inventory表中是否存在
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE (`statcode` = '$statCode' AND `devcode` = '$devCode')";
        $result = $mysqli->query($query_str);

        if (($result != false) && ($result->num_rows)>0)
        {
            //生成控制命令的控制字
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_FHYS_LOCK);
            $opt_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_OPT_FHYS_RFID_LOCKOPEN_RESP);
            //暂时只判断是否为空，将来要进行权限判断
            if(empty($funcFlag))
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_CLOSE);
            else
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_OPEN);

            $len = $apiL2snrCommonServiceObj->byte2string(strlen($opt_key.$para)/2);
            $respCmd = $ctrl_key . $len . $opt_key . $para;

            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($devCode, $respCmd);
            $client->connect();
            $resp = "Lock open with RFID send success";
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
        $mysqli->query("set character_set_results = utf8");

        //确认要操作的设备在 HCU Inventory表中是否存在
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE (`statcode` = '$statCode' AND `devcode` = '$devCode')";
        $result = $mysqli->query($query_str);

        if (($result != false) && ($result->num_rows)>0)
        {
            //生成控制命令的控制字
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_FHYS_LOCK);
            $opt_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_OPT_FHYS_BLE_LOCKOPEN_RESP);
            //暂时只判断是否为空，将来要进行权限判断
            if(empty($funcFlag))
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_CLOSE);
            else
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_OPEN);

            $len = $apiL2snrCommonServiceObj->byte2string(strlen($opt_key.$para)/2);
            $respCmd = $ctrl_key . $len . $opt_key . $para;

            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($devCode, $respCmd);
            $client->connect();
            $resp = "Lock open with BLE send success";
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
        $mysqli->query("set character_set_results = utf8");

        //确认要操作的设备在 HCU Inventory表中是否存在
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE (`statcode` = '$statCode' AND `devcode` = '$devCode')";
        $result = $mysqli->query($query_str);

        if (($result != false) && ($result->num_rows)>0)
        {
            //生成控制命令的控制字
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_FHYS_LOCK);
            $opt_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_OPT_FHYS_WECHAT_LOCKOPEN_RESP);
            //暂时只判断是否为空，将来要进行权限判断
            if(empty($funcFlag))
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_CLOSE);
            else
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_OPEN);

            $len = $apiL2snrCommonServiceObj->byte2string(strlen($opt_key.$para)/2);
            $respCmd = $ctrl_key . $len . $opt_key . $para;

            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($devCode, $respCmd);
            $client->connect();
            $resp = "Lock open with WECHAT send success";
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
        $mysqli->query("set character_set_results = utf8");

        //确认要操作的设备在 HCU Inventory表中是否存在
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE (`statcode` = '$statCode' AND `devcode` = '$devCode')";
        $result = $mysqli->query($query_str);

        if (($result != false) && ($result->num_rows)>0)
        {
            //生成控制命令的控制字
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_FHYS_LOCK);
            $opt_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_OPT_FHYS_IDCARD_LOCKOPEN_RESP);
            //暂时只判断是否为空，将来要进行权限判断
            if(empty($funcFlag))
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_CLOSE);
            else
                $para = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_DATA_FHYS_LOCK_OPEN);

            $len = $apiL2snrCommonServiceObj->byte2string(strlen($opt_key.$para)/2);
            $respCmd = $ctrl_key . $len . $opt_key . $para;

            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($devCode, $respCmd);
            $client->connect();
            $resp = "Lock open with ID_CARD send success";
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
        $mysqli->query("set character_set_results = utf8");

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

            $query_str = "UPDATE `t_l2snr_fhys_minreport` SET `doorstat` = '$status' WHERE (`devcode` = '$devCode' AND `statcode` = '$statCode' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')";
            $result = $mysqli->query($query_str);
        }
        else
        {
            $query_str = "INSERT INTO `t_l2snr_fhys_minreport` (devcode,statcode,doorstat,reportdate,hourminindex) VALUES ('$devCode','$statCode','$status', '$date', '$hourminindex')";
            $result = $mysqli->query($query_str);
        }

        //更新当前聚合表
        $currenttime = date("Y-m-d H:i:s",$timestamp);
        $result = $mysqli->query("SELECT * FROM `t_l3f3dm_fhys_currentreport` WHERE (`devcode` = '$devCode' ");
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

}

?>