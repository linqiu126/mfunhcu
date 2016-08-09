<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/7/17
 * Time: 23:47
 */
include_once "../l1comvm/vmlayer.php";

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
//视频HSMMP 2C
    echo " [TC IOT_HCU: MFUN_HCU_OPT_VEDIOFILE_RESP START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1463066586</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[2C03820301]]></Content><FuncFlag>HCU_SH_0302_av201607201111.h264.mp4</FuncFlag></xml>";
    require("../l1mainentry/cloud_callback_hcu.php");
    echo " [TC IOT_HCU: MFUN_HCU_OPT_VEDIOFILE_RESP]\n";

    echo " [TC IOT_HCU: MFUN_HCU_OPT_VEDIOLINK_RESP START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1463066586</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[2C15810B0245000000004E000000000000000057318D70]]></Content><FuncFlag>HCU_SH_0302_av201607201122.h264.mp4</FuncFlag></xml>";
    require("../l1mainentry/cloud_callback_hcu.php");
    echo " [TC IOT_HCU: MFUN_HCU_OPT_VEDIOLINK_RESP]\n";

//中环保格式
    echo " [TC IOT_HCU: ZHB FORMAT START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "##007020160619033803000___11111ZHB_NOMHCU_SH_0304_44444405556666a01000=139A,68BE";
    require("../l1mainentry/cloud_callback_hcu.php");
    echo " [TC IOT_HCU: ZHB FORMAT END]\n";
//TEST CASE: 基础数据测试用例集: END


//TEST CASE: 测试图片存储的功能: START
    echo " [TC OTHERS: PICTURE STORAGE START]\n";
    $dbiObj = new classDbiL2snrHsmmp();
    $data = addslashes(fread(fopen("C:\wamp\www\xhzn\mfunhcu\l4oamtools\qrcode.png", "rb"), filesize("C:\wamp\www\xhzn\mfunhcu\l4oamtools\qrcode.png")));
    $dbiObj->dbi_picture_data_save(1, 1, 1, $data, 1);
//fclose($data);
//读取操作
    $bindata = $dbiObj->dbi_latestPictureData_inqury(1);
    $myfile = fopen("C:\wamp\www\xhzn\mfunhcu\l4oamtools\aaapic.png", "w") or die("Unable to open file!");
    fwrite($myfile, $bindata);
    fclose($myfile);
    echo " [TC OTHERS: PICTURE STORAGE END]\n";
//TEST CASE: 测试图片存储的功能：END


//TEST CASE: 全局工程参数中图像的更新: START
    echo " [TC ENGPAR: UPDATE LOG PICTURE FILES START]\n";
    $dbiObj = new classDbiL1vmCommon();
    $data = addslashes(fread(fopen("C:\wamp\www\xhzn\mfunhcu\l4oamtools\qrcode.png", "rb"), filesize("C:\wamp\www\xhzn\mfunhcu\l4oamtools\qrcode.png")));
    $project = MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE;
    $filename = json_encode("C:\wamp\www\xhzn\mfunhcu\l4oamtools\qrcode.png");
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
    $_GET["length"] = "5";
    $_GET["startseq"] = "1";
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
    $_GET["user"] = "UID001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: ProjectPGList END]\n";

    echo " [TC L4AQYC: ProjectList START]\n";
    $_GET["action"] = "ProjectList";
    $_GET["user"] = "UID001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: ProjectList END]\n";

    echo " [TC L4AQYC: UserProj START]\n";
    $_GET["action"] = "UserProj";
    $_GET["userid"] = "UID001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: UserProj END]\n";

    echo " [TC L4AQYC: PGTable START]\n";
    $_GET["action"] = "PGTable";
    $_GET["length"] = "5";
    $_GET["startseq"] = "1";
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
    $_GET["id"] = "PG_1111";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PGProj END]\n";

    echo " [TC L4AQYC: ProjTable START]\n";
    $_GET["action"] = "ProjTable";
    $_GET["length"] = "5";
    $_GET["startseq"] = "1";
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
    $_GET["user"] = "UID001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: ProjPoint END]\n";

    echo " [TC L4AQYC: PointProj START]\n";
    $_GET["action"] = "PointProj";
    $_GET["ProjCode"] = "P_0001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PointProj END]\n";

    echo " [TC L4AQYC: PointTable START]\n";
    $_GET["action"] = "PointTable";
    $_GET["length"] = "5";
    $_GET["startseq"] = "1";
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
    $_GET["StatCode"] = "120101001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: PointDev END]\n";

    echo " [TC L4AQYC: DevTable START]\n";
    $_GET["action"] = "DevTable";
    $_GET["length"] = "5";
    $_GET["startseq"] = "1";
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
    $_GET["StatCode"] = "120101001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: DevAlarm END]\n";

    echo " [TC L4AQYC: DevAlarm START]\n";
    $_GET["action"] = "DevAlarm";
    $_GET["StatCode"] = "120101001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: DevAlarm END]\n";

    echo " [TC L4AQYC: MonitorList START]\n";
    $_GET["action"] = "MonitorList";
    $_GET["id"] = "UID001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: MonitorList END]\n";

    echo " [TC L4AQYC: AlarmQuery START]\n";
    $_GET["action"] = "AlarmQuery";
    $_GET["id"] = "UID001";
    $_GET["StatCode"] = "120101001";
    $_GET["date"] = "11";
    $_GET["type"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: AlarmQuery END]\n";

    echo " [TC L4AQYC: AlarmType START]\n";
    $_GET["action"] = "AlarmType";
    $_GET["user"] = "UID001";
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
    $_GET["user"] = "UID001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: SensorList END]\n";

    echo " [TC L4AQYC: DevSensor START]\n";
    $_GET["action"] = "DevSensor";
    $_GET["DevCode"] = "HCU_SH_0301";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: DevSensor END]\n";

    echo " [TC L4AQYC: SensorUpdate START]\n";
    $_GET["action"] = "SensorUpdate";
    $_GET["DevCode"] = "HCU_SH_0301";
    $_GET["SensorCode"] = "S_0001";
    $_GET["status"] = "true";
    $para_list = array();
    $temp = array(
        'name'=>"MODBUS_Addr",
        'memo'=>"MODBUS地址",
        'value'=>0x05);
    array_push($para_list, $temp);
    $_GET["ParaList"] = $para_list;
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
    $_GET["id"] = "UID001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: GetStaticMonitorTable END]\n";

    echo " [TC L4AQYC: GetVideoList START]\n";
    $_GET["action"] = "GetVideoList";
    $_GET["id"] = "UID001";
    $_GET["StatCode"] = "120101001";
    $_GET["date"] = "2016-04-16";
    $_GET["hour"] = "11";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: GetVideoList END]\n";

    echo " [TC L4AQYC: GetVideo START]\n";
    $_GET["action"] = "GetVideo";
    $_GET["id"] = "HCU_SH_0301_av201607201122.h264.mp4";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: GetVideo END]\n";

    echo " [TC L4AQYC: GetVersionList START]\n";
    $_GET["action"] = "GetVersionList";
    $_GET["id"] = "UID001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: GetVersionList END]\n";

    echo " [TC L4AQYC: GetProjDevVersion START]\n";
    $_GET["action"] = "GetProjDevVersion";
    $_GET["id"] = "UID001";
    $_GET["ProjCode"] = "P_0001";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: GetProjDevVersion END]\n";

    echo " [TC L4AQYC: UpdateDevVersion START]\n";
    $_GET["action"] = "UpdateDevVersion";
    $_GET["id"] = "UID001";
        $dev1 = "HCU_SH_0301";
        $dev2 = "HCU_SH_0314";
        $list = array();
        array_push($list, $dev1); array_push($list, $dev2);
    $_GET["list"] = $list;
    $_GET["version"] = "SW_R01.D0066";
    require("../l4aqycui/request.php");
    echo " [TC L4AQYC: UpdateDevVersion END]\n";

//TEST CASE: L4AQYC-UI界面: END

}




?>