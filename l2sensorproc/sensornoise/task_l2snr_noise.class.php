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

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2snr_noise_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //赋初值
        $project= "";
        $platform ="";
        $devCode="";
        $statCode = "";
        $content="";

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_NOISE", "mfun_l2snr_noise_task_main_entry", $log_time, $log_content);
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
        }
        //多条消息发送到NOISE模块
        if ($msgId != HUITP_MSGID_uni_noise_data_report){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_NOISE", "mfun_l2snr_noise_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        if ($msgId == HUITP_MSGID_uni_noise_data_report)
        {
            $dbiL2snrNoiseObj = new classDbiL2snrNoise();
            $dbiL2snrNoiseObj->dbi_huitp_msg_uni_noise_data_report($devCode, $statCode, $content);

            //暂时HUITP_MSGID_uni_noise_data_confirm没有处理
            $resp ="";
        }
        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, $devCode, $log_time, $log_content);
            echo trim($resp);
        }

        //返回
        return true;
    }


}

?>
