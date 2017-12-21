<?php
/**
 * Created by PhpStorm.
 * User: QL
 * Date: 2016/10/15
 * Time: 14:57
 */

include_once "../l1comvm/vmlayer.php";

/**************************************************************************************
 *                             L4TBSWR-UI TEST CASES                                   *
 *************************************************************************************/
if (TC_L4FAAM_UI == true) {
    $sessionid = "DuRXqyCZun";
    $uerid = "UID000001";

    echo " [TC L4FAAM: AssembleHistory START]\n";
    $_GET["action"] = "AssembleHistory";
    $_GET["user"] = $sessionid;
    $body = array("Time"=>"7", "KeyWord"=>"172");
    $_GET["body"] = $body;
    require("../l4faamui/request.php");
    echo " [TC L4FAAM: AssembleHistory END]\n";

    echo " [TC L4FAAM: AttendanceHistory START]\n";
    $_GET["action"] = "AttendanceHistory";
    $_GET["user"] = $sessionid;
    $body = array("Time"=>"1", "KeyWord"=>"");
    $_GET["body"] = $body;
    require("../l4faamui/request.php");
    echo " [TC L4FAAM: AttendanceHistory END]\n";

    echo " [TC L4FAAM: StaffTable START]\n";
    $_GET["action"] = "StaffTable";
    $_GET["user"] = $sessionid;
    require("../l4faamui/request.php");
    echo " [TC L4FAAM: StaffTable END]\n";

    echo " [TC L4FAAM: StaffDel START]\n";
    $_GET["action"] = "StaffDel";
    $_GET["user"] = $sessionid;
    require("../l4faamui/request.php");
    echo " [TC L4FAAM: StaffDel END]\n";

}




?>