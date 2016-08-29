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
define ("TC_NBIOT_CJ188_UL", false);
define ("TC_NBIOT_CJ188_DL", false);
define ("TC_NBIOT_QG376", false);

require("testcase_nbiot188.php");
require("testcase_l4aqyc.php");
require("testcase_wxemc.php");
require("testcase_hcuiot.php");
require("testcase_l2cron.php");
require("testcase_l2socket.php");


/**************************************************************************************
 *                             NBIOT IPM @QG376 TEST CASES                            *
 *************************************************************************************/
if (TC_NBIOT_QG376 == true){
    //TEST CASE: NBIOT IPM @QG376: START

    //TEST CASE: NBIOT IPM @QG376: END
}


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








?>