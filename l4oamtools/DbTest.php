<?php
/**
 * Created by PhpStorm.
 * User: jianlinz
 * Date: 2015/7/3
 * Time: 11:33
 */
include_once "../l1comvm/vmlayer.php";
//require dirname(__FILE__).'/../l1comvm/vmlayer.php';
//include_once "../l2sdk/task_l2sdk_wechat.class.php";
//include_once "../l2sdk/task_l2sdk_iot_hcu.class.php";
//include_once "../l4aqycui/dbi_l4aqyc_ui.class.php";
//$dir = dirname(__FILE__);
//header("Content-type:text/html;charset=utf-8");
//define('ROOT' , pathinfo(__FILE__, PATHINFO_DIRNAME));
//$path = ROOT."/l3appl/fum1sym/dbi_l3apl_f1sym.class.php";
//$path2 = pathinfo(__FILE__, PATHINFO_DIRNAME);
//$path3 = $_SERVER['DOCUMENT_ROOT'];

define ("TC_EMCWX", false);
define ("TC_SOCKET", false);
define ("TC_CRON", false);
define ("TC_IOT_HCU", false);
define ("TC_L4AQYC_UI", true);
define ("TC_NBIOT_CJ188", false);
define ("TC_NBIOT_QG376", false);


/**************************************************************************************
 *                             测试型区域                                             *
 *************************************************************************************/
//$uiDbObj = new classDbiL3apF1sym();
//$result = $uiDbObj->dbi_login_req("admin", "admin");


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

/**************************************************************************************
 *                             WECHAT / EMCWX TEST CASES                              *
 *************************************************************************************/
if (TC_EMCWX == true){
//EMCWX测试开始
    echo " [TC EMCWX: EMC DEVICE_TEXT START]\n";
//$content = pack("H*", "FE01001C71212372010002206500403020101020304050607081800");
    $content = base64_encode(pack("H*", "201000220650040302010102030405060708"));
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[IHU]]></ToUserName><FromUserName><![CDATA[oS0Chv3Uum1TZqHaCEb06AoBfCvY]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[device_text]]></MsgType><Content><![CDATA[" . $content . "]]></Content><FuncFlag>0</FuncFlag></xml>";
    require("../l1mainentry/cloud_callback_wechat.php");
    echo " [TC EMCWX: EMC DEVICE_TEXT END]\n";

    echo " [TC EMCWX: EMC DEVICE_EVENT START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[device_event]]></MsgType><Content><![CDATA[201881050201124945000000004E000000000000000057066DF0]]></Content><FuncFlag>0</FuncFlag></xml>";
    require("../l1mainentry/cloud_callback_wechat.php");
    echo " [TC EMCWX: EMC DEVICE_EVENT END]\n";

//EMCWX测试结束
}

/**************************************************************************************
 *                             SOCKET TEST CASES                              *
 *************************************************************************************/
if (TC_SOCKET == true) {
//SOCKET测试开始
    echo " [TC SOCKET: xxx START]\n";
    if (MFUN_CLOUD_HCU == "TEST_HCU") {
        require("../l1mainentry/cloud_callback_socket_listening.php");
    }
    echo " [TC SOCKET: xxx END]\n";

//SOCKET测试结束
}


/**************************************************************************************
 *                             CRON TEST CASES                                        *
 *************************************************************************************/
if (TC_CRON == true) {
//CRON测试开始
    echo " [TC CRON: DEFAULT START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201124945000000004E000000000000000057066DF0]]></Content><FuncFlag>0</FuncFlag></xml>";
    $argv[1] = 0;
    require("../l1mainentry/cloud_callback_cron.php");
    echo " [TC CRON: DEFAULT END]\n";

    echo " [TC CRON: 1MIN START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201124945000000004E000000000000000057066DF0]]></Content><FuncFlag>0</FuncFlag></xml>";
    $argv[1] = 1;
    require("../l1mainentry/cloud_callback_cron.php");
    echo " [TC CRON: 1MIN END]\n";

    echo " [TC CRON: 3MIN START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201124945000000004E000000000000000057066DF0]]></Content><FuncFlag>0</FuncFlag></xml>";
    $argv[1] = 2;
    require("../l1mainentry/cloud_callback_cron.php");
    echo " [TC CRON: 3MIN END]\n";

    echo " [TC CRON: 10MIN START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201124945000000004E000000000000000057066DF0]]></Content><FuncFlag>0</FuncFlag></xml>";
    $argv[1] = 3;
    require("../l1mainentry/cloud_callback_cron.php");
    echo " [TC CRON: 10MIN END]\n";

    echo " [TC CRON: 30MIN START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201124945000000004E000000000000000057066DF0]]></Content><FuncFlag>0</FuncFlag></xml>";
    $argv[1] = 4;
    require("../l1mainentry/cloud_callback_cron.php");
    echo " [TC CRON: 30MIN END]\n";

    echo " [TC CRON: 1HOUR START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201124945000000004E000000000000000057066DF0]]></Content><FuncFlag>0</FuncFlag></xml>";
    $argv[1] = 5;
    require("../l1mainentry/cloud_callback_cron.php");
    echo " [TC CRON: 1HOUR END]\n";

    echo " [TC CRON: 6HOUR START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201124945000000004E000000000000000057066DF0]]></Content><FuncFlag>0</FuncFlag></xml>";
    $argv[1] = 6;
    require("../l1mainentry/cloud_callback_cron.php");
    echo " [TC CRON: 6HOUR END]\n";

    echo " [TC CRON: 24HOUR START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201124945000000004E000000000000000057066DF0]]></Content><FuncFlag>0</FuncFlag></xml>";
    $argv[1] = 7;
    require("../l1mainentry/cloud_callback_cron.php");
    echo " [TC CRON: 24HOUR END]\n";

    echo " [TC CRON: 2DAY START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201124945000000004E000000000000000057066DF0]]></Content><FuncFlag>0</FuncFlag></xml>";
    $argv[1] = 8;
    require("../l1mainentry/cloud_callback_cron.php");
    echo " [TC CRON: 2DAY END]\n";

    echo " [TC CRON: 7DAY START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201124945000000004E000000000000000057066DF0]]></Content><FuncFlag>0</FuncFlag></xml>";
    $argv[1] = 9;
    require("../l1mainentry/cloud_callback_cron.php");
    echo " [TC CRON: 7DAY END]\n";

    echo " [TC CRON: 30DAY START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201124945000000004E000000000000000057066DF0]]></Content><FuncFlag>0</FuncFlag></xml>";
    $argv[1] = 10;
    require("../l1mainentry/cloud_callback_cron.php");
    echo " [TC CRON: 30DAY END]\n";
//CRON测试结束
}


/**************************************************************************************
 *                             IOT HCU TEST CASES                                     *
 *************************************************************************************/
if (TC_IOT_HCU == true) {
//TEST CASE: IOT_HCU基础数据测试用例集: START
//EMC 20
    echo " [TC IOT_HCU: EMC START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201124945000000004E000000000000000057066DF0]]></Content><FuncFlag>0</FuncFlag></xml>";
//$GLOBALS["HTTP_RAW_POST_DATA"] = $postStr;
//$msg = $GLOBALS["HTTP_RAW_POST_DATA"];
//$obj = new classTaskL1vmCoreRouter();
//$obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_IOT_HCU, MSG_ID_L2SDK_HCU_DATA_COMING, "MSG_ID_L2SDK_HCU_DATA_COMING", $postStr);
    require("../l1mainentry/cloud_callback_hcu.php");
    echo " [TC IOT_HCU: EMC END]\n";
//PM 25
    echo " [TC IOT_HCU: PM25 START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872404</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[252281010201000001120000011200000492000000000000000000000000000056E55E14]]></Content><FuncFlag>0</FuncFlag></xml>";
    require("../l1mainentry/cloud_callback_hcu.php");
    echo " [TC IOT_HCU: PM25 END]\n";
//Wind speed 26
    echo " [TC IOT_HCU: WINDSPD START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1459985808</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[261881020201000045000000004E000000000000000057059D90]]></Content><FuncFlag>0</FuncFlag></xml>";
    require("../l1mainentry/cloud_callback_hcu.php");
    echo " [TC IOT_HCU: WINDSPD END]\n";
//Wind Direction 27
    echo " [TC IOT_HCU: WINDDIR START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1459899126</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[271881030201008D45000000004E000000000000000057044AF5]]></Content><FuncFlag>0</FuncFlag></xml>";
    require("../l1mainentry/cloud_callback_hcu.php");
    echo " [TC IOT_HCU: WINDDIR END]\n";
//Temperature 28
    echo " [TC IOT_HCU: TEMP START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872422</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[2818810602010223000000000000000000000000000056E55E26]]></Content><FuncFlag>0</FuncFlag></xml>";
    require("../l1mainentry/cloud_callback_hcu.php");
    echo " [TC IOT_HCU: TEMP END]\n";
//Humidity 29
    echo " [TC IOT_HCU: HUMID START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872525</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[29188106020100AC000000000000000000000000000056E55E8D]]></Content><FuncFlag>0</FuncFlag></xml>";
    require("../l1mainentry/cloud_callback_hcu.php");
    echo " [TC IOT_HCU: HUMID END]\n";
//Noise 2B
    echo " [TC IOT_HCU: NOISE START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872731</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[2B1A810A02020000028B000000000000000000000000000056E55F5B]]></Content><FuncFlag>0</FuncFlag></xml>";
    require("../l1mainentry/cloud_callback_hcu.php");
    echo " [TC IOT_HCU: NOISE END]\n";
//Heart Beat
    echo " [TC IOT_HCU: HEART BEAT START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872409</CreateTime><MsgType><![CDATA[hcu_heart_beat]]></MsgType><Content><![CDATA[FE00]]></Content><FuncFlag>0</FuncFlag></xml>";
    require("../l1mainentry/cloud_callback_hcu.php");
    echo " [TC IOT_HCU: HEART BEAT END]\n";
//CMD pooling
    echo " [TC IOT_HCU: CMD POOLING START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1457872559</CreateTime><MsgType><![CDATA[hcu_command]]></MsgType><Content><![CDATA[FD00]]></Content><FuncFlag>0</FuncFlag></xml>";
    require("../l1mainentry/cloud_callback_hcu.php");
    echo " [TC IOT_HCU: CMD POOLING END]\n";
//EMC 20
    echo " [TC IOT_HCU: EMC NEW START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0305]]></FromUserName><CreateTime>1463066586</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201130345000000004E000000000000000057318D70]]></Content><FuncFlag>0</FuncFlag></xml>";
    require("../l1mainentry/cloud_callback_hcu.php");
    echo " [TC IOT_HCU: EMC NEW END]\n";
//中环保格式
    echo " [TC IOT_HCU: ZHB FORMAT START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "##007020160619033803000___11111ZHB_NOMHCU_SH_0304_44444405556666a01000=139A,68BE";
    require("../l1mainentry/cloud_callback_hcu.php");
    echo " [TC IOT_HCU: ZHB FORMAT END]\n";
//TEST CASE: 基础数据测试用例集: END


//TEST CASE: 测试图片存储的功能: START
    echo " [TC OTHERS: PICTURE STORAGE START]\n";
    $dbiObj = new classDbiL2snrHsmmp();
    $data = addslashes(fread(fopen("C:\wamp\www\mfunhcu\l4oamtools\qrcode.png", "rb"), filesize("C:\wamp\www\mfunhcu\l4oamtools\qrcode.png")));
    $dbiObj->dbi_picture_data_save(1, 1, 1, $data, 1);
//fclose($data);
//读取操作
    $bindata = $dbiObj->dbi_latestPictureData_inqury(1);
    $myfile = fopen("C:\wamp\www\mfunhcu\l4oamtools\aaapic.png", "w") or die("Unable to open file!");
    fwrite($myfile, $bindata);
    fclose($myfile);
    echo " [TC OTHERS: PICTURE STORAGE END]\n";
//TEST CASE: 测试图片存储的功能：END


//TEST CASE: 全局工程参数中图像的更新: START
    echo " [TC ENGPAR: UPDATE LOG PICTURE FILES START]\n";
    $dbiObj = new classDbiL1vmCommon();
    $data = addslashes(fread(fopen("C:\wamp\www\mfunhcu\l4oamtools\qrcode.png", "rb"), filesize("C:\wamp\www\mfunhcu\l4oamtools\qrcode.png")));
    $project = MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE;
    $filename = json_encode("C:\wamp\www\mfunhcu\l4oamtools\qrcode.png");
    $filetype = "png";
    $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
    $result = $mysqli->query("UPDATE `t_l1vm_engpar` SET `filenamebg` = '$filename', `filetypebg` = '$filetype',`filedatabg` = '$data' WHERE (`project` = '$project')");
    $mysqli->close();
//fclose($data);
    echo " [TC ENGPAR: UPDATE LOG PICTURE FILES END]\n";
//TEST CASE: 全局工程参数中图像的更新：END

}

/**************************************************************************************
 *                             L4AQYC-UI TEST CASES                                   *
 *************************************************************************************/
if (TC_L4AQYC_UI == true) {
    //TEST CASE: L4AQYC-UI界面: START
    echo " [TC L4AQYC: LOGIN START]\n";
    $_GET["action"] = "login";
    $_GET["name"] = "admin";
    $_GET["password"] = "admin";
    require("../l4aqycui/request.php");
//$obj = new classTaskL1vmCoreRouter();
//$obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_AQYC_UI, MSG_ID_L2SDK_HCU_DATA_COMING, "MSG_ID_L2SDK_HCU_DATA_COMING", $_GET["action"]);
    echo " [TC L4AQYC: LOGIN END]\n";

    echo " [TC L4AQYC: USERINFO START]\n";
    $_GET["action"] = "UserInfo";
    $_GET["session"] = 1;
    require("../l4aqycui/request.php");
//$obj = new classTaskL1vmCoreRouter();
//$obj->mfun_l1vm_task_main_entry(MFUN_MAIN_ENTRY_AQYC_UI, MSG_ID_L2SDK_HCU_DATA_COMING, "MSG_ID_L2SDK_HCU_DATA_COMING", $_GET["action"]);
    echo " [TC L4AQYC: USERINFO END]\n";

    echo " [TC L4AQYC: USERNEW START]\n";
    $_GET["action"] = "UserNew";
    $_GET["name"] = "ZZZ";
    $_GET["nickname"] = "ZZZ";
    $_GET["password"] ="zzz";
    $_GET["mobile"] ="zzz";
    $_GET["mail"] ="zzz";
    $_GET["type"] ="aa";
    $_GET["memo"] ="zz";
    $_GET["auth"] ="zz";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: USERNEW END]\n";

    echo " [TC L4AQYC: UserMod START]\n";
    $_GET["action"] = "UserMod";
    $_GET["id"] = "11";
    $_GET["name"] = "ZZZ";
    $_GET["nickname"] = "ZZZ";
    $_GET["password"] ="zzz";
    $_GET["mobile"] ="zzz";
    $_GET["mail"] ="zzz";
    $_GET["type"] ="aa";
    $_GET["memo"] ="zz";
    $_GET["auth"] ="zz";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: UserMod END]\n";

    echo " [TC L4AQYC: UserDel START]\n";
    $_GET["action"] = "UserMod";
    $_GET["id"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: UserDel END]\n";

    echo " [TC L4AQYC: UserTable START]\n";
    $_GET["action"] = "UserTable";
    $_GET["length"] = "11";
    $_GET["startseq"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: UserTable END]\n";

    echo " [TC L4AQYC: HcuSwUpdate START]\n";
    $_GET["action"] = "HcuSwUpdate";
    $_GET["deviceid"] = "11";
    $_GET["projectid"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: HcuSwUpdate END]\n";

    echo " [TC L4AQYC: ProjectPGList START]\n";
    $_GET["action"] = "ProjectPGList";
    $_GET["user"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: ProjectPGList END]\n";

    echo " [TC L4AQYC: ProjectList START]\n";
    $_GET["action"] = "ProjectList";
    $_GET["user"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: ProjectList END]\n";

    echo " [TC L4AQYC: UserProj START]\n";
    $_GET["action"] = "UserProj";
    $_GET["userid"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: UserProj END]\n";

    echo " [TC L4AQYC: PGTable START]\n";
    $_GET["action"] = "PGTable";
    $_GET["length"] = "11";
    $_GET["startseq"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PGTable END]\n";

    echo " [TC L4AQYC: PGNew START]\n";
    $_GET["action"] = "PGNew";
    $_GET["PGCode"] = "11";
    $_GET["PGName"] = "11";
    $_GET["ChargeMan"] = "11";
    $_GET["Telephone"] = "11";
    $_GET["Department"] = "11";
    $_GET["Address"] = "11";
    $_GET["Stage"] = "11";
    $_GET["Projlist"] = "11";
    $_GET["user"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PGNew END]\n";

    echo " [TC L4AQYC: PGMod START]\n";
    $_GET["action"] = "PGMod";
    $_GET["PGCode"] = "11";
    $_GET["PGName"] = "11";
    $_GET["ChargeMan"] = "11";
    $_GET["Telephone"] = "11";
    $_GET["Department"] = "11";
    $_GET["Address"] = "11";
    $_GET["Stage"] = "11";
    $_GET["Projlist"] = "11";
    $_GET["user"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PGMod END]\n";

    echo " [TC L4AQYC: PGDel START]\n";
    $_GET["action"] = "PGDel";
    $_GET["id"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PGDel END]\n";

    echo " [TC L4AQYC: PGProj START]\n";
    $_GET["action"] = "PGProj";
    $_GET["id"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PGProj END]\n";

    echo " [TC L4AQYC: ProjTable START]\n";
    $_GET["action"] = "ProjTable";
    $_GET["length"] = "11";
    $_GET["startseq"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: ProjTable END]\n";

    echo " [TC L4AQYC: ProjNew START]\n";
    $_GET["action"] = "ProjNew";
    $_GET["ProjCode"] = "11";
    $_GET["ProjName"] = "11";
    $_GET["ChargeMan"] = "11";
    $_GET["Telephone"] = "11";
    $_GET["Department"] = "11";
    $_GET["Address"] = "11";
    $_GET["ProStartTime"] = "11";
    $_GET["Stage"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: ProjNew END]\n";

    echo " [TC L4AQYC: ProjMod START]\n";
    $_GET["action"] = "ProjMod";
    $_GET["ProjCode"] = "11";
    $_GET["ProjName"] = "11";
    $_GET["ChargeMan"] = "11";
    $_GET["Telephone"] = "11";
    $_GET["Department"] = "11";
    $_GET["Address"] = "11";
    $_GET["ProStartTime"] = "11";
    $_GET["Stage"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: ProjMod END]\n";

    echo " [TC L4AQYC: ProjDel START]\n";
    $_GET["action"] = "ProjDel";
    $_GET["ProjCode"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: ProjDel END]\n";

    echo " [TC L4AQYC: ProjPoint START]\n";
    $_GET["action"] = "ProjPoint";
    $_GET["user"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: ProjPoint END]\n";

    echo " [TC L4AQYC: PointProj START]\n";
    $_GET["action"] = "PointProj";
    $_GET["ProjCode"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PointProj END]\n";

    echo " [TC L4AQYC: PointTable START]\n";
    $_GET["action"] = "PointTable";
    $_GET["length"] = "11";
    $_GET["startseq"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PointTable END]\n";

    echo " [TC L4AQYC: PointDetail START]\n";
    $_GET["action"] = "PointDetail";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PointDetail END]\n";

    echo " [TC L4AQYC: PointNew START]\n";
    $_GET["action"] = "PointNew";
    $_GET["StatCode"] = "11";
    $_GET["StatName"] = "11";
    $_GET["ProjCode"] = "11";
    $_GET["ChargeMan"] = "11";
    $_GET["Telephone"] = "11";
    $_GET["Longitude"] = "11";
    $_GET["Latitude"] = "11";
    $_GET["Department"] = "11";
    $_GET["Address"] = "11";
    $_GET["Country"] = "11";
    $_GET["Street"] = "11";
    $_GET["Square"] = "11";
    $_GET["ProStartTime"] = "11";
    $_GET["Stage"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PointNew END]\n";

    echo " [TC L4AQYC: PointMod START]\n";
    $_GET["action"] = "PointMod";
    $_GET["StatCode"] = "11";
    $_GET["StatName"] = "11";
    $_GET["ProjCode"] = "11";
    $_GET["ChargeMan"] = "11";
    $_GET["Telephone"] = "11";
    $_GET["Longitude"] = "11";
    $_GET["Latitude"] = "11";
    $_GET["Department"] = "11";
    $_GET["Address"] = "11";
    $_GET["Country"] = "11";
    $_GET["Street"] = "11";
    $_GET["Square"] = "11";
    $_GET["ProStartTime"] = "11";
    $_GET["Stage"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PointMod END]\n";

    echo " [TC L4AQYC: PointDel START]\n";
    $_GET["action"] = "PointDel";
    $_GET["StatCode"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PointDel END]\n";

    echo " [TC L4AQYC: PointDev START]\n";
    $_GET["action"] = "PointDev";
    $_GET["StatCode"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PointDev END]\n";

    echo " [TC L4AQYC: DevTable START]\n";
    $_GET["action"] = "DevTable";
    $_GET["length"] = "11";
    $_GET["startseq"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: DevTable END]\n";

    echo " [TC L4AQYC: DevNew START]\n";
    $_GET["action"] = "DevNew";
    $_GET["DevCode"] = "11";
    $_GET["StatCode"] = "11";
    $_GET["StartTime"] = "11";
    $_GET["PreEndTime"] = "11";
    $_GET["EndTime"] = "11";
    $_GET["DevStatus"] = "11";
    $_GET["VideoURL"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: DevNew END]\n";

    echo " [TC L4AQYC: DevMod START]\n";
    $_GET["action"] = "DevMod";
    $_GET["DevCode"] = "11";
    $_GET["StatCode"] = "11";
    $_GET["StartTime"] = "11";
    $_GET["PreEndTime"] = "11";
    $_GET["EndTime"] = "11";
    $_GET["DevStatus"] = "11";
    $_GET["VideoURL"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: DevMod END]\n";

    echo " [TC L4AQYC: DevDel START]\n";
    $_GET["action"] = "DevDel";
    $_GET["DevCode"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: DevDel END]\n";

    echo " [TC L4AQYC: DevAlarm START]\n";
    $_GET["action"] = "DevAlarm";
    $_GET["StatCode"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: DevAlarm END]\n";

    echo " [TC L4AQYC: DevAlarm START]\n";
    $_GET["action"] = "DevAlarm";
    $_GET["StatCode"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: DevAlarm END]\n";

    echo " [TC L4AQYC: MonitorList START]\n";
    $_GET["action"] = "MonitorList";
    $_GET["id"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: MonitorList END]\n";

    echo " [TC L4AQYC: AlarmQuery START]\n";
    $_GET["action"] = "AlarmQuery";
    $_GET["id"] = "11";
    $_GET["StatCode"] = "11";
    $_GET["date"] = "11";
    $_GET["type"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: AlarmQuery END]\n";

    echo " [TC L4AQYC: AlarmType START]\n";
    $_GET["action"] = "AlarmType";
    $_GET["user"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: AlarmType END]\n";

    echo " [TC L4AQYC: TableQuery START]\n";
    $_GET["action"] = "TableQuery";
    $_GET["TableName"] = 1;
    $_GET["Condition"] = 1;
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: TableQuery END]\n";

    echo " [TC L4AQYC: SensorList START]\n";
    $_GET["action"] = "SensorList";
    $_GET["user"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: SensorList END]\n";

    echo " [TC L4AQYC: DevSensor START]\n";
    $_GET["action"] = "DevSensor";
    $_GET["DevCode"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: DevSensor END]\n";

    echo " [TC L4AQYC: SensorUpdate START]\n";
    $_GET["action"] = "SensorUpdate";
    $_GET["DevCode"] = "11";
    $_GET["SensorCode"] = "11";
    $_GET["status"] = "11";
    $_GET["ParaList"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: SensorUpdate END]\n";

    echo " [TC L4AQYC: SetUserMsg START]\n";
    $_GET["action"] = "SetUserMsg";
    $_GET["id"] = "11";
    $_GET["msg"] = "11";
    $_GET["ifdev"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: SetUserMsg END]\n";

    echo " [TC L4AQYC: GetUserMsg START]\n";
    $_GET["action"] = "GetUserMsg";
    $_GET["id"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: GetUserMsg END]\n";

    echo " [TC L4AQYC: ShowUserMsg START]\n";
    $_GET["action"] = "ShowUserMsg";
    $_GET["id"] = "11";
    $_GET["StatCode"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: ShowUserMsg END]\n";

    echo " [TC L4AQYC: GetUserImg START]\n";
    $_GET["action"] = "GetUserImg";
    $_GET["id"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: GetUserImg END]\n";

    echo " [TC L4AQYC: ClearUserImg START]\n";
    $_GET["action"] = "ClearUserImg";
    $_GET["id"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: ClearUserImg END]\n";

    echo " [TC L4AQYC: GetStaticMonitorTable START]\n";
    $_GET["action"] = "GetStaticMonitorTable";
    $_GET["id"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: GetStaticMonitorTable END]\n";
//TEST CASE: L4AQYC-UI界面: END

}


/**************************************************************************************
 *                             NBIOT IPM/IWM/IGM/IHM @CJ188 TEST CASES                              *
 *************************************************************************************/
if (TC_NBIOT_CJ188 == true){
    //TEST CASE: NBIOT IWM/IPM/IGM/IHM@CJ188: START

    echo " [TC: READ_DATA返回错误帧 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "681011223344556677C1030111223416";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC: READ_DATA返回错误帧 END]\n";

    echo " [TC IWM: READ DATA - 读计量数据 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566778116901F01132333432C142434442C201607150959591122A416";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IWM: READ DATA - 读计量数据 END]\n";

    echo " [TC IGM: READ DATA - 读计量数据 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6830112233445566778116901F01132333432C142434442C201607150959591122A416";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IGM: READ DATA - 读计量数据 END]\n";

    echo " [TC IPM: READ DATA - 读计量数据 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6840112233445566778116901F01132333432C142434442C201607150959591122A416";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IPM: READ DATA - 读计量数据 END]\n";

    echo " [TC IHM: READ DATA - 读计量数据 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "682011223344556677812E901F01132333432C142434442C152535452C162636462C172737472C182838192939102030201607150959591122A316";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IHM: READ DATA - 读计量数据 END]\n";

    echo " [TC IWM: READ DATA - 读历史数据1 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566778108D12001132333432CCA16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IWM: READ DATA - 读历史数据1 END]\n";

    echo " [TC IHM: READ DATA - 读历史数据7 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6820112233445566778108D12601132333432CD016";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IHM: READ DATA - 读历史数据7 END]\n";

    echo " [TC IGM: READ DATA - 读历史数据9 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6830112233445566778108D12801132333432CD216";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IGM: READ DATA - 读历史数据9 END]\n";

    echo " [TC IPM: READ DATA - 读历史数据12 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6840112233445566778108D12B01132333432CD516";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IPM: READ DATA - 读历史数据12 END]\n";

    echo " [TC IWM: READ DATA - 读价格信息 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566778112810201122232132333142434152535162636A016";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IWM: READ DATA - 读价格信息 END]\n";

    echo " [TC IHM: READ DATA - 读价格信息 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6820112233445566778112810201122232132333142434152535162636A016";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IHM: READ DATA - 读价格信息 END]\n";

    echo " [TC IGM: READ DATA - 读价格信息 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6830112233445566778112810201122232132333142434152535162636A016";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IGM: READ DATA - 读价格信息 END]\n";

    echo " [TC IPM: READ DATA - 读价格信息 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6840112233445566778112810201122232132333142434152535162636A016";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IPM: READ DATA - 读价格信息 END]\n";

    echo " [TC IHM: READ DATA - 读结算日 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6820112233445566778104810401119716";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IHM: READ DATA - 读结算日 END]\n";

    echo " [TC IWM: READ DATA - 读抄表日 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566778104810301119616";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IWM: READ DATA - 读抄表日 END]\n";

    echo " [TC IGM: READ DATA - 读购入金额 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "68301122334455667781128105013311213141122232421323334333442916";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IGM: READ DATA - 读购入金额 END]\n";

    echo " [TC IWM: READ DATA - 读购入金额 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "68101122334455667781128105013311213141122232421323334333442916";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IWM: READ DATA - 读购入金额 END]\n";

    echo " [TC IHM: READ DATA - 读购入金额 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "68201122334455667781128105013311213141122232421323334333442916";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IHM: READ DATA - 读购入金额 END]\n";

    echo " [TC IPM: READ DATA - 读购入金额 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "68401122334455667781128105013311213141122232421323334333442916";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IPM: READ DATA - 读购入金额 END]\n";

    echo " [TC IPM: READ DATA - 读秘钥版本号 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6840112233445566778904810601119916";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IPM: READ DATA - 读秘钥版本号 END]\n";

    echo " [TC IWM: READ DATA - 读秘钥版本号 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566778904810601119916";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IWM: READ DATA - 读秘钥版本号 END]\n";

    echo " [TC IHM: READ DATA - 读秘钥版本号 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6820112233445566778904810601119916";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IHM: READ DATA - 读秘钥版本号 END]\n";

    echo " [TC IGM: READ DATA - 读秘钥版本号 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6830112233445566778904810601119916";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IGM: READ DATA - 读秘钥版本号 END]\n";

    echo " [TC IPM: READ DATA - 读地址 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6840112233445566778303810A018C16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IPM: READ DATA - 读地址 END]\n";

    echo " [TC IWM: READ DATA - 读地址 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6810112233445566778303810A018C16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IWM: READ DATA - 读地址 END]\n";

    echo " [TC IHM: READ DATA - 读地址 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6820112233445566778303810A018C16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IHM: READ DATA - 读地址 END]\n";

    echo " [TC IWM: READ DATA - 读地址 START]\n";
    include_once "../l2sdk/dbi_l2sdk_nbiot.class.php";
    $obj = new classDbiL2sdkNbiotStdCj188();
    $obj->dbi_std_cj188_cntser_set_value("11223344556677", 1);
    $GLOBALS["HTTP_RAW_POST_DATA"] = "6830112233445566778303810A018C16";
    require("../l1mainentry/cloud_callback_nbiot_std_cj188.php");
    echo " [TC IWM: READ DATA - 读地址 END]\n";


//TEST CASE: NBIOT IWM/IPM/IGM/IHM@CJ188: END
}



/**************************************************************************************
 *                             NBIOT IPM @QG376 TEST CASES                            *
 *************************************************************************************/
if (TC_NBIOT_QG376 == true){







}










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

//$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
//$msg = file_get_contents('php://input','r');


//libxml_disable_entity_loader(true);
//$postObj = simplexml_load_string($postStr, 'SimpleXMLElement');

//$hcuDevObj = new classTaskL2sdkIotHcu();
//$result = $hcuDevObj->receive_hcu_xmlMessage(null, $postObj);
//$result = $hcuDevObj->receive_hcu_zhbMessage($postStr);

//$wxObj = new classTaskL2sdkIotWx(MFUN_WX_APPID, MFUN_WX_APPSECRET);
//$result = $wxObj->receive_wx_deviceMessage($postObj);


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