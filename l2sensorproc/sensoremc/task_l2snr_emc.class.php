<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2015/12/13
 * Time: 12:19
 */
include_once "../../l1comvm/vmlayer.php";
include_once "dbi_l2snr_emc.class.php";

class classTaskL2snrEmc
{
    //构造函数
    public function __construct()
    {

    }

    public function func_emc_process($platform, $deviceId, $statCode, $content)
    {
        switch($platform)
        {
            case PLTF_WX:
                if (strlen($content) == 0) {
                    return "ERROR EMC_SERVICE[WX]: message length invalid";  //消息长度不合法，直接返回
                }
                $resp = $this->wx_emcdata_req_process($deviceId,$content);
                break;
            case PLTF_HCU:
                $raw_MsgHead = substr($content, 0, HCU_MSG_HEAD_LENGTH);  //截取4Byte MsgHead
                $msgHead = unpack(HCU_MSG_HEAD_FORMAT, $raw_MsgHead);

                $length = hexdec($msgHead['Len']) & 0xFF;
                $length =  ($length+2) * 2; //因为收到的消息为16进制字符，消息总长度等于length＋1B控制字＋1B长度本身
                if ($length != strlen($content)) {
                    return "ERROR EMC_SERVICE[HCU]: message length invalid";  //消息长度不合法，直接返回
                }
                $data = substr($content, HCU_MSG_HEAD_LENGTH, $length - HCU_MSG_HEAD_LENGTH);//截取消息数据域

                $opt_key = hexdec($msgHead['Cmd']) & 0xFF;
                switch ($opt_key) //MODBUS操作字处理
                {
                    case MODBUS_DATA_REPORT:
                        $resp = $this->hcu_emcdata_req_process($deviceId, $statCode, $data);
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
                $resp = "ERROR EMC_SERVICE: PLTF invalid";
                break;
        }
        return $resp;
    }

    private function wx_emcdata_req_process( $deviceId,$content)
    {
        $emc_value = hexdec($content) & 0xFFFF;
        //$emc_time = hexdec(substr($content, 8, 8)) & 0xFFFFFFFF;
        $emc_time = time(); //下位机暂时没有时间上报，取系统当前时间
        $sensorId = "";
        $gps = "";

        $sDbObj = new classDbiL2snrEmc();
        $sDbObj->dbi_emcData_save($deviceId, $sensorId, $emc_time, $emc_value,$gps);
        $sDbObj->dbi_emcData_delete_3monold($deviceId, $sensorId, 90);  //remove 90 days old data.
        $sDbObj->dbi_emcAccumulation_save($deviceId); //累计值计算，如果不是初次接收数据，而且日期没有改变，则该过程将非常快

        $resp = ""; //no response message
        return $resp;
    }

    private function hcu_emcdata_req_process( $deviceId,$statCode,$content)
    {
        $format = "A2Equ/A2Type/A2Format/A4Emc/A2Flag_Lo/A8Longitude/A2Flag_La/A8Latitude/A8Altitude/A8Time";
        $data = unpack($format, $content);

        $sensorId = hexdec($data['Equ']) & 0xFF;
        $report["format"] = hexdec($data['Format']) & 0xFF;
        $report["value"] = hexdec($data['Emc']) & 0xFFFF;
        $gps["flag_la"] = chr(hexdec($data['Flag_La']) & 0xFF);
        $gps["latitude"] = hexdec($data['Latitude']) & 0xFFFFFFFF;
        $gps["flag_lo"] = chr(hexdec($data['Flag_Lo']) & 0xFF);
        $gps["longitude"] = hexdec($data['Longitude']) & 0xFFFFFFFF;
        $gps["altitude"] = hexdec($data['Altitude']) & 0xFFFFFFFF;
        $timeStamp = hexdec($data['Time']) & 0xFFFFFFFF;

        //存入数据库中
        $sDbObj = new classDbiL2snrEmc();
        $sDbObj->dbi_emcData_save($deviceId, $sensorId, $timeStamp, $report, $gps);
        $sDbObj->dbi_emcData_delete_3monold($deviceId, $sensorId, 90);  //remove 90 days old data.
        $sDbObj->dbi_emcAccumulation_save($deviceId); //累计值计算，如果不是初次接收数据，而且日期没有改变，则该过程将非常快

        //更新分钟测量报告聚合表
        $sDbObj->dbi_minreport_update_emc($deviceId,$statCode,$timeStamp,$report);

        //更新数据精度格式表
        $format = $report["format"];
        $cDbObj = new classDbiL1vmCommon();
        $cDbObj->dbi_dataformat_update_format($deviceId,"T_emcdata",$format);
        //更新瞬时测量值聚合表
        $cDbObj->dbi_currentreport_update_value($deviceId, $statCode, $timeStamp,"T_emcdata", $report);

        $resp = "";
        return $resp;
    }

    public function func_emc_data_push_process()
    {
        $magicCode = "FECF";
        $version = "0001";
        $length = "000C";
        $cmdid = $this->ushort2string(CMDID_EMC_DATA_PUSH);
        $seq = "0000";
        $errCode = "0000";

        $msg_body = $magicCode . $version . $length . $cmdid . $seq . $errCode;

        $hex_body = strtoupper(pack('H*',$msg_body));

        return $hex_body;
    }

    //BYTE转换到字符串
    public function byte2string($n)
    {
        $out = "00";
        $a1 = strtoupper(dechex($n & 0xFF));
        return substr_replace($out, $a1, strlen($out)-strlen($a1), strlen($a1));
    }
    
    //2*BYTE转换到字符串
    public function ushort2string($n)
    {
        $out = "0000";
        $a1 = strtoupper(dechex($n & 0xFFFF));
        return substr_replace($out, $a1, strlen($out)-strlen($a1), strlen($a1));
    }

    //任务入口函数
    public function mfun_l2snr_emc_task_main_entry($parObj, $msg)
    {

    }

}//End of class_emc_service

?>