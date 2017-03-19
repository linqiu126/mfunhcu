<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/25
 * Time: 15:02
 */

include_once "l2codec_huitp_msg_dict.php";

class classTaskL2codecHuitpXml
{
    //构造函数
    public function __construct()
    {

    }

    public function mfun_l2codec_huitp_xml_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //判断入口消息是否为空
        if (empty($msg) == true) {
            $loggerObj->logger("MFUN_TASK_ID_L2CODEC_HUITP", "mfun_l2codec_huitp_xml_task_main_entry", $log_time, "R: Received null message body.");
            echo "";
            return false;
        }
        if (($msgId != MSG_ID_L2SDK_IOT_HUITP_TO_L2CODEC_HUITP) || ($msgName != "MSG_ID_L2SDK_IOT_HUITP_TO_L2CODEC_HUITP")){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2CODEC_HUITP", "mfun_l2codec_huitp_xml_task_main_entry", $log_time, $log_content);
            echo trim($result);
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
            $loggerObj->logger("MFUN_TASK_ID_L2CODEC_HUITP", "mfun_l2codec_huitp_xml_task_main_entry", $log_time, "I: Received null message body.");
            echo "";
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
            $result = "Message length invalid";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2CODEC_HUITP", "mfun_l2codec_huitp_xml_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //判断HUITP消息的IE是否为空
        if(empty($huitpBody) == true){
            $loggerObj->logger("MFUN_TASK_ID_L2CODEC_HUITP", "mfun_l2codec_huitp_xml_task_main_entry", $log_time, "I: Received HUITP message with NULL IE");
            echo "";
            return false;
        }

        $l2codecHuitpMsgDictObj = new classL2codecHuitpMsgDict;
        $huitpIeArray = $l2codecHuitpMsgDictObj->mfun_l2codec_getHuitpIeArray($huitpMsgId);
        if ($huitpIeArray == false){
            $loggerObj->logger("MFUN_TASK_ID_L2CODEC_HUITP", "mfun_l2codec_huitp_xml_task_main_entry", $log_time, "I: Received invalid HUITP message ID");
            echo "";
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
                $loggerObj->logger("MFUN_TASK_ID_L2CODEC_HUITP", "mfun_l2codec_huitp_xml_task_main_entry", $log_time, "I: Received HUITP message with invalid IE");
                echo "";
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

        return $unpackedHuitpIeArray;
    }//end of mfun_l2codec_huitp_xml_task_main_entry

}
?>