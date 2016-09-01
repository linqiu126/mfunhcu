<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:49
 */
//include_once "../l1comvm/vmlayer.php";
include_once "../l1comvm/vmlayer.php";
include_once "dbi_l4emcwx_ui.class.php";

header("Content-type:text/html;charset=utf-8");

class classTaskL4emcwxUi
{
    //构造函数
    public function __construct()
    {

    }

    /**************************************************************************************
     *                             任务入口函数                                           *
     *************************************************************************************/
    public function mfun_l4emcwx_ui_task_main_entry($parObj, $msgId, $msgName, $msg)
    {

        //定义本入口函数的logger处理对象及函数
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //入口消息内容判断
        if (empty($msg) == true) {
            $result = "Received null message body";
            $log_content = "R:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L4EMCWX_UI", "mfun_l4emcwx_ui_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }
        //多条消息发送到L4EMXWXUI，这里潜在的消息太多，没法一个一个的判断，故而只检查上下界
        if (($msgId <= MSG_ID_MFUN_MIN) || ($msgId >= MSG_ID_MFUN_MAX)) {
            $result = "Msgid or MsgName error";
            $log_content = "P:" . json_encode($result);
            $loggerObj->logger("MFUN_TASK_ID_L4EMCWX_UI", "mfun_l4emcwx_ui_task_main_entry", $log_time, $log_content);
            echo trim($result);
            return false;
        }

        if (($msgId == MSG_ID_L4EMCWXUI_CLICK_INCOMING) && (isset($msg))) {
            $resp = "";
            //这里是L4EMCWX与L3APPL功能之间的交换矩阵，从而让UI对应的多种不确定组合变换为L3APPL确定的功能组合
            switch ($msg) {
                case "personal_bracelet_radiation_current":
                    /*
                        var device = data.id;
                        var retval={
                            status:"true",
                            ret: GetRandomNum(0,255).toString()
                        };
                        return JSON.stringify(retval);
                    */
                    if (isset($_GET["id"])) $deviceId = trim($_GET["id"]); else $deviceId = "";
                    $input = array("deviceid" => $deviceId);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4EMCWX_UI, MFUN_TASK_ID_L3APPL_FUM0WECHAT, MSG_ID_L4EMCWXUI_TO_L3F0_EMCNOW, "MSG_ID_L4EMCWXUI_TO_L3F0_EMCNOW",$input);
                    break;
                case "personal_bracelet_radiation_alarm":
                    /*
                    var retval={
                        status:"true",
                        warning: "150",
                        alarm: "200"
                    };
                    return JSON.stringify(retval);
                    */
                    if (isset($_GET["id"])) $deviceId = trim($_GET["id"]); else $deviceId = "";
                    $input = array("deviceid" => $deviceId);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4EMCWX_UI, MFUN_TASK_ID_L3APPL_FUM0WECHAT, MSG_ID_L4EMCWXUI_TO_L3F0_EMCALARM, "MSG_ID_L4EMCWXUI_TO_L3F0_EMCALARM",$input);
                    break;
                case "personal_bracelet_radiation_history":
                    /*
                        var device = data.id;
                        var retlist = new Array();
                        for(var i=0;i<48;i++){
                          retlist.push(GetRandomNum(0,255).toString())
                        }
                        var retval={
                          status:"true",
                          ret:retlist
                        }
                        return JSON.stringify(retval);
                    */
                    if (isset($_GET["id"])) $deviceId = trim($_GET["id"]); else $deviceId = "";
                    $input = array("deviceid" => $deviceId);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4EMCWX_UI, MFUN_TASK_ID_L3APPL_FUM0WECHAT, MSG_ID_L4EMCWXUI_TO_L3F0_EMCHISTORY, "MSG_ID_L4EMCWXUI_TO_L3F0_EMCHISTORY",$input);
                    break;
                case "personal_bracelet_radiation_track":
                    /*
                        var device = data.id;
                        var retlist = new Array();
                        for(var i=0;i<48*6;i++){
                            var map = {
                                longitude: (121.514168+0.05*i).toString(),
                                latitude: "31.240246",
                                value:GetRandomNum(0,255).toString(),
                            }
                            retlist.push(GetRandomNum(0,255).toString())
                        }
                        var retval={
                            status:"true",
                            ret:retlist
                        }
                        return JSON.stringify(retval);
                    */
                    if (isset($_GET["id"])) $deviceId = trim($_GET["id"]); else $deviceId = "";
                    $input = array("deviceid" => $deviceId);
                    $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4EMCWX_UI, MFUN_TASK_ID_L3APPL_FUM0WECHAT, MSG_ID_L4EMCWXUI_TO_L3F0_EMCTRACK, "MSG_ID_L4EMCWXUI_TO_L3F0_EMCTRACK",$input);
                    break;
                default:
                    break;
            }
        }
    }
}//End of class_task_service

?>