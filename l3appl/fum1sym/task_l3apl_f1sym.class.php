<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:31
 */
//include_once "../../l1comvm/vmlayer.php";
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
        $userinfo =$uiF1symDbObj->dbi_login_req($user, $pwd);
        $jsonencode = json_encode($userinfo);
        return $jsonencode;
    }

    function func_userinfo_process($session)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $userinfo =$uiF1symDbObj->dbi_userinfo_req($session);
        if(!empty($userinfo))
            $retval=array(
                'status'=>'true',
                'ret'=>$userinfo
            );
        else
            $retval=array(
                'status'=>'false',
                'ret'=>null
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_usernew_process($userinfo)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $result = $uiF1symDbObj->dbi_userinfo_new($userinfo);
        if($result == true){
            $retval=array(
                'status'=>'true',
                'msg'=>'用户新增成功'
            );
        }
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'用户新增失败'
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_usermod_process($userinfo)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $result = $uiF1symDbObj->dbi_userinfo_update($userinfo);
        if($result)
            $retval=array(
                'status'=>'true',
                'msg'=>'用户信息更新成功'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'用户信息更新失败'
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_userdel_process($uid)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $result = $uiF1symDbObj->dbi_userinfo_delete($uid);
        if($result == true)
            $retval=array(
                'status'=>'true',
                'msg'=>'用户删除成功'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'用户删除失败'
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_usertable_process($length, $startseq)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $total = $uiF1symDbObj->dbi_usernum_inqury();
        $query_length = (int)($length);
        $start = (int)($startseq);
        if($query_length > $total-$start) $query_length = $total-$start;
        $usertable = $uiF1symDbObj->dbi_usertable_req($start, $query_length);
        if (!empty($usertable))
            $retval=array(
                'status'=>'true',
                'start'=> (string)$start,
                'total'=> (string)$total,
                'length'=>(string)$query_length,
                'ret'=> $usertable
            );
        else
            $retval=array(
                'status'=>'false',
                'start'=> null,
                'total'=> null,
                'length'=>null,
                'ret'=> null
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    //待完善的函数
    function func_hcu_sw_update_process($deviceid, $projectid)
    {
        //获取最新版本, swbin和dbbin
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $latestver = $uiF1symDbObj->dbi_latest_hcu_swver_inqury();
        $result = $uiF1symDbObj->dbi_hcu_swver_inqury($latestver);

        //发送软件版本到HCU网关

        //返回结果
        $retval=array(
            'status'=>'true',
            'ret'=> ""
        );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
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

        //功能Login
        if ($msgId == MSG_ID_L4AQYCUI_TO_L3F1_LOGIN)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            if (isset($msg["pwd"])) $pwd = $msg["pwd"]; else  $pwd = "";
            //具体处理函数
            $resp = $this->func_login_process($user, $pwd);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能UserInfo
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F1_USERINFO)
        {
            //解开消息
            if (isset($msg["session"])) $session = $msg["session"]; else  $session = "";
            //具体处理函数
            $resp = $this->func_userinfo_process($session);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能UserNew
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F1_USERNEW)
        {
            //解开消息
            if (isset($msg["name"])) $name = $msg["name"]; else  $name = "";
            if (isset($msg["nickname"])) $nickname = $msg["nickname"]; else  $nickname = "";
            if (isset($msg["password"])) $password = $msg["password"]; else  $password = "";
            if (isset($msg["mobile"])) $mobile = $msg["mobile"]; else  $mobile = "";
            if (isset($msg["mail"])) $mail = $msg["mail"]; else  $mail = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["memo"])) $memo = $msg["memo"]; else  $memo = "";
            if (isset($msg["auth"])) $auth = $msg["auth"]; else  $auth = "";
            $userinfo = array("name" => $name, "nickname" => $nickname, "password" => $password, "mobile" => $mobile,
                "mail" => $mail, "type" => $type, "memo" => $memo, "auth" => $auth);
            //具体处理函数
            $resp = $this->func_usernew_process($userinfo);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能UserMod
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F1_USERMOD)
        {
            //解开消息
            if (isset($msg["id"])) $id = $msg["id"]; else  $id = "";
            if (isset($msg["name"])) $name = $msg["name"]; else  $name = "";
            if (isset($msg["nickname"])) $nickname = $msg["nickname"]; else  $nickname = "";
            if (isset($msg["password"])) $password = $msg["password"]; else  $password = "";
            if (isset($msg["mobile"])) $mobile = $msg["mobile"]; else  $mobile = "";
            if (isset($msg["mail"])) $mail = $msg["mail"]; else  $mail = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["memo"])) $memo = $msg["memo"]; else  $memo = "";
            if (isset($msg["auth"])) $auth = $msg["auth"]; else  $auth = "";
            $userinfo = array("id" => $id, "name" => $name, "nickname" => $nickname, "password" => $password, "mobile" => $mobile,
                "mail" => $mail, "type" => $type, "memo" => $memo, "auth" => $auth);
            //具体处理函数
            $resp = $this->func_usermod_process($userinfo);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能UserDel
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F1_USERDEL)
        {
            //解开消息
            if (isset($msg["id"])) $id = $msg["id"]; else  $id = "";
            //具体处理函数
            $resp = $this->func_userdel_process($id);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能UserTable
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F1_USERTABLE)
        {
            //解开消息
            if (isset($msg["length"])) $length = $msg["length"]; else  $length = "";
            if (isset($msg["startseq"])) $startseq = $msg["startseq"]; else  $startseq = "";
            //具体处理函数
            $resp = $this->func_usertable_process($length, $startseq);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能HcuSwUpdate
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F1_HCUSWUPDATE)
        {
            //解开消息
            if (isset($msg["deviceid"])) $deviceid = $msg["deviceid"]; else  $deviceid = "";
            if (isset($msg["projectid"])) $projectid = $msg["projectid"]; else  $projectid = "";
            //具体处理函数
            $resp = $this->func_hcu_sw_update_process($deviceid, $projectid);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, "MFUN_TASK_ID_L3APPL_FUM1SYM", $log_time, $log_content);
            echo trim($resp);
        }

        //返回
        return true;
    }

}//End of class_task_service

?>