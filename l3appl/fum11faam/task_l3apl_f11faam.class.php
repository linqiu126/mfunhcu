<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:38
 */
//include_once "../../l1comvm/vmlayer.php";
header("Content-type:text/html;charset=utf-8");
include_once "dbi_l3apl_f11faam.class.php";

class classTaskL3aplF11faam
{
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

    //查询员工信息表
    function func_faam_staff_table_query($action, $user, $body)
    {
        if (isset($body["length"])) $length = $body["length"]; else  $length = "";
        if (isset($body["startseq"])) $startseq = $body["startseq"]; else  $startseq = "";
        if (isset($body["keyword"])) $keyword = $body["keyword"]; else  $keyword = "";

        $uiF11faamDbObj = new classDbiL3apF11faam(); //初始化一个UI DB对象
        $total = $uiF11faamDbObj->dbi_faam_employeenum_inqury();
        $query_length = (int)($length);
        $start = (int)($startseq);
        if($query_length > $total-$start) $query_length = $total-$start;

        $uiF1symDbObj = new classDbiL3apF1sym();
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $staffTable = $uiF11faamDbObj->dbi_faam_stafftable_query($start, $query_length,$keyword);
            if(!empty($staffTable)){
                $ret = array('start'=> (string)$start,'total'=> (string)$total,'length'=>(string)$query_length,'stafftable'=>$staffTable);
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"员工信息表获取成功");
            }
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"员工信息表获取失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_staff_table_new($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $result = $uiF11faamDbObj->dbi_faam_staff_table_update($body);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"员工信息新增成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"员工信息新增失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_staff_table_modify($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $result = $uiF11faamDbObj->dbi_faam_staff_table_update($body);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"员工信息修改成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"员工信息修改失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_staff_table_delete($action, $user, $body)
    {
        if (isset($body["staffid"])) $staffId = $body["staffid"]; else  $staffId = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $result = $uiF11faamDbObj->dbi_faam_staff_table_delete($staffId);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"员工信息删除成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"员工信息删除失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_attendance_history_query($action, $user, $body)
    {
        if (isset($body["Time"])) $duration = $body["Time"]; else  $duration = "";
        if (isset($body["KeyWord"])) $keyWord = $body["KeyWord"]; else  $keyWord = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $resp = $uiF11faamDbObj->dbi_faam_attendance_history_query($duration, $keyWord);
            $ret = array('ColumnName' => $resp["ColumnName"],'TableData' => $resp["TableData"]);
            if(!empty($resp['TableData']))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取考勤历史记录成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取考勤历史记录失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_attendance_record_new($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $result = $uiF11faamDbObj->dbi_faam_attendance_record_new($body);
            if($result == true)
                $retval=array('status'=>"true",'auth'=>$usercheck['auth'],'msg'=>"新建考勤记录成功");
            else
                $retval=array('status'=>"false",'auth'=>$usercheck['auth'],'msg'=>"新建考勤记录失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_attendance_record_delete($action, $user, $body)
    {
        if (isset($body["attendanceid"])) $recordId = $body["attendanceid"]; else  $recordId = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $result = $uiF11faamDbObj->dbi_faam_attendance_record_delete($recordId);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"删除考勤记录成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"删除考勤记录失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_production_history_query($action, $user, $body)
    {
        if (isset($body["Time"])) $duration = $body["Time"]; else  $duration = "";
        if (isset($body["KeyWord"])) $keyWord = $body["KeyWord"]; else  $keyWord = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $resp = $uiF11faamDbObj->dbi_faam_production_history_query($duration, $keyWord);
            $ret = array('ColumnName' => $resp["ColumnName"],'TableData' => $resp["TableData"]);
            if(!empty($resp['TableData']))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取生产历史记录成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取生产历史记录失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }


    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l3apl_f11faam_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project ="";

        //入口消息内容判断
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog("NULL","NULL","NULL","MFUN_TASK_ID_L3APPL_FUM11FAAM",$msgName,$log_content);
            return false;
        }
        else{
            //解开消息
            if (isset($msg["project"])) $project = $msg["project"]; else  $project = "NULL";
            if (isset($msg["action"])) $action = $msg["action"]; else  $action = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            if (isset($msg["body"])) $body = $msg["body"]; else  $body = "";
        }

        switch ($msgId){
            case MSG_ID_L4FAAMUI_TO_L3F11_STAFFTABLE:
                $resp = $this->func_faam_staff_table_query($action, $user, $body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_STAFFNEW:
                $resp = $this->func_faam_staff_table_new($action, $user, $body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_STAFFMOD:
                $resp = $this->func_faam_staff_table_modify($action, $user, $body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_STAFFDEL:
                $resp = $this->func_faam_staff_table_delete($action, $user, $body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCEHISTORY:
                $resp = $this->func_faam_attendance_history_query($action, $user, $body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCERECORDNEW:
                $resp = $this->func_faam_attendance_record_new($action, $user, $body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCEDEL:
                $resp = $this->func_faam_attendance_record_delete($action, $user, $body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTIONHISTORY:
                $resp = $this->func_faam_production_history_query($action, $user, $body);
                break;
            default:
                break;
        }

        //这里需要将response返回给UI界面
        if (!empty($resp)) {
            $jsonencode = json_encode($resp, JSON_UNESCAPED_UNICODE);
            $log_content = "T:" . $jsonencode;
            $loggerObj->mylog($project,$user,"MFUN_TASK_ID_L3APPL_FUM11FAAM","MFUN_TASK_VID_L4UI_ECHO",$msgName,$log_content);
            echo trim($jsonencode);
        }

        //返回
        return true;
    }

}//End of class_task_service

?>