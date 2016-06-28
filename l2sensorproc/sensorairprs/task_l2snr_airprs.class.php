<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:24
 */
include_once "../../l1comvm/vmlayer.php";
include_once "dbi_l2snr_airprs.class.php";

class classTaskL2snrAirprs
{
    //构造函数
    public function __construct()
    {

    }

    public function func_airprs_data_process($platform, $deviceId, $statCode, $content)
    {
        return true;
    }

    //任务入口函数
    public function mfun_l2snr_airprs_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classL1vmFuncComApi();
        $log_time = date("Y-m-d H:i:s", time());

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_AIRPRS", "mfun_l2snr_airprs_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        if (($msgId != MSG_ID_L2SDK_HCU_TO_L2SNR_AIRPRS) || ($msgName != "MSG_ID_L2SDK_HCU_TO_L2SNR_AIRPRS")){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_AIRPRS", "mfun_l2snr_airprs_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        //解开消息
        $project= "";
        $log_from = "";
        $platform ="";
        $deviceId="";
        $statCode = "";
        $content="";
        if (isset($msg["project"])) $project = $msg["project"];
        if (isset($msg["log_from"])) $log_from = $msg["log_from"];
        if (isset($msg["platform"])) $platform = $msg["platform"];
        if (isset($msg["deviceId"])) $deviceId = $msg["deviceId"];
        if (isset($msg["statCode"])) $statCode = $msg["statCode"];
        if (isset($msg["content"])) $content = $msg["content"];

        //具体处理函数
        $resp = $this->func_airprs_data_process($platform, $deviceId, $statCode, $content);

        //返回ECHO
        $log_content = "T:" . json_encode($resp);
        $loggerObj->logger($project, $log_from, $log_time, $log_content);
        echo trim($resp);
        return true;
    }

}//End of class_task_service

?>