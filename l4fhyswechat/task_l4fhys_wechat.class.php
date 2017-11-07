<?php
/**
 * Created by PhpStorm.
 * User: QL
 * Date: 2016/10/02
 * Time: 11:55
 */
include_once "../l1comvm/vmlayer.php";

class classTaskL4fhysWechat
{
    //构造函数
    public function __construct()
    {

    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l4fhys_wechat_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $project = MFUN_PRJ_HCU_FHYSWX;

        //入口消息内容判断
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog($project,"NULL","H5UI_ENTRY_FHYS_WECHAT","MFUN_TASK_ID_L4FHYS_WECHAT",$msgName,$log_content);
            return false;
        }
        if (($msgId != MSG_ID_L4FHYS_WECHAT_CLICK_INCOMING) || ($msgName != "MSG_ID_L4FHYS_WECHAT_CLICK_INCOMING") ){
            $log_content = "E: receive MsgId or MsgName error";
            $loggerObj->mylog($project,"NULL","H5UI_ENTRY_FHYS_WECHAT","MFUN_TASK_ID_L4FHYS_WECHAT",$msgName,$log_content);
            return false;
        }

        $user = "";
        if (isset($msg)) $action = trim($msg); else $action = "";
        //这里是L4CLOUDLOCK与L3APPL功能之间的交换矩阵，从而让UI对应的多种不确定组合变换为L3APPL确定的功能组合
        switch($action)
        {
            case "HCU_Wechat_Login": //Use Wechat to login the Server, response is the userID in system.
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "type" => $type,"user" => $user,"body" => $body);
                if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_WECHAT,
                        MFUN_TASK_ID_L3WX_OPR_FHYS,
                        MSG_ID_FHYSWECHAT_TO_L3WXOPR_LOGIN,
                        "MSG_ID_FHYSWECHAT_TO_L3WXOPR_LOGIN",
                        $input) == false) $resp = "E: send to message buffer error";
                else $resp = "";
                break;

            case "HCU_Wechat_Bonding":
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "type" => $type,"user" => $user,"body" => $body);
                if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_WECHAT,
                        MFUN_TASK_ID_L3WX_OPR_FHYS,
                        MSG_ID_FHYSWECHAT_TO_L3WXOPR_USERBIND,
                        "MSG_ID_FHYSWECHAT_TO_L3WXOPR_USERBIND",
                        $input) == false) $resp = "E: send to message buffer error";
                else $resp = "";
                break;

            case "HCU_Lock_Query": //Query How many lock is autherized to user,response is a list of StatCode and Name and Location and so on
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "type" => $type,"user" => $user,"body" => $body);
                if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_WECHAT,
                        MFUN_TASK_ID_L3WX_OPR_FHYS,
                        MSG_ID_FHYSWECHAT_TO_L3WXOPR_LOCKQUERY,
                        "MSG_ID_FHYSWECHAT_TO_L3WXOPR_LOCKQUERY",
                        $input) == false) $resp = "E: send to message buffer error";
                else $resp = "";
                break;

            case "HCU_Lock_Status": //Query A Lock status by statCode.
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "type" => $type,"user" => $user,"body" => $body);
                if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_WECHAT,
                        MFUN_TASK_ID_L3WX_OPR_FHYS,
                        MSG_ID_FHYSWECHAT_TO_L3WXOPR_LOCKSTATUS,
                        "MSG_ID_FHYSWECHAT_TO_L3WXOPR_LOCKSTATUS",
                        $input) == false) $resp = "E: send to message buffer error";
                else $resp = "";
                break;

            case "HCU_Lock_open": //Open a lock
                if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                $input = array("project" => $project, "type" => $type,"user" => $user,"body" => $body);
                if ($parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_WECHAT,
                        MFUN_TASK_ID_L3WX_OPR_FHYS,
                        MSG_ID_FHYSWECHAT_TO_L3WXOPR_LOCKOPEN,
                        "MSG_ID_FHYSWECHAT_TO_L3WXOPR_LOCKOPEN",
                        $input) == false) $resp = "E: send to message buffer error";
                else $resp = "";
                break;

            case "HCU_Lock_close": //Close a lock
                $resp = "";
                break;

            default:
                $resp = "";
                break;
        }

        if (!empty($resp)) {
            $log_content = json_encode($resp,JSON_UNESCAPED_UNICODE);
            $loggerObj->mylog($project,$user,"MFUN_TASK_ID_L4FHYS_WECHAT","MFUN_TASK_ID_L3WX_OPR_FHYS",$msgName,$log_content);
        }

        //返回
        return true;
    }

}//End of class_task_service

?>
