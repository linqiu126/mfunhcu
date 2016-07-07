<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:32
 */
//include_once "../../l1comvm/vmlayer.php";
include_once "dbi_l3apl_f2cm.class.php";

class classTaskL3aplF2cm
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

    function func_project_pglist_process($user)
    {
        $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
        $proj_pg_list = $uiF2cmDbObj->dbi_all_projpglist_req();
        if(!empty($proj_pg_list))
            $retval=array(
                'status'=>'true',
                'ret'=>$proj_pg_list
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

    function func_project_list_process($user)
    {
        $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
        $projlist = $uiF2cmDbObj->dbi_all_projlist_req();

        if(!empty($projlist))
            $retval=array(
                'status'=>'true',
                'ret'=>$projlist
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

    function func_user_project_list_process($userid)
    {
        $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
        $userproj = $uiF2cmDbObj->dbi_user_projpglist_req($userid);
        if(!empty($userproj))
            $retval= array(
                'status'=>"true",
                'ret'=>$userproj
            );
        else
            $retval= array(
                'status'=>"true",
                'ret'=>""
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_pg_table_process($length, $startseq)
    {
        $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
        $total = $uiF2cmDbObj->dbi_all_pgnum_inqury();
        $query_length = (int)($length);
        $start = (int)($startseq);
        if($query_length> $total-$start)
        {$query_length = $total-$start;}
        $pgtable = $uiF2cmDbObj->dbi_all_pgtable_req($start, $query_length);
        if(!empty($pgtable))
            $retval=array(
                'status'=>'true',
                'start'=> (string)$start,
                'total'=> (string)$total,
                'length'=>(string)$query_length,
                'ret'=> $pgtable
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

    function func_pg_new_process($pginfo)
    {
        $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
        $result = $uiF2cmDbObj->dbi_pginfo_update($pginfo);
        if($result)
            $retval=array(
                'status'=>'true',
                'msg'=>'新建项目组成功'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'新建项目组失败'
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_pg_mod_process($pginfo)
    {
        $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
        $result = $uiF2cmDbObj->dbi_pginfo_update($pginfo);
        if($result)
            $retval=array(
                'status'=>'true',
                'msg'=>'项目组信息修改成功'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'项目组信息修改失败'
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_pg_del_process($pgid)
    {
        $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
        $result = $uiF2cmDbObj->dbi_pginfo_delete($pgid);
        if ($result)
            $retval=array(
                'status'=>'true',
                'msg'=>'成功删除一个项目组'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'删除一个项目组失败'
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_pg_project_process($pgid)
    {
        $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
        $projlist = $uiF2cmDbObj->dbi_pg_projlist_req($pgid);
        if(!empty($projlist))
            $retval=array(
                'status'=>'true',
                'ret'=> $projlist
            );
        else
            $retval=array(
                'status'=>'true',
                'ret'=> ""
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_project_table_process($length, $startseq)
    {
        $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
        $total = $uiF2cmDbObj->dbi_all_projnum_inqury();
        $query_length = (int)($length);
        $start = (int)($startseq);
        if($query_length> $total-$start)
        {$query_length = $total-$start;}
        $projtable = $uiF2cmDbObj->dbi_all_projtable_req($start, $query_length);
        if(!empty($projtable))
            $retval=array(
                'status'=>'true',
                'start'=> (string)$start,
                'total'=> (string)$total,
                'length'=>(string)$query_length,
                'ret'=> $projtable
            );
        else
            $retval=array(
                'status'=>'false',
                'start'=> null,
                'total'=> null,
                'length'=> null,
                'ret'=> null
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_project_new_process($projinfo)
    {
        $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
        $result = $uiF2cmDbObj->dbi_projinfo_update($projinfo);
        if ($result == true)
            $retval=array(
                'status'=>'true',
                'msg'=>'新项目创建成功'
            );
        else
            $retval=array(
                'status'=>'true',
                'msg'=>'新项目创建失败'
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_project_mod_process($projinfo)
    {
        $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
        $result = $uiF2cmDbObj->dbi_projinfo_update($projinfo);
        if ($result == true)
            $retval=array(
                'status'=>'true',
                'msg'=>'项目信息修改成功'
            );
        else
            $retval=array(
                'status'=>'true',
                'msg'=>'项目信息修改失败'
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }



    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l3apl_f2cm_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3APPL_FUM2CM", "mfun_l3apl_f2cm_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到L3APPL_F2CM，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3APPL_FUM2CM", "mfun_l3apl_f2cm_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        //功能Project Pg List
        if ($msgId == MSG_ID_L4AQYCUI_TO_L3F2_PROJECTPGLIST)
        {
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_project_pglist_process($user);
        }

        //功能Project List
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F2_PROJECTLIST)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_project_list_process($user);
        }

        //功能User Project
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F2_USERPROJ)
        {
            //解开消息
            if (isset($msg["userid"])) $userid = $msg["userid"]; else  $userid = "";
            //具体处理函数
            $resp = $this->func_user_project_list_process($userid);
        }

        //功能PG Table
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F2_PGTABLE)
        {
            //解开消息
            if (isset($msg["length"])) $length = $msg["length"]; else  $length = "";
            if (isset($msg["startseq"])) $startseq = $msg["startseq"]; else  $startseq = "";
            //具体处理函数
            $resp = $this->func_pg_table_process($length, $startseq);
        }

        //功能PG New
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F2_PGNEW)
        {
            //解开消息
            if (isset($msg["PGCode"])) $PGCode = $msg["PGCode"]; else  $PGCode = "";
            if (isset($msg["PGName"])) $PGName = $msg["PGName"]; else  $PGName = "";
            if (isset($msg["ChargeMan"])) $ChargeMan = $msg["ChargeMan"]; else  $ChargeMan = "";
            if (isset($msg["Telephone"])) $Telephone = $msg["Telephone"]; else  $Telephone = "";
            if (isset($msg["Department"])) $Department = $msg["Department"]; else  $Department = "";
            if (isset($msg["Address"])) $Address = $msg["Address"]; else  $Address = "";
            if (isset($msg["Stage"])) $Stage = $msg["Stage"]; else  $Stage = "";
            if (isset($msg["Projlist"])) $Projlist = $msg["Projlist"]; else  $Projlist = "";
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            $pginfo = array("PGCode" => $PGCode, "PGName" => $PGName, "ChargeMan" => $ChargeMan, "Telephone" => $Telephone, "Department" => $Department,
                "Address" => $Address, "Stage" => $Stage, "Projlist" => $Projlist, "user" => $user, );
            //具体处理函数
            $resp = $this->func_pg_new_process($pginfo);
        }

        //功能PG Mod
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F2_PGMOD)
        {
            //解开消息
            if (isset($msg["PGCode"])) $PGCode = $msg["PGCode"]; else  $PGCode = "";
            if (isset($msg["PGName"])) $PGName = $msg["PGName"]; else  $PGName = "";
            if (isset($msg["ChargeMan"])) $ChargeMan = $msg["ChargeMan"]; else  $ChargeMan = "";
            if (isset($msg["Telephone"])) $Telephone = $msg["Telephone"]; else  $Telephone = "";
            if (isset($msg["Department"])) $Department = $msg["Department"]; else  $Department = "";
            if (isset($msg["Address"])) $Address = $msg["Address"]; else  $Address = "";
            if (isset($msg["Stage"])) $Stage = $msg["Stage"]; else  $Stage = "";
            if (isset($msg["Projlist"])) $Projlist = $msg["Projlist"]; else  $Projlist = "";
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            $pginfo = array("PGCode" => $PGCode, "PGName" => $PGName, "ChargeMan" => $ChargeMan, "Telephone" => $Telephone, "Department" => $Department,
                "Address" => $Address, "Stage" => $Stage, "Projlist" => $Projlist, "user" => $user, );
            //具体处理函数
            $resp = $this->func_pg_mod_process($pginfo);
        }

        //功能PG Del
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F2_PGDEL)
        {
            //解开消息
            if (isset($msg["id"])) $pgid = $msg["id"]; else  $pgid = "";
            //具体处理函数
            $resp = $this->func_pg_del_process($pgid);
        }

        //功能PG Project
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F2_PGPROJ)
        {
            //解开消息
            if (isset($msg["id"])) $pgid = $msg["id"]; else  $pgid = "";
            //具体处理函数
            $resp = $this->func_pg_project_process($pgid);
        }

        //功能Project Table
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F2_PROJTABLE)
        {
            //解开消息
            if (isset($msg["length"])) $length = $msg["length"]; else  $length = "";
            if (isset($msg["startseq"])) $startseq = $msg["startseq"]; else  $startseq = "";
            //具体处理函数
            $resp = $this->func_project_table_process($length, $startseq);
        }

        //功能ProjNew
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F2_PROJNEW)
        {
            //解开消息
            if (isset($msg["ProjCode"])) $ProjCode = $msg["ProjCode"]; else  $ProjCode = "";
            if (isset($msg["ProjName"])) $ProjName = $msg["ProjName"]; else  $ProjName = "";
            if (isset($msg["ChargeMan"])) $ChargeMan = $msg["ChargeMan"]; else  $ChargeMan = "";
            if (isset($msg["Telephone"])) $Telephone = $msg["Telephone"]; else  $Telephone = "";
            if (isset($msg["Department"])) $Department = $msg["Department"]; else  $Department = "";
            if (isset($msg["Address"])) $Address = $msg["Address"]; else  $Address = "";
            if (isset($msg["ProStartTime"])) $ProStartTime = $msg["ProStartTime"]; else  $ProStartTime = "";
            if (isset($msg["Stage"])) $Stage = $msg["Stage"]; else  $Stage = "";
            $projinfo = array("ProjCode" => $ProjCode, "ProjName" => $ProjName, "ChargeMan" => $ChargeMan, "Telephone" => $Telephone, "Department" => $Department,
                "Address" => $Address, "ProStartTime" => $ProStartTime, "Stage" => $Stage);
            //具体处理函数
            $resp = $this->func_project_new_process($projinfo);
        }

        //功能ProjMod
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F2_PROJMOD)
        {
            //解开消息
            if (isset($msg["ProjCode"])) $ProjCode = $msg["ProjCode"]; else  $ProjCode = "";
            if (isset($msg["ProjName"])) $ProjName = $msg["ProjName"]; else  $ProjName = "";
            if (isset($msg["ChargeMan"])) $ChargeMan = $msg["ChargeMan"]; else  $ChargeMan = "";
            if (isset($msg["Telephone"])) $Telephone = $msg["Telephone"]; else  $Telephone = "";
            if (isset($msg["Department"])) $Department = $msg["Department"]; else  $Department = "";
            if (isset($msg["Address"])) $Address = $msg["Address"]; else  $Address = "";
            if (isset($msg["ProStartTime"])) $ProStartTime = $msg["ProStartTime"]; else  $ProStartTime = "";
            if (isset($msg["Stage"])) $Stage = $msg["Stage"]; else  $Stage = "";
            $projinfo = array("ProjCode" => $ProjCode, "ProjName" => $ProjName, "ChargeMan" => $ChargeMan, "Telephone" => $Telephone, "Department" => $Department,
                "Address" => $Address, "ProStartTime" => $ProStartTime, "Stage" => $Stage);
            //具体处理函数
            $resp = $this->func_project_mod_process($projinfo);
        }


        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger("L4AQYCUI", "MFUN_TASK_ID_L3APPL_FUM2CM", $log_time, $log_content);
            echo trim($resp); //这里需要编码送出去，跟其他处理方式还不太一样
        }

        //返回
        return true;
    }

}//End of class_task_service

?>