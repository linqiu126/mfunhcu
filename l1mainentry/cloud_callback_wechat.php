<?php
/*
    方倍工作室原创，ZJL修改
*/
include_once "../l1comvm/vmlayer.php";
include_once "../l2sdk/task_l2sdk_wechat.class.php";
//header("Content-type:text/html;charset=utf-8");

/*
// 主程序MAIN()
$wx_options = array(
    'token'=>MFUN_WX_TOKEN, //填写你设定的key
    'encodingaeskey'=>MFUN_WX_ENCODINGAESKEY, //填写加密用的EncodingAESKey，如接口为明文模式可忽略
    'appid'=>MFUN_WX_APPID,
    'appsecret'=>MFUN_WX_APPSECRET, //填写高级调用功能的密钥
    'debug'=> MFUN_WX_DEBUG,
    'logcallback' => MFUN_WX_LOGCALLBACK
);
$wxObj = new classTaskL2sdkWechat($wx_options);
//$wxObj->responseMsg();
if (isset($_GET['echostr'])) {
    $wxObj->valid_sdk01();
}else{
    $wxObj->responseMsg();}
*/

// 主程序MAIN()
$obj = new classTaskL1vmCoreRouter();
//$obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_EMC_WX, NULL, NULL, file_get_contents('php://input','r'));
$obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_WECHAT, NULL, NULL, $GLOBALS["HTTP_RAW_POST_DATA"]);

?>