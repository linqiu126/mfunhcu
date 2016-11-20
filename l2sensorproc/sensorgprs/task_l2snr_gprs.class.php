<?php
/**
 * Created by PhpStorm.
 * User: zehongl
 * Date: 2016/11/7
 * Time: 21:37
 */


include_once "dbi_l2snr_gprs.class.php";

class classTaskL2snrGprs
{
    //构造函数
    public function __construct()
    {

    }

    public function func_gprs_data_process($platform, $devCode, $statCode, $content)
    {
        $raw_MsgHead = substr($content, 0, MFUN_HCU_MSG_HEAD_LENGTH);  //截取6Byte MsgHead
        $msgHead = unpack(MFUN_HCU_MSG_HEAD_FORMAT, $raw_MsgHead);
        $length = hexdec($msgHead['Len']) & 0xFF;
        $length =  ($length+2) * 2; //因为收到的消息为16进制字符，消息总长度等于length＋1B控制字＋1B长度本身
        if ($length != strlen($content)) {
            return "ERROR FHYS_GPRS: message length invalid";  //消息长度不合法，直接返回
        }

        $opt_key = hexdec($msgHead['Cmd']) & 0xFF;

        if ($opt_key == MFUN_HCU_OPT_FHYS_GPRSSTAT_IND){
            $data = substr($content, MFUN_HCU_MSG_HEAD_LENGTH, 2);
            $data = hexdec($data) & 0xFF;
            $classDbiL2snrGprs = new classDbiL2snrGprs();
            $resp = $classDbiL2snrGprs->dbi_hcu_gprs_status_update($devCode, $statCode, $data);
        }
        elseif ($opt_key == MFUN_HCU_OPT_FHYS_SIGLEVEL_IND){
            $data = substr($content, MFUN_HCU_MSG_HEAD_LENGTH, 2);
            $data = hexdec($data) & 0xFF;
            $classDbiL2snrGprs = new classDbiL2snrGprs();
            $resp = $classDbiL2snrGprs->dbi_hcu_sig_level_process($devCode, $statCode, $data);
        }
        else
            $resp = "ERROR FHYS_GPRS: Invalid Operation Command";

        return $resp;
    }


    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2snr_gprs_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_GPRS", "mfun_l2snr_gprs_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        if (($msgId != MSG_ID_L2SDK_HCU_TO_L2SNR_GPRS) || ($msgName != "MSG_ID_L2SDK_HCU_TO_L2SNR_GPRS")){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_GPRS", "mfun_l2snr_gprs_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        //初始化消息内容
        $project= "";
        $log_from = "";
        $platform ="";
        $deviceId="";
        $statCode = "";
        $content="";

        //具体处理函数
        if ($msgId == MSG_ID_L2SDK_HCU_TO_L2SNR_GPRS)
        {
            if (isset($msg["project"])) $project = $msg["project"];
            if (isset($msg["log_from"])) $log_from = $msg["log_from"];
            if (isset($msg["platform"])) $platform = $msg["platform"];
            if (isset($msg["deviceId"])) $deviceId = $msg["deviceId"];
            if (isset($msg["statCode"])) $statCode = $msg["statCode"];
            if (isset($msg["content"])) $content = $msg["content"];
            $resp = $this->func_gprs_data_process($platform, $deviceId, $statCode, $content);
        }
        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, $log_from, $log_time, $log_content);
            echo trim($resp);
        }

        //返回
        return true;
    }

}//End of class_task_service

?>