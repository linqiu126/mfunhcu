<?php
/**
 * Created by PhpStorm.
 * User: zehongli
 * Date: 2015/12/9
 * Time: 23:09
 */
include_once "../l1comvm/vmlayer.php";
include_once "../l2sdk/dbi_l2sdk_iot_com.class.php";

//HCU硬件设备级 Layer 2 SDK
//TASK_ID = MFUN_TASK_ID_L2SDK_IOT_STDXML
class classTaskL2sdkIotStdxml
{
    //构造函数
    public function __construct()
    {

    }

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
        $pdu =  $pHeader .$pduLen .$dataField . $crc . $cr . $lf;
        $resp = pack("A*",$pdu);
        //var_dump($resp);

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

    function getStrBetween($kw1,$mark1,$mark2)
    {
        $kw=$kw1;
        $kw='123'.$kw.'123';
        $st =stripos($kw,$mark1);
        $ed =stripos($kw,$mark2);
        if(($st==false||$ed==false)||$st>=$ed)
            return 0;
        $kw=substr($kw,($st+1),($ed-$st-1));
        return $kw;
    }

    //暂时保留，后面根据需要通过不同的socket端口接收，移到对应的IOT模块处理
    //处理环保局要求格式的消息
    public function receive_hcu_zhbMessage($parObj, $project, $log_from, $pdu)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

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
            case MFUN_L2SDK_IOTHCU_ZHB_NOM_FRAME:
                $sdu_format = "A20QN/A5ST/A7CN/A12MN/A6PW/A4PNUM/A4PNO";
                $temp = unpack($sdu_format, $sdu_body);
                $pnum = $temp['PNUM']; //总包号
                $pno = $temp['PNO']; //包号
                $fix_len = $fix_len + 4 + 4; //=20+5+7+12+6+4+4
                $dataLen =$pduLen - $fix_len;
                $data = substr($sdu_body, $fix_len, $dataLen);  //数据区的处理等规范业务逻辑明确后再处理
                $resp = $this->dummy_data_response($mn);
                break;
            case MFUN_L2SDK_IOTHCU_ZHB_HRB_FRAME:
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

        //ECHO回去，即使是空的，也一并记录下来，说明处理有问题，或者本来就应该返回空内容
        $log_content = "T:" . json_encode($resp);
        $loggerObj->logger($project, $log_from, $log_time, $log_content);
        echo trim($resp);

        //返回
        return true;
    }//receive_hcu_ZhbMsg处理结束

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    //错误的地方，是否需要采用exit过程，待定
    public function mfun_l2sdk_iot_stdxml_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project = MFUN_PRJ_HCU_STDXML;
        $log_time = date("Y-m-d H:i:s", time());

        //入口消息内容判断
        if (empty($msg) == true) {
            $loggerObj->logger("MFUN_TASK_ID_L2SDK_IOT_STDXML", "mfun_l2sdk_iot_stdxml_task_main_entry", $log_time, "R: Received null message body.");
            echo "";
            return false;
        }
        if (($msgId != MSG_ID_L1VM_TO_L2SDK_IOT_STDXML_INCOMING) || ($msgName != "MSG_ID_L1VM_TO_L2SDK_IOT_STDXML_INCOMING")){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SDK_IOT_STDXML", "mfun_l2sdk_iot_stdxml_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        if (isset($msg["socketid"])) $socketid = $msg["socketid"]; else  $socketid = "";
        if (isset($msg["data"])) $data = $msg["data"]; else  $data = "";

        //正式处理消息格式和消息内容的过程
        //FHYS测试时发现有多条xml消息粘连在一起的情况，此处加保护保证只取第一条完整xml消息
        $data = $this->getStrBetween($data,"<xml>","</xml>");
        $xmlmsg = "<" . $data . "</xml>";
        libxml_disable_entity_loader(true);  //prevent XML entity injection
        $postObj = simplexml_load_string($xmlmsg, 'SimpleXMLElement');  //防止破坏CDATA的内容，进而影响智能硬件L3消息体
        //$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $textTpl = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                <FuncFlag>0</FuncFlag></xml>";

        //XML消息解码
        $toUser = trim($postObj->ToUserName);
        $fromUser = trim($postObj->FromUserName);
        $createTime = trim($postObj->CreateTime);
        $msgType = trim($postObj->MsgType);
        $content = trim($postObj->Content);
        $funcFlag = trim($postObj->FuncFlag);

        //对接收内容进行log记录
        $log_content = "R:" . trim($xmlmsg);
        $loggerObj->logger($project, $fromUser, $log_time, $log_content);

        //取DB中的硬件信息，判断FromUser合法性
        $dbiL2sdkIotcomObj = new classDbiL2sdkIotcom();
        $statCode = $dbiL2sdkIotcomObj->dbi_hcuDevice_valid_device($fromUser); //FromUserName对应每个HCU硬件的设备编号
        if (empty($statCode)){
            $result = "IOT_STDXML: invalid FromUserName = ".$fromUser;
            $log_content = "T:" . json_encode($result);
            $loggerObj->logger($project, $fromUser, $log_time, $log_content);
            return true;
        }

        //判断ToUser合法性
        if ($toUser != MFUN_CLOUD_HCU ){
            $result = "IOT_STDXML: invalid ToUserName = ".$toUser;
            $log_content = "T:" . json_encode($result);
            $loggerObj->logger($project, $toUser, $log_time, $log_content);
            echo trim($result);
            return true;
        }

        //将socket id和设备ID（fromUser）进行绑定
        if(!empty($socketid) AND !empty($statCode)){
            $dbiL2sdkIotcomObj = new classDbiL2sdkIotcom();
            $dbiL2sdkIotcomObj->dbi_huitp_huc_socketid_update($fromUser, $socketid);
        }

        //消息或者说帧类型分离，l2SDK只进行XML类型解码，不对消息的content进行处理,Content处理在具体的L2sensor模块
        switch ($msgType) {
            case "hcu_text":
                $msg = array("project" => $project,
                    "platform" => MFUN_TECH_PLTF_HCUSTM,
                    "devCode" => $fromUser,
                    "statCode" => $statCode,
                    "content" => $content,
                    "funcFlag" => $funcFlag);
                if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_IOT_STDXML,
                        MFUN_TASK_ID_L2SENSOR_DOORLOCK,
                        MSG_ID_L2SDK_HCU_TO_L2SNR_DOORLOCK,
                        "MSG_ID_L2SDK_HCU_TO_L2SNR_DOORLOCK",
                        $msg) == false) $resp = "Send to message buffer error";
                else $resp = "";
                break;
            case "hcu_pic":
                $msg = array("project" => $project,
                    "platform" => MFUN_TECH_PLTF_HCUSTM,
                    "devCode" => $fromUser,
                    "statCode" => $statCode,
                    "content" => $content,
                    "funcFlag" => $funcFlag);
                if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SDK_IOT_STDXML,
                        MFUN_TASK_ID_L2SENSOR_HSMMP,
                        MSG_ID_L2SDK_HCU_TO_L2SNR_HSMMP,
                        "MSG_ID_L2SDK_HCU_TO_L2SNR_HSMMP",
                        $msg) == false) $resp = "Send to message buffer error";
                else $resp = "";
                break;
            default:
                //收内容存储
                $resp = "[STDXML]unknown message type: " . $msgType;
                break;
        }

        //处理结果
        if (!empty($resp)) {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, $fromUser, $log_time, $log_content);
        }
        //结束，返回
        return true;
    }

}

?>