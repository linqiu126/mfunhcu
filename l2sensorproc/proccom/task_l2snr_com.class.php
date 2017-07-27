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