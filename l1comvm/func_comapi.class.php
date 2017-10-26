<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2016/6/20
 * Time: 12:06
 */

class classApiL1vmFuncCom
{
    //构造函数
    public function __construct()
    {

    }

    //日志记录
    public function logger($project,$fromUser,$createTime,$log_content)
    {
        /*
        if(isset($_SERVER['HTTP_APPNAME'])){   //SAE
            sae_set_display_errors(false);
            sae_debug($log_content);
            sae_set_display_errors(true);
        }else if($_SERVER['REMOTE_ADDR'] != "127.0.0.1"){ //LOCAL
            $max_size = 10000;
            $log_filename = "log.xml";
            if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
            file_put_contents($log_filename, date('H:i:s')." ".$log_content."\r\n", FILE_APPEND);
        }
        */
        //存储log在数据库中
        $cDbObj = new classDbiL1vmCommon();
        $result = $cDbObj->dbi_log_process_save($project,$fromUser,$createTime,$log_content);

        return $result;
    }

    public function mylog($project,$fromUser,$srcName,$destName,$msgId,$logData)
    {
        //存储log在数据库中
        $dbiL1vmCommonObj = new classDbiL1vmCommon();
        $result = $dbiL1vmCommonObj->dbi_l1comvm_syslog_save($project,$fromUser,$srcName,$destName,$msgId,$logData);

        return $result;
    }

    //MODULE TRACE查询
    public function trace_module_inqury($moduleId)
    {
        $obj = new classDbiL1vmCommon();
        $result = $obj->dbi_logtrace_module_inqury($moduleId);
        return $result;
    }

    //MESSAGE TRACE查询
    public function trace_msg_inqury($msgId)
    {
        $obj = new classDbiL1vmCommon();
        $result = $obj->dbi_logtrace_msg_inqury($msgId);
        return $result;
    }

}


?>