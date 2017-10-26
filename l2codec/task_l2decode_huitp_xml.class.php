<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/25
 * Time: 15:02
 */

include_once "l2codec_huitp_msg_dict.php";

class classTaskL2decodeHuitpXml
{
    //构造函数
    public function __construct()
    {

    }

    public function mfun_l2decode_huitp_xml_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project = MFUN_PRJ_HCU_HUITP;

        //判断入口消息是否为空
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog($project,"NULL","MFUN_TASK_ID_L2SDK_IOT_HUITP","MFUN_TASK_ID_L2DECODE_HUITP",$msgName,$log_content);
            return false;
        }
        //这里HUITP消息有两个来源，一个是来自CCL通过socket收到的MSG_ID_L1VM_TO_L2SDK_IOT_HUITP_INCOMING，
        //另外一个是扬尘HCU通过curl收到的，因为curl复用了cloud_callback_wechat,所以消息来自L2SDK_IOT_WX (MSG_ID_L2SDK_WECHAT_TO_L2DECODE_HUITP)
        if (($msgId != MSG_ID_L2SDK_IOT_HUITP_TO_L2DECODE_HUITP) AND ($msgId != MSG_ID_L2SDK_WECHAT_TO_L2DECODE_HUITP)){
            $log_content = "E: receive MsgId or MsgName error";
            $loggerObj->mylog($project,"NULL","MFUN_TASK_ID_L2SDK_IOT_HUITP","MFUN_TASK_ID_L2DECODE_HUITP",$msgName,$log_content);
            return false;
        }
        else{ //解开消息
            if (isset($msg["project"])) $project = $msg["project"]; else  $project = "";
            if (isset($msg["devCode"])) $devCode = $msg["devCode"]; else  $devCode = "";
            if (isset($msg["statCode"])) $statCode = $msg["statCode"]; else  $statCode = "";
            if (isset($msg["content"])) $content = $msg["content"]; else  $content = "";
            if (isset($msg["funcFlag"])) $funcFlag = $msg["funcFlag"]; else  $funcFlag = "";
        }

        //判断收到的HUITP消息是否为空
        if(empty($content) == true){
            $log_content = "E: empty HUITP message body";
            $loggerObj->mylog($project,$devCode,"MFUN_TASK_ID_L2SDK_IOT_HUITP","MFUN_TASK_ID_L2DECODE_HUITP",$msgName,$log_content);
            return false;
        }
        else{
            $huitpHead = substr($content, 0, MFUN_HUITP_MSG_HEAD_LENGTH);
            $huitpBody = substr($content, MFUN_HUITP_MSG_HEAD_LENGTH);
            $huitpData = unpack(MFUN_HUITP_MSG_HEAD_FORMAT, $huitpHead);
            $huitpMsgId = hexdec($huitpData['MsgId']) & 0xFFFF; //转化成10进制整数
            $huitpMsgLen = hexdec($huitpData['MsgLen']) & 0xFFFF;
        }
        //判断HUITP消息长度的合法性
        $length =  $huitpMsgLen * 2 + MFUN_HUITP_MSG_HEAD_LENGTH; //因为收到的消息为16进制字符，消息总长度等于length＋2B MsgId＋2B MsgLen本身
        if ($length != strlen($content)) {
            $log_content = "E: HUITP Message length invalid";
            $loggerObj->mylog($project,$devCode,"MFUN_TASK_ID_L2SDK_IOT_HUITP","MFUN_TASK_ID_L2DECODE_HUITP",$msgName,$log_content);
            return false;
        }
        //判断HUITP消息的IE是否为空
        if(empty($huitpBody) == true){
            $log_content = "E: HUITP message with NULL IE";
            $loggerObj->mylog($project,$devCode,"MFUN_TASK_ID_L2SDK_IOT_HUITP","MFUN_TASK_ID_L2DECODE_HUITP",$msgName,$log_content);
            return false;
        }

        //解码HUITP消息
        $l2codecHuitpMsgDictObj = new classL2codecHuitpMsgDict();
        $respArray = $l2codecHuitpMsgDictObj->mfun_l2codec_getHuitpIeArray($huitpMsgId);
        if ($respArray == false){
            $log_content = "E: invaild HUITP message ID";
            $loggerObj->mylog($project,$devCode,"MFUN_TASK_ID_L2SDK_IOT_HUITP","MFUN_TASK_ID_L2DECODE_HUITP",$msgName,$log_content);
            return false;
        }

        $huitpMsgName = $respArray['MSGNAME'];
        $huitpIeArray = $respArray['MSGIE'];
        if ($huitpIeArray == false){
            $log_content = "E: invaild HUITP message ID";
            $loggerObj->mylog($project,$devCode,"MFUN_TASK_ID_L2SDK_IOT_HUITP","MFUN_TASK_ID_L2DECODE_HUITP",$msgName,$log_content);
            return false;
        }

        $i = 0;
        $huitpIePtr = 0;
        $unpackedHuitpIeArray = array();
        $l2codecHuitpIeDictObj = new classL2codecHuitpIeDict;
        while($i < count($huitpIeArray) AND $huitpBody != false)
        {
            $one_row = array(); //初始化
            $huitpIeId = $huitpIeArray[$i];
            $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat($huitpIeId);
            //判断HUITP消息的IE是否合法
            if($huitpIe == false){
                $log_content = "E: received HUITP message with invalid IE";
                $loggerObj->mylog($project,$devCode,"MFUN_TASK_ID_L2SDK_IOT_HUITP","MFUN_TASK_ID_L2DECODE_HUITP",$msgName,$log_content);
                return false;
            }
            $huitpIeFormat = $huitpIe['format'];
            $huitpIeName = $huitpIe['name'];

            $ieContent = unpack($huitpIeFormat, $huitpBody);
            $one_row = array($huitpIeName => $ieContent);
            array_push($unpackedHuitpIeArray, $one_row);

            $ieLen = hexdec($ieContent['ieLen']) & 0xFFFF;
            $huitpIePtr = $ieLen*2 + MFUN_HUITP_IE_HEAD_LENGTH;
            $huitpBody = substr($huitpBody,$huitpIePtr); //从消息体上剥离已经解码的IE
            $i++;
        }

        $huitp_destId = $l2codecHuitpMsgDictObj->mfun_l2codec_getHuitpDestTaskId($huitpMsgId);

        $msg = array("project" => $project,
            "platform" => MFUN_TECH_PLTF_HCUGX_HUITP,
            "devCode" => $devCode,
            "statCode" => $statCode,
            "content" => $unpackedHuitpIeArray,
            "funcFlag" => $funcFlag);
        if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2DECODE_HUITP,
                $huitp_destId,
                $huitpMsgId,
                $huitpMsgName,
                $msg) == false) $resp = "E: send to message buffer error";
        else $resp = "";

        //处理结果
        //由于消息的分布发送到各个任务模块中去了，这里不再统一处理ECHO返回，而由各个任务模块单独完成
        if (!empty($resp)) {
            $log_content = json_encode($resp,JSON_UNESCAPED_UNICODE);
            $loggerObj->mylog($project,$devCode,"MFUN_TASK_ID_L2SDK_IOT_HUITP","MFUN_TASK_ID_L2DECODE_HUITP",$msgName,$log_content);
        }
        //结束，返回
        return true;

    }//end of mfun_l2decode_huitp_xml_task_main_entry

}
?>