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
//TASK_ID = MFUN_TASK_ID_L2SDK_IOT_HCU
class classTaskL2sdkIotHuitp
{
    //构造函数
    public function __construct()
    {

    }

    function getStrBetween($kw1,$mark1,$mark2)
    {
        $kw=$kw1;
        $kw='123'.$kw.'123';
        $st =stripos($kw,$mark1);
        $ed =stripos($kw,$mark2);
        if(($st==false||$ed==false)||$st>=$ed)
            return 0;
        $kw=substr($kw,($st+1),($ed-$st-1));
        return $kw;
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

        //入口消息内容判断
        if (empty($msg) == true) {
            $loggerObj->logger("MFUN_TASK_ID_L2SDK_IOT_HUITP", "mfun_l2sdk_iot_huitp_task_main_entry", $log_time, "R: Received null message body.");
            echo "";
            return false;
        }
        if (($msgId != MSG_ID_L1VM_TO_L2SDK_IOT_HUITP_INCOMING) || ($msgName != "MSG_ID_L1VM_TO_L2SDK_IOT_HUITP_INCOMING")){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SDK_IOT_HUITP", "mfun_l2sdk_iot_huitp_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        if (isset($msg["socketid"])) $socketid = $msg["socketid"]; else  $socketid = "";
        if (isset($msg["data"])) $data = $msg["data"]; else  $data = "";

        //FHYS测试时发现有多条xml消息粘连在一起的情况，此处加保护保证只取第一条完整xml消息
        $msg = $this->getStrBetween($data,"<xml>","</xml>");
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

        $log_time = date("Y-m-d H:i:s",$createTime);
        $log_content = "R:" . trim($msg);

        //消息或者说帧类型分离，l2SDK只进行协议类型解码，不对消息的content进行处理，判断协议类型后发送给专门的l2codec任务处理
        switch ($msgType)
        {
            //case "hcu_huitp"://HUITP消息处理
            case "huitp_text"://HUITP消息处理
                $project = MFUN_PRJ_HCU_XML;
                $log_from = $fromUser;
                //定义本入口函数的logger处理对象及函数
                $loggerObj = new classApiL1vmFuncCom();

                //取DB中的硬件信息，判断基本信息
                $l2sdkHcuDbObj = new classDbiL2sdkHcu();
                $result = $l2sdkHcuDbObj->dbi_hcuDevice_valid_device($fromUser); //FromUserName对应每个HCU硬件的设备编号
                if (empty($result)){
                    $result = "HCU_IOT: invalid device ID";
                    $log_content = "T:" . json_encode($result);
                    $loggerObj->logger($project, $log_from, $log_time, $log_content);
                    return true;
                }

                $statCode = $result;
                //将socket id和设备ID（fromUser）进行绑定
                if(!empty($socketid) AND !empty($statCode)){
                    $dbiL2sdkHuitpObj = new classDbiL2sdkHuitp();
                    $dbiL2sdkHuitpObj->dbi_huitp_huc_socketid_update($fromUser, $socketid);
                }

                //收到非本消息体该收到的消息
                if ($toUser != MFUN_CLOUD_HCU ){
                    $result = "HCU_IOT: FHYS XML message invalid ToUserName";
                    $log_content = "T:" . json_encode($result);
                    $loggerObj->logger($project, $log_from, $log_time, $log_content);
                    echo trim($result);
                    return true;
                }
                $msg = array("project" => $project,
                            "platform" => MFUN_TECH_PLTF_HCUSTM,
                            "devCode" => $fromUser,
                            "statCode" => $statCode,
                            "content" => $content,
                            "funcFlag" => $funcFlag);
                if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_IOT_HUITP,
                        MFUN_TASK_ID_L2CODEC_HUITP,
                        MSG_ID_L2SDK_IOT_HUITP_TO_L2CODEC_HUITP,
                        "MSG_ID_L2SDK_IOT_HUITP_TO_L2CODEC_HUITP",
                        $msg) == false) $resp = "Send to message buffer error";
                else $resp = "";
                break;

            default:
                //收内容存储
                $project = "NULL";
                $loggerObj->logger($project, $fromUser, $log_time, $log_content);
                $log_from = "CLOUD_NONE";
                $result = "[XML_FORMAT]unknown message type: " . $msgType;
                //差错返回
                $log_content = "T:" . json_encode($result);
                $loggerObj->logger($project, $log_from, $log_time, $log_content);
                echo trim($result);
                break;
        }


        //处理结果
        //由于消息的分布发送到各个任务模块中去了，这里不再统一处理ECHO返回，而由各个任务模块单独完成
        if (!empty($resp)) {
            $timestamp = time();
            $log_time = date("Y-m-d H:i:s", $timestamp);
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, $log_from, $log_time, $log_content);
            echo trim($resp);
        }

        //结束，返回
        return true;
    }//End of 任务入口函数





}

?>