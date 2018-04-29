<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:35
 */
//include_once "../../l1comvm/vmlayer.php";
include_once "dbi_l3apl_f4icm.class.php";
require_once dirname(__FILE__)."/../../l2socketlisten/socket_client_sync.class.php";
header("Content-type:text/html;charset=utf-8");

class classTaskL3aplF4icm
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

    function func_hcu_camweb_process($action, $user, $body)
    {
        if (isset($body["StatCode"])) $statcode = $body["StatCode"]; else  $statcode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF4icmDbObj = new classDbiL3apF4icm();
            $resp = $uiF4icmDbObj->dbi_get_hcu_camweb_link($statcode);
            if(!empty($resp))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$resp,'msg'=>"获取视频摄像头WEB地址成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>"获取视频摄像头WEB地址失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>$usercheck['msg']);

        return $retval;
    }

    //传感器信息更新并发送HCU控制命令
    function func_sensor_update_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF4icmDbObj = new classDbiL3apF4icm();
            $resp = $uiF4icmDbObj->dbi_sensor_info_update($body);
            if(!empty($resp))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$resp,'msg'=>"更新传感器信息成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>"更新传感器信息失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>$usercheck['msg']);

        return $retval;
    }

    //查询指定监测点指定时间的图片/视频列表
    function func_hcu_hsmmplist_process($action, $user, $body)
    {
        if (isset($body["StatCode"])) $statcode = trim($body["StatCode"]); else  $statcode = "";
        if (isset($body["date"])) $date = trim($body["date"]); else  $date = "";
        if (isset($body["hour"])) $hour = trim($body["hour"]); else  $hour = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF4icmDbObj = new classDbiL3apF4icm();
            $resp = $uiF4icmDbObj->dbi_hcu_hsmmplist_inqury($statcode, $date, $hour);
            if(!empty($resp))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$resp,'msg'=>"获取指定时间图片/视频列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>"获取指定时间图片/视频列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>$usercheck['msg']);

        return $retval;
    }

    //显示指定照片/视频
    function func_hcu_hsmmpdisplay_process($action, $user, $body)
    {
        if (isset($body["videoid"])) $url_index = $body["videoid"]; else  $url_index = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            //$uiF4icmDbObj = new classDbiL3apF4icm();
            //$resp = $uiF4icmDbObj->dbi_hcu_hsmmpdisplay_request($urlIndex);
            if(!empty($resp))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$url_index,'msg'=>"播放指定照片/视频成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>"播放指定照片/视频失败");

        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>$usercheck['msg']);

        return $retval;
    }

    //Camera信息更新并发送HCU控制命令
    function func_get_camera_status_process($action, $user, $body)
    {
        if (isset($body["StatCode"])) $StatCode = $body["StatCode"]; else  $StatCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF4icmDbObj = new classDbiL3apF4icm();
            $ret = $uiF4icmDbObj->dbi_get_camera_status($StatCode);
            if(!empty($ret))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"摄像头状态更新成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>"摄像头状态更新失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_get_camera_unit_process($action, $user, $body)
    {
        if (isset($body["StatCode"])) $StatCode = $body["StatCode"]; else  $StatCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $adj_unit=array('v'=>"3~",'h'=>"3~");
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$adj_unit,'msg'=>"success");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_adjust_camera_vertical_process($action, $user, $body)
    {
        if (isset($body["StatCode"])) $statCode = $body["StatCode"]; else  $statCode = "";
        if (isset($body["adj"])) $adj = $body["adj"]; else  $adj = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true"){
            $uiF4icmDbObj = new classDbiL3apF4icm();
            $camStatus = $uiF4icmDbObj->dbi_adjust_camera_vertical($statCode, $adj);
            if($camStatus != false)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$camStatus,'msg'=>'摄像头垂直步进调整成功');
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>'摄像头垂直步进调整失败');
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_adjust_camera_horizon_process($action, $user, $body)
    {
        if (isset($body["StatCode"])) $statCode = $body["StatCode"]; else  $statCode = "";
        if (isset($body["adj"])) $adj = $body["adj"]; else  $adj = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true"){
            $uiF4icmDbObj = new classDbiL3apF4icm();
            $camStatus = $uiF4icmDbObj->dbi_adjust_camera_horizon($statCode, $adj);
            if($camStatus != false)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$camStatus,'msg'=>'摄像头水平步进调整成功');
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>'摄像头水平步进调整失败');
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_adjust_camera_zoom_process($action, $user, $body)
    {
        if (isset($body["StatCode"])) $statCode = $body["StatCode"]; else  $statCode = "";
        if (isset($body["adj"])) $adj = $body["adj"]; else  $adj = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true"){
            $uiF4icmDbObj = new classDbiL3apF4icm();
            $camStatus = $uiF4icmDbObj->dbi_adjust_camera_zoom($statCode, $adj);
            if($camStatus != false)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$camStatus,'msg'=>'摄像头调节指定位置成功');
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>'摄像头调节指定位置失败');
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_adjust_camera_reset_process($action, $user, $body)
    {
        if (isset($body["StatCode"])) $statCode = $body["StatCode"]; else  $statCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true"){
            $uiF4icmDbObj = new classDbiL3apF4icm();
            $camStatus = $uiF4icmDbObj->dbi_adjust_camera_reset($statCode);
            if($camStatus != false)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$camStatus,'msg'=>'摄像头回归Home位置成功');
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>'摄像头回归Home位置失败');
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>$usercheck['msg']);

        return $retval;
    }

    //TBSWR GetTempStatus
    function func_tbswr_gettempstatus_process($uid, $StatCode)
    {
        $uiF4icmDbObj = new classDbiL3apF4icm();
        $resp = $uiF4icmDbObj->dbi_tbswr_gettempstatus($uid, $StatCode);
        if (!empty($resp))
            $retval=array(
                'status'=>'true',
                'msg'=>$resp
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>null
            );
        //$jsonencode = _encode($retval);
        return $retval;
    }

    /*********************************智能云锁新增处理 Start*********************************************/

    //HCU_Lock_Open
    function func_hcu_lock_compel_open($action, $user, $body)
    {
        if (isset($body["StatCode"])) $StatCode = $body["StatCode"]; else  $StatCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF4icmDbObj = new classDbiL3apF4icm();
            $result = $uiF4icmDbObj->dbi_hcu_lock_compel_open($user, $StatCode);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"开锁授权成功，请通知现场人员按压手柄激活门锁");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"本次开锁授权认证未通过，请联系管理人员");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }


    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l3apl_f4icm_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project ="";

        //入口消息内容判断
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog("NULL","NULL","NULL","MFUN_TASK_ID_L3APPL_FUM4ICM",$msgName,$log_content);
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

        switch($msgId)
        {
            case MSG_ID_L4COMUI_TO_L3F4_SENSORUPDATE://功能Sensor update
                $resp = $this->func_sensor_update_process($action, $user, $body);
                break;

            case MSG_ID_L4COMUI_TO_L3F4_CAMWEB:
                $resp = $this->func_hcu_camweb_process($action, $user, $body);
                break;

            case MSG_ID_L4COMUI_TO_L3F4_HSMMPLIST: //这里沿用以前的Video消息，实际上是处理picture
                $resp = $this->func_hcu_hsmmplist_process($action, $user, $body);
                break;
            case MSG_ID_L4COMUI_TO_L3F4_HSMMPPLAY:  //这里沿用以前的Video消息，实际上是处理picture
                $resp = $this->func_hcu_hsmmpdisplay_process($action, $user, $body);
                break;

            case MSG_ID_L4COMUI_TO_L3F4_GETCAMERASTATUS://功能Get Camera Status
                $resp = $this->func_get_camera_status_process($action, $user, $body);
                break;

            case MSG_ID_L4COMUI_TO_L3F4_GETCAMERAUNIT:
                $resp = $this->func_get_camera_unit_process($action, $user, $body);
                break;
            //摄像头垂直步进调整
            case MSG_ID_L4COMUI_TO_L3F4_CAMERAVADJ:
                $resp = $this->func_adjust_camera_vertical_process($action, $user, $body);
                break;
            //摄像头水平步进调整
            case MSG_ID_L4COMUI_TO_L3F4_CAMERAHADJ:
                $resp = $this->func_adjust_camera_horizon_process($action, $user, $body);
                break;
            //摄像头指定转角调整
            case MSG_ID_L4COMUI_TO_L3F4_CAMERAZADJ:
                $resp = $this->func_adjust_camera_zoom_process($action, $user, $body);
                break;
            //摄像头回归HOME位置
            case MSG_ID_L4COMUI_TO_L3F4_CAMERARESET:
                $resp = $this->func_adjust_camera_reset_process($action, $user, $body);
                break;

            /*********************************智能云锁新增处理 Start*********************************************/
            case MSG_ID_L4FHYSUI_TO_L3F4_LOCKOPEN://功能HCU_Lock_Open
                $resp = $this->func_hcu_lock_compel_open($action, $user, $body);
                break;

            /*********************************TBSWR新增处理 Start*********************************************/
            case MSG_ID_L4TBSWRUI_TO_L3F4_GETTEMPSTATUS://功能TBSWR GetTempStatus,暂时放个例子，待后面修改
                //解开消息
                if (isset($_GET["id"])) $uid = trim($_GET["id"]); else  $uid = "";
                if (isset($_GET["StatCode"])) $StatCode = trim($_GET["StatCode"]); else  $StatCode= "";
                $input = array("uid" => $uid, "StatCode" => $StatCode);
                //具体处理函数
                $resp = $this->func_tbswr_gettempstatus_process($uid, $StatCode);
                break;

            default:
                $resp = ""; //啥都不ECHO
                break;
        }

        //这里需要将response返回给UI界面
        if (!empty($resp)) {
            $jsonencode = json_encode($resp, JSON_UNESCAPED_UNICODE);
            $log_content = "T:" . $jsonencode;
            $loggerObj->mylog($project,$user,"MFUN_TASK_ID_L3APPL_FUM4ICM","MFUN_TASK_VID_L4UI_ECHO",$msgName,$log_content);
            echo trim($jsonencode);
        }

        //返回
        return true;
    }

}//End of class_task_service

?>