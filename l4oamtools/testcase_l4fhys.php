<?php
/**
 * Created by PhpStorm.
 * User: QL
 * Date: 16-10-2
 * Time: 上午10:44
 */

include_once "../l1comvm/vmlayer.php";

/**************************************************************************************
 *                             L4FHYS-UI TEST CASES                                   *
 *************************************************************************************/
if (TC_L4FHYS_UI == true) {

    //BFSC
    echo " [TC L4BFSC: GetStaticMonitorTable START]\n";
    $_GET["action"] = "GetStaticMonitorTable";
    $_GET["id"] = "JCMP24znHk";
    require("../l4bfscui/request.php");
    echo " [TC L4BFSC: GetStaticMonitorTable END]\n";

    //HCU_Lock_open
    echo " [TC L4FHYS: Compel OpenLock START]\n";
    $_GET["action"] = "OpenLock";
    $_GET["id"] = "rcu4SoomAd"; //暂时用admin用户名
    $_GET["StatCode"] = "120101015"; //t_l3f3dm_siteinfo中对应HCU_SH_0301
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: Compel OpenLock END]\n";

    echo " [TC L4FHYS: UserKey START]\n";
    $_GET["action"] = "UserKey";
    $_GET["userid"] = "UID000001";
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: UserKey END]\n";

    echo " [TC L4FHYS: ProjKeyList START]\n";
    $_GET["action"] = "ProjKeyList";
    $_GET["userid"] = "UID000001";
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: ProjKeyList END]\n";

    echo " [TC L4FHYS: ProjKey START]\n";
    $_GET["action"] = "ProjKey";
    $_GET["ProjCode"] = "P_0014";
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: ProjKey END]\n";

    echo " [TC L4FHYS: ProjUserList START]\n";
    $_GET["action"] = "ProjUserList";
    $_GET["id"] = "UID000001";
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: ProjUserList END]\n";

    echo " [TC L4FHYS: KeyTable START]\n";
    $_GET["action"] = "KeyTable";
    $_GET["length"] = "15";
    $_GET["startseq"] = "0";
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: KeyTable END]\n";

    echo " [TC L4FHYS: DomainAuthlist START]\n";
    $_GET["action"] = "DomainAuthlist";
    $_GET["DomainCode"] = "P_0014";
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: DomainAuthlist END]\n";

    echo " [TC L4FHYS: KeyAuthlist START]\n";
    $_GET["action"] = "KeyAuthlist";
    $_GET["KeyId"] = "KEY540970";
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: KeyAuthlist END]\n";

    echo " [TC L4FHYS: KeyAuthNew START]\n";
    $_GET["action"] = "KeyAuthNew";
    $_GET["id"] = "gCuv92Barf";
    $auth = array("DomainId"=>"P_0014", "KeyId"=>"KEY278347", "Authway" =>"2016-12-01");
    $_GET["Auth"] = $auth;
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: KeyAuthNew END]\n";

    echo " [TC L4FHYS: GetStaticMonitorTable START]\n";
    $_GET["action"] = "GetStaticMonitorTable";
    $_GET["id"] = "gCuv92Barf";
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: GetStaticMonitorTable END]\n";

    echo " [TC L4FHYS: KeyHistory START]\n";
    $_GET["action"] = "KeyHistory";
    $_GET["id"] = "gCuv92Barf";
    $condition = array("ProjCode"=>"P_0015", "Time"=>"7");
    $_GET["condition"] = $condition;
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: KeyHistory END]\n";

    //HCU_Lock_Status
    echo " [TC L4FHYS: HCU_Lock_Status START]\n";
    $_GET["action"] = "HCU_Lock_Status";
    $_GET["id"] = "admin"; //暂时用admin用户名
    $_GET["StatCode"] = "120101001"; //t_l3f3dm_siteinfo中对应HCU_SH_0301
    //require("../l4fhysui/request.php");
    echo " [TC L4FHYS: HCU_Lock_Status END]\n";

}