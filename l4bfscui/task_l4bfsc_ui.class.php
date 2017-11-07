<?php
/**
 * Created by PhpStorm.
 * User: QL
 * Date: 2016/10/02
 * Time: 11:55
 */
include_once "../l1comvm/vmlayer.php";

class classTaskL4bfscUi
{

    //构造函数
    public function __construct()
    {

    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l4bfsc_ui_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project = MFUN_PRJ_HCU_BFSCUI;

        //入口消息内容判断
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog($project,"NULL","H5UI_ENTRY_BFSC","MFUN_TASK_ID_L4BFSC_UI",$msgName,$log_content);
            echo trim($log_content);
            return false;
        }
        if (($msgId != MSG_ID_L4BFSCUI_CLICK_INCOMING) || ($msgName != "MSG_ID_L4BFSCUI_CLICK_INCOMING")){
            $log_content = "E: Msgid or MsgName error";
            $loggerObj->mylog($project,"NULL","H5UI_ENTRY_BFSC","MFUN_TASK_ID_L4BFSC_UI",$msgName,$log_content);
            echo trim($log_content);
            return false;
        }

        $resp = "";
        $user = "";
        if (isset($msg)) $action = trim($msg); else $action = "";
        //这里是L4FHYS与L3APPL功能之间的交换矩阵，从而让UI对应的多种不确定组合变换为L3APPL确定的功能组合
        switch($action)
        {
            case "ProjDel":  //删除一个项目
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4BFSC_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PROJDEL, "MSG_ID_L4AQYCUI_TO_L3F2_PROJDEL",$input);
                break;

            case "PointDel":  //删除一个监测点
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4BFSC_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_POINTDEL, "MSG_ID_L4AQYCUI_TO_L3F2_POINTDEL",$input);
                break;

            case "DevDel":  //删除HCU设备
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4BFSC_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_DEVDEL, "MSG_ID_L4AQYCUI_TO_L3F2_DEVDEL",$input);
                break;

            case "MonitorAlarmList":      // get alarm monitorList in map by user id
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4BFSC_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_ALARMMONITORLIST, "MSG_ID_L4AQYCUI_TO_L3F5_ALARMMONITORLIST",$input);
                break;

            case "GetWarningHandleListTable":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4BFSC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F5_ALARMHANDLETABLE, "MSG_ID_L4AQYCUI_TO_L3F5_ALARMHANDLETABLE",$input);
                break;

            /*以下5条消息是公用，要考虑不同项目的适配*/
            case "DevAlarm":  //获取当前的测量值，如果测量值超出范围，提示告警
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4BFSC_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_DEVALARM, "MSG_ID_L4AQYCUI_TO_L3F5_DEVALARM",$input);
                break;

            case "AlarmType":  //获取所有传感器类型
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4BFSC_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_ALARMTYPE, "MSG_ID_L4AQYCUI_TO_L3F5_ALARMTYPE",$input);
                break;

            case "SensorList":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4BFSC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_SENSORLIST, "MSG_ID_L4AQYCUI_TO_L3F3_SENSORLIST",$input);
                break;

            case "DevSensor": //查询设备下传感器列表
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4BFSC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_DEVSENSOR, "MSG_ID_L4AQYCUI_TO_L3F3_DEVSENSOR",$input);
                break;

            case "GetStaticMonitorTable":  //查询测量点聚合信息
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4BFSC_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_GETSTATICMONITORTABLE, "MSG_ID_L4AQYCUI_TO_L3F3_GETSTATICMONITORTABLE",$input);
                break;

            default:
                $msg = array("action" => $action, 'project' => MFUN_PRJ_HCU_AQYCUI);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4BFSC_UI, MFUN_TASK_ID_L4COM_UI, MSG_ID_L4COMUI_CLICK_INCOMING, "MSG_ID_L4COMUI_CLICK_INCOMING",$msg);
                break;
        }

        if (!empty($resp)) {
            $jsonencode = json_encode($resp, JSON_UNESCAPED_UNICODE);
            $log_content = "T:" . $jsonencode;
            $loggerObj->mylog($project,$user,"H5UI_ENTRY_BFSC","MFUN_TASK_ID_L4BFSC_UI",$msgName,$log_content);
            echo trim($jsonencode);
        }

        //返回
        return true;
    }

}//End of class_task_service

?>
