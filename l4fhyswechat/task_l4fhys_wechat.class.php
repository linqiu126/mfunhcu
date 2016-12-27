<?php
/**
 * Created by PhpStorm.
 * User: QL
 * Date: 2016/10/02
 * Time: 11:55
 */
include_once "../l1comvm/vmlayer.php";
include_once "dbi_l4fhys_wechat.class.php";

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
        $log_time = date("Y-m-d H:i:s", time());

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L4FHYS_WECHAT", "mfun_l4fhys_wechat_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到L4CLOCKLOCKUI，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L4FHYS_WECHAT", "mfun_l4fhys_wechat_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        if (($msgId == MSG_ID_L4FHYS_WECHAT_CLICK_INCOMING) && (isset($msg)))
        {
            $resp = "";
            //这里是L4CLOUDLOCK与L3APPL功能之间的交换矩阵，从而让UI对应的多种不确定组合变换为L3APPL确定的功能组合
            switch($msg)
            {
                case "HCU_Wechat_Login": //Use Wechat to login the Server, response is the userID in system.
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_WECHAT, MFUN_TASK_ID_L3WX_OPR_FHYS, MSG_ID_FHYSWECHAT_TO_L3WXOPR_LOGIN, "MSG_ID_FHYSWECHAT_TO_L3WXOPR_LOGIN",$input);
                    break;
                case "HCU_Lock_Query": //Query How many lock is autherized to user,response is a list of StatCode and Name and Location and so on
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_WECHAT, MFUN_TASK_ID_L3WX_OPR_FHYS, MSG_ID_FHYSWECHAT_TO_L3WXOPR_LOCKQUERY, "MSG_ID_FHYSWECHAT_TO_L3WXOPR_LOCKQUERY",$input);
                    break;

                case "HCU_Lock_Status": //Query A Lock status by statCode.
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_WECHAT, MFUN_TASK_ID_L3WX_OPR_FHYS, MSG_ID_FHYSWECHAT_TO_L3WXOPR_LOCKSTATUS, "MSG_ID_FHYSWECHAT_TO_L3WXOPR_LOCKSTATUS",$input);
                    break;

                case "HCU_Lock_open": //Open a lock
                    if (isset($_GET["type"])) $type = trim($_GET["type"]); else $type = "";
                    if (isset($_GET["user"])) $user = trim($_GET["user"]); else $user = "";
                    if (isset($_GET["body"])) $body = $_GET["body"]; else $body = "";

                    $input = array("type" => $type,"user" => $user,"body" => $body);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4FHYS_WECHAT, MFUN_TASK_ID_L3WX_OPR_FHYS, MSG_ID_FHYSWECHAT_TO_L3WXOPR_LOCKOPEN, "MSG_ID_FHYSWECHAT_TO_L3WXOPR_LOCKOPEN",$input);
                    break;

                case "HCU_Lock_close": //Close a lock
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
            $loggerObj->logger("MFUN_TASK_ID_L4FHYS_WECHAT", "mfun_l4fhys_wechat_task_main_entry", $log_time, $log_content);
            echo trim($resp);
        }

        //返回
        return true;
    }

}//End of class_task_service

?>
