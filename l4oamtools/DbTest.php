<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2015/7/3
 * Time: 11:33
 */
include_once "../l1comvm/vmlayer.php";
include_once "../l2sdk/l2sdk_wechat.class.php";
include_once "../l2sdk/l2sdk_iot_hcu.class.php";
include_once "../l4aqycui/dbi_l4aqyc_ui.class.php";

//header("Content-type:text/html;charset=utf-8");

/*
$a = "2016-06-12 21:06:00";

$b = strtotime($a);
$stamp = strtotime("2016-06-12 21:07:50");

$d = date("Y-m-d H:m:s", time());
$c = $stamp - $b;

$mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
$query_str = "SELECT `auth_code` FROM `t_authlist` WHERE `uid` = 'UID003'";
$result = $mysqli->query($query_str);

$temp = array();
while($row = $result->fetch_array())
{
    $p_code = $row["auth_code"];
    array_push($temp,$p_code);
}
*/

$uiDbObj = new class_ui_db();
/*
$plist[0] = array(
    'id'=>"P_0001",
    'name'=>"万宝国际广场1"
);
$plist[1] = array(
    'id'=>"P_0002",
    'name'=>"万宝国际广场2"
);
$pginfo =array(
    'PGCode' => "PG_9999",
    'PGName' => "Test",
    'ChargeMan' => "Test",
    'Telephone' => "123",
    'Department' => "D",
    'Address' => "A",
    'Stage' => "S",
    'Projlist' => $plist,
    'user' => "UID001"
);


$siteinfo =array(
    'StatCode' => "123",
    'StatName' => "测试监测点",
    'ProjCode' => "P_9999",
    'ChargeMan' => "123",
    'Telephone' => "123",
    'Longitude' => "123",
    'Latitude' => "321",
    'Department' =>"123",
    'Address' => "123",
    'Country' => "浦东",
    'Street' => "街道",
    'Square' => "9999",
    'ProStartTime' => "2016-06-16",
    'Stage' => "开工"
);

$result = $uiDbObj->db_user_projlist_req("UID001");

$pgtable = $uiDbObj->db_pgtable_req(0, 8, "user_01");

$result = $uiDbObj->db_usertable_req(1, 3);

$result = $uiDbObj->db_login_req("user_01", "user01");
*/

/*
class testObj
{
    var $EventKey = "CLICK_EMC_READ";
    var $FromUserName = "oS0Chv3Uum1TZqHaCEb06AoBfCvY";
    var $ToUserName = "wx1183be5c8f6a24b4";
    var $DeviceID = "gh_70c714952b02_8cd47e1f6141e49a4e45f4b807cf41fe";
    var $Content = "IA4AAAABAgMEBQECAwQFBg==";

}

$object = new testObj();
$wxObj = new class_wx_IOT_sdk(WX_APPID,WX_APPSECRET);

$obj = new class_hcu_IOT_sdk();
$hrb = "##005820151118055535000___11111ZHB_HRBHCU_SH_0301_4444440555666633CA";
$nom = "##007020151118055536000___11111ZHB_NOMHCU_SH_0301_44444405556666a01000=1234,DD54";


$a = $obj->receive_hcu_zhbMessage($hrb);

date_default_timezone_set('prc');
$timestamp = time();
$a = date("ymd",$timestamp);
$b = date("hms",$timestamp);


$content = "IA4AAAABAgMEBQECAwQFBg==";

$fromuser = "oS0Chv3Uum1TZqHaCEb06AoBfCvY";  //"oAjc8uKl-QS9EGIfRGb8";
$deviceid = "gh_70c714952b02_8cd47e1f6141e49a4e45f4b807cf41fe";
$devicetype = "gh_70c714952b02";


$wx_options = array(
    'token'=>WX_TOKEN, //填写你设定的key
    'encodingaeskey'=>WX_ENCODINGAESKEY, //填写加密用的EncodingAESKey，如接口为明文模式可忽略
    'appid'=>WX_APPID,
    'appsecret'=>WX_APPSECRET, //填写高级调用功能的密钥
    'debug'=> WX_DEBUG,
    'logcallback' => WX_LOGCALLBACK
);
$Obj = new class_wechat_sdk($wx_options);
$resp = $Obj->responseMsg();*/


//EMC 20
//$postStr = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1463066438</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[20188105020113DB45000000004E0000000000000000570A59B2]]></Content><FuncFlag>0</FuncFlag></xml>";
//$postStr = "<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201124945000000004E000000000000000057066DF0]]></Content><FuncFlag>0</FuncFlag></xml>";
//PM 25
//$postStr = "<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872404</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[252281010201000001120000011200000492000000000000000000000000000056E55E14]]></Content><FuncFlag>0</FuncFlag></xml>";
//Wind speed 26
//$postStr = "<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1459985808</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[261881020201000045000000004E000000000000000057059D90]]></Content><FuncFlag>0</FuncFlag></xml>";
//Wind Direction 27
//$postStr = "<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1459899126</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[271881030201008D45000000004E000000000000000057044AF5]]></Content><FuncFlag>0</FuncFlag></xml>";
//Temperature 28
//$postStr = "<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872422</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[2818810602010223000000000000000000000000000056E55E26]]></Content><FuncFlag>0</FuncFlag></xml>";
//Humidity 29
//$postStr = "<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872525</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[29188106020100AC000000000000000000000000000056E55E8D]]></Content><FuncFlag>0</FuncFlag></xml>";
//Noise 2B
//$postStr = "<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872731</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[2B1A810A02020000028B000000000000000000000000000056E55F5B]]></Content><FuncFlag>0</FuncFlag></xml>";
//Heart Beat
//$postStr = "<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872409</CreateTime><MsgType><![CDATA[hcu_heart_beat]]></MsgType><Content><![CDATA[FE00]]></Content><FuncFlag>0</FuncFlag></xml>";
//CMD pooling
//$postStr = "<xml><ToUserName><![CDATA[SAE_MFUNHCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872559</CreateTime><MsgType><![CDATA[hcu_command]]></MsgType><Content><![CDATA[FD00]]></Content><FuncFlag>0</FuncFlag></xml>";

//$postStr = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0305]]></FromUserName><CreateTime>1463066586</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201130345000000004E000000000000000057318D70]]></Content><FuncFlag>0</FuncFlag></xml>";

//中环保格式
$postStr = "##007020160619033803000___11111ZHB_NOMHCU_SH_0304_44444405556666a01000=139A,68BE";

libxml_disable_entity_loader(true);
$postObj = simplexml_load_string($postStr, 'SimpleXMLElement');

$hcuDevObj = new class_hcu_IOT_sdk();
//$result = $hcuDevObj->receive_hcu_xmlMessage($postObj);
$result = $hcuDevObj->receive_hcu_zhbMessage($postStr);



$wxObj = new class_wx_IOT_sdk(WX_APPID,WX_APPSECRET);
$result = $wxObj->receive_wx_deviceMessage($postObj);


/*$fromuser = strtoupper("$fromuser");

//$mysqli = new mysqli(WX_DBHOST, WX_DBUSER, WX_DBPSW, WX_DBNAME, WX_DBPORT);
//$result = $mysqli->query("SELECT * FROM `logswitch` WHERE ('appid'='$fromuser')");
//$row = $result->fetch_array();
$value = 122;
$gps = 102030405060;
$user = "oS0Chv3Uum1TZqHaCEb06AoBfCvY";


$db->db_EmcDataInfo_save($user, $deviceid, $timestamp, $value, $gps);

$result = $db->db_LogSwitchInfo_inqury($fromuser);

$result = $db->db_LogSwitchInfo_set($fromuser,0);


$obj = new class_L3_Process_Func();
$s = $obj->L3_emc_data_push_process();

$content = base64_decode($content);
$a = unpack('H*', $content);
$c = strtoupper($a["1"]);

$wxL3Obj = new class_L3_Process_Func();
$result = $wxL3Obj->L3_deviceMsgProcess("device_text", $c, $fromuser, $deviceid);

$result = $wxL3Obj->L3_device_text_process($c,$fromuser, $deviceid);


$result = $wxL3Obj->L3_deviceMsgProcess ("CLICK_READ", "", $fromuser, $deviceid);


$db = new class_mysql_db();
$db->db_LogSwitchInfo_inqury($fromuser);

$db->db_LogSwitchInfo_set($fromuser,1);

$wxL3Obj = new class_L3_Process_Func();

$wxL3Obj = new class_L3_Process_Func();
$result = $wxL3Obj->L3_deviceMsgProcess ("CLICK_EMC_READ", "", $fromuser, $deviceid);


$result = $wxL3Obj->L3_device_text_process($content,$fromuser, $deviceid);


$result = $msgTest->L3_deviceMsgProcess ("CLICK_READ", "", $fromuser, $deviceid);

$result = $db->db_EmcAccumulationInfo_save("aaa", "bbb");


$a = '2015-05-19';
$b = strtotime($a);
$c = date("ymd", $b);

$tmp = 1455629400;
$res = $db->db_EmcDataInfo_save("aaa", "bbb", $tmp, 155, 42433);


$tmp = 1435629400;
$res = $db->db_EmcDataInfo_save("aaa", "bbb", $tmp, 155, 42433);
$res = $db->db_EmcDataInfo_delete_3monold("aaa", "bbb", 80);

$t1 = date("ymd");
$t2 = date_create('2009-10-13');
$olddate = date_diff($t1,$t2);


$t1 = date("ymd");
$t3 = time();
$t2 = idate("m", $t1);
$t4 = idate("m", $t3);
$t5 = date_create($t1);
$t6 = idate("m", $t5->date);

$t1 ="";
$t2 = "00";
$tmp1 = $t1 . substr_replace("00", strtoupper(dechex(14&0xFF)),2,strlen(dechex(14&0xFF)));


$result = $db->db_EmcAccumulationInfo_save("aaa", "bbb");


$tm = intval(substr(date("ymd"),2,2));
$td = intval(substr(date("ymd"),4,2));
$index = $tm*31 + $td;
$index = intval(($index - intval($index/90)*90)/3);

for ($i=0;$i<32;$i++)
{
$daynum [$i] = 0;
$monthnum [$i] = 0;
}

$result = $db->db_EmcAccumulationInfo_inqury("aaa", "bbb");

*/
?>