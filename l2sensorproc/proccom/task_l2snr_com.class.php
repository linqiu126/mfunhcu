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


    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2snr_common_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project= MFUN_PRJ_HCU_HUITP;

        //入口消息内容判断
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog($project,"NULL","MFUN_TASK_ID_L2DECODE_HUITP","MFUN_TASK_ID_L2SENSOR_COMMON",$msgName,$log_content);
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
            case HUITP_MSGID_uni_heart_beat_report:
                $dbiL2snrCommonObj = new classDbiL2snrCommon();
                $respHuitpMsg = $dbiL2snrCommonObj->dbi_huitp_xmlmsg_heart_beat_report($devCode, $statCode, $content);
                //组装返回消息 HUITP_MSGID_uni_heart_beat_confirm, 并发送给L2 ENCODE进行编码发送
                if (!empty($respHuitpMsg)){
                    $msg = array("project" => $project,
                        "devCode" => $devCode,
                        "respMsg" => HUITP_MSGID_uni_heart_beat_confirm,
                        "content" => $respHuitpMsg);
                    if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SENSOR_COMMON,
                            MFUN_TASK_ID_L2ENCODE_HUITP,
                            MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING,
                            "MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING",
                            $msg) == false) $resp = "E: send to message buffer error";
                    else $resp = "";
                }
                break;
            case HUITP_MSGID_uni_alarm_info_report:
                $dbiL2snrCommonObj = new classDbiL2snrCommon();
                $respHuitpMsg = $dbiL2snrCommonObj->dbi_huitp_xmlmsg_alarm_info_report($devCode, $statCode, $content);
                //组装返回消息 HUITP_MSGID_uni_alarm_info_confirm, 并发送给L2 ENCODE进行编码发送
                if (!empty($respHuitpMsg)){
                    $msg = array("project" => $project,
                        "devCode" => $devCode,
                        "respMsg" => HUITP_MSGID_uni_alarm_info_confirm,
                        "content" => $respHuitpMsg);
                    if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SENSOR_COMMON,
                            MFUN_TASK_ID_L2ENCODE_HUITP,
                            MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING,
                            "MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING",
                            $msg) == false) $resp = "E: send to message buffer error";
                    else $resp = "";
                }
                break;
            case HUITP_MSGID_uni_performance_info_report:
                $dbiL2snrCommonObj = new classDbiL2snrCommon();
                $respHuitpMsg = $dbiL2snrCommonObj->dbi_huitp_xmlmsg_performance_info_report($devCode, $statCode, $content);
                //组装返回消息 HUITP_MSGID_uni_performance_info_confirm, 并发送给L2 ENCODE进行编码发送
                if (!empty($respHuitpMsg)){
                    $msg = array("project" => $project,
                        "devCode" => $devCode,
                        "respMsg" => HUITP_MSGID_uni_performance_info_confirm,
                        "content" => $respHuitpMsg);
                    if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SENSOR_COMMON,
                            MFUN_TASK_ID_L2ENCODE_HUITP,
                            MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING,
                            "MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING",
                            $msg) == false) $resp = "E: send to message buffer error";
                    else $resp = "";
                }
                break;
            case HUITP_MSGID_uni_inventory_report:
                $dbiL2snrCommonObj = new classDbiL2snrCommon();
                $respHuitpMsg = $dbiL2snrCommonObj->dbi_huitp_xmlmsg_inventory_report($devCode, $statCode, $content);

                //组装返回消息 HUITP_MSGID_uni_inventory_confirm, 并发送给L2 ENCODE进行编码发送
                if (!empty($respHuitpMsg)){
                    $msg = array("project" => $project,
                        "devCode" => $devCode,
                        "respMsg" => HUITP_MSGID_uni_inventory_confirm,
                        "content" => $respHuitpMsg);
                    if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SENSOR_COMMON,
                            MFUN_TASK_ID_L2ENCODE_HUITP,
                            MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING,
                            "MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING",
                            $msg) == false) $resp = "E: send to message buffer error";
                    else $resp = "";
                }
                break;
            case HUITP_MSGID_uni_inventory_resp:
                $dbiL2snrCommonObj = new classDbiL2snrCommon();
                $respHuitpMsg = $dbiL2snrCommonObj->dbi_huitp_xmlmsg_inventory_resp($devCode, $statCode, $content);
                break;
            case HUITP_MSGID_uni_sw_package_resp:
                $dbiL2snrCommonObj = new classDbiL2snrCommon();
                $respHuitpMsg = $dbiL2snrCommonObj->dbi_huitp_xmlmsg_sw_package_resp($devCode, $statCode, $content);
                break;
            case HUITP_MSGID_uni_sw_package_report:
                $dbiL2snrCommonObj = new classDbiL2snrCommon();
                $respHuitpMsg = $dbiL2snrCommonObj->dbi_huitp_xmlmsg_sw_package_report($devCode, $statCode, $content);

                //组装返回消息 HUITP_MSGID_uni_sw_package_confirm, 并发送给L2 ENCODE进行编码发送
                if (!empty($respHuitpMsg)) {
                    $msg = array("project" => $project,
                        "devCode" => $devCode,
                        "respMsg" => HUITP_MSGID_uni_sw_package_confirm,
                        "content" => $respHuitpMsg);
                    if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SENSOR_COMMON,
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

        //返回ECHO
        if (!empty($resp)){
            $log_content = json_encode($resp,JSON_UNESCAPED_UNICODE);
            $loggerObj->mylog($project,$devCode,"MFUN_TASK_ID_L2SENSOR_COMMON","MFUN_TASK_ID_L2ENCODE_HUITP",$msgName,$log_content);
        }

        //返回
        return true;
    }
}

?>