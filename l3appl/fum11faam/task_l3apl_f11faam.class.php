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

    function func_faam_factory_codelist_query($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $codeList = $uiF11faamDbObj->dbi_faam_factory_codelist_query($uid);
            if(!empty($codeList))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$codeList,'msg'=>"获取工厂代码列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$codeList,'msg'=>"获取工厂代码列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_factory_table_query($action, $user, $body)
    {
        if (isset($body["length"])) $length = $body["length"]; else  $length = "";
        if (isset($body["startseq"])) $startseq = $body["startseq"]; else  $startseq = "";
        if (isset($body["keyword"])) $keyWord = $body["keyword"]; else  $keyWord = "";

        $uiF1symDbObj = new classDbiL3apF1sym();
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $uiF11faamDbObj = new classDbiL3apF11faam(); //初始化一个UI DB对象
            $total = (int)($length);  //多工厂时要按照授权工厂查询数量
            $query_length = (int)($length);
            $start = (int)($startseq);
            if($query_length > $total-$start) $query_length = $total-$start;

            $factoryTable = $uiF11faamDbObj->dbi_faam_factory_table_query($uid,$start, $query_length,$keyWord);
            if(!empty($factoryTable)){
                $ret = array('start'=> (string)$start,'total'=> (string)$total,'length'=>(string)$query_length,'factorytable'=>$factoryTable);
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取工厂信息列表成功");
            }
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>"获取工厂信息列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_factory_table_modify($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $result = $uiF11faamDbObj->dbi_faam_factory_table_modify($body);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"工厂信息修改成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"工厂信息修改失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_factory_table_new($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $result = $uiF11faamDbObj->dbi_faam_factory_table_new($body);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"工厂信息新建成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"工厂信息新建失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_factory_table_delete($action, $user, $body)
    {
        if (isset($body["factoryid"])) $factoryId = $body["factoryid"]; else  $factoryId = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $result = $uiF11faamDbObj->dbi_faam_factory_table_delete($factoryId);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"工厂信息删除成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"工厂信息删除失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_product_type_query($action, $user, $body)
    {
        if (isset($body["length"])) $length = $body["length"]; else  $length = "";
        if (isset($body["startseq"])) $startseq = $body["startseq"]; else  $startseq = "";
        if (isset($body["keyword"])) $keyWord = $body["keyword"]; else  $keyWord = "";

        $uiF1symDbObj = new classDbiL3apF1sym();
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $uiF11faamDbObj = new classDbiL3apF11faam(); //初始化一个UI DB对象
            $total = $uiF11faamDbObj->dbi_faam_product_type_num_inqury($uid);
            $query_length = (int)($length);
            $start = (int)($startseq);
            if($query_length > $total-$start) $query_length = $total-$start;

            $productType = $uiF11faamDbObj->dbi_faam_product_type_table_query($uid,$start, $query_length,$keyWord);
            if(!empty($productType)){
                $ret = array('start'=> (string)$start,'total'=> (string)$total,'length'=>(string)$query_length,'specificationtable'=>$productType);
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取产品规格列表成功");
            }
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>"获取产品规格列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_product_type_modify($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $result = $uiF11faamDbObj->dbi_faam_product_type_modify($body);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"产品规格信息修改成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"产品规格信息修改失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_product_type_new($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $result = $uiF11faamDbObj->dbi_faam_product_type_new($uid, $body);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"产品规格信息新建成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"产品规格信息新建失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_product_type_delete($action, $user, $body)
    {
        if (isset($body["specificationid"])) $typeId = $body["specificationid"]; else  $typeId = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $result = $uiF11faamDbObj->dbi_faam_product_type_delete($typeId);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"产品规格信息删除成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"产品规格信息删除失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_staff_namelist_query($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $nameList = $uiF11faamDbObj->dbi_faam_staff_namelist_query($uid);
            if(!empty($nameList))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$nameList,'msg'=>"获取员工姓名列表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$nameList,'msg'=>"获取员工姓名列表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    //查询员工信息表
    function func_faam_staff_table_query($action, $user, $body)
    {
        if (isset($body["length"])) $length = $body["length"]; else  $length = "";
        if (isset($body["startseq"])) $startseq = $body["startseq"]; else  $startseq = "";
        if (isset($body["keyword"])) $keyWord = $body["keyword"]; else  $keyWord = "";
        if (isset($body["containleave"])) $containLeave = $body["containleave"]; else  $containLeave = "";

        $uiF1symDbObj = new classDbiL3apF1sym();
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $uiF11faamDbObj = new classDbiL3apF11faam(); //初始化一个UI DB对象
            $total = $uiF11faamDbObj->dbi_faam_employeenum_inqury($uid);
            $query_length = (int)($length);
            $start = (int)($startseq);
            if($query_length > $total-$start) $query_length = $total-$start;
            $staffTable = $uiF11faamDbObj->dbi_faam_stafftable_query($uid,$start, $query_length,$keyWord,$containLeave);
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
            $result = $uiF11faamDbObj->dbi_faam_staff_table_new($body);
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
            $result = $uiF11faamDbObj->dbi_faam_staff_table_modify($body);
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
        if (isset($body["Timestart"])) $timeStart = $body["Timestart"]; else  $timeStart = "";
        if (isset($body["Timeend"])) $timeEnd = $body["Timeend"]; else  $timeEnd = "";
        if (isset($body["KeyWord"])) $keyWord = $body["KeyWord"]; else  $keyWord = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $resp = $uiF11faamDbObj->dbi_faam_attendance_history_query($uid, $timeStart, $timeEnd, $keyWord);
            $ret = array('ColumnName' => $resp["ColumnName"],'TableData' => $resp["TableData"]);
            if(!empty($resp['TableData']))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取考勤历史记录表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取考勤历史记录表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_attendance_history_audit($action, $user, $body)
    {
        if (isset($body["TimeStart"])) $timeStart = $body["TimeStart"]; else  $timeStart = "";
        if (isset($body["TimeEnd"])) $timeEnd = $body["TimeEnd"]; else  $timeEnd = "";
        if (isset($body["KeyWord"])) $keyWord = $body["KeyWord"]; else  $keyWord = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $resp = $uiF11faamDbObj->dbi_faam_attendance_history_audit($uid, $timeStart, $timeEnd, $keyWord);
            $ret = array('ColumnName' => $resp["ColumnName"],'TableData' => $resp["TableData"]);
            if(!empty($resp['TableData']))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取考勤历史统计表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取考勤历史统计表失败");
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
            $uid = $usercheck['uid'];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $result = $uiF11faamDbObj->dbi_faam_attendance_record_new($uid, $body);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"新建一条考勤记录成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"新建一条考勤记录失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_attendance_record_batch_add($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $result = $uiF11faamDbObj->dbi_faam_attendance_record_batch_add($uid);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"批量添加考勤记录成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"批量添加考勤记录失败");
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
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"删除一条考勤记录成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"删除一条考勤记录失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_attendance_record_get($action, $user, $body)
    {
        if (isset($body["attendanceID"])) $recordId = $body["attendanceID"]; else  $recordId = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $record = $uiF11faamDbObj->dbi_faam_attendance_record_get($recordId);
            if(!empty($record))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$record,'msg'=>"查询一条考勤记录成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>array(),'msg'=>"查询一条考勤记录失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_attendance_record_modify($action, $user, $body)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $result = $uiF11faamDbObj->dbi_faam_attendance_record_modify($uid, $body);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"修改一条考勤记录成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"修改一条考勤记录失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_production_history_query($action, $user, $body)
    {
        if (isset($body["TimeStart"])) $timeStart = $body["TimeStart"]; else  $timeStart = "";
        if (isset($body["TimeEnd"])) $timeEnd = $body["TimeEnd"]; else  $timeEnd = "";
        if (isset($body["KeyWord"])) $keyWord = $body["KeyWord"]; else  $keyWord = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $resp = $uiF11faamDbObj->dbi_faam_production_history_query($uid, $timeStart, $timeEnd, $keyWord);
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

    function func_faam_production_history_audit($action, $user, $body)
    {
        if (isset($body["TimeStart"])) $timeStart = $body["TimeStart"]; else  $timeStart = "";
        if (isset($body["TimeEnd"])) $timeEnd = $body["TimeEnd"]; else  $timeEnd = "";
        if (isset($body["KeyWord"])) $keyWord = $body["KeyWord"]; else  $keyWord = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $resp = $uiF11faamDbObj->dbi_faam_production_history_audit($uid, $timeStart, $timeEnd, $keyWord);
            $ret = array('ColumnName' => $resp["ColumnName"],'TableData' => $resp["TableData"]);
            if(!empty($resp['TableData']))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取生产历史统计表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取生产历史统计表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }

    function func_faam_employee_kpi_audit($action, $user, $body)
    {
        if (isset($body["TimeStart"])) $timeStart = $body["TimeStart"]; else  $timeStart = "";
        if (isset($body["TimeEnd"])) $timeEnd = $body["TimeEnd"]; else  $timeEnd = "";
        if (isset($body["KeyWord"])) $keyWord = $body["KeyWord"]; else  $keyWord = "";

        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $resp = $uiF11faamDbObj->dbi_faam_employee_kpi_audit($uid, $timeStart, $timeEnd, $keyWord);
            $ret = array('ColumnName' => $resp["ColumnName"],'TableData' => $resp["TableData"]);
            if(!empty($resp['TableData']))
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取员工绩效统计表成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>$ret,'msg'=>"获取员工绩效统计表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'ret'=>"",'msg'=>$usercheck['msg']);

        return $retval;
    }
    /**************************************自己更改起始处*********************************************************/
    function func_faam_consumables_buys($action, $user, $body)
    {
        $reason="正常入库";
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $usercheck = $uiF1symDbObj->dbi_user_authcheck($action, $user);
        if($usercheck['status']=="true" AND $usercheck['auth']=="true") { //用户session没有超时且有权限做此操作
            $uid = $usercheck['uid'];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $result = $uiF11faamDbObj->dbi_faam_consumables_buy($uid,$body,$reason);
            if($result == true)
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"入库成功");
            else
                $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>"入库失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);

        return $retval;
    }
    function func_faam_consumables_table($action, $user, $body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $resp = $uiF11faamDbObj->dbi_faam_consumables_table($uid);
            if(!empty($resp))
                $retval = array('status' => $usercheck['status'], 'auth' => $usercheck['auth'], 'ret' => $resp, 'msg' => "获取耗材表成功");
            else
                $retval = array('status' => $usercheck['status'], 'auth' => $usercheck['auth'], 'ret' => $resp, 'msg' => "获取耗材表失败");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    function func_faam_consumables_history($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        $timeStart="0000-00-00";
        $timeEnd=date("Y-m-d",time());
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            switch($body["Item"]){
                case "0";$key="";break;
                case "1":$key="纸箱";break;
                case "2";$key="保鲜袋";break;
                case "3":$key="胶带";break;
                case "4";$key="标签";break;
                case "5":$key="托盘";break;
                case "6";$key="垫片";break;
                case "7":$key="网套";break;
                case "8";$key="打包带";break;
                default:break;
            }
            switch($body["Period"]){
                case "1":$timeStart=$timeEnd;break;;
                case "7":$timeStart=date('Y-m-d', strtotime("-6 day"));break;
                case "30":$timeStart=date('Y-m-d',strtotime("-29 day"));break;
                default;break;
            }
            $timeStart=$timeStart." 00:00:00";
            $timeEnd=$timeEnd." 23:59:59";
            $keyWord=$body["KeyWord"];
            $resp = $uiF11faamDbObj->dbi_faam_consumables_history_table($uid,$key,$timeStart,$timeEnd,$keyWord);
            $retval = array('status' => $usercheck['status'], 'auth' => $usercheck['auth'], 'ret' => $resp, 'msg' => "获取耗材表成功");
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //获取一条信息
    function func_faam_get_consumbales_purchase($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        $sid=$body["consumablespurchaseID"];
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $resp=$uiF11faamDbObj->dbi_faam_get_consumbales_purchase($sid);
            if(!empty($resp)) {
                $retval = array('status' => $usercheck['status'], 'auth' => $usercheck['auth'], 'ret' => $resp, 'msg' => "获取耗材信息成功");
            }
            else{
                $retval = array('status' => $usercheck['status'], 'auth' => $usercheck['auth'], 'ret' => $resp, 'msg' => "获取耗材信息失败");
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //修改一条信息
    function func_faam_consumables_purchase_mod($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);

        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $resp=$uiF11faamDbObj->dbi_faam_consumables_purchase_mod($body);
            if($resp){
                $retval=array('status'=>$usercheck['status'],'msg'=>'success','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'msg'=>'failed','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //删除一条信息
    function func_faam_consumables_purchase_del($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);

        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $resp=$uiF11faamDbObj->dbi_faam_consumables_purchase_del($body);
            if($resp){
                $retval=array('status'=>$usercheck['status'],'msg'=>'success','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'msg'=>'failed','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //仓库增加
    function func_faam_product_stock_new($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);

        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $resp=$uiF11faamDbObj->dbi_faam_product_stock_new($body);
            if($resp){
                $retval=array('status'=>$usercheck['status'],'msg'=>'success','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'msg'=>'failed','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //获取产品的重量和大小
    function func_faam_get_product_weight_size($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $resp=$uiF11faamDbObj->dbi_faam_get_product_weight_size();
            if($resp){
                $retlist = array('weight'=>$resp["weight"], 'size'=>$resp["size"]);
                $retval=array('status'=>$usercheck['status'], 'ret'=>$retlist, 'msg'=>'success', 'auth'=>'true');
            }
            else{
                $retval=array('status'=>$usercheck['status'], 'ret'=>"", 'msg'=>'failed', 'auth'=>'true');
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }

    //获取尚未存货的空仓库
    function func_faam_get_product_empty_stock($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);

        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $resp=$uiF11faamDbObj->dbi_faam_get_product_empty_stock();
            if($resp){
                $retval=array('status'=>$usercheck['status'],'ret'=>$resp,'msg'=>'success','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>"",'msg'=>'failed','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //获取仓库列表
    function func_faam_get_product_stock_list($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);

        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $resp=$uiF11faamDbObj->dbi_faam_get_product_stock_list();
            if($resp){
                $retval=array('status'=>$usercheck['status'],'ret'=>$resp,'msg'=>'success','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>"",'msg'=>'failed','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //删除空仓
    function func_faam_product_stock_del($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true"){
            $uid=$usercheck["uid"];
            $uif11faamDbObj=new classDbiL3apF11faam();
            $resp=$uif11faamDbObj->dbi_faam_product_stock_del($body);
            if($resp){
                $retval=array('status'=>$usercheck['status'],'msg'=>'success','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'msg'=>'failed','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //仓库信息列表
    function func_faam_product_stock_table($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uif11faamDbObj = new classDbiL3apF11faam();
            $resp=$uif11faamDbObj->dbi_faam_product_stock_table($body);
            if($resp){
                $retval=array('status'=>$usercheck['status'],'ret'=>$resp,'msg'=>'success','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>"",'msg'=>'failed','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //查看一条入库信息
    function func_faam_get_product_stock_detail($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uif11faamDbObj = new classDbiL3apF11faam();
            $resp = $uif11faamDbObj->dbi_faam_get_product_stock_detail($body);
            if($resp){
                $retval=array('status'=>$usercheck['status'],'ret'=>$resp,'msg'=>'success','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>"",'msg'=>'failed','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //转库
    function func_faam_product_stock_transfer($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uif11faamDbObj = new classDbiL3apF11faam();
            $resp=$uif11faamDbObj->dbi_faam_product_stock_transfer($body);
            if($resp){
                $retval=array('status'=>$usercheck['status'],'ret'=>$resp,'msg'=>'转库成功','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>"",'msg'=>'转库失败','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //出库
    function func_faam_product_stock_removal_new($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uif11faamDbObj = new classDbiL3apF11faam();
            $resp=$uif11faamDbObj->dbi_faam_product_stock_removal_new($body);
            if($resp){
                $retval=array('status'=>$usercheck['status'],'ret'=>$resp,'msg'=>'转库成功','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>"",'msg'=>'转库失败','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //获取出库历史表单
    function func_faam_product_stock_history($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uif11faamDbObj = new classDbiL3apF11faam();
            $resp=$uif11faamDbObj->dbi_faam_product_stock_history($body);
            if($resp){
                $retval=array('status'=>$usercheck['status'],'ret'=>$resp,'msg'=>'success','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>"",'msg'=>'failed','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //获取一条出库信息
    function func_faam_get_product_stock_history_detail($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uif11faamDbObj = new classDbiL3apF11faam();
            $resp = $uif11faamDbObj->dbi_faam_get_product_stock_history_detail($body);
            if($resp){
                $retval=array('status'=>$usercheck['status'],'ret'=>$resp,'msg'=>'success','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>"",'msg'=>'failed','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //新建原料仓库
    function func_faam_material_stock_new($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);

        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $resp=$uiF11faamDbObj->dbi_faam_material_stock_new($body);
            if($resp){
                $retval=array('status'=>$usercheck['status'],'msg'=>'success','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'msg'=>'failed','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //获取原料仓库列表
    function func_faam_get_material_stock_list($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);

        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $resp=$uiF11faamDbObj->dbi_faam_get_material_stock_list();
            if($resp){
                $retval=array('status'=>$usercheck['status'],'ret'=>$resp,'msg'=>'success','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>"",'msg'=>'failed','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //获取原料空仓列表
    function func_faam_get_material_empty_stock($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);

        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $resp=$uiF11faamDbObj->dbi_faam_get_material_empty_stock();
            if($resp){
                $retval=array('status'=>$usercheck['status'],'ret'=>$resp,'msg'=>'success','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>"",'msg'=>'failed','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    function func_faam_material_stock_del($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true"){
            $uid=$usercheck["uid"];
            $uif11faamDbObj=new classDbiL3apF11faam();
            $resp=$uif11faamDbObj->dbi_faam_material_stock_del($body);
            if($resp){
                $retval=array('status'=>$usercheck['status'],'ret'=>'true','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>'false','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //显示原材料仓库的信息
    function func_faam_material_stock_table($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uif11faamDbObj = new classDbiL3apF11faam();
            $resp=$uif11faamDbObj->dbi_faam_material_stock_table($body);
            if($resp){
                $retval=array('status'=>$usercheck['status'],'ret'=>$resp,'msg'=>'success','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>"",'msg'=>'failed','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //显示一个仓库的信息
    function func_faam_get_material_stock_detail($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uif11faamDbObj = new classDbiL3apF11faam();
            $resp=$uif11faamDbObj->dbi_faam_get_material_stock_detail($body);
            if($resp){
                $retval=array('status'=>$usercheck['status'],'ret'=>$resp,'msg'=>'success','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>"",'msg'=>'failed','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //原料入库
    function func_faam_material_stock_income_new($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uif11faamDbObj = new classDbiL3apF11faam();
            $resp=$uif11faamDbObj->dbi_faam_material_stock_income_new($body);
            if($resp){
                $retval=array('status'=>$usercheck['status'],'ret'=>$resp,'auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>$resp,'auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //原料出库
    function func_faam_material_stock_remova_new($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uif11faamDbObj = new classDbiL3apF11faam();
            $resp=$uif11faamDbObj->dbi_faam_material_stock_remova_new($body);
            if($resp){
                $retval=array('status'=>$usercheck['status'],'ret'=>$resp,'auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>$resp,'auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //原料历史表
    function func_faam_material_stock_history($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uif11faamDbObj = new classDbiL3apF11faam();
            $resp=$uif11faamDbObj->dbi_faam_material_stock_history($body);
            if($resp){
                $retval=array('status'=>$usercheck['status'],'ret'=>$resp,'msg'=>'查看原料历史成功','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>"",'msg'=>'查看原料历史失败','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //单条历史详细信息
    function func_faam_get_material_stock_history_detail($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uif11faamDbObj = new classDbiL3apF11faam();
            $resp=$uif11faamDbObj->dbi_faam_get_material_stock_history_detail($body);
            if($resp){
                $retval=array('status'=>$usercheck['status'],'ret'=>$resp,'msg'=>'记录查看成功','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>"",'msg'=>'记录查看失败','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //更新入库信息
    function func_faam_material_stock_income_mod($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uif11faamDbObj = new classDbiL3apF11faam();
            $resp=$uif11faamDbObj->dbi_faam_material_stock_income_mod($body);
            if($resp!=""){
                $retval=array('status'=>$usercheck['status'],'msg'=>"true",'auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'msg'=>'false','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //更新出库信息
    function func_faam_material_stock_remova_mod($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uif11faamDbObj = new classDbiL3apF11faam();
            $resp=$uif11faamDbObj->dbi_faam_material_stock_remova_mod($body);
            if($resp!=""){
                $retval=array('status'=>$usercheck['status'],'ret'=>'true','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>'false','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //删除一条信息
    function func_faam_material_stock_removal_del($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uif11faamDbObj = new classDbiL3apF11faam();
            $resp=$uif11faamDbObj->dbi_faam_material_stock_removal_del($body);
            if($resp!=""){
                $retval=array('status'=>$usercheck['status'],'ret'=>'true','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>'false','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //更新成品
    function func_faam_product_stock_removal_mod($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uif11faamDbObj = new classDbiL3apF11faam();
            $resp=$uif11faamDbObj->dbi_faam_product_stock_removal_mod($body);
            if($resp!=""){
                $retval=array('status'=>$usercheck['status'],'ret'=>'true','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>'false','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //成品删除
    function func_faam_product_stock_removal_del($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uif11faamDbObj = new classDbiL3apF11faam();
            $resp=$uif11faamDbObj->dbi_faam_product_stock_removal_del($body);
            if($resp!=""){
                $retval=array('status'=>$usercheck['status'],'ret'=>'true','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>'false','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
    //获取打印报表
    function func_faam_table_query($action,$user,$body){
        $uiFlsymDbObj=new classDbiL3apF1sym();
        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);

        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
            $uid = $usercheck["uid"];
            $uiF11faamDbObj = new classDbiL3apF11faam();
            $resp=$uiF11faamDbObj->dbi_faam_table_query($uid);
            if($resp){
                $retval=array('status'=>$usercheck['status'],'ret'=>$resp,'msg'=>'success','auth'=>$usercheck['auth']);
            }
            else{
                $retval=array('status'=>$usercheck['status'],'ret'=>"",'msg'=>'failed','auth'=>$usercheck['auth']);
            }
        }
        else
            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
        return $retval;
    }
//    function func_faam_material_stock_income_del($action,$user,$body){
//        $uiFlsymDbObj=new classDbiL3apF1sym();
//        $usercheck=$uiFlsymDbObj->dbi_user_authcheck($action,$user);
//        if($usercheck["status"]=="true" AND $usercheck["auth"]=="true") {
//            $uid = $usercheck["uid"];
//            $uif11faamDbObj = new classDbiL3apF11faam();
//            $resp=$uif11faamDbObj->dbi_faam_material_stock_income_del($body);
//            if($resp!=""){
//                $retval=array('status'=>$usercheck['status'],'msg'=>'记录删除成功','auth'=>$usercheck['auth']);
//            }
//            else{
//                $retval=array('status'=>$usercheck['status'],'msg'=>'记录删除失败','auth'=>$usercheck['auth']);
//            }
//        }
//        else
//            $retval=array('status'=>$usercheck['status'],'auth'=>$usercheck['auth'],'msg'=>$usercheck['msg']);
//        return $retval;
//    }
    /**************************************自己更改终止处*********************************************************/


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
            case MSG_ID_L4FAAMUI_TO_L3F11_FACTORYCODELIST:
                $resp = $this->func_faam_factory_codelist_query($action, $user, $body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_FACTORYTABLE:
                $resp = $this->func_faam_factory_table_query($action, $user, $body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_FACTORYMOD:
                $resp = $this->func_faam_factory_table_modify($action, $user, $body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_FACTORYNEW:
                $resp = $this->func_faam_factory_table_new($action, $user, $body);
                break;

            case MSG_ID_L4FAAMUI_TO_L3F11_FACTORYDEL:
                $resp = $this->func_faam_factory_table_delete($action, $user, $body);
                break;

            case MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTTYPE:
                $resp = $this->func_faam_product_type_query($action, $user, $body);
                break;

            case MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTTYPEMOD:
                $resp = $this->func_faam_product_type_modify($action, $user, $body);
                break;

            case MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTTYPENEW:
                $resp = $this->func_faam_product_type_new($action, $user, $body);
                break;

            case MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTTYPEDEL:
                $resp = $this->func_faam_product_type_delete($action, $user, $body);
                break;

            case MSG_ID_L4FAAMUI_TO_L3F11_STAFFNAMELIST:
                $resp = $this->func_faam_staff_namelist_query($action, $user, $body);
                break;
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
            case MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCEAUDIT:
                $resp = $this->func_faam_attendance_history_audit($action, $user, $body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCERECORDNEW:
                $resp = $this->func_faam_attendance_record_new($action, $user, $body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCERECORDBATCH:
                $resp = $this->func_faam_attendance_record_batch_add($action, $user, $body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCEDEL:
                $resp = $this->func_faam_attendance_record_delete($action, $user, $body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCEGET:
                $resp = $this->func_faam_attendance_record_get($action, $user, $body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_ATTENDANCEMOD:
                $resp = $this->func_faam_attendance_record_modify($action, $user, $body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTIONHISTORY:
                $resp = $this->func_faam_production_history_query($action, $user, $body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTIONAUDIT:
                $resp = $this->func_faam_production_history_audit($action, $user, $body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_KPIAUDIT:
                $resp = $this->func_faam_employee_kpi_audit($action, $user, $body);
                break;
            /*****************************自己更改起始处*******************************************/
            case MSG_ID_L4FAAMUI_TO_L3F11_BUYCONSUMABLES:
                $resp=$this->func_faam_consumables_buys($action, $user, $body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_CONSUMABLESTABLES:
                $resp=$this->func_faam_consumables_table($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_CONSUMABLESHISTORY:
                $resp=$this->func_faam_consumables_history($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_GETCONSUMABLESPURCHASE:
                $resp=$this->func_faam_get_consumbales_purchase($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_CONSUMABLESPURCHASEMOD:
                $resp=$this->func_faam_consumables_purchase_mod($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_CONSUMABLESPUTCHASEDEL:
                $resp=$this->func_faam_consumables_purchase_del($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKNEW:
                $resp=$this->func_faam_product_stock_new($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_GETPRODUCTEMPTYSTOCK:
                $resp=$this->func_faam_get_product_empty_stock($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_GETPRODUCTWEIGHTANDSIZE:
                $resp=$this->func_faam_get_product_weight_size($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_GETPRODUCTSTOCKLIST:
                $resp=$this->func_faam_get_product_stock_list($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKDEL:
                $resp=$this->func_faam_product_stock_del($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKTABLE:
                $resp=$this->func_faam_product_stock_table($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_GETPRODUCTSTOCKDETAIL:
                $resp=$this->func_faam_get_product_stock_detail($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKREMOVALNEW:
                $resp=$this->func_faam_product_stock_removal_new($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKTRANSFER:
                $resp=$this->func_faam_product_stock_transfer($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKHISTORY:
                $resp=$this->func_faam_product_stock_history($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_GETPRODUCTSTOCKHISTORYDETAIL:
                $resp=$this->func_faam_get_product_stock_history_detail($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_MATERIALSTOCKNEW:
                $resp=$this->func_faam_material_stock_new($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_GETMATERIALSTOCKLIST:
                $resp=$this->func_faam_get_material_stock_list($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_GETMATERIALEMPTYSTOCK:
                $resp=$this->func_faam_get_material_empty_stock($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_MATERIALSTOCKDEL:
                $resp=$this->func_faam_material_stock_del($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_MATERIALSTOCKTABLE:
                $resp=$this->func_faam_material_stock_table($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_GETMATERIALSTOCKDETAIL:
                $resp=$this->func_faam_get_material_stock_detail($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_MATERIALSTOCKINCOMENEW:
                $resp=$this->func_faam_material_stock_income_new($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_MATERIALSTOCKREMOVANEW:
                $resp=$this->func_faam_material_stock_remova_new($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_MATERIALSTOCKHISTORY:
                $resp=$this->func_faam_material_stock_history($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_GETMATERIALSTOCKHISTORYDETAIL:
                $resp=$this->func_faam_get_material_stock_history_detail($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_METERIALSTOCKINCOMEMOD:
                $resp=$this->func_faam_material_stock_income_mod($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_METERIALSTOCKREMOVAMOD:
                $resp=$this->func_faam_material_stock_remova_mod($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_METERIALSTOCKREMOVALDEL:
                $resp=$this->func_faam_material_stock_removal_del($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKREMOVALMOD:
                $resp=$this->func_faam_product_stock_removal_mod($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_PRODUCTSTOCKREMOVALDEL:
                $resp=$this->func_faam_product_stock_removal_del($action,$user,$body);
                break;
            case MSG_ID_L4FAAMUI_TO_L3F11_TABLEQUERY:
                $resp=$this->func_faam_table_query($action,$user,$body);
                break;
//            case MSG_ID_L4FAAMUI_TO_L3F11_MATERIALSTOCKINCOMEDEL:
//                $resp=$this->func_faam_material_stock_income_del($action,$user,$body);
//                break;
            /*****************************自己更改终止处*******************************************/
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