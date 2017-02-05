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

    //4E
    $data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_CL_0499]]></FromUserName><CreateTime>1485035971</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[4E81006800030001014D0000060404010101014D00000604040101010148000001024B000001024600000102470000010245000001024900000303FFFF4A00000303FFFF450100030300234E00000303FB5D4E01000303DFD84400000303E0C04E02000303C68B4E03000102]]></Content><FuncFlag>0</FuncFlag></xml>";
    //4C
    $data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_CL_1001]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[4C100101010101010F320000000000000000]]></Content><FuncFlag>0</FuncFlag></xml>";
    //$data = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_CL_1001]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[400183]]></Content><FuncFlag>00000001</FuncFlag></xml>";
    $obj = new classTaskL1vmCoreRouter();
    $obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_IOT_HCU, MSG_ID_L2SDK_HCU_DATA_COMING, "MSG_ID_L2SDK_HCU_DATA_COMING", $data);


    if (MFUN_CLOUD_HCU == "AQ_HCU") {
        require("../l1mainentry/cloud_callback_socket_listening.php");
    }
    echo " [TC SOCKET: xxx END]\n";

//SOCKET测试结束
}