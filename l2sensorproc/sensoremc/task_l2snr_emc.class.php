<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2015/12/13
 * Time: 12:19
 */
//include_once "../../l1comvm/vmlayer.php";
include_once "dbi_l2snr_emc.class.php";

class classTaskL2snrEmc
{
    //构造函数
    public function __construct()
    {

    }

    public function func_emc_process($platform, $deviceId, $statCode, $timeStamp,$content)
    {
        switch($platform)
        {
            case MFUN_TECH_PLTF_WECHAT:
                if (strlen($content) == 0) {
                    return "ERROR EMC_SERVICE[WX]: message length invalid";  //消息长度不合法，直接返回
                }
                $resp = $this->wx_emcdata_req_process($deviceId, $timeStamp, $content);
                break;
            case MFUN_TECH_PLTF_HCUGX:
                $raw_MsgHead = substr($content, 0, MFUN_HCU_MSG_HEAD_LENGTH);  //截取6Byte MsgHead
                $msgHead = unpack(MFUN_HCU_MSG_HEAD_FORMAT, $raw_MsgHead);

                $length = hexdec($msgHead['Len']) & 0xFF;
                $length =  ($length+2) * 2; //因为收到的消息为16进制字符，消息总长度等于length＋1B控制字＋1B长度本身
                if ($length != strlen($content)) {
                    return "ERROR EMC_SERVICE[HCU]: message length invalid";  //消息长度不合法，直接返回
                }
                $data = substr($content, MFUN_HCU_MSG_HEAD_LENGTH, $length - MFUN_HCU_MSG_HEAD_LENGTH);//截取消息数据域

                $opt_key = hexdec($msgHead['Cmd']) & 0xFF;
                switch ($opt_key) //MODBUS操作字处理
                {
                    case MFUN_HCU_MODBUS_DATA_REPORT:
                        $resp = $this->hcu_emcdata_req_process($deviceId, $statCode, $data);
                        break;
                    default:
                        $resp = "";
                        break;
                }
                break;
            case MFUN_TECH_PLTF_JDIOT:
                $resp = ""; //no response message
                break;
            default:
                $resp = "ERROR EMC_SERVICE: PLTF invalid";
                break;
        }
        return $resp;
    }

    private function wx_emcdata_req_process( $deviceId, $timeStamp, $content)
    {
        //$format = "A2EmcCmd/A2Len/A4EmcValue/A12Time/A12Gps";
        //$data = unpack($format, $content);
        $emc_value = $content; //注意，微信过来的EMC值已经在IOT_WX中进行了十进制转换，所有不需要再转换了
        $report["format"] = 0;
        $report["value"] = $emc_value; //保持和HCU EMC_data的处理一致，增加数据格式
        $gps = "";
        $sensorId = 1;

        $sDbObj = new classDbiL2snrEmc();
        $sDbObj->dbi_emcData_save($deviceId, $sensorId, $timeStamp, $report, $gps);
        $sDbObj->dbi_emcData_delete_3monold($deviceId, $sensorId, MFUN_HCU_DATA_SAVE_DURATION_BY_PROJ);  //remove 90 days old data.
        $sDbObj->dbi_emcAccumulation_save($deviceId); //累计值计算，如果不是初次接收数据，而且日期没有改变，则该过程将非常快

        $resp = ""; //no response message
        return $resp;
    }

    private function hcu_emcdata_req_process( $deviceId,$statCode,$content)
    {
        $format = "A2Equ/A2Type/A2Format/A4Emc/A2Flag_Lo/A8Longitude/A2Flag_La/A8Latitude/A8Altitude/A8Time";
        $data = unpack($format, $content);

        $sensorId = hexdec($data['Equ']) & 0xFF;
        $report["format"] = hexdec($data['Format']) & 0xFF;
        $report["value"] = hexdec($data['Emc']) & 0xFFFF;  //转换成十进制
        $gps["flag_la"] = chr(hexdec($data['Flag_La']) & 0xFF);
        $gps["latitude"] = hexdec($data['Latitude']) & 0xFFFFFFFF;
        $gps["flag_lo"] = chr(hexdec($data['Flag_Lo']) & 0xFF);
        $gps["longitude"] = hexdec($data['Longitude']) & 0xFFFFFFFF;
        $gps["altitude"] = hexdec($data['Altitude']) & 0xFFFFFFFF;
        $timeStamp = hexdec($data['Time']) & 0xFFFFFFFF;

        //存入数据库中
        $sDbObj = new classDbiL2snrEmc();
        $sDbObj->dbi_emcData_save($deviceId, $sensorId, $timeStamp, $report, $gps);
        //该函数处理需要再完善，不确定是否可用
        $sDbObj->dbi_emcData_delete_3monold($deviceId, $sensorId, MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS);  //remove 90 days old data.
        $sDbObj->dbi_emcAccumulation_save($deviceId); //累计值计算，如果不是初次接收数据，而且日期没有改变，则该过程将非常快

        //更新分钟测量报告聚合表
        $sDbObj->dbi_minreport_update_emc($deviceId,$statCode,$timeStamp,$report);

        $resp = "";
        return $resp;
    }

    public function func_emc_instant_read_process($deviceId, $content)
    {
        $magicCode = "FECF";
        $version = "0001";
        $length = "000C";
        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        $cmdid = $dbiL1vmCommonObj->ushort2string(MFUN_IHU_CMDID_EMC_INSTANT_READ);
        $seq = "0000";
        $errCode = "0000";

        $msg_body = $magicCode . $version . $length . $cmdid . $seq . $errCode;

        $hex_body = strtoupper(pack('H*',$msg_body));

        return $hex_body;
    }

    public function func_emc_period_read_open_process($deviceId, $content)
    {
        $magicCode = "FECF";
        $version = "0001";
        $length = "000C";
        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        $cmdid = $dbiL1vmCommonObj->ushort2string(MFUN_IHU_CMDID_EMC_PERIOD_READ_OPEN);
        $seq = "0000";
        $errCode = "0000";

        $msg_body = $magicCode . $version . $length . $cmdid . $seq . $errCode;

        $hex_body = strtoupper(pack('H*',$msg_body));

        return $hex_body;
    }

    public function func_emc_period_read_close_process($deviceId, $content)
    {
        $magicCode = "FECF";
        $version = "0001";
        $length = "000C";
        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        $cmdid = $dbiL1vmCommonObj->ushort2string(MFUN_IHU_CMDID_EMC_PERIOD_READ_CLOSE);
        $seq = "0000";
        $errCode = "0000";

        $msg_body = $magicCode . $version . $length . $cmdid . $seq . $errCode;

        $hex_body = strtoupper(pack('H*',$msg_body));

        return $hex_body;
    }

    public function func_emc_power_status_req_process($deviceId, $content)
    {
        $magicCode = "FECF";
        $version = "0001";
        $length = "000C";
        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        $cmdid = $dbiL1vmCommonObj->ushort2string(MFUN_IHU_CMDID_EMC_POWER_STATUS_REQ);
        $seq = "0000";
        $errCode = "0000";

        $msg_body = $magicCode . $version . $length . $cmdid . $seq . $errCode;
        $hex_body = strtoupper(pack('H*',$msg_body));

        return $hex_body;
    }


    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2snr_emc_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_EMC", "mfun_l2snr_emc_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到EMC
        if (($msgId != MSG_ID_L2SDK_HCU_TO_L2SNR_EMC) && ($msgId != MSG_ID_L2SDK_EMCWX_TO_L2SNR_EMC_DATA_READ_INSTANT) && ($msgId != MSG_ID_L2SDK_EMCWX_TO_L2SNR_EMC_DATA_REPORT_TIMING)
                && ($msgId != MSG_ID_L2SDK_EMCWX_TO_L2SNR_POWER_STATUS_REPORT_TIMING)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_EMC", "mfun_l2snr_emc_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        //赋初值
        $project= "";
        $log_from = "";
        $platform ="";
        $deviceId="";
        $statCode = "";
        $content="";

        if ($msgId == MSG_ID_L2SDK_HCU_TO_L2SNR_EMC)
        {
            //解开消息
            if (isset($msg["project"])) $project = $msg["project"];
            if (isset($msg["log_from"])) $log_from = $msg["log_from"];
            if (isset($msg["platform"])) $platform = $msg["platform"];
            if (isset($msg["deviceId"])) $deviceId = $msg["deviceId"];
            if (isset($msg["statCode"])) $statCode = $msg["statCode"];
            if (isset($msg["content"])) $content = $msg["content"];

            //具体处理函数
            $resp = $this->func_emc_process($platform, $deviceId, $statCode, "", $content);
        }
        elseif ($msgId == MSG_ID_L2SDK_EMCWX_TO_L2SNR_EMC_DATA_READ_INSTANT)
        {
            //解开消息
            if (isset($msg["project"])) $project = $msg["project"];
            if (isset($msg["log_from"])) $log_from = $msg["log_from"];
            if (isset($msg["deviceId"])) $deviceId = $msg["deviceId"];
            if (isset($msg["content"])) $content = $msg["content"];
            //具体处理函数
            $resp = $this->func_emc_instant_read_process($deviceId, $content);
        }
        elseif ($msgId == MSG_ID_L2SDK_EMCWX_TO_L2SNR_EMC_DATA_REPORT_TIMING)
        {
            //解开消息
            if (isset($msg["project"])) $project = $msg["project"];
            if (isset($msg["log_from"])) $log_from = $msg["log_from"];
            if (isset($msg["platform"])) $platform = $msg["platform"];
            if (isset($msg["deviceId"])) $deviceId = $msg["deviceId"];
            if (isset($msg["statCode"])) $statCode = $msg["statCode"];
            if (isset($msg["timeStamp"])) $timeStamp = $msg["timeStamp"];
            if (isset($msg["content"])) $content = $msg["content"];

            //具体处理函数
            $resp = $this->func_emc_process($platform, $deviceId, $statCode, $timeStamp, $content);
        }
        elseif ($msgId == MSG_ID_L2SDK_EMCWX_TO_L2SNR_POWER_STATUS_REPORT_TIMING)
        {
            //解开消息
            if (isset($msg["project"])) $project = $msg["project"];
            if (isset($msg["log_from"])) $log_from = $msg["log_from"];
            if (isset($msg["platform"])) $platform = $msg["platform"];
            if (isset($msg["deviceId"])) $deviceId = $msg["deviceId"];
            if (isset($msg["statCode"])) $statCode = $msg["statCode"];
            if (isset($msg["content"])) $content = $msg["content"];

            //具体处理函数
            $resp = $this->func_emc_process($platform, $deviceId, $statCode, "", $content);
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

}//End of class_emc_service

?>