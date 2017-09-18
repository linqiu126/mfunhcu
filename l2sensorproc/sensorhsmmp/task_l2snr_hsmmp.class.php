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

    public function func_fhys_picture_chardata_process($devCode, $statCode, $content, $funcFlag)
    {
        $content = pack("H*", $content); //将收到的16进制字符串pack成HEX data
        $timeStamp = time();
        $log_time = date("Y-m-d H:i:s", $timeStamp);
        $dbiL2snrHsmmpObj = new classDbiL2snrHsmmp();

        if ($funcFlag == "01"){ //第一包数据，创建一个新JPG文件
            if(!file_exists(MFUN_HCU_SITE_PIC_BASE_DIR.$statCode))
                $result = mkdir(MFUN_HCU_SITE_PIC_BASE_DIR.$statCode,0777,true);
            $picName = $statCode . "_" . $timeStamp . MFUN_HCU_SITE_PIC_FILE_TYPE;
            $picLink = MFUN_HCU_SITE_PIC_BASE_DIR.$statCode."/".$picName;
            $file_handle = fopen($picLink, "wb+") or die("Unable to open file!");
            $picSize = fwrite($file_handle, $content);
            fclose($file_handle);

            if ($picSize){
                //保存图片名到最后一次开锁记录表中
                $result = $dbiL2snrHsmmpObj->dbi_fhys_locklog_picture_name_save($timeStamp,$statCode, $picName);

                //保存图片的信息到picturedata表中
                $result = $dbiL2snrHsmmpObj->dbi_door_open_picture_info_save($devCode,$statCode, $picName, $picSize);

                $resp = "来自设备".$devCode."上传的照片第".$funcFlag."帧保存成功";
            }
            else
                $resp = "来自设备".$devCode."上传的照片第".$funcFlag."帧保存失败";
        }
        else{ //往最新的文件里追加写内容
            $lastfile_time = 0; //初始化
            $lastfile_name = "";
            $file_path = MFUN_HCU_SITE_PIC_BASE_DIR.$statCode;
            foreach(glob($file_path."*".MFUN_HCU_SITE_PIC_FILE_TYPE) as $filename) {
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
                $picSize = fwrite($oldfile, $content);
                fclose($oldfile);

                //更新picturedata表中图片的size
                if ($picSize){
                    $pos = strripos($lastfile_name, "/");
                    $picName = substr($lastfile_name, $pos+1); //位置加1去除目录字符'/'
                    $result = $dbiL2snrHsmmpObj->dbi_door_open_picture_info_save($devCode,$statCode, $picName, $picSize);
                    $resp = "来自设备".$devCode."上传的照片第".$funcFlag."帧保存成功";
                }
                else
                    $resp = "来自设备".$devCode."上传的照片第".$funcFlag."帧保存失败";
            }
            else
                $resp = "来自设备".$devCode."上传的照片第".$funcFlag."帧保存失败";
        }

        return $resp;
    }


    private function func_fhys_picture_hexdata_process($devCode,$statCode,$picName,$picSize,$content)
    {
        //$content = pack("H*", $content); //将收到的16进制字符串pack成HEX data

        if(!file_exists(MFUN_HCU_SITE_PIC_BASE_DIR.$statCode))
            $result = mkdir(MFUN_HCU_SITE_PIC_BASE_DIR.$statCode,0777,true);

        $filelink = MFUN_HCU_SITE_PIC_BASE_DIR.$statCode."/".$picName;
        $file_handle = fopen($filelink, "wb+") or die("Unable to open file!");
        for ($i=0; $i<$picSize; $i++)
            fwrite($file_handle, $content[$i]);

        fclose($file_handle);

        //保存图片的信息到picturedata表中
        $dbiL2snrHsmmpObj = new classDbiL2snrHsmmp();
        $result = $dbiL2snrHsmmpObj->dbi_door_open_picture_info_save($devCode,$statCode, $picName,$picSize);
        $resp = "来自设备".$devCode."上传的照片保存成功";

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
        $picName = "";
        $picSize = 0;
        $statCode = "";
        $content = "";
        $funcFlag = "";
        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SENSOR_HSMMP", "mfun_l2snr_hsmmp_task_main_entry", $log_time, $log_content);
            return false;
        }
        else{
            //解开消息
            if (isset($msg["project"])) $project = $msg["project"];
            if (isset($msg["platform"])) $platform = $msg["platform"];
            if (isset($msg["devCode"])) $devCode = $msg["devCode"];
            if (isset($msg["picname"])) $picName = $msg["picname"];
            if (isset($msg["picsize"])) $picSize = intval($msg["picsize"]);
            if (isset($msg["statCode"])) $statCode = $msg["statCode"];
            if (isset($msg["content"])) $content = $msg["content"];
            if (isset($msg["funcFlag"])) $funcFlag = $msg["funcFlag"];
        }

        switch($msgId)
        {
            //来自STDXML IOT，通过ASCII码传送的照片数据，兼容FHYS的图片消息hcu_pic
            case MSG_ID_L2SDK_HCU_TO_L2SNR_HSMMP:
                $resp = $this->func_fhys_picture_chardata_process($devCode, $statCode, $content, $funcFlag);
                break;
            //来自L2socket，通过Hex码流发送的照片数据，适应于新的CCL
            case MSG_ID_L2SOCKET_TO_L2SNR_HSMMP:
                if ($picSize != 0)
                    $resp = $this->func_fhys_picture_hexdata_process($devCode,$statCode,$picName,$picSize,$content);
                else
                    $resp = "来自设备".$devCode."上传的照片保存失败,照片大小为0";
                break;
            case HUITP_MSGID_uni_picture_data_report:
                $dbiL2snrHsmmpObj = new classDbiL2snrHsmmp();
                $respHuitpMsg = $dbiL2snrHsmmpObj->dbi_huitp_msg_uni_picture_data_report($devCode, $statCode, $content);

                //发送HUITP_MSGID_uni_picture_data_confirm
                if (!empty($respHuitpMsg)) {
                    $msg = array("project" => $project,
                        "platform" => MFUN_TECH_PLTF_HCUGX_HUITP,
                        "devCode" => $devCode,
                        "respMsg" => HUITP_MSGID_uni_picture_data_confirm,
                        "content" => $respHuitpMsg);
                    if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SENSOR_HSMMP,
                            MFUN_TASK_ID_L2ENCODE_HUITP,
                            MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING,
                            "MSG_ID_L2CODEC_ENCODE_HUITP_INCOMING",
                            $msg) == false
                    ) $resp = "Send to message buffer error";
                    else $resp = "";
                }
                break;
            default:
                $resp = "";
                break;
        }

        if (!empty($resp)){
            $log_content = "R:" . json_encode($resp,JSON_UNESCAPED_UNICODE);
            $loggerObj->logger($project, $devCode, $log_time, $log_content);
        }

        //返回
        return true;
    }

}

?>