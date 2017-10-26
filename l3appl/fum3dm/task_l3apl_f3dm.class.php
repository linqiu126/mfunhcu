<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:34
 */
//include_once "../../l1comvm/vmlayer.php";
header("Content-type:text/html;charset=utf-8");
include_once "dbi_l3apl_f3dm.class.php";

class classTaskL3aplF3dm
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

    function func_monitor_list_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $uiF1symDbObj->dbi_session_check($user);
            $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
            $stat_list = $uiF3dmDbObj->dbi_map_sitetinfo_req($uid);
            if(!empty($stat_list))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$stat_list,'msg'=>"获取地图监测列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取地图监测列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_favourite_list_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $uiF1symDbObj->dbi_session_check($user);
            $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
            $stat_list = $uiF3dmDbObj->dbi_favourite_list_process($uid);
            if(!empty($stat_list))
                $retval=array('status'=>"true",'auth'=>"true",'ret'=>$stat_list,'msg'=>"获取常用站点列表成功");
            else
                $retval=array('status'=>"true",'auth'=>"true",'ret'=>$stat_list,'msg'=>"获取常用站点列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_favourite_count_process($action, $user, $body) //临时处理函数
    {
        if (isset($body["StatCode"])) $statCode = $body["StatCode"]; else  $statCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $uiF1symDbObj->dbi_session_check($user);
            $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
            $result = $uiF3dmDbObj->dbi_favourite_count_process($uid, $statCode);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"添加常用站点成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"添加常用站点失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_aqyc_sensor_list_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiL2snrDbObj = new classDbiL2snrCommon();
            $sensor_type = MFUN_L3APL_F3DM_AQYC_STYPE_PREFIX;
            $sensor_list = $uiL2snrDbObj->dbi_all_sensorlist_req($sensor_type);
            if(!empty($sensor_list))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$sensor_list,'msg'=>"获取传感器列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取传感器列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_aqyc_dev_sensor_process($action, $user, $body)
    {
        if (isset($body["DevCode"])) $DevCode = $body["DevCode"]; else  $DevCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiL2snrDbObj = new classDbiL2snrCommon();
            $sensorinfo = $uiL2snrDbObj->dbi_aqyc_dev_sensorinfo_req($DevCode);
            if(!empty($sensorinfo))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$sensorinfo,'msg'=>"获取指定设备下传感器列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取指定设备下传感器列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_aqyc_get_static_monitor_table_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $uiF1symDbObj->dbi_session_check($user);
            $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
            $resp = $uiF3dmDbObj->dbi_aqyc_user_dataaggregate_req($uid);
            if(!empty($resp)){
                $ret = array('ColumnName' => $resp["column"],'TableData' => $resp["data"]);
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取站点测量聚合表成功");
            }
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取站点测量聚合表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    /*******************************波峰智能组合秤新增处理 Start****************************************/
    function func_bfsc_get_static_monitor_table_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $uiF1symDbObj->dbi_session_check($user);
            $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
            $resp = $uiF3dmDbObj->dbi_bfsc_user_dataaggregate_req($uid);
            if(!empty($resp)){
                $ret = array('ColumnName' => $resp["column"],'TableData' => $resp["data"]);
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取站点测量聚合表成功");
            }
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取站点测量聚合表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    /*********************************智能云锁新增处理************************************************/
    function func_fhys_sensor_list_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiL2snrDbObj = new classDbiL2snrCommon();
            $sensor_type= MFUN_L3APL_F3DM_FHYS_STYPE_PREFIX;
            $sensor_list = $uiL2snrDbObj->dbi_all_sensorlist_req($sensor_type);
            if(!empty($sensor_list))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$sensor_list,'msg'=>"获取传感器列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取传感器列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_fhys_dev_sensor_process($action, $user, $body)
    {
        if (isset($body["DevCode"])) $DevCode = $body["DevCode"]; else  $DevCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiL2snrDbObj = new classDbiL2snrCommon();
            $sensorinfo = $uiL2snrDbObj->dbi_fhys_dev_sensorinfo_req($DevCode);
            if(!empty($sensorinfo))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$sensorinfo,'msg'=>"获取指定设备下传感器列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取指定设备下传感器列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_fhys_get_static_monitor_table_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $uiF1symDbObj->dbi_session_check($user);
            $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
            $resp = $uiF3dmDbObj->dbi_fhys_user_dataaggregate_req($uid);
            if(!empty($resp)){
                $ret = array('ColumnName' => $resp["column"],'TableData' => $resp["data"]);
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取站点测量聚合表成功");
            }
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取站点测量聚合表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    //查询开锁历史记录
    function func_key_event_history_process($action, $user, $body)
    {
        if (isset($body["ProjCode"])) $projCode = $body["ProjCode"]; else  $projCode = "";
        if (isset($body["Time"])) $duration = $body["Time"]; else  $duration = "";
        if (isset($body["KeyWord"])) $keyWord = $body["KeyWord"]; else  $keyWord = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $uiF1symDbObj->dbi_session_check($user);
            $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
            $resp = $uiF3dmDbObj->dbi_key_event_history_process($projCode,$duration,$keyWord);
            if(!empty($resp)){
                $ret = array('ColumnName' => $resp["ColumnName"],'TableData' => $resp["TableData"]);
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取锁事件历史记录成功");
            }
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取锁事件历史记录失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    //根据开锁事件event_id查询本次开门抓拍的照片
    function func_door_open_picture_process($action, $user, $body)
    {
        if (isset($body["openid"])) $enventid = $body["openid"]; else  $enventid = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
            $pic_result = $uiF3dmDbObj->dbi_door_open_picture_process($enventid);
            if(!empty($pic_result))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$pic_result,'msg'=>"获取指定开门事件的抓拍照片成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取指定开门事件的抓拍照片失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_point_install_picture_process($action, $user, $body)
    {
        if (isset($body["StatCode"])) $statcode = $body["StatCode"]; else  $statcode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
            $pic_list = $uiF3dmDbObj->dbi_point_install_picture_process($statcode);
            if(!empty($pic_list))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$pic_list,'msg'=>"获取指定站点的照片列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取指定站点的照片列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l3apl_f3dm_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project ="";

        //入口消息内容判断
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog("NULL","NULL","NULL","MFUN_TASK_ID_L3APPL_FUM3DM",$msgName,$log_content);
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
            case MSG_ID_L4AQYCUI_TO_L3F3_MONITORLIST://功能Monitor List
                $resp = $this->func_monitor_list_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F3_FAVOURITELIST:
                $resp = $this->func_favourite_list_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F3_FAVOURITECOUNT:
                $resp = $this->func_favourite_count_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F3_SENSORLIST://功能Sensor List
                $resp = $this->func_aqyc_sensor_list_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F3_DEVSENSOR://功能Dev Sensor
                $resp = $this->func_aqyc_dev_sensor_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F3_GETSTATICMONITORTABLE://功能GetStaticMonitorTable
                $resp = $this->func_aqyc_get_static_monitor_table_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

/*********************************波峰智能组合秤新增处理 Start*********************************************/
            case MSG_ID_L4BFSCUI_TO_L3F3_GETSTATICMONITORTABLE://功能GetStaticMonitorTable
                $resp = $this->func_bfsc_get_static_monitor_table_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_BFSCUI;
                break;
/*************************************智能云锁新增处理 Start*********************************************/
            case MSG_ID_L4FHYSUI_TO_L3F3_SENSORLIST://功能Sensor List
                $resp = $this->func_fhys_sensor_list_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F3_DEVSENSOR://功能Dev Sensor
                $resp = $this->func_fhys_dev_sensor_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F3_GETSTATICMONITORTABLE://功能GetStaticMonitorTable
                $resp = $this->func_fhys_get_static_monitor_table_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F3_KEYHISTORY://开锁事件历史记录
                $resp = $this->func_key_event_history_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F3_DOOROPENPIC://开锁抓拍照片
                $resp = $this->func_door_open_picture_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F3_POINTPICTURE: //开站安装上传照片
                $resp = $this->func_point_install_picture_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            default :
                $resp = ""; //啥都不ECHO
                break;
        }

        //这里需要将response返回给UI界面
        if (!empty($resp)) {
            $jsonencode = json_encode($resp, JSON_UNESCAPED_UNICODE);
            $log_content = "T:" . $jsonencode;
            $loggerObj->mylog($project,$user,"MFUN_TASK_ID_L3APPL_FUM3DM","NULL",$msgName,$log_content);
            echo trim($jsonencode);
        }

        //返回
        return true;
    }

}//End of class_task_service

?>