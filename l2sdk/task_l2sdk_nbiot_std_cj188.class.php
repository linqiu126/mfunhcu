<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/7/9
 * Time: 14:34
 */
include_once "../l1comvm/vmlayer.php";
include_once "dbi_l2sdk_nbiot.class.php";

class classTaskL2sdkNbiotStdCj188
{
    //构造函数
    public function __construct()
    {

    }

    function func_l2sdk_std_cj188_ul_frame_process($parObj, $msg)
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

        //先将通用的帧处理做完
        $cj188Obj = new classDbiL2sdkNbiotStdCj188(); //初始化一个UI DB对象
        if ($msgCtrlDir != 1) return "";
        if (($msgCtrlStatus == 1) && ($msgLen != 3)) return "";  //异常回送码
        $resp = "";
        //通信异常下的应答帧
        if ( ($msgCtrlStatus == 1) && ($msgLen == 3)){
            $format = "A2Ser/A4Stat";
            $temp = unpack($format, $msgBody);
            $Ser = hexdec($temp['Ser']);
            $Stat = hexdec($temp['Stat']);

            //采用这种方式将RESP发送回去，是否会有ECHO的问题，待定！！！
            if ($Ser != $cj188Obj->dbi_std_cj188_context_ser_inqury($msgAddr)) {
                $resp = "SER ERROR!";
            }
            //SER序号增加1，以便下一帧继续使用
            else {
                $cj188Obj->dbi_std_cj188_cntser_increase($msgAddr);
                $resp = $Stat;
            }
        }
        //正常的回复应答帧
        elseif (($msgCtrlStatus == 0) && ($msgLen >= 3)){
            if ($msgCtrl == MFUN_NBIOT_CJ188_CTRL_READ_DATA) $resp = $this->func_frame_read_data_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus);
            elseif ($msgCtrl == MFUN_NBIOT_CJ188_CTRL_READ_KEY_VER) $resp = $this->func_frame_read_key_ver_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus);
            elseif ($msgCtrl == MFUN_NBIOT_CJ188_CTRL_READ_ADDR) $resp = $this->func_frame_read_addr_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus);
            elseif ($msgCtrl == MFUN_NBIOT_CJ188_CTRL_WRITE_DATA) $resp = $this->func_frame_write_data_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus);
            elseif ($msgCtrl == MFUN_NBIOT_CJ188_CTRL_WRITE_ADDR) $resp = $this->func_frame_write_address_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus);
            elseif ($msgCtrl == MFUN_NBIOT_CJ188_CTRL_WRITE_DEVICE_SYN) $resp = $this->func_frame_write_device_syn_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus);
            else{return "";}
        }
        //其它都是非正常状态，暂时不支持厂商自定义的消息状态
        else{
            return "";
        }

        return $resp;
    }

    function func_check_sum_caculate($content)
    {
        $i = 0;
        if (strlen($content) == 0) return 0;
        if (strlen($content) != ((strlen($content)/2) * 2)) return "";
        $result = 0;
        for ($i =0; $i < strlen($content)/2; $i++){
            $temp = substr($content, 2*$i, 2);
            $temp = hexdec($temp);
            $result = ($result + $temp) & 0xFF;
        }
        return $result;
    }

    function func_frame_read_data_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus)
    {
        $format = "A2DI0/A2DI1/A2Ser";
        $temp = unpack($format, $msgBody);
        $DI0 = (hexdec($temp['DI0'])) & 0xFF;
        $DI1 = (hexdec($temp['DI1'])) & 0xFF;
        $Ser = hexdec($temp['Ser']);
        $DI0DI1 = ($DI0 << 8) + $DI1;

        $cj188Obj = new classDbiL2sdkNbiotStdCj188(); //初始化一个UI DB对象
        //采用这种方式将RESP发送回去，是否会有ECHO的问题，待定！！！
        if ($Ser != $cj188Obj->dbi_std_cj188_context_ser_inqury($msgAddr)) {
            $resp = "SER ERROR!";
            return $resp;
        }
        //SER序号增加1，以便下一帧继续使用
        else {
            $cj188Obj->dbi_std_cj188_cntser_increase($msgAddr);
        }

        //组包，发送消息给目标传感器
        $resp = "";
        $input = array("msgAddr" => $msgAddr,
            "msgType" => $msgType,
            "msgBody" => $msgBody,
            "msgLen" => $msgLen,
            "msgCtrlDir" => $msgCtrlDir,
            "msgCtrlStatus" => $msgCtrlStatus);
        if (($msgType >= MFUN_NBIOT_CJ188_T_TYPE_WATER_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_WATER_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IWM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IWM_READ_DATA, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IWM_READ_DATA",$input);
        elseif(($msgType >= MFUN_NBIOT_CJ188_T_TYPE_HEAT_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_HEAT_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IHM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IHM_READ_DATA, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IHM_READ_DATA",$input);
        elseif(($msgType >= MFUN_NBIOT_CJ188_T_TYPE_GAS_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_GAS_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IGM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IGM_READ_DATA, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IGM_READ_DATA",$input);
        elseif(($msgType >= MFUN_NBIOT_CJ188_T_TYPE_POWER_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_POWER_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IPM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IPM_READ_DATA, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IPM_READ_DATA",$input);
        else return "";

        return $resp;
    }

    function func_frame_read_key_ver_process($parObj, $msgAddr,$msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus)
    {
        $format = "A2DI0/A2DI1/A2Ser";
        $temp = unpack($format, $msgBody);
        $DI0 = (hexdec($temp['DI0'])) & 0xFF;
        $DI1 = (hexdec($temp['DI1'])) & 0xFF;
        $Ser = hexdec($temp['Ser']);
        $DI0DI1 = ($DI0 << 8) + $DI1;

        $cj188Obj = new classDbiL2sdkNbiotStdCj188(); //初始化一个UI DB对象
        //采用这种方式将RESP发送回去，是否会有ECHO的问题，待定！！！
        if ($Ser != $cj188Obj->dbi_std_cj188_context_ser_inqury($msgAddr)) {
            $resp = "SER ERROR!";
            return $resp;
        }
        //SER序号增加1，以便下一帧继续使用
        else {
            $cj188Obj->dbi_std_cj188_cntser_increase($msgAddr);
        }

        //组包，发送消息给目标传感器
        $resp = "";
        $input = array("msgAddr" => $msgAddr,
            "msgType" => $msgType,
            "msgBody" => $msgBody,
            "msgLen" => $msgLen,
            "msgCtrlDir" => $msgCtrlDir,
            "msgCtrlStatus" => $msgCtrlStatus);
        if (($msgType >= MFUN_NBIOT_CJ188_T_TYPE_WATER_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_WATER_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IWM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IWM_READ_KEY_VER, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IWM_READ_KEY_VER",$input);
        elseif(($msgType >= MFUN_NBIOT_CJ188_T_TYPE_HEAT_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_HEAT_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IHM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IHM_READ_KEY_VER, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IHM_READ_KEY_VER",$input);
        elseif(($msgType >= MFUN_NBIOT_CJ188_T_TYPE_GAS_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_GAS_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IGM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IGM_READ_KEY_VER, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IGM_READ_KEY_VER",$input);
        elseif(($msgType >= MFUN_NBIOT_CJ188_T_TYPE_POWER_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_POWER_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IPM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IPM_READ_KEY_VER, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IPM_READ_KEY_VER",$input);
        else return "";

        return "";
    }

    function func_frame_read_addr_process($parObj, $msgAddr,$msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus)
    {
        $format = "A2DI0/A2DI1/A2Ser";
        $temp = unpack($format, $msgBody);
        $DI0 = (hexdec($temp['DI0'])) & 0xFF;
        $DI1 = (hexdec($temp['DI1'])) & 0xFF;
        $Ser = hexdec($temp['Ser']);
        $DI0DI1 = ($DI0 << 8) + $DI1;

        $cj188Obj = new classDbiL2sdkNbiotStdCj188(); //初始化一个UI DB对象
        //采用这种方式将RESP发送回去，是否会有ECHO的问题，待定！！！
        if ($Ser != $cj188Obj->dbi_std_cj188_context_ser_inqury($msgAddr)) {
            $resp = "SER ERROR!";
            return $resp;
        }
        //SER序号增加1，以便下一帧继续使用
        else {
            $cj188Obj->dbi_std_cj188_cntser_increase($msgAddr);
        }

        //组包，发送消息给目标传感器
        $resp = "";
        $input = array("msgAddr" => $msgAddr,
            "msgType" => $msgType,
            "msgBody" => $msgBody,
            "msgLen" => $msgLen,
            "msgCtrlDir" => $msgCtrlDir,
            "msgCtrlStatus" => $msgCtrlStatus);
        if (($msgType >= MFUN_NBIOT_CJ188_T_TYPE_WATER_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_WATER_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IWM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IWM_READ_ADDR, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IWM_READ_ADDR",$input);
        elseif(($msgType >= MFUN_NBIOT_CJ188_T_TYPE_HEAT_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_HEAT_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IHM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IHM_READ_ADDR, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IHM_READ_ADDR",$input);
        elseif(($msgType >= MFUN_NBIOT_CJ188_T_TYPE_GAS_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_GAS_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IGM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IGM_READ_ADDR, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IGM_READ_ADDR",$input);
        elseif(($msgType >= MFUN_NBIOT_CJ188_T_TYPE_POWER_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_POWER_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IPM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IPM_READ_ADDR, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IPM_READ_ADDR",$input);
        else return "";

        return "";
    }

    function func_frame_write_data_process($parObj, $msgAddr,$msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus)
    {
        $format = "A2DI0/A2DI1/A2Ser";
        $temp = unpack($format, $msgBody);
        $DI0 = (hexdec($temp['DI0'])) & 0xFF;
        $DI1 = (hexdec($temp['DI1'])) & 0xFF;
        $Ser = hexdec($temp['Ser']);
        $DI0DI1 = ($DI0 << 8) + $DI1;

        $cj188Obj = new classDbiL2sdkNbiotStdCj188(); //初始化一个UI DB对象
        //采用这种方式将RESP发送回去，是否会有ECHO的问题，待定！！！
        if ($Ser != $cj188Obj->dbi_std_cj188_context_ser_inqury($msgAddr)) {
            $resp = "SER ERROR!";
            return $resp;
        }
        //SER序号增加1，以便下一帧继续使用
        else {
            $cj188Obj->dbi_std_cj188_cntser_increase($msgAddr);
        }

        //组包，发送消息给目标传感器
        $resp = "";
        $input = array("msgAddr" => $msgAddr,
            "msgType" => $msgType,
            "msgBody" => $msgBody,
            "msgLen" => $msgLen,
            "msgCtrlDir" => $msgCtrlDir,
            "msgCtrlStatus" => $msgCtrlStatus);
        if (($msgType >= MFUN_NBIOT_CJ188_T_TYPE_WATER_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_WATER_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IWM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IWM_WRITE_DATA, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IWM_WRITE_DATA",$input);
        elseif(($msgType >= MFUN_NBIOT_CJ188_T_TYPE_HEAT_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_HEAT_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IHM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IHM_WRITE_DATA, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IHM_WRITE_DATA",$input);
        elseif(($msgType >= MFUN_NBIOT_CJ188_T_TYPE_GAS_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_GAS_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IGM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IGM_WRITE_DATA, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IGM_WRITE_DATA",$input);
        elseif(($msgType >= MFUN_NBIOT_CJ188_T_TYPE_POWER_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_POWER_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IPM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IPM_WRITE_DATA, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IPM_WRITE_DATA",$input);
        else return "";

        return "";
    }

    function func_frame_write_address_process($parObj, $msgAddr,$msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus)
    {
        $format = "A2DI0/A2DI1/A2Ser";
        $temp = unpack($format, $msgBody);
        $DI0 = (hexdec($temp['DI0'])) & 0xFF;
        $DI1 = (hexdec($temp['DI1'])) & 0xFF;
        $Ser = hexdec($temp['Ser']);
        $DI0DI1 = ($DI0 << 8) + $DI1;

        $cj188Obj = new classDbiL2sdkNbiotStdCj188(); //初始化一个UI DB对象
        //采用这种方式将RESP发送回去，是否会有ECHO的问题，待定！！！
        if ($Ser != $cj188Obj->dbi_std_cj188_context_ser_inqury($msgAddr)) {
            $resp = "SER ERROR!";
            return $resp;
        }
        //SER序号增加1，以便下一帧继续使用
        else {
            $cj188Obj->dbi_std_cj188_cntser_increase($msgAddr);
        }

        //组包，发送消息给目标传感器
        $resp = "";
        $input = array("msgAddr" => $msgAddr,
            "msgType" => $msgType,
            "msgBody" => $msgBody,
            "msgLen" => $msgLen,
            "msgCtrlDir" => $msgCtrlDir,
            "msgCtrlStatus" => $msgCtrlStatus);
        if (($msgType >= MFUN_NBIOT_CJ188_T_TYPE_WATER_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_WATER_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IWM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IWM_WRITE_ADDR, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IWM_WRITE_ADDR",$input);
        elseif(($msgType >= MFUN_NBIOT_CJ188_T_TYPE_HEAT_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_HEAT_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IHM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IHM_WRITE_ADDR, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IHM_WRITE_ADDR",$input);
        elseif(($msgType >= MFUN_NBIOT_CJ188_T_TYPE_GAS_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_GAS_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IGM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IGM_WRITE_ADDR, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IGM_WRITE_ADDR",$input);
        elseif(($msgType >= MFUN_NBIOT_CJ188_T_TYPE_POWER_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_POWER_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IPM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IPM_WRITE_ADDR, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IPM_WRITE_ADDR",$input);
        else return "";

        return "";
    }

    function func_frame_write_device_syn_process($parObj, $msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus)
    {
        $format = "A2DI0/A2DI1/A2Ser";
        $temp = unpack($format, $msgBody);
        $DI0 = (hexdec($temp['DI0'])) & 0xFF;
        $DI1 = (hexdec($temp['DI1'])) & 0xFF;
        $Ser = hexdec($temp['Ser']);
        $DI0DI1 = ($DI0 << 8) + $DI1;

        $cj188Obj = new classDbiL2sdkNbiotStdCj188(); //初始化一个UI DB对象
        //采用这种方式将RESP发送回去，是否会有ECHO的问题，待定！！！
        if ($Ser != $cj188Obj->dbi_std_cj188_context_ser_inqury($msgAddr)) {
            $resp = "SER ERROR!";
            return $resp;
        }
        //SER序号增加1，以便下一帧继续使用
        else {
            $cj188Obj->dbi_std_cj188_cntser_increase($msgAddr);
        }

        //组包，发送消息给目标传感器
        $resp = "";
        $input = array("msgAddr" => $msgAddr,
            "msgType" => $msgType,
            "msgBody" => $msgBody,
            "msgLen" => $msgLen,
            "msgCtrlDir" => $msgCtrlDir,
            "msgCtrlStatus" => $msgCtrlStatus);
        if (($msgType >= MFUN_NBIOT_CJ188_T_TYPE_WATER_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_WATER_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IWM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IWM_WRITE_DEVICE_SYN, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IWM_WRITE_DEVICE_SYN",$input);
        elseif(($msgType >= MFUN_NBIOT_CJ188_T_TYPE_HEAT_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_HEAT_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IHM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IHM_WRITE_DEVICE_SYN, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IHM_WRITE_DEVICE_SYN",$input);
        elseif(($msgType >= MFUN_NBIOT_CJ188_T_TYPE_GAS_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_GAS_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IGM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IGM_WRITE_DEVICE_SYN, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IGM_WRITE_DEVICE_SYN",$input);
        elseif(($msgType >= MFUN_NBIOT_CJ188_T_TYPE_POWER_METER_MIN) &&($msgType <= MFUN_NBIOT_CJ188_T_TYPE_POWER_METER_MAX))
            $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188, MFUN_TASK_ID_L2SENSOR_IPM, MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IPM_WRITE_DEVICE_SYN, "MSG_ID_L2SDK_NBIOT_STD_CJ188_TO_L2SNR_IPM_WRITE_DEVICE_SYN",$input);
        else return "";

        return "";
    }


    function func_l2sdk_std_cj188_dl_frame_process($parObj, $taddr, $type, $msgCtrl, $msgHead, $msgBody)
    {
        //检查收到的信息是否合法
        if (($type < MFUN_NBIOT_CJ188_T_TYPE_WATER_METER_MIN) || ($type > MFUN_NBIOT_CJ188_T_TYPE_POWER_METER_MAX)) return "";
        if (($msgCtrl < MFUN_NBIOT_CJ188_CTRL_MIN) || ($msgCtrl > MFUN_NBIOT_CJ188_CTRL_MAX)) return "";
        if (strlen($taddr) != 14 ) return "";
        if (strlen($msgHead) != 6) return "";

        //试图组建整个帧
        $frameFixHead = MFUN_NBIOT_CJ188_FRAME_FIX_HEAD;
        $frameCtrlDir = 0; //DL
        $frameCtrl = $frameCtrlDir << 7 + $msgCtrl & 0x3F;
        $frameTail = MFUN_NBIOT_CJ188_FRAME_FIX_TAIL;

        //取得ser编号
        $cj188Obj = new classDbiL2sdkNbiotStdCj188(); //初始化一个UI DB对象
        $ser = $cj188Obj->dbi_std_cj188_context_ser_inqury($taddr);
        if (($ser == false) || (empty($ser) == true))
        {
            $cj188Obj->dbi_std_cj188_context_data_save($taddr, 0, "");
        }
        $frameSer = $ser & 0xFF;
        if ($frameSer != $ser){
            $cj188Obj->dbi_std_cj188_context_data_save($taddr, $frameSer, "");
        }

        //计算CRC CHECKSUM
        $frameCrcHead = $this->func_check_sum_caculate(substr($msgHead,2,4));  //长度不在CRC范畴内
        $frameCrcBody = $this->func_check_sum_caculate($msgBody);
        if (empty($frameCrcBody)) $frameCrcBody = 0;
        $frameCrc = ($frameCrcHead + $frameSer + $frameCrcBody) & 0xFF;

        //L2编码
        $frameMsg = sprintf("%02X%02X%s%02X%s%02X%s%02X%02X", $frameFixHead, $type, $taddr, $msgCtrl, $msgHead, $frameSer, $msgBody ,$frameCrc, $frameTail);

        //返回
        return $frameMsg;
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
            $resp = $this->func_l2sdk_std_cj188_ul_frame_process($parObj, $msg);
            $project = MFUN_PRJ_NB_IOT_IPM188; //要根据RESP中的项目信息重新赋值
        }

        //IPM188UI来的业务应用消息，待发送出去给终端设备
        elseif($msgId == MSG_ID_L3NBIOT_OPR_METERTO_STD_CJ188_DL_REQUEST){
            //解开消息
            if (isset($msg["taddr"])) $taddr = $msg["taddr"]; else  $taddr = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["msgCtrl"])) $msgCtrl = $msg["msgCtrl"]; else  $msgCtrl = "";
            if (isset($msg["msgHead"])) $msgHead = $msg["msgHead"]; else  $msgHead = "";
            if (isset($msg["msgBody"])) $msgBody = $msg["msgBody"]; else  $msgBody = "";

            //具体处理函数
            $resp = $this->func_l2sdk_std_cj188_dl_frame_process($parObj, $taddr, $type, $msgCtrl, $msgHead, $msgBody);
            $project = MFUN_PRJ_NB_IOT_IPM188;
        }

        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, "MFUN_TASK_ID_L2SDK_NBIOT_STD_CJ188", $log_time, $log_content);
            echo trim($resp);
        }

        //返回
        return true;

    }

}

?>