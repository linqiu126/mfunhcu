<?php
/**
* Created by PhpStorm.
* User: zehongli
* Date: 2017/2/26
* Time: 23:09
*/
include_once "../l1comvm/vmlayer.php";
include_once "../l2sdk/dbi_l2sdk_iot_huitp.class.php";

//HCU硬件设备级 Layer 2 SDK
//TASK_ID = MFUN_TASK_ID_L2SDK_IOT_STDXML
class classTaskL2sdkIotHuitp
{
    //构造函数
    public function __construct()
    {

    }

    /*****************************************************************************************************************
    *                                                任务入口函数                                                     *
    *****************************************************************************************************************/
    //HUITP XML或者HUITP JSON协议消息处理函数的主入口
    public function mfun_l2sdk_iot_huitp_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());
        $project = MFUN_PRJ_HCU_HUITP;

        //入口消息内容判断
        if (empty($msg) == true) {
            $log_content = "IOT_HUITP:received null message body";
            $loggerObj->logger($project, "mfun_l2sdk_iot_huitp_task_main_entry", $log_time, $log_content);
            echo trim($log_content); //这里echo主要是为了swoole log打印，帮助查找问题
            return false;
        }
        //这里HUITP消息有两个来源，一个是来自CCL通过socket收到的MSG_ID_L1VM_TO_L2SDK_IOT_HUITP_INCOMING，
        //另外一个是扬尘HCU通过curl收到的(MSG_ID_L2SDK_WECHAT_TO_L2DECODE_HUITP)，因为curl复用了cloud_callback_wechat,所以消息通过L2SDK_IOT_WX直接发给了L2CODEC,没有经由本模块
        if (($msgId != MSG_ID_L1VM_TO_L2SDK_IOT_HUITP_INCOMING) || ($msgName != "MSG_ID_L1VM_TO_L2SDK_IOT_HUITP_INCOMING") ){
            $log_content = "P:MsgId or MsgName error";
            $loggerObj->logger($project, "mfun_l2sdk_iot_huitp_task_main_entry", $log_time, $log_content);
            return false;
        }

        if (isset($msg["socketid"])) $socketid = $msg["socketid"]; else  $socketid = "";
        if (isset($msg["data"])) $data = $msg["data"]; else  $data = "";

        //FHYS测试时发现有多条xml消息粘连在一起的情况，此处加保护保证只取第一条完整xml消息
        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        $msg = $dbiL1vmCommonObj->getStrBetween($data,"<xml>","</xml>");
        if(empty($msg)){
            $log_content = "IOT_HUITP:received XML message format error";
            $loggerObj->logger($project, "mfun_l2sdk_iot_huitp_task_main_entry", $log_time, $log_content);
            echo trim($log_content); //这里echo主要是为了swoole log打印，帮助查找问题
            return false;
        }

        $msg = "<" . $msg . "</xml>";
        libxml_disable_entity_loader(true);  //prevent XML entity injection
        $postObj = simplexml_load_string($msg, 'SimpleXMLElement');  //防止破坏CDATA的内容，进而影响智能硬件L3消息体
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


        //消息或者说帧类型分离，l2SDK只进行协议类型解码，不对消息的content进行处理，判断协议类型后发送给专门的l2codec任务处理
        switch ($msgType)
        {
            //case "huitp_text"://HUITP消息处理
            case "huitp_text"://HUITP消息处理
                $log_from = $fromUser;

                //取DB中的硬件信息，判断基本信息
                $dbiL2sdkIotcomObj = new classDbiL2sdkIotcom();
                $statCode = $dbiL2sdkIotcomObj->dbi_hcuDevice_valid_device($fromUser); //FromUserName对应每个HCU硬件的设备编号
                if (empty($statCode)){
                    $log_content = "IOT_STDXML: invalid FromUserName = ".$fromUser;
                    $loggerObj->logger($project, $log_from, $log_time, $log_content);
                    echo trim($log_content); //这里echo主要是为了swoole log打印，帮助查找问题
                    return true;
                }

                //将socket id和设备ID（fromUser）进行绑定
                if(!empty($socketid) AND !empty($statCode)){
                    $dbiL2sdkIotcomObj = new classDbiL2sdkIotcom();
                    $dbiL2sdkIotcomObj->dbi_huitp_huc_socketid_update($fromUser, $socketid);
                }

                //收到非本消息体该收到的消息
                if ($toUser != MFUN_CLOUD_HCU ){
                    $log_content = "IOT_STDXML: invalid ToUserName = ".$toUser;
                    $loggerObj->logger($project, $log_from, $log_time, $log_content);
                    echo trim($log_content); //这里echo主要是为了swoole log打印，帮助查找问题
                    return true;
                }
                $msg = array("project" => $project,
                            "platform" => MFUN_TECH_PLTF_HCUGX_HUITP,
                            "devCode" => $fromUser,
                            "statCode" => $statCode,
                            "content" => $content,
                            "funcFlag" => $funcFlag);
                if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_IOT_HUITP,
                        MFUN_TASK_ID_L2DECODE_HUITP,
                        MSG_ID_L2SDK_IOT_HUITP_TO_L2DECODE_HUITP,
                        "MSG_ID_L2SDK_IOT_HUITP_TO_L2DECODE_HUITP",
                        $msg) == false) $resp = "Send to message buffer error";
                else $resp = "";
                break;

            default:
                $log_content = "IOT_HUITP:unknown message type = " . $msgType;
                $loggerObj->logger($project, $fromUser, $log_time, $log_content);
                echo trim($log_content); //这里echo主要是为了swoole log打印，帮助查找问题
                break;
        }

        //处理结果
        //由于消息的分布发送到各个任务模块中去了，这里不再统一处理ECHO返回，而由各个任务模块单独完成
        if (!empty($resp)) {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, $fromUser, $log_time, $log_content);
        }

        //结束，返回
        return true;
    }//End of 任务入口函数





}

?>