<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:35
 */
//include_once "../../l1comvm/vmlayer.php";
include_once "dbi_l3apl_f5fm.class.php";

class classTaskL3aplF5fm
{
    //构造函数
    public function __construct()
    {

    }

    function _encode($arr)
    {
        $na = array();
        foreach ( $arr as $k => $value ) {
            $na[_urlencode($k)] = _urlencode ($value);
        }
        return addcslashes(urldecode(json_encode($na)),"\r\n");
    }

    function _urlencode($elem)
    {
        $na = 0;
        if(is_array($elem)&&(!empty($elem))){
            foreach($elem as $k=>$v){
                $na[_urlencode($k)] = _urlencode($v);
            }
            return $na;
        }
        if(is_array($elem)&&empty($elem)){
            return $elem;
        }
        return urlencode($elem);
    }

    function func_dev_alarm_process($StatCode)
    {
        $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
        $alarmlist = $uiF3dmDbObj->dbi_dev_currentvalue_req($StatCode);
        if(!empty($alarmlist))
            $retval=array(
                'status'=>'true',
                'ret'=> $alarmlist
            );
        else
            $retval=array(
                'status'=>'true',
                'ret'=> array()
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_alarm_query_process($id, $StatCode, $date, $type)
    {
        $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
        $result = $uiF3dmDbObj->dbi_dev_alarmhistory_req($StatCode, $date, $type);
        if(!empty($result))
            $retval= array(
                'status'=>"true",
                'StatCode'=> $StatCode,
                'date'=> $date,
                'AlarmName'=> $result["alarm_name"],
                'AlarmUnit'=> $result["alarm_unit"],
                'WarningTarget'=>$result["warning"],
                'minute_head'=>$result["minute_head"],
                'minute_alarm'=> $result["minute_alarm"],
                'hour_head'=>$result["hour_head"],
                'hour_alarm'=> $result["hour_alarm"],
                'day_head'=>$result["day_head"],
                'day_alarm'=> $result["day_alarm"]
            );
        else
            $retval= array(
                'status'=>"false",
                'StatCode'=> $StatCode,
                'date'=> $date,
                'AlarmName'=> $type,
                'AlarmUnit'=> null,
                'WarningTarget'=> null,
                'minute_head'=> null,
                'minute_alarm'=> null,
                'hour_head'=> null,
                'hour_alarm'=> null,
                'day_head'=> null,
                'day_alarm'=> null
            );

        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }



    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l3apl_f5fm_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());
        $project ="";

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3APPL_FUM5FM", "mfun_l3apl_f5fm_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到L3APPL_F5FM，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3APPL_FUM5FM", "mfun_l3apl_f5fm_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        //功能Dev Alarm
        if ($msgId == MSG_ID_L4AQYCUI_TO_L3F5_DEVALARM)
        {
            //解开消息
            if (isset($msg["StatCode"])) $StatCode = $msg["StatCode"]; else  $StatCode = "";
            //具体处理函数
            $resp = $this->func_dev_alarm_process($StatCode);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能Alarm Query
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F5_ALARMQUERY)
        {
            //解开消息
            if (isset($msg["id"])) $id = $msg["id"]; else  $id = "";
            if (isset($msg["StatCode"])) $StatCode = $msg["StatCode"]; else  $StatCode = "";
            if (isset($msg["date"])) $date = $msg["date"]; else  $date = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            $input = array("id" => $id, "StatCode" => $StatCode, "date" => $date, "type" => $type);
            //具体处理函数
            $resp = $this->func_alarm_query_process($id, $StatCode, $date, $type);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }


        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, "MFUN_TASK_ID_L3APPL_FUM5FM", $log_time, $log_content);
            echo trim($resp); //这里需要编码送出去，跟其他处理方式还不太一样
        }

        //返回
        return true;
    }

}//End of class_task_service

?>