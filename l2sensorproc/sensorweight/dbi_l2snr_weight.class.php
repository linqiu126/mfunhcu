<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/3
 * Time: 15:19
 */

class classDbiL2snrWeight
{

    public function dbi_hcu_weight_data_process($devCode, $statCode, $content)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $format = "A2Cmd/A2Len/A2Opt/A2Num/A8W01/A8W02/A8W03/A8W04/A8W05/A8W06/A8W07/A8W08/A8W09/A8W10/A8W11/A8W12";
        $data = unpack($format, $content);
        $w01 = hexdec($data['W01']) & 0xFFFFFFFF;
        $w02 = hexdec($data['W02']) & 0xFFFFFFFF;
        $w03 = hexdec($data['W03']) & 0xFFFFFFFF;
        $w04 = hexdec($data['W04']) & 0xFFFFFFFF;
        $w05 = hexdec($data['W05']) & 0xFFFFFFFF;
        $w06 = hexdec($data['W06']) & 0xFFFFFFFF;
        $w07 = hexdec($data['W07']) & 0xFFFFFFFF;
        $w08 = hexdec($data['W08']) & 0xFFFFFFFF;
        $w09 = hexdec($data['W09']) & 0xFFFFFFFF;
        $w10 = hexdec($data['W10']) & 0xFFFFFFFF;
        $w11 = hexdec($data['W11']) & 0xFFFFFFFF;
        $w12 = hexdec($data['W12']) & 0xFFFFFFFF;

        $status = MFUN_HCU_BFSC_STATUS_OK;

        $timestamp = time();
        $date = intval(date("ymd", $timestamp));
        $temp = getdate($timestamp);
        $hourminindex = intval(($temp["hours"] * 60 + floor($temp["minutes"]/MFUN_HCU_FHYS_TIME_GRID_SIZE)));

        //更新分钟报告表
        /*
        $result = $mysqli->query("SELECT * FROM `t_l2snr_fhys_minreport` WHERE (( `devcode` = '$devCode' AND `statcode` = '$statCode')
                        AND (`reportdate` = '$date' AND `hourminindex` = '$hourminindex'))");
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $query_str = "UPDATE `t_l2snr_fhys_minreport` SET `waterstat` = '$status' WHERE (`devcode` = '$devCode' AND `statcode` = '$statCode' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')";
            $result = $mysqli->query($query_str);
        }
        else
        {
            $query_str = "INSERT INTO `t_l2snr_fhys_minreport` (devcode,statcode,waterstat,reportdate,hourminindex) VALUES ('$devCode','$statCode','$status', '$date', '$hourminindex')";
            $result = $mysqli->query($query_str);
        }
        */

        //更新当前聚合表
        $currenttime = date("Y-m-d H:i:s",$timestamp);
        $result = $mysqli->query("SELECT * FROM `t_l3f3dm_bfsc_currentreport` WHERE (`devcode` = '$devCode') ");
        if (($result->num_rows)>0) {
            $query_str = "UPDATE `t_l3f3dm_bfsc_currentreport` SET  `devcode` = '$devCode', `statcode` = '$statCode', `createtime` = '$currenttime', `status` = '$status',
                            `weight_01` = '$w01', `weight_02` = '$w02',`weight_03` = '$w03',`weight_04` = '$w04',`weight_05` = '$w05',`weight_06` = '$w06',`weight_07` = '$w07',`weight_08` = '$w08',`weight_09` = '$w09',`weight_10` = '$w10',`weight_11` = '$w11',`weight_12` = '$w12' WHERE (`devcode` = '$devCode')";
            $result = $mysqli->query($query_str);
        }
        else {
            $query_str ="INSERT INTO `t_l3f3dm_bfsc_currentreport` (devcode,statcode,createtime,status,weight_01,weight_02,weight_03,weight_04,weight_05,weight_06,weight_07,weight_08,weight_09,weight_10,weight_11,weight_12)
                          VALUES ('$devCode','$statCode','$currenttime','$status','$w01','$w02','$w03','$w04','$w05','$w06','$w07','$w08','$w09','$w10','$w11','$w12')";
            $result = $mysqli->query($query_str);
        }

        $mysqli->close();
        return $result;
    }

    public function dbi_hcu_weight_alarm_process($devCode, $statCode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("SET NAMES utf8");

        $status = MFUN_HCU_FHYS_ALARM_YES;
        $timestamp = time();
        $date = intval(date("ymd", $timestamp));
        $temp = getdate($timestamp);
        $hourminindex = intval(($temp["hours"] * 60 + floor($temp["minutes"]/MFUN_HCU_FHYS_TIME_GRID_SIZE)));

        //更新分钟报告表
        $result = $mysqli->query("SELECT * FROM `t_l2snr_fhys_minreport` WHERE (( `devcode` = '$devCode' AND `statcode` = '$statCode')
                        AND (`reportdate` = '$date' AND `hourminindex` = '$hourminindex'))");
        if (($result != false) && ($result->num_rows)>0)   //重复，则覆盖
        {
            $query_str = "UPDATE `t_l2snr_fhys_minreport` SET `wateralarm` = '$status' WHERE (`devcode` = '$devCode' AND `statcode` = '$statCode' AND `reportdate` = '$date' AND `hourminindex` = '$hourminindex')";
            $result = $mysqli->query($query_str);
        }
        else
        {
            $query_str = "INSERT INTO `t_l2snr_fhys_minreport` (devcode,statcode,wateralarm,reportdate,hourminindex) VALUES ('$devCode','$statCode','$status', '$date', '$hourminindex')";
            $result = $mysqli->query($query_str);
        }

        //更新当前聚合表
        $currenttime = date("Y-m-d H:i:s",$timestamp);
        $result = $mysqli->query("SELECT * FROM `t_l3f3dm_fhys_currentreport` WHERE (`devcode` = '$devCode') ");
        if (($result->num_rows)>0) {
            $query_str = "UPDATE `t_l3f3dm_fhys_currentreport` SET  `wateralarm` = '$status', `createtime` = '$currenttime' WHERE (`devcode` = '$devCode')";
            $result = $mysqli->query($query_str);
        }
        else {
            $query_str = "INSERT INTO `t_l3f3dm_fhys_currentreport` (devcode,statcode,createtime,wateralarm) VALUES ('$devCode','$statCode','$currenttime','$status')";
            $result = $mysqli->query($query_str);
        }

        //返回Response
        $query_str = "SELECT * FROM `t_l2sdk_iothcu_inventory` WHERE (`statcode` = '$statCode' AND `devcode` = '$devCode')";
        $result = $mysqli->query($query_str);

        if (($result != false) && ($result->num_rows)>0)
        {
            //生成控制命令的控制字
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_FHYS_WATER);
            $opt_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_OPT_FHYS_WATERALARM_RESP);

            $len = $apiL2snrCommonServiceObj->byte2string(strlen($opt_key)/2);
            $respCmd = $ctrl_key . $len . $opt_key;

            //通过9502端口建立tcp阻塞式socket连接，向HCU转发操控命令
            $client = new socket_client_sync($devCode, $respCmd);
            $client->connect();
            $resp = "Sensor water alarm response send success";
        }
        else
            $resp = "Sensor water alarm response send failure";

        $mysqli->close();
        return $resp;
    }

}

?>