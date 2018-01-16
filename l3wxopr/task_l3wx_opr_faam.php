<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/12
 * Time: 17:40
 */
include_once "../l1comvm/vmlayer.php";
include_once "dbi_l3wx_opr_faam.php";

class classTaskL3wxOprFaam
{

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l3wx_opr_faam_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project = MFUN_PRJ_HCU_FAAMWX;

        //入口消息内容判断
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog($project,"NULL","MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L3WX_OPR_FAAM",$msgName,$log_content);
            return false;
        }

        if ($msgId == MSG_ID_L1VM_TO_L3WXL3WXOPR_FAAM_XCXPOST){  //来自微信小程序的消息
            $msg = json_decode($msg,true);
            //解开消息
            if (isset($msg["codeType"])) $codeType = trim($msg["codeType"]); else $codeType = "";
            if (isset($msg["scanCode"])) $scanCode = trim($msg["scanCode"]); else $scanCode = "";
            if (isset($msg["latitude"])) $latitude = $msg["latitude"]; else $latitude = 0;
            if (isset($msg["longitude"])) $longitude = $msg["longitude"]; else $longitude = 0;
            if (isset($msg["nickName"])) $nickName = trim($msg["nickName"]); else $nickName = "";

            if (isset($msg["phone"])) $phone = trim($msg["phone"]); else $phone = ""; ///////////////////////////////////////////joe modify///////////////////////////////////

            $l3wxOprFaamDbObj = new classDbiL3wxOprFaam(); //初始化一个UI DB对象
            switch($codeType) {
                case "QRCODE_KQ":  //考勤二维码
                    $resp = $l3wxOprFaamDbObj->dbi_faam_qrcode_kq_process($scanCode,$latitude,$longitude,$nickName,$phone); ///////////////////////////////////////////joe modify///////////////////////////////////
                    break;

                case "QRCODE_SC":  //生产二维码
                    $resp = $l3wxOprFaamDbObj->dbi_faam_qrcode_sc_process($scanCode,$latitude,$longitude,$nickName);
                    break;

                case "QRCODE_SH":  //收货二维码
                    $resp = $l3wxOprFaamDbObj->dbi_faam_qrcode_sh_process();
                    break;

                default:
                    $resp = "";
                    break;
            }

            //这里需要将response返回给微信小程序界面
            if (!empty($resp)) {
                $loggerObj = new classApiL1vmFuncCom();
                $jsonencode = json_encode($resp, JSON_UNESCAPED_UNICODE);
                $log_content = "T:" . $jsonencode;
                $loggerObj->mylog(MFUN_PRJ_HCU_FAAMWX,$nickName,"MFUN_TASK_ID_L3APPL_FUM11FAAM","NULL","NULL",$log_content);
                echo $jsonencode;
            }
            //返回
            return true;
        }
        //来自工厂打印设备的Socket消息（HUITP）
        else {
            //解开消息
            if (isset($msg["project"])) $project = $msg["project"]; else $project= "";;
            if (isset($msg["devCode"])) $devCode = $msg["devCode"]; else $devCode="";
            if (isset($msg["statCode"])) $statCode = $msg["statCode"]; else $statCode = "";
            if (isset($msg["content"])) $content = $msg["content"]; else $content="";

            switch($msgId) {
                case HUITP_MSGID_uni_equlable_apply_report:
                    $dbiL3wxoprFaamObj = new classDbiL3wxOprFaam();
                    $respHuitpMsg = $dbiL3wxoprFaamObj->dbi_huitp_xmlmsg_equlable_apply_report($devCode, $statCode, $content);
                    //组装返回消息 HUITP_MSGID_uni_equlable_apply_confirm, 并发送给L2 ENCODE进行编码发送
                    if (!empty($respHuitpMsg)) {
                        $msg = array("project" => $project,
                            "devCode" => $devCode,
                            "respMsg" => HUITP_MSGID_uni_equlable_apply_confirm,
                            "content" => $respHuitpMsg);
                        if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L3WX_OPR_FAAM,
                                MFUN_TASK_ID_L2ENCODE_HUITP,
                                MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING,
                                "MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING",
                                $msg) == false
                        ) $resp = "E: send to message buffer error";
                        else $resp = "";
                    }
                    break;
                case HUITP_MSGID_uni_equlable_userlist_sync_report:
                    $dbiL3wxoprFaamObj = new classDbiL3wxOprFaam();
                    $respHuitpMsg = $dbiL3wxoprFaamObj->dbi_huitp_xmlmsg_equlable_userlist_sync_report($devCode, $statCode, $content);
                    //组装返回消息 HUITP_MSGID_uni_equlable_userlist_sync_confirm, 并发送给L2 ENCODE进行编码发送
                    if (!empty($respHuitpMsg)) {
                        $msg = array("project" => $project,
                            "devCode" => $devCode,
                            "respMsg" => HUITP_MSGID_uni_equlable_userlist_sync_confirm,
                            "content" => $respHuitpMsg);
                        if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L3WX_OPR_FAAM,
                                MFUN_TASK_ID_L2ENCODE_HUITP,
                                MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING,
                                "MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING",
                                $msg) == false
                        ) $resp = "E: send to message buffer error";
                        else $resp = "";
                    }
                    break;
                default:
                    break;
            }

            if (!empty($resp)){
                $log_content = json_encode($resp,JSON_UNESCAPED_UNICODE);
                $loggerObj->mylog($project,$devCode,"MFUN_TASK_ID_L3WX_OPR_FAAM","MFUN_TASK_ID_L2ENCODE_HUITP",$msgName,$log_content);
            }
            //返回
            return true;
        }
    }
}

?>