<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2015/12/9
 * Time: 23:09
 */

include_once "../service/emc.class.php";
include_once "../service/humidity.class.php";
include_once "../service/noise.class.php";
include_once "../service/common.class.php";
include_once "../service/pmdata.class.php";
include_once "../service/temperature.class.php";
include_once "../service/video.class.php";
include_once "../service/winddirection.class.php";
include_once "../service/windspeed.class.php";

include_once "../database/db_common.class.php";


//HCU硬件设备级 Layer 2 SDK
class class_hcu_IOT_sdk
{
    //Layer3 业务消息“XML格式”的处理函数，跳转到对应的业务处理模块
    public function receive_hcu_xmlMessage($data)
    {
        //目前HCU发送的数据已经是ASCII码，不需要再进行解码
        //$content = base64_decode($data->Content);
        //$content = unpack('H*',$content);
        //$strContent = strtoupper($content["1"]); //转换成16进制格式的字符串
        $toUser = trim($data->ToUserName);
        $deviceId = trim($data->FromUserName);
        $createTime = trim($data->CreateTime);  //暂时不处理，后面增加时间合法性的判断
        $content = trim($data->Content);
        $funcFlag = trim($data->FuncFlag);

        $cDbObj = new class_common_db();
        $result = $cDbObj->db_hcuDevice_valid_device($deviceId); //FromUserName对应每个HCU硬件的设备编号
        if (empty($result)){
            return "HCU_IOT: invalid device ID";
        }
        else{
            $statCode = $result;
        }

        if ($toUser !=CLOUD_NAME){
            return "HCU_IOT: XML message invalid ToUserName";
        }

        $key = unpack('A2Key', $content);
        $ctrl_key = hexdec($key['Key'])& 0xFF;
        switch ($ctrl_key)
        {
            case CMDID_VERSION_SYNC:
                //定时辐射强度处理
                $hcuObj = new class_common_service();
                $resp = $hcuObj->func_version_update_process(PLTF_HCU, $deviceId, $content);
                break;
            case CMDID_TIME_SYNC:
                $hcuObj = new class_common_service();
                $resp = $hcuObj->func_timeSync_process();
                break;
            case CMDID_HEART_BEAT:
                $hcuObj = new class_common_service();
                $resp = $hcuObj->func_heartBeat_process();
                break;
            case CMDID_HCU_POLLING:
                $hcuObj = new class_common_service();
                $resp = $hcuObj->func_hcuPolling_process($deviceId);
                break;
            case CMDID_EMC_DATA:  //定时辐射强度处理
                $hcuObj = new class_emc_service();
                $resp = $hcuObj->func_emc_process(PLTF_HCU, $deviceId, $statCode, $content);
                break;
            case CMDID_PM_DATA:
                $hcuObj = new class_pmData_service();
                $resp = $hcuObj->func_pmData_process(PLTF_HCU, $deviceId, $statCode, $content);
                break;
            case CMDID_WINDSPEED_DATA:
                $hcuObj = new class_windSpeed_service();
                $resp = $hcuObj->func_windSpeed_process(PLTF_HCU, $deviceId, $statCode, $content);
                break;
            case CMDID_WINDDIR_DATA:
                $hcuObj = new class_windDirection_service();
                $resp = $hcuObj->func_windDirection_process(PLTF_HCU, $deviceId,  $statCode, $content);
                break;
            case CMDID_TEMPERATURE_DATA:
                $hcuObj = new class_temperature_service();
                $resp = $hcuObj->func_temperature_process(PLTF_HCU, $deviceId, $statCode, $content);
                break;
            case CMDID_HUMIDITY_DATA:
                $hcuObj = new class_humidity_service();
                $resp = $hcuObj->func_humidity_process(PLTF_HCU, $deviceId, $statCode, $content);
                break;
            case CMDID_VIDEO_DATA:
                if (empty($funcFlag)){
                    return "HCU_IOT: video link empty";
                }
                $hcuObj = new class_video_service();
                $resp = $hcuObj->func_video_process(PLTF_HCU, $deviceId, $content,$funcFlag);
                break;
            case CMDID_NOISE_DATA:
                $hcuObj = new class_noise_service();
                $resp = $hcuObj->func_noise_process(PLTF_HCU, $deviceId, $statCode, $content);
                break;
            default:
                $resp ="HCU_IOT: invalid service type";
                break;
        }
        return $resp;
    } //receive_hcu_xmlMsg处理结束


    //处理环保局要求格式的消息
    public function receive_hcu_zhbMessage($pdu)
    {
        $pduLen = intval(substr($pdu, 2, 4));  //数据段长度

        $qn = trim(substr($pdu, 6, 20),"_");  //请求编号
        $st = trim(substr($pdu, 26, 5), "_");  //系统编号
        $cn = trim(substr($pdu, 31, 7), "_");  //命令编号
        $mn =trim(substr($pdu, 38, 12),"_");  //设备编号
        $pw = substr($pdu, 50, 6);   //访问密码

        switch($cn)
        {
            case "ZHB_NOM":
                $pnum = substr($pdu, 56, 4);
                $pno = substr($pdu, 60, 4);
                $headerLen = 58; //=20+5+7+12+6+4+4
                $dataLen =$pduLen - $headerLen;
                $data =substr($pdu, 64, $dataLen);  //数据区的处理等规范业务逻辑明确后再处理

                $crc = substr($pdu, 6+$pduLen, 4);
                $pdu = substr($pdu, 6, $pduLen);
                $result = $this->crc_check($pdu,$crc);  //数据段CRC校验
                if ($result == false)
                    return "HCU_IOT: ZHB_NOM message CRC error";  //CRC校验失败直接返回

                $resp = $this->dummy_data_response($mn);
                break;
            case "ZHB_HRB":
                $pnum = substr($pdu, 56, 4);
                $pno = substr($pdu, 60, 4);

                $crc = substr($pdu, 6+$pduLen, 4);
                $pdu = substr($pdu, 6, $pduLen);
                $result = $this->crc_check($pdu,$crc);  //数据段CRC校验
                if ($result == false)
                    return "HCU_IOT: ZHB_HRB message CRC error";  //CRC校验失败直接返回

                $resp = $this->dummy_data_response($mn);
                break;
            default:
                $resp ="HCU_IOT: invalid frame type";
                break;
        }

        return $resp;
    }//receive_hcu_ZhbMsg处理结束

    public function dummy_data_response($fromUser)
    {
        $pHeader = "##"; //包头固定为“##”
        $pduLen = "0058";  // = 20+5+7+12+6+4+4
        $strDate = date('YmdHis',time());
        $qn = $this->str_padding($strDate,20);
        $st = "11111";
        $cn = "ZHB_HRB";
        $mn = $this->str_padding($fromUser,12);;  //HCU_SH_03010  ASSCII码484355 5F 5348 5F
        $pw = "BXBXBX";
        $pnum = "5555";
        $pno = "6666";
        $dataField = $qn . $st .$cn .$mn .$pw .$pnum . $pno;

        $crc = strtoupper(dechex($this->crc16($dataField,$crc=0xffff)));
        $cr = "0D"; //回车键CR
        $lf = "0A"; //换行键LF

        $pdu = $pHeader . $pduLen .$dataField . $crc . $cr . $lf;
        $resp = pack("H*",$pdu);

        return $resp;
    }

    public function str_padding($strInput,$lenInput)
    {
        $padding = "_"; //填充字符
        $len = strlen($strInput);
        while ($len < $lenInput)
        {
            $strInput = $strInput . $padding;
            $len++;
        }

        return $strInput;
    }

    public function crc16($string,$crc=0xffff) {

        for ( $x=0; $x<strlen( $string ); $x++ ) {

            $crc = $crc ^ ord( $string[$x] );
            for ($y = 0; $y < 8; $y++) {

                if ( ($crc & 0x0001) == 0x0001 )
                    $crc = ( ($crc >> 1 ) ^ 0xA001 );
                else
                    $crc =    $crc >> 1;
            }
        }
        return $crc;
    }

    public function crc_check($data, $crc)
    {
        $calc_crc = strtoupper(dechex($this->crc16($data, 0xffff)));

        if ($calc_crc == $crc)
            return true;
        else
            return false;
    }

}// End of class_hcu_IOT_sdk

?>