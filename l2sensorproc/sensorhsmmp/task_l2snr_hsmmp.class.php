<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2015/12/13
 * Time: 12:24
 */
include_once "../../l1comvm/vmlayer.php";
include_once "dbi_l2snr_hsmmp.class.php";

class class_video_service
{
    //构造函数
    public function __construct()
    {

    }

    public function func_video_process($platform, $deviceId, $content,$funcFlag)
    {
        switch($platform)
        {
            case PLTF_WX:   //微信有专门的video消息类型，这里暂时定义一个空操作保持结构的完整性
                $length = hexdec(substr($content, 2, 2)) & 0xFF;
                $length = ($length + 2)*2; //消息总长度等于length＋1B 控制字＋1B长度本身
                if ($length != strlen($content)){
                    return "VIDEO_SERVICE[WX]: message length invalid";  //消息长度不合法，直接返回
                }
                $sub_key = hexdec(substr($content, 4, 2)) & 0xFF;
                switch ($sub_key) //MODBUS操作字处理
                {
                    case OPT_VEDIOLINK_RESP:
                        $resp = $this->wx_video_req_process($deviceId, $content,$funcFlag);
                        break;
                    case OPT_VEDIOFILE_RESP:
                        $resp = "";
                        break;

                    default:
                        $resp = "";
                        break;
                }
                break;
            case PLTF_HCU:
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
            case PLTF_JD:
                $resp = ""; //no response message
                break;
            default:
                $resp = "VIDEO_SERVICE: PLTF invalid";
                break;
        }
        return $resp;
    }

    //微信平台暂时不支持
    private function wx_video_req_process( $deviceId, $content, $funcFlag)
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

}

?>