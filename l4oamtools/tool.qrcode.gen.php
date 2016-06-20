<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2015/7/1
 * Time: 19:52
 */
/**
 * 本工具用于管理员生成设备二维码，并测试扫码和绑定设备功能
 *
**/
include_once "../l1comvm/vmlayer.php";
include_once "../l2sdk/sdk_wechat.class.php";
header("Content-type:text/html;charset=utf-8");
//如果运行在本地，以下地址存放二维码图片
static $imagePath = "D:/work/image/";


$wx_options = array(
    'token'=>WX_TOKEN, //填写你设定的key
    'encodingaeskey'=>WX_ENCODINGAESKEY, //填写加密用的EncodingAESKey，如接口为明文模式可忽略
    'appid'=>WX_APPID,
    'appsecret'=>WX_APPSECRET, //填写高级调用功能的密钥
    'debug'=> WX_DEBUG,
    'logcallback' => WX_LOGCALLBACK
);

$mac = $_POST["mac_address"];
echo "Input MAC ADDRESS = " . $mac ."<br>";

$wxObj = new class_wechat_sdk($wx_options);
//Step1:刷新Token
echo "<br><H2>微信硬件工作环境即将开始......<br></H2>";
$wxDevObj = new class_wx_IOT_sdk(WX_APPID, WX_APPSECRET);

//实验Token是否已经被刷新
echo "<br>测试最新刷新的Token=<br>"."$wxDevObj->access_token"."<br>";

//Step2: 从数据库中取得有效的DEVICE_ID
$wxDbObj = new class_wx_db();
$result = $wxDbObj->db_deviceqrcode_query_mac();
if ($result ==null)
{
    echo "<br>没有空的MAC地址了，请联系管理员! <br>";
}else{
    $deviceIdBLE = $result["deviceid"];
    $qrcode = $result["qrcode"];
    var_dump($deviceIdBLE);
    var_dump($qrcode);

//验证二维码
    $qrcode_result = $wxDevObj->verify_qrcode($qrcode);
    echo "<br>二维码验证的结果<br>";
    var_dump($qrcode_result);
    $deviceTypeBLE = $qrcode_result["device_type"];
//将二维码使用图像方式显示出来
    var_dump($wxDevObj->create_qrcodeDisplay($qrcode));
//Update MAC地址到系统中
    var_dump($wxDbObj->db_deviceqrcode_update_mac($deviceIdBLE, $mac));

    // Step3 设备授权
// 设备授权后才能进行扫码绑定
// 开发调试时，可以先用假的信息授权，测试服务端设备绑定事件的处理。
// 设备参数确定后，更新为正确的设备属性，再和设备联调。
    echo "<br>设备授权结果 <br>";
    var_dump($wxDevObj->device_AuthBLE($deviceIdBLE, $mac));

// Step4 设备状态查询
    echo "<br>查询设备状态 <br>";
    var_dump($wxDevObj->getstat_qrcodebyDeviceid($deviceIdBLE));

}

//end of tool_main();
?>