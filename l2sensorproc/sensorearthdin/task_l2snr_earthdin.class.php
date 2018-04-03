<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/25
 * Time: 10:31
 */

class classTaskL2snrEarthdin
{
    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l2snr_earthdin_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project= MFUN_PRJ_HCU_JSON;

        //入口消息内容判断
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog($project,"NULL","MFUN_TASK_ID_L2SDK_IOT_JSON","MFUN_TASK_ID_L2SENSOR_EARTHDIN",$msgName,$log_content);
            return false;
        }
        else{
            //解开消息
            if (isset($msg["project"])) $project = $msg["project"]; else $project= "";;
            if (isset($msg["devCode"])) $devCode = $msg["devCode"]; else $devCode="";
            if (isset($msg["jsonMsgId"])) $jsonMsgId = $msg["jsonMsgId"]; else $jsonMsgId="";
            if (isset($msg["statCode"])) $statCode = $msg["statCode"]; else $statCode = "";
            if (isset($msg["content"])) $content = $msg["content"]; else $content="";
        }

        if ($jsonMsgId == HUITP_JSON_MSGID_uni_mxiot_earthquake_data_report)
        {

        }
        else{
            $resp ="E: received invalid MSGID!";
        }

        if (!empty($resp)) {
            $log_content = json_encode($resp,JSON_UNESCAPED_UNICODE);
            $loggerObj->mylog($project,$devCode,"MFUN_TASK_ID_L2SENSOR_EARTHDIN","NULL",$msgName,$log_content);
        }

        //返回
        return true;
    }
}


?>