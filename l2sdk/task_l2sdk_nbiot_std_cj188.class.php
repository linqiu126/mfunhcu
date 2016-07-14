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

        //先将通用的帧处理做完
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
        //正常的回复应答帧
        elseif (($msgCtrlStatus == 1) && ($msgLen > 3)){
            if ($msgCtrl == MFUN_NBIOT_CJ188_CTRL_READ_DATA) $resp = $this->func_frame_read_data_process($msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $msgAddr);
            elseif ($msgCtrl == MFUN_NBIOT_CJ188_CTRL_READ_KEY_VER) $resp = $this->func_frame_read_key_ver_process($msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $msgAddr);
            elseif ($msgCtrl == MFUN_NBIOT_CJ188_CTRL_READ_ADDR) $resp = $this->func_frame_read_addr_process($msgAddr, $msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $msgAddr);
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
        if (strlen($content) != ((strlen($content)/2) * 2)) return "";
        $result = 0;
        for ($i =0; $i < strlen($content)/2; $i++){
            $temp = substr($content, 2*$i, 2);
            $temp = hexdec($temp);
            $result = ($result + $temp) & 0xFF;
        }
        return $result;
    }

    function func_frame_read_data_process($msgAddr,$msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $msgAddr)
    {
        $format = "A2DI0/A2DI1/A2Ser";
        $temp = $format($format, $msgBody);
        $DI0 = (hexdec($temp['DI0'])) & 0xFF;
        $DI1 = (hexdec($temp['DI1'])) & 0xFF;
        $Ser = hexdec($temp['Ser']);
        $DI0DI1 = ($DI0 << 8) & 0xFF00 + $DI1;

        $cj188Obj = new classDbiL2sdkNbiotStdCj188(); //初始化一个UI DB对象
        //采用这种方式将RESP发送回去，是否会有ECHO的问题，待定！！！
        if ($Ser != $cj188Obj->dbi_std_cj188_context_pfc_inqury($msgAddr)) {
            $resp = "SER ERROR!";
            return $resp;
        }
        //SER序号增加1，以便下一帧继续使用
        else {
            $cj188Obj->dbi_std_cj188_cntser_increase($msgAddr);
        }

        //正式处理不同的DI0/DI1
        $resp = "";
        switch($DI0DI1){
            case MFUN_NBIOT_CJ188_READ_DI0DI1_CURRENT_COUNTER_DATA:
                if (($msgLen = 0x16) && (($msgType == MFUN_NBIOT_CJ188_T_TYPE_COLD_WATER_METER) || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_HOT_WATER_METER)
                        || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_DRINK_WATER_METER) || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_MIDDLE_WATER_METER)
                        || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_GAS_METER) || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_ELECTRONIC_POWER_METER)))
                {
                    $format = "A2DI0/A2DI1/A2Ser/A2CuAVp/A2CuAV0/A2CuAV2/A2CuAV4/A2CuAVu/A2ToAVp/A2ToAV0/A2ToAV2/A2ToAV4/A2ToAVu/A14RealTime/A4ST";
                    $temp = $format($format, $msgBody);
                    //当前累计流量
                    $CuAVp = (dechex($temp['CuAVp'])) & 0xFF;
                    $CuAV0 = (dechex($temp['CuAV0'])) & 0xFF;
                    $CuAV2 = (dechex($temp['CuAV2'])) & 0xFF;
                    $CuAV4 = (dechex($temp['CuAV4'])) & 0xFF;
                    $CuAVu = $temp['CuAVu'];
                    $CuAV = $CuAV4 * 10000 + $CuAV2 * 100 + $CuAV0 + $CuAVp / 100;
                    //结算日累计流量
                    $ToAVp = (dechex($temp['ToAVp'])) & 0xFF;
                    $ToAV0 = (dechex($temp['ToAV0'])) & 0xFF;
                    $ToAV2 = (dechex($temp['ToAV2'])) & 0xFF;
                    $ToAV4 = (dechex($temp['ToAV4'])) & 0xFF;
                    $ToAVu = $temp['ToAVu'];
                    $ToAV = $ToAV4 * 10000 + $ToAV2 * 100 + $ToAV0 + $ToAVp / 100;
                    $realtime = $temp['RealTime'];
                    $st = $temp['ST'];
                    //按照道理，应该讲数据发送给L2SNR的水表等外设进行处理。这里先偷懒，直接将数据存入到数据库中。
                    $resp = $cj188Obj->dbi_std_cj188_data_save_counter_data_water_and_gas_and_power_meter($msgAddr, $msgType, $CuAV, $CuAVu, $ToAV, $ToAVu, $realtime, $st);
                }
                elseif (($msgLen = 0x2E) && (($msgType == MFUN_NBIOT_CJ188_T_TYPE_HEAT_ENERGY_METER) || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_COLD_ENERGY_METER)))
                {
                    $format = "A2DI0/A2DI1/A2Ser/A2ToHp/A2ToH0/A2ToH2/A2ToH4/A2ToHu/A2CuHp/A2CuH0/A2CuH2/A2CuH4/A2CuHu/A2HPp/A2HP0/A2HP2/A2HP4/A2HPu/A2Fop/A2Fo0/A2Fo2/A2Fo4/A2Fou/A2AFp/A2AF0/A2AF2/A2AF4/A2AFu/A2SWp/A2SW0/A2SW2/A2BWp/A2BW0/A2BW2/A2AW0/A2AW2/A2AW4/A14RealTime/A4ST";
                    $temp = $format($format, $msgBody);
                    //结算日热量
                    $ToHp = (dechex($temp['ToHp'])) & 0xFF;
                    $ToH0 = (dechex($temp['ToH0'])) & 0xFF;
                    $ToH2 = (dechex($temp['ToH2'])) & 0xFF;
                    $ToH4 = (dechex($temp['ToH4'])) & 0xFF;
                    $ToHu = $temp['ToHu'];
                    $ToH = $ToH4 * 10000 + $ToH2 * 100 + $ToH0 + $ToHp / 100;
                    //当前热量
                    $CuHp = (dechex($temp['CuHp'])) & 0xFF;
                    $CuH0 = (dechex($temp['CuH0'])) & 0xFF;
                    $CuH2 = (dechex($temp['CuH2'])) & 0xFF;
                    $CuH4 = (dechex($temp['CuH4'])) & 0xFF;
                    $CuHu = $temp['CuHu'];
                    $CuH = $CuH4 * 10000 + $CuH2 * 100 + $CuH0 + $CuHp / 100;
                    //热功率
                    $HPp = (dechex($temp['HPp'])) & 0xFF;
                    $HP0 = (dechex($temp['HP0'])) & 0xFF;
                    $HP2 = (dechex($temp['HP2'])) & 0xFF;
                    $HP4 = (dechex($temp['HP4'])) & 0xFF;
                    $HPu = $temp['HPu'];
                    $HP = $HP4 * 10000 + $HP2 * 100 + $HP0 + $HPp / 100;
                    //流量
                    $Fop = (dechex($temp['Fop'])) & 0xFF;
                    $Fo0 = (dechex($temp['Fo0'])) & 0xFF;
                    $Fo2 = (dechex($temp['Fo2'])) & 0xFF;
                    $Fo4 = (dechex($temp['Fo4'])) & 0xFF;
                    $Fou = $temp['Fou'];
                    $Fo = $Fo4 * 10000 + $Fo2 * 100 + $Fo0 + $Fop / 100;
                    //累计流量
                    $AFp = (dechex($temp['AFp'])) & 0xFF;
                    $AF0 = (dechex($temp['AF0'])) & 0xFF;
                    $AF2 = (dechex($temp['AF2'])) & 0xFF;
                    $AF4 = (dechex($temp['AF4'])) & 0xFF;
                    $AFu = $temp['AFu'];
                    $AF = $AF4 * 10000 + $AF2 * 100 + $AF0 + $AFp / 100;
                    //供水温度
                    $SWp = (dechex($temp['SWp'])) & 0xFF;
                    $SW0 = (dechex($temp['SW0'])) & 0xFF;
                    $SW2 = (dechex($temp['SW2'])) & 0xFF;
                    $SW = $SW2 * 100 + $SW0 + $SWp / 100;
                    //回水温度
                    $BWp = (dechex($temp['BWp'])) & 0xFF;
                    $BW0 = (dechex($temp['BW0'])) & 0xFF;
                    $BW2 = (dechex($temp['BW2'])) & 0xFF;
                    $BW = $BW2 * 100 + $BW0 + $BWp / 100;
                    //累计工作时间
                    $AW0 = (dechex($temp['AW0'])) & 0xFF;
                    $AW2 = (dechex($temp['AW2'])) & 0xFF;
                    $AW4 = (dechex($temp['AW4'])) & 0xFF;
                    $AW = $AW4 * 10000 + $AW2 * 100 + $AW0;
                    $realtime = $temp['RealTime'];
                    $st = $temp['ST'];
                    //按照道理，应该讲数据发送给L2SNR的水表等外设进行处理。这里先偷懒，直接将数据存入到数据库中。
                    $resp = $cj188Obj->dbi_std_cj188_data_save_counter_data_heat_meter($msgAddr, $msgType, $ToH, $ToHu, $CuH, $CuHu, $HP, $HPu,$Fo, $Fou, $AF, $AFu, $SW, $BW, $AW, $realtime, $st);
                }
                else{
                        $resp = "";
                }
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA1:
                if (($msgLen = 0x16) && (($msgType == MFUN_NBIOT_CJ188_T_TYPE_COLD_WATER_METER) || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_HOT_WATER_METER)
                        || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_DRINK_WATER_METER) || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_MIDDLE_WATER_METER)
                        || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_GAS_METER) || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_ELECTRONIC_POWER_METER)))
                {
                    $format = "A2DI0/A2DI1/A2Ser/A2CuAVp/A2CuAV0/A2CuAV2/A2CuAV4";
                    $temp = $format($format, $msgBody);
                    //当前累计流量
                    $CuAVp = (dechex($temp['CuAVp'])) & 0xFF;
                    $CuAV0 = (dechex($temp['CuAV0'])) & 0xFF;
                    $CuAV2 = (dechex($temp['CuAV2'])) & 0xFF;
                    $CuAV4 = (dechex($temp['CuAV4'])) & 0xFF;
                    $CuAVu = $temp['CuAVu'];
                    $CuAV = $CuAV4 * 10000 + $CuAV2 * 100 + $CuAV0 + $CuAVp / 100;
                    //按照道理，应该讲数据发送给L2SNR的水表等外设进行处理。这里先偷懒，直接将数据存入到数据库中。
                    $resp = $cj188Obj->dbi_std_cj188_data_save_counter_data_water_and_gas_and_power_meter_last_month($msgAddr, $msgType, $CuAV, $CuAVu, 1);
                }
                elseif (($msgLen = 0x2E) && (($msgType == MFUN_NBIOT_CJ188_T_TYPE_HEAT_ENERGY_METER) || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_COLD_ENERGY_METER)))
                {
                    $format = "A2DI0/A2DI1/A2Ser/A2CuAVp/A2CuAV0/A2CuAV2/A2CuAV4";
                    $temp = $format($format, $msgBody);
                    //当前累计流量
                    $CuAVp = (dechex($temp['CuAVp'])) & 0xFF;
                    $CuAV0 = (dechex($temp['CuAV0'])) & 0xFF;
                    $CuAV2 = (dechex($temp['CuAV2'])) & 0xFF;
                    $CuAV4 = (dechex($temp['CuAV4'])) & 0xFF;
                    $CuAVu = $temp['CuAVu'];
                    $CuAV = $CuAV4 * 10000 + $CuAV2 * 100 + $CuAV0 + $CuAVp / 100;
                    //按照道理，应该讲数据发送给L2SNR的水表等外设进行处理。这里先偷懒，直接将数据存入到数据库中。
                    $resp = $cj188Obj->dbi_std_cj188_data_save_counter_data_heat_meter_last_month($msgAddr, $msgType, $CuAV, $CuAVu, 1);
                }
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA2:
                if (($msgLen = 0x16) && (($msgType == MFUN_NBIOT_CJ188_T_TYPE_COLD_WATER_METER) || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_HOT_WATER_METER)
                        || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_DRINK_WATER_METER) || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_MIDDLE_WATER_METER)
                        || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_GAS_METER) || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_ELECTRONIC_POWER_METER)))
                {
                    $format = "A2DI0/A2DI1/A2Ser/A2CuAVp/A2CuAV0/A2CuAV2/A2CuAV4";
                    $temp = $format($format, $msgBody);
                    //当前累计流量
                    $CuAVp = (dechex($temp['CuAVp'])) & 0xFF;
                    $CuAV0 = (dechex($temp['CuAV0'])) & 0xFF;
                    $CuAV2 = (dechex($temp['CuAV2'])) & 0xFF;
                    $CuAV4 = (dechex($temp['CuAV4'])) & 0xFF;
                    $CuAVu = $temp['CuAVu'];
                    $CuAV = $CuAV4 * 10000 + $CuAV2 * 100 + $CuAV0 + $CuAVp / 100;
                    //按照道理，应该讲数据发送给L2SNR的水表等外设进行处理。这里先偷懒，直接将数据存入到数据库中。
                    $resp = $cj188Obj->dbi_std_cj188_data_save_counter_data_water_and_gas_and_power_meter_last_month($msgAddr, $msgType, $CuAV, $CuAVu, 2);
                }
                elseif (($msgLen = 0x2E) && (($msgType == MFUN_NBIOT_CJ188_T_TYPE_HEAT_ENERGY_METER) || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_COLD_ENERGY_METER)))
                {
                    $format = "A2DI0/A2DI1/A2Ser/A2CuAVp/A2CuAV0/A2CuAV2/A2CuAV4";
                    $temp = $format($format, $msgBody);
                    //当前累计流量
                    $CuAVp = (dechex($temp['CuAVp'])) & 0xFF;
                    $CuAV0 = (dechex($temp['CuAV0'])) & 0xFF;
                    $CuAV2 = (dechex($temp['CuAV2'])) & 0xFF;
                    $CuAV4 = (dechex($temp['CuAV4'])) & 0xFF;
                    $CuAVu = $temp['CuAVu'];
                    $CuAV = $CuAV4 * 10000 + $CuAV2 * 100 + $CuAV0 + $CuAVp / 100;
                    //按照道理，应该讲数据发送给L2SNR的水表等外设进行处理。这里先偷懒，直接将数据存入到数据库中。
                    $resp = $cj188Obj->dbi_std_cj188_data_save_counter_data_heat_meter_last_month($msgAddr, $msgType, $CuAV, $CuAVu, 2);
                }
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA3:
                if (($msgLen = 0x16) && (($msgType == MFUN_NBIOT_CJ188_T_TYPE_COLD_WATER_METER) || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_HOT_WATER_METER)
                        || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_DRINK_WATER_METER) || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_MIDDLE_WATER_METER)
                        || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_GAS_METER) || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_ELECTRONIC_POWER_METER)))
                {
                    $format = "A2DI0/A2DI1/A2Ser/A2CuAVp/A2CuAV0/A2CuAV2/A2CuAV4";
                    $temp = $format($format, $msgBody);
                    //当前累计流量
                    $CuAVp = (dechex($temp['CuAVp'])) & 0xFF;
                    $CuAV0 = (dechex($temp['CuAV0'])) & 0xFF;
                    $CuAV2 = (dechex($temp['CuAV2'])) & 0xFF;
                    $CuAV4 = (dechex($temp['CuAV4'])) & 0xFF;
                    $CuAVu = $temp['CuAVu'];
                    $CuAV = $CuAV4 * 10000 + $CuAV2 * 100 + $CuAV0 + $CuAVp / 100;
                    //按照道理，应该讲数据发送给L2SNR的水表等外设进行处理。这里先偷懒，直接将数据存入到数据库中。
                    $resp = $cj188Obj->dbi_std_cj188_data_save_counter_data_water_and_gas_and_power_meter_last_month($msgAddr, $msgType, $CuAV, $CuAVu, 3);
                }
                elseif (($msgLen = 0x2E) && (($msgType == MFUN_NBIOT_CJ188_T_TYPE_HEAT_ENERGY_METER) || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_COLD_ENERGY_METER)))
                {
                    $format = "A2DI0/A2DI1/A2Ser/A2CuAVp/A2CuAV0/A2CuAV2/A2CuAV4";
                    $temp = $format($format, $msgBody);
                    //当前累计流量
                    $CuAVp = (dechex($temp['CuAVp'])) & 0xFF;
                    $CuAV0 = (dechex($temp['CuAV0'])) & 0xFF;
                    $CuAV2 = (dechex($temp['CuAV2'])) & 0xFF;
                    $CuAV4 = (dechex($temp['CuAV4'])) & 0xFF;
                    $CuAVu = $temp['CuAVu'];
                    $CuAV = $CuAV4 * 10000 + $CuAV2 * 100 + $CuAV0 + $CuAVp / 100;
                    //按照道理，应该讲数据发送给L2SNR的水表等外设进行处理。这里先偷懒，直接将数据存入到数据库中。
                    $resp = $cj188Obj->dbi_std_cj188_data_save_counter_data_heat_meter_last_month($msgAddr, $msgType, $CuAV, $CuAVu, 3);
                }
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA4:
                if (($msgLen = 0x16) && (($msgType == MFUN_NBIOT_CJ188_T_TYPE_COLD_WATER_METER) || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_HOT_WATER_METER)
                        || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_DRINK_WATER_METER) || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_MIDDLE_WATER_METER)
                        || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_GAS_METER) || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_ELECTRONIC_POWER_METER)))
                {
                    $format = "A2DI0/A2DI1/A2Ser/A2CuAVp/A2CuAV0/A2CuAV2/A2CuAV4";
                    $temp = $format($format, $msgBody);
                    //当前累计流量
                    $CuAVp = (dechex($temp['CuAVp'])) & 0xFF;
                    $CuAV0 = (dechex($temp['CuAV0'])) & 0xFF;
                    $CuAV2 = (dechex($temp['CuAV2'])) & 0xFF;
                    $CuAV4 = (dechex($temp['CuAV4'])) & 0xFF;
                    $CuAVu = $temp['CuAVu'];
                    $CuAV = $CuAV4 * 10000 + $CuAV2 * 100 + $CuAV0 + $CuAVp / 100;
                    //按照道理，应该讲数据发送给L2SNR的水表等外设进行处理。这里先偷懒，直接将数据存入到数据库中。
                    $resp = $cj188Obj->dbi_std_cj188_data_save_counter_data_water_and_gas_and_power_meter_last_month($msgAddr, $msgType, $CuAV, $CuAVu, 4);
                }
                elseif (($msgLen = 0x2E) && (($msgType == MFUN_NBIOT_CJ188_T_TYPE_HEAT_ENERGY_METER) || ($msgType == MFUN_NBIOT_CJ188_T_TYPE_COLD_ENERGY_METER)))
                {
                    $format = "A2DI0/A2DI1/A2Ser/A2CuAVp/A2CuAV0/A2CuAV2/A2CuAV4";
                    $temp = $format($format, $msgBody);
                    //当前累计流量
                    $CuAVp = (dechex($temp['CuAVp'])) & 0xFF;
                    $CuAV0 = (dechex($temp['CuAV0'])) & 0xFF;
                    $CuAV2 = (dechex($temp['CuAV2'])) & 0xFF;
                    $CuAV4 = (dechex($temp['CuAV4'])) & 0xFF;
                    $CuAVu = $temp['CuAVu'];
                    $CuAV = $CuAV4 * 10000 + $CuAV2 * 100 + $CuAV0 + $CuAVp / 100;
                    //按照道理，应该讲数据发送给L2SNR的水表等外设进行处理。这里先偷懒，直接将数据存入到数据库中。
                    $resp = $cj188Obj->dbi_std_cj188_data_save_counter_data_heat_meter_last_month($msgAddr, $msgType, $CuAV, $CuAVu, 4);
                }
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA5:
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA6:
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA7:
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA8:
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA9:
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA10:
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA11:
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_HISTORY_COUNTER_DATA12:
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_PRICE_TABLE:
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_BILL_DATE:
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_ACCOUNT_DATE:
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_BUY_AMOUNT:
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_KEY_VER:
                break;
            case MFUN_NBIOT_CJ188_READ_DI0DI1_ADDRESS:
                break;

            default:
                $resp = "";
                break;
        }


        return $resp;
    }

    function func_frame_read_key_ver_process($msgAddr,$msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $msgAddr6)
    {
        return "";
    }

    function func_frame_read_addr_process($msgAddr,$msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $msgAddr)
    {
        return "";
    }

    function func_frame_write_process($msgAddr,$msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $msgAddr)
    {
        return "";
    }

    function func_frame_set_device_syn_process($msgAddr,$msgType, $msgBody, $msgLen, $msgCtrlDir, $msgCtrlStatus, $msgAddr)
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