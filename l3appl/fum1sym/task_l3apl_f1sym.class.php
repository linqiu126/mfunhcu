<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:31
 */
//include_once "../../l1comvm/vmlayer.php";
header("Content-type:text/html;charset=utf-8");
include_once "dbi_l3apl_f1sym.class.php";

class classTaskL3aplF1sym
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

    function func_login_process($user, $pwd)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $resp =$uiF1symDbObj->dbi_login_req($user, $pwd);
        $body = $resp['body'];
        $msg = $resp['msg'];

        if (!empty($body['key']))
            $retval=array('status'=>"true",'auth'=>"true",'ret'=>$body,'msg'=>$msg);
        else
            $retval=array('status'=>"false",'auth'=>"false",'ret'=>$body,'msg'=>$msg);

        return $retval;
    }

    function func_userinfo_process($type, $user, $body)
    {
        if (isset($body["session"])) $sessionid = $body["session"]; else  $sessionid = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        //改消息特殊不做权限判断
        $userinfo =$uiF1symDbObj->dbi_userinfo_req($sessionid);
        $retval=array('status'=>"true",'auth'=>"true",'ret'=>$userinfo,'msg'=>"");

        return $retval;
    }

    function func_usernew_process($type, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($type, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $result = $uiF1symDbObj->dbi_userinfo_new($body);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"Add new user success");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"Add new user failure");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_usermod_process($type, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($type, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $result = $uiF1symDbObj->dbi_userinfo_update($body);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"User info update success");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"User info update failure");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_userdel_process($type, $user, $body)
    {
        if (isset($body["userid"])) $userid = $body["userid"]; else  $userid = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($type, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $result = $uiF1symDbObj->dbi_userinfo_delete($userid);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"User delete success");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"User delete failure");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_usertable_process($type, $user, $body)
    {
        if (isset($body["length"])) $length = $body["length"]; else  $length = "";
        if (isset($body["startseq"])) $startseq = $body["startseq"]; else  $startseq = "";
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $total = $uiF1symDbObj->dbi_usernum_inqury();
        $query_length = (int)($length);
        $start = (int)($startseq);
        if($query_length > $total-$start) $query_length = $total-$start;

        $usercheck = $uiF1symDbObj->dbi_user_authcheck($type, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $usertable = $uiF1symDbObj->dbi_usertable_req($start, $query_length);
            if(!empty($usertable)){
                $ret = array('start'=> (string)$start,'total'=> (string)$total,'length'=>(string)$query_length,'usertable'=>$usertable);
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"Get user table success");
            }
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"Get user table failure");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }


    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l3apl_f1sym_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());
        $project ="";

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3APPL_FUM1SYM", "mfun_l3apl_f1sym_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到L3APPL_F1SYM，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3APPL_FUM1SYM", "mfun_l3apl_f1sym_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        switch($msgId)
        {
            case MSG_ID_L4AQYCUI_TO_L3F1_LOGIN:  //功能Login
                //解开消息
                if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
                if (isset($msg["pwd"])) $pwd = $msg["pwd"]; else  $pwd = "";
                //具体处理函数
                $resp = $this->func_login_process($user, $pwd);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F1_USERINFO://功能UserInfo
                //解开消息
                if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
                if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
                if (isset($msg["body"])) $body = $msg["body"]; else  $body = "";
                //具体处理函数
                $resp = $this->func_userinfo_process($type, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F1_USERNEW://功能UserNew
                //解开消息
                if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
                if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
                if (isset($msg["body"])) $body = $msg["body"]; else  $body = "";

                //具体处理函数
                $resp = $this->func_usernew_process($type, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F1_USERMOD://功能UserMod
                //解开消息
                if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
                if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
                if (isset($msg["body"])) $body = $msg["body"]; else  $body = "";

                //具体处理函数
                $resp = $this->func_usermod_process($type, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F1_USERDEL://功能UserDel
                //解开消息
                if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
                if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
                if (isset($msg["body"])) $body = $msg["body"]; else  $body = "";

                //具体处理函数
                $resp = $this->func_userdel_process($type, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F1_USERTABLE://功能UserTable
                //解开消息
                if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
                if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
                if (isset($msg["body"])) $body = $msg["body"]; else  $body = "";

                //具体处理函数
                $resp = $this->func_usertable_process($type, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
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
            $loggerObj->logger($project, "MFUN_TASK_ID_L3APPL_FUM1SYM", $log_time, $log_content);
            echo trim($jsonencode);
        }

        //返回
        return true;
    }

}//End of class_task_service

?>