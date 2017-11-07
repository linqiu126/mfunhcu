<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:35
 */
//include_once "../../l1comvm/vmlayer.php";
header("Content-type:text/html;charset=utf-8");
include_once "dbi_l3apl_f5fm.class.php";

class classTaskL3aplF5fm
{
    //构造函数
    public function __construct()
    {

    }

    private function _encode($arr)
    {
        $na = array();
        foreach ( $arr as $k => $value ) {
            $na[_urlencode($k)] = _urlencode ($value);
        }
        return addcslashes(urldecode(json_encode($na)),"\r\n");
    }

    private function _urlencode($elem)
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

    private function func_aqyc_dev_alarm_process($action, $user, $body)
    {
        if (isset($body["StatCode"])) $StatCode = $body["StatCode"]; else  $StatCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
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

        return $retval;
    }

    private function func_aqyc_alarm_query_process($action, $user, $body)
    {
        if (isset($body["StatCode"])) $StatCode = $body["StatCode"]; else  $StatCode = "";
        if (isset($body["date"])) $date = $body["date"]; else  $date = "";
        if (isset($body["type"])) $alarmtype = $body["type"]; else  $alarmtype = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
            $table = $uiF3dmDbObj->dbi_aqyc_dev_alarmhistory_req($StatCode, $date, $alarmtype);

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
                        'day_alarm'=> $table["day_alarm"],
                        'Alarm_min'=> $table["value_min"],
                        'Alarm_max'=> $table["value_max"]
                        );
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"查询历史告警数据成功");
            }
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"查询历史告警数据失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    private function func_aqyc_alarmtype_list_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF5fmDbObj = new classDbiL3apF5fm();
            $sensor_type = MFUN_L3APL_F3DM_AQYC_STYPE_PREFIX;
            $alarm_type = $uiF5fmDbObj->dbi_all_alarmtype_req($sensor_type);
            if(!empty($alarm_type))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$alarm_type,'msg'=>"获取告警类型列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取告警类型列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    private function func_aqyc_alarm_monitor_list_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $uiF1symDbObj->dbi_session_check($user);
            $uiF5fmDbObj = new classDbiL3apF5fm(); //初始化一个UI DB对象
            $stat_list = $uiF5fmDbObj->dbi_map_alarm_sitetinfo_req($uid);
            if(!empty($stat_list))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$stat_list,'msg'=>"获取地图告警监测列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取地图告警监测列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    //告警处理表
    function func_aqyc_get_alarm_handle_table_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $uiF1symDbObj->dbi_session_check($user);
            $uiF5fmDbObj = new classDbiL3apF5fm(); //初始化一个UI DB对象
            $resp = $uiF5fmDbObj->dbi_aqyc_alarm_handle_table_req($uid);
            if(!empty($resp)){
                $ret = array('ColumnName' => $resp["column"],'TableData' => $resp["data"]);
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取告警处理表成功");
            }
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取告警处理表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    /*********************************智能云锁新增处理************************************************/
    private function func_fhys_alarmtype_list_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF5fmDbObj = new classDbiL3apF5fm();
            $sensor_type = MFUN_L3APL_F3DM_FHYS_STYPE_PREFIX;
            $alarm_type = $uiF5fmDbObj->dbi_all_alarmtype_req($sensor_type);
            if(!empty($alarm_type))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$alarm_type,'msg'=>"获取告警类型列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取告警类型列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    private function func_fhys_dev_alarm_process($action, $user, $body)
    {
        if (isset($body["StatCode"])) $StatCode = $body["StatCode"]; else  $StatCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
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

        return $retval;
    }

    private function func_fhys_get_alarm_handle_table_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $uiF1symDbObj->dbi_session_check($user);
            $uiF5fmDbObj = new classDbiL3apF5fm(); //初始化一个UI DB对象
            $resp = $uiF5fmDbObj->dbi_fhys_alarm_handle_table_req($uid);
            if(!empty($resp)){
                $ret = array('ColumnName' => $resp["column"],'TableData' => $resp["data"]);
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取告警处理表成功");
            }
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取告警处理表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    private function func_fhys_alarm_handle_process($action, $user, $body)
    {
        if (isset($body["StatCode"])) $statcode = $body["StatCode"]; else  $statcode = "";
        if (isset($body["Mobile"])) $mobile = $body["Mobile"]; else  $mobile = "";
        if (isset($body["Action"])) $action = $body["Action"]; else  $action = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $uiF1symDbObj->dbi_session_check($user);
            if (!empty($mobile) AND !empty($action)){
                $uiF5fmDbObj = new classDbiL3apF5fm(); //初始化一个UI DB对象
                $alarm_proc = $uiF5fmDbObj->dbi_fhys_alarm_handle_process($statcode,$mobile,$action);
            }

            if(!empty($alarm_proc))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"告警处理成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"告警处理失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"超时退出");

        return $retval;
    }

    private function func_fhys_alarm_close_process($action, $user, $body)
    {
        if (isset($body["StatCode"])) $statcode = $body["StatCode"]; else  $statcode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $uiF1symDbObj->dbi_session_check($user);
            $uiF5fmDbObj = new classDbiL3apF5fm(); //初始化一个UI DB对象
            $result = $uiF5fmDbObj->dbi_fhys_alarm_close_process($uid,$statcode);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"告警关闭成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"告警关闭失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"超时退出");

        return $retval;
    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l3apl_f5fm_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project ="";

        //入口消息内容判断
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog("NULL","NULL","NULL","MFUN_TASK_ID_L3APPL_FUM5FM",$msgName,$log_content);
            return false;
        }
        else{
            //解开消息
            if (isset($msg["action"])) $action = $msg["action"]; else  $action = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            if (isset($msg["body"])) $body = $msg["body"]; else  $body = "";
        }

        switch($msgId)
        {
            //功能Dev Alarm
            case MSG_ID_L4AQYCUI_TO_L3F5_DEVALARM:
                $resp = $this->func_aqyc_dev_alarm_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            //功能Alarm Query
            case MSG_ID_L4COMUI_TO_L3F5_ALARMQUERY:
                $resp = $this->func_aqyc_alarm_query_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            //功能Alarm Type, 获取所有告警传感器类型
            case MSG_ID_L4AQYCUI_TO_L3F5_ALARMTYPE:
                $resp = $this->func_aqyc_alarmtype_list_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            //告警地图查看
            case MSG_ID_L4AQYCUI_TO_L3F5_ALARMMONITORLIST:
                $resp = $this->func_aqyc_alarm_monitor_list_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            //告警处理表
            case MSG_ID_L4AQYCUI_TO_L3F5_ALARMHANDLETABLE:
                $resp = $this->func_aqyc_get_alarm_handle_table_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

/*********************************智能云锁新增处理************************************************/
            //功能Dev Alarm
            case MSG_ID_L4FHYSUI_TO_L3F5_DEVALARM:
                $resp = $this->func_fhys_dev_alarm_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            //功能Alarm Type, 获取所有告警传感器类型
            case MSG_ID_L4FHYSUI_TO_L3F5_ALARMTYPE:
                $resp = $this->func_fhys_alarmtype_list_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F5_ALARMHANDLETABLE:
                $resp = $this->func_fhys_get_alarm_handle_table_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F5_ALARMHANDLE:
                $resp = $this->func_fhys_alarm_handle_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F5_ALARMCLOSE:
                $resp = $this->func_fhys_alarm_close_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            default:
                $resp = ""; //啥都不ECHO
                break;
        }

        //这里需要将response返回给UI界面
        if (!empty($resp)) {
            $jsonencode = json_encode($resp, JSON_UNESCAPED_UNICODE);
            $log_content = "T:" . $jsonencode;
            $loggerObj->mylog($project,$user,"MFUN_TASK_ID_L3APPL_FUM5FM","MFUN_TASK_VID_L4UI_ECHO",$msgName,$log_content);
            echo trim($jsonencode);
        }

        //返回
        return true;
    }

}//End of class_task_service

?>