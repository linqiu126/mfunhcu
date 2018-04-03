<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/3
 * Time: 15:20
 */

include_once "dbi_l2snr_weight.class.php";

class classTaskL2snrWeight
{
    //构造函数
    public function __construct()
    {

    }

    public function func_weight_data_process( $devCode, $statCode, $content)
    {
        $raw_MsgHead = substr($content, 0, MFUN_HCU_MSG_HEAD_LENGTH);  //截取6Byte MsgHead
        $msgHead = unpack(MFUN_HCU_MSG_HEAD_FORMAT, $raw_MsgHead);
        $length = hexdec($msgHead['Len']) & 0xFF;
        $length =  ($length+2) * 2; //因为收到的消息为16进制字符，消息总长度等于length＋1B控制字＋1B长度本身
        if ($length != strlen($content)) {
            return "ERROR BFSC_WEIGHT: message length invalid";  //消息长度不合法，直接返回
        }

        $opt_key = hexdec($msgHead['Cmd']) & 0xFF;

        if ($opt_key == MFUN_HCU_OPT_BFSC_WEIGHTDATA_IND){
            $classDbiL2snrWeight = new classDbiL2snrWeight();
            $resp = $classDbiL2snrWeight->dbi_hcu_weight_data_process($devCode, $statCode, $content);
        }
        elseif ($opt_key == MFUN_HCU_OPT_BFSC_WEIGHTSTART_RESP){
            $resp = "BFSC weight start response receive";
        }
        elseif ($opt_key == MFUN_HCU_OPT_BFSC_WEIGHTSTOP_RESP){
            $resp = "BFSC weight stop response receive";
        }
        else
            $resp = "ERROR FHYS_WATER: Invalid Operation Command";

        return $resp;
    }



    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2snr_weight_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project = MFUN_PRJ_HCU_JSON;

        //入口消息内容判断
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog($project,"","MFUN_TASK_ID_L2SDK_IOT_JSON","MFUN_TASK_ID_L2SNR_WEIGHT",$msgName,$log_content);
            return false;
        }
        else{ //解开消息
            if (isset($msg["project"])) $project = $msg["project"]; else $project = "";
            if (isset($msg["devCode"])) $devCode = $msg["devCode"]; else $devCode = "";
            if (isset($msg["statCode"])) $statCode = $msg["statCode"]; else $statCode = "";
            if (isset($msg["content"])) $content = $msg["content"]; else $content = "";
            if (isset($msg["funcFlag"])) $funcFlag = $msg["funcFlag"]; else $funcFlag = "";
        }

        //具体处理函数
        if ($msgId == MSG_ID_L2SDK_HCU_TO_L2SNR_WEIGHT){ //for old BFSC project
            $resp = $this->func_weight_data_process( $devCode, $statCode, $content);
        }
        elseif($msgId == HUITP_JSON_MSGID_uni_faws_data_report){
            $respJson = array("ToUsr" => $devCode,
                            "FrUsr" => MFUN_CLOUD_HCU,
                            "CrTim" => time(),
                            "MsgTp" => "huitp-json",
                            "MsgId" => HUITP_JSON_MSGID_uni_faws_data_confirm,
                            "MsgLn" => 0,
                            "IeCnt" => 0,
                            "FnFlg" => 0);
            //通过建立tcp阻塞式socket连接，向HCU发送回复消息
            $dbiL1vmCommonObj = new classDbiL1vmCommon();
            $socketid = $dbiL1vmCommonObj->dbi_huitp_huc_socketid_inqery($devCode);
            if ($socketid != 0){
                $client = new socket_client_sync($socketid, $devCode, $respJson);
                $client->connect();
                //返回消息log
                $log_content = "T:" . json_encode($respJson);
                $loggerObj->mylog($project,$devCode,"MFUN_TASK_ID_L2SNR_WEIGHT","MFUN_TASK_VID_L1VM_SWOOLE","MSG_VID_L2CODEC_ENCODE_HUITP_OUTPUT",$log_content);
            }
            else{
                $log_content = "E: Socket closed!";
                $loggerObj->mylog($project,$devCode,"MFUN_TASK_ID_L2SNR_WEIGHT","MFUN_TASK_VID_L1VM_SWOOLE","MSG_VID_L2CODEC_ENCODE_HUITP_OUTPUT",$log_content);
            }
        }
        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp)) {
            $log_content = json_encode($resp,JSON_UNESCAPED_UNICODE);
            $loggerObj->mylog($project,$devCode,"MFUN_TASK_ID_L2SDK_IOT_JSON","MFUN_TASK_ID_L2SNR_WEIGHT",$msgName,$log_content);
        }

        //返回
        return true;
    }

}//End of class_task_service

?>