<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/7/11
 * Time: 12:12
 */
include_once "dbi_l2snr_ipm.class.php";
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

    function func_ipm_cj188_ul_read_data_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus)
    {
        $cj188Obj = new classDbiL2snrIpm(); //初始化一个UI DB对象
        $format = "A2DI0/A2DI1/A2Ser";
        $temp = unpack($format, $msgBody);
        $DI0 = (hexdec($temp['DI0'])) & 0xFF;
        $DI1 = (hexdec($temp['DI1'])) & 0xFF;
        $DI0DI1 = ($DI0 << 8)  + $DI1;

        //正式处理不同的DI0/DI1
        $resp = "";
        switch($DI0DI1){
            case MFUN_NBIOT_CJ188_READ_DI0DI1_CURRENT_COUNTER_DATA:
                if (($msgLen == 0x16) && ($msgType == MFUN_NBIOT_CJ188_T_TYPE_ELECTRONIC_POWER_METER))
                {
                    $format = "A2DI0/A2DI1/A2Ser/A2CuAVp/A2CuAV0/A2CuAV2/A2CuAV4/A2CuAVu/A2ToAVp/A2ToAV0/A2ToAV2/A2ToAV4/A2ToAVu/A14RealTime/A4ST";
                    $temp = unpack($format, $msgBody);
                    //当前累计流量
                    $CuAVp = hexdec(dechex($temp['CuAVp'])) & 0xFF;
                    $CuAV0 = hexdec(dechex($temp['CuAV0'])) & 0xFF;
                    $CuAV2 = hexdec(dechex($temp['CuAV2'])) & 0xFF;
                    $CuAV4 = hexdec(dechex($temp['CuAV4'])) & 0xFF;
                    $CuAVu = $temp['CuAVu'];
                    $CuAV = $CuAV4 * 10000 + $CuAV2 * 100 + $CuAV0 + $CuAVp / 100;
                    //结算日累计流量
                    $ToAVp = hexdec(dechex($temp['ToAVp'])) & 0xFF;
                    $ToAV0 = hexdec(dechex($temp['ToAV0'])) & 0xFF;
                    $ToAV2 = hexdec(dechex($temp['ToAV2'])) & 0xFF;
                    $ToAV4 = hexdec(dechex($temp['ToAV4'])) & 0xFF;
                    $ToAVu = $temp['ToAVu'];
                    $ToAV = $ToAV4 * 10000 + $ToAV2 * 100 + $ToAV0 + $ToAVp / 100;
                    $realtime = $temp['RealTime'];
                    $st = $temp['ST'];
                    $resp = $cj188Obj->dbi_ipm_std_cj188_data_save($msgAddr, $msgType, $CuAV, $CuAVu, $ToAV, $ToAVu, $realtime, $st);
                }
                else{
                    $resp = "";
                }
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA1:
                $resp = $this->func_ipm_cj188_history_data_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $cj188Obj, 1);
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA2:
                $resp = $this->func_ipm_cj188_history_data_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $cj188Obj, 2);
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA3:
                $resp = $this->func_ipm_cj188_history_data_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $cj188Obj, 3);
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA4:
                $resp = $this->func_ipm_cj188_history_data_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $cj188Obj, 4);
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA5:
                $resp = $this->func_ipm_cj188_history_data_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $cj188Obj, 5);
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA6:
                $resp = $this->func_ipm_cj188_history_data_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $cj188Obj, 6);
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA7:
                $resp = $this->func_ipm_cj188_history_data_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $cj188Obj, 7);
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA8:
                $resp = $this->func_ipm_cj188_history_data_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $cj188Obj, 8);
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA9:
                $resp = $this->func_ipm_cj188_history_data_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $cj188Obj, 9);
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA10:
                $resp = $this->func_ipm_cj188_history_data_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $cj188Obj, 10);
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA11:
                $resp = $this->func_ipm_cj188_history_data_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $cj188Obj, 11);
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA12:
                $resp = $this->func_ipm_cj188_history_data_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $cj188Obj, 12);
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_PRICE_TABLE:
                if (($msgLen == 0x12) && ($msgType == MFUN_NBIOT_CJ188_T_TYPE_ELECTRONIC_POWER_METER))
                {
                    $format = "A2DI0/A2DI1/A2Ser/A2P1p/A2P10/A2P12/A2V10/A2V12/A2V14/A2P2p/A2P20/A2P22/A2V20/A2V22/A2V24/A2P3p/A2P30/A2P32";
                    $temp = unpack($format, $msgBody);
                    //当前价格1
                    $P1p = hexdec(dechex($temp['P1p'])) & 0xFF;
                    $P10 = hexdec(dechex($temp['P10'])) & 0xFF;
                    $P12 = hexdec(dechex($temp['P12'])) & 0xFF;
                    $P1 = $P12 * 100 + $P10 + $P1p / 100;
                    //当前流量1
                    $V10 = hexdec(dechex($temp['V10'])) & 0xFF;
                    $V12 = hexdec(dechex($temp['V12'])) & 0xFF;
                    $V14 = hexdec(dechex($temp['V14'])) & 0xFF;
                    $V1 = $V14 * 10000 + $V12 * 100 + $V10;
                    //当前价格2
                    $P2p = hexdec(dechex($temp['P2p'])) & 0xFF;
                    $P20 = hexdec(dechex($temp['P20'])) & 0xFF;
                    $P22 = hexdec(dechex($temp['P22'])) & 0xFF;
                    $P2 = $P22 * 100 + $P20 + $P2p / 100;
                    //当前流量2
                    $V20 = hexdec(dechex($temp['V20'])) & 0xFF;
                    $V22 = hexdec(dechex($temp['V22'])) & 0xFF;
                    $V24 = hexdec(dechex($temp['V24'])) & 0xFF;
                    $V2 = $V24 * 10000 + $V22 * 100 + $V20;
                    //当前价格3
                    $P3p = hexdec(dechex($temp['P3p'])) & 0xFF;
                    $P30 = hexdec(dechex($temp['P30'])) & 0xFF;
                    $P32 = hexdec(dechex($temp['P32'])) & 0xFF;
                    $P3 = $P32 * 100 + $P30 + $P3p / 100;

                    $resp = $cj188Obj->dbi_ipm_std_cj188_data_save_price($msgAddr, $msgType, $P1, $V1, $P2, $V2, $P3);
                }
                else $resp = "";
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_BILL_DATE:
                if (($msgLen == 0x04) && ($msgType == MFUN_NBIOT_CJ188_T_TYPE_ELECTRONIC_POWER_METER))
                {
                    $format = "A2DI0/A2DI1/A2Ser/A2BillDate";
                    $temp = unpack($format, $msgBody);
                    //当前结算日
                    $BillDate = hexdec(dechex($temp['BillDate'])) & 0xFF;
                    $resp = $cj188Obj->dbi_ipm_std_cj188_data_save_bill_date($msgAddr, $msgType, $BillDate);
                }
                else $resp = "";
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_ACCOUNT_DATE:
                if (($msgLen == 0x04) && ($msgType == MFUN_NBIOT_CJ188_T_TYPE_ELECTRONIC_POWER_METER))
                {
                    $format = "A2DI0/A2DI1/A2Ser/A2ReadDate";
                    $temp = unpack($format, $msgBody);
                    //当前抄表日
                    $ReadDate = hexdec(dechex($temp['ReadDate'])) & 0xFF;
                    $resp = $cj188Obj->dbi_ipm_std_cj188_data_save_read_date($msgAddr, $msgType, $ReadDate);
                }
                else $resp = "";
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_BUY_AMOUNT:
                if (($msgLen == 0x12) && ($msgType == MFUN_NBIOT_CJ188_T_TYPE_ELECTRONIC_POWER_METER))
                {
                    $format = "A2DI0/A2DI1/A2Ser/A2BC/A2TAp/A2TA0/A2TA2/A2TA4/A2AAp/A2AA0/A2AA2/A2AA4/A2RAp/A2RA0/A2RA2/A2RA4/A4ST";
                    $temp = unpack($format, $msgBody);
                    //购买序号
                    $BC = hexdec($temp['BC']) & 0xFF;
                    //本次金额
                    $TAp = hexdec(dechex($temp['TAp'])) & 0xFF;
                    $TA0 = hexdec(dechex($temp['TA0'])) & 0xFF;
                    $TA2 = hexdec(dechex($temp['TA2'])) & 0xFF;
                    $TA4 = hexdec(dechex($temp['TA4'])) & 0xFF;
                    $TA = $TA4 * 10000 + $TA2 * 100 + $TA0 + $TAp / 100;
                    //累计金额
                    $AAp = hexdec(dechex($temp['AAp'])) & 0xFF;
                    $AA0 = hexdec(dechex($temp['AA0'])) & 0xFF;
                    $AA2 = hexdec(dechex($temp['AA2'])) & 0xFF;
                    $AA4 = hexdec(dechex($temp['AA4'])) & 0xFF;
                    $AA = $AA4 * 10000 + $AA2 * 100 + $AA0 + $AAp / 100;
                    //剩余金额
                    $RAp = hexdec(dechex($temp['RAp'])) & 0xFF;
                    $RA0 = hexdec(dechex($temp['RA0'])) & 0xFF;
                    $RA2 = hexdec(dechex($temp['RA2'])) & 0xFF;
                    $RA4 = hexdec(dechex($temp['RA4'])) & 0xFF;
                    $RA = $RA4 * 10000 + $RA2 * 100 + $RA0 + $RAp / 100;
                    $resp = $cj188Obj->dbi_ipm_std_cj188_data_save_buy_amount($msgAddr, $msgType, $BC, $TA, $AA, $RA);
                }
                else $resp = "";
                break;
            default:
                $resp = "";
                break;
        }

        return $resp;
    }

    function func_ipm_cj188_history_data_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $cj188Obj, $months)
    {
        if (($msgLen == 0x08) && ($msgType == MFUN_NBIOT_CJ188_T_TYPE_ELECTRONIC_POWER_METER))
        {
            $format = "A2DI0/A2DI1/A2Ser/A2CuAVp/A2CuAV0/A2CuAV2/A2CuAVu";
            $temp = unpack($format, $msgBody);
            //当前累计流量
            $CuAVp = hexdec(dechex($temp['CuAVp'])) & 0xFF;
            $CuAV0 = hexdec(dechex($temp['CuAV0'])) & 0xFF;
            $CuAV2 = hexdec(dechex($temp['CuAV2'])) & 0xFF;
            $CuAVu = $temp['CuAVu'];
            $CuAV = $CuAV2 * 100 + $CuAV0 + $CuAVp / 100;
            $resp = $cj188Obj->dbi_ipm_std_cj188_data_save_last_month($msgAddr, $msgType, $CuAV, $CuAVu, $months);
        }
        else $resp = "";
        return $resp;
    }

    function func_ipm_cj188_ul_read_key_ver_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus)
    {
        $cj188Obj = new classDbiL2snrIpm(); //初始化一个UI DB对象
        $format = "A2DI0/A2DI1/A2Ser";
        $temp = unpack($format, $msgBody);
        $DI0 = (hexdec($temp['DI0'])) & 0xFF;
        $DI1 = (hexdec($temp['DI1'])) & 0xFF;
        $DI0DI1 = ($DI0 << 8) + $DI1;

        //正式处理不同的DI0/DI1
        $resp = "";
        switch($DI0DI1){
            case MFUN_NBIOT_CJ188_READ_DI0DI1_KEY_VER:
                if (($msgLen == 0x04) && ($msgType == MFUN_NBIOT_CJ188_T_TYPE_ELECTRONIC_POWER_METER))
                {
                    $format = "A2DI0/A2DI1/A2Ser/A2KeyVer";
                    $temp = unpack($format, $msgBody);
                    //当前版本
                    $KeyVer = hexdec($temp['KeyVer']) & 0xFF;
                    $resp = $cj188Obj->dbi_ipm_std_cj188_data_save_key_ver($msgAddr, $msgType, $KeyVer);
                }
                else $resp = "";
                break;
            default:
                $resp = "";
                break;
        }

        return $resp;
    }

    function func_ipm_cj188_ul_read_address_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus)
    {
        $cj188Obj = new classDbiL2snrIpm(); //初始化一个UI DB对象
        $format = "A2DI0/A2DI1/A2Ser";
        $temp = unpack($format, $msgBody);
        $DI0 = (hexdec($temp['DI0'])) & 0xFF;
        $DI1 = (hexdec($temp['DI1'])) & 0xFF;
        $DI0DI1 = ($DI0 << 8) + $DI1;

        //正式处理不同的DI0/DI1
        $resp = "";
        switch($DI0DI1){
            case MFUN_NBIOT_CJ188_READ_DI0DI1_ADDRESS:
                if (($msgLen == 0x03) && ($msgType == MFUN_NBIOT_CJ188_T_TYPE_ELECTRONIC_POWER_METER))
                {
                    $resp = $cj188Obj->dbi_ipm_std_cj188_data_save_address($msgAddr, $msgType);
                }
                else $resp = "";
                break;
            default:
                $resp = "";
                break;
        }

        return $resp;
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

        //QG376规范中上报CONFIRM
        if ($msgId == MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_CNFNG)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_confirm_nor_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //QG376规范中上报RESET
        elseif ($msgId == MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_RESET)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_reset_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //QG376规范中上报LK_CHECK
        elseif ($msgId == MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_LICK)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_link_check_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //QG376规范中上报RELAY
        elseif ($msgId == MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_RELAY)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_relay_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //QG376规范中上报SET Parameter
        elseif ($msgId == MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_SETPAR)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_set_parameter_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //QG376规范中上报CONTROL
        elseif ($msgId == MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_CONTROL)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_control_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //QG376规范中上报Security Negotiation
        elseif ($msgId == MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_SECNEG)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_security_nego_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //QG376规范中上报REQUEST REPORT
        elseif ($msgId == MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_REQREP)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_req_report_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //QG376规范中上报REQUEST CONFIG
        elseif ($msgId == MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_REQCFG)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_req_config_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //QG376规范中上报INQURY PARAMETER
        elseif ($msgId == MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_INQPAR)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_inqury_parameter_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //QG376规范中上报REQUEST TASK
        elseif ($msgId == MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_REQTSK)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_req_task_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //QG376规范中上报REQUEST DATA1
        elseif ($msgId == MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_REQDATA1)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_req_data1_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //QG376规范中上报REQUEST DATA2
        elseif ($msgId == MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_REQDATA2)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_req_data2_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //QG376规范中上报REQUEST DATA3
        elseif ($msgId == MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_REQDATA3)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_req_data3_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //QG376规范中上报FILE TRANSFER
        elseif ($msgId == MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_FILETRNS)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_file_transfer_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //QG376规范中上报DATA FORWARD
        elseif ($msgId == MSG_ID_L2SDK_NBIOT_STD_QG376_TO_L2SNR_IPM_AFN_UL_DATAFWD)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_afn_ul_data_forward_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        //CJ188规范中上报READ DATA
        if ($msgId == MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IPM_READ_DATA)
        {
            //解开消息
            if (isset($msg["msgAddr"])) $msgAddr = $msg["msgAddr"]; else  $msgAddr = "";
            if (isset($msg["msgType"])) $msgType = $msg["msgType"]; else  $msgType = "";
            if (isset($msg["msgBody"])) $msgBody = $msg["msgBody"]; else  $msgBody = "";
            if (isset($msg["msgLen"])) $msgLen = $msg["msgLen"]; else  $msgLen = "";
            if (isset($msg["msgCtrlDir"])) $msgCtrlDir = $msg["msgCtrlDir"]; else  $msgCtrlDir = "";
            if (isset($msg["msgCtrlStatus"])) $msgCtrlStatus = $msg["msgCtrlStatus"]; else  $msgCtrlStatus = "";

            //具体处理函数
            $resp = $this->func_ipm_cj188_ul_read_data_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        //CJ188规范中上报READ KEY VER
        elseif ($msgId == MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IPM_READ_KEY_VER)
        {
            //解开消息
            if (isset($msg["msgAddr"])) $msgAddr = $msg["msgAddr"]; else  $msgAddr = "";
            if (isset($msg["msgType"])) $msgType = $msg["msgType"]; else  $msgType = "";
            if (isset($msg["msgBody"])) $msgBody = $msg["msgBody"]; else  $msgBody = "";
            if (isset($msg["msgLen"])) $msgLen = $msg["msgLen"]; else  $msgLen = "";
            if (isset($msg["msgCtrlDir"])) $msgCtrlDir = $msg["msgCtrlDir"]; else  $msgCtrlDir = "";
            if (isset($msg["msgCtrlStatus"])) $msgCtrlStatus = $msg["msgCtrlStatus"]; else  $msgCtrlStatus = "";
            //具体处理函数
            $resp = $this->func_ipm_cj188_ul_read_key_ver_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        //CJ188规范中上报READ ADDRESS
        elseif ($msgId == MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IPM_READ_ADDR)
        {
            //解开消息
            if (isset($msg["msgAddr"])) $msgAddr = $msg["msgAddr"]; else  $msgAddr = "";
            if (isset($msg["msgType"])) $msgType = $msg["msgType"]; else  $msgType = "";
            if (isset($msg["msgBody"])) $msgBody = $msg["msgBody"]; else  $msgBody = "";
            if (isset($msg["msgLen"])) $msgLen = $msg["msgLen"]; else  $msgLen = "";
            if (isset($msg["msgCtrlDir"])) $msgCtrlDir = $msg["msgCtrlDir"]; else  $msgCtrlDir = "";
            if (isset($msg["msgCtrlStatus"])) $msgCtrlStatus = $msg["msgCtrlStatus"]; else  $msgCtrlStatus = "";
            //具体处理函数
            $resp = $this->func_ipm_cj188_ul_read_address_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus);
            $project = MFUN_PRJ_NB_IOT_IPM188;
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