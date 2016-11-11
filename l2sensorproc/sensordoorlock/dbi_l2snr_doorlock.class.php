<?php
/**
 * Created by PhpStorm.
 * User: zehongl
 * Date: 2016/11/7
 * Time: 21:35
 */

class classDbiL2snrDoorlock
{
    //构造函数
    public function __construct()
    {

    }

//HCU_Lock_Status
    public function dbi_hcu_lock_status($uid, $StatCode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        //根据StatCode查找特定HCU
        $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$StatCode' ";
        $result = $mysqli->query($query_str);

        if (($result != false) && ($result->num_rows)>0)
        {
            //生成控制命令的控制字
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_FHYS_LOCK);
            $opt_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_OPT_STATUS_REQ);

            $row = $result->fetch_array();  //statcode和devcode一一对应
            $DevCode = $row['devcode'];

            $len = $apiL2snrCommonServiceObj->byte2string(strlen($opt_key)/2);
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

    //HCU_Lock_Open
    public function dbi_hcu_lock_open($uid, $StatCode)
    {
        //建立连接
        $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
        if (!$mysqli) {
            die('Could not connect: ' . mysqli_error($mysqli));
        }
        $mysqli->query("set character_set_results = utf8");

        //根据StatCode查找特定HCU
        $query_str = "SELECT * FROM `t_l3f3dm_siteinfo` WHERE `statcode` = '$StatCode' ";
        $result = $mysqli->query($query_str);

        if (($result != false) && ($result->num_rows)>0)
        {
            //生成控制命令的控制字
            $apiL2snrCommonServiceObj = new classApiL2snrCommonService();
            $ctrl_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_CMDID_FHYS_LOCK);
            $opt_key = $apiL2snrCommonServiceObj->byte2string(MFUN_HCU_OPT_FHYS_LOCKOPEN_PUSH);
            $para = "00";

            $row = $result->fetch_array();  //statcode和devcode一一对应
            $DevCode = $row['devcode'];

            $len = $apiL2snrCommonServiceObj->byte2string(strlen($opt_key.$para)/2);
            $respCmd = $ctrl_key . $len . $opt_key . $para;

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


}

?>