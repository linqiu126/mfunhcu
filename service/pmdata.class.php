<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2015/12/13
 * Time: 12:23
 */

include_once "../database/db_common.class.php";
include_once "../database/db_pmdata.class.php";


class class_pmData_service
{
    public function func_pmData_process($platform, $deviceId, $statCode, $content)
    {
        switch($platform)
        {
            case PLTF_WX:
                $length = hexdec(substr($content, 2, 2)) & 0xFF;
                $length =($length + 2)*2; //消息总长度等于length＋1B 控制字＋1B长度本身
                if ($length != strlen($content)){
                    return "PM_SERVICE[WX]: message length invalid";  //消息长度不合法，直接返回
                }
                $sub_key = hexdec(substr($content, 4, 2)) & 0xFF;
                switch ($sub_key) //MODBUS操作字处理
                {
                    case MODBUS_DATA_REPORT:
                        $resp = $this->wx_pmdata_req_process($deviceId, $content);
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
                    return "PM_SERVICE[HCU]: message length invalid";  //消息长度不合法，直接返回
                }
                $data = substr($content, HCU_MSG_HEAD_LENGTH, $length - HCU_MSG_HEAD_LENGTH);//截取消息数据域

                $opt_key = hexdec($msgHead['Cmd']) & 0xFF;
                switch ($opt_key) //MODBUS操作字处理
                {
                    case MODBUS_DATA_REPORT:
                        $resp = $this->hcu_pmdata_req_process($deviceId,$statCode, $data);
                        break;
                    case MODBUS_SWITCH_SET_ACK:
                        $resp = $this->hcu_pm_switch_set_process($deviceId,$statCode, $data);
                        break;
                    case MODBUS_ADDR_SET_ACK:
                        $resp = "";
                        break;
                    case MODBUS_PERIOD_SET_ACK:
                        $resp = "";
                        break;
                    case MODBUS_SAMPLE_SET_ACK:
                        $resp = "";
                        break;
                    case MODBUS_TIMES_SET_ACK:
                        $resp = "";
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
                $resp = "PM_SERVICE: PLTF invalid";
                break;

        }
        return $resp;
    }

    private function wx_pmdata_req_process( $deviceId,$content)
    {
        $pmdata["pm01"] = hexdec(substr($content, 6, 8)) & 0xFFFFFFFF;
        $pmdata["pm25"] = hexdec(substr($content, 14, 8)) & 0xFFFFFFFF;
        $pmdata["pm10"] = hexdec(substr($content, 22, 8)) & 0xFFFFFFFF;
        $devCode = hexdec(substr($content, 30, 4)) & 0xFFFF;
        //$ntimes = hexdec(substr($content, 34, 4)) & 0xFFFF;
        $ntimes =time();
        $gps = "";

        $sDbObj = new class_pmdata_db();
        $sDbObj->db_pmData_save($deviceId, $devCode,$ntimes, $pmdata,$gps);
        $sDbObj->db_pmdata_delete_3monold($deviceId, $devCode,90);  //remove 90 days old data.

        $resp = ""; //no response message
        return $resp;
    }

    private function hcu_pmdata_req_process( $deviceId,$statCode,$content)
    {
        $format = "A2Equ/A2Type/A2Format/A8PM01/A8PM25/A8PM10/A2Flag_Lo/A8Longitude/A2Flag_La/A8Latitude/A8Altitude/A8Time";
        $data = unpack($format, $content);

        $sensorId = hexdec($data['Equ']) & 0xFF;
        $report["format"] = hexdec($data['Format']) & 0xFF;
        $report["pm01"] = hexdec($data['PM01']) & 0xFFFFFFFF;
        $report["pm25"] = hexdec($data['PM25']) & 0xFFFFFFFF;
        $report["pm10"] = hexdec($data['PM10']) & 0xFFFFFFFF;
        $gps["flag_la"] = chr(hexdec($data['Flag_La']) & 0xFF);
        $gps["latitude"] = hexdec($data['Latitude']) & 0xFFFFFFFF;
        $gps["flag_lo"] = chr(hexdec($data['Flag_Lo']) & 0xFF);
        $gps["longitude"] = hexdec($data['Longitude']) & 0xFFFFFFFF;
        $gps["altitude"] = hexdec($data['Altitude']) & 0xFFFFFFFF;
        $timeStamp = hexdec($data['Time']) & 0xFFFFFFFF;

        $sDbObj = new class_pmdata_db();
        $sDbObj->db_pmData_save($deviceId, $sensorId, $timeStamp, $report,$gps);
        $sDbObj->db_pmdata_delete_3monold($deviceId, $sensorId,90);  //remove 90 days old data.

        //更新分钟测量报告聚合表
        $sDbObj->db_minreport_update_pmdata($deviceId,$statCode,$timeStamp,$report);

        //更新数据精度格式表
        $format = $report["format"];
        $cDbObj = new class_common_db();
        $cDbObj->db_dataformat_update_format($deviceId,"T_pmdata",$format);
        //更新瞬时测量值聚合表
        $cDbObj->db_currentreport_update_value($deviceId, $statCode, $timeStamp,"T_pmdata", $report);

        $resp = ""; //no response message
        return $resp;
    }

    private function hcu_pm_switch_set_process($deviceId,$statCode, $content)
    {
        $format = "A2Equ/A2Status";
        $data = unpack($format, $content);

        $sensorId = hexdec($data['Equ']) & 0xFF;
        $status = hexdec($data['Status']) & 0xFF;

        $cDbObj = new class_common_db();
        $cDbObj->db_hcuDevice_update_status($deviceId,$statCode,$status);

        $resp = ""; //no response message
        return $resp;
    }


    //PM强度读取 (Cloud- > IHU)
    public function func_pm_data_push_process()
    {
        $cmdid = $this->byte2string(CMDID_PM_DATA);
        $length = "01";
        $sub_key =  $this->byte2string(MODBUS_DATA_REQ);
        $msg_body = $cmdid . $length . $sub_key;

        $hex_body = pack('H*',$msg_body);

        return $hex_body;
    }

    //BYTE转换到字符串
    public function byte2string($n)
    {
        $out = "00";
        $a1 = strtoupper(dechex($n & 0xFF));
        return substr_replace($out, $a1, strlen($out)-strlen($a1), strlen($a1));
    }
}//End of class_pmData_service

?>