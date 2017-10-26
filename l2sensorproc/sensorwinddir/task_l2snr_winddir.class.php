<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2015/12/13
 * Time: 12:21
 */
//include_once "../../l1comvm/vmlayer.php";
include_once "dbi_l2snr_winddir.class.php";

class classTaskL2snrWinddir
{
    //构造函数
    public function __construct()
    {

    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2snr_winddir_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project= MFUN_PRJ_HCU_HUITP;

        //入口消息内容判断
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog($project,"NULL","MFUN_TASK_ID_L2DECODE_HUITP","MFUN_TASK_ID_L2SENSOR_WINDDIR",$msgName,$log_content);
            return false;
        }
        else{
            //解开消息
            if (isset($msg["project"])) $project = $msg["project"]; else $project= "";;
            if (isset($msg["devCode"])) $devCode = $msg["devCode"]; else $devCode="";
            if (isset($msg["statCode"])) $statCode = $msg["statCode"]; else $statCode = "";
            if (isset($msg["content"])) $content = $msg["content"]; else $content="";
        }

        if ($msgId == HUITP_MSGID_uni_winddir_data_report)
        {
            $dbiL2snrWinddirObj = new classDbiL2snrWinddir();
            $respHuitpMsg = $dbiL2snrWinddirObj->dbi_huitp_msg_uni_winddir_data_report($devCode, $statCode, $content);

            //发送HUITP_MSGID_uni_winddir_data_confirm
            if (!empty($respHuitpMsg)) {
                $msg = array("project" => $project,
                    "devCode" => $devCode,
                    "respMsg" => HUITP_MSGID_uni_winddir_data_confirm,
                    "content" => $respHuitpMsg);
                if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SENSOR_WINDDIR,
                        MFUN_TASK_ID_L2ENCODE_HUITP,
                        MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING,
                        "MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING",
                        $msg) == false
                ) $resp = "E: send to message buffer error";
                else $resp = "";
            }
        }
        else{
            $resp ="E: received invalid MSGID!";
        }

        if (!empty($resp)) {
            $log_content = json_encode($resp,JSON_UNESCAPED_UNICODE);
            $loggerObj->mylog($project,$devCode,"MFUN_TASK_ID_L2SENSOR_WINDDIR","MFUN_TASK_ID_L2ENCODE_HUITP",$msgName,$log_content);
        }

        //返回
        return true;
    }

}//End of class_windDirection_service

?>