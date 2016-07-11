<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/7/7
 * Time: 22:01
 */
include_once "../l1comvm/vmlayer.php";

class classTaskL2sdkNbiotIpm376
{
    //构造函数
    public function __construct()
    {

    }

    function func_l2sdk_ipm376_ul_frame_process($user)
    {
        $ipm376Obj = new classDbiL2sdkNbiotIpm376(); //初始化一个UI DB对象
        //L2解码

        //准备发给L2SNR进行数据存储

        //如果有必要，反馈链路L2帧


        $jsonencode = json_encode($ipm376Obj);
        return $jsonencode;
    }

    function func_l2sdk_ipm376_dl_frame_process($user)
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
    public function mfun_l2sdk_nbiot_ipm376_task_main_entry($parObj, $msgId, $msgName, $msg)
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
            $loggerObj->logger("MFUN_TASK_ID_L2SDK_NBIOT_IPM376", "mfun_l2sdk_nbiot_ipm376_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到L2SNR_IPM，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SDK_NBIOT_IPM376", "mfun_l2sdk_nbiot_ipm376_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        //判定是UL还是DL来的消息
        if ($msgId == MSG_ID_L2SDK_NBIOT_IPM376_INCOMING){
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_l2sdk_ipm376_ul_frame_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
        }

        elseif($msgId == MSG_ID_L4NBIOTIPM_TO_NBIOT_IPM376_DL_REQUEST){
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_l2sdk_ipm376_dl_frame_process($user);
            $project = MFUN_PRJ_NB_IOT_IPM376;
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