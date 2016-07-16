<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/7/16
 * Time: 11:38
 */
//include_once "../l1comvm/vmlayer.php";

class classTaskL3nbiotOprMeter
{
    //构造函数
    public function __construct()
    {

    }

    function func_afn_reqdata1_f1_process($parObj, $user)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $jsonencode = json_encode($uiF1symDbObj);
        $input = $jsonencode;
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L3NBIOT_OPR_METER, MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376, MSG_ID_L3NBIOT_OPR_METERTO_STD_QG376_DL_REQUEST, "MSG_ID_L3NBIOT_OPR_METERTO_STD_QG376_DL_REQUEST", $input);
        return $jsonencode;
    }

    function func_afn_reqdata1_f2_process($parObj, $user)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $jsonencode = json_encode($uiF1symDbObj);
        $input = $jsonencode;
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L3NBIOT_OPR_METER, MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376, MSG_ID_L3NBIOT_OPR_METERTO_STD_QG376_DL_REQUEST, "MSG_ID_L3NBIOT_OPR_METERTO_STD_QG376_DL_REQUEST", $input);
        return $jsonencode;
    }

    function func_afn_reqdata1_f25_process($parObj, $user)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $jsonencode = json_encode($uiF1symDbObj);
        $input = $jsonencode;
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L3NBIOT_OPR_METER, MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376, MSG_ID_L3NBIOT_OPR_METERTO_STD_QG376_DL_REQUEST, "MSG_ID_L3NBIOT_OPR_METERTO_STD_QG376_DL_REQUEST", $input);
        return $jsonencode;
    }

    function func_afn_reqdata1_f26_process($parObj, $user)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $jsonencode = json_encode($uiF1symDbObj);
        $input = $jsonencode;
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L3NBIOT_OPR_METER, MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376, MSG_ID_L3NBIOT_OPR_METERTO_STD_QG376_DL_REQUEST, "MSG_ID_L3NBIOT_OPR_METERTO_STD_QG376_DL_REQUEST", $input);
        return $jsonencode;
    }

    function func_ipm_read_cur_cnt_data_process($parObj, $type, $len)
    {
        $D0D1 = dechex(MFUN_NBIOT_CJ188_READ_DI0DI1_CURRENT_COUNTER_DATA) & 0xFFFF;
        $D0 = $D0D1 & 0xFF00 >> 8;
        $D1 = $D0D1 & 0xFF;
        $ser = 0;
        $msgBody = $len . $D0 . $D1 . $ser;
        $msg = pack('H*',$msgBody);
        $input = array("type" => $type, "msgBody" => $msg);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L3NBIOT_OPR_METER, MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MSG_ID_L3NBIOT_OPR_METERTO_STD_CJ188_DL_REQUEST, "MSG_ID_L3NBIOT_OPR_METERTO_STD_CJ188_DL_REQUEST", $input);
        return "";
    }

    function func_ipm_read_his_cnt_data1_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ipm_read_his_cnt_data2_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ipm_read_his_cnt_data3_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ipm_read_his_cnt_data4_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ipm_read_his_cnt_data5_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ipm_read_his_cnt_data6_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ipm_read_his_cnt_data7_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ipm_read_his_cnt_data8_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ipm_read_his_cnt_data9_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ipm_read_his_cnt_data10_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ipm_read_his_cnt_data11_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ipm_read_his_cnt_data12_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ipm_read_price_table_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ipm_read_bill_date_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ipm_read_account_date_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ipm_read_buy_amount_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ipm_read_key_ver_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ipm_read_address_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ipm_write_price_table_process($parObj, $type, $len, $price1, $volume1, $price2, $volume2, $price3, $startdate)
    {
        return "";
    }

    function func_ipm_write_bill_date_process($parObj, $type, $len, $billdate)
    {
        return "";
    }

    function func_ipm_write_account_date_process($parObj, $type, $len, $accountdate)
    {
        return "";
    }

    function func_ipm_write_buy_amount_process($parObj, $type, $len, $buycode, $buyamount)
    {
        return "";
    }

    function func_ipm_write_new_key_process($parObj, $type, $len, $kerver, $newkey)
    {
        return "";
    }

    function func_ipm_write_std_time_process($parObj, $type, $len, $realtime)
    {
        return "";
    }

    function func_ipm_write_switch_ctrl_process($parObj, $type, $len, $switch)
    {
        return "";
    }

    function func_ipm_write_off_fac_start_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ipm_write_address_process($parObj, $type, $len, $newaddr)
    {
        return "";
    }

    function func_ipm_write_device_syn_process($parObj, $type, $len, $curaccumvolume)
    {
        return "";
    }

    function func_iwm_read_cur_cnt_data_process($parObj, $type, $len)
    {
        return "";
    }

    function func_iwm_read_his_cnt_data1_process($parObj, $type, $len)
    {
        return "";
    }

    function func_iwm_read_his_cnt_data2_process($parObj, $type, $len)
    {
        return "";
    }

    function func_iwm_read_his_cnt_data3_process($parObj, $type, $len)
    {
        return "";
    }

    function func_iwm_read_his_cnt_data4_process($parObj, $type, $len)
    {
        return "";
    }

    function func_iwm_read_his_cnt_data5_process($parObj, $type, $len)
    {
        return "";
    }

    function func_iwm_read_his_cnt_data6_process($parObj, $type, $len)
    {
        return "";
    }

    function func_iwm_read_his_cnt_data7_process($parObj, $type, $len)
    {
        return "";
    }

    function func_iwm_read_his_cnt_data8_process($parObj, $type, $len)
    {
        return "";
    }

    function func_iwm_read_his_cnt_data9_process($parObj, $type, $len)
    {
        return "";
    }

    function func_iwm_read_his_cnt_data10_process($parObj, $type, $len)
    {
        return "";
    }

    function func_iwm_read_his_cnt_data11_process($parObj, $type, $len)
    {
        return "";
    }

    function func_iwm_read_his_cnt_data12_process($parObj, $type, $len)
    {
        return "";
    }

    function func_iwm_read_price_table_process($parObj, $type, $len)
    {
        return "";
    }

    function func_iwm_read_bill_date_process($parObj, $type, $len)
    {
        return "";
    }

    function func_iwm_read_account_date_process($parObj, $type, $len)
    {
        return "";
    }

    function func_iwm_read_buy_amount_process($parObj, $type, $len)
    {
        return "";
    }

    function func_iwm_read_key_ver_process($parObj, $type, $len)
    {
        return "";
    }

    function func_iwm_read_address_process($parObj, $type, $len)
    {
        return "";
    }

    function func_iwm_write_price_table_process($parObj, $type, $len, $price1, $volume1, $price2, $volume2, $price3, $startdate)
    {
        return "";
    }

    function func_iwm_write_bill_date_process($parObj, $type, $len, $billdate)
    {
        return "";
    }

    function func_iwm_write_account_date_process($parObj, $type, $len, $accountdate)
    {
        return "";
    }

    function func_iwm_write_buy_amount_process($parObj, $type, $len, $buycode, $buyamount)
    {
        return "";
    }

    function func_iwm_write_new_key_process($parObj, $type, $len, $kerver, $newkey)
    {
        return "";
    }

    function func_iwm_write_std_time_process($parObj, $type, $len, $realtime)
    {
        return "";
    }

    function func_iwm_write_switch_ctrl_process($parObj, $type, $len, $switch)
    {
        return "";
    }

    function func_iwm_write_off_fac_start_process($parObj, $type, $len)
    {
        return "";
    }

    function func_iwm_write_address_process($parObj, $type, $len, $newaddr)
    {
        return "";
    }

    function func_iwm_write_device_syn_process($parObj, $type, $len, $curaccumvolume)
    {
        return "";
    }

    function func_igm_read_cur_cnt_data_process($parObj, $type, $len)
    {
        return "";
    }

    function func_igm_read_his_cnt_data1_process($parObj, $type, $len)
    {
        return "";
    }

    function func_igm_read_his_cnt_data2_process($parObj, $type, $len)
    {
        return "";
    }

    function func_igm_read_his_cnt_data3_process($parObj, $type, $len)
    {
        return "";
    }

    function func_igm_read_his_cnt_data4_process($parObj, $type, $len)
    {
        return "";
    }

    function func_igm_read_his_cnt_data5_process($parObj, $type, $len)
    {
        return "";
    }

    function func_igm_read_his_cnt_data6_process($parObj, $type, $len)
    {
        return "";
    }

    function func_igm_read_his_cnt_data7_process($parObj, $type, $len)
    {
        return "";
    }

    function func_igm_read_his_cnt_data8_process($parObj, $type, $len)
    {
        return "";
    }

    function func_igm_read_his_cnt_data9_process($parObj, $type, $len)
    {
        return "";
    }

    function func_igm_read_his_cnt_data10_process($parObj, $type, $len)
    {
        return "";
    }

    function func_igm_read_his_cnt_data11_process($parObj, $type, $len)
    {
        return "";
    }

    function func_igm_read_his_cnt_data12_process($parObj, $type, $len)
    {
        return "";
    }

    function func_igm_read_price_table_process($parObj, $type, $len)
    {
        return "";
    }

    function func_igm_read_bill_date_process($parObj, $type, $len)
    {
        return "";
    }

    function func_igm_read_account_date_process($parObj, $type, $len)
    {
        return "";
    }

    function func_igm_read_buy_amount_process($parObj, $type, $len)
    {
        return "";
    }

    function func_igm_read_key_ver_process($parObj, $type, $len)
    {
        return "";
    }

    function func_igm_read_address_process($parObj, $type, $len)
    {
        return "";
    }

    function func_igm_write_price_table_process($parObj, $type, $len, $price1, $volume1, $price2, $volume2, $price3, $startdate)
    {
        return "";
    }

    function func_igm_write_bill_date_process($parObj, $type, $len, $billdate)
    {
        return "";
    }

    function func_igm_write_account_date_process($parObj, $type, $len, $accountdate)
    {
        return "";
    }

    function func_igm_write_buy_amount_process($parObj, $type, $len, $buycode, $buyamount)
    {
        return "";
    }

    function func_igm_write_new_key_process($parObj, $type, $len, $kerver, $newkey)
    {
        return "";
    }

    function func_igm_write_std_time_process($parObj, $type, $len, $realtime)
    {
        return "";
    }

    function func_igm_write_switch_ctrl_process($parObj, $type, $len, $switch)
    {
        return "";
    }

    function func_igm_write_off_fac_start_process($parObj, $type, $len)
    {
        return "";
    }

    function func_igm_write_address_process($parObj, $type, $len, $newaddr)
    {
        return "";
    }

    function func_igm_write_device_syn_process($parObj, $type, $len, $curaccumvolume)
    {
        return "";
    }

    function func_ihm_read_cur_cnt_data_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ihm_read_his_cnt_data1_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ihm_read_his_cnt_data2_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ihm_read_his_cnt_data3_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ihm_read_his_cnt_data4_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ihm_read_his_cnt_data5_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ihm_read_his_cnt_data6_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ihm_read_his_cnt_data7_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ihm_read_his_cnt_data8_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ihm_read_his_cnt_data9_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ihm_read_his_cnt_data10_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ihm_read_his_cnt_data11_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ihm_read_his_cnt_data12_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ihm_read_price_table_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ihm_read_bill_date_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ihm_read_account_date_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ihm_read_buy_amount_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ihm_read_key_ver_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ihm_read_address_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ihm_write_price_table_process($parObj, $type, $len, $price1, $volume1, $price2, $volume2, $price3, $startdate)
    {
        return "";
    }

    function func_ihm_write_bill_date_process($parObj, $type, $len, $billdate)
    {
        return "";
    }

    function func_ihm_write_account_date_process($parObj, $type, $len, $accountdate)
    {
        return "";
    }

    function func_ihm_write_buy_amount_process($parObj, $type, $len, $buycode, $buyamount)
    {
        return "";
    }

    function func_ihm_write_new_key_process($parObj, $type, $len, $kerver, $newkey)
    {
        return "";
    }

    function func_ihm_write_std_time_process($parObj, $type, $len, $realtime)
    {
        return "";
    }

    function func_ihm_write_switch_ctrl_process($parObj, $type, $len, $switch)
    {
        return "";
    }

    function func_ihm_write_off_fac_start_process($parObj, $type, $len)
    {
        return "";
    }

    function func_ihm_write_address_process($parObj, $type, $len, $newaddr)
    {
        return "";
    }

    function func_ihm_write_device_syn_process($parObj, $type, $len, $curaccumvolume)
    {
        return "";
    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l3nbiot_opr_meter_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());
        $project ="";

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3NBIOT_OPR_METER", "mfun_l3nbiot_opr_meter_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到L3APPL_FXPRCM，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3NBIOT_OPR_METER", "mfun_l3nbiot_opr_meter_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        //功能 afn_reqdata1_f1
        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_AFN_REQDATA1_F1)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_reqdata1_f1_process($parObj, $user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //功能 afn_reqdata1_f2
        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_AFN_REQDATA1_F2)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_reqdata1_f2_process($parObj, $user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //功能 afn_reqdata1_f25
        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_AFN_REQDATA1_F25)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_reqdata1_f25_process($parObj, $user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //功能 afn_reqdata1_f26
        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_AFN_REQDATA1_F26)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_reqdata1_f26_process($parObj, $user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_CURRENT_COUNTER_DATA)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ipm_read_cur_cnt_data_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA1)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ipm_read_his_cnt_data1_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA2)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ipm_read_his_cnt_data2_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA3)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ipm_read_his_cnt_data3_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA4)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ipm_read_his_cnt_data4_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA5)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ipm_read_his_cnt_data5_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA6)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ipm_read_his_cnt_data6_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA7)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ipm_read_his_cnt_data7_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA8)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ipm_read_his_cnt_data8_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA9)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ipm_read_his_cnt_data9_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA10)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ipm_read_his_cnt_data10_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA11)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ipm_read_his_cnt_data11_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA12)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ipm_read_his_cnt_data12_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_PRICE_TABLE)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ipm_read_price_table_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_BILL_DATE)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ipm_read_bill_date_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_ACCOUNT_DATE)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ipm_read_account_date_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_BUY_AMOUNT)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ipm_read_buy_amount_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_KEY_VER)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ipm_read_key_ver_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_READ_DI0DI1_ADDRESS)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ipm_read_address_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_PRICE_TABLE)
        {
            //解开消息
            if (isset($msg["len"])) $len = trim($msg["len"]); else $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["price1"])) $price1 = trim($msg["price1"]); else $price1 = "";
            if (isset($msg["volume1"])) $volume1 = trim($msg["volume1"]); else $volume1 = "";
            if (isset($msg["price2"])) $price2 = trim($msg["price2"]); else $price2 = "";
            if (isset($msg["volume2"])) $volume2 = trim($msg["volume2"]); else $volume2 = "";
            if (isset($msg["price3"])) $price3 = trim($msg["price3"]); else $price3 = "";
            if (isset($msg["startdate"])) $startdate = trim($msg["startdate"]); else $startdate = "";

            //具体处理函数
            $resp = $this->func_ipm_write_price_table_process($parObj, $type, $len, $price1, $volume1, $price2, $volume2, $price3, $startdate);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_BILL_DATE)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["billdate"])) $billdate = trim($msg["billdate"]); else $billdate = "";
            //具体处理函数
            $resp = $this->func_ipm_write_bill_date_process($parObj, $type, $len, $billdate);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_ACCOUNT_DATE)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["accountdate"])) $accountdate = trim($msg["accountdate"]); else $accountdate = "";
            //具体处理函数
            $resp = $this->func_ipm_write_account_date_process($parObj, $type, $len, $accountdate);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_BUY_AMOUNT)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["buycode"])) $buycode = trim($msg["buycode"]); else $buycode = "";
            if (isset($msg["buyamount"])) $buyamount = trim($msg["buyamount"]); else $buyamount = "";
            //具体处理函数
            $resp = $this->func_ipm_write_buy_amount_process($parObj, $type, $len, $buycode, $buyamount);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_NEW_KEY)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["kerver"])) $kerver = trim($msg["kerver"]); else $kerver = "";
            if (isset($msg["newkey"])) $newkey = trim($msg["newkey"]); else $newkey = "";
            //具体处理函数
            $resp = $this->func_ipm_write_new_key_process($parObj, $type, $len, $kerver, $newkey);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_STD_TIME)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["realtime"])) $realtime = trim($msg["realtime"]); else $realtime = "";
            //具体处理函数
            $resp = $this->func_ipm_write_std_time_process($parObj, $type, $len, $realtime);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_SWITCH_CTRL)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["switch"])) $switch = trim($msg["switch"]); else $switch = "";
            //具体处理函数
            $resp = $this->func_ipm_write_switch_ctrl_process($parObj, $type, $len, $switch);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_OFF_FACTORY_START)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ipm_write_off_fac_start_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_ADDRESS)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["newaddr"])) $newaddr = trim($msg["newaddr"]); else $newaddr = "";
            //具体处理函数
            $resp = $this->func_ipm_write_address_process($parObj, $type, $len, $newaddr);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IPMUI_TO_L3OPR_METER_DL_WRITE_DEVICE_SYN_DATA)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["curaccumvolume"])) $curaccumvolume = trim($msg["curaccumvolume"]); else $curaccumvolume = "";
            //具体处理函数
            $resp = $this->func_ipm_write_device_syn_process($parObj, $type, $len, $curaccumvolume);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_READ_DI0DI1_CURRENT_COUNTER_DATA)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_iwm_read_cur_cnt_data_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA1)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_iwm_read_his_cnt_data1_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA2)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_iwm_read_his_cnt_data2_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA3)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_iwm_read_his_cnt_data3_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA4)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_iwm_read_his_cnt_data4_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA5)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_iwm_read_his_cnt_data5_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA6)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_iwm_read_his_cnt_data6_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA7)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_iwm_read_his_cnt_data7_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA8)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_iwm_read_his_cnt_data8_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA9)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_iwm_read_his_cnt_data9_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA10)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_iwm_read_his_cnt_data10_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA11)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_iwm_read_his_cnt_data11_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA12)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_iwm_read_his_cnt_data12_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_READ_DI0DI1_PRICE_TABLE)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_iwm_read_price_table_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_READ_DI0DI1_BILL_DATE)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_iwm_read_bill_date_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_READ_DI0DI1_ACCOUNT_DATE)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_iwm_read_account_date_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_READ_DI0DI1_BUY_AMOUNT)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_iwm_read_buy_amount_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_READ_DI0DI1_KEY_VER)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_iwm_read_key_ver_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_READ_DI0DI1_ADDRESS)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_iwm_read_address_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_PRICE_TABLE)
        {
            //解开消息
            if (isset($msg["len"])) $len = trim($msg["len"]); else $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["price1"])) $price1 = trim($msg["price1"]); else $price1 = "";
            if (isset($msg["volume1"])) $volume1 = trim($msg["volume1"]); else $volume1 = "";
            if (isset($msg["price2"])) $price2 = trim($msg["price2"]); else $price2 = "";
            if (isset($msg["volume2"])) $volume2 = trim($msg["volume2"]); else $volume2 = "";
            if (isset($msg["price3"])) $price3 = trim($msg["price3"]); else $price3 = "";
            if (isset($msg["startdate"])) $startdate = trim($msg["startdate"]); else $startdate = "";

            //具体处理函数
            $resp = $this->func_iwm_write_price_table_process($parObj, $type, $len, $price1, $volume1, $price2, $volume2, $price3, $startdate);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_BILL_DATE)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["billdate"])) $billdate = trim($msg["billdate"]); else $billdate = "";
            //具体处理函数
            $resp = $this->func_iwm_write_bill_date_process($parObj, $type, $len, $billdate);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_ACCOUNT_DATE)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["accountdate"])) $accountdate = trim($msg["accountdate"]); else $accountdate = "";
            //具体处理函数
            $resp = $this->func_iwm_write_account_date_process($parObj, $type, $len, $accountdate);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_BUY_AMOUNT)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["buycode"])) $buycode = trim($msg["buycode"]); else $buycode = "";
            if (isset($msg["buyamount"])) $buyamount = trim($msg["buyamount"]); else $buyamount = "";
            //具体处理函数
            $resp = $this->func_iwm_write_buy_amount_process($parObj, $type, $len, $buycode, $buyamount);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_NEW_KEY)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["kerver"])) $kerver = trim($msg["kerver"]); else $kerver = "";
            if (isset($msg["newkey"])) $newkey = trim($msg["newkey"]); else $newkey = "";
            //具体处理函数
            $resp = $this->func_iwm_write_new_key_process($parObj, $type, $len, $kerver, $newkey);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_STD_TIME)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["realtime"])) $realtime = trim($msg["realtime"]); else $realtime = "";
            //具体处理函数
            $resp = $this->func_iwm_write_std_time_process($parObj, $type, $len, $realtime);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_SWITCH_CTRL)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["switch"])) $switch = trim($msg["switch"]); else $switch = "";
            //具体处理函数
            $resp = $this->func_iwm_write_switch_ctrl_process($parObj, $type, $len, $switch);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_OFF_FACTORY_START)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_iwm_write_off_fac_start_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_ADDRESS)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["newaddr"])) $newaddr = trim($msg["newaddr"]); else $newaddr = "";
            //具体处理函数
            $resp = $this->func_iwm_write_address_process($parObj, $type, $len, $newaddr);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IWMUI_TO_L3OPR_METER_DL_WRITE_DEVICE_SYN_DATA)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["curaccumvolume"])) $curaccumvolume = trim($msg["curaccumvolume"]); else $curaccumvolume = "";
            //具体处理函数
            $resp = $this->func_iwm_write_device_syn_process($parObj, $type, $len, $curaccumvolume);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_READ_DI0DI1_CURRENT_COUNTER_DATA)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_igm_read_cur_cnt_data_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA1)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_igm_read_his_cnt_data1_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA2)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_igm_read_his_cnt_data2_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA3)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_igm_read_his_cnt_data3_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA4)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_igm_read_his_cnt_data4_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA5)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_igm_read_his_cnt_data5_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA6)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_igm_read_his_cnt_data6_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA7)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_igm_read_his_cnt_data7_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA8)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_igm_read_his_cnt_data8_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA9)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_igm_read_his_cnt_data9_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA10)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_igm_read_his_cnt_data10_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA11)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_igm_read_his_cnt_data11_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA12)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_igm_read_his_cnt_data12_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_READ_DI0DI1_PRICE_TABLE)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_igm_read_price_table_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_READ_DI0DI1_BILL_DATE)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_igm_read_bill_date_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_READ_DI0DI1_ACCOUNT_DATE)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_igm_read_account_date_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_READ_DI0DI1_BUY_AMOUNT)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_igm_read_buy_amount_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_READ_DI0DI1_KEY_VER)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_igm_read_key_ver_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_READ_DI0DI1_ADDRESS)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_igm_read_address_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_PRICE_TABLE)
        {
            //解开消息
            if (isset($msg["len"])) $len = trim($msg["len"]); else $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["price1"])) $price1 = trim($msg["price1"]); else $price1 = "";
            if (isset($msg["volume1"])) $volume1 = trim($msg["volume1"]); else $volume1 = "";
            if (isset($msg["price2"])) $price2 = trim($msg["price2"]); else $price2 = "";
            if (isset($msg["volume2"])) $volume2 = trim($msg["volume2"]); else $volume2 = "";
            if (isset($msg["price3"])) $price3 = trim($msg["price3"]); else $price3 = "";
            if (isset($msg["startdate"])) $startdate = trim($msg["startdate"]); else $startdate = "";

            //具体处理函数
            $resp = $this->func_igm_write_price_table_process($parObj, $type, $len, $price1, $volume1, $price2, $volume2, $price3, $startdate);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_BILL_DATE)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["billdate"])) $billdate = trim($msg["billdate"]); else $billdate = "";
            //具体处理函数
            $resp = $this->func_igm_write_bill_date_process($parObj, $type, $len, $billdate);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_ACCOUNT_DATE)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["accountdate"])) $accountdate = trim($msg["accountdate"]); else $accountdate = "";
            //具体处理函数
            $resp = $this->func_igm_write_account_date_process($parObj, $type, $len, $accountdate);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_BUY_AMOUNT)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["buycode"])) $buycode = trim($msg["buycode"]); else $buycode = "";
            if (isset($msg["buyamount"])) $buyamount = trim($msg["buyamount"]); else $buyamount = "";
            //具体处理函数
            $resp = $this->func_igm_write_buy_amount_process($parObj, $type, $len, $buycode, $buyamount);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_NEW_KEY)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["kerver"])) $kerver = trim($msg["kerver"]); else $kerver = "";
            if (isset($msg["newkey"])) $newkey = trim($msg["newkey"]); else $newkey = "";
            //具体处理函数
            $resp = $this->func_igm_write_new_key_process($parObj, $type, $len, $kerver, $newkey);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_STD_TIME)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["realtime"])) $realtime = trim($msg["realtime"]); else $realtime = "";
            //具体处理函数
            $resp = $this->func_igm_write_std_time_process($parObj, $type, $len, $realtime);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_SWITCH_CTRL)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["switch"])) $switch = trim($msg["switch"]); else $switch = "";
            //具体处理函数
            $resp = $this->func_igm_write_switch_ctrl_process($parObj, $type, $len, $switch);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_OFF_FACTORY_START)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_igm_write_off_fac_start_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_ADDRESS)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["newaddr"])) $newaddr = trim($msg["newaddr"]); else $newaddr = "";
            //具体处理函数
            $resp = $this->func_igm_write_address_process($parObj, $type, $len, $newaddr);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IGMUI_TO_L3OPR_METER_DL_WRITE_DEVICE_SYN_DATA)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["curaccumvolume"])) $curaccumvolume = trim($msg["curaccumvolume"]); else $curaccumvolume = "";
            //具体处理函数
            $resp = $this->func_igm_write_device_syn_process($parObj, $type, $len, $curaccumvolume);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_READ_DI0DI1_CURRENT_COUNTER_DATA)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ihm_read_cur_cnt_data_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA1)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ihm_read_his_cnt_data1_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA2)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ihm_read_his_cnt_data2_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA3)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ihm_read_his_cnt_data3_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA4)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ihm_read_his_cnt_data4_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA5)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ihm_read_his_cnt_data5_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA6)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ihm_read_his_cnt_data6_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA7)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ihm_read_his_cnt_data7_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA8)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ihm_read_his_cnt_data8_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA9)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ihm_read_his_cnt_data9_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA10)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ihm_read_his_cnt_data10_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA11)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ihm_read_his_cnt_data11_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_READ_DI0DI1_HISTORY_COUNTER_DATA12)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ihm_read_his_cnt_data12_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_READ_DI0DI1_PRICE_TABLE)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ihm_read_price_table_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_READ_DI0DI1_BILL_DATE)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ihm_read_bill_date_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_READ_DI0DI1_ACCOUNT_DATE)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ihm_read_account_date_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_READ_DI0DI1_BUY_AMOUNT)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ihm_read_buy_amount_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_READ_DI0DI1_KEY_VER)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ihm_read_key_ver_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_READ_DI0DI1_ADDRESS)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ihm_read_address_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_PRICE_TABLE)
        {
            //解开消息
            if (isset($msg["len"])) $len = trim($msg["len"]); else $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["price1"])) $price1 = trim($msg["price1"]); else $price1 = "";
            if (isset($msg["volume1"])) $volume1 = trim($msg["volume1"]); else $volume1 = "";
            if (isset($msg["price2"])) $price2 = trim($msg["price2"]); else $price2 = "";
            if (isset($msg["volume2"])) $volume2 = trim($msg["volume2"]); else $volume2 = "";
            if (isset($msg["price3"])) $price3 = trim($msg["price3"]); else $price3 = "";
            if (isset($msg["startdate"])) $startdate = trim($msg["startdate"]); else $startdate = "";

            //具体处理函数
            $resp = $this->func_ihm_write_price_table_process($parObj, $type, $len, $price1, $volume1, $price2, $volume2, $price3, $startdate);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_BILL_DATE)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["billdate"])) $billdate = trim($msg["billdate"]); else $billdate = "";
            //具体处理函数
            $resp = $this->func_ihm_write_bill_date_process($parObj, $type, $len, $billdate);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_ACCOUNT_DATE)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["accountdate"])) $accountdate = trim($msg["accountdate"]); else $accountdate = "";
            //具体处理函数
            $resp = $this->func_ihm_write_account_date_process($parObj, $type, $len, $accountdate);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_BUY_AMOUNT)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["buycode"])) $buycode = trim($msg["buycode"]); else $buycode = "";
            if (isset($msg["buyamount"])) $buyamount = trim($msg["buyamount"]); else $buyamount = "";
            //具体处理函数
            $resp = $this->func_ihm_write_buy_amount_process($parObj, $type, $len, $buycode, $buyamount);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_NEW_KEY)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["kerver"])) $kerver = trim($msg["kerver"]); else $kerver = "";
            if (isset($msg["newkey"])) $newkey = trim($msg["newkey"]); else $newkey = "";
            //具体处理函数
            $resp = $this->func_ihm_write_new_key_process($parObj, $type, $len, $kerver, $newkey);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_STD_TIME)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["realtime"])) $realtime = trim($msg["realtime"]); else $realtime = "";
            //具体处理函数
            $resp = $this->func_ihm_write_std_time_process($parObj, $type, $len, $realtime);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_SWITCH_CTRL)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["switch"])) $switch = trim($msg["switch"]); else $switch = "";
            //具体处理函数
            $resp = $this->func_ihm_write_switch_ctrl_process($parObj, $type, $len, $switch);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_OFF_FACTORY_START)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            //具体处理函数
            $resp = $this->func_ihm_write_off_fac_start_process($parObj, $type, $len);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_WRITE_DI0DI1_ADDRESS)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["newaddr"])) $newaddr = trim($msg["newaddr"]); else $newaddr = "";
            //具体处理函数
            $resp = $this->func_ihm_write_address_process($parObj, $type, $len, $newaddr);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }

        if ($msgId == MSG_ID_L4NBIOT_IHMUI_TO_L3OPR_METER_DL_WRITE_DEVICE_SYN_DATA)
        {
            //解开消息
            if (isset($msg["len"])) $len = $msg["len"]; else  $len = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["curaccumvolume"])) $curaccumvolume = trim($msg["curaccumvolume"]); else $curaccumvolume = "";
            //具体处理函数
            $resp = $this->func_ihm_write_device_syn_process($parObj, $type, $len, $curaccumvolume);
            $project = MFUN_PRJ_NB_IOT_IHM188;
        }
        

        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, "MFUN_TASK_ID_L3NBIOT_OPR_METER", $log_time, $log_content);
            echo trim($resp); //这里需要编码送出去，跟其他处理方式还不太一样
        }

        //返回
        return true;
    }

}//End of class_task_service

?>