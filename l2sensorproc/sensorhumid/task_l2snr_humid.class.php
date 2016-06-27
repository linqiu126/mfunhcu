<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2015/12/13
 * Time: 12:22
 */
include_once "../../l1comvm/vmlayer.php";
include_once "dbi_l2snr_humid.class.php";

class classTaskL2snrHumid
{
    //构造函数
    public function __construct()
    {

    }

    public function func_humidity_process($platform, $deviceId, $statCode, $content)
    {
        switch($platform)
        {
            case PLTF_WX:
                $length = hexdec(substr($content, 2, 2)) & 0xFF;
                $length = ($length + 2)*2; //消息总长度等于length＋1B 控制字＋1B长度本身
                if ($length != strlen($content)){
                    return "HUMIDITY_SERVICE[WX]: message length invalid";  //消息长度不合法，直接返回
                }
                $sub_key = hexdec(substr($content, 4, 2)) & 0xFF;
                switch ($sub_key) //MODBUS操作字处理
                {
                    case MODBUS_DATA_REPORT:
                        $resp = $this->wx_humidity_req_process($deviceId, $content);
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
                    return "HUMIDITY_SERVICE[HCU]: message length invalid";  //消息长度不合法，直接返回
                }
                $data = substr($content, HCU_MSG_HEAD_LENGTH, $length - HCU_MSG_HEAD_LENGTH);//截取消息数据域

                $opt_key = hexdec($msgHead['Cmd']) & 0xFF;
                switch ($opt_key) //MODBUS操作字处理
                {
                    case MODBUS_DATA_REPORT:
                        $resp = $this->hcu_humidity_req_process($deviceId, $statCode, $data);
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
                $resp = "HUMIDITY_SERVICE: PLTF invalid";
                break;
        }
        return $resp;
    }

    private function wx_humidity_req_process( $deviceId, $content)
    {
        $humidity =  hexdec(substr($content, 6, 4)) & 0xFFFF;
        $devCode = hexdec(substr($content, 10, 4)) & 0xFFFF;
        //$ntimes = hexdec(substr($content, 14, 4)) & 0xFFFF;
        $ntimes =time();
        $gps = "";

        $sDbObj = new classDbiL2snrHumid();
        $sDbObj->dbi_humidity_data_save($deviceId,$devCode,$ntimes,$humidity,$gps);

        $resp = ""; //no response message
        return $resp;
    }

    private function hcu_humidity_req_process( $deviceId,$statCode,$content)
    {
        $format = "A2Equ/A2Type/A2Format/A4Humidity/A2Flag_Lo/A8Longitude/A2Flag_La/A8Latitude/A8Altitude/A8Time";
        $data = unpack($format, $content);

        $sensorId = hexdec($data['Equ']) & 0xFF;
        $report["format"] = hexdec($data['Format']) & 0xFF;
        $report["value"] = hexdec($data['Humidity']) & 0xFFFF;
        $gps["flag_la"] = chr(hexdec($data['Flag_La']) & 0xFF);
        $gps["latitude"] = hexdec($data['Latitude']) & 0xFFFFFFFF;
        $gps["flag_lo"] = chr(hexdec($data['Flag_Lo']) & 0xFF);
        $gps["longitude"] = hexdec($data['Longitude']) & 0xFFFFFFFF;
        $gps["altitude"] = hexdec($data['Altitude']) & 0xFFFFFFFF;
        $timeStamp = hexdec($data['Time']) & 0xFFFFFFFF;

        $sDbObj = new classDbiL2snrHumid();
        $sDbObj->dbi_humidity_data_save($deviceId, $sensorId, $timeStamp, $report,$gps);
        //$wxDbObj->dbi_AirPmDataInfo_delete_3monold($fromuser, $deviceid, $boxid,90);  //remove 90 days old data.

        //更新分钟测量报告聚合表
        $sDbObj->dbi_minreport_update_humidity($deviceId,$statCode,$timeStamp,$report);

        //更新数据精度格式表
        $format = $report["format"];
        $cDbObj = new classDbiL1vmCommon();
        $cDbObj->dbi_dataformat_update_format($deviceId,"T_humidity",$format);
        //更新瞬时测量值聚合表
        $cDbObj->dbi_currentreport_update_value($deviceId, $statCode, $timeStamp,"T_humidity", $report);

        $resp = ""; //no response message
        return $resp;
    }

    //任务入口函数
    public function mfun_l2snr_humid_task_main_entry($parObj, $msg)
    {

    }

}

?>