<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/7/17
 * Time: 23:49
 */
include_once "../l1comvm/vmlayer.php";

/**************************************************************************************
 *                             WECHAT / EMCWX TEST CASES                              *
 *************************************************************************************/
if (TC_EMCWX == true){
//EMCWX测试开始
    echo " [TC EMCWX: EMC DEVICE_TEXT START]\n";
//$content = pack("H*", "FE01001C71212372010002206500403020101020304050607081800");
    $content = base64_encode(pack("H*", "201000220650040302010102030405060708"));
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[IHU]]></ToUserName><FromUserName><![CDATA[oS0Chv3Uum1TZqHaCEb06AoBfCvY]]></FromUserName><DeviceID><![CDATA[gh_70c714952b02_8cd47e1f6141e49a4e45f4b807cf41fe]]></DeviceID>><CreateTime>1460039152</CreateTime><MsgType><![CDATA[device_text]]></MsgType><Content><![CDATA[" . $content . "]]></Content><FuncFlag>0</FuncFlag></xml>";
    require("../l1mainentry/cloud_callback_wechat.php");
    echo " [TC EMCWX: EMC DEVICE_TEXT END]\n";

    echo " [TC EMCWX: EMC DEVICE_EVENT START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[device_event]]></MsgType><Content><![CDATA[201881050201124945000000004E000000000000000057066DF0]]></Content><FuncFlag>0</FuncFlag></xml>";
    require("../l1mainentry/cloud_callback_wechat.php");
    echo " [TC EMCWX: EMC DEVICE_EVENT END]\n";

    echo " [TC EMCWX: WEIXIN CLICK_EMC_READ START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[gh_70c714952b02]]></ToUserName><FromUserName><![CDATA[oS0Chv-avCH7W4ubqOQAFXojYODY]]></FromUserName><CreateTime>1470315946</CreateTime><MsgType><![CDATA[event]]></MsgType><Event><![CDATA[CLICK]]></Event><EventKey><![CDATA[CLICK_EMC_READ]]></EventKey></xml>";
    require("../l1mainentry/cloud_callback_wechat.php");
    echo " [TC EMCWX: WEIXIN CLICK_EMC_READ END]\n";


//EMCWX测试结束
}


?>