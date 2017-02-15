<?php
/**
 * Created by PhpStorm.
 * User: QL
 * Date: 2016/10/02
 * Time: 11:55
 */
include_once "../l1comvm/vmlayer.php";
include_once "dbi_l4fhys_ui.class.php";

class classTaskL4fhysUi
{
    //构造函数
    public function __construct()
    {

    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l4fhys_ui_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L4FHYS_UI", "mfun_l4fhys_ui_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到L4CLOCKLOCKUI，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L4FHYS_UI", "mfun_l4fhys_ui_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        if (($msgId == MSG_ID_L4FHYSUI_CLICK_INCOMING) && (isset($msg)))
        {
            $resp = "";
            //这里是L4FHYS与L3APPL功能之间的交换矩阵，从而让UI对应的多种不确定组合变换为L3APPL确定的功能组合
            switch($msg)
            {
                case "login":  //login message:
                    if (isset($_GET["name"])) $name = trim($_GET["name"]); else $name = "";
                    if (isset($_GET["password"])) $pwd = trim($_GET["password"]); else $pwd = "";
                    $input = array("user" => $name, "pwd" => $pwd);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4AQYCUI_TO_L3F1_LOGIN, "MSG_ID_L4AQYCUI_TO_L3F1_LOGIN",$input);
                    break;

                case "UserInfo":    // get User Information after login
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type, "user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4AQYCUI_TO_L3F1_USERINFO, "MSG_ID_L4AQYCUI_TO_L3F1_USERINFO",$input);
                    break;

                case "UserNew": //Add new user
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type, "user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4AQYCUI_TO_L3F1_USERNEW, "MSG_ID_L4AQYCUI_TO_L3F1_USERNEW",$input);
                    break;

                case "UserMod":  //modify user
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type, "user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4AQYCUI_TO_L3F1_USERMOD, "MSG_ID_L4AQYCUI_TO_L3F1_USERMOD",$input);
                    break;

                case "UserDel": //Delete the user
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4AQYCUI_TO_L3F1_USERDEL, "MSG_ID_L4AQYCUI_TO_L3F1_USERDEL",$input);
                    break;

                case "UserTable": //查询所有用户信息表
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4AQYCUI_TO_L3F1_USERTABLE, "MSG_ID_L4AQYCUI_TO_L3F1_USERTABLE",$input);
                    break;

                case "ProjectPGList":  //Get the Project & Project Group list which will be use in user auth
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PROJECTPGLIST, "MSG_ID_L4AQYCUI_TO_L3F2_PROJECTPGLIST",$input);
                    break;

                case "ProjectList":   //Get the Project list
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PROJECTLIST, "MSG_ID_L4AQYCUI_TO_L3F2_PROJECTLIST",$input);
                    break;

                case "UserProj":    // query project list belong to one user
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_USERPROJ, "MSG_ID_L4AQYCUI_TO_L3F2_USERPROJ",$input);
                    break;

                case "PGTable":    // query project group table
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PGTABLE, "MSG_ID_L4AQYCUI_TO_L3F2_PGTABLE",$input);
                    break;

                case "PGNew":  //创建新的项目组
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PGNEW, "MSG_ID_L4AQYCUI_TO_L3F2_PGNEW",$input);
                    break;

                case "PGMod":  //修改项目组信息
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PGMOD, "MSG_ID_L4AQYCUI_TO_L3F2_PGMOD",$input);
                    break;

                case "PGDel":  //删除项目组信息
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PGDEL, "MSG_ID_L4AQYCUI_TO_L3F2_PGDEL",$input);
                    break;

                case "PGProj":    // 查询属于项目组的所有项目列表
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PGPROJ, "MSG_ID_L4AQYCUI_TO_L3F2_PGPROJ",$input);
                    break;

                case "ProjTable":    // query project table
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PROJTABLE, "MSG_ID_L4AQYCUI_TO_L3F2_PROJTABLE",$input);
                    break;

                case "ProjNew": //创建新的项目信息
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PROJNEW, "MSG_ID_L4AQYCUI_TO_L3F2_PROJNEW",$input);
                    break;

                case "ProjMod": //修改项目信息
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PROJMOD, "MSG_ID_L4AQYCUI_TO_L3F2_PROJMOD",$input);
                    break;

                case "ProjDel":  //删除一个项目
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4AQYCUI_TO_L3F2_PROJDEL, "MSG_ID_L4AQYCUI_TO_L3F2_PROJDEL",$input);
                    break;

                case "ProjPoint":   //查询所有监控点列表
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_PROJPOINT, "MSG_ID_L4AQYCUI_TO_L3F3_PROJPOINT",$input);
                    break;

                case "PointProj": //查询该项目下面对应监控点列表
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_POINTPROJ, "MSG_ID_L4AQYCUI_TO_L3F3_POINTPROJ",$input);
                    break;

                case "PointTable":  //查询所有监控点信息
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_POINTTABLE, "MSG_ID_L4AQYCUI_TO_L3F3_POINTTABLE",$input);
                    break;

                case "PointDetail":
                    //abandon
                    break;

                case "PointNew":  //新建监测点
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_POINTNEW, "MSG_ID_L4AQYCUI_TO_L3F3_POINTNEW",$input);
                    break;

                case "PointMod"://修改监测点信息
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_POINTMOD, "MSG_ID_L4AQYCUI_TO_L3F3_POINTMOD",$input);
                    break;

                case "PointDel":  //删除一个监测点
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_POINTDEL, "MSG_ID_L4AQYCUI_TO_L3F3_POINTDEL",$input);
                    break;

                case "PointDev": //查询监测点下的HCU设备列表
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_POINTDEV, "MSG_ID_L4AQYCUI_TO_L3F3_POINTDEV",$input);
                    break;

                case "DevTable": //查询HCU设备列表信息
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_DEVTABLE, "MSG_ID_L4AQYCUI_TO_L3F3_DEVTABLE",$input);
                    break;

                case "DevNew":  //创建新的HCU信息
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_DEVNEW, "MSG_ID_L4AQYCUI_TO_L3F3_DEVNEW",$input);
                    break;

                case "DevMod": //修改监测设备信息
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_DEVMOD, "MSG_ID_L4AQYCUI_TO_L3F3_DEVMOD",$input);
                    break;

                case "DevDel":  //删除HCU设备
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_DEVDEL, "MSG_ID_L4AQYCUI_TO_L3F3_DEVDEL",$input);
                    break;

                case "MonitorList":      // get monitorList in map by user id
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_MONITORLIST, "MSG_ID_L4AQYCUI_TO_L3F3_MONITORLIST",$input);
                    break;

                case "AlarmQuery": //查询一个监测点历史告警数据 minute/hour/day
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4AQYCUI_TO_L3F5_ALARMQUERY, "MSG_ID_L4AQYCUI_TO_L3F5_ALARMQUERY",$input);
                    break;

                case "TableQuery":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4AQYCUI_TO_L3F3_TABLEQUERY, "MSG_ID_L4AQYCUI_TO_L3F3_TABLEQUERY",$input);
                    break;

                case "SensorUpdate":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_SENSORUPDATE, "MSG_ID_L4AQYCUI_TO_L3F4_SENSORUPDATE",$input);
                    break;

                case "SetUserMsg":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM7ADS, MSG_ID_L4AQYCUI_TO_L3F7_SETUSERMSG, "MSG_ID_L4AQYCUI_TO_L3F7_SETUSERMSG",$input);
                    break;

                case "GetUserMsg":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM7ADS, MSG_ID_L4AQYCUI_TO_L3F7_GETUSERMSG, "MSG_ID_L4AQYCUI_TO_L3F7_GETUSERMSG",$input);
                    break;

                case "ShowUserMsg":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM7ADS, MSG_ID_L4AQYCUI_TO_L3F7_SHOWUSERMSG, "MSG_ID_L4AQYCUI_TO_L3F7_SHOWUSERMSG",$input);
                    break;

                case "GetUserImg":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM7ADS, MSG_ID_L4AQYCUI_TO_L3F7_GETUSERIMG, "MSG_ID_L4AQYCUI_TO_L3F7_GETUSERIMG",$input);
                    break;

                case "ClearUserImg":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM7ADS, MSG_ID_L4AQYCUI_TO_L3F7_CLEARUSERIMG, "MSG_ID_L4AQYCUI_TO_L3F7_CLEARUSERIMG",$input);
                    break;

                case "GetVideoList": //获取指定站点指定时间段内的所有视频文件列表
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_VIDEOLIST, "MSG_ID_L4AQYCUI_TO_L3F4_VIDEOLIST",$input);
                    break;

                case "GetVideo":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_VIDEOPLAY, "MSG_ID_L4AQYCUI_TO_L3F4_VIDEOPLAY",$input);
                    break;

                case "GetVersionList":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_ALLSW, "MSG_ID_L4AQYCUI_TO_L3F4_ALLSW",$input);
                    break;

                case "GetProjDevVersion":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_DEVSW, "MSG_ID_L4AQYCUI_TO_L3F4_DEVSW",$input);
                    break;

                case "UpdateDevVersion":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_SWUPDATE, "MSG_ID_L4AQYCUI_TO_L3F4_SWUPDATE",$input);
                    break;

                case "GetCameraStatus": //Get camera vertical and horizontal angle and fetch a current photo
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_GETCAMERASTATUS, "MSG_ID_L4AQYCUI_TO_L3F4_GETCAMERASTATUS",$input);
                    break;

                case "GetCameraUnit":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4AQYCUI_TO_L3F4_GETCAMERAUNIT, "MSG_ID_L4AQYCUI_TO_L3F4_GETCAMERAUNIT",$input);
                    break;
                case "CameraVAdj":
                    break;
                case "CameraHAdj":
                    break;

/*********************************智能云锁新增处理 Start*********************************************/
                /*以下5条消息是公用，要考虑不同项目的适配*/
                case "DevAlarm":  //获取当前的测量值，如果测量值超出范围，提示告警
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4FHYSUI_TO_L3F5_DEVALARM, "MSG_ID_L4FHYSUI_TO_L3F5_DEVALARM",$input);
                    break;

                case "AlarmType":  //获取所有传感器类型
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4FHYSUI_TO_L3F5_ALARMTYPE, "MSG_ID_L4FHYSUI_TO_L3F5_ALARMTYPE",$input);
                    break;

                case "SensorList":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4FHYSUI_TO_L3F3_SENSORLIST, "MSG_ID_L4FHYSUI_TO_L3F3_SENSORLIST",$input);
                    break;

                case "DevSensor": //查询设备下传感器列表
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4FHYSUI_TO_L3F3_DEVSENSOR, "MSG_ID_L4FHYSUI_TO_L3F3_DEVSENSOR",$input);
                    break;

                case "GetStaticMonitorTable":  //查询测量点聚合信息
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4FHYSUI_TO_L3F3_GETSTATICMONITORTABLE, "MSG_ID_L4FHYSUI_TO_L3F3_GETSTATICMONITORTABLE",$input);
                    break;

                case "GetWarningHandleListTable":  //告警处理表
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM5FM, MSG_ID_L4FHYSUI_TO_L3F5_GETALARMHANDLETABLE, "MSG_ID_L4FHYSUI_TO_L3F5_GETALARMHANDLETABLE",$input);
                    break;

                //开锁请求命令
                case "OpenLock": //Open a lock
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4FHYSUI_TO_L3F4_LOCKOPEN, "MSG_ID_L4FHYSUI_TO_L3F4_LOCKOPEN",$input);
                    break;

                //根据钥匙用户的ID查询该用户授权的钥匙列表
                case "UserKey":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_USERKEY, "MSG_ID_L4FHYSUI_TO_L3F2_USERKEY",$input);
                    break;

                //查询所有项目钥匙列表
                case "ProjKeyList":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_PROJKEYLIST, "MSG_ID_L4FHYSUI_TO_L3F2_PROJKEYLIST",$input);
                    break;

                //查询指定项目下的钥匙列表
                case "ProjKey":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_PROJKEY, "MSG_ID_L4FHYSUI_TO_L3F2_PROJKEY",$input);
                    break;

                //查询所有项目钥匙用户列表
                case "ProjUserList":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_PROJKEYUSERLIST, "MSG_ID_L4FHYSUI_TO_L3F2_PROJKEYUSERLIST",$input);
                    break;

                //查询所有钥匙列表
                case "KeyTable":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_KEYTABLE, "MSG_ID_L4FHYSUI_TO_L3F2_KEYTABLE",$input);
                    break;

                //添加新钥匙
                case "KeyNew":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_KEYNEW, "MSG_ID_L4FHYSUI_TO_L3F2_KEYNEW",$input);
                    break;

                case "KeyMod":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_KEYMOD, "MSG_ID_L4FHYSUI_TO_L3F2_KEYMOD",$input);
                    break;

                //删除钥匙
                case "KeyDel":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_KEYDEL, "MSG_ID_L4FHYSUI_TO_L3F2_KEYDEL",$input);
                    break;

                //查询授权对象（项目或者站点）下所有的授权信息列表
                case "DomainAuthlist":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_OBJAUTHLIST, "MSG_ID_L4FHYSUI_TO_L3F2_OBJAUTHLIST",$input);
                    break;

                //查询某个KEY下的授权列表
                case "KeyAuthlist":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_KEYAUTHLIST, "MSG_ID_L4FHYSUI_TO_L3F2_KEYAUTHLIST",$input);
                    break;

                //将钥匙授予某人
                case "KeyGrant":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_KEYGRANT, "MSG_ID_L4FHYSUI_TO_L3F2_KEYGRANT",$input);
                    break;

                //新建钥匙授权
                case "KeyAuthNew":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_KEYAUTHNEW, "MSG_ID_L4FHYSUI_TO_L3F2_KEYAUTHNEW",$input);
                    break;

                //删除钥匙授权
                case "KeyAuthDel":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4FHYSUI_TO_L3F2_KEYAUTHDEL, "MSG_ID_L4FHYSUI_TO_L3F2_KEYAUTHDEL",$input);
                    break;

                //开锁历史查询
                case "KeyHistory":
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4FHYSUI_TO_L3F3_KEYHISTORY, "MSG_ID_L4FHYSUI_TO_L3F3_KEYHISTORY",$input);
                    break;

                default:
                    $resp = ""; //啥都不ECHO
                    break;
            }

        }
        else{
            $resp = ""; //啥都不ECHO
        }

        //返回ECHO
        if (!empty($resp))
        {
            $log_content = "T:" . json_encode($resp);
            $loggerObj->logger("MFUN_TASK_ID_L4FHYS_UI", "mfun_l4fhys_ui_task_main_entry", $log_time, $log_content);
            echo trim($resp);
        }

        //返回
        return true;
    }

}//End of class_task_service

?>
