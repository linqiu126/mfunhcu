<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2015/12/13
 * Time: 12:24
 */
//include_once "../../l1comvm/vmlayer.php";
include_once "dbi_l2snr_hsmmp.class.php";

class classTaskL2snrHsmmp
{
    //构造函数
    public function __construct()
    {

    }

    public function func_hsmmp_process($platform, $deviceId, $content,$funcFlag)
    {
        switch($platform)
        {
            case MFUN_PLTF_WX:   //微信有专门的video消息类型，这里暂时定义一个空操作保持结构的完整性
                $length = hexdec(substr($content, 2, 2)) & 0xFF;
                $length = ($length + 2)*2; //消息总长度等于length＋1B 控制字＋1B长度本身
                if ($length != strlen($content)){
                    return "VIDEO_SERVICE[WX]: message length invalid";  //消息长度不合法，直接返回
                }
                $sub_key = hexdec(substr($content, 4, 2)) & 0xFF;
                switch ($sub_key) //MODBUS操作字处理
                {
                    case OPT_VEDIOLINK_RESP:
                        $resp = $this->wx_hsmmp_req_process($deviceId, $content,$funcFlag);
                        break;
                    case OPT_VEDIOFILE_RESP:
                        $resp = "";
                        break;

                    default:
                        $resp = "";
                        break;
                }
                break;
            case MFUN_PLTF_HCU:
                $raw_MsgHead = substr($content, 0, HCU_MSG_HEAD_LENGTH);  //截取4Byte MsgHead
                $msgHead = unpack(HCU_MSG_HEAD_FORMAT, $raw_MsgHead);

                $length = hexdec($msgHead['Len']) & 0xFF;
                $length =  ($length+2) * 2; //因为收到的消息为16进制字符，消息总长度等于length＋1B控制字＋1B长度本身
                if ($length != strlen($content)) {
                    return "VIDEO_SERVICE[HCU]: message length invalid";  //消息长度不合法，直接返回
                }
                $data = substr($content, HCU_MSG_HEAD_LENGTH, $length - HCU_MSG_HEAD_LENGTH);//截取消息数据域

                $opt_key = hexdec($msgHead['Cmd']) & 0xFF;
                switch ($opt_key) //MODBUS操作字处理
                {
                    case MODBUS_DATA_REPORT:
                        $resp = $this->hcu_video_req_process($deviceId, $data, $funcFlag);
                        break;
                    default:
                        $resp = "";
                        break;
                }
                break;
            case MFUN_PLTF_JD:
                $resp = ""; //no response message
                break;
            default:
                $resp = "VIDEO_SERVICE: PLTF invalid";
                break;
        }
        return $resp;
    }

    //微信平台暂时不支持
    private function wx_hsmmp_req_process( $deviceId, $content, $funcFlag)
    {
        $resp = ""; //no response message
        return $resp;
    }

    private function hcu_video_req_process( $deviceId,$content,$funcFlag)
    {
        $format = "A2Equ/A2Type/A2Flag_Lo/A8Longitude/A2Flag_La/A8Latitude/A8Altitude/A8Time";
        $data = unpack($format, $content);

        $sensorId = hexdec($data['Equ']) & 0xFF;
        $gps["flag_la"] = chr(hexdec($data['Flag_La']) & 0xFF);
        $gps["latitude"] = hexdec($data['Latitude']) & 0xFFFFFFFF;
        $gps["flag_lo"] = chr(hexdec($data['Flag_Lo']) & 0xFF);
        $gps["longitude"] = hexdec($data['Longitude']) & 0xFFFFFFFF;
        $gps["altitude"] = hexdec($data['Altitude']) & 0xFFFFFFFF;
        $timeStamp = hexdec($data['Time']) & 0xFFFFFFFF;

        $sDbObj = new classDbiL2snrHsmmp();
        $sDbObj->dbi_video_data_save($deviceId, $sensorId, $timeStamp, $funcFlag,$gps);

        $resp = ""; //no response message
        return $resp;
    }

    //任务入口函数
    public function mfun_l2snr_hsmmp_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classL1vmFuncComApi();
        $log_time = date("Y-m-d H:i:s", time());

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_HSMMP", "mfun_l2snr_hsmmp_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        if (($msgId != MSG_ID_L2SDK_HCU_TO_L2SNR_HSMMP) || ($msgName != "MSG_ID_L2SDK_HCU_TO_L2SNR_HSMMP")){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SNR_HSMMP", "mfun_l2snr_hsmmp_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        //解开消息
        $project= "";
        $log_from = "";
        $platform ="";
        $deviceId="";
        $statCode = "";
        $content="";
        if (isset($msg["project"])) $project = $msg["project"];
        if (isset($msg["log_from"])) $log_from = $msg["log_from"];
        if (isset($msg["platform"])) $platform = $msg["platform"];
        if (isset($msg["deviceId"])) $deviceId = $msg["deviceId"];
        if (isset($msg["statCode"])) $statCode = $msg["statCode"];
        if (isset($msg["content"])) $content = $msg["content"];

        //具体处理函数
        $resp = $this->func_hsmmp_process($platform, $deviceId, $statCode, $content);

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