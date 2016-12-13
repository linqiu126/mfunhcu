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

    function func_aqyc_dev_alarm_process($type, $user, $body)
    {
        if (isset($body["StatCode"])) $StatCode = $body["StatCode"]; else  $StatCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($type, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
            $alarmlist = $uiF3dmDbObj->dbi_aqyc_dev_currentvalue_req($StatCode);
            if(!empty($alarmlist))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$alarmlist,'msg'=>"获取该站点下当前设备测量信息成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取该站点下当前设备测量信息失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_alarm_query_process($type, $user, $body)
    {
        if (isset($body["StatCode"])) $StatCode = $body["StatCode"]; else  $StatCode = "";
        if (isset($body["date"])) $date = $body["date"]; else  $date = "";
        if (isset($body["type"])) $alarmtype = $body["type"]; else  $alarmtype = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($type, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
            $table = $uiF3dmDbObj->dbi_dev_alarmhistory_req($StatCode, $date, $alarmtype);
            if(!empty($table)){
                $ret = array('StatCode'=> $StatCode,
                            'date'=> $date,
                            'AlarmName'=> $table["alarm_name"],
                            'AlarmUnit'=> $table["alarm_unit"],
                            'WarningTarget'=>$table["warning"],
                            'minute_head'=>$table["minute_head"],
                            'minute_alarm'=> $table["minute_alarm"],
                            'hour_head'=>$table["hour_head"],
                            'hour_alarm'=> $table["hour_alarm"],
                            'day_head'=>$table["day_head"],
                            'day_alarm'=> $table["day_alarm"]);
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"查询历史告警数据成功");
            }
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"查询历史告警数据失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    /*********************************智能云锁新增处理************************************************/
    function func_fhys_dev_alarm_process($type, $user, $body)
    {
        if (isset($body["StatCode"])) $StatCode = $body["StatCode"]; else  $StatCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($type, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
            $resp = $uiF3dmDbObj->dbi_fhys_dev_currentvalue_req($StatCode);
            if(!empty($resp)){
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$resp,'msg'=>"获取该站点下当前设备测量信息成功");
            }
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取该站点下当前设备测量信息失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

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
        else{
            //解开消息
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            if (isset($msg["body"])) $body = $msg["body"]; else  $body = "";
        }

        //多条消息发送到L3APPL_F5FM，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3APPL_FUM5FM", "mfun_l3apl_f5fm_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        switch($msgId)
        {
            //功能Dev Alarm
            case MSG_ID_L4AQYCUI_TO_L3F5_DEVALARM:
                $resp = $this->func_aqyc_dev_alarm_process($type, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;
            //功能Alarm Query
            case MSG_ID_L4AQYCUI_TO_L3F5_ALARMQUERY:
                $resp = $this->func_alarm_query_process($type, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;
            /*********************************智能云锁新增处理************************************************/
            //功能Dev Alarm
            case MSG_ID_L4FHYSUI_TO_L3F5_DEVALARM:
                $resp = $this->func_fhys_dev_alarm_process($type, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;
            default:
                $resp = ""; //啥都不ECHO
                break;
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