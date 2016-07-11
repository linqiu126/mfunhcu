<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/7/11
 * Time: 12:12
 */
class classTaskL2snrIpm
{
    //构造函数
    public function __construct()
    {

    }

    function func_afn_ul_confirm_nor_process($user)
    {
        $ipmObj = new classDbiL2snrIpm(); //初始化一个UI DB对象
        $jsonencode = json_encode($ipmObj);
        return $jsonencode;
    }

    function func_afn_ul_reset_process($user)
    {
        $ipmObj = new classDbiL2snrIpm(); //初始化一个UI DB对象
        $jsonencode = json_encode($ipmObj);
        return $jsonencode;
    }

    function func_afn_ul_link_check_process($user)
    {
        $ipmObj = new classDbiL2snrIpm(); //初始化一个UI DB对象
        $jsonencode = json_encode($ipmObj);
        return $jsonencode;
    }

    function func_afn_ul_relay_process($user)
    {
        $ipmObj = new classDbiL2snrIpm(); //初始化一个UI DB对象
        $jsonencode = json_encode($ipmObj);
        return $jsonencode;
    }

    function func_afn_ul_set_parameter_process($user)
    {
        $ipmObj = new classDbiL2snrIpm(); //初始化一个UI DB对象
        $jsonencode = json_encode($ipmObj);
        return $jsonencode;
    }

    function func_afn_ul_control_process($user)
    {
        $ipmObj = new classDbiL2snrIpm(); //初始化一个UI DB对象
        $jsonencode = json_encode($ipmObj);
        return $jsonencode;
    }

    function func_afn_ul_security_nego_process($user)
    {
        $ipmObj = new classDbiL2snrIpm(); //初始化一个UI DB对象
        $jsonencode = json_encode($ipmObj);
        return $jsonencode;
    }

    function func_afn_ul_req_report_process($user)
    {
        $ipmObj = new classDbiL2snrIpm(); //初始化一个UI DB对象
        $jsonencode = json_encode($ipmObj);
        return $jsonencode;
    }

    function func_afn_ul_req_config_process($user)
    {
        $ipmObj = new classDbiL2snrIpm(); //初始化一个UI DB对象
        $jsonencode = json_encode($ipmObj);
        return $jsonencode;
    }

    function func_afn_ul_inqury_parameter_process($user)
    {
        $ipmObj = new classDbiL2snrIpm(); //初始化一个UI DB对象
        $jsonencode = json_encode($ipmObj);
        return $jsonencode;
    }

    function func_afn_ul_req_task_process($user)
    {
        $ipmObj = new classDbiL2snrIpm(); //初始化一个UI DB对象
        $jsonencode = json_encode($ipmObj);
        return $jsonencode;
    }

    function func_afn_ul_req_data1_process($user)
    {
        $ipmObj = new classDbiL2snrIpm(); //初始化一个UI DB对象
        $jsonencode = json_encode($ipmObj);
        return $jsonencode;
    }

    function func_afn_ul_req_data2_process($user)
    {
        $ipmObj = new classDbiL2snrIpm(); //初始化一个UI DB对象
        $jsonencode = json_encode($ipmObj);
        return $jsonencode;
    }

    function func_afn_ul_req_data3_process($user)
    {
        $ipmObj = new classDbiL2snrIpm(); //初始化一个UI DB对象
        $jsonencode = json_encode($ipmObj);
        return $jsonencode;
    }

    function func_afn_ul_file_transfer_process($user)
    {
        $ipmObj = new classDbiL2snrIpm(); //初始化一个UI DB对象
        $jsonencode = json_encode($ipmObj);
        return $jsonencode;
    }

    function func_afn_ul_data_forward_process($user)
    {
        $ipmObj = new classDbiL2snrIpm(); //初始化一个UI DB对象
        $jsonencode = json_encode($ipmObj);
        return $jsonencode;
    }


    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2snr_ipm_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());
        $project = "";

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_IPM", "mfun_l2snr_ipm_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到L2SNR_IPM，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_IPM", "mfun_l2snr_ipm_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        //上报CONFIRM
        if ($msgId == MSG_ID_L2SDK_NBIOT_IPM376_TO_L2SNR_IPM_AFN_UL_CNFNG)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_confirm_nor_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //上报RESET
        if ($msgId == MSG_ID_L2SDK_NBIOT_IPM376_TO_L2SNR_IPM_AFN_UL_RESET)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_reset_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //上报LK_CHECK
        if ($msgId == MSG_ID_L2SDK_NBIOT_IPM376_TO_L2SNR_IPM_AFN_UL_LICK)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_link_check_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //上报RELAY
        if ($msgId == MSG_ID_L2SDK_NBIOT_IPM376_TO_L2SNR_IPM_AFN_UL_RELAY)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_relay_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //上报SET Parameter
        if ($msgId == MSG_ID_L2SDK_NBIOT_IPM376_TO_L2SNR_IPM_AFN_UL_SETPAR)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_set_parameter_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //上报CONTROL
        if ($msgId == MSG_ID_L2SDK_NBIOT_IPM376_TO_L2SNR_IPM_AFN_UL_CONTROL)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_control_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //上报Security Negotiation
        if ($msgId == MSG_ID_L2SDK_NBIOT_IPM376_TO_L2SNR_IPM_AFN_UL_SECNEG)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_security_nego_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //上报REQUEST REPORT
        if ($msgId == MSG_ID_L2SDK_NBIOT_IPM376_TO_L2SNR_IPM_AFN_UL_REQREP)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_req_report_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //上报REQUEST CONFIG
        if ($msgId == MSG_ID_L2SDK_NBIOT_IPM376_TO_L2SNR_IPM_AFN_UL_REQCFG)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_req_config_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //上报INQURY PARAMETER
        if ($msgId == MSG_ID_L2SDK_NBIOT_IPM376_TO_L2SNR_IPM_AFN_UL_INQPAR)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_inqury_parameter_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //上报REQUEST TASK
        if ($msgId == MSG_ID_L2SDK_NBIOT_IPM376_TO_L2SNR_IPM_AFN_UL_REQTSK)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_req_task_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //上报REQUEST DATA1
        if ($msgId == MSG_ID_L2SDK_NBIOT_IPM376_TO_L2SNR_IPM_AFN_UL_REQDATA1)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_req_data1_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //上报REQUEST DATA2
        if ($msgId == MSG_ID_L2SDK_NBIOT_IPM376_TO_L2SNR_IPM_AFN_UL_REQDATA2)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_req_data2_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //上报REQUEST DATA3
        if ($msgId == MSG_ID_L2SDK_NBIOT_IPM376_TO_L2SNR_IPM_AFN_UL_REQDATA3)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_req_data3_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //上报FILE TRANSFER
        if ($msgId == MSG_ID_L2SDK_NBIOT_IPM376_TO_L2SNR_IPM_AFN_UL_FILETRNS)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_file_transfer_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //上报DATA FORWARD
        if ($msgId == MSG_ID_L2SDK_NBIOT_IPM376_TO_L2SNR_IPM_AFN_UL_DATAFWD)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_data_forward_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, "MFUN_TASK_ID_L2SNR_IPM", $log_time, $log_content);
            echo trim($resp);
        }

        //返回
        return true;
    }

}

?>