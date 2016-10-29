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

    echo " [TC L4FHYS: DevTable START]\n";
    $_GET["action"] = "DevTable";
    $_GET["length"] = "5";
    $_GET["startseq"] = "1";
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: DevTable END]\n";

    echo " [TC L4FHYS: GetCameraStatus START]\n";
    $_GET["action"] = "GetCameraStatus";
    $_GET["id"] = "admin"; //暂时用admin用户名
    $_GET["StatCode"] = "120101001"; //t_l3f3dm_siteinfo中对应HCU_SH_0301
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: GetCameraStatus END]\n";

    //HCU_Lock_Status
    echo " [TC L4FHYS: HCU_Lock_Status START]\n";
    $_GET["action"] = "HCU_Lock_Status";
    $_GET["id"] = "admin"; //暂时用admin用户名
    $_GET["StatCode"] = "120101001"; //t_l3f3dm_siteinfo中对应HCU_SH_0301
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: HCU_Lock_Status END]\n";

    //HCU_Lock_open
    echo " [TC L4FHYS: HCU_Lock_open START]\n";
    $_GET["action"] = "HCU_Lock_open";
    $_GET["id"] = "admin"; //暂时用admin用户名
    $_GET["StatCode"] = "120101001"; //t_l3f3dm_siteinfo中对应HCU_SH_0301
    require("../l4fhysui/request.php");
    echo " [TC L4FHYS: HCU_Lock_open END]\n";
}