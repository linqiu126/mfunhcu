<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/5
 * Time: 19:15
 */

include_once "../l1comvm/vmlayer.php";

/**************************************************************************************
 *                             L4FHYS-UI TEST CASES                                   *
 *************************************************************************************/
if (TC_L4BFSC_UI == true) {

    //BFSC
    echo " [TC L4BFSC: GetStaticMonitorTable START]\n";
    $_GET["action"] = "GetStaticMonitorTable";
    $_GET["id"] = "JCMP24znHk";
    require("../l4bfscui/request.php");
    echo " [TC L4BFSC: GetStaticMonitorTable END]\n";

    //HCU_Lock_open
    echo " [TC L4FHYS: Compel OpenLock START]\n";
    $_GET["action"] = "StartScale";
    $_GET["user"] = "rcu4SoomAd"; //暂时用admin用户名
    $body = array("StatCode"=>"120101015");
    $_GET["body"] = $body;
    //require("../l4bfscui/request.php");
    echo " [TC L4FHYS: Compel OpenLock END]\n";

    echo " [TC L4FHYS: Compel OpenLock START]\n";
    $_GET["action"] = "StopScale";
    $_GET["user"] = "rcu4SoomAd"; //暂时用admin用户名
    $body = array("StatCode"=>"120101015");
    $_GET["body"] = $body;
    require("../l4bfscui/request.php");
    echo " [TC L4FHYS: Compel OpenLock END]\n";
}