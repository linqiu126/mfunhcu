<?php
/**
 * Created by PhpStorm.
 * User: QL
 * Date: 2016/10/02
 * Time: 11:55
 */
include_once "../l1comvm/vmlayer.php";

class classTaskL4fhysUi
{

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l4fhys_ui_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project = MFUN_PRJ_HCU_FHYSUI;

        //入口消息内容判断
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog($project,"NULL","H5UI_ENTRY_FHYS","MFUN_TASK_ID_L4FHYS_UI",$msgName,$log_content);
            echo trim($log_content);
            return false;
        }
        if (($msgId != MSG_ID_L4FHYSUI_CLICK_INCOMING) || ($msgName != "MSG_ID_L4FHYSUI_CLICK_INCOMING")){
            $log_content = "E: Msgid or MsgName error";
            $loggerObj->mylog($project,"NULL","H5UI_ENTRY_FHYS","MFUN_TASK_ID_L4FHYS_UI",$msgName,$log_content);
            echo trim($log_content);
            return false;
        }

        $resp = "";
        $user = "";
        if (isset($msg)) $action = trim($msg); else $action = "";
        //这里是L4FHYS与L3APPL功能之间的交换矩阵，从而让UI对应的多种不确定组合变换为L3APPL确定的功能组合
        switch($action)
        {
             case "ProjDel":  //删除一个项目，对于云控锁，删除项目要相应清除项目相关的钥匙信息，所以这里的处理不是通用的，使用MSG_ID_L4FHYSUI_TO_L3F2_PROJDEL消息
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_PROJDEL, "MSG_ID_L4FHYSUI_TO_L3F2_PROJDEL",$input);
                break;

            case "PointDel":  //删除一个监测点
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_POINTDEL, "MSG_ID_L4FHYSUI_TO_L3F2_POINTDEL",$input);
                break;

            case "DevDel":  //删除HCU设备
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_DEVDEL, "MSG_ID_L4FHYSUI_TO_L3F2_DEVDEL",$input);
                break;

            //根据钥匙用户的ID查询该用户授权的钥匙列表
            case "UserKey":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_USERKEY, "MSG_ID_L4FHYSUI_TO_L3F2_USERKEY",$input);
                break;

            //查询该用户授权所有项目的钥匙列表
            case "ProjKeyList":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_PROJKEYLIST, "MSG_ID_L4FHYSUI_TO_L3F2_PROJKEYLIST",$input);
                break;

            //查询指定项目下的钥匙列表
            case "ProjKey":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_PROJKEY, "MSG_ID_L4FHYSUI_TO_L3F2_PROJKEY",$input);
                break;

            //查询所有项目钥匙用户列表
            case "ProjUserList":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_PROJKEYUSERLIST, "MSG_ID_L4FHYSUI_TO_L3F2_PROJKEYUSERLIST",$input);
                break;

            //查询所有钥匙列表
            case "KeyTable":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_KEYTABLE, "MSG_ID_L4FHYSUI_TO_L3F2_KEYTABLE",$input);
                break;

            //添加新钥匙
            case "KeyNew":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_KEYNEW, "MSG_ID_L4FHYSUI_TO_L3F2_KEYNEW",$input);
                break;

            case "KeyMod":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_KEYMOD, "MSG_ID_L4FHYSUI_TO_L3F2_KEYMOD",$input);
                break;

            //删除钥匙
            case "KeyDel":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_KEYDEL, "MSG_ID_L4FHYSUI_TO_L3F2_KEYDEL",$input);
                break;

            //查询授权对象（项目或者站点）下所有的授权信息列表
            case "DomainAuthlist":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_OBJAUTHLIST, "MSG_ID_L4FHYSUI_TO_L3F2_OBJAUTHLIST",$input);
                break;

            //查询某个KEY下的授权列表
            case "KeyAuthlist":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_KEYAUTHLIST, "MSG_ID_L4FHYSUI_TO_L3F2_KEYAUTHLIST",$input);
                break;

            //将钥匙授予某人
            case "KeyGrant":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_KEYGRANT, "MSG_ID_L4FHYSUI_TO_L3F2_KEYGRANT",$input);
                break;

            //新建钥匙授权
            case "KeyAuthNew":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_KEYAUTHNEW, "MSG_ID_L4FHYSUI_TO_L3F2_KEYAUTHNEW",$input);
                break;

            //删除钥匙授权
            case "KeyAuthDel":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_KEYAUTHDEL, "MSG_ID_L4FHYSUI_TO_L3F2_KEYAUTHDEL",$input);
                break;

            case "GetRTUTable":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_RTUTABLE, "MSG_ID_L4FHYSUI_TO_L3F2_RTUTABLE",$input);
                break;

            case "GetOTDRTable":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_OTDRTABLE, "MSG_ID_L4FHYSUI_TO_L3F2_OTDRTABLE",$input);
                break;

            case "SensorList":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4FHYSUI_TO_L3F3_SENSORLIST, "MSG_ID_L4FHYSUI_TO_L3F3_SENSORLIST",$input);
                break;

            case "DevSensor": //查询设备下传感器列表
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4FHYSUI_TO_L3F3_DEVSENSOR, "MSG_ID_L4FHYSUI_TO_L3F3_DEVSENSOR",$input);
                break;

            case "PointPicture": //查询该站点的照片列表
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4FHYSUI_TO_L3F3_POINTPICTURE, "MSG_ID_L4FHYSUI_TO_L3F3_POINTPICTURE",$input);
                break;

            case "GetStaticMonitorTable":  //查询测量点聚合信息
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4FHYSUI_TO_L3F3_GETSTATICMONITORTABLE, "MSG_ID_L4FHYSUI_TO_L3F3_GETSTATICMONITORTABLE",$input);
                break;

            //开锁历史查询
            case "KeyHistory":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4FHYSUI_TO_L3F3_KEYHISTORY, "MSG_ID_L4FHYSUI_TO_L3F3_KEYHISTORY",$input);
                break;

            //查询开门时抓拍的照片
            case "GetOpenImg":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4FHYSUI_TO_L3F3_DOOROPENPIC, "MSG_ID_L4FHYSUI_TO_L3F3_DOOROPENPIC",$input);
                break;

            //开锁请求命令
            case "OpenLock": //Open a lock
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4FHYSUI_TO_L3F4_LOCKOPEN, "MSG_ID_L4FHYSUI_TO_L3F4_LOCKOPEN",$input);
                break;

            case "DevAlarm":  //获取当前的测量值，如果测量值超出范围，提示告警
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4FHYSUI_TO_L3F5_DEVALARM, "MSG_ID_L4FHYSUI_TO_L3F5_DEVALARM",$input);
                break;

            case "AlarmType":  //获取所有传感器类型
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4FHYSUI_TO_L3F5_ALARMTYPE, "MSG_ID_L4FHYSUI_TO_L3F5_ALARMTYPE",$input);
                break;

            case "MonitorAlarmList":  //map alarm site
                //TBD
                break;

            case "GetWarningHandleListTable":  //告警处理表
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4FHYSUI_TO_L3F5_ALARMHANDLETABLE, "MSG_ID_L4FHYSUI_TO_L3F5_ALARMHANDLETABLE",$input);
                break;

            case "AlarmHandle":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4FHYSUI_TO_L3F5_ALARMHANDLE, "MSG_ID_L4FHYSUI_TO_L3F5_ALARMHANDLE",$input);
                break;

            case "AlarmClose":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project,"action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4FHYSUI_TO_L3F5_ALARMCLOSE, "MSG_ID_L4FHYSUI_TO_L3F5_ALARMCLOSE",$input);
                break;

            default:
                $msg = array("project" => $project,"action" => $action);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L4COM_UI, MSG_ID_L4COMUI_CLICK_INCOMING, "MSG_ID_L4COMUI_CLICK_INCOMING",$msg);
                break;
        }

        if (!empty($resp)) {
            $jsonencode = json_encode($resp, JSON_UNESCAPED_UNICODE);
            $log_content = "T:" . $jsonencode;
            $loggerObj->mylog($project,$user,"NULL","MFUN_TASK_ID_L4FHYS_UI",$msgName,$log_content);
            echo trim($jsonencode);
        }

        //返回
        return true;
    }

}//End of class_task_service

?>
