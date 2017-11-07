<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/27
 * Time: 22:49
 */
//include_once "../l1comvm/vmlayer.php";
include_once "../l1comvm/vmlayer.php";

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
        $project = MFUN_PRJ_IHU_EMCWXUI;

        //入口消息内容判断
        if (empty($msg) == true) {
            $log_content = "E: receive null message body";
            $loggerObj->mylog($project,"NULL","H5UI_ENTRY_EMCWX","MFUN_TASK_ID_L4EMCWX_UI",$msgName,$log_content);
            return false;
        }
        if (($msgId != MSG_ID_L4EMCWXUI_CLICK_INCOMING) || ($msgName != "MSG_ID_L4EMCWXUI_CLICK_INCOMING")){
            $log_content = "E: Msgid or MsgName error";
            $loggerObj->mylog($project,"NULL","H5UI_ENTRY_EMCWX","MFUN_TASK_ID_L4EMCWX_UI",$msgName,$log_content);
            return false;
        }

        if (isset($msg)) $action = trim($msg); else $action = "";
        //这里是L4EMCWX与L3APPL功能之间的交换矩阵，从而让UI对应的多种不确定组合变换为L3APPL确定的功能组合
        switch ($action)
        {
            case "wechat_login":
                if (isset($_GET["code"])) $code = trim($_GET["code"]); else $code = "";
                $input = array("code" => $code);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4EMCWX_UI, MFUN_TASK_ID_L3WX_OPR_EMC, MSG_ID_L4EMCWXUI_TO_L3WXOPR_EMCUSER, "MSG_ID_L4EMCWXUI_TO_L3WXOPR_EMCUSER",$input);
                break;
            case "personal_bracelet_radiation_current":
                /*
                    var device = data.id;
                    var retval={
                        status:"true",
                        ret: GetRandomNum(0,255).toString()
                    };
                    return JSON.stringify(retval);
                */
                if (isset($_GET["id"])) $openid = trim($_GET["id"]); else $openid = "";
                $input = array("openid" => $openid);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4EMCWX_UI, MFUN_TASK_ID_L3WX_OPR_EMC, MSG_ID_L4EMCWXUI_TO_L3WXOPR_EMCNOW, "MSG_ID_L4EMCWXUI_TO_L3WXOPR_EMCNOW",$input);
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
                if (isset($_GET["id"])) $openid = trim($_GET["id"]); else $openid = "";
                $input = array("openid" => $openid);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4EMCWX_UI, MFUN_TASK_ID_L3WX_OPR_EMC, MSG_ID_L4EMCWXUI_TO_L3WXOPR_EMCALARM, "MSG_ID_L4EMCWXUI_TO_L3WXOPR_EMCALARM",$input);
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
                if (isset($_GET["id"])) $openid = trim($_GET["id"]); else $openid = "";
                $input = array("openid" => $openid);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4EMCWX_UI, MFUN_TASK_ID_L3WX_OPR_EMC, MSG_ID_L4EMCWXUI_TO_L3WXOPR_EMCHISTORY, "MSG_ID_L4EMCWXUI_TO_L3WXOPR_EMCHISTORY",$input);
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
                if (isset($_GET["id"])) $openid = trim($_GET["id"]); else $openid = "";
                $input = array("openid" => $openid);
                $parObj->mfun_l1vm_msg_send(MFUN_TASK_ID_L4EMCWX_UI, MFUN_TASK_ID_L3WX_OPR_EMC, MSG_ID_L4EMCWXUI_TO_L3WXOPR_EMCTRACK, "MSG_ID_L4EMCWXUI_TO_L3WXOPR_EMCTRACK",$input);
                break;
            default:
                break;
        }
    }

}//End of class_task_service

?>