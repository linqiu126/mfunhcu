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

    public function func_doorlock_data_process($platform, $deviceId, $statCode, $content)
    {
        $raw_MsgHead = substr($content, 0, MFUN_HCU_MSG_HEAD_LENGTH);  //截取6Byte MsgHead
        $msgHead = unpack(MFUN_HCU_MSG_HEAD_FORMAT, $raw_MsgHead);

        $length = hexdec($msgHead['Len']) & 0xFF;
        $length =  ($length+2) * 2; //因为收到的消息为16进制字符，消息总长度等于length＋1B控制字＋1B长度本身
        if ($length != strlen($content)) {
            return "ERROR FHYS_DOORCLOCK: message length invalid";  //消息长度不合法，直接返回
        }

        $opt_key = hexdec($msgHead['Cmd']) & 0xFF;

        if ($opt_key == MFUN_HCU_OPT_FHYS_LOCKOPEN_REQ){
            $uiF4icmDbObj = new classDbiL2snrDoorlock();
            $resp = $uiF4icmDbObj->dbi_hcu_lock_open("", $statCode);
        }

        return $resp;
    }
    //H5 UI命令处理函数
    function func_hcu_lock_status_process($uid, $StatCode)
    {
        $uiF4icmDbObj = new classDbiL2snrDoorlock();
        $resp = $uiF4icmDbObj->dbi_hcu_lock_status($uid, $StatCode);
        if (!empty($resp))
            $retval=array(
                'status'=>'true',
                'msg'=>$resp
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>null
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    //HCU_Lock_Open
    function func_hcu_lock_open_process($uid, $StatCode)
    {
        $uiF4icmDbObj = new classDbiL2snrDoorlock();
        $resp = $uiF4icmDbObj->dbi_hcu_lock_open($uid, $StatCode);
        if (!empty($resp))
            $retval=array(
                'status'=>'true',
                'msg'=>$resp
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>null
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }


    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2snr_doorlock_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_DOORLOCK", "mfun_l2snr_doorlocktask_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        if (($msgId != MSG_ID_L2SDK_HCU_TO_L2SNR_DOORLOCK) || ($msgName != "MSG_ID_L2SDK_HCU_TO_L2SNR_DOORLOCK")){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_DOORLOCK", "mfun_l2snr_doorlock_task_main_entry", $log_time, $log_content);
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


        if ($msgId == MSG_ID_L2SDK_HCU_TO_L2SNR_DOORLOCK) {
            //解开消息
            if (isset($msg["project"])) $project = $msg["project"];
            if (isset($msg["log_from"])) $log_from = $msg["log_from"];
            if (isset($msg["platform"])) $platform = $msg["platform"];
            if (isset($msg["deviceId"])) $deviceId = $msg["deviceId"];
            if (isset($msg["statCode"])) $statCode = $msg["statCode"];
            if (isset($msg["content"])) $content = $msg["content"];
            //具体处理函数
            $resp = $this->func_doorlock_data_process($platform, $deviceId, $statCode, $content);
        }

        //功能HCU_Lock_Status
        elseif ($msgId == MSG_ID_L4FHYSUI_TO_L3F4_HCULOCKSTATUS)
        {
            //解开消息
            if (isset($_GET["id"])) $uid = trim($_GET["id"]); else  $uid = "";
            if (isset($_GET["StatCode"])) $StatCode = trim($_GET["StatCode"]); else  $StatCode= "";
            $input = array("uid" => $uid, "StatCode" => $StatCode);
            //具体处理函数
            $resp = $this->func_hcu_lock_status_process($uid, $StatCode);
            $project = MFUN_PRJ_HCU_FHYSUI;
        }
        //功能HCU_Lock_Open
        elseif ($msgId == MSG_ID_L4FHYSUI_TO_L3F4_HCULOCKOPEN)
        {
            //解开消息
            if (isset($_GET["id"])) $uid = trim($_GET["id"]); else  $uid = "";
            if (isset($_GET["StatCode"])) $StatCode = trim($_GET["StatCode"]); else  $StatCode= "";
            $input = array("uid" => $uid, "StatCode" => $StatCode);
            //具体处理函数
            $resp = $this->func_hcu_lock_open_process($uid, $StatCode);
            $project = MFUN_PRJ_HCU_FHYSUI;
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

}//End of class_task_service

?>