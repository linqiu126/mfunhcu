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
        $log_time = date("Y-m-d H:i:s", time());

        //初始化消息内容
        $project= "";
        $log_from = "";
        $devCode="";
        $statCode = "";
        $content="";

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SENSOR_COMMON", "mfun_l2snr_common_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        else{
            //解开消息
            if (isset($msg["project"])) $project = $msg["project"];
            if (isset($msg["log_from"])) $log_from = $msg["log_from"];
            if (isset($msg["devCode"])) $devCode = $msg["devCode"];
            if (isset($msg["statCode"])) $statCode = $msg["statCode"];
            if (isset($msg["content"])) $content = $msg["content"];
        }

        switch($msgId)
        {
            case HUITP_MSGID_uni_alarm_info_report:
                $dbiL2snrCommonObj = new classDbiL2snrCommon();
                $respHuitpMsg = $dbiL2snrCommonObj->dbi_huitp_xmlmsg_alarm_info_report($devCode, $statCode, $content);
                //组装返回消息 HUITP_MSGID_uni_alarm_info_confirm, 并发送给L2 ENCODE进行编码发送
                if (!empty($respHuitpMsg)){
                    $msg = array("project" => $project,
                        "platform" => MFUN_TECH_PLTF_HCUGX_HUITP,
                        "devCode" => $devCode,
                        "respMsg" => HUITP_MSGID_uni_alarm_info_confirm,
                        "content" => $respHuitpMsg);
                    if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SENSOR_COMMON,
                            MFUN_TASK_ID_L2ENCODE_HUITP,
                            MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING,
                            "MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING",
                            $msg) == false) $resp = "Send to message buffer error";
                    else $resp = "";
                }
                break;
            case HUITP_MSGID_uni_performance_info_report:
                $dbiL2snrCommonObj = new classDbiL2snrCommon();
                $respHuitpMsg = $dbiL2snrCommonObj->dbi_huitp_xmlmsg_performance_info_report($devCode, $statCode, $content);
                //组装返回消息 HUITP_MSGID_uni_performance_info_confirm, 并发送给L2 ENCODE进行编码发送
                if (!empty($respHuitpMsg)){
                    $msg = array("project" => $project,
                        "platform" => MFUN_TECH_PLTF_HCUGX_HUITP,
                        "devCode" => $devCode,
                        "respMsg" => HUITP_MSGID_uni_performance_info_confirm,
                        "content" => $respHuitpMsg);
                    if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SENSOR_COMMON,
                            MFUN_TASK_ID_L2ENCODE_HUITP,
                            MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING,
                            "MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING",
                            $msg) == false) $resp = "Send to message buffer error";
                    else $resp = "";
                }
                break;
            case HUITP_MSGID_uni_inventory_report:
                $dbiL2snrCommonObj = new classDbiL2snrCommon();
                $respHuitpMsg = $dbiL2snrCommonObj->dbi_huitp_xmlmsg_inventory_report($devCode, $statCode, $content);

                //组装返回消息 HUITP_MSGID_uni_inventory_confirm, 并发送给L2 ENCODE进行编码发送
                if (!empty($respHuitpMsg)){
                    $msg = array("project" => $project,
                        "platform" => MFUN_TECH_PLTF_HCUGX_HUITP,
                        "devCode" => $devCode,
                        "respMsg" => HUITP_MSGID_uni_inventory_confirm,
                        "content" => $respHuitpMsg);
                    if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SENSOR_COMMON,
                            MFUN_TASK_ID_L2ENCODE_HUITP,
                            MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING,
                            "MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING",
                            $msg) == false) $resp = "Send to message buffer error";
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
                        "platform" => MFUN_TECH_PLTF_HCUGX_HUITP,
                        "devCode" => $devCode,
                        "respMsg" => HUITP_MSGID_uni_sw_package_confirm,
                        "content" => $respHuitpMsg);
                    if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SENSOR_COMMON,
                            MFUN_TASK_ID_L2ENCODE_HUITP,
                            MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING,
                            "MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING",
                            $msg) == false
                    ) $resp = "Send to message buffer error";
                    else $resp = "";
                }
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