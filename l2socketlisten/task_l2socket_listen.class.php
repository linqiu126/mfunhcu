<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/7/4
 * Time: 21:46
 */
include_once "../l1comvm/vmlayer.php";

class classTaskL2SocketListen
{
    //构造函数
    public function __construct()
    {

    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2socket_listen_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SOCKET_LISTEN", "mfun_l2socket_listen_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        else{
            //解开消息
            if (isset($msg["socketid"])) $socketid = $msg["socketid"]; else  $socketid = "";
            if (isset($msg["data"])) $data = $msg["data"]; else  $data = "";
        }

        //多条消息发送到L2SOCKET_LISTEN，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId != MSG_ID_L2SOCKET_LISTEN_DATA_COMING) || ($msgName != "MSG_ID_L2SOCKET_LISTEN_DATA_COMING")){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SOCKET_LISTEN", "mfun_l2socket_listen_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        $project = MFUN_PRJ_HCU_HEXDATA;
        $statCode = "";

        //图片HEX数据来自MFUN_SWOOLE_SOCKET_DATA_STREAM_TCP端口，数据格式定义如下：
        //0-19字节为设备ID，现在的DEVCODE为19个字符，第20个字符为填充，20～23字节为数据长度，4B，后面的数据为照片Hex码流
        if ($msgId == MSG_ID_L2SOCKET_LISTEN_DATA_COMING)
        {
            $filename = "";
            $picname = "";
            //解析设备ID
            for($i=0; $i<HUITP_IEID_UNI_CCL_GEN_PIC_ID_LEN_MAX; $i++){
                $filename = $filename. chr(hexdec(substr($data, $i*2, 2)));
                $picname = trim($filename, "_").MFUN_HCU_SITE_PIC_FILE_TYPE;
            }

            //查询开锁记录表，通过事先生成的文件名找到对应的站点
            $dbiL2snrHsmmpObj = new classDbiL2snrHsmmp();
            $statCode = $dbiL2snrHsmmpObj->dbi_fhys_locklog_picture_name_inqury($picname);

            if (empty($statCode)){
                $result = "L2SOCKET_LISTEN: reecive invalid picnmae = ".$picname;
                $log_content = "T:" . json_encode($result);
                $loggerObj->logger($project, MFUN_TASK_ID_L2SOCKET_LISTEN, $log_time, $log_content);
                return true;
            }

            //解析HEX Content
            $content = substr($data, (HUITP_IEID_UNI_CCL_GEN_PIC_ID_LEN_MAX + 4)*2); //扣除32B picname + 4B Length

            $msg = array("project" => $project,
                "platform" => MFUN_TECH_PLTF_HCUSTM,
                "picname" => $picname,
                "statCode" => $statCode,
                "content" => $content);
            if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L2SOCKET_LISTEN,
                    MFUN_TASK_ID_L2SENSOR_HSMMP,
                    MSG_ID_L2SOCKET_TO_L2SNR_HSMMP,
                    "MSG_ID_L2SOCKET_TO_L2SNR_HSMMP",
                    $msg) == false) $resp = "Send to message buffer error";
            else $resp = "";
        }

        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger("L2SOCKETLISTEN", "MFUN_TASK_ID_L2SOCKET_LISTEN", $log_time, $log_content);
            echo trim($resp);
        }

        //返回
        return true;
    }

}//End of class_task_service
