<?php
/**
 * Created by PhpStorm.
 * User: zehongl
 * Date: 2016/11/7
 * Time: 21:36
 */


include_once "dbi_l2snr_ccl.class.php";

class classTaskL2snrCcl
{
    //构造函数
    public function __construct()
    {

    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2snr_ccl_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //初始化消息内容
        $project= "";
        $log_from = "";
        $platform ="";
        $devCode="";
        $statCode = "";
        $content="";

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L2SENSOR_CCL", "mfun_l2snr_ccl_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        else{
            //解开消息
            if (isset($msg["project"])) $project = $msg["project"];
            if (isset($msg["log_from"])) $log_from = $msg["log_from"];
            if (isset($msg["platform"])) $platform = $msg["platform"];
            if (isset($msg["devCode"])) $devCode = $msg["devCode"];
            if (isset($msg["statCode"])) $statCode = $msg["statCode"];
            if (isset($msg["content"])) $content = $msg["content"];
        }

        switch($msgId)
        {
            case HUITP_MSGID_uni_ccl_lock_resp:
                $dbiL2snrCclObj = new classDbiL2snrCcl();
                $resp = $dbiL2snrCclObj->dbi_huitp_msg_uni_ccl_lock_resp($devCode, $statCode, $content);
                break;
            case HUITP_MSGID_uni_ccl_lock_report:
                $dbiL2snrCclObj = new classDbiL2snrCcl();
                $resp = $dbiL2snrCclObj->dbi_huitp_msg_uni_ccl_lock_report($devCode, $statCode, $content);
                break;
            case HUITP_MSGID_uni_ccl_lock_auth_inq:
                $dbiL2snrCclObj = new classDbiL2snrCcl();
                $resp = $dbiL2snrCclObj->dbi_huitp_msg_uni_ccl_auth_inq($devCode, $statCode, $content);
                break;
            case HUITP_MSGID_uni_ccl_state_resp:
                $dbiL2snrCclObj = new classDbiL2snrCcl();
                $resp = $dbiL2snrCclObj->dbi_huitp_msg_uni_ccl_state_resp($devCode, $statCode, $content);
                break;

            case HUITP_MSGID_uni_ccl_state_report:
                $dbiL2snrCclObj = new classDbiL2snrCcl();
                $resp = $dbiL2snrCclObj->dbi_huitp_msg_uni_ccl_state_report($devCode, $statCode, $content);
                break;
            case HUITP_MSGID_uni_ccl_state_pic_report:
                break;
            default:
                $resp = ""; //啥都不ECHO
                break;
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, $log_from, $log_time, $log_content);
            echo trim($resp);
        }

        //返回
        return true;
    }

}//End of class_task_service

?>