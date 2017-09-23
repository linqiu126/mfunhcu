<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:32
 */
//include_once "../../l1comvm/vmlayer.php";
header("Content-type:text/html;charset=utf-8");
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

    //用户表，项目组/项目/站点/设备表的打印按钮对应的excel表导出
    function func_print_excel_table_query_process($action, $user, $body)
    {
        if (isset($body["TableName"])) $tablename = $body["TableName"]; else  $tablename = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $uiF1symDbObj->dbi_session_check($user);
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result = $uiF2cmDbObj->dbi_print_excel_table_query_process($uid, $tablename);
            if(!empty($result)){
                $ret = array('ColumnName' => $result["column"],'TableData' => $result["data"]);
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取打印报表成功");
            }
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取打印报表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    //查询所有的项目，项目组列表，用于用户授权，所以给出的是全部列表
    function func_all_project_pg_list_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $proj_pg_list = $uiF2cmDbObj->dbi_user_all_projpglist_req();
            if(!empty($proj_pg_list))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$proj_pg_list,'msg'=>"获取全部项目项目组列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$proj_pg_list,'msg'=>"获取全部项目项目组列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_all_project_list_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $projlist = $uiF2cmDbObj->dbi_user_all_projlist_req($uid);
            if(!empty($projlist))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$projlist,'msg'=>"获取全部项目列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$projlist,'msg'=>"获取全部项目列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_user_project_list_process($action, $user, $body)
    {
        if (isset($body["userid"])) $userid = $body["userid"]; else  $userid = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $userproj = $uiF2cmDbObj->dbi_user_projpglist_req($userid);
            if(!empty($userproj))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$userproj,'msg'=>"获取用户所属项目列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$userproj,'msg'=>"获取用户所属项目列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_user_pg_table_process($action, $user, $body)
    {
        if (isset($body["length"])) $length = $body["length"]; else  $length = "";
        if (isset($body["startseq"])) $startseq = $body["startseq"]; else  $startseq = "";
        if (isset($body["keyword"])) $keyword = $body["keyword"]; else  $keyword = "";

        $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
        $total = $uiF2cmDbObj->dbi_all_pgnum_inqury();
        $query_length = (int)($length);
        $start = (int)($startseq);
        if($query_length> $total-$start)  {$query_length = $total-$start;}

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $pgtable = $uiF2cmDbObj->dbi_user_pg_table_req($uid, $start, $query_length,$keyword);
            $ret = array('start'=> (string)$start,'total'=> (string)$total,'length'=>(string)$query_length,'pgtable'=>$pgtable);
            if(!empty($pgtable))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取用户授权项目组列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取用户授权项目组列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_pg_new_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result = $uiF2cmDbObj->dbi_pginfo_new($uid, $body);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"项目组新增成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"项目组新增失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_pg_modify_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result = $uiF2cmDbObj->dbi_pginfo_modify($body);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"项目组信息修改成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"项目组信息修改失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_pg_del_process($action, $user, $body)
    {
        if (isset($body["PGCode"])) $pgid = $body["PGCode"]; else  $pgid = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result = $uiF2cmDbObj->dbi_pginfo_delete($pgid);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"删除一个项目组成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"删除一个项目组失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_pg_project_process($action, $user, $body)
    {
        if (isset($body["PGCode"])) $pgid = $body["PGCode"]; else  $pgid = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $projlist = $uiF2cmDbObj->dbi_pg_projlist_req($pgid);
            if(!empty($projlist))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$projlist,'msg'=>"获取项目组下项目列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取项目组下项目列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_project_table_process($action, $user, $body)
    {
        if (isset($body["length"])) $length = $body["length"]; else  $length = "";
        if (isset($body["startseq"])) $startseq = $body["startseq"]; else  $startseq = "";
        if (isset($body["keyword"])) $keyword = $body["keyword"]; else  $keyword = "";

        $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
        $total = $uiF2cmDbObj->dbi_all_projnum_inqury();
        $query_length = (int)($length);
        $start = (int)($startseq);
        //if($query_length> $total-$start) {$query_length = $total-$start;}

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $projtable = $uiF2cmDbObj->dbi_all_projtable_req($uid, $start, $query_length, $keyword);
            if(!empty($projtable)){
                $ret = array('start'=> (string)$start,'total'=> (string)$total,'length'=>(string)$query_length,'projtable'=>$projtable);
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"项目列表获取成功");
            }
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"项目列表获取失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_project_new_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result = $uiF2cmDbObj->dbi_projinfo_new($uid, $body);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"新项目创建成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"新项目创建失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_project_modify_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result = $uiF2cmDbObj->dbi_projinfo_modify($body);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"项目信息修改成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"项目信息修改失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_project_delete_process($action, $user, $body)
    {
        if (isset($body["ProjCode"])) $ProjCode = $body["ProjCode"]; else  $ProjCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result = $uiF2cmDbObj->dbi_projinfo_delete($ProjCode);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"删除一个项目成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"删除一个项目失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_all_project_point_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $sitelist = $uiF2cmDbObj->dbi_user_all_proj_sitelist_req($uid);
            if(!empty($sitelist))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$sitelist,'msg'=>"获取所有项目站点列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取所有项目站点列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_one_project_point_process($action, $user, $body)
    {
        if (isset($body["ProjCode"])) $ProjCode = $body["ProjCode"]; else  $ProjCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $sitelist = $uiF2cmDbObj->dbi_one_proj_sitelist_req($ProjCode);
            if(!empty($sitelist))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$sitelist,'msg'=>"获取该项目下站点列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取该项目下站点列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_point_table_process($action, $user, $body)
    {
        if (isset($body["length"])) $length = $body["length"]; else  $length = "";
        if (isset($body["startseq"])) $startseq = $body["startseq"]; else  $startseq = "";
        if (isset($body["keyword"])) $keyword = $body["keyword"]; else  $keyword = "";

        $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
        $total = $uiF2cmDbObj->dbi_all_sitenum_inqury();
        $query_length = (int)($length);
        $start = (int)($startseq);
        if($query_length> $total-$start) {$query_length = $total-$start;}

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $sitetable = $uiF2cmDbObj->dbi_all_sitetable_req($uid, $start, $query_length, $keyword);
            if(!empty($sitetable)){
                $ret = array('start'=> (string)$start,'total'=> (string)$total,'length'=>(string)$query_length,'pointtable'=>$sitetable);
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取站点列表成功");
            }
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取站点列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_point_new_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result = $uiF2cmDbObj->dbi_siteinfo_new($body);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"新建监测点成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"新建监测点失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_point_mod_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result = $uiF2cmDbObj->dbi_siteinfo_modify($body);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"新修改监测点成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"修改监测点失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_point_delete_process($action, $user, $body)
    {
        if (isset($body["StatCode"])) $StatCode = $body["StatCode"]; else  $StatCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result = $uiF2cmDbObj->dbi_siteinfo_delete($StatCode);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"删除一个监测点成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"删除一个监测点失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_point_dev_process($action, $user, $body)
    {
        if (isset($body["StatCode"])) $StatCode = $body["StatCode"]; else  $StatCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $devlist = $uiF2cmDbObj->dbi_site_devlist_req($StatCode);
            if(!empty($devlist))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$devlist,'msg'=>"获取该站点下设备列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取该站点下设备列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_dev_table_process($action, $user, $body)
    {
        if (isset($body["length"])) $length = $body["length"]; else  $length = "";
        if (isset($body["startseq"])) $startseq = $body["startseq"]; else  $startseq = "";
        if (isset($body["keyword"])) $keyword = $body["keyword"]; else  $keyword = "";

        $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
        $total = $uiF2cmDbObj->dbi_all_hcunum_inqury();
        $query_length = (int)($length);
        $start = (int)($startseq);
        if($query_length> $total-$start) {$query_length = $total-$start;}

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $devtable = $uiF2cmDbObj->dbi_all_hcutable_req($uid, $start, $query_length, $keyword);
            if(!empty($devtable)){
                $ret = array('start'=> (string)$start,'total'=> (string)$total,'length'=>(string)$query_length,'devtable'=>$devtable);
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取设备列表成功");
            }
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取设备列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_dev_new_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result = $uiF2cmDbObj->dbi_devinfo_update($body);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"新增监测设备成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"新增监测设备失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_dev_mod_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result = $uiF2cmDbObj->dbi_devinfo_update($body);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"修改监测设备信息成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"修改监测设备信息失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_dev_delete_process($action, $user, $body)
    {
        if (isset($body["DevCode"])) $DevCode = $body["DevCode"]; else  $DevCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result = $uiF2cmDbObj->dbi_deviceinfo_delete($DevCode);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"删除设备信息成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"删除设备信息失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    /*********************************智能云锁新增处理 Start*********************************************/
    function func_fhys_project_delete_process($action, $user, $body)
    {
        if (isset($body["ProjCode"])) $ProjCode = $body["ProjCode"]; else  $ProjCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result1 = $uiF2cmDbObj->dbi_fhys_projkey_delete($ProjCode); //针对云控锁项目，删除归属于该项目的钥匙和相应授权
            $result2 = $uiF2cmDbObj->dbi_projinfo_delete($ProjCode);
            if($result1 AND $result2)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"删除一个项目成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"删除一个项目失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_fhys_point_delete_process($action, $user, $body)
    {
        if (isset($body["StatCode"])) $StatCode = $body["StatCode"]; else  $StatCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result1 = $uiF2cmDbObj->dbi_site_keyauth_delete($StatCode); //针对云控锁项目，删除归属于该站点的相应钥匙授权
            $result2 = $uiF2cmDbObj->dbi_siteinfo_delete($StatCode);
            if($result1 AND $result2)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"删除一个监测点成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"删除一个监测点失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_fhys_dev_delete_process($action, $user, $body)
    {
        if (isset($body["DevCode"])) $DevCode = $body["DevCode"]; else  $DevCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result = $uiF2cmDbObj->dbi_fhys_deviceinfo_delete($DevCode);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"删除设备信息成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"删除设备信息失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_project_userkey_process($action, $user, $body)
    {
        if (isset($body["userid"])) $uid = $body["userid"]; else  $uid = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $user_keylist = $uiF2cmDbObj->dbi_project_userkey_process($uid);
            if(!empty($user_keylist))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$user_keylist,'msg'=>"获取用户钥匙列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取用户钥匙列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_all_projkey_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $all_projkey = $uiF2cmDbObj->dbi_all_projkey_process($uid);
            if(!empty($all_projkey))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$all_projkey,'msg'=>"查询所有项目钥匙列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"查询所有项目钥匙列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_project_keylist_process($action, $user, $body)
    {
        if (isset($body["ProjCode"])) $projCode = $body["ProjCode"]; else  $projCode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $proj_keylist = $uiF2cmDbObj->dbi_project_keylist_process($projCode);
            if(!empty($proj_keylist))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$proj_keylist,'msg'=>"获取项目钥匙列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取项目钥匙列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_all_projkeyuser_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $all_keyuser = $uiF2cmDbObj->dbi_all_projkeyuser_process($uid);
            if(!empty($all_keyuser))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$all_keyuser,'msg'=>"获取项目钥匙用户列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$all_keyuser,'msg'=>"获取项目钥匙用户列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_key_table_process($action, $user, $body)
    {
        if (isset($body["length"])) $length = $body["length"]; else  $length = "";
        if (isset($body["startseq"])) $startseq = $body["startseq"]; else  $startseq = "";
        if (isset($body["keyword"])) $keyword = $body["keyword"]; else  $keyword = "";

        $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
        $total = $uiF2cmDbObj->dbi_all_keynum_inqury();
        $query_length = (int)($length);
        $start = (int)($startseq);
        if($query_length> $total-$start) {$query_length = $total-$start;}

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $key_table = $uiF2cmDbObj->dbi_all_keytable_req($uid, $start, $query_length, $keyword);
            if(!empty($key_table)){
                $ret = array('start'=> (string)$start,'total'=> (string)$total,'length'=>(string)$query_length,'keytable'=>$key_table);
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"钥匙列表获取成功");
            }
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"钥匙列表获取失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_key_new_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result = $uiF2cmDbObj->dbi_key_new_process($body);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"新建钥匙成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"新建钥匙失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_key_mod_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result = $uiF2cmDbObj->dbi_key_mod_process($body);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"修改钥匙成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"修改钥匙失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_key_del_process($action, $user, $body)
    {
        if (isset($body["KeyCode"])) $keyid = $body["KeyCode"]; else  $keyid = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result = $uiF2cmDbObj->dbi_key_del_process($keyid);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"删除钥匙成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"删除钥匙失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_obj_authlist_process($action, $user, $body)
    {
        if (isset($body["DomainCode"])) $authobjcode = $body["DomainCode"]; else  $authobjcode = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $authlist = $uiF2cmDbObj->dbi_obj_authlist_process($authobjcode);
            if(!empty($authlist))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$authlist,'msg'=>"查询授权对象下所有的授权信息列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"查询授权对象下所有的授权信息列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_key_authlist_process($action, $user, $body)
    {
        if (isset($body["KeyCode"])) $keyid = $body["KeyCode"]; else  $keyid = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $authlist = $uiF2cmDbObj->dbi_key_authlist_process($keyid);
            if(!empty($authlist))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$authlist,'msg'=>"获取指定钥匙下授权信息列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取指定钥匙下授权信息列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_key_grant_process($action, $user, $body)
    {
        if (isset($body["KeyCode"])) $keyid = $body["KeyCode"]; else  $keyid = "";
        if (isset($body["UserId"])) $userid = $body["UserId"]; else  $userid = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result = $uiF2cmDbObj->dbi_key_grant_process($keyid, $userid);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"钥匙使用人授予成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"钥匙使用人授予失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_key_authnew_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result = $uiF2cmDbObj->dbi_key_authnew_process($body);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"钥匙新建授权成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"钥匙新建授权失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_key_authdel_process($action, $user, $body)
    {
        if (isset($body["AuthId"])) $authid = $body["AuthId"]; else  $authid = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $result = $uiF2cmDbObj->dbi_key_authdel_process($authid);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"钥匙授权删除成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"钥匙授权删除失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    //用于FHYS临时纤芯资源管理
    function func_get_rtutable_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $uiF1symDbObj->dbi_session_check($user);
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $resp = $uiF2cmDbObj->dbi_fhys_get_rtutable_req($uid);
            if(!empty($resp)){
                $ret = array('ColumnName' => $resp["column"],'TableData' => $resp["data"]);
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取RTU表成功");
            }
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取RTU表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }
    //用于FHYS临时纤芯资源管理
    function func_get_otdrtable_process($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $uiF1symDbObj->dbi_session_check($user);
            $uiF2cmDbObj = new classDbiL3apF2cm(); //初始化一个UI DB对象
            $resp = $uiF2cmDbObj->dbi_fhys_get_otdrtable_req($uid);
            if(!empty($resp)){
                $ret = array('ColumnName' => $resp["column"],'TableData' => $resp["data"]);
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取OTDR表成功");
            }
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>"获取OTDR表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l3apl_f2cm_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());
        $project ="";

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3APPL_FUM2CM", "mfun_l3apl_f2cm_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        else{
            //解开消息
            if (isset($msg["action"])) $action = $msg["action"]; else  $action = "";
            if (isset($msg["type"])) $type = $msg["type"]; else  $type = "";
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            if (isset($msg["body"])) $body = $msg["body"]; else  $body = "";
        }

        //多条消息发送到L3APPL_F2CM，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3APPL_FUM2CM", "mfun_l3apl_f2cm_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        switch($msgId)
        {
            case MSG_ID_L4AQYCUI_TO_L3F2_TABLEQUERY://功能Tabel Query
                $resp = $this->func_print_excel_table_query_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_PROJECTPGLIST://功能Project Pg List
                $resp = $this->func_all_project_pg_list_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_PROJECTLIST://功能Project List
                $resp = $this->func_all_project_list_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_USERPROJ://功能User Project
                $resp = $this->func_user_project_list_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_PGTABLE://功能PG Table
                $resp = $this->func_user_pg_table_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_PGNEW://功能PG New
                $resp = $this->func_pg_new_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_PGMOD://功能PG Mod
                $resp = $this->func_pg_modify_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_PGDEL://功能PG Del
                $resp = $this->func_pg_del_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_PGPROJ://功能PG Project
                $resp = $this->func_pg_project_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_PROJTABLE://功能Project Table
                $resp = $this->func_project_table_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_PROJNEW://功能ProjNew
                $resp = $this->func_project_new_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_PROJMOD://功能ProjMod
                $resp = $this->func_project_modify_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_PROJDEL://功能ProjDel
                $resp = $this->func_project_delete_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_ALLPROJPOINT://功能Project Point 查询所有监控点列表
                $resp = $this->func_all_project_point_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_ONEPROJPOINT://功能Point project查询该项目下面对应监控点列表
                $resp = $this->func_one_project_point_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_POINTTABLE://功能Point Table
                $resp = $this->func_point_table_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_POINTNEW://功能Point New
                $resp = $this->func_point_new_process($type, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_POINTMOD://功能Point Mod
                $resp = $this->func_point_mod_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_POINTDEL://功能Point Del
                $resp = $this->func_point_delete_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_POINTDEV://功能Point Dev
                $resp = $this->func_point_dev_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_DEVTABLE://功能Dev Table
                $resp = $this->func_dev_table_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_DEVNEW://功能Dev New
                $resp = $this->func_dev_new_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_DEVMOD://功能Dev Mod
                $resp = $this->func_dev_mod_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4AQYCUI_TO_L3F2_DEVDEL://功能Dev Del
                $resp = $this->func_dev_delete_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            /*********************************智能云锁新增处理 Start*********************************************/
            case MSG_ID_L4FHYSUI_TO_L3F2_PROJDEL://功能ProjDel
                $resp = $this->func_fhys_project_delete_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F2_POINTDEL://功能Point Del
                $resp = $this->func_fhys_point_delete_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F2_DEVDEL://功能Dev Del
                $resp = $this->func_fhys_dev_delete_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_AQYCUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F2_USERKEY:
                $resp = $this->func_project_userkey_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F2_PROJKEYLIST:
                $resp = $this->func_all_projkey_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F2_PROJKEY:
                $resp = $this->func_project_keylist_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F2_PROJKEYUSERLIST:
                $resp = $this->func_all_projkeyuser_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F2_KEYTABLE:
                $resp = $this->func_key_table_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F2_KEYNEW:
                $resp = $this->func_key_new_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F2_KEYMOD:
                $resp = $this->func_key_mod_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F2_KEYDEL:
                $resp = $this->func_key_del_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F2_OBJAUTHLIST:
                $resp = $this->func_obj_authlist_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F2_KEYAUTHLIST:
                $resp = $this->func_key_authlist_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F2_KEYGRANT:
                $resp = $this->func_key_grant_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F2_KEYAUTHNEW:
                $resp = $this->func_key_authnew_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F2_KEYAUTHDEL:
                $resp = $this->func_key_authdel_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F2_RTUTABLE:
                $resp = $this->func_get_rtutable_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            case MSG_ID_L4FHYSUI_TO_L3F2_OTDRTABLE:
                $resp = $this->func_get_otdrtable_process($action, $user, $body);
                $project = MFUN_PRJ_HCU_FHYSUI;
                break;

            default :
                $resp = ""; //啥都不ECHO
                break;
        }

        //返回ECHO
        if (!empty($resp))
        {
            $jsonencode = json_encode($resp, JSON_UNESCAPED_UNICODE);
            $log_content = "T:" . $jsonencode;
            $loggerObj->logger($project, "MFUN_TASK_ID_L3APPL_FUM2CM", $log_time, $log_content);
            echo trim($jsonencode);
        }

        //返回
        return true;
    }

}//End of class_task_service

?>