<?php
/**
 * Created by PhpStorm.
 * User: zehongl
 * Date: 2016/8/27
 * Time: 11:33
 */

include_once "../l1comvm/vmlayer.php";

/**************************************************************************************
 *                             IOT HCU TEST CASES                                     *
 *************************************************************************************/
if (TC_IOT_HCU == true) {
//TEST CASE: IOT_HCU基础数据测试用例集: START

//HCU Inventory Data
    echo " [TC IOT_HCU: Inventory Data START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0305]]></FromUserName><CreateTime>1483765031</CreateTime><MsgType><![CDATA[hcu_command]]></MsgType><Content><![CDATA[A01B810242383A32373A45423A37323A30453A39430200030100880088]]></Content><FuncFlag>0</FuncFlag></xml>";
    require("../l1mainentry/cloud_callback_hcu.php");
    echo " [TC IOT_HCU: Inventory Data END]\n";

//Alarm Data
    echo " [TC IOT_HCU: Alarm Data START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0305]]></FromUserName><CreateTime>1483764977</CreateTime><MsgType><![CDATA[hcu_alarm]]></MsgType><Content><![CDATA[B00B81410100010006587074F1]]></Content><FuncFlag>0</FuncFlag></xml>";
    require("../l1mainentry/cloud_callback_hcu.php");
    echo " [TC IOT_HCU: Alarm Data END]\n";

//Performance Statistcis
    echo " [TC IOT_HCU: Performance Statistics START]\n";
    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[XHZN_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0305]]></FromUserName><CreateTime>1483588568</CreateTime><MsgType><![CDATA[hcu_pm]]></MsgType><Content><![CDATA[B110810200010000000000000000000000000000586DC3D8]]></Content><FuncFlag>0</FuncFlag></xml>";
    require("../l1mainentry/cloud_callback_hcu.php");
    echo " [TC IOT_HCU: Performance Statistics END]\n";

//EMC 20
    echo " [TC IOT_HCU: EMC START]\n";

    $GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0302]]></FromUserName><CreateTime>1460039152</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[201881050201124945000000004E000000000000000057066DF0]]></Content><FuncFlag>0</FuncFlag></xml>";
    //$GLOBALS["HTTP_RAW_POST_DATA"] = "<xml><ToUserName><![CDATA[AQ_HCU]]></ToUserName><FromUserName><![CDATA[HCU_SH_0301]]></FromUserName><CreateTime>1477323704</CreateTime><MsgType><![CDATA[hcu_text]]></MsgType><Content><![CDATA[400183]]></Content><FuncFlag>0</FuncFlag></xml>";
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
    $data = addslashes(fread(fopen("C:\wamp\www\mfunhcu\l4oamtools\xhzn.png", "rb"), filesize("C:\wamp\www\mfunhcu\l4oamtools\xhzn.png")));
    $dbiObj->dbi_picture_data_save(1, 1, 1, $data, 1);
//fclose($data);
//读取操作
    $bindata = $dbiObj->dbi_latestPictureData_inqury(1);
    $myfile = fopen("C:\wamp\www\mfunhcu\l4oamtools\xhzn.png", "w") or die("Unable to open file!");
    fwrite($myfile, $bindata);
    fclose($myfile);
    echo " [TC OTHERS: PICTURE STORAGE END]\n";
//TEST CASE: 测试图片存储的功能：END


//TEST CASE: 全局工程参数中图像的更新: START
    echo " [TC ENGPAR: UPDATE LOG PICTURE FILES START]\n";
    $dbiObj = new classDbiL1vmCommon();
    $data = addslashes(fread(fopen("C:\wamp\www\mfunhcu\l4oamtools\xhzn.png", "rb"), filesize("C:\wamp\www\mfunhcu\l4oamtools\xhzn.png")));
    $project = MFUN_CURRENT_WORKING_PROGRAM_NAME_UNIQUE;
    $filename = json_encode("C:\wamp\www\mfunhcu\l4oamtools\xhzn.png");
    $filetype = "png";
    $mysqli = new mysqli(MFUN_CLOUD_DBHOST, MFUN_CLOUD_DBUSER, MFUN_CLOUD_DBPSW, MFUN_CLOUD_DBNAME_L1L2L3, MFUN_CLOUD_DBPORT);
    $result = $mysqli->query("UPDATE `t_l1vm_engpar` SET `filenamebg` = '$filename', `filetypebg` = '$filetype',`filedatabg` = '$data' WHERE (`project` = '$project')");
    $mysqli->close();
//fclose($data);
    echo " [TC ENGPAR: UPDATE LOG PICTURE FILES END]\n";
//TEST CASE: 全局工程参数中图像的更新：END

}

