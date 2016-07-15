<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/7/7
 * Time: 22:10
 */
include_once "../l1comvm/vmlayer.php";

class classTaskL4nbiotIpmUi
{
    //构造函数
    public function __construct()
    {

    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l4nbiot_ipm_ui_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L4NBIOT_IPM_UI", "mfun_l4nbiot_ipm_ui_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到L4AQYCUI，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L4NBIOT_IPM_UI", "mfun_l4nbiot_ipm_ui_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        if (($msgId == MSG_ID_L4NBIOT_IPMUI_CLICK_INCOMING) && (isset($msg)))
        {
            $resp = "";
            //这里是L4NBIOTIPMUI与底层L2SDK之间的交换矩阵
            switch($msg)
            {
                //require data structure:
                //var map={
                //    action:"login",
                //    name:$("#Username_Input").val(),
                //    password:$("#Password_Input").val()
                //};
                //return data structure:
                //usrinfo={
                //  status:"true",
                //  text:"login successfully",
                //  key: "1234567",
                //  admin: "true"
                //};
                //具体功能待实现
                case "login":  //login message:
                    if (isset($_GET["name"])) $name = trim($_GET["name"]); else $name = "";
                    if (isset($_GET["password"])) $pwd = trim($_GET["password"]); else $pwd = "";
                    $input = array("user" => $name, "pwd" => $pwd);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L3APPL_FUM1SYM, MSG_ID_L4NBIOT_IPMUI_TO_L3F1_LOGIN, "MSG_ID_L4NBIOT_IPMUI_TO_L3F1_LOGIN", $input);
                    break;

                //function reqdata1_f1
                case "afn_reqdata1_f1":
                    $input = array("user" => "", "func" => "afn_reqdata1_f1", "pwd" => "");
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376, MSG_ID_L4NBIOT_IPMUI_TO_NBIOT_STD_QG376_DL_REQUEST, "MSG_ID_L4NBIOT_IPMUI_TO_NBIOT_STD_QG376_DL_REQUEST", $input);
                    break;

                //function reqdata1_f2
                case "afn_reqdata1_f2":
                    $input = array("user" => "", "func" => "afn_reqdata1_f2", "pwd" => "");
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376, MSG_ID_L4NBIOT_IPMUI_TO_NBIOT_STD_QG376_DL_REQUEST, "MSG_ID_L4NBIOT_IPMUI_TO_NBIOT_STD_QG376_DL_REQUEST", $input);
                    break;

                //function reqdata1_f25
                case "afn_reqdata1_f25":
                    $input = array("user" => "", "pwd" => "");
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376, MSG_ID_L4NBIOT_IPMUI_TO_NBIOT_STD_QG376_DL_REQUEST, "MSG_ID_L4NBIOT_IPMUI_TO_NBIOT_STD_QG376_DL_REQUEST", $input);
                    break;

                //function reqdata1_f26
                case "afn_reqdata1_f26":
                    $input = array("user" => "", "pwd" => "");
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4NBIOT_IPM_UI, MFUN_TASK_ID_L2SDK_NBIOT_STD_QG376, MSG_ID_L4NBIOT_IPMUI_TO_NBIOT_STD_QG376_DL_REQUEST, "MSG_ID_L4NBIOT_IPMUI_TO_NBIOT_STD_QG376_DL_REQUEST", $input);
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
            $loggerObj->logger("L4NBIOTIPMUI", "MFUN_TASK_ID_L4NBIOT_IPM_UI", $log_time, $log_content);
            echo trim($resp);
        }

        //返回
        return true;
    }

}//End of class_task_service

?>