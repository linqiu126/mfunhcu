<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2015/12/13
 * Time: 12:23
 */
//include_once "../../l1comvm/vmlayer.php";
header("Content-type:text/html;charset=utf-8");
include_once "dbi_l2snr_pm25.class.php";


class classTaskL2snrPm25
{

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2snr_pm25_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project= MFUN_PRJ_HCU_HUITP;

        //入口消息内容判断
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog($project,"NULL","MFUN_TASK_ID_L2DECODE_HUITP","MFUN_TASK_ID_L2SENSOR_PM25",$msgName,$log_content);
            return false;
        }
        else{
            //解开消息
            if (isset($msg["project"])) $project = $msg["project"]; else $project= "";;
            if (isset($msg["devCode"])) $devCode = $msg["devCode"]; else $devCode="";
            if (isset($msg["statCode"])) $statCode = $msg["statCode"]; else $statCode = "";
            if (isset($msg["content"])) $content = $msg["content"]; else $content="";
        }

        switch($msgId)
        {
            case HUITP_MSGID_uni_pm25_data_report:
                $dbiL2snrPm25Obj = new classDbiL2snrPm25();
                $respHuitpMsg = $dbiL2snrPm25Obj->dbi_huitp_msg_uni_pm25_data_report($devCode, $statCode, $content);

                //发送HUITP_MSGID_uni_pm25_data_confirm
                if (!empty($respHuitpMsg)) {
                    $msg = array("project" => $project,
                        "devCode" => $devCode,
                        "respMsg" => HUITP_MSGID_uni_pm25_data_confirm,
                        "content" => $respHuitpMsg);
                    if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SENSOR_PM25,
                            MFUN_TASK_ID_L2ENCODE_HUITP,
                            MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING,
                            "MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING",
                            $msg) == false
                    ) $resp = "E: send to message buffer error";
                    else $resp = "";
                }
                break;
            case HUITP_MSGID_uni_ycjk_data_report:
                $dbiL2snrPm25Obj = new classDbiL2snrPm25();
                $respHuitpMsg = $dbiL2snrPm25Obj->dbi_huitp_msg_uni_ycjk_data_report($devCode, $statCode, $content);

                //发送HUITP_MSGID_uni_ycjk_data_confirm
                if (!empty($respHuitpMsg)) {
                    $msg = array("project" => $project,
                        "devCode" => $devCode,
                        "respMsg" => HUITP_MSGID_uni_ycjk_data_confirm,
                        "content" => $respHuitpMsg);
                    if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SENSOR_PM25,
                            MFUN_TASK_ID_L2ENCODE_HUITP,
                            MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING,
                            "MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING",
                            $msg) == false
                    ) $resp = "E: send to message buffer error";
                    else $resp = "";
                }
                break;
            default:
                $resp ="E: received invalid MSGID!";
                break;
        }

        if (!empty($resp)) {
            $log_content = json_encode($resp,JSON_UNESCAPED_UNICODE);
            $loggerObj->mylog($project,$devCode,"MFUN_TASK_ID_L2SENSOR_PM25","MFUN_TASK_ID_L2ENCODE_HUITP",$msgName,$log_content);
        }

        //返回
        return true;
    }

}//End of class_pmData_service

?>