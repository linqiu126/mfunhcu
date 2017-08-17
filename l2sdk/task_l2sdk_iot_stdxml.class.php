<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2015/12/9
 * Time: 23:09
 */
include_once "../l1comvm/vmlayer.php";
include_once "../l2sdk/dbi_l2sdk_iot_com.class.php";

//HCU硬件设备级 Layer 2 SDK
//TASK_ID = MFUN_TASK_ID_L2SDK_IOT_STDXML
class classTaskL2sdkIotStdxml
{
    //构造函数
    public function __construct()
    {

    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    //错误的地方，是否需要采用exit过程，待定
    public function mfun_l2sdk_iot_stdxml_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project = MFUN_PRJ_HCU_STDXML;
        $log_time = date("Y-m-d H:i:s", time());

        //入口消息内容判断
        if (empty($msg) == true) {
            $loggerObj->logger("MFUN_TASK_ID_L2SDK_IOT_STDXML", "mfun_l2sdk_iot_stdxml_task_main_entry", $log_time, "R: Received null message body.");
            return false;
        }
        if (($msgId != MSG_ID_L1VM_TO_L2SDK_IOT_STDXML_INCOMING) || ($msgName != "MSG_ID_L1VM_TO_L2SDK_IOT_STDXML_INCOMING")){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SDK_IOT_STDXML", "mfun_l2sdk_iot_stdxml_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        if (isset($msg["socketid"])) $socketid = $msg["socketid"]; else  $socketid = "";
        if (isset($msg["data"])) $data = $msg["data"]; else  $data = "";

        //正式处理消息格式和消息内容的过程
        //FHYS测试时发现有多条xml消息粘连在一起的情况，此处加保护保证只取第一条完整xml消息
        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        $data = $dbiL1vmCommonObj->getStrBetween($data,"<xml>","</xml>");
        if(empty($data)){
            $loggerObj->logger("MFUN_TASK_ID_L2SDK_IOT_STDXML", "mfun_l2sdk_iot_stdxml_task_main_entry", $log_time, "R:Received XML message format error!");
            return false;
        }

        $xmlmsg = "<" . $data . "</xml>";
        libxml_disable_entity_loader(true);  //prevent XML entity injection
        $postObj = simplexml_load_string($xmlmsg, 'SimpleXMLElement');  //防止破坏CDATA的内容，进而影响智能硬件L3消息体
        //$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $textTpl = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                <FuncFlag>0</FuncFlag></xml>";

        //XML消息解码
        $toUser = trim($postObj->ToUserName);
        $fromUser = trim($postObj->FromUserName);
        $createTime = trim($postObj->CreateTime);
        $msgType = trim($postObj->MsgType);
        $content = trim($postObj->Content);
        $funcFlag = trim($postObj->FuncFlag);

        //对接收内容进行log记录
        $log_content = "R:" . trim($xmlmsg);
        $loggerObj->logger($project, $fromUser, $log_time, $log_content);

        //取DB中的硬件信息，判断FromUser合法性
        $dbiL2sdkIotcomObj = new classDbiL2sdkIotcom();
        $statCode = $dbiL2sdkIotcomObj->dbi_hcuDevice_valid_device($fromUser); //FromUserName对应每个HCU硬件的设备编号
        if (empty($statCode)){
            $result = "IOT_STDXML: invalid FromUserName = ".$fromUser;
            $log_content = "T:" . json_encode($result);
            $loggerObj->logger($project, $fromUser, $log_time, $log_content);
            return true;
        }

        //判断ToUser合法性
        if ($toUser != MFUN_CLOUD_HCU ){
            $result = "IOT_STDXML: invalid ToUserName = ".$toUser;
            $log_content = "T:" . json_encode($result);
            $loggerObj->logger($project, $toUser, $log_time, $log_content);
            echo trim($result);
            return true;
        }

        //将socket id和设备ID（fromUser）进行绑定
        if(!empty($socketid) AND !empty($statCode)){
            $dbiL2sdkIotcomObj = new classDbiL2sdkIotcom();
            $result = $dbiL2sdkIotcomObj->dbi_huitp_huc_socketid_update($fromUser, $socketid);
        }

        //消息或者说帧类型分离，l2SDK只进行XML类型解码，不对消息的content进行处理,Content处理在具体的L2sensor模块
        switch ($msgType) {
            case "hcu_text":
                $msg = array("project" => $project,
                    "platform" => MFUN_TECH_PLTF_HCUSTM,
                    "devCode" => $fromUser,
                    "statCode" => $statCode,
                    "content" => $content,
                    "funcFlag" => $funcFlag);
                if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_IOT_STDXML,
                        MFUN_TASK_ID_L2SENSOR_DOORLOCK,
                        MSG_ID_L2SDK_HCU_TO_L2SNR_DOORLOCK,
                        "MSG_ID_L2SDK_HCU_TO_L2SNR_DOORLOCK",
                        $msg) == false) $resp = "Send to message buffer error";
                else $resp = "";
                break;
            case "hcu_pic":
                $msg = array("project" => $project,
                    "platform" => MFUN_TECH_PLTF_HCUSTM,
                    "devCode" => $fromUser,
                    "statCode" => $statCode,
                    "content" => $content,
                    "funcFlag" => $funcFlag);
                if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_IOT_STDXML,
                        MFUN_TASK_ID_L2SENSOR_HSMMP,
                        MSG_ID_L2SDK_HCU_TO_L2SNR_HSMMP,
                        "MSG_ID_L2SDK_HCU_TO_L2SNR_HSMMP",
                        $msg) == false) $resp = "Send to message buffer error";
                else $resp = "";
                break;
            default:
                //收内容存储
                $resp = "[STDXML]unknown message type: " . $msgType;
                break;
        }

        //处理结果
        if (!empty($resp)) {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, $fromUser, $log_time, $log_content);
        }
        //结束，返回
        return true;
    }

}

?>