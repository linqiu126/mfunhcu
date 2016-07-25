<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:34
 */
//include_once "../../l1comvm/vmlayer.php";
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

    function func_project_del_process($ProjCode)
    {
        $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
        $result = $uiF3dmDbObj->dbi_projinfo_delete($ProjCode);
        if ($result == true)
            $retval=array(
                'status'=>'true',
                'msg'=>'成功删除一个项目'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'删除一个项目失败'
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    //传入的参数为假的，没用，因为如果不传参数的话，意味着msgBody为空，不符合VM的整体精神
    function func_project_point_process($user)
    {
        $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
        $sitelist = $uiF3dmDbObj->dbi_all_sitelist_req();
        if(!empty($sitelist))
            $retval=array(
                'status'=>'true',
                'ret'=> $sitelist
            );
        else
            $retval=array(
                'status'=>'false',
                'ret'=> null
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_point_project_process($ProjCode)
    {
        $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
        $sitelist = $uiF3dmDbObj->dbi_proj_sitelist_req($ProjCode);
        if(!empty($sitelist))
            $retval=array(
                'status'=>'true',
                'ret'=> $sitelist
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

    function func_point_table_process($length, $startseq)
    {
        $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
        $total = $uiF3dmDbObj->dbi_all_sitenum_inqury();
        $query_length = (int)($length);
        $start = (int)($startseq);
        if($query_length> $total-$start)
        {$query_length = $total-$start;}
        $sitetable = $uiF3dmDbObj->dbi_all_sitetable_req($start, $query_length);
        if(!empty($sitetable))
            $retval=array(
                'status'=>'true',
                'start'=> (string)$start,
                'total'=> (string)$total,
                'length'=>(string)$query_length,
                'ret'=> $sitetable
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

    function func_point_new_process($siteinfo)
    {
        $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
        $result = $uiF3dmDbObj->dbi_siteinfo_update($siteinfo);
        if ($result == true)
            $retval=array(
                'status'=>'true',
                'msg'=>'新建监测点成功'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'新建监测点失败'
            );

        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_point_mod_process($siteinfo)
    {
        $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
        $result = $uiF3dmDbObj->dbi_siteinfo_update($siteinfo);
        if ($result == true)
            $retval=array(
                'status'=>'true',
                'msg'=>'新修改监测点成功'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'修改监测点失败'
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_point_del_process($StatCode)
    {
        $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
        $result = $uiF3dmDbObj->dbi_siteinfo_delete($StatCode);
        if ($result)
            $retval=array(
                'status'=>'true',
                'msg'=>'成功删除一个监测点'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'删除一个监测点失败'
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_point_dev_process($StatCode)
    {
        $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
        $devlist = $uiF3dmDbObj->dbi_site_devlist_req($StatCode);
        if(!empty($devlist))
            $retval=array(
                'status'=>"true",
                'ret'=> $devlist
            );
        else
            $retval=array(
                'status'=>"true",
                'ret'=> ""
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_dev_table_process($length, $startseq)
    {
        $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
        $uiSdkDbObj = new classDbiL2sdkHcu();
        $total = $uiSdkDbObj->dbi_all_hcunum_inqury();
        $query_length = (int)($length);
        $start = (int)($startseq);
        if($query_length> $total-$start)
        {$query_length = $total-$start;}
        $devtable = $uiF3dmDbObj->dbi_all_hcutable_req($start,$query_length);
        if(!empty($devtable))
            $retval=array(
                'status'=>'true',
                'start'=> (string)$start,
                'total'=> (string)$total,
                'length'=>(string)$query_length,
                'ret'=> $devtable
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

    function func_dev_new_process($devinfo)
    {
        $uiSdkDbObj = new classDbiL2sdkHcu();
        $result = $uiSdkDbObj->dbi_devinfo_update($devinfo);
        if ($result == true)
            $retval=array(
                'status'=>'true',
                'msg'=>'新增监测设备成功'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'新增监测设备失败'
            );
        $retval=array(
            'status'=>'true',
            'msg'=>''
        );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_dev_mod_process($devinfo)
    {
        $uiSdkDbObj = new classDbiL2sdkHcu();
        $result = $uiSdkDbObj->dbi_devinfo_update($devinfo);
        if ($result == true)
            $retval=array(
                'status'=>'true',
                'msg'=>'修改监测设备信息成功'
            );
        else
            $retval=array(
                'status'=>'false',
                'msg'=>'修改监测设备信息失败'
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_dev_del_process($DevCode)
    {
        $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
        $result = $uiF3dmDbObj->dbi_deviceinfo_delete($DevCode);
        if ($result)
            $retval=array(
                'status'=>'true',
                'msg'=>'删除HCU设备成功'
            );
        else
            $retval=array(
                'status'=>'true',
                'msg'=>'删除HCU设备失败'
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_monitor_list_process($uid)
    {
        $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
        $stat_list = $uiF3dmDbObj->dbi_map_sitetinfo_req($uid);
        if(!empty($stat_list))
            $retval=array(
                'status'=>'true',
                'id'=>$uid,
                'ret'=> $stat_list
            );
        else
            $retval=array(
                'status'=>'false',
                'id'=>$uid,
                'ret'=> null
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    //传入的参数为假的，没用，因为如果不传参数的话，意味着msgBody为空，不符合VM的整体精神
    function func_sensor_type_list_process($user)
    {
        $uiL2snrDbObj = new classDbiL2snrCom();
        $alarm_type = $uiL2snrDbObj->dbi_all_alarmtype_req();
        if(!empty($alarm_type))
            $retval=array(
                'status'=>'true',
                'typelist'=> $alarm_type
            );
        else
            $retval=array(
                'status'=>'false',
                'typelist'=> null
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_table_query_process($TableName, $Condition)
    {
        $uiL2snrDbObj = new classDbiL2snrCom();
        $result = $uiL2snrDbObj->dbi_excel_historydata_req($Condition);
        if(!empty($result))
            $retval=array(
                'status'=>'true',
                'ColumnName' => $result["column"],
                'TableData' => $result["data"]
            );
        else
            $retval=array(
                'status'=>'false',
                'ColumnName' => null,
                'TableData' => null
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    //传入的参数为假的，没用，因为如果不传参数的话，意味着msgBody为空，不符合VM的整体精神
    function func_sensor_list_process($user)
    {
        $uiL2snrDbObj = new classDbiL2snrCom();
        $sensor_list = $uiL2snrDbObj->dbi_all_sensorlist_req();
        if(!empty($sensor_list))
            $retval=array(
                'status'=>'true',
                'SensorList'=> $sensor_list
            );
        else
            $retval=array(
                'status'=>'false',
                'SensorList'=> null
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_dev_sensor_process($DevCode)
    {
        $uiL2snrDbObj = new classDbiL2snrCom();
        $sensorinfo = $uiL2snrDbObj->dbi_dev_sensorinfo_req($DevCode);
        if(!empty($sensorinfo))
            $retval=array(
                'status'=>'true',
                'ret'=>$sensorinfo
            );
        else
            $retval=array(
                'status'=>'false',
                'ret'=>null
            );
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }

    function func_get_static_monitor_table_process($id)
    {
        $uiF1symDbObj = new classDbiL3apF1sym(); //初始化一个UI DB对象
        $uiF3dmDbObj = new classDbiL3apF3dm(); //初始化一个UI DB对象
        $uid = $uiF1symDbObj->dbi_session_check($id);
        $result = $uiF3dmDbObj->dbi_user_dataaggregate_req($uid);
        if(!empty($result))
            $retval=array(
                'status'=>'true',
                'ColumnName' => $result["column"],
                'TableData' => $result["data"]
            );
        else
            $retval=array(
                'status'=>'false',
                'ColumnName' => null,
                'TableData' => null
            );
        //$jsonencode = _encode($retval);
        $jsonencode = json_encode($retval, JSON_UNESCAPED_UNICODE);
        return $jsonencode;
    }



    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l3apl_f3dm_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());
        $project ="";

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3APPL_FUM3DM", "mfun_l3apl_f3dm_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到L3APPL_F3DM，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L3APPL_FUM3DM", "mfun_l3apl_f3dm_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        //功能ProjDel
        if ($msgId == MSG_ID_L4AQYCUI_TO_L3F3_PROJDEL)
        {
            //解开消息
            if (isset($msg["ProjCode"])) $ProjCode = $msg["ProjCode"]; else  $ProjCode = "";
            //具体处理函数
            $resp = $this->func_project_del_process($ProjCode);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能Project Point 查询所有监控点列表
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F3_PROJPOINT)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_project_point_process($user);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能Point project查询该项目下面对应监控点列表
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F3_POINTPROJ)
        {
            //解开消息
            if (isset($msg["ProjCode"])) $ProjCode = $msg["ProjCode"]; else  $ProjCode = "";
            //具体处理函数
            $resp = $this->func_point_project_process($ProjCode);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能Point Table
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F3_POINTTABLE)
        {
            //解开消息
            if (isset($msg["length"])) $length = $msg["length"]; else  $length = "";
            if (isset($msg["startseq"])) $startseq = $msg["startseq"]; else  $startseq = "";
            //具体处理函数
            $resp = $this->func_point_table_process($length, $startseq);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能Point New
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F3_POINTNEW)
        {
            //解开消息
            if (isset($msg["StatCode"])) $StatCode = $msg["StatCode"]; else  $StatCode = "";
            if (isset($msg["StatName"])) $StatName = $msg["StatName"]; else  $StatName = "";
            if (isset($msg["ProjCode"])) $ProjCode = $msg["ProjCode"]; else  $ProjCode = "";
            if (isset($msg["ChargeMan"])) $ChargeMan = $msg["ChargeMan"]; else  $ChargeMan = "";
            if (isset($msg["Telephone"])) $Telephone = $msg["Telephone"]; else  $Telephone = "";
            if (isset($msg["Longitude"])) $Longitude = $msg["Longitude"]; else  $Longitude = "";
            if (isset($msg["Latitude"])) $Latitude = $msg["Latitude"]; else  $Latitude = "";
            if (isset($msg["Department"])) $Department = $msg["Department"]; else  $Department = "";
            if (isset($msg["Address"])) $Address = $msg["Address"]; else  $Address = "";
            if (isset($msg["Country"])) $Country = $msg["Country"]; else  $Country = "";
            if (isset($msg["Street"])) $Street = $msg["Street"]; else  $Street = "";
            if (isset($msg["Square"])) $Square = $msg["Square"]; else  $Square = "";
            if (isset($msg["ProStartTime"])) $ProStartTime = $msg["ProStartTime"]; else  $ProStartTime = "";
            if (isset($msg["Stage"])) $Stage = $msg["Stage"]; else  $Stage = "";
            $siteinfo = array("StatCode" => $StatCode, "StatName" => $StatName, "ProjCode" => $ProjCode, "ChargeMan" => $ChargeMan, "Telephone" => $Telephone,
                "Longitude" => $Longitude, "Latitude" => $Latitude, "Department" => $Department, "Address" => $Address, "Country" => $Country,
                "Street" => $Street, "Square" => $Square, "ProStartTime" => $ProStartTime, "Stage" => $Stage);
            //具体处理函数
            $resp = $this->func_point_new_process($siteinfo);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能Point Mod
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F3_POINTMOD)
        {
            //解开消息
            if (isset($msg["StatCode"])) $StatCode = $msg["StatCode"]; else  $StatCode = "";
            if (isset($msg["StatName"])) $StatName = $msg["StatName"]; else  $StatName = "";
            if (isset($msg["ProjCode"])) $ProjCode = $msg["ProjCode"]; else  $ProjCode = "";
            if (isset($msg["ChargeMan"])) $ChargeMan = $msg["ChargeMan"]; else  $ChargeMan = "";
            if (isset($msg["Telephone"])) $Telephone = $msg["Telephone"]; else  $Telephone = "";
            if (isset($msg["Longitude"])) $Longitude = $msg["Longitude"]; else  $Longitude = "";
            if (isset($msg["Latitude"])) $Latitude = $msg["Latitude"]; else  $Latitude = "";
            if (isset($msg["Department"])) $Department = $msg["Department"]; else  $Department = "";
            if (isset($msg["Address"])) $Address = $msg["Address"]; else  $Address = "";
            if (isset($msg["Country"])) $Country = $msg["Country"]; else  $Country = "";
            if (isset($msg["Street"])) $Street = $msg["Street"]; else  $Street = "";
            if (isset($msg["Square"])) $Square = $msg["Square"]; else  $Square = "";
            if (isset($msg["ProStartTime"])) $ProStartTime = $msg["ProStartTime"]; else  $ProStartTime = "";
            if (isset($msg["Stage"])) $Stage = $msg["Stage"]; else  $Stage = "";
            $siteinfo = array("StatCode" => $StatCode, "StatName" => $StatName, "ProjCode" => $ProjCode, "ChargeMan" => $ChargeMan, "Telephone" => $Telephone,
                "Longitude" => $Longitude, "Latitude" => $Latitude, "Department" => $Department, "Address" => $Address, "Country" => $Country,
                "Street" => $Street, "Square" => $Square, "ProStartTime" => $ProStartTime, "Stage" => $Stage);
            //具体处理函数
            $resp = $this->func_point_mod_process($siteinfo);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能Point Del
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F3_POINTDEL)
        {
            //解开消息
            if (isset($msg["StatCode"])) $StatCode = $msg["StatCode"]; else  $StatCode = "";
            //具体处理函数
            $resp = $this->func_point_del_process($StatCode);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能Point Dev
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F3_POINTDEV)
        {
            //解开消息
            if (isset($msg["StatCode"])) $StatCode = $msg["StatCode"]; else  $StatCode = "";
            //具体处理函数
            $resp = $this->func_point_dev_process($StatCode);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能Dev Table
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F3_DEVTABLE)
        {
            //解开消息
            if (isset($msg["length"])) $length = $msg["length"]; else  $length = "";
            if (isset($msg["startseq"])) $startseq = $msg["startseq"]; else  $startseq = "";
            //具体处理函数
            $resp = $this->func_dev_table_process($length, $startseq);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能Dev New
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F3_DEVNEW)
        {
            //解开消息
            if (isset($msg["DevCode"])) $DevCode = $msg["DevCode"]; else  $DevCode = "";
            if (isset($msg["StatCode"])) $StatCode = $msg["StatCode"]; else  $StatCode = "";
            if (isset($msg["StartTime"])) $StartTime = $msg["StartTime"]; else  $StartTime = "";
            if (isset($msg["PreEndTime"])) $PreEndTime = $msg["PreEndTime"]; else  $PreEndTime = "";
            if (isset($msg["EndTime"])) $EndTime = $msg["EndTime"]; else  $EndTime = "";
            if (isset($msg["DevStatus"])) $DevStatus = $msg["DevStatus"]; else  $DevStatus = "";
            if (isset($msg["VideoURL"])) $VideoURL = $msg["VideoURL"]; else  $VideoURL = "";
            $devinfo = array("DevCode" => $DevCode, "StatCode" => $StatCode, "StartTime" => $StartTime, "PreEndTime" => $PreEndTime,
                "EndTime" => $EndTime, "DevStatus" => $DevStatus, "VideoURL" => $VideoURL);
            //具体处理函数
            $resp = $this->func_dev_new_process($devinfo);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能Dev Mod
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F3_DEVMOD)
        {
            //解开消息
            if (isset($msg["DevCode"])) $DevCode = $msg["DevCode"]; else  $DevCode = "";
            if (isset($msg["StatCode"])) $StatCode = $msg["StatCode"]; else  $StatCode = "";
            if (isset($msg["StartTime"])) $StartTime = $msg["StartTime"]; else  $StartTime = "";
            if (isset($msg["PreEndTime"])) $PreEndTime = $msg["PreEndTime"]; else  $PreEndTime = "";
            if (isset($msg["EndTime"])) $EndTime = $msg["EndTime"]; else  $EndTime = "";
            if (isset($msg["DevStatus"])) $DevStatus = $msg["DevStatus"]; else  $DevStatus = "";
            if (isset($msg["VideoURL"])) $VideoURL = $msg["VideoURL"]; else  $VideoURL = "";
            $devinfo = array("DevCode" => $DevCode, "StatCode" => $StatCode, "StartTime" => $StartTime, "PreEndTime" => $PreEndTime,
                "EndTime" => $EndTime, "DevStatus" => $DevStatus, "VideoURL" => $VideoURL);
            //具体处理函数
            $resp = $this->func_dev_mod_process($devinfo);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能Dev Del
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F3_DEVDEL)
        {
            //解开消息
            if (isset($msg["DevCode"])) $DevCode = $msg["DevCode"]; else  $DevCode = "";
            //具体处理函数
            $resp = $this->func_dev_del_process($DevCode);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能Monitor List
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F3_MONITORLIST)
        {
            //解开消息
            if (isset($msg["id"])) $id = $msg["id"]; else  $id = "";
            //具体处理函数
            $resp = $this->func_monitor_list_process($id);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能Alarm Type, 获取所有传感器类型
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F3_ALARMTYPE)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_sensor_type_list_process($user);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能Tabel Query
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F3_TABLEQUERY)
        {
            //解开消息
            if (isset($msg["TableName"])) $TableName = $msg["TableName"]; else  $TableName = "";
            if (isset($msg["Condition"])) $Condition = $msg["Condition"]; else  $Condition = "";
            //具体处理函数
            $resp = $this->func_table_query_process($TableName, $Condition);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能Sensor List
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F3_SENSORLIST)
        {
            //解开消息
            if (isset($msg["user"])) $user = $msg["user"]; else  $user = "";
            //具体处理函数
            $resp = $this->func_sensor_list_process($user);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能Dev Sensor
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F3_DEVSENSOR)
        {
            //解开消息
            if (isset($msg["DevCode"])) $DevCode = $msg["DevCode"]; else  $DevCode = "";
            //具体处理函数
            $resp = $this->func_dev_sensor_process($DevCode);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        //功能GetStaticMonitorTable
        elseif ($msgId == MSG_ID_L4AQYCUI_TO_L3F3_GETSTATICMONITORTABLE)
        {
            //解开消息
            if (isset($msg["id"])) $id = $msg["id"]; else  $id = "";
            //具体处理函数
            $resp = $this->func_get_static_monitor_table_process($id);
            $project = MFUN_PRJ_HCU_AQYCUI;
        }

        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger($project, "MFUN_TASK_ID_L3APPL_FUM3DM", $log_time, $log_content);
            echo trim($resp); //这里需要编码送出去，跟其他处理方式还不太一样
        }

        //返回
        return true;
    }

}//End of class_task_service

?>