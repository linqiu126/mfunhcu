<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2015/12/13
 * Time: 12:22
 */
//include_once "../../l1comvm/vmlayer.php";
include_once "dbi_l2snr_humid.class.php";

class classTaskL2snrHumid
{
    //构造函数
    public function __construct()
    {

    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2snr_humid_task_main_entry($parObj, $msgId, $msgName, $msg)
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
            $loggerObj->logger("MFUN_TASK_ID_L2SENSOR_HUMID", "mfun_l2snr_humid_task_main_entry", $log_time, $log_content);
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

        //具体处理函数
        if ($msgId == HUITP_MSGID_uni_humid_data_report){
            $dbiL2snrHumidObj = new classDbiL2snrHumid();
            $respHuitpMsg = $dbiL2snrHumidObj->dbi_huitp_msg_uni_humid_data_report($devCode, $statCode, $content);

            //发送HUITP_MSGID_uni_humid_data_confirm
            if (!empty($respHuitpMsg)) {
                $msg = array("project" => $project,
                    "platform" => MFUN_TECH_PLTF_HCUGX_HUITP,
                    "devCode" => $devCode,
                    "respMsg" => HUITP_MSGID_uni_humid_data_confirm,
                    "content" => $respHuitpMsg);
                if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SENSOR_HUMID,
                        MFUN_TASK_ID_L2ENCODE_HUITP,
                        MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING,
                        "MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING",
                        $msg) == false
                ) $resp = "Send to message buffer error";
                else $resp = "";
            }
        }
        else{
            $resp ="Received invalid MSGID!";
        }

        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, "mfun_l2snr_humid_task_main_entry", $log_time, $log_content);
        }

        //返回
        return true;
    }

}

?>