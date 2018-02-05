<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:37
 */
//include_once "../../l1comvm/vmlayer.php";
header("Content-type:text/html;charset=utf-8");
include_once "dbi_l3apl_f7ads.class.php";

class classTaskL3aplF7ads
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

    //TBD，功能待完善
    function func_set_user_msg_process($action, $user, $body)
    {
        if (isset($body["id"])) $userid = $body["id"]; else  $userid = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            //$uiF7adsDbObj = new classDbiL3apF7ads(); //初始化一个UI DB对象
            $ret = array('msg'=>'您好，今天是xxxx号，欢迎领导前来视察，今天的气温是 今天的PM2.5是....','ifdev'=>"true");
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"success");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    //TBD，功能待完善
    function func_get_user_msg_process($action, $user, $body)
    {
        if (isset($body["id"])) $userid = $body["id"]; else  $userid = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            //$uiF7adsDbObj = new classDbiL3apF7ads(); //初始化一个UI DB对象
            $ret = array('msg'=>'您好，今天是xxxx号，欢迎领导前来视察，今天的气温是 今天的PM2.5是....','ifdev'=>"true");
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"success");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    //TBD，功能待完善
    function func_show_user_msg_process($action, $user, $body)
    {
        if (isset($body["id"])) $userid = $body["id"]; else  $userid = "";
        if (isset($body["StatCode"])) $statCode = $body["StatCode"]; else  $statCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            //$uiF7adsDbObj = new classDbiL3apF7ads(); //初始化一个UI DB对象
            $temp =(string)rand(1000,9999);
            $msg =$temp.'您好，今天是'.$temp.'号，欢迎领导前来视察，今天的气温是 今天的PM2.5是....';
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$msg);
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    //TBD，功能待完善
    function func_get_user_image_process($action, $user, $body)
    {
        if (isset($body["id"])) $userid = $body["id"]; else  $userid = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            //$uiF7adsDbObj = new classDbiL3apF7ads(); //初始化一个UI DB对象
            $ImgList = array();
            for ($i=1;$i<6;$i++){
                $map = array(
                    'name'=>"test".(string)$i.".jpg",
                    'url'=>"screensaver/assets/img/test".(string)$i.".jpg"
                );
                array_push($ImgList,$map);
            }
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ImgList,'msg'=>"success");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    //TBD，功能待完善
    function func_clear_user_image_process($action, $user, $body)
    {
        if (isset($body["id"])) $userid = $body["id"]; else  $userid = "";
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            //$uiF7adsDbObj = new classDbiL3apF7ads(); //初始化一个UI DB对象
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"success");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_get_demo_show_action_process($action, $user, $body)
    {

    }


    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l3apl_f7ads_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project ="";

        //入口消息内容判断
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog("NULL","NULL","NULL","MFUN_TASK_ID_L3APPL_FUM7ADS",$msgName,$log_content);
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
            case MSG_ID_L4COMUI_TO_L3F7_SETUSERMSG://功能Set User Message
                $resp = $this->func_set_user_msg_process($action, $user, $body);
                break;

            case MSG_ID_L4COMUI_TO_L3F7_GETUSERMSG://功能Get User Message
                $resp = $this->func_get_user_msg_process($action, $user, $body);
                break;

            case MSG_ID_L4COMUI_TO_L3F7_SHOWUSERMSG://功能Show User Message
                $resp = $this->func_show_user_msg_process($action, $user, $body);
                break;

            case MSG_ID_L4COMUI_TO_L3F7_GETUSERIMG://功能Get User Image
                $resp = $this->func_get_user_image_process($action, $user, $body);
                break;

            case MSG_ID_L4COMUI_TO_L3F7_CLEARUSERIMG://功能Clear User Image
                $resp = $this->func_clear_user_image_process($action, $user, $body);
                break;

            case MSG_ID_L4AQYCUI_TO_L3F7_GETSHOWACTIONE:
                $resp = $this->func_get_demo_show_action_process($action, $user, $body);
                break;

            default:
                $resp = ""; //啥都不ECHO
                break;
        }

        //这里需要将response返回给UI界面
        if (!empty($resp)) {
            $jsonencode = json_encode($resp, JSON_UNESCAPED_UNICODE);
            $log_content = "T:" . $jsonencode;
            $loggerObj->mylog($project,$user,"MFUN_TASK_ID_L3APPL_FUM7ADS","MFUN_TASK_VID_L4UI_ECHO",$msgName,$log_content);
            echo trim($jsonencode);
        }

        //返回
        return true;
    }

}//End of class_task_service

?>