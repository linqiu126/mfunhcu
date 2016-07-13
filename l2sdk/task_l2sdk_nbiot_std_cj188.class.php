<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/7/9
 * Time: 14:34
 */
include_once "../l1comvm/vmlayer.php";

class classTaskL2sdkNbiotStdCj188
{
    //构造函数
    public function __construct()
    {

    }

    function func_l2sdk_std_cj188_ul_frame_process($msg)
    {
        //L2解码头
        $msg = trim($msg);
        $msgFormat = "A2Header/A2Type/A14Addr/A2Ctrl/A2Len";
        $temp = unpack($msgFormat, $msg);
        $msgHeader = hexdec($temp['Header']);  //通信包包头
        if ($msgHeader != MFUN_NBIOT_CJ188_FRAME_FIX_HEAD) return "";
        $msgLen = hexdec($temp['Len']) & 0xFF;//数据段长度
        if ($msgLen > MFUN_NBIOT_CJ188_FRAME_READ_MAX_LEN) return "";
        if (strlen($msg)-26 != 2*$msgLen) return ""; //长度msgLen + 固定长度 13BYTE(26Char)
        $msgType = hexdec($temp['Type']) & 0xFF; //仪表类型
        if (($msgType != MFUN_NBIOT_CJ188_T_TYPE_COLD_WATER_METER) && ($msgType != MFUN_NBIOT_CJ188_T_TYPE_HOT_WATER_METER)
            && ($msgType != MFUN_NBIOT_CJ188_T_TYPE_DRINK_WATER_METER) && ($msgType != MFUN_NBIOT_CJ188_T_TYPE_MIDDLE_WATER_METER)
            && ($msgType != MFUN_NBIOT_CJ188_T_TYPE_HEAT_ENERGY_METER) && ($msgType != MFUN_NBIOT_CJ188_T_TYPE_COLD_ENERGY_METER)
            && ($msgType != MFUN_NBIOT_CJ188_T_TYPE_GAS_METER) && ($msgType != MFUN_NBIOT_CJ188_T_TYPE_ELECTRONIC_POWER_METER))
            return "";
        $msgBody = substr($msg, 22, 2*$msgLen); //数据段,变长
        $msgCksum = hexdec(substr($msg, 2*($msgLen + 11), 2));
        $msgTail = hexdec(substr($msg, 2*($msgLen + 12), 2));
        if ($this->func_check_sum_caculate($msgBody) != $msgCksum) return "";
        if ($msgTail != MFUN_NBIOT_CJ188_FRAME_FIX_TAIL) return "";

        //控制字和地址字解码
        $msgCtrl = hexdec($temp['Ctrl']) & 0xFF; //控制域
        $msgAddr = $temp['Addr']; //地址，地位在前，高位在后
        $msgCtrlDir = (($msgCtrl & 0x80) >> 7 ) & 1;
        $msgCtrlStatus = (($msgCtrl & 0x40) >> 6 ) & 1;
        if ($msgCtrlDir != 1) return ""; //UL DIR = 1, DL DIR = 0
        $msgCtrl = $msgCtrl & 0x3F;

        if ($msgCtrl == MFUN_NBIOT_CJ188_CTRL_READ_DATA) $resp = $this->func_frame_read_data_process($msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $msgAddr);
        elseif ($msgCtrl == MFUN_NBIOT_CJ188_CTRL_READ_KEY_VER) $resp = $this->func_frame_read_key_ver_process($msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $msgAddr);
        elseif ($msgCtrl == MFUN_NBIOT_CJ188_CTRL_READ_ADDR) $resp = $this->func_frame_read_addr_process($msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $msgAddr);
        elseif ($msgCtrl == MFUN_NBIOT_CJ188_CTRL_WRITE_ADDR) $resp = $this->func_frame_write_process($msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $msgAddr);
        elseif ($msgCtrl == MFUN_NBIOT_CJ188_CTRL_SET_DEVICE_SYN) $resp = $this->func_frame_set_device_syn_process($msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $msgAddr);
        else{return "";}

        return $resp;
    }

    function func_check_sum_caculate($content)
    {
        $i = 0;
        if (strlen($content) != ((strlen($content)/2) * 2)) return "";
        $result = 0;
        for ($i =0; $i < strlen($content)/2; $i++){
            $temp = substr($content, 2*$i, 2);
            $temp = hexdec($temp);
            $result = ($result + $temp) & 0xFF;
        }
        return $result;
    }

    function func_frame_read_data_process($msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $msgAddr)
    {
        $cj188Obj = new classDbiL2sdkNbiotStdCj188(); //初始化一个UI DB对象
        if ($msgCtrlDir != 1) return "";
        if (($msgCtrlStatus == 1) && ($msgLen != 3)) return "";  //异常回送码
        $resp = "";
        //通信异常下的应答帧
        if ( ($msgCtrlStatus == 1) && ($msgLen == 3)){
            $format = "A2Ser/A4Stat";
            $temp = $format($format, $msgBody);
            $Ser = hexdec($temp['Ser']);
            $Stat = hexdec($temp['Stat']);

            //采用这种方式将RESP发送回去，是否会有ECHO的问题，待定！！！
            if ($Ser != $cj188Obj->dbi_std_cj188_context_pfc_inqury($msgAddr)) {
                $resp = "SER ERROR!";
            }
            //SER序号增加1，以便下一帧继续使用
            else {
                $cj188Obj->dbi_std_cj188_cntser_increase($msgAddr);
                $resp = $Stat;
            }
        }
        elseif (($msgCtrlStatus == 1) && ($msgLen > 3)){
            $format = "A2DI0/A2DI1/A2Ser";
            $temp = $format($format, $msgBody);
            $DI0 = hexdec($temp['DI0']);
            $DI1 = hexdec($temp['DI1']);
            $Ser = hexdec($temp['Ser']);


        }
        return $resp;
    }

    function func_frame_read_key_ver_process($msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $msgAddr6)
    {
        return "";
    }

    function func_frame_read_addr_process($msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $msgAddr)
    {
        return "";
    }

    function func_frame_write_process($msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $msgAddr)
    {
        return "";
    }

    function func_frame_set_device_syn_process($msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $msgAddr)
    {
        return "";
    }

    function func_l2sdk_std_cj188_dl_frame_process($user)
    {
        //L3消息处理
        //L2编码并发送出去

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $jsonencode = json_encode($uiF1symDbObj);
        return $jsonencode;
    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2sdk_nbiot_std_cj188_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //合法性检查
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());
        $project = "";

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188", "mfun_l2sdk_nbiot_std_cj188_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到STD_CJ188，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188", "mfun_l2sdk_nbiot_std_cj188_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        //判定是UL还是DL来的消息
        if ($msgId == MSG_ID_L2SDK_NBIOT_STD_CJ188_INCOMING){
            //解开消息
            //if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_l2sdk_std_cj188_ul_frame_process($msg);
            $project = MFUN_PRJ_NB_IOT_IPM188; //要根据RESP中的项目信息重新赋值
        }

        //IPM188UI来的业务应用消息，待发送出去给终端设备
        elseif($msgId == MSG_ID_L4NBIOTIPM_TO_NBIOT_IPM188_DL_REQUEST){
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_l2sdk_std_cj188_dl_frame_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        //IWM188UI来的业务应用消息，待发送出去给终端设备
        elseif($msgId == MSG_ID_L4NBIOTIPM_TO_NBIOT_IWM188_DL_REQUEST){
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_l2sdk_std_cj188_dl_frame_process($user);
            $project = MFUN_PRJ_NB_IOT_IWM188;
        }

        //IGM188UI来的业务应用消息，待发送出去给终端设备
        elseif($msgId == MSG_ID_L4NBIOTIPM_TO_NBIOT_IGM188_DL_REQUEST){
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_l2sdk_std_cj188_dl_frame_process($user);
            $project = MFUN_PRJ_NB_IOT_IGM188;
        }

        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, "MFUN_TASK_ID_L2SDK_NBIOT_IPM376", $log_time, $log_content);
            echo trim($resp); //这里需要编码送出去，跟其他处理方式还不太一样
        }

        //返回
        return true;

    }

}

?>