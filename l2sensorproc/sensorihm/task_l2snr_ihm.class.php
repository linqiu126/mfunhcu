<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/7/15
 * Time: 10:12
 */
class classTaskL2snrIhm
{
    //构造函数
    public function __construct()
    {

    }

    function func_ihm_cj188_ul_read_data_process($user)
    {
        $ihmObj = new classDbiL2snrIhm(); //初始化一个UI DB对象
        $jsonencode = json_encode($ihmObj);
        return $jsonencode;
    }

    function func_ihm_cj188_ul_read_key_ver_process($user)
    {
        $ihmObj = new classDbiL2snrIhm(); //初始化一个UI DB对象
        $jsonencode = json_encode($ihmObj);
        return $jsonencode;
    }

    function func_ihm_cj188_ul_read_address_process($user)
    {
        $ihmObj = new classDbiL2snrIhm(); //初始化一个UI DB对象
        $jsonencode = json_encode($ihmObj);
        return $jsonencode;
    }


    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2snr_ihm_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());
        $project = "";

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_IHM", "mfun_l2snr_ihm_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到L2SNR_IHM，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_IHM", "mfun_l2snr_ihm_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        //CJ188规范中上报READ DATA
        if ($msgId == MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IHM_READ_DATA)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_ihm_cj188_ul_read_data_process($user);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        //CJ188规范中上报READ KEY VER
        elseif ($msgId == MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IHM_READ_KEY_VER)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_ihm_cj188_ul_read_key_ver_process($user);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        //CJ188规范中上报READ ADDRESS
        elseif ($msgId == MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IHM_READ_ADDR)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_ihm_cj188_ul_read_address_process($user);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, "MFUN_TASK_ID_L2SNR_IHM", $log_time, $log_content);
            echo trim($resp);
        }

        //返回
        return true;
    }

}

?>