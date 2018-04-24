<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:47
 */
include_once "../l1comvm/vmlayer.php";

class classTaskL4aqycUi
{

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l4aqyc_ui_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project = MFUN_PRJ_HCU_AQYCUI;

        //入口消息内容判断
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog($project,"NULL","H5UI_ENTRY_AQYC","MFUN_TASK_ID_L4AQYC_UI",$msgName,$log_content);
            echo trim($log_content);
            return false;
        }
        if (($msgId != MSG_ID_L4AQYCUI_CLICK_INCOMING) || ($msgName != "MSG_ID_L4AQYCUI_CLICK_INCOMING")){
            $log_content = "E: Msgid or MsgName error";
            $loggerObj->mylog($project,"NULL","H5UI_ENTRY_AQYC","MFUN_TASK_ID_L4AQYC_UI",$msgName,$log_content);
            echo trim($log_content);
            return false;
        }

        $resp = "";
        $user = "";
        if (isset($msg)) $action = trim($msg); else $action = "";
        //这里是L4AQYC与L3APPL功能之间的交换矩阵，从而让UI对应的多种不确定组合变换为L3APPL确定的功能组合
        switch($action)
        {

            /*********************以下6条消息公用，要考虑不同项目的适配*********************/
            case "ProjDel":  //删除一个项目
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PROJDEL, "MSG_ID_L4AQYCUI_TO_L3F2_PROJDEL",$input);
                break;

            case "PointDel":  //删除一个监测点
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_POINTDEL, "MSG_ID_L4AQYCUI_TO_L3F2_POINTDEL",$input);
                break;

            case "DevDel":  //删除HCU设备
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_DEVDEL, "MSG_ID_L4AQYCUI_TO_L3F2_DEVDEL",$input);
                break;
            case "SensorList":  //获取传感器列表
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_SENSORLIST, "MSG_ID_L4AQYCUI_TO_L3F3_SENSORLIST",$input);
                break;

            case "DevSensor": //查询设备下传感器列表
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_DEVSENSOR, "MSG_ID_L4AQYCUI_TO_L3F3_DEVSENSOR",$input);
                break;

            case "GetStaticMonitorTable":  //查询测量点聚合信息
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_GETSTATICMONITORTABLE, "MSG_ID_L4AQYCUI_TO_L3F3_GETSTATICMONITORTABLE",$input);
                break;

            case "MonitorAlarmList":      // get alarm monitorList in map by user id
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_ALARMMONITORLIST, "MSG_ID_L4AQYCUI_TO_L3F5_ALARMMONITORLIST",$input);
                break;

            case "DevAlarm":  //获取当前的测量值，如果测量值超出范围，提示告警
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_DEVALARM, "MSG_ID_L4AQYCUI_TO_L3F5_DEVALARM",$input);
                break;

            case "AlarmType":  //获取所有传感器类型
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_ALARMTYPE, "MSG_ID_L4AQYCUI_TO_L3F5_ALARMTYPE",$input);
                break;

            case "AlarmQuery": //查询一个监测点历史告警数据 minute/hour/day
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_ALARMQUERY, "MSG_ID_L4AQYCUI_TO_L3F5_ALARMQUERY",$input);
                break;

            case "AlarmQueryRealtime": //实时显示一个监测点的动态数据
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_ALARMQUERYREALTIME, "MSG_ID_L4AQYCUI_TO_L3F5_ALARMQUERYREALTIME",$input);
                break;

            case "GetWarningHandleListTable":  //告警处理表
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_ALARMHANDLETABLE, "MSG_ID_L4AQYCUI_TO_L3F5_ALARMHANDLETABLE",$input);
                break;

            case "GetWarningImg":  //查询告警抓拍照片
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_ALARMIMGGET, "MSG_ID_L4AQYCUI_TO_L3F5_ALARMIMGGET",$input);
                break;

            case "AlarmHandle":  //告警处理
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_ALARMHANDLE, "MSG_ID_L4AQYCUI_TO_L3F5_ALARMHANDLE",$input);
                break;

            case "AlarmClose":  //告警关闭
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_ALARMCLOSE, "MSG_ID_L4AQYCUI_TO_L3F5_ALARMCLOSE",$input);
                break;

            case "GetHistoryRTSP":  //查询历史告警视频
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_ALARMRTSP, "MSG_ID_L4AQYCUI_TO_L3F5_ALARMRTSP",$input);
                break;

            case "GetShowAction":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM7ADS, MSG_ID_L4AQYCUI_TO_L3F7_GETSHOWACTIONE, "MSG_ID_L4AQYCUI_TO_L3F7_GETSHOWACTIONE",$input);
                break;

            default:
                $msg = array("project" => $project, "action" => $action);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L4COM_UI, MSG_ID_L4COMUI_CLICK_INCOMING, "MSG_ID_L4COMUI_CLICK_INCOMING",$msg);
                break;
        }

        if (!empty($resp)) {
            $jsonencode = json_encode($resp, JSON_UNESCAPED_UNICODE);
            $log_content = "T:" . $jsonencode;
            $loggerObj->mylog($project,$user,"H5UI_ENTRY_AQYC","MFUN_TASK_ID_L4AQYC_UI",$msgName,$log_content);
            echo trim($jsonencode);
        }

        //返回
        return true;
    }

}//End of class_task_service

//暂时不用删除的消息
/*
    case "GetVersionList":
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_ALLSW, "MSG_ID_L4AQYCUI_TO_L3F4_ALLSW",$input);
        break;

    case "GetProjDevVersion":
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_DEVSW, "MSG_ID_L4AQYCUI_TO_L3F4_DEVSW",$input);
        break;

    case "UpdateDevVersion":
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_SWUPDATE, "MSG_ID_L4AQYCUI_TO_L3F4_SWUPDATE",$input);
        break;

    //获取软件3条版本基线的最新说明
    case "VersionInformation":
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_SWVERINFO, "MSG_ID_L4AQYCUI_TO_L3F4_SWVERINFO",$input);
        break;

    //获取指定项目下所有设备的软件更新策略，包括软件版本，版本基线，是否允许自动更新
    case "ProjUpdateStrategyList":
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_PROJSUSTRATEGY, "MSG_ID_L4AQYCUI_TO_L3F4_PROJSUSTRATEGY",$input);
        break;

    //修改项目软件版本基线
    case "ProjVersionStrategyChange":
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_PROJSWBASECHANGE, "MSG_ID_L4AQYCUI_TO_L3F4_SWBASECHANGE",$input);
        break;

    //修改某站点软件更新策略
    case "PointUpdateStrategyChange":
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_DEVSUSTRATEGYCHANGE, "MSG_ID_L4AQYCUI_TO_L3F4_DEVSUSTRATEGYCHANGE",$input);
        break;

    //修改某项目软件更新策略
    case "ProjUpdateStrategyChange":
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_PROJSUSTRATEGYCHANGE, "MSG_ID_L4AQYCUI_TO_L3F4_PROJSUSTRATEGYCHANGE",$input);
        break;

    //获取某项目软件更新策略
    case "GetProjUpdateStrategy":
        if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
        if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
        if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

        $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
        $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4AQYC_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_PROJSUSTRATEGYGET, "MSG_ID_L4AQYCUI_TO_L3F4_PROJSUSTRATEGYGET",$input);
        break;
*/

?>
