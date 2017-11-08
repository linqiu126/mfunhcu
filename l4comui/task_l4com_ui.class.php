<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:47
 */
include_once "../l1comvm/vmlayer.php";

class classTaskL4comUi
{

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l4com_ui_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project = "NULL";

        //入口消息内容判断
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog($project,"NULL","NULL","MFUN_TASK_ID_L4COM_UI",$msgName,$log_content);
            echo trim($log_content);
            return false;
        }
        else{
            if (isset($msg['action'])) $action = trim(($msg['action'])); else $action = "";
            if (isset($msg['project'])) $project = trim(($msg['project'])); else $project = "";
        }
        if (($msgId != MSG_ID_L4COMUI_CLICK_INCOMING) || ($msgName != "MSG_ID_L4COMUI_CLICK_INCOMING")){
            $log_content = "E: Msgid or MsgName error";
            $loggerObj->mylog($project,"NULL","NULL","MFUN_TASK_ID_L4COM_UI",$msgName,$log_content);
            echo trim($log_content);
            return false;
        }

        $resp = "";
        $user = "";

        //这里是L4COM与L3APPL功能之间的交换矩阵，从而让UI对应的多种不确定组合变换为L3APPL确定的功能组合
        switch($action)
        {
            case "login":  //login message:
                if (isset($_GET["name"])) $name = trim($_GET["name"]); else $name = "";
                if (isset($_GET["password"])) $pwd = trim($_GET["password"]); else $pwd = "";
                $input = array("project" => $project, "user" => $name, "pwd" => $pwd);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4COMUI_TO_L3F1_LOGIN, "MSG_ID_L4COMUI_TO_L3F1_LOGIN",$input);
                break;

            case "Get_user_auth_code": //找回密码发送手机验证码
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type, "user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4COMUI_TO_L3F1_USERAUTHCODE, "MSG_ID_L4COMUI_TO_L3F1_USERAUTHCODE",$input);
                break;

            case "Reset_password":  //重置密码
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type, "user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4COMUI_TO_L3F1_PWRESET, "MSG_ID_L4COMUI_TO_L3F1_PWRESET",$input);
                break;

            case "UserInfo":    // get User Information after login
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type, "user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4COMUI_TO_L3F1_USERINFO, "MSG_ID_L4COMUI_TO_L3F1_USERINFO",$input);
                break;

            case "UserNew": //Add new user
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type, "user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4COMUI_TO_L3F1_USERNEW, "MSG_ID_L4COMUI_TO_L3F1_USERNEW",$input);
                break;

            case "UserMod":  //modify user
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type, "user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4COMUI_TO_L3F1_USERMOD, "MSG_ID_L4COMUI_TO_L3F1_USERMOD",$input);
                break;

            case "UserDel": //Delete the user
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4COMUI_TO_L3F1_USERDEL, "MSG_ID_L4COMUI_TO_L3F1_USERDEL",$input);
                break;

            case "UserTable": //查询所有用户信息表
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4COMUI_TO_L3F1_USERTABLE, "MSG_ID_L4COMUI_TO_L3F1_USERTABLE",$input);
                break;

            case "ProjectPGList":  //Get the Project & Project Group list which will be use in user auth
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_PROJECTPGLIST, "MSG_ID_L4COMUI_TO_L3F2_PROJECTPGLIST",$input);
                break;

            case "ProjectList":   //Get the Project list
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_PROJECTLIST, "MSG_ID_L4COMUI_TO_L3F2_PROJECTLIST",$input);
                break;

            case "UserProj":    // query project list belong to one user
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_USERPROJ, "MSG_ID_L4COMUI_TO_L3F2_USERPROJ",$input);
                break;

            case "PGTable":    // query project group table
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_PGTABLE, "MSG_ID_L4COMUI_TO_L3F2_PGTABLE",$input);
                break;

            case "PGNew":  //创建新的项目组
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_PGNEW, "MSG_ID_L4COMUI_TO_L3F2_PGNEW",$input);
                break;

            case "PGMod":  //修改项目组信息
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_PGMOD, "MSG_ID_L4COMUI_TO_L3F2_PGMOD",$input);
                break;

            case "PGDel":  //删除项目组信息
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_PGDEL, "MSG_ID_L4COMUI_TO_L3F2_PGDEL",$input);
                break;

            case "PGProj":    // 查询属于项目组的所有项目列表
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_PGPROJ, "MSG_ID_L4COMUI_TO_L3F2_PGPROJ",$input);
                break;

            case "ProjTable":    // query project table
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_PROJTABLE, "MSG_ID_L4COMUI_TO_L3F2_PROJTABLE",$input);
                break;

            case "ProjNew": //创建新的项目信息
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_PROJNEW, "MSG_ID_L4COMUI_TO_L3F2_PROJNEW",$input);
                break;

            case "ProjMod": //修改项目信息
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_PROJMOD, "MSG_ID_L4COMUI_TO_L3F2_PROJMOD",$input);
                break;

            case "ProjPoint":   //查询所有监控点列表
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_ALLPROJPOINT, "MSG_ID_L4COMUI_TO_L3F2_ALLPROJPOINT",$input);
                break;

            case "PointProj": //查询该项目下面对应监控点列表
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_ONEPROJPOINT, "MSG_ID_L4COMUI_TO_L3F2_ONEPROJPOINT",$input);
                break;

            case "PointTable":  //查询所有监控点信息
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_POINTTABLE, "MSG_ID_L4COMUI_TO_L3F2_POINTTABLE",$input);
                break;

            case "PointDetail":
                //abandon
                break;

            case "PointNew":  //新建监测点
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_POINTNEW, "MSG_ID_L4COMUI_TO_L3F2_POINTNEW",$input);
                break;

            case "PointMod"://修改监测点信息
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_POINTMOD, "MSG_ID_L4COMUI_TO_L3F2_POINTMOD",$input);
                break;

            case "PointDev": //查询监测点下的HCU设备列表
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_POINTDEV, "MSG_ID_L4COMUI_TO_L3F2_POINTDEV",$input);
                break;

            case "DevTable": //查询HCU设备列表信息
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_DEVTABLE, "MSG_ID_L4COMUI_TO_L3F2_DEVTABLE",$input);
                break;

            case "DevNew":  //创建新的HCU信息
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_DEVNEW, "MSG_ID_L4COMUI_TO_L3F2_DEVNEW",$input);
                break;

            case "DevMod": //修改监测设备信息
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_DEVMOD, "MSG_ID_L4COMUI_TO_L3F2_DEVMOD",$input);
                break;

            case "MonitorList":      // get monitorList in map by user id
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4COMUI_TO_L3F3_MONITORLIST, "MSG_ID_L4COMUI_TO_L3F3_MONITORLIST",$input);
                break;

            case "GetStationActiveInfo"://查询站点是否激活状态
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_POINTACTIVEINFO, "MSG_ID_L4COMUI_TO_L3F2_POINTACTIVEINFO",$input);
                break;

            case "StationActive": //确认站点激活成功
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_POINTACTIVESET, "MSG_ID_L4COMUI_TO_L3F2_POINTACTIVESET",$input);
                break;

            case "Favourite_list": //获取用户常用站点
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4COMUI_TO_L3F3_FAVOURITELIST, "MSG_ID_L4COMUI_TO_L3F3_FAVOURITELIST",$input);
                break;

            case "Favourite_count":  //添加常用站点
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM3DM, MSG_ID_L4COMUI_TO_L3F3_FAVOURITECOUNT, "MSG_ID_L4COMUI_TO_L3F3_FAVOURITECOUNT",$input);
                break;

            case "TableQuery"://用户表，项目组/项目/站点/设备表的打印按钮对应的excel表导出
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM2CM, MSG_ID_L4COMUI_TO_L3F2_TABLEQUERY, "MSG_ID_L4COMUI_TO_L3F2_TABLEQUERY",$input);
                break;

            case "SensorUpdate":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4COMUI_TO_L3F4_SENSORUPDATE, "MSG_ID_L4COMUI_TO_L3F4_SENSORUPDATE",$input);
                break;

            case "SetUserMsg":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM7ADS, MSG_ID_L4COMUI_TO_L3F7_SETUSERMSG, "MSG_ID_L4COMUI_TO_L3F7_SETUSERMSG",$input);
                break;

            case "GetUserMsg":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM7ADS, MSG_ID_L4COMUI_TO_L3F7_GETUSERMSG, "MSG_ID_L4COMUI_TO_L3F7_GETUSERMSG",$input);
                break;

            case "ShowUserMsg":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM7ADS, MSG_ID_L4COMUI_TO_L3F7_SHOWUSERMSG, "MSG_ID_L4COMUI_TO_L3F7_SHOWUSERMSG",$input);
                break;

            case "GetUserImg":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM7ADS, MSG_ID_L4COMUI_TO_L3F7_GETUSERIMG, "MSG_ID_L4COMUI_TO_L3F7_GETUSERIMG",$input);
                break;

            case "ClearUserImg":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM7ADS, MSG_ID_L4COMUI_TO_L3F7_CLEARUSERIMG, "MSG_ID_L4COMUI_TO_L3F7_CLEARUSERIMG",$input);
                break;

            //以下视频和摄像头处理为老的方法，保留在这里暂时不起作用
            case "GetVideoList": //获取指定站点指定时间段内的所有视频文件列表
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4COMUI_TO_L3F4_HSMMPLIST, "MSG_ID_L4COMUI_TO_L3F4_HSMMPLIST",$input);
                break;

            case "GetVideo":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4COMUI_TO_L3F4_HSMMPPLAY, "MSG_ID_L4COMUI_TO_L3F4_HSMMPPLAY",$input);
                break;

            case "GetVideoCameraWeb": //使用第三方控件实现视频和摄像头处理
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4COMUI_TO_L3F4_CAMWEB, "MSG_ID_L4COMUI_TO_L3F4_CAMWEB",$input);
                break;

            case "GetCameraStatus": //Get camera vertical and horizontal angle and fetch a current photo
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4COMUI_TO_L3F4_GETCAMERASTATUS, "MSG_ID_L4COMUI_TO_L3F4_GETCAMERASTATUS",$input);
                break;

            case "GetCameraUnit":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4COMUI_TO_L3F4_GETCAMERAUNIT, "MSG_ID_L4COMUI_TO_L3F4_GETCAMERAUNIT",$input);
                break;
            case "CameraVAdj":
                break;
            case "CameraHAdj":
                break;

            case "GetAuditStabilityTable":  //获取稳定性统计参数表
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "action" => $action, "type" => $type,"user" => $user,"body" => $body);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4COM_UI, MFUN_TASK_ID_L3APPL_FUM6PM, MSG_ID_L4COMUI_TO_L3F6_PERFORMANCETABLE, "MSG_ID_L4COMUI_TO_L3F6_PERFORMANCETABLE",$input);
                break;

            default:
                $resp = "E: receive unknown UI action request";
                break;
        }

        if (!empty($resp)) {
            $jsonencode = json_encode($resp, JSON_UNESCAPED_UNICODE);
            $log_content = "T:" . $jsonencode;
            $loggerObj->mylog($project,$user,"NULL","MFUN_TASK_ID_L4COM_UI",$msgName,$log_content);
            echo trim($jsonencode);
        }

        //返回
        return true;
    }

}//End of class_task_service


?>
