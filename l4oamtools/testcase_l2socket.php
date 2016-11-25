<?php
/**
 * Created by PhpStorm.
 * User: zehongl
 * Date: 2016/8/27
 * Time: 11:25
 */

include_once "../l1comvm/vmlayer.php";

/**************************************************************************************
 *                             SOCKET TEST CASES                              *
 *************************************************************************************/
if (TC_SOCKET == true) {
//SOCKET测试开始
    echo " [TC SOCKET: xxx START]\n";

    $data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_CL_0301]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[400183]]></Content><FuncFlag>0</FuncFlag></xml>";
    $data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_CL_0301]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[4A028101]]></Content><FuncFlag>XXX</FuncFlag></xml>";

    $obj = new classTaskL1vmCoreRouter();
    $obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_IOT_HCU, MSG_ID_L2SDK_HCU_DATA_COMING, "MSG_ID_L2SDK_HCU_DATA_COMING", $data);


    if (MFUN_CLOUD_HCU == "AQ_HCU") {
        require("../l1mainentry/cloud_callback_socket_listening.php");
    }
    echo " [TC SOCKET: xxx END]\n";

//SOCKET测试结束
}