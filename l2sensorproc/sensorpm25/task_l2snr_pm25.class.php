<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2015/12/13
 * Time: 12:23
 */
//include_once "../../l1comvm/vmlayer.php";
include_once "dbi_l2snr_pm25.class.php";


class classTaskL2snrPm25
{
    //构造函数
    public function __construct()
    {

    }

    public function func_pm25_data_process($platform, $devCode, $statCode, $content)
    {
        switch($platform)
        {
            case MFUN_TECH_PLTF_WECHAT:
                $length = hexdec(substr($content, 2, 2)) & 0xFF;
                $length =($length + 2)*2; //消息总长度等于length＋1B 控制字＋1B长度本身
                if ($length != strlen($content)){
                    return "PM_SERVICE[WX]: message length invalid";  //消息长度不合法，直接返回
                }
                $sub_key = hexdec(substr($content, 4, 2)) & 0xFF;
                switch ($sub_key) //MODBUS操作字处理
                {
                    case MFUN_HCU_MODBUS_DATA_REPORT:
                        $resp = $this->wx_pmdata_req_process($devCode, $content);
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
                    return "PM_SERVICE[HCU]: message length invalid";  //消息长度不合法，直接返回
                }
                $data = substr($content, MFUN_HCU_MSG_HEAD_LENGTH, $length - MFUN_HCU_MSG_HEAD_LENGTH);//截取消息数据域

                $opt_key = hexdec($msgHead['Cmd']) & 0xFF;
                switch ($opt_key) //MODBUS操作字处理
                {
                    case MFUN_HCU_MODBUS_DATA_REPORT:
                        $resp = $this->hcu_pmdata_req_process($devCode,$statCode, $data);
                        break;
                    case MFUN_HCU_MODBUS_SWITCH_SET_ACK:
                        $resp = $this->hcu_pm_switch_set_process($devCode,$statCode, $data);
                        break;
                    case MFUN_HCU_MODBUS_ADDR_SET_ACK:
                        $resp = "";
                        break;
                    case MFUN_HCU_MODBUS_PERIOD_SET_ACK:
                        $resp = "";
                        break;
                    case MFUN_HCU_MODBUS_SAMPLE_SET_ACK:
                        $resp = "";
                        break;
                    case MFUN_HCU_MODBUS_TIMES_SET_ACK:
                        $resp = "";
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
                $resp = "PM_SERVICE: PLTF invalid";
                break;

        }
        return $resp;
    }

    public function func_pm25_data_huitp_process($platform, $devCode, $statCode, $content)
    {
        switch($platform)
        {
            case MFUN_TECH_PLTF_WECHAT:
                $length = hexdec(substr($content, 2, 2)) & 0xFF;
                $length =($length + 2)*2; //消息总长度等于length＋1B 控制字＋1B长度本身
                if ($length != strlen($content)){
                    return "PM_SERVICE[WX]: message length invalid";  //消息长度不合法，直接返回
                }
                $sub_key = hexdec(substr($content, 4, 2)) & 0xFF;
                switch ($sub_key) //MODBUS操作字处理
                {
                    case MFUN_HCU_MODBUS_DATA_REPORT:
                        $resp = $this->wx_pmdata_req_process($devCode, $content);
                        break;
                    default:
                        $resp = "";
                        break;
                }
                break;
            case MFUN_TECH_PLTF_HCUGX_HUITP:

                $resp = $this->hcu_pmdata_req_huitp_process($devCode, $statCode, $content);

                break;
            case MFUN_TECH_PLTF_JDIOT:
                $resp = ""; //no response message
                break;
            default:
                $resp = "PM_SERVICE: PLTF invalid";
                break;

        }
        return $resp;
    }

    private function wx_pmdata_req_process( $devCode,$content)
    {
        $pmdata["pm01"] = hexdec(substr($content, 6, 8)) & 0xFFFFFFFF;
        $pmdata["pm25"] = hexdec(substr($content, 14, 8)) & 0xFFFFFFFF;
        $pmdata["pm10"] = hexdec(substr($content, 22, 8)) & 0xFFFFFFFF;
        $devCode = hexdec(substr($content, 30, 4)) & 0xFFFF;
        //$ntimes = hexdec(substr($content, 34, 4)) & 0xFFFF;
        $ntimes =time();
        $gps = "";

        $sDbObj = new classDbiL2snrPm25();
        $sDbObj->dbi_pmData_save($devCode, $devCode,$ntimes, $pmdata,$gps);
        $sDbObj->dbi_pmdata_delete_3monold($devCode, $devCode,90);  //remove 90 days old data.

        $resp = ""; //no response message
        return $resp;
    }

    private function hcu_pmdata_req_process( $devCode,$statCode,$content)
    {
        $format = "A2Equ/A2Type/A2Format/A8PM01/A8PM25/A8PM10/A2Flag_Lo/A8Longitude/A2Flag_La/A8Latitude/A8Altitude/A8Time";
        $data = unpack($format, $content);

        $sensorId = hexdec($data['Equ']) & 0xFF;
        $report["format"] = hexdec($data['Format']) & 0xFF;
        $report["pm01"] = hexdec($data['PM01']) & 0xFFFFFFFF;
        $report["pm25"] = hexdec($data['PM25']) & 0xFFFFFFFF;
        $report["pm10"] = hexdec($data['PM10']) & 0xFFFFFFFF;
        $gps["flag_la"] = chr(hexdec($data['Flag_La']) & 0xFF);
        $gps["latitude"] = hexdec($data['Latitude']) & 0xFFFFFFFF;
        $gps["flag_lo"] = chr(hexdec($data['Flag_Lo']) & 0xFF);
        $gps["longitude"] = hexdec($data['Longitude']) & 0xFFFFFFFF;
        $gps["altitude"] = hexdec($data['Altitude']) & 0xFFFFFFFF;
        $timeStamp = hexdec($data['Time']) & 0xFFFFFFFF;

        $sDbObj = new classDbiL2snrPm25();
        $sDbObj->dbi_pmData_save($devCode, $sensorId, $timeStamp, $report,$gps);
        //该函数处理需要再完善，不确定是否可用
        $sDbObj->dbi_pmdata_delete_3monold($devCode, $sensorId,90);  //remove 90 days old data.

        //更新分钟测量报告聚合表
        $sDbObj->dbi_minreport_update_pmdata($devCode,$statCode,$timeStamp,$report);

        //更新数据精度格式表
        $format = $report["format"];
        $cDbObj = new classDbiL2snrCommon();
        $cDbObj->dbi_dataformat_update_format($devCode,"T_pmdata",$format);
        //更新瞬时测量值聚合表
        $eDbObj = new classDbiL3apF3dm();
        $eDbObj->dbi_currentreport_update_value($devCode, $statCode, $timeStamp,"T_pmdata", $report);

        $resp = ""; //no response message
        return $resp;
    }

    private function hcu_pmdata_req_huitp_process( $devCode,$statCode,$content)
    {
        $pm01data = $content[1]['HUITP_IEID_uni_pm01_value']['pm01Value'];
        $pm01dataFormat = pow(10,$content[1]['HUITP_IEID_uni_pm01_value']['dataFormat']);
        $pm01Value = hexdec($pm01data) / $pm01dataFormat;

        $pm25data = $content[2]['HUITP_IEID_uni_pm25_value']['pm25Value'];
        $pm25dataFormat = pow(10,$content[2]['HUITP_IEID_uni_pm25_value']['dataFormat']);
        $pm25Value = hexdec($pm25data) / $pm25dataFormat;

        $pm10data = $content[3]['HUITP_IEID_uni_pm10_value']['pm10Value'];
        $pm10dataFormat = pow(10,$content[3]['HUITP_IEID_uni_pm10_value']['dataFormat']);
        $pm10Value = hexdec($pm10data) / $pm10dataFormat;

        $timeStamp = time();

        $sDbObj = new classDbiL2snrPm25();
        $resp = $sDbObj->dbi_pmData_huitp_save($devCode, $timeStamp, $pm01Value, $pm25Value, $pm10Value);
        //该函数处理需要再完善，不确定是否可用
        $resp = $sDbObj->dbi_pmdata_huitp_delete_3monold($devCode, 90);  //remove 90 days old data.

        //更新分钟测量报告聚合表
        $resp = $sDbObj->dbi_minreport_update_huitp_pmdata($devCode,$statCode,$timeStamp,$pm01Value, $pm25Value, $pm10Value);

        //更新瞬时测量值聚合表
        $eDbObj = new classDbiL3apF3dm();
        $pmdata = ["pm01"=>$pm01Value,"pm25"=>$pm25Value,"pm10"=>$pm10Value];
        $resp = $eDbObj->dbi_currentreport_update_value($devCode, $statCode, $timeStamp,"T_pmdata", $pmdata);

        return $resp;
    }

    private function hcu_pm_switch_set_process($devCode,$statCode, $content)
    {
        $format = "A2Equ/A2Status";
        $data = unpack($format, $content);

        $sensorId = hexdec($data['Equ']) & 0xFF;
        $status = hexdec($data['Status']) & 0xFF;

        $dbiL2sdkIotcomObj = new classDbiL2sdkIotcom();
        $dbiL2sdkIotcomObj->dbi_hcuDevice_update_status($devCode,$statCode,$status);

        $resp = ""; //no response message
        return $resp;
    }


    //PM强度读取 (Cloud- > IHU)
    public function func_pm_data_push_process($devCode, $content)
    {
        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        $cmdid = $dbiL1vmCommonObj->byte2string(MFUN_IHU_CMDID_PM25_DATA);
        $length = "01";
        $sub_key =  $dbiL1vmCommonObj->byte2string(MFUN_HCU_MODBUS_DATA_REQ);
        $msg_body = $cmdid . $length . $sub_key;

        $hex_body = pack('H*',$msg_body);

        return $hex_body;
    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2snr_pm25_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //赋初值
        $project= "";
        $log_from = "";
        $platform ="";
        $devCode ="";
        $statCode = "";
        $content="";

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_PM25", "mfun_l2snr_pm25_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        else{
            //解开消息
            if (isset($msg["project"])) $project = $msg["project"];
            if (isset($msg["log_from"])) $log_from = $msg["log_from"];
            if (isset($msg["platform"])) $platform = $msg["platform"];
            if (isset($msg["devCode"])) $devCode = $msg["devCode"];
            if (isset($msg["statCode"])) $statCode = $msg["statCode"];
            if (isset($msg["content"])) $content = $msg["content"];
        }

        //多条消息发送到PM25
        if (($msgId != MSG_ID_L2SDK_HCU_TO_L2SNR_PM25) && ($msgId != MSG_ID_L2SDK_EMCWX_TO_L2SNR_PM25_DATA_READ_INSTANT) && ($msgId != MSG_ID_L2SDK_EMCWX_TO_L2SNR_PM25_DATA_REPORT_TIMING)&& ($msgId != HUITP_MSGID_uni_pm25_data_report)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_PM25", "mfun_l2snr_pm25_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }



        if ($msgId == MSG_ID_L2SDK_HCU_TO_L2SNR_PM25)
        {
            //具体处理函数
            $resp = $this->func_pm25_data_process($platform, $devCode, $statCode, $content);
        }
        elseif ($msgId == MSG_ID_L2SDK_EMCWX_TO_L2SNR_PM25_DATA_READ_INSTANT)
        {
            //具体处理函数
            $resp = $this->func_pm_data_push_process($devCode, $content);
        }
        elseif ($msgId == MSG_ID_L2SDK_EMCWX_TO_L2SNR_PM25_DATA_REPORT_TIMING)
        {
            //具体处理函数
            $resp = $this->func_pm25_data_process($platform, $devCode, $statCode, $content);
        }
        elseif ($msgId == HUITP_MSGID_uni_pm25_data_report)
        {
            //具体处理函数
            $resp = $this->func_pm25_data_huitp_process($platform, $devCode, $statCode, $content);
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

}//End of class_pmData_service

?>