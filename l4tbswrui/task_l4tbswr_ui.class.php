<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:50
 */
include_once "../l1comvm/vmlayer.php";
include_once "dbi_l4tbswr_ui.class.php";

class classTaskL4tbswrUi
{
    //构造函数
    public function __construct()
    {

    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l4tbswr_ui_task_main_entry($parObj, $msgId, $msgName, $msg)
    {
        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L4TBSWR_UI", "mfun_l4tbswr_ui_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到L4TBSWRUI，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)){
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L4TBSWR_UI", "mfun_l4tbswr_ui_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        if (($msgId == MSG_ID_L4TBSWR_CLICK_INCOMING) && (isset($msg)))
        {
            $resp = "";
            //这里是L4TBSWR与L3APPL功能之间的交换矩阵，从而让UI对应的多种不确定组合变换为L3APPL确定的功能组合
            switch($msg)
            {

                case "GetTempStatus": //Query A Lock status by statCode.
                    if (isset($_GET["id"])) $uid = trim($_GET["id"]); else  $uid = "";
                    if (isset($_GET["StatCode"])) $StatCode = trim($_GET["StatCode"]); else  $StatCode= "";
                    $input = array("uid" => $uid, "StatCode" => $StatCode);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4CLOUDLOCK_UI, MFUN_TASK_ID_L3APPL_FUM4ICM, MSG_ID_L4TBSWRUI_TO_L3F4_GETTEMPSTATUS, "MSG_ID_L4TBSWRUI_TO_L3F4_GETTEMPSTATUS",$input);
                    break;

                /*$locked = 'true';
                $retval=array(
                    'status'=>'true',
                    'lock'=>$locked
                );
                $jsonencode = _encode($retval);
                echo $jsonencode; break;*/

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
            $loggerObj->logger("L4TBSWRUI", "MFUN_TASK_ID_L4TBSWR_UI", $log_time, $log_content);
            echo trim($resp);
        }

        //返回
        return true;

    }

}//End of class_task_service

?>