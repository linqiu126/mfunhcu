<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2015/12/13
 * Time: 12:26
 */
//include_once "../../l1comvm/vmlayer.php";
include_once "dbi_l2snr_noise.class.php";


class classTaskL2snrNoise
{
    public function func_noise_process($platform, $deviceId, $statCode, $content)
    {
        switch($platform)
        {
            case MFUN_TECH_PLTF_WECHAT:
                $length = hexdec(substr($content, 2, 2)) & 0xFF;
                $length = ($length + 2)*2; //消息总长度等于length＋1B 控制字＋1B长度本身
                if ($length != strlen($content)){
                    return "NOISE_SERVICE[WX]: message length invalid";  //消息长度不合法，直接返回
                }
                $sub_key = hexdec(substr($content, 4, 2)) & 0xFF;
                switch ($sub_key) //MODBUS操作字处理
                {
                    case MFUN_HCU_MODBUS_DATA_REPORT:
                        $resp = $this->wx_noise_req_process($deviceId, $content);
                        break;
                    default:
                        $resp = "";
                        break;
                }
                break;
            case MFUN_TECH_PLTF_HCUGX:
                $raw_MsgHead = substr($content, 0, MFUN_HCU_MSG_HEAD_LENGTH);  //截取4Byte MsgHead
                $msgHead = unpack(MFUN_HCU_MSG_HEAD_FORMAT, $raw_MsgHead);

                $length = hexdec($msgHead['Len']) & 0xFF;
                $length =  ($length+2) * 2; //因为收到的消息为16进制字符，消息总长度等于length＋1B控制字＋1B长度本身
                if ($length != strlen($content)) {
                    return "NOISE_SERVICE[HCU]: message length invalid";  //消息长度不合法，直接返回
                }
                $data = substr($content, MFUN_HCU_MSG_HEAD_LENGTH, $length - MFUN_HCU_MSG_HEAD_LENGTH);//截取消息数据域

                $opt_key = hexdec($msgHead['Cmd']) & 0xFF;
                switch ($opt_key) //MODBUS操作字处理
                {
                    case MFUN_HCU_MODBUS_DATA_REPORT:
                        $resp = $this->hcu_noise_req_process($deviceId, $statCode, $data);
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
                $resp = "NOISE_SERVICE: PLTF invalid";
                break;
        }
        return $resp;
    }

    public function func_noise_huitp_process($platform, $deviceId, $statCode, $content)
    {
        switch($platform)
        {
            case MFUN_TECH_PLTF_WECHAT:
                $length = hexdec(substr($content, 2, 2)) & 0xFF;
                $length = ($length + 2)*2; //消息总长度等于length＋1B 控制字＋1B长度本身
                if ($length != strlen($content)){
                    return "NOISE_SERVICE[WX]: message length invalid";  //消息长度不合法，直接返回
                }
                $sub_key = hexdec(substr($content, 4, 2)) & 0xFF;
                switch ($sub_key) //MODBUS操作字处理
                {
                    case MFUN_HCU_MODBUS_DATA_REPORT:
                        $resp = $this->wx_noise_req_process($deviceId, $content);
                        break;
                    default:
                        $resp = "";
                        break;
                }
                break;
            case MFUN_TECH_PLTF_HCUGX:

                $opt_key = $content[1]['HUITP_IEID_uni_noise_value']['ieId'];
                $noise = $content[1]['HUITP_IEID_uni_noise_value']['noiseValue'];
                $dataFormat = pow(10,$content[1]['HUITP_IEID_uni_noise_value']['dataFormat']);
                $noiseValue = hexdec($noise) / $dataFormat;
                $timeStamp = $content[1]['HUITP_IEID_uni_noise_value']['timeStamp'];

                $resp = $this->hcu_noise_req_huitp_process($deviceId, $statCode, $timeStamp, $noiseValue);

                break;
            case MFUN_TECH_PLTF_JDIOT:
                $resp = ""; //no response message
                break;
            default:
                $resp = "NOISE_SERVICE: PLTF invalid";
                break;
        }
        return $resp;
    }

    private function wx_noise_req_process( $deviceId, $content)
    {
        //微信平台暂时不支持
        /*
        $noise =  hexdec(substr($content, 6, 4)) & 0xFFFF;
        $devCode = hexdec(substr($content, 10, 4)) & 0xFFFF;
        //$ntimes = hexdec(substr($content, 14, 4)) & 0xFFFF;
        $ntimes =time();
        $gps = "";

        $sDbObj = new class_service_db();
        $sDbObj->dbi_noise_data_save($deviceId,$devCode,$ntimes,$noise,$gps);
        */
        $resp = ""; //no response message
        return $resp;
    }

    private function hcu_noise_req_process( $deviceId,$statCode,$content)
    {
        $format = "A2Equ/A2Type/A2Format/A8Noise/A2Flag_Lo/A8Longitude/A2Flag_La/A8Latitude/A8Altitude/A8Time";
        $data = unpack($format, $content);

        $sensorId = hexdec($data['Equ']) & 0xFF;
        $report["format"] = hexdec($data['Format']) & 0xFF;
        $report["value"] = hexdec($data['Noise']) & 0xFFFFFFFF;
        $gps["flag_la"] = chr(hexdec($data['Flag_La']) & 0xFF);
        $gps["latitude"] = hexdec($data['Latitude']) & 0xFFFFFFFF;
        $gps["flag_lo"] = chr(hexdec($data['Flag_Lo']) & 0xFF);
        $gps["longitude"] = hexdec($data['Longitude']) & 0xFFFFFFFF;
        $gps["altitude"] = hexdec($data['Altitude']) & 0xFFFFFFFF;
        $timeStamp = hexdec($data['Time']) & 0xFFFFFFFF;

        $sDbObj = new classDbiL2snrNoise();
        $sDbObj->dbi_noise_data_save($deviceId, $sensorId, $timeStamp, $report,$gps);
        //该函数处理需要再完善，不确定是否可用
        $sDbObj->dbi_noiseData_delete_3monold($sensorId, $deviceId, MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS);  //remove 90 days old data.

        //更新分钟测量报告聚合表
        $sDbObj->dbi_minreport_update_noise($deviceId,$statCode,$timeStamp,$report);

        //更新数据精度格式表
        $format = $report["format"];
        $cDbObj = new classDbiL2snrCom();
        $cDbObj->dbi_dataformat_update_format($deviceId,"T_noise",$format);
        //更新瞬时测量值聚合表
        $cDbObj = new classDbiL3apF3dm();
        $cDbObj->dbi_currentreport_update_value($deviceId, $statCode, $timeStamp,"T_noise", $report);

        $resp = ""; //no response message
        return $resp;
    }

    private function hcu_noise_req_huitp_process( $deviceId,$statCode,$timeStamp, $noiseValue)
    {
        $timeStamp = hexdec($timeStamp) & 0xFFFFFFFF;

        $sDbObj = new classDbiL2snrNoise();
        $sDbObj->dbi_noise_huitp_data_save($deviceId, $timeStamp, $noiseValue);
        //该函数处理需要再完善，不确定是否可用
        $sDbObj->dbi_noiseData_huitp_delete_3monold($deviceId, MFUN_HCU_DATA_SAVE_DURATION_IN_DAYS);  //remove 90 days old data.

        //更新分钟测量报告聚合表
        $sDbObj->dbi_minreport_huitp_update_noise($deviceId,$statCode,$timeStamp,$noiseValue);

        //更新瞬时测量值聚合表
        $cDbObj = new classDbiL3apF3dm();
        $cDbObj->dbi_currentreport_huitp_update_value($deviceId, $statCode, $timeStamp, "T_noise", $noiseValue);

        $resp = ""; //no response message
        return $resp;
    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2snr_noise_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_NOISE", "mfun_l2snr_noise_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到PM25
        if (($msgId != MSG_ID_L2SDK_HCU_TO_L2SNR_NOISE) && ($msgId != MSG_ID_L2SDK_EMCWX_TO_L2SNR_NOISE_DATA_READ_INSTANT) && ($msgId != MSG_ID_L2SDK_EMCWX_TO_L2SNR_NOISE_DATA_REPORT_TIMING) && ($msgId != HUITP_MSGID_uni_noise_data_report)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_NOISE", "mfun_l2snr_noise_task_main_entry", $log_time, $log_content);
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

        if ($msgId == MSG_ID_L2SDK_HCU_TO_L2SNR_NOISE)
        {
            if (isset($msg["project"])) $project = $msg["project"];
            if (isset($msg["log_from"])) $log_from = $msg["log_from"];
            if (isset($msg["platform"])) $platform = $msg["platform"];
            if (isset($msg["deviceId"])) $deviceId = $msg["deviceId"];
            if (isset($msg["statCode"])) $statCode = $msg["statCode"];
            if (isset($msg["content"])) $content = $msg["content"];

            //具体处理函数
            $resp = $this->func_noise_process($platform, $deviceId, $statCode, $content);
        }
        elseif ($msgId == MSG_ID_L2SDK_EMCWX_TO_L2SNR_NOISE_DATA_READ_INSTANT)
        {
            //解开消息
            if (isset($msg["project"])) $project = $msg["project"];
            if (isset($msg["log_from"])) $log_from = $msg["log_from"];
            if (isset($msg["deviceId"])) $deviceId = $msg["deviceId"];
            if (isset($msg["content"])) $content = $msg["content"];
            //具体处理函数
            $resp = $this->wx_noise_req_process($deviceId, $content);
        }
        elseif ($msgId == MSG_ID_L2SDK_EMCWX_TO_L2SNR_NOISE_DATA_REPORT_TIMING)
        {
            //解开消息
            if (isset($msg["project"])) $project = $msg["project"];
            if (isset($msg["log_from"])) $log_from = $msg["log_from"];
            if (isset($msg["platform"])) $platform = $msg["platform"];
            if (isset($msg["deviceId"])) $deviceId = $msg["deviceId"];
            if (isset($msg["statCode"])) $statCode = $msg["statCode"];
            if (isset($msg["content"])) $content = $msg["content"];

            //具体处理函数
            $resp = $this->func_noise_process($platform, $deviceId, $statCode, $content);
        }
        elseif ($msgId == HUITP_MSGID_uni_noise_data_report)
        {
            //解开消息
            if (isset($msg["project"])) $project = $msg["project"];
            if (isset($msg["log_from"])) $log_from = $msg["log_from"];
            if (isset($msg["platform"])) $platform = $msg["platform"];
            if (isset($msg["deviceId"])) $deviceId = $msg["deviceId"];
            if (isset($msg["statCode"])) $statCode = $msg["statCode"];
            if (isset($msg["content"])) $content = $msg["content"];

            //具体处理函数
            $resp = $this->func_noise_huitp_process($platform, $deviceId, $statCode, $content);
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


}

?>
