<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/7/7
 * Time: 22:01
 */
include_once "../l1comvm/vmlayer.php";

class classTaskL2sdkNbiotStdQg376
{
    //构造函数
    public function __construct()
    {

    }

    function func_l2sdk_std_qg376_ul_frame_process($msg)
    {
        $ipm376Obj = new classDbiL2sdkNbiotIpm376(); //初始化一个UI DB对象

        //L2解码头
        $msg = trim($msg);
        $msgFormat = "A2Header/A4Len/A2Start/A2Ctrl/A4AddrA1/A4AddrA2/A2AddrA3/A2AFN/A2SEQ";
        $temp = unpack($msgFormat, $msg);
        $msgHeader = hexdec(['Header']);  //通信包包头
        if ($msgHeader != MFUN_NBIOT_IPM376_FRAME_FIX_HEAD) return "";
        $msgLen = hexdec($temp['Len']) & 0xFFFF;//数据段长度
        if (($msgLen & 0x3) != 0x2) return "";
        if ($msgLen > MFUN_NBIOT_IPM376_FRAME_MAX_LEN) return "";
        $msgLen = (($msgLen & 0xFFFC) >> 2) & 0x3FFF; //D2-D15是真正的长度域
        if (strlen($msg)-12 != 2*$msgLen) return ""; //长度msgLen + 固定长度 6BYTE = 12Char
        $msgStart = hexdec($temp['Start']) & 0xFF; //起始标识
        if ($msgStart != MFUN_NBIOT_IPM376_FRAME_FIX_START) return "";
        $msgBody = substr($msg, 8, 2*$msgLen); //数据段,变长
        $msgCksum = hexdec(substr($msg, 2*($msgLen + 4), 2));
        $msgTail = hexdec(substr($msg, 2*($msgLen + 5), 2));
        if ($this->func_check_sum_caculate($msgBody) != $msgCksum) return "";
        if ($msgTail != MFUN_NBIOT_IPM376_FRAME_FIX_TAIL) return "";

        //控制字和地址字解码
        $msgCtrl = hexdec($temp['Ctrl']) & 0xFF; //控制域
        $msgAddrA1 = hexdec($temp['AddrA1']) & 0xFFFF; //地址A1
        $msgAddrA2 = hexdec($temp['AddrA2']) & 0xFFFF; //地址A2
        $msgAddrA3 = hexdec($temp['AddrA3']) & 0xFF; //地址A3
        if (((($msgCtrl & 0x80) >> 7) & 1) != 1) return ""; //DL DIR = 1，表示上行链路
        $framePRM = (($msgCtrl & 0x40) >> 6) & 1; //PRM表示为启动标识位
        $frameACD = (($msgCtrl & 0x20) >> 5) & 1; //ACD表示为上行要求访问位
        $frameFUNC = $msgCtrl & 0x0F; //D3-D0功能码字
        $frameAFN = hexdec($temp['AFN']) & 0xFF; //应用层功能码
        $frameSEQ = hexdec($temp['SEQ']) & 0xFF; //系列号
        if ($frameAFN >= 0x11) return "";
        $frameTpv = ($frameSEQ & 0x80 >> 7) & 1;
        $frameFIR = ($frameSEQ & 0x40 >> 6) & 1;
        $frameFIN = ($frameSEQ & 0x20 >> 5) & 1;
        $frameCON = ($frameSEQ & 0x10 >> 4) & 1;
        $framePRSEQ = $frameSEQ & 0x0F;

        if (($framePRM == 1) && ($frameFUNC == 1)) $resp = $this->func_frame_reset_command_process($msgBody, $msgAddrA1, $msgAddrA2, $msgAddrA3, $frameACD, $frameTpv, $frameFIR, $frameFIN, $frameCON, $framePRSEQ);
        elseif (($framePRM == 1) && ($frameFUNC == 4)) $resp = $this->func_frame_user_data_process($msgBody, $msgAddrA1, $msgAddrA2, $msgAddrA3, $frameACD, $frameTpv, $frameFIR, $frameFIN, $frameCON, $framePRSEQ);
        elseif (($framePRM == 1) && ($frameFUNC == 9)) $resp = $this->func_frame_link_test_process($msgBody, $msgAddrA1, $msgAddrA2, $msgAddrA3, $frameACD, $frameTpv, $frameFIR, $frameFIN, $frameCON, $framePRSEQ);
        elseif (($framePRM == 1) && ($frameFUNC == 10)) $resp = $this->func_frame_request_data1_process($msgBody, $msgAddrA1, $msgAddrA2, $msgAddrA3, $frameACD, $frameTpv, $frameFIR, $frameFIN, $frameCON, $framePRSEQ);
        elseif (($framePRM == 1) && ($frameFUNC == 11)) $resp = $this->func_frame_request_data2_process($msgBody, $msgAddrA1, $msgAddrA2, $msgAddrA3, $frameACD, $frameTpv, $frameFIR, $frameFIN, $frameCON, $framePRSEQ);
        elseif (($framePRM == 0) && ($frameFUNC == 0)) $resp = $this->func_frame_acceptance_process($msgBody, $msgAddrA1, $msgAddrA2, $msgAddrA3, $frameACD, $frameTpv, $frameFIR, $frameFIN, $frameCON, $framePRSEQ);
        elseif (($framePRM == 0) && ($frameFUNC == 8)) $resp = $this->func_frame_user_data_process($msgBody, $msgAddrA1, $msgAddrA2, $msgAddrA3, $frameACD, $frameTpv, $frameFIR, $frameFIN, $frameCON, $framePRSEQ);
        elseif (($framePRM == 0) && ($frameFUNC == 9)) $resp = $this->func_frame_negative_no_data_process($msgBody, $msgAddrA1, $msgAddrA2, $msgAddrA3, $frameACD, $frameTpv, $frameFIR, $frameFIN, $frameCON, $framePRSEQ);
        elseif (($framePRM == 0) && ($frameFUNC == 11)) $resp = $this->func_frame_link_status_process($msgBody, $msgAddrA1, $msgAddrA2, $msgAddrA3, $frameACD, $frameTpv, $frameFIR, $frameFIN, $frameCON, $framePRSEQ);
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

    function func_frame_reset_command_process($msgBody, $addrA1, $addrA2, $addrA3, $frameACD, $frameTpv, $frameFIR, $frameFIN, $frameCON, $framePRSEQ)
    {
        return "";
    }

    function func_frame_user_data_process($msgBody, $addrA1, $addrA2, $addrA3, $frameACD, $frameTpv, $frameFIR, $frameFIN, $frameCON, $framePRSEQ)
    {
        return "";
    }

    function func_frame_link_test_process($msgBody, $addrA1, $addrA2, $addrA3, $frameACD, $frameTpv, $frameFIR, $frameFIN, $frameCON, $framePRSEQ)
    {
        return "";
    }

    function func_frame_request_data1_process($msgBody, $addrA1, $addrA2, $addrA3, $frameACD, $frameTpv, $frameFIR, $frameFIN, $frameCON, $framePRSEQ)
    {
        return "";
    }

    function func_frame_request_data2_process($msgBody, $addrA1, $addrA2, $addrA3, $frameACD, $frameTpv, $frameFIR, $frameFIN, $frameCON, $framePRSEQ)
    {
        return "";
    }

    function func_frame_acceptance_process($msgBody, $addrA1, $addrA2, $addrA3, $frameACD, $frameTpv, $frameFIR, $frameFIN, $frameCON, $framePRSEQ)
    {
        return "";
    }

    function func_frame_negative_no_data_process($msgBody, $addrA1, $addrA2, $addrA3, $frameACD, $frameTpv, $frameFIR, $frameFIN, $frameCON, $framePRSEQ)
    {
        return "";
    }

    function func_frame_link_status_process($msgBody, $addrA1, $addrA2, $addrA3, $frameACD, $frameTpv, $frameFIR, $frameFIN, $frameCON, $framePRSEQ)
    {
        return "";
    }

    function func_l2sdk_std_qg376_dl_frame_process($user)
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
    public function mfun_l2sdk_nbiot_std_qg376_task_main_entry($parObj, $msgId, $msgName, $msg)
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
            $loggerObj->logger("MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376", "mfun_l2sdk_nbiot_std_qg376_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到IPM376，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376", "mfun_l2sdk_nbiot_std_qg376_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        //判定是UL还是DL来的消息
        if ($msgId == MSG_ID_L2SDK_NBIOT_STD_QG376_INCOMING){
            //解开消息
            //if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_l2sdk_std_qg376_ul_frame_process($msg);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        elseif($msgId == MSG_ID_L4NBIOT_IPMUI_TO_NBIOT_STD_QG376_DL_REQUEST){
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_l2sdk_std_qg376_dl_frame_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }
        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, "MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376", $log_time, $log_content);
            echo trim($resp); //这里需要编码送出去，跟其他处理方式还不太一样
        }

        //返回
        return true;

    }

}

?>