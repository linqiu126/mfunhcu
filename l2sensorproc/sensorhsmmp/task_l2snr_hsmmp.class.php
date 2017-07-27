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

    public function func_hsmmp_process($platform, $project, $devCode, $statCode, $content, $funcFlag)
    {
        switch($platform)
        {
            case MFUN_TECH_PLTF_WECHAT:   //微信有专门的video消息类型，这里暂时定义一个空操作保持结构的完整性
                $length = hexdec(substr($content, 2, 2)) & 0xFF;
                $length = ($length + 2)*2; //消息总长度等于length＋1B 控制字＋1B长度本身
                if ($length != strlen($content)){
                    return "VIDEO_SERVICE[WX]: message length invalid";  //消息长度不合法，直接返回
                }
                $sub_key = hexdec(substr($content, 4, 2)) & 0xFF;
                switch ($sub_key) //MODBUS操作字处理
                {
                    case MFUN_HCU_OPT_VEDIOLINK_RESP:
                        $resp = $this->wx_hsmmp_req_process($devCode, $content,$funcFlag);
                        break;
                    case MFUN_HCU_OPT_VEDIOFILE_RESP:
                        $resp = "";
                        break;

                    default:
                        $resp = "";
                        break;
                }
                break;
            case MFUN_TECH_PLTF_HCUGX:
                $raw_MsgHead = substr($content, 0, MFUN_HCU_MSG_HEAD_LENGTH);  //截取3Byte MsgHead
                $msgHead = unpack(MFUN_HCU_MSG_HEAD_FORMAT, $raw_MsgHead);

                $length = hexdec($msgHead['Len']) & 0xFF;
                $length =  ($length+2) * 2; //因为收到的消息为16进制字符，消息总长度等于length＋1B控制字＋1B长度本身
                if ($length != strlen($content)) {
                    return "VIDEO_SERVICE[HCU]: message length invalid";  //消息长度不合法，直接返回
                }
                $data = substr($content, MFUN_HCU_MSG_HEAD_LENGTH, $length - MFUN_HCU_MSG_HEAD_LENGTH);//截取消息数据域

                $opt_key = hexdec($msgHead['Cmd']) & 0xFF;
                switch ($opt_key) //操作字处理
                {
                    case MFUN_HCU_OPT_VEDIOLINK_RESP:
                        $resp = $this->hcu_videolink_resp_process($devCode, $data, $funcFlag);
                        break;
                    case MFUN_HCU_OPT_VEDIOFILE_RESP:
                        $resp = $this->hcu_videofile_resp_process($devCode, $data, $funcFlag);
                        break;
                    default:
                        $resp = "";
                        break;
                }
                break;
            case MFUN_TECH_PLTF_HCUSTM: //HCU单片机STM32平台
                $content = pack("H*", $content); //将收到的16进制字符串pack成HEX data
                $loggerObj = new classApiL1vmFuncCom();
                $timestamp = time();
                $log_time = date("Y-m-d H:i:s", $timestamp);
                $file_type = ".jpg";
                $result = "";
                if ($funcFlag == "01"){ //第一包数据，创建一个新JPG文件
                    if(!file_exists(MFUN_HCU_SITE_PIC_BASE_DIR.$statCode.'/upload/'))
                        $result = mkdir(MFUN_HCU_SITE_PIC_BASE_DIR.$statCode.'/upload/',0777,true);
                    $filename = $statCode . "_" . $timestamp . $file_type;
                    $filelink = MFUN_HCU_SITE_PIC_BASE_DIR.$statCode.'/upload/'.$filename;
                    $newfile = fopen($filelink, "wb+") or die("Unable to open file!");
                    $filesize = fwrite($newfile, $content);
                    fclose($newfile);

                    //保存图片名到最后一次开锁记录表中
                    $dbiL2snrHsmmpObj = new classDbiL2snrHsmmp();
                    $result = $dbiL2snrHsmmpObj->dbi_fhys_locklog_picture_name_save($statCode, $filename);

                    //保存图片的信息到picturedata表中
                    if ($filesize){
                        //$base_dir = str_replace( '\\' , '/' , realpath(dirname(__FILE__).'/../../../avorion'));
                        $filename = $statCode . "_" . $timestamp . $file_type;
                        $loggerObj->logger($project, $devCode, $log_time, "上传新图片文件".$filename);
                        //$result = $dbiL2snrHsmmpObj->dbi_door_open_picture_link_save($statCode, $devCode, $timestamp, $filename,$filesize);
                    }
                }
                else{ //往最新的文件里追加写内容
                    $lastfile_time = 0; //初始化
                    $lastfile_name = "";
                    $file_path = MFUN_HCU_SITE_PIC_BASE_DIR.$statCode.'/upload/';
                    foreach(glob($file_path."*".$file_type) as $filename) {
                        if (!(is_dir($filename))) { //是个文件而不是目录
                            $filetime = filemtime($filename);  //获取文件修改时间
                            if ($filetime >= $lastfile_time){
                                $lastfile_time = $filetime;
                                $lastfile_name = $filename;
                            }
                        }
                    }

                    if (!empty($lastfile_name)){
                        $oldfile = fopen($lastfile_name, "ab") or die("Unable to open file!");
                        $filesize = fwrite($oldfile, $content);
                        fclose($oldfile);

                        //更新picturedata表中图片的size
                        /*
                        if ($filesize){
                            $pos = strripos($lastfile_name, "/");
                            $filename = substr($lastfile_name, $pos+1); //位置加1去除目录字符'/'
                            $dbiL2snrHsmmpObj = new classDbiL2snrHsmmp();
                            $result = $dbiL2snrHsmmpObj->dbi_door_open_picture_filesize_update($statCode, $devCode, $timestamp, $filename, $filesize);
                        }*/
                    }
                }

                $resp = "";
                break;
            case MFUN_TECH_PLTF_JDIOT:
                $resp = ""; //no response message
                break;
            default:
                $resp = "VIDEO_SERVICE: PLTF invalid";
                break;
        }
        return $resp;
    }

    private function func_pic_hexdata_process($project,$devCode,$statCode,$content)
    {
        $loggerObj = new classApiL1vmFuncCom();
        $timestamp = time();
        $log_time = date("Y-m-d H:i:s", $timestamp);
        $file_type = ".jpg";

        if(!file_exists(MFUN_HCU_SITE_PIC_BASE_DIR.$statCode.'/upload/'))
            $result = mkdir(MFUN_HCU_SITE_PIC_BASE_DIR.$statCode.'/upload/',0777,true);
        $filename = $statCode . "_" . $timestamp . $file_type;
        $filelink = MFUN_HCU_SITE_PIC_BASE_DIR.$statCode.'/upload/'.$filename;
        $newfile = fopen($filelink, "wb+") or die("Unable to open file!");
        $filesize = fwrite($newfile, $content);
        fclose($newfile);

        //保存图片名到最后一次开锁记录表中
        $dbiL2snrHsmmpObj = new classDbiL2snrHsmmp();
        $result = $dbiL2snrHsmmpObj->dbi_fhys_locklog_picture_name_save($statCode, $filename);

        //保存图片的信息到picturedata表中
        if ($filesize){
            //$base_dir = str_replace( '\\' , '/' , realpath(dirname(__FILE__).'/../../../avorion'));
            $filename = $statCode . "_" . $timestamp . $file_type;
            $loggerObj->logger($project, $devCode, $log_time, "上传新图片文件".$filename);
            //$result = $dbiL2snrHsmmpObj->dbi_door_open_picture_link_save($statCode, $devCode, $timestamp, $filename,$filesize);
        }

        return $result;
    }

    //微信平台暂时不支持
    private function wx_hsmmp_req_process( $devCode, $content, $funcFlag)
    {
        $resp = ""; //no response message
        return $resp;
    }

    private function hcu_videolink_resp_process( $devCode,$content,$funcFlag)
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

        $dbiL2snrHsmmpObj = new classDbiL2snrHsmmp();
        $dbiL2snrHsmmpObj->dbi_video_data_save($devCode, $sensorId, $timeStamp, $funcFlag,$gps);

        $resp = ""; //no response message
        return $resp;
    }

    private function hcu_videofile_resp_process($devCode, $content, $funcFlag)
    {
        $format = "A2Type/A2Status";
        $data = unpack($format, $content);
        $status = hexdec($data["Status"]) & 0xFF;
        $videoid = $funcFlag;
        $dbiL2snrHsmmpObj = new classDbiL2snrHsmmp();
        $dbiL2snrHsmmpObj->dbi_video_data_status_update($devCode, $status, $videoid);

        $resp = ""; //no response message
        return $resp;
    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2snr_hsmmp_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        $project = "";
        $platform = "";
        $devCode = "";
        $statCode = "";
        $content = "";
        $funcFlag = "";
        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SENSOR_HSMMP", "mfun_l2snr_hsmmp_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        else{
            //解开消息
            if (isset($msg["project"])) $project = $msg["project"];
            if (isset($msg["platform"])) $platform = $msg["platform"];
            if (isset($msg["devCode"])) $devCode = $msg["devCode"];
            if (isset($msg["statCode"])) $statCode = $msg["statCode"];
            if (isset($msg["content"])) $content = $msg["content"];
            if (isset($msg["funcFlag"])) $funcFlag = $msg["funcFlag"];
        }

        if (($msgId != MSG_ID_L2SDK_HCU_TO_L2SNR_HSMMP) AND ($msgName != MSG_ID_L2SOCKET_TO_L2SNR_HSMMP)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SENSOR_HSMMP", "mfun_l2snr_hsmmp_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        switch($msgId)
        {
            case MSG_ID_L2SDK_HCU_TO_L2SNR_HSMMP:
                //具体处理函数
                $resp = $this->func_hsmmp_process($platform, $project, $devCode, $statCode, $content,$funcFlag);
                break;
            case MSG_ID_L2SOCKET_TO_L2SNR_HSMMP:
                $resp = $this->func_pic_hexdata_process($project,$devCode,$statCode,$content);
                break;
            default:
                $resp = "";
                break;
        }

        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, $devCode, $log_time, $log_content);
        }

        //返回
        return true;
    }

}

?>