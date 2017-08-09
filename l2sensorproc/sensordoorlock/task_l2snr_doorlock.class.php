<?php
/**
 * Created by PhpStorm.
 * User: zehongl
 * Date: 2016/11/7
 * Time: 21:36
 */


include_once "dbi_l2snr_doorlock.class.php";

class classTaskL2snrDoorlock
{
    //构造函数
    public function __construct()
    {

    }

    private function func_fhys_doorlock_status_process($platform, $devCode, $statCode, $content, $funcFlag)
    {
        $raw_MsgHead = substr($content, 0, MFUN_HCU_MSG_HEAD_LENGTH-2);  //截取4Byte MsgHead
        $msgHead = unpack("A2Key/A2Len", $raw_MsgHead);
        $length = hexdec($msgHead['Len']) & 0xFF;
        $length =  ($length+2) * 2; //因为收到的消息为16进制字符，消息总长度等于length＋1B控制字＋1B长度本身
        if ($length != strlen($content)) {
            return "ERROR FHYS_DOORCLOCK: message length invalid";  //消息长度不合法，直接返回
        }
        $data = substr($content, MFUN_HCU_MSG_HEAD_LENGTH-2, $length);
        $classDbiL2snrDoorlock = new classDbiL2snrDoorlock();
        $resp = $classDbiL2snrDoorlock->dbi_fhys_doorlock_status_process($devCode, $statCode, $data);

        return $resp;
    }

    private function func_fhys_doorlock_open_process($platform, $devCode, $statCode, $content, $funcFlag)
    {
        $raw_MsgHead = substr($content, 0, MFUN_HCU_MSG_HEAD_LENGTH-2);  //截取4Byte MsgHead
        $msgHead = unpack("A2Key/A2Len", $raw_MsgHead);
        $length = hexdec($msgHead['Len']) & 0xFF;
        $length =  ($length+2) * 2; //因为收到的消息为16进制字符，消息总长度等于length＋1B控制字＋1B长度本身
        if ($length != strlen($content)) {
            return "ERROR FHYS_DOORCLOCK: message length invalid";  //消息长度不合法，直接返回
        }
        $data = substr($content, MFUN_HCU_MSG_HEAD_LENGTH-2, $length);
        $classDbiL2snrDoorlock = new classDbiL2snrDoorlock();
        $resp = $classDbiL2snrDoorlock->dbi_fhys_doorlock_open_process($devCode, $statCode, $data);

        return $resp;
    }


    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2snr_doorlock_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //初始化消息内容
        $project = "";
        $platform = "";
        $devCode = "";
        $statCode = "";
        $content = "";
        $funcFlag = "";

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_DOORLOCK", "mfun_l2snr_doorlocktask_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        else{
            //解开消息
            if (isset($msg["project"])) $project = $msg["project"];
            if (isset($msg["platform"])) $platform = $msg["platform"];
            if (isset($msg["devCode"])) $devCode = $msg["devCode"];
            if (isset($msg["statCode"])) $statCode = $msg["statCode"];
            if (isset($msg["content"])) $content = $msg["content"];
            if (isset($msg["funcFlag"])) $funcFlag = $msg["funcFlag"];
        }

        if (($msgId != MSG_ID_L2SDK_HCU_TO_L2SNR_DOORLOCK) || ($msgName != "MSG_ID_L2SDK_HCU_TO_L2SNR_DOORLOCK")){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_DOORLOCK", "mfun_l2snr_doorlock_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        switch($msgId)
        {
            case MSG_ID_L2SDK_HCU_TO_L2SNR_DOORLOCK:
                //具体处理函数
                $key = unpack('A2Cmd/A2Opt', $content);
                $cmdKey = hexdec($key['Cmd'])& 0xFF;
                if($cmdKey == MFUN_HCU_CMDID_FHYS_DOORLOCK_STATUS)
                    $resp = $this->func_fhys_doorlock_status_process($platform, $devCode, $statCode, $content, $funcFlag);
                elseif($cmdKey == MFUN_HCU_CMDID_FHYS_DOORLOCK_OPEN)
                    $resp = $this->func_fhys_doorlock_open_process($platform, $devCode, $statCode, $content, $funcFlag);
                else
                    $resp = ""; //啥都不ECHO

                break;
            default:
                $resp = ""; //啥都不ECHO
                break;
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, $devCode, $log_time, $log_content);
        }

        //返回
        return true;
    }

}//End of class_task_service

?>