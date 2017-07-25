<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/25
 * Time: 15:02
 */

include_once "l2codec_huitp_msg_dict.php";

class classTaskL2encodeHuitpXml
{
    //构造函数
    public function __construct()
    {

    }

    //查找IE format字符串中的长度数字
    private function findNum($str){
        $str=trim($str);
        if(empty($str)){return '';}
        $result=array();
        while(!empty($str)){
            $len = intval(substr($str,1,1));
            array_push($result,$len);
            $str = strstr($str, "/");
            $str = substr($str,1);
        }
        return $result;
    }

    //HUITP消息编码发送模块总入口。Cloud回复给HCU的HUITP消息在各任务模块生成，通过消息MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING发送到HUITP ENCODE模块，
    //每个IE为一个数组，填充在content里，在这里对消息进行编码，保证回复的消息为规定长度的HEX->CHAR型
    public function mfun_l2encode_huitp_xml_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //判断入口消息是否为空
        if (empty($msg) == true) {
            $loggerObj->logger("MFUN_TASK_ID_L2ENCODE_HUITP", "mfun_l2encode_huitp_xml_task_main_entry", $log_time, "R: Received null message body.");
            echo "";
            return false;
        }
        //来自各L2SNR模块发给给HCU的HUITP消息
        if (($msgId != MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING) || ($msgName != "MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING")){
            $result = "Received Msgid error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2ENCODE_HUITP", "mfun_l2encode_huitp_xml_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        else{ //解开消息
            if (isset($msg["project"])) $project = $msg["project"]; else  $project = "";
            if (isset($msg["devCode"])) $devCode = $msg["devCode"]; else  $devCode = "";
            if (isset($msg["respMsg"])) $huitpMsgId = intval($msg["respMsg"]); else  $huitpMsgId = 0;
            if (isset($msg["content"])) $content = $msg["content"]; else  $content = "";
        }

        //编码HUITP消息
        $l2codecHuitpMsgDictObj = new classL2codecHuitpMsgDict();
        $respArray = $l2codecHuitpMsgDictObj->mfun_l2codec_getHuitpIeArray($huitpMsgId);
        $huitpMsgName = $respArray['MSGNAME'];
        $huitpIeArray = $respArray['MSGIE'];
        if ($huitpIeArray == false){
            $loggerObj->logger("MFUN_TASK_ID_L2ENCODE_HUITP", "mfun_l2encode_huitp_xml_task_main_entry", $log_time, "I: Received invalid HUITP message ID");
            echo "";
            return false;
        }

        $i = 0;
        $respIeStr = "";
        $l2codecHuitpIeDictObj = new classL2codecHuitpIeDict;
        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        while($i < count($huitpIeArray))
        {
            $huitpIeId = $huitpIeArray[$i];
            $huitpIe = $l2codecHuitpIeDictObj->mfun_l2codec_getHuitpIeFormat($huitpIeId);
            $huitpIeFormat = $huitpIe['format'];  //A4ieId/A4ieLen/A2dataFormat/A8pm01Value
            $huitpIeLen = $huitpIe['len'];

            //编码IE ID
            $respIeStr = $respIeStr.$dbiL1vmCommonObj->ushort2string($huitpIeId);
            //编码IE Length
            $respIeStr = $respIeStr.$dbiL1vmCommonObj->ushort2string($huitpIeLen);
            //编码IE参数
            $ieNumList = $this->findNum($huitpIeFormat);
            for($j = 2; $j<count($ieNumList); $j++)
            {
                if($ieNumList[$j] == HUITP_FRAME_STRUCT_1_BYTE){
                    $respIeStr = $respIeStr.$dbiL1vmCommonObj->byte2string($content[$i][$j]);
                }
                elseif($ieNumList[$j] == HUITP_FRAME_STRUCT_2_BYTE){
                    $respIeStr = $respIeStr.$dbiL1vmCommonObj->ushort2string($content[$i][$j]);
                }
                elseif($ieNumList[$j] == HUITP_FRAME_STRUCT_4_BYTE){
                    $respIeStr = $respIeStr.$dbiL1vmCommonObj->int2string($content[$i][$j]);
                }
            }
            $i++;
        }

        if(!empty($respIeStr))
        {
            $respMsgLen = strlen($respIeStr)/2;
            $respMsgStr = $dbiL1vmCommonObj->ushort2string($respMsgLen).$respIeStr;
            $respMsgStr = $dbiL1vmCommonObj->ushort2string($huitpMsgId).$respMsgStr;

            //通过建立tcp阻塞式socket连接，向HCU发送回复消息
            $client = new socket_client_sync($devCode, $respMsgStr);
            $client->connect();

            //返回消息log
            $timestamp = time();
            $log_time = date("Y-m-d H:i:s", $timestamp);
            $log_from = $devCode;
            $log_content = "T:" . json_encode($respMsgStr);
            $loggerObj->logger($project, $log_from, $log_time, $log_content);
        }
        //结束，返回
        return true;

    }//end of mfun_l2encode_huitp_xml_task_main_entry

}
?>