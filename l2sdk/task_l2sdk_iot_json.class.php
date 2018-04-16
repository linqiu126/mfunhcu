<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/23
 * Time: 10:22
 */

include_once "../l1comvm/vmlayer.php";

class classTaskL2sdkIotJson
{
    /*****************************************************************************************************************
     *                                                任务入口函数                                                     *
     *****************************************************************************************************************/
    //HUITP JSON协议消息处理函数的主入口
    public function mfun_l2sdk_iot_json_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        $loggerObj = new classApiL1vmFuncCom();
        $project = MFUN_PRJ_HCU_JSON;
        if (empty($msg)) {
            $log_content = "E: IOT_JSON received null message body";
            $loggerObj->mylog($project,"NULL","MFUN_TASK_VID_L1VM_SWOOLE","MFUN_TASK_ID_L2SDK_IOT_JSON",$msgName,$log_content);
            echo trim($log_content); //这里echo主要是为了swoole log打印，帮助查找问题
            return false;
        }
        if (($msgId != MSG_ID_L1VM_TO_L2SDK_IOT_JSON_INCOMING) || ($msgName != "MSG_ID_L1VM_TO_L2SDK_IOT_JSON_INCOMING")){
            $log_content = "E: IOT_JSON receive Msgid or MsgName error";
            $loggerObj->mylog($project,"NULL","MFUN_TASK_VID_L1VM_SWOOLE","MFUN_TASK_ID_L2SDK_IOT_JSON",$msgName,$log_content);
            return false;
        }

        if (isset($msg["socketid"])) $socketid = $msg["socketid"]; else  $socketid = "";
        if (isset($msg["data"])) $data = $msg["data"]; else  $data = "";

        //这里可能收到HTTP header内容，json解码为空，直接返回
        $jsonData = json_decode($data);
        if (empty($jsonData)) return false;

        $toUser = strtoupper(trim($jsonData->ToUsr));
        $fromUser = strtoupper(trim($jsonData->FrUsr));
        $createTime = intval($jsonData->CrTim);
        $msgType = trim($jsonData->MsgTp);
        $jsonMsgId = intval($jsonData->MsgId);
        $msgLen = intval($jsonData->MsgLn);
        $ieCnt = $jsonData->IeCnt;
        $ieContent = array("rfidUser"=>$ieCnt->rfidUser, "spsValue"=>$ieCnt->spsValue);

        $funcFlag = trim($jsonData->FnFlg);

        //取DB中的硬件信息，判断FromUser合法性
        $dbiL2sdkIotcomObj = new classDbiL2sdkIotcom();
        $statCode = $dbiL2sdkIotcomObj->dbi_hcuDevice_valid_device($fromUser); //FromUserName对应每个HCU硬件的设备编号
        if (empty($statCode)){
            $log_content = "E: IOT_JSON receive invalid FromUserName = ".$fromUser;
            $loggerObj->mylog($project,$fromUser,"MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L2SDK_IOT_JSON",$msgName,$log_content);
            echo trim($log_content); //这里echo主要是为了swoole log打印，帮助查找问题
            return true;
        }
        //判断ToUser合法性
        if ($toUser != "XHZN" ){
            $log_content = "E: IOT_JSON receive invalid ToUserName = ".$toUser;
            $loggerObj->mylog($project,$fromUser,"MFUN_TASK_ID_L1VM","MFUN_TASK_ID_L2SDK_IOT_JSON",$msgName,$log_content);
            echo trim($log_content); //这里echo主要是为了swoole log打印，帮助查找问题
            return true;
        }

        //将socket id和设备ID（fromUser）进行绑定
        if(!empty($socketid) AND !empty($statCode)){
            $dbiL2sdkIotcomObj = new classDbiL2sdkIotcom();
            $result = $dbiL2sdkIotcomObj->dbi_huitp_huc_socketid_update($fromUser, $socketid);
        }

        $l2codecHuitpMsgDictObj = new classL2codecHuitpMsgDict();
        $jsonDestId = $l2codecHuitpMsgDictObj->mfun_l2codec_getHuitpDestTaskId($jsonMsgId);
        $respArray = $l2codecHuitpMsgDictObj->mfun_l2codec_getHuitpIeArray($jsonMsgId);
        if (isset($respArray['MSGNAME'])) $jsonMsgName = $respArray['MSGNAME']; else  $jsonMsgName = "";

        switch ($msgType) {
            case "huitp-json":
                $msg = array("project" => $project,
                    "devCode" => $fromUser,
                    "statCode" => $statCode,
                    "jsonMsgId" => $jsonMsgId,
                    "content" => $ieContent,
                    "funcFlag" => $funcFlag);
                if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_IOT_JSON,
                        $jsonDestId,
                        $jsonMsgId,
                        $jsonMsgName,
                        $msg) == false)$resp = "E: send to message buffer error";
                else $resp = "";
                break;
            default:
                $resp = "E:IOT_JSON received unknown message type = " . $msgType;
                break;
        }

        //处理结果
        //由于消息的分布发送到各个任务模块中去了，这里不再统一处理ECHO返回，而由各个任务模块单独完成
        if (!empty($resp)) {
            $log_content = json_encode($resp,JSON_UNESCAPED_UNICODE);
            $loggerObj->mylog($project,$fromUser,"MFUN_TASK_ID_L2SDK_IOT_JSON","NULL",$msgName,$log_content);
            echo trim($log_content); //这里echo主要是为了swoole log打印，帮助查找问题
        }

        //结束，返回
        return true;
    }
}

?>