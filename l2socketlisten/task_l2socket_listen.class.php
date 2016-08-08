<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/7/4
 * Time: 21:46
 */
include_once "../l1comvm/vmlayer.php";

class classTaskL2SocketListen
{
    //构造函数
    public function __construct()
    {

    }

    function func_ftp_video_process($serv, $fd, $fromid, $data)
    {
        return "";
    }
    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2socket_listen_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SOCKET_LISTEN", "mfun_l2socket_listen_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到L2SOCKET_LISTEN，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SOCKET_LISTEN", "mfun_l2socket_listen_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        if ($msgId == MSG_ID_L2SOCKET_LISTEN_DATA_COMING)
        {
            //解开消息
            if (isset($msg["serv"])) $serv = $msg["serv"]; else  $serv = "";
            if (isset($msg["fd"])) $fd = $msg["fd"]; else  $fd = "";
            if (isset($msg["fromid"])) $fromid = $msg["fromid"]; else  $fromid = "";
            if (isset($msg["data"])) $data = $msg["data"]; else  $data = "";
            //具体处理函数
            $this->func_ftp_video_process($serv, $fd, $fromid, $data);
        }

        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger("L2SOCKETLISTEN", "MFUN_TASK_ID_L2SOCKET_LISTEN", $log_time, $log_content);
            echo trim($resp);
        }

        //返回
        return true;

    }

}//End of class_task_service
