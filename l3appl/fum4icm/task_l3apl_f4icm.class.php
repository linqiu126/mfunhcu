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

    function func_hcu_camweb_process($type, $user, $body)
    {
        if (isset($body["StatCode"])) $statcode = $body["StatCode"]; else  $statcode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($type, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF4icmDbObj = new classDbiL3apF4icm();
            $resp = $uiF4icmDbObj->dbi_get_hcu_camweb_link($statcode);
            if(!empty($resp))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$resp,'msg'=>"获取视频摄像头WEB地址成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取视频摄像头WEB地址失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    //查询所有可用的软件版本列表
    function func_allsw_version_process($type, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($type, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF4icmDbObj = new classDbiL3apF4icm();
            $resp = $uiF4icmDbObj->dbi_hcu_allsw_inqury();
            if(!empty($resp))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$resp,'msg'=>"查询所有可用的软件版本列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"查询所有可用的软件版本列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    //查询指定项目下所有设备的当前版本信息
    function func_devsw_version_process($type, $user, $body)
    {
        if (isset($body["ProjCode"])) $projcode = $body["ProjCode"]; else  $projcode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($type, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作

            $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
            $sitelist = $uiF3dmDbObj->dbi_proj_sitelist_req($projcode); //查询指定项目号下的所有监测点

            $i = 0;
            $devlist = array();
            while ($i < count($sitelist)) {
                $devlist = $uiF3dmDbObj->dbi_site_devlist_req($sitelist[$i]["id"]); //查询指定监测点下的HCU设备
                $i++;
            }

            $j = 0;
            $verlist = array();
            while ($j < count($devlist)) {
                $devcode = $devlist[$j]["name"];
                $uiF4icmDbObj = new classDbiL3apF4icm(); //初始化一个UI DB对象
                $latestver = $uiF4icmDbObj->dbi_latest_hcu_swver_inqury($devcode);
                if (!empty($latestver)) {
                    $temp = array('DevCode' => $devcode,'ProjName' => ':','version' => $latestver);
                    array_push($verlist, $temp);
                }
                $j++;
            }

            if(!empty($verlist))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$verlist,'msg'=>"查询指定项目下所有设备的当前版本信息成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"查询指定项目下所有设备的当前版本信息失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    //更新指定设备到指定的版本
    function func_devsw_update_process($type, $user, $body)
    {
        if (isset($body["list"])) $devlist = $body["list"]; else  $devlist = "";
        if (isset($body["version"])) $version = $body["version"]; else  $version = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($type, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF4icmDbObj = new classDbiL3apF4icm();
            $result = $uiF4icmDbObj->dbi_hcu_swver_update($devlist, $version);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"更新指定设备到指定的版本成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"更新指定设备到指定的版本失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    //传感器信息更新并发送HCU控制命令
    function func_sensor_update_process($type, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($type, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF4icmDbObj = new classDbiL3apF4icm();
            $resp = $uiF4icmDbObj->dbi_sensor_info_update($body);
            if(!empty($resp))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$resp,'msg'=>"更新传感器信息成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"更新传感器信息失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    //查询指定监测点指定时间的视频列表
    function func_hcu_videolist_process($type, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($type, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF4icmDbObj = new classDbiL3apF4icm();
            $resp = $uiF4icmDbObj->dbi_hcu_vediolist_inqury($body);
            if(!empty($resp))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$resp,'msg'=>"获取指定时间视频列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取指定时间视频列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    //请求播放指定视频
    function func_hcu_videoplay_process($type, $user, $body)
    {
        if (isset($body["videoid"])) $videoid = $body["videoid"]; else  $videoid = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($type, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF4icmDbObj = new classDbiL3apF4icm();
            $resp = $uiF4icmDbObj->dbi_hcu_vedioplay_request($videoid);
            if(!empty($resp))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$resp,'msg'=>"播放指定视频成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"播放指定视频失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    //Camera信息更新并发送HCU控制命令
    function func_get_camera_status_process($type, $user, $body)
    {
        if (isset($body["StatCode"])) $StatCode = $body["StatCode"]; else  $StatCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($type, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF4icmDbObj = new classDbiL3apF4icm();
            $result = $uiF4icmDbObj->dbi_get_camera_status($StatCode);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"摄像头状态更新成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"摄像头状态更新失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_get_camera_unit_process($type, $user, $body)
    {
        if (isset($body["StatCode"])) $StatCode = $body["StatCode"]; else  $StatCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($type, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $adj_unit=array('v'=>"3~",'h'=>"3~");
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$adj_unit,'msg'=>"success");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

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
    function func_hcu_lock_compel_open($type, $user, $body)
    {
        if (isset($body["StatCode"])) $StatCode = $body["StatCode"]; else  $StatCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($type, $user);
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

    /*********************************BFSC组合秤新增处理 Start*********************************************/
    function func_hcu_weight_compel_open($uid, $StatCode)
    {
        $uiF4icmDbObj = new classDbiL3apF4icm();
        $resp = $uiF4icmDbObj->dbi_hcu_weight_compel_open($uid, $StatCode);

        $retval=array(
            'status'=>'true',
            'msg'=>$resp
        );

        return $retval;
    }

    function func_hcu_weight_compel_close($uid, $StatCode)
    {
        $uiF4icmDbObj = new classDbiL3apF4icm();
        $resp = $uiF4icmDbObj->dbi_hcu_weight_compel_close($uid, $StatCode);

        $retval=array(
            'status'=>'true',
            'msg'=>$resp
        );

        return $retval;
    }


    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l3apl_f4icm_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());
        $project ="";

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3APPL_FUM4ICM", "mfun_l3apl_f4icm_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        else{
            //解开消息
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            if (isset($msg["body"])) $body = $msg["body"]; else  $body = "";
        }

        //多条消息发送到L3APPL_F4ICM，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3APPL_FUM4ICM", "mfun_l3apl_f4icm_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        switch($msgId)
        {
            case MSG_ID_L4AQYCUI_TO_L3F4_ALLSW:
                $resp = $this->func_allsw_version_process($type, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F4_DEVSW:
                $resp = $this->func_devsw_version_process($type, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F4_SWUPDATE:
                $resp = $this->func_devsw_update_process($type, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F4_SENSORUPDATE://功能Sensor update
                $resp = $this->func_sensor_update_process($type, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F4_CAMWEB:
                $resp = $this->func_hcu_camweb_process($type, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F4_VIDEOLIST:
                $resp = $this->func_hcu_videolist_process($type, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F4_VIDEOPLAY:
                $resp = $this->func_hcu_videoplay_process($type, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F4_GETCAMERASTATUS://功能Get Camera Status
                $resp = $this->func_get_camera_status_process($type, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F4_GETCAMERAUNIT:
                $resp = $this->func_get_camera_unit_process($type, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

/*********************************TBSWR新增处理 Start*********************************************/
            case MSG_ID_L4TBSWRUI_TO_L3F4_GETTEMPSTATUS://功能TBSWR GetTempStatus,暂时放个例子，待后面修改
                //解开消息
                if (isset($_GET["id"])) $uid = trim($_GET["id"]); else  $uid = "";
                if (isset($_GET["StatCode"])) $StatCode = trim($_GET["StatCode"]); else  $StatCode= "";
                $input = array("uid" => $uid, "StatCode" => $StatCode);
                //具体处理函数
                $resp = $this->func_tbswr_gettempstatus_process($uid, $StatCode);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

/*********************************智能云锁新增处理 Start*********************************************/
            case MSG_ID_L4FHYSUI_TO_L3F4_LOCKOPEN://功能HCU_Lock_Open
                $resp = $this->func_hcu_lock_compel_open($type, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

/*********************************BFSC组合秤新增处理 Start*********************************************/
            case MSG_ID_L4BFSCUI_TO_L3F4_WEIGHTOPEN:
                //解开消息
                if (isset($msg["uid"])) $uid = trim($msg["uid"]); else  $uid = "";
                if (isset($msg["statcode"])) $statcode = trim($msg["statcode"]); else  $statcode= "";
                //具体处理函数
                $resp = $this->func_hcu_weight_compel_open($uid, $statcode);
                $project = MFUN_PRJ_HCU_BFSCUI;
                break;

            case MSG_ID_L4BFSCUI_TO_L3F4_WEIGHTCLOSE:
                //解开消息
                if (isset($msg["uid"])) $uid = trim($msg["uid"]); else  $uid = "";
                if (isset($msg["statcode"])) $statcode = trim($msg["statcode"]); else  $statcode= "";
                //具体处理函数
                $resp = $this->func_hcu_weight_compel_close($uid, $statcode);
                $project = MFUN_PRJ_HCU_BFSCUI;
                break;

            default:
                $resp = ""; //啥都不ECHO
                break;
        }

        //返回ECHO
        if (!empty($resp))
        {
            $jsonencode = json_encode($resp, JSON_UNESCAPED_UNICODE);
            $log_content = "T:" . $jsonencode;
            $loggerObj->logger($project, "MFUN_TASK_ID_L3APPL_FUM4ICM", $log_time, $log_content);
            echo trim($jsonencode); //这里需要编码送出去，跟其他处理方式还不太一样
        }

        //返回
        return true;
    }

}//End of class_task_service

?>