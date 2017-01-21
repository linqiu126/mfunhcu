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

    $data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_CL_0301]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[400182]]></Content><FuncFlag>0</FuncFlag></xml>";
    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_CL_0301]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[4A028101]]></Content><FuncFlag>XXX</FuncFlag></xml>";

    //FHYS Temperature
    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_CL_0302]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[4903820C00]]></Content><FuncFlag>0</FuncFlag></xml>";
    //FHYS Humidity
    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_CL_0302]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[4A03821700]]></Content><FuncFlag>0</FuncFlag></xml>";
    //FHYS 异常消息，多条XML消息粘连
    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_CL_0302]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[400182]]></Content><FuncFlag>0</FuncFlag></xml><xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_CL_0302]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[4903821000]]></Content><FuncFlag>0</FuncFlag></xml>";

    $data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0499]]></FromUserName><CreateTime>1480759074</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[3B32810C000002890000028A0000028B0000028C0000028D0000028E0000028F0000029000000291000002920000029300000294]]></Content><FuncFlag>0</FuncFlag></xml>";
    $data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1484654902</CreateTime><MsgType><![CDATA[hcu_alarm]]></MsgType><Content><![CDATA[B00C8101010100010101587E0936]]></Content><FuncFlag>0</FuncFlag></xml>";

    $data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_CL_0304]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[4C100000000000000F320000000000000000]]></Content><FuncFlag>0</FuncFlag></xml>";
    $obj = new classTaskL1vmCoreRouter();
    $obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_IOT_HCU, MSG_ID_L2SDK_HCU_DATA_COMING, "MSG_ID_L2SDK_HCU_DATA_COMING", $data);


    if (MFUN_CLOUD_HCU == "AQ_HCU") {
        require("../l1mainentry/cloud_callback_socket_listening.php");
    }
    echo " [TC SOCKET: xxx END]\n";

//SOCKET测试结束
}