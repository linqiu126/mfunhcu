<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2015/12/13
 * Time: 13:12
 */
//include_once "../../l1comvm/vmlayer.php";

class classTaskL2snrCommonService
{
    //构造函数
    public function __construct()
    {

    }

    public function func_timeSync_process($platform, $deviceId, $data)  //时间同步消息处理，返回当前时间戳
    {
        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        $cmdid = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_TIME_SYNC);
        $now = time();
        $timestamp = dechex($now);
        $length = "04";
        $resp = $cmdid . $length . $timestamp;

        return $resp;
    }

    public function func_heartBeat_process() //心跳监测消息处理，返回心跳帧
    {
        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        $cmdid = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_HEART_BEAT);
        $length = "00";
        $resp = $cmdid . $length;

        return $resp;
    }

    public function func_hcuPolling_process($deviceId)
    {
        $cDbObj = new classDbiL1vmCommon();
        $resp = $cDbObj->dbi_cmdbuf_inquiry_cmd($deviceId);
        if (empty($resp))
        {
            $dbiL1vmCommonObj = new classDbiL1vmCommon();
            $cmdid = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_HCU_POLLING);
            $length = "00";
            $resp = $cmdid . $length;
        }

        return $resp;
    }

    public function func_hcuAlarmData_process($deviceId, $statCode, $content, $PictureName)
    {
        $format = "A2CmdId/A2Length/A2OptionId/A2EquipmentId/A2CmdIdBackType/A2AlarmType/A4AlarmDescription/A2AlarmServerity/A2AlarmClearFlag/A8AlarmTime";
        $data = unpack($format, $content);

        $CmdId = hexdec($data['CmdId']) & 0xFF;
        $Length = hexdec($data['Length']) & 0xFF;
        $OptionId = hexdec($data['OptionId']) & 0xFF;
        $EquipmentId = hexdec($data['EquipmentId']) & 0xFF;
        $CmdIdBackType = hexdec($data['CmdIdBackType']) & 0xFF;
        $AlarmType = hexdec($data['AlarmType']) & 0xFF;
        $AlarmDescription = hexdec($data['AlarmDescription']) & 0xFFFF;
        $AlarmServerity = hexdec($data['AlarmServerity']) & 0xFF;
        $AlarmClearFlag = hexdec($data['AlarmClearFlag']) & 0xFF;
        $AlarmTime = hexdec($data['AlarmTime']) & 0xFFFFFFFF;

        $cDbObj = new classDbiL1vmCommon();

        //$resp = $cDbObj->dbi_hcu_alarm_data_save($deviceId, $statCode, $AlarmType, $AlarmDescription, $SensorId, $AlarmTime);
        $resp = $cDbObj->dbi_hcu_alarm_data_save($deviceId, $statCode, $EquipmentId, $AlarmType, $AlarmDescription, $AlarmServerity, $AlarmClearFlag, $AlarmTime, $PictureName);
        return $resp;
    }

    public function func_hcuPerformance_process($deviceId, $statCode, $content)
    {
        $format = "A2CmdId/A2Len/A2OptId/A2CmdIdBackType/A4CurlConnAttempt/A4CurlConnFailCnt/A4CurlDiscCnt/A4SocketDiscCnt/A4PmTaskRestartCnt/A4CPUOccupyCnt/A4MemOccupyCnt/A4DiskOccupyCnt/A8createtime";
        $data = unpack($format, $content);

        $CmdId = hexdec($data['CmdId']) & 0xFF;
        $Len = hexdec($data['Len']) & 0xFF;
        $OptId = hexdec($data['OptId']) & 0xFF;
        $CmdIdBackType = hexdec($data['CmdIdBackType']) & 0xFF;
        $CurlConnAttempt = hexdec($data['CurlConnAttempt']) & 0xFFFF;
        $CurlConnFailCnt = hexdec($data['CurlConnFailCnt']) & 0xFFFF;
        $CurlDiscCnt = hexdec($data['CurlDiscCnt']) & 0xFFFF;
        $SocketDiscCnt = hexdec($data['SocketDiscCnt']) & 0xFFFF;
        $PmTaskRestartCnt = hexdec($data['PmTaskRestartCnt']) & 0xFFFF;
        $CPUOccupyCnt = hexdec($data['CPUOccupyCnt']) & 0xFFFF;
        $MemOccupyCnt = hexdec($data['MemOccupyCnt']) & 0xFFFF;
        $DiskOccupyCnt = hexdec($data['DiskOccupyCnt']) & 0xFFFF;
        $createtime = hexdec($data['createtime']) & 0xFFFFFFFF;

        $dbiL2snrCommonObj = new classDbiL2snrCommon();

        $resp = $dbiL2snrCommonObj->dbi_hcu_performance_data_save($deviceId, $statCode, $CurlConnAttempt, $CurlConnFailCnt, $CurlDiscCnt, $SocketDiscCnt, $PmTaskRestartCnt, $CPUOccupyCnt, $MemOccupyCnt, $DiskOccupyCnt, $createtime);

        return $resp;
    }

    public function func_version_update_process($platform,$deviceId, $content)
    {
        $mac = hexdec(substr($content, 4, 12)) & 0xFFFFFFFFFFFF;
        $hw_type = hexdec(substr($content, 16, 2)) & 0xFF;
        $hw_ver = hexdec(substr($content, 18, 4)) & 0xFFFF;
        $sw_rel = hexdec(substr($content, 22, 2)) & 0xFF;
        $sw_drop = hexdec(substr($content, 24, 4)) & 0xFFFF;

        $cDbObj = new classDbiL1vmCommon();
        $cDbObj->dbi_deviceVersion_update($deviceId,"",$hw_type,$hw_ver,$sw_rel,$sw_drop,"");

        switch($platform)
        {
            case MFUN_TECH_PLTF_WECHAT:  //说明版本更新请求来自微信，验证IHU设备信息表（t_deviceqrcode）中MAC地址合法性
                $wDbObj = new classDbiL2sdkWechat();
                $result = $wDbObj->dbi_deviceQrcode_valid_mac($deviceId, $mac);
                if ($result == true)
                    $resp = ""; //暂时没有resp msg，后面可以考虑如果版本不是最新，强制下载最新软件
                else
                    $resp = "COMMON_SERVICE: IHU invalid MAC address";
                break;
            case MFUN_TECH_PLTF_HCUGX:  //说明版本更新请求来自HCU，验证HCU设备信息表（t_hcudevice）中MAC地址合法性
                $cDbObj = new classDbiL2sdkHcu();
                $result = $cDbObj->dbi_hcuDevice_valid_mac($deviceId, $mac);
                if ($result == true)
                    $resp = ""; //暂时没有resp msg，后面可以考虑如果版本不是最新，强制下载最新软件
                else
                    $resp = "COMMON_SERVICE: HCU invalid MAC address";
                break;
            case MFUN_TECH_PLTF_JDIOT:
                $resp = "";
                break;
            default:
                $resp = "COMMON_SERVICE: PLTF invalid";
                break;
        }
        return $resp;
    }

    public function func_inventory_data_process($platform,$deviceId, $content)
    {
        //$format = "A2Key/A2Len/A2Opt/A2Type/A6Uuid/A2HW_Tpye/A4HW_Ver/A2SW_Rel/A4SW_Drop";
        $format = "A2Key/A2Len/A2Opt/A2Type/A34MAC_Addr/A2HW_Type/A4HW_Ver/A2SW_Rel/A4SW_Drop/A4DB_Ver";
        $data = unpack($format, $content);

        $length = hexdec($data['Len']) & 0xFF;
        $length = ($length + 2)*2; //消息总长度等于length＋1B 控制字＋1B长度本身
        if ($length != strlen($content)){
            return "COMMON_SERVICE[HCU]: Inventory message length invalid";  //消息长度不合法，直接返回
        }

        $mac = pack("H*",$data['MAC_Addr']);
        $hw_type = hexdec($data['HW_Type']) & 0xFF;
        $hw_ver = hexdec($data['HW_Ver']) & 0xFFFF;
        $sw_rel = hexdec($data['SW_Rel']) & 0xFF;
        $sw_drop = hexdec($data['SW_Drop']) & 0xFFFF;
        $db_ver = hexdec($data['DB_Ver']) & 0xFFFF;

        $cDbObj = new classDbiL1vmCommon();
        $cDbObj->dbi_deviceVersion_update($deviceId,$mac,$hw_type,$hw_ver,$sw_rel,$sw_drop, $db_ver);

        /*
        switch($platform)
        {
            case PLTF_WX:  //说明版本更新请求来自微信，验证IHU设备信息表（t_deviceqrcode）中MAC地址合法性
                $wDbObj = new classDbiL2sdkWechat();
                $result = $wDbObj->dbi_deviceQrcode_valid_mac($deviceId, $mac);
                if ($result == ture)
                    $resp = ""; //暂时没有resp msg，后面可以考虑如果版本不是最新，强制下载最新软件
                else
                    $resp = "COMMON_SERVICE: IHU invalid MAC address";
                break;
            case PLTF_HCU:  //说明版本更新请求来自HCU，验证HCU设备信息表（t_hcudevice）中MAC地址合法性
                $cDbObj = new classDbiL2sdkIothcu();
                $result = $cDbObj->dbi_hcuDevice_valid_mac($deviceId, $mac);
                if ($result == ture)
                    $resp = ""; //暂时没有resp msg，后面可以考虑如果版本不是最新，强制下载最新软件
                else
                    $resp = "COMMON_SERVICE: HCU invalid MAC address";
                break;
            case PLTF_JD:
                $resp = "";
                break;
            default:
                $resp = "COMMON_SERVICE: PLTF invalid";
                break;
        }
        */

        $resp = "";
        return $resp;

    }


    public function func_version_push_process()
    {
        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        $cmdid = $dbiL1vmCommonObj->byte2string(MFUN_HCU_CMDID_VERSION_SYNC);
        $length = "01";
        $sub_key = "00";
        $msg_body = $cmdid . $length . $sub_key;

        $hex_body = pack('H*',$msg_body);

        return $hex_body;
    }


    /************************************************HUITP 消息处理*****************************************************/

    public function func_hcuAlarmData_huitp_process($devCode, $statCode, $data)
    {
        $AlarmType = hexdec($data[1]['HUITP_IEID_uni_alarm_info_element']['alarmType']) & 0xFFFF;
        $AlarmServerity = hexdec($data[1]['HUITP_IEID_uni_alarm_info_element']['alarmServerity']) & 0xFF;
        $AlarmClearFlag = hexdec($data[1]['HUITP_IEID_uni_alarm_info_element']['alarmClearFlag']) & 0xFF;
        $EquipmentId = hexdec($data[1]['HUITP_IEID_uni_alarm_info_element']['equID']) & 0xFFFFFFFF;

        //$AlarmDescription = $data[1]['HUITP_IEID_uni_alarm_info_element']['alarmDesc'];
        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        $AlarmDescription = $dbiL1vmCommonObj->Hex2String($data[1]['HUITP_IEID_uni_alarm_info_element']['alarmDescp']);

        //new
        $CauseId = hexdec($data[1]['HUITP_IEID_uni_alarm_info_element']['causeId']) & 0xFFFFFFFF;
        $AlarmContent = hexdec($data[1]['HUITP_IEID_uni_alarm_info_element']['alarmContent']) & 0xFFFFFFFF;

        $AlarmTime = time();

        $dbiL2snrCommonObj = new classDbiL2snrCommon();
        $resp = $dbiL2snrCommonObj->dbi_hcu_alarm_huitp_data_save($devCode, $statCode, $EquipmentId, $AlarmType, $AlarmDescription, $AlarmServerity, $AlarmClearFlag, $AlarmTime, $CauseId, $AlarmContent);
        return $resp;
    }

    public function func_hcuPerformance_huitp_process($deviceId, $statCode, $data)
    {
        $PmTaskRestartCnt = hexdec($data[1]['HUITP_IEID_uni_performance_info_element']['restartCnt']) & 0xFFFFFFFF;
        $CurlConnAttempt = hexdec($data[1]['HUITP_IEID_uni_performance_info_element']['networkConnCnt']) & 0xFFFFFFFF;
        $CurlConnFailCnt = hexdec($data[1]['HUITP_IEID_uni_performance_info_element']['networkConnFailCnt']) & 0xFFFFFFFF;
        $CurlDiscCnt = hexdec($data[1]['HUITP_IEID_uni_performance_info_element']['networkDiscCnt']) & 0xFFFFFFFF;
        $SocketDiscCnt = hexdec($data[1]['HUITP_IEID_uni_performance_info_element']['socketDiscCnt']) & 0xFFFFFFFF;
        $CPUOccupyCnt = hexdec($data[1]['HUITP_IEID_uni_performance_info_element']['cpuOccupy']) & 0xFFFFFFFF;
        $MemOccupyCnt = hexdec($data[1]['HUITP_IEID_uni_performance_info_element']['memOccupy']) & 0xFFFFFFFF;
        $DiskOccupyCnt = hexdec($data[1]['HUITP_IEID_uni_performance_info_element']['diskOccupy']) & 0xFFFFFFFF;
        $CpuTemp = hexdec($data[1]['HUITP_IEID_uni_performance_info_element']['cpuTemp']) & 0xFFFFFFFF;
        $createtime = time();

        $dbiL2snrCommonObj = new classDbiL2snrCommon();
        $resp = $dbiL2snrCommonObj->dbi_hcu_performance_huitp_data_save($deviceId, $statCode, $CurlConnAttempt, $CurlConnFailCnt, $CurlDiscCnt, $SocketDiscCnt, $PmTaskRestartCnt, $CPUOccupyCnt, $MemOccupyCnt, $DiskOccupyCnt, $CpuTemp, $createtime);

        return $resp;
    }

    public function func_inventory_huitp_data_process($deviceId, $data)
    {
        $hw_type = hexdec($data[1]['HUITP_IEID_uni_inventory_element']['hwType']) & 0xFFFF;
        $hw_ver = hexdec($data[1]['HUITP_IEID_uni_inventory_element']['hwId']) & 0xFFFF;
        $sw_rel = hexdec($data[1]['HUITP_IEID_uni_inventory_element']['swRel']) & 0xFFFF;
        $sw_drop = hexdec($data[1]['HUITP_IEID_uni_inventory_element']['swVer']) & 0xFFFF;
        $upgradeFlag = hexdec($data[1]['HUITP_IEID_uni_inventory_element']['upgradeFlag']) & 0xFFFF;
        $timeStamp = time();

        //$desc = $data[1]['HUITP_IEID_uni_inventory_element']['desc'];
        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        $descp = $dbiL1vmCommonObj->Hex2String($data[1]['HUITP_IEID_uni_inventory_element']['descp']);

        $dbiL2snrCommonObj = new classDbiL2snrCommon();
        $resp = $dbiL2snrCommonObj->dbi_deviceVersion_huitp_update($deviceId,$hw_type,$hw_ver,$sw_rel,$sw_drop, $upgradeFlag,$descp,$timeStamp);

        return $resp;
    }


    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2snr_common_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //初始化消息内容
        $project= "";
        $log_from = "";
        $platform ="";
        $devCode="";
        $statCode = "";
        $content="";

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_COMMON", "mfun_l2snr_common_task_main_entry", $log_time, $log_content);
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

        switch($msgId)
        {
            case HUITP_MSGID_uni_alarm_info_report:
                //具体处理函数
                $resp = $this->func_hcuAlarmData_huitp_process($devCode, $statCode, $content);
                break;
            case HUITP_MSGID_uni_performance_info_report:
                //具体处理函数
                $resp = $this->func_hcuPerformance_huitp_process($devCode, $statCode, $content);
                break;

            case HUITP_MSGID_uni_inventory_report:
                //具体处理函数
                $resp = $this->func_inventory_huitp_data_process($devCode, $content);
                break;
            default:
                $resp = ""; //啥都不ECHO
                break;
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