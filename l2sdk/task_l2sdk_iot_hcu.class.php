<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2015/12/9
 * Time: 23:09
 */
include_once "../l1comvm/vmlayer.php";
include_once "../l2sdk/dbi_l2sdk_iot_hcu.class.php";

//HCU硬件设备级 Layer 2 SDK
//TASK_ID = MFUN_TASK_ID_L2SDK_IOT_HCU
class classTaskL2sdkIotHcu
{
    //构造函数
    public function __construct()
    {

    }

    //业务消息“XML格式”的处理函数，跳转到对应的业务处理模块
    public function receive_hcu_xmlMessage($parObj, $data)
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

        //取DB中的硬件信息，判断基本信息
        $cDbObj = new classL1vmCommonDbi();
        $result = $cDbObj->dbi_hcuDevice_valid_device($deviceId); //FromUserName对应每个HCU硬件的设备编号
        if (empty($result)){
            return "HCU_IOT: invalid device ID";
        }
        else{
            $statCode = $result;
        }
        if ($toUser != MFUN_CLOUD_HCU){
            return "HCU_IOT: XML message invalid ToUserName";
        }
        //解开key，处理CMDID
        $key = unpack('A2Key', $content);
        $ctrl_key = hexdec($key['Key'])& 0xFF;
        switch ($ctrl_key)
        {
            case CMDID_VERSION_SYNC:
                $hcuObj = new classApiL2snrCommonService();
                $resp = $hcuObj->func_version_update_process(PLTF_HCU, $deviceId, $content);
                break;
            case CMDID_TIME_SYNC:
                $hcuObj = new classApiL2snrCommonService();
                $resp = $hcuObj->func_timeSync_process();
                break;
            case CMDID_INVENTORY_DATA:
                $hcuObj = new classApiL2snrCommonService();
                $resp = $hcuObj->func_inventory_data_process(PLTF_HCU,$deviceId, $content);
                break;
            case CMDID_HEART_BEAT:
                $hcuObj = new classApiL2snrCommonService();
                $resp = $hcuObj->func_heartBeat_process();
                break;
            case CMDID_HCU_POLLING:
                $hcuObj = new classApiL2snrCommonService();
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
                    //return "HCU_IOT: video link empty";
                }
                $hcuObj = new class_video_service();
                $resp = $hcuObj->func_video_process(PLTF_HCU, $deviceId, $content,$funcFlag);
                break;
            case CMDID_NOISE_DATA:
                $hcuObj = new class_noise_service();
                $resp = $hcuObj->func_noise_process(PLTF_HCU, $deviceId, $statCode, $content);
                break;
            case CMDID_SW_UPDATE:
                $resp ="";
                break;
            default:
                $resp ="HCU_IOT: invalid command type";
                break;
        }
        return $resp;
    } //receive_hcu_xmlMsg处理结束


    //处理环保局要求格式的消息
    public function receive_hcu_zhbMessage($parObj, $pdu)
    {
        $pdu_format = "A2Header/A4Len";
        $temp = unpack($pdu_format, $pdu);

        $header = $temp['Header'];  //通信包包头
        //$pduLen = hexdec($temp['Len'])& 0xFFFF;//数据段长度
        $pduLen = $temp['Len']& 0xFFFF;//数据段长度

        $sdu_body = substr($pdu, 6, $pduLen); //数据段,变长，0～1024
        $crc = substr($pdu, 6+$pduLen, 4);  //CRC
        //$tail = substr($pdu, 6+$pduLen+4, 2);  //包尾

        //先进行CRC校验，如果失败直接返回
        $result = $this->crc_check($sdu_body,$crc);  //数据段CRC校验
        if ($result == false)
            return "HCU_IOT: ZHB message CRC error";  //CRC校验失败直接返回

        //数据段解码
        $sdu_format = "A20QN/A5ST/A7CN/A12MN/A6PW";
        $fix_len = 20+5+7+12+6;

        $temp = unpack($sdu_format, $sdu_body);


        $qn = trim($temp['QN'], '_');  //请求编号
        $st = trim($temp['ST'], '_');  //系统编号
        $cn = trim($temp['CN'], '_');  //命令编号
        $mn = trim($temp['MN'], '_');  //设备编号
        $pw = trim($temp['PW'], '_');   //访问密码

        switch($cn)
        {
            case ZHB_NOM_FRAME:
                $sdu_format = "A20QN/A5ST/A7CN/A12MN/A6PW/A4PNUM/A4PNO";
                $temp = unpack($sdu_format, $sdu_body);
                $pnum = $temp['PNUM']; //总包号
                $pno = $temp['PNO']; //包号
                $fix_len = $fix_len + 4 + 4; //=20+5+7+12+6+4+4
                $dataLen =$pduLen - $fix_len;
                $data = substr($sdu_body, $fix_len, $dataLen);  //数据区的处理等规范业务逻辑明确后再处理

                $resp = $this->dummy_data_response($mn);
                break;
            case ZHB_HRB_FRAME:
                $sdu_format = "A20QN/A5ST/A7CN/A12MN/A6PW/A3FLAG";
                $temp = unpack($sdu_format, $sdu_body);
                $flag = $temp['FLAG']; //数据是否拆分及应答标志
                $fix_len = $fix_len + 4 ; //=20+5+7+12+6+3
                $cp_len = $pduLen - $fix_len;
                $cp = substr($sdu_body, $fix_len, $cp_len);

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

    //任务入口函数
    public function mfun_l2sdk_iot_hcu_task_main_entry($parObj, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classL1vmFuncComApi();
        $log_time = date("Y-m-d H:i:s", time());

        //入口消息内容判断
        if (empty($msg) == true) {
            echo "";
            $loggerObj->logger("MFUN_TASK_ID_L2SDK_IOT_HCU", "mfun_l2sdk_iot_hcu_task_main_entry", $log_time, "R: Received null message body.");
            return false;
            //exit; //是否需要采用EXIT过程，待定
        }

        //正式处理消息格式和消息内容的过程
        $format = substr(trim($msg), 0, 2);
        switch ($format) {
            case XML_FORMAT:
                libxml_disable_entity_loader(true);  //prevent XML entity injection
                $postObj = simplexml_load_string($msg, 'SimpleXMLElement');  //防止破坏CDATA的内容，进而影响智能硬件L3消息体
                //$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag></xml>";

                $fromUser = trim($postObj->FromUserName);
                $createTime = trim($postObj->CreateTime);
                $log_time = date("Y-m-d H:i:s", $createTime);
                $log_content = "R:" . trim($msg);
                $RX_TYPE = trim($postObj->MsgType);

                //消息或者说帧类型分离
                switch ($RX_TYPE) {
                    case "hcu_text":
                        $project = "HCU";
                        $loggerObj->logger($project, $fromUser, $log_time, $log_content);
                        $log_from = MFUN_CLOUD_HCU;
                        $result = $this->receive_hcu_xmlMessage($parObj, $postObj);
                        break;
                    case "hcu_heart_beat":
                        $project = "HCU";
                        $loggerObj->logger($project, $fromUser, $log_time, $log_content);
                        $log_from = MFUN_CLOUD_HCU;
                        $result = $this->receive_hcu_xmlMessage($parObj, $postObj);
                        break;
                    case "hcu_command":
                        $project = "HCU";
                        $loggerObj->logger($project, $fromUser, $log_time, $log_content);
                        $log_from = MFUN_CLOUD_HCU;
                        $result = $this->receive_hcu_xmlMessage($parObj, $postObj);
                        break;
                    case "hcu_polling":
                        $project = "HCU";
                        $loggerObj->logger($project, $fromUser, $log_time, $log_content);
                        $log_from = MFUN_CLOUD_HCU;
                        $result = $this->receive_hcu_xmlMessage($parObj, $postObj);
                        break;
                    default:
                        $project = "NULL";
                        $loggerObj->logger($project, $fromUser, $log_time, $log_content);
                        $log_from = "CLOUD_NONE";
                        $result = "[XML_FORMAT]unknown message type: " . $RX_TYPE;
                        break;
                }
                break;
            case ZHB_FORMAT:
                $project = "HCU";
                $fromUser = "ZHBMSG";
                $timestamp = time();
                $log_time = date("Y-m-d H:i:s", $timestamp);
                $log_content = "R:" . trim($msg);
                $loggerObj->logger($project, $fromUser, $log_time, $log_content); //ZHB接收消息log保存
                $log_from = MFUN_CLOUD_HCU;
                $result = $this->receive_hcu_zhbMessage($parObj, $msg);
                break;
            default:
                $result = "Unknown message format";
                $project = "NULL";
                $log_from = "CLOUD_NONE";
                break;
        }

        //处理结果
        if (!empty($result)) {
            $timestamp = time();
            $log_time = date("Y-m-d H:i:s", $timestamp);
            $log_content = "T:" . json_encode($result);
            $loggerObj->logger($project, $log_from, $log_time, $log_content);
            echo trim($result);
        }

        //结束，返回
        return true;
    }//End of 任务入口函数

}

?>